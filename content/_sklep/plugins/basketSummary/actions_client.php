<?php
/**
* basketSummary.php for QCv1.0+
* Wizzud 22/02/06
*/
require_once DIR_CORE.'orders-'.$config['db_type'].'.php';
require_once DIR_CORE.'orders.php';

extendedTplParser();
$tpl->newIntercept('orders_basket.tpl', 'orders_basket.tpl', 'LIST_HEAD', 'LIST_HEAD', 'throwBasketSummary', '');
$tpl->newIntercept('orders_basket.tpl', 'orders_basket.tpl', 'NOT_FOUND', 'NOT_FOUND', 'throwBasketSummary', '');

$content .= $oPlugMan->loadStylesheet('basketSummary.css');
throwBasketSummary();
?>
