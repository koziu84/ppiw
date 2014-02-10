<?php
/*
* actions_client.php for taxAndDiscount plugin
* Wizzud : 01/02/06
*/
require_once DIR_PLUGINS.'taxAndDiscount/tax.php';
require_once DIR_PLUGINS.'taxAndDiscount/tax-'.$config['db_type'].'.php';

require_once DIR_CORE.'orders-'.$config['db_type'].'.php';
require_once DIR_CORE.'orders.php';

extendedTplParser();
$tpl->newIntercept('orders_delivery.tpl', 'taxAndDiscount.tpl', 'COURIER', 'DELIVERY', 'throwTaxAndDiscount', '');
$tpl->newIntercept('orders_print.tpl', 'taxAndDiscount.tpl', 'COURIER', 'DELIVERY_PRINT', 'throwTaxAndDiscountPrint', '');

if( $p == 'ordersDelivery' && isset( $_POST['sOption'] ) && $_POST['sOption'] == 'send' ){
  if( !isset( $_SESSION['iCustomer'] ) )
    session_start( );
  if( !isset( $_SESSION['iCustomer'] ) )
    $_SESSION['iCustomer'] = time( ).rand( 100, 999 );

  $iOrder = throwOrderIdTemp( $_SESSION['iCustomer'], null );
  if( isset( $iOrder ) && is_numeric( $iOrder ) ){ setTaxAndDiscount( $iOrder, $_POST ); }
}
?>
