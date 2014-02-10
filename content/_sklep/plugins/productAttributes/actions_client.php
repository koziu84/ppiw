<?php
/**
* actions_client.php
* Wizzud 31/01/06 Product-Attributes
*/
require_once DIR_PLUGINS.'productAttributes/productAttributes.class.php';
require_once DIR_PLUGINS.'productAttributes/attributes.php';

$oAttributes = new productAttributes();
extendedTplParser();
/* SPECIAL PRICE INTERCEPTS */
$tpl->newIntercept('products_list.tpl', (in_array('products_list.tpl',$config['attrPaTemplate'])?'pa.':'').'products_list.tpl', 'LIST_LIST', 'LIST_LIST', 'throwAttrSpecialPrice', '');
$tpl->newIntercept('productsInRow.tpl', (in_array('productsInRow.tpl',$config['attrPaTemplate'])?'pa.':'').'productsInRow.tpl', 'LIST_LIST', 'LIST_LIST', 'throwAttrSpecialPrice', '');
$tpl->newIntercept('products_more.tpl', (in_array('products_more.tpl',$config['attrPaTemplate'])?'pa.':'').'products_more.tpl', 'SHOW', 'SHOW', 'throwAttrSpecialPrice', '');
$tpl->newIntercept('products_print.tpl', (in_array('products_print.tpl',$config['attrPaTemplate'])?'pa.':'').'products_print.tpl', 'SHOW', 'SHOW', 'throwAttrSpecialPrice', '');

// Modification ...
if( $p == 'productsList' ){
  $content .= $oPlugMan->loadStylesheet('productAttributes.css');
}
// Modification ...
elseif( $p == 'productsMore' && isset( $iProduct ) && is_numeric( $iProduct ) ){
  $oAttributes->throwAttributeSelectors( $iProduct );
  $content .= $oPlugMan->loadStylesheet('productAttributes.css');
}
// Modification ...
elseif( $p == 'ordersBasket' && isset( $sOption ) && $sOption == 'add' && isset( $iProduct ) && is_numeric( $iProduct ) && isset( $iQuantity ) && is_numeric( $iQuantity ) && $iQuantity >= 1 && $iQuantity < 1000 ){
  if( ($sCommaDelimAttributes = $oAttributes->missingAttributes( $iProduct ) ) === true ){
    header( "Location: {$_SERVER['PHP_SELF']}?p=productsMore&iProduct=$iProduct" );
    exit();
  }
}

// Modification ...
if(substr($p,0,6) == 'orders'){
  $content .= $oPlugMan->loadStylesheet('productAttributes.css');
}
?>
