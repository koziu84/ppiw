<?php
/*
* tax-ff.php for taxAndDiscount plugin
* Wizzud : 01/02/06
*/
if( !function_exists( 'dbScanTheBasket' ) ){
  /**
  * Tally the number of products, the number of items, and the total value of the items in the basket for an order
  * @return array false if basket empty
  * @param int  $iOrder
  */
  function dbScanTheBasket( $iOrder ){
    $aFile =  file( DB_ORDERS_PRODUCTS );
    $iCount = count( $aFile );
    $aRtn = array('products'=>0, 'items'=>0, 'value'=>0);
    $bFound = false;
    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( $aExp[1] == $iOrder ){
        $bFound = true;
        $aRtn['products']++;
        $aRtn['items'] += (int)$aExp[3]; // quantity
        $aRtn['value'] += (int)$aExp[3] * (float)$aExp[4]; // quantity * price
      }
    }
    unset($aFile, $aExp);
    return ($bFound ? $aRtn : $bFound);
  } // end function dbScanTheBasket
}

if( !function_exists( 'dbListCountries' ) ){
  function dbListCountries( ){
    return $GLOBALS['oFF']->throwFileArray( DB_COUNTRIES, 'sort' );
  } // end function dbListCountries
}
?>
