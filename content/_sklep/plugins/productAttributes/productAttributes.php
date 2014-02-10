<?php
/**
* productAttributes.php
* Wizzud 31/01/06 Product-Attributes
*/

@include_once (DIR_PLUGINS.'productAttributes/lang-en.php'); // default
@include_once (DIR_PLUGINS."productAttributes/lang-{$config['language']}.php");
@include_once (DIR_PLUGINS.'productAttributes/config.php');

/**
* Replacements for orders.php functions ...
*/
if( !function_exists( 'listBasket' ) ){
  /**
  * Generate basket list. Modified to retrieve extra field and then expand field into attributes
  * @return string
  * @param int    $iOrder
  * @param string $sFile
  */
  function listBasket( $iOrder, $sFile = 'orders_basket.tpl' ){
    global $tpl, $oAttributes, $aList, $sBlockPage; // added 1 gobal

    $aData      = dbListBasket( $iOrder );

    if( isset( $aData ) ){
      $iCount   = count( $aData );
      $fSummary = 0;
      $content  = null;

      for( $i = 0; $i < $iCount; $i++ ){
//        list( $aList['iElement'], $aList['iOrder'], $aList['iProduct'], $aList['iQuantity'], $aList['fPrice'], $aList['sProduct'] ) = $aData[$i];
        list( $aList['iElement'], $aList['iOrder'], $aList['iProduct'], $aList['iQuantity'], $aList['fPrice'], $aList['sProduct'], $sAttributes ) = $aData[$i];

        $aList['sAttributes'] = $oAttributes->throwBasketAttributes( $sAttributes ); // inserted

        if( $i % 2 )
          $aList['iStyle'] = 0;
        else
          $aList['iStyle'] = 1;

        $aList['fSummary']  = tPrice( $aList['iQuantity'] * $aList['fPrice'] );

        $fSummary +=  $aList['fSummary'];
        if($sFile == 'orders_delivery.tpl')
          $content  .= $tpl->tbHtml( $oAttributes->getTemplate(), 'BASKET_LIST_LIST_DELIVERY' ); // use productAttributes template
        else
          $content  .= $tpl->tbHtml( $oAttributes->getTemplate(), 'BASKET_LIST_LIST'.$sBlockPage ); // use productAttributes template
      } // end for

      $aList['fSummary'] = tPrice( $fSummary );

      return $tpl->tbHtml( $sFile, 'LIST_HEAD' ).$content.$tpl->tbHtml( $sFile, 'LIST_FOOTER' );
    }
    else
      return $tpl->tbHtml( $sFile, 'NOT_FOUND' );
  } // end function listBasket
}

/**
* Replacements for orders-ff.php functions ...
*/
if( !function_exists( 'dbCheckOrderProduct' ) ){
  /**
  * Check exist product in basket : Modified to check for matching attributes
  * @return bool
  * @param int  $iOrder
  $ @param int  $iProduct
  */
  function dbCheckOrderProduct( $iOrder, $iProduct ){
    global $sCommaDelimAttributes; // inserted
    $aFile =  file( DB_ORDERS_PRODUCTS );
    $iCount = count( $aFile );
    for( $i = 1; $i < $iCount; $i++ ){
      $aFile[$i]  = rtrim( $aFile[$i] );
      $aExp = explode( '$', $aFile[$i] );
//      if( $aExp[1] == $iOrder && $aExp[2] == $iProduct ){
      array_pop( $aExp ); // inserted
      // attributes are last field in basket record ...
      if( $aExp[1] == $iOrder && $aExp[2] == $iProduct && $aExp[(count($aExp)-1)] == $sCommaDelimAttributes ){
        return $aExp;
      }
    }
    return null;
  } // end function dbCheckOrderProduct
}

if( !function_exists( 'dbAddOrderProduct' ) ){
  /**
  * Add product to basket : Modified to save adjusted price and list of attributes
  * @return void
  * @param array  $aProduct
  * @param int    $iQuantity
  * @param int    $iOrder
  */
  function dbAddOrderProduct( $aProduct, $iQuantity, $iOrder ){
    global $oFF, $oAttributes, $sCommaDelimAttributes; // added 2 more globals
    $iElement = throwLastId( DB_ORDERS_PRODUCTS, 0 ) + 1;
    $prodPrice = $oAttributes->getActualPrice($aProduct['iProduct'], $aProduct['fPrice'], $sCommaDelimAttributes);
//    $oFF->setRow( Array( $iElement, $iOrder, $aProduct['iProduct'], $iQuantity, $aProduct['fPrice'], $aProduct['sName'] ) );
    // changed product price and appended attributes ...
    $oFF->setRow( Array( $iElement, $iOrder, $aProduct['iProduct'], $iQuantity, $prodPrice, $aProduct['sName'], $sCommaDelimAttributes ) );
    $oFF->addToFile( DB_ORDERS_PRODUCTS, 'end' );
  } // end function dbAddOrderProduct
}

if( !function_exists( 'dbSaveOrderProduct' ) ){
  /**
  * Save product to file : Modified to save all data fields, including attributes
  * @return void
  * @param array  $aData
  */
  function dbSaveOrderProduct( $aData ){
    global $oFF;
//    $oFF->setRow( Array( $aData[0], $aData[1], $aData[2], $aData[3], $aData[4], $aData[5] ) );
    $oFF->setRow( $aData ); // inserted
    $oFF->changeInFile( DB_ORDERS_PRODUCTS, $aData[0], 0 );
  } // end function dbSaveOrderProduct
}

if( !function_exists( 'dbSaveOrderProducts' ) ){
  /**
  * Save products quantity to file : Modified to handle extra attributes field
  * @return void
  * @param array  $aElements
  */
  function dbSaveOrderProducts( $aElements ){
    $aFile  = file( DB_ORDERS_PRODUCTS );
    $rFile  = fopen( DB_ORDERS_PRODUCTS, 'w' );
    $iCount = count( $aFile );

    for( $i = 0; $i < $iCount; $i++ ){
      if( $i > 0 ){
        $aFile[$i]  = rtrim( $aFile[$i] );
        $aExp = explode( '$', $aFile[$i] );
        array_pop( $aExp ); // inserted
        if( isset( $aElements[$aExp[0]] ) && $aElements[$aExp[0]] >= 1 ){
//          $aFile[$i] = $aExp[0].'$'.$aExp[1].'$'.$aExp[2].'$'.sprintf( '%01.0f', $aElements[$aExp[0]] ).'$'.$aExp[4].'$'.$aExp[5].'$'."\n";
          $aExp[3] = sprintf( '%01.0f', $aElements[$aExp[0]] ); // inserted
          $aFile[$i] = implode('$', $aExp) . '$' . "\n"; // inserted
        }else{
          $aFile[$i] .= "\n";
        }
      }

      fwrite( $rFile, $aFile[$i] );
    } // end for

    fclose( $rFile );
  } // end function dbSaveOrderProducts
}
?>
