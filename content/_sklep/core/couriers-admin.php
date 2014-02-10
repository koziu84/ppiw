<?php
if( !function_exists( 'saveCourier' ) ){
  /**
  * Save courier
  * @return void
  * @param array  $aForm
  */
  function saveCourier( $aForm ){
    
    if( is_numeric( $aForm['iCourier'] ) ){
      $bExist = true;
    }
    else{
      $aForm['iCourier'] = throwLastId( DB_COURIERS ) + 1;
      $bExist = null;
    }

    $aForm['sName']  = changeTxt( $aForm['sName'] );
    $aForm['fPrice'] = ereg_replace( ',', '.', $aForm['fPrice'] );
    $aForm['fPrice'] = tPrice( $aForm['fPrice'] );
    
    dbSaveCourier( $aForm, $bExist );
  } // end function saveCourier
}

if( !function_exists( 'delCourier' ) ){
  /**
  * Delete courier
  * @return void
  * @param int  $iCourier
  */
  function delCourier( $iCourier ){
    dbDelCourier( $iCourier );
  } // end function delCourier
}
?>