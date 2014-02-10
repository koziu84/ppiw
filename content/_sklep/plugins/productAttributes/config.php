<?php
$config['db_attributes']         = $config['dir_db'].'attributes.php';
$config['db_product_attributes'] = $config['dir_db'].'product_attributes.php';
define( 'DB_ATTRIBUTES',           $config['db_attributes'] );
define( 'DB_PRODUCT_ATTRIBUTES',   $config['db_product_attributes'] );

$config['attrTTonProdList'] = true;
$config['attrInclGroupInBasket'] = 'both';
$config['attrShowAttrOnProdPrint'] = 'both';
$config['attrShowCurrencyOnOffset'] = 'after';
$config['attrPaTemplate'] = array('products_list.tpl', 'products_more.tpl', 'products_print.tpl', 'productsInRow.tpl');
/* Plugin Manager Configuration Instructions */
$PMCI['db_attributes']['hide'] = $PMCI['db_product_attributes']['hide'] = true;
$PMCI['attrInclGroupInBasket']['type'] = 'radio(no='.LANG_NO_SHORT.",select={$lang['attrSelectable']},ui={$lang['attrReservedGroupButton']},both={$lang['both']})";
$PMCI['attrShowAttrOnProdPrint']['type'] = 'radio(no='.LANG_NO_SHORT.",select={$lang['attrSelectable']},ui={$lang['attrReservedGroupButton']},both={$lang['both']})";
$PMCI['attrShowCurrencyOnOffset']['type'] = 'radio(no='.LANG_NO_SHORT.",before={$lang['attrCurrencyBefore']},afterpm={$lang['attrCurrencyBeforeAmount']},after={$lang['attrCurrencyAfterAmount']})";
$PMCI['attrPaTemplate'] = array('format'=>'a(s*)', 'type'=>'textarea');
?>
