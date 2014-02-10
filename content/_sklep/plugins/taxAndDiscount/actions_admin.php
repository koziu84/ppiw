<?php
####################
## Author: wizzud ##
####################
/*
* actions_admin.php for taxAndDiscount plugin
* Wizzud : 16/02/06
*/
require_once DIR_PLUGINS.'taxAndDiscount/tax.php';
require_once DIR_PLUGINS.'taxAndDiscount/tax-'.$config['db_type'].'.php';

extendedTplParser();
$tpl->newIntercept('orders_more.tpl', 'taxAndDiscount.tpl', 'COURIER', 'DELIVERY', 'throwTaxAndDiscountPrint', '');
$tpl->newIntercept('orders_print.tpl', 'taxAndDiscount.tpl', 'COURIER', 'DELIVERY_PRINT', 'throwTaxAndDiscountPrint', '');
?>
