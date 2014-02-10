<?php
/*
* taxAndDiscount.php for taxAndDiscount plugin v2.0
* Wizzud : 01/02/06
*/
@include_once (DIR_PLUGINS.'taxAndDiscount/lang-en.php'); // default
@include_once (DIR_PLUGINS."taxAndDiscount/lang-{$config['language']}.php");
@include_once (DIR_PLUGINS.'taxAndDiscount/config.php');

// db/orders.php: new fields (delivery, discount rate, discount, tax, total)
// modifications (core/orders-ff.php)
if( !function_exists( 'dbAddOrderExtensions' ) ){
  /**
  * Add order extensions to file
  * @return void
  * @param array  $aData
  * @param bool   $bErase
  */
  function dbAddOrderExtensions( $aData, $bErase = true ){
    global $oFF, $aTadSaveOrderExt; // added global
    if( isset( $bErase ) )
      $oFF->deleteInFile( DB_ORDERS_EXT, $aData[0], 0 );
    $aNewData = array_merge($aData, $aTadSaveOrderExt); // inserted
    $oFF->setRow( $aNewData ); // changed from $aData
    $oFF->addToFile( DB_ORDERS_EXT, 'rsort' );
  } // end function dbAddOrderExtensions
}
if( !function_exists( 'dbAddOrderExtension' ) ){
  /**
  * Dummy : Add order extensions to file. This is included purely because QCv1.0 and QCv1.1 (at least) have an error in core/orders-ff.php
  *         where the function_exists checks for dbAddOrderExtension but the function is dbAddOrderExtensions (plural) so depending on
  *         whether they change the function name or the function_exists check, this should cope with both (as long as they don't create
  *         2 DIFFERENT functions with these 2 names!)
  * @return void
  * @param array  $aData
  * @param bool   $bErase
  */
  function dbAddOrderExtension( $aData, $bErase = true ){
    dbAddOrderExtensions($aData, $bErase);
  } // end function dbAddOrderExtension
}
?>
