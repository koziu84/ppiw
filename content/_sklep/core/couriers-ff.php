<?php
if( !function_exists( 'dbSaveCourier' ) ){
  /**
  * Save courier to file
  * @return void
  * @param array  $aForm
  * @param bool   $bExist
  */
  function dbSaveCourier( $aForm, $bExist ){
    global $oFF;
    $oFF->setRow( Array(  $aForm['iCourier'], $aForm['sName'], $aForm['fPrice'] ) );
    $oFF->setData( Array( 1, 2, 0 ) );
    if( isset( $bExist ) )
      $oFF->changeInFile( DB_COURIERS, $aForm['iCourier'], 0, 'sort' );
    else
      $oFF->addToFile( DB_COURIERS, 'sort' );
  } // end function dbSaveCourier
}

if( !function_exists( 'dbDelCourier' ) ){
  /**
  * Delete courier
  * @return void
  * @param int  $iCourier
  */
  function dbDelCourier( $iCourier ){
    $GLOBALS['oFF']->deleteInFile( DB_COURIERS, $iCourier, 0 );
  } // end function dbDelCourier
}

if( !function_exists( 'dbListCouriers' ) ){
  /**
  * Return couriers list
  * @return array
  */
  function dbListCouriers( ){
    return $GLOBALS['oFF']->throwFileArray( DB_COURIERS );
  } // end function dbListCouriers
}

if( !function_exists( 'dbThrowCourier' ) ){
  /**
  * Return courier data
  * @return array
  * @param int  $iCourier
  */
  function dbThrowCourier( $iCourier ){
    return $GLOBALS['oFF']->throwData( DB_COURIERS, $iCourier, 0 );
  } // end function dbThrowCourier
}
?>