<?php
if( !function_exists( 'throwOrderIdTemp' ) ){
  /**
  * Return temporary order id
  * @return int
  * @param int    $iClient
  * @param string $sOption
  */
  function throwOrderIdTemp( $iClient, $sOption = 'add' ){
    return dbThrowOrderIdTemp( $iClient, $sOption );
  } // end function throwOrderIdTemp
}

if( !function_exists( 'throwOrder' ) ){
  /**
  * Return order data
  * @return array
  * @param int  $iOrder
  */
  function throwOrder( $iOrder ){
    $aData = dbThrowOrder( $iOrder );
    $aList = dbThrowOrderExt( $iOrder );

    if( isset( $aData ) && is_array( $aData ) && isset( $aList ) && is_array( $aList ) ){
      list( , $aList['iTime'], $aList['iCourier'], $aList['sCourier'], $aList['fCourierPrice'], $aList['sFirstName'], $aList['sLastName'], $aList['sCompanyName'], /*Modyfied by Wieslaw Klimiuk (22.03.2006)*/ $aList['sNIP'], /*Modyfied by Wieslaw Klimiuk (22.03.2006)*/ $aList['sStreet'], $aList['sZipCode'], $aList['sCity'], $aList['sTelephone'], $aList['sEmail'], $aList['sIp'], $aList['sComment'] ) = $aList;
      list( $aList['iOrder'], $aList['iClient'], $aList['iStatus'] ) = $aData;
      
      $aList          = changeMassTxt( $aList, '' );
      $aList['sDate'] = date( 'Y-m-d H:i:s', $aList['iTime'] );

      return $aList;
    }
  } // end function throwOrder
}

if( !function_exists( 'checkOrderProducts' ) ){
  /**
  * Return true if products are defined to order
  * @return void
  * @param int  $iOrder
  */
  function checkOrderProducts( $iOrder ){
    return dbCheckOrderProducts( $iOrder );
  } // end function checkOrderProducts
}

if( !function_exists( 'addOrderProduct' ) ){
  /**
  * Add product to basket
  * @return void
  * @param int  $iProduct
  * @param int  $iQuantity
  * @param int  $iOrder
  */
  function addOrderProduct( $iProduct, $iQuantity, $iOrder ){
    $aData = throwProduct( $iProduct );
    if( isset( $aData ) ){
      $aBasket  = dbCheckOrderProduct( $iOrder, $iProduct );
      if( isset( $aBasket ) && is_array( $aBasket ) ){
        $aBasket[3] += $iQuantity;
        dbSaveOrderProduct( $aBasket );
      }
      else{
        dbAddOrderProduct( $aData, $iQuantity, $iOrder );
      }
    }
  } // end function addOrderProduct
}

if( !function_exists( 'saveOrderProduct' ) ){
  /**
  * Save product quantity
  * @return void
  * @param array  $aForm
  */
  function saveOrderProducts( $aForm ){
    dbSaveOrderProducts( $aForm['aElements'] );
  } // end function saveOrderProducts
}

if( !function_exists( 'delOrderElement' ) ){
  /**
  * Delete product in basket
  * @return void
  * @param int  $iOrder
  * @param int  $iElement
  */
  function delOrderElement( $iOrder, $iElement = null ){
    dbDelOrderElement( $iOrder, $iElement );
  } // end function delOrderElement
}

if( !function_exists( 'delOrder' ) ){
  /**
  * Del order
  * @return void
  * @param int  $iOrder
  */
  function delOrder( $iOrder ){
    dbDelOrder( $iOrder );
    delOrderElement( $iOrder );
  } // end function delOrder
}

if( !function_exists( 'listBasket' ) ){
  /**
  * Generate basket list
  * @return string
  * @param int    $iOrder
  * @param string $sFile
  */
  function listBasket( $iOrder, $sFile = 'orders_basket.tpl' ){
    global $tpl, $aList;
    
    $aData      = dbListBasket( $iOrder );

    if( isset( $aData ) ){
      $iCount   = count( $aData );
      $fSummary = 0;
      $content  = null;

      for( $i = 0; $i < $iCount; $i++ ){
        list( $aList['iElement'], $aList['iOrder'], $aList['iProduct'], $aList['iQuantity'], $aList['fPrice'], $aList['sProduct'] ) = $aData[$i];
        
        if( $i % 2 )
          $aList['iStyle'] = 0;
        else
          $aList['iStyle'] = 1;

        $aList['fSummary']  = tPrice( $aList['iQuantity'] * $aList['fPrice'] );

        $fSummary +=  $aList['fSummary'];
        $content  .= $tpl->tbHtml( $sFile, 'LIST_LIST' );
      } // end for

      $aList['fSummary'] = tPrice( $fSummary );

      return $tpl->tbHtml( $sFile, 'LIST_HEAD' ).$content.$tpl->tbHtml( $sFile, 'LIST_FOOTER' );
    }
    else
      return $tpl->tbHtml( $sFile, 'NOT_FOUND' );
  } // end function listBasket
}

if( !function_exists( 'saveOrder' ) ){
  /**
  * Save order
  * @return void
  * @param int    $iOrder
  * @param array  $aForm
  */
  function saveOrder( $iOrder, $aForm ){

    $aForm =    changeMassTxt( $aForm, '', Array( 'sComment', 'lenH' ) );

    if( throwStrLen( $aForm['sComment'] ) < 2 )
      $aForm['sComment'] = null;
    elseif( throwStrLen( $aForm['sComment'] ) > 500 )
      $aForm['sComment'] = substr( $aForm['sComment'], 0, 500 ).'...';

    if( isset( $aForm['iCourier'] ) ){
      $aCourier = explode( '|', $aForm['iCourier'] );
      $aForm['iCourier'] = $aCourier[0];
    }
    else
      $aForm['iCourier'] = null;

    $aForm['iOrder']  = $iOrder;
    $aCourier         = throwCourier( $aForm['iCourier'] );

    dbSaveOrder( $aForm );
    dbAddOrderExtensions( Array( $aForm['iOrder'], time( ), $aForm['iCourier'], $aCourier['sName'], $aCourier['fPrice'], $aForm['sFirstName'], $aForm['sLastName'], $aForm['sCompanyName'], /*Modyfied by Wieslaw Klimiuk (22.03.2006)*/ $aForm['sNIP'], /*Modyfied by Wieslaw Klimiuk (22.03.2006)*/ $aForm['sStreet'], $aForm['sZipCode'], $aForm['sCity'], $aForm['sTelephone'], $aForm['sEmail'], $_SERVER['REMOTE_ADDR'], $aForm['sComment'] ) );

    if( $GLOBALS['config']['mail_informing'] === true )
      @mail( EMAIL, $GLOBALS['lang']['mail_title'], $GLOBALS['lang']['mail_txt'], 'FROM: '.EMAIL );
  } // end function saveOrder
}

if( !function_exists( 'checkOrderFields' ) ){
  /**
  * Check order fields
  * @return bool
  * @param array  $aForm
  */
  function checkOrderFields( $aForm ){
    if(
      checkLength( $aForm['sFirstName'], 0 )
      && checkLength( $aForm['sLastName'], 0 )
      && checkLength( $aForm['sStreet'], 0 )
      && checkLength( $aForm['sZipCode'], 0 )
      && checkLength( $aForm['sCity'], 0 )
      && checkLength( $aForm['sTelephone'], 0 )
      && checkEmail( $aForm['sEmail'] )
      && checkLength( $aForm['iCourier'], 1 )
    )
      return true;
    else
      return false;
  } // end function checkOrderFields
}
?>
