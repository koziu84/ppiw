<?php
/**
* actions_admin.php
* Wizzud 31/01/06 Product-Attributes
*/
require_once DIR_PLUGINS.'productAttributes/productAttributes.class.php';
require_once DIR_PLUGINS.'productAttributes/attributes-admin.php';
require_once DIR_PLUGINS.'productAttributes/attributes.php';
$oAttributes = new productAttributes();

extendedTplParser();

if( $p == 'productsList' ){
  //replace LIST_LIST block in products_list.tpl with PRODUCTS_LIST_LIST block from productAttributes.tpl, and set a run-before function (setProdListHasAttr() from attributes-admin.php)
  $tpl->newIntercept('products_list.tpl', 'productAttributes.tpl', 'LIST_LIST', 'PRODUCTS_LIST_LIST', 'setProdListHasAttr');
  if($config['attrTTonProdList'])
    $content .= $tpl->tbHtml( 'productAttributes.tpl', 'PRODLIST_TOOLTIP_SCRIP' );
  $content .= $oPlugMan->loadStylesheet('productAttributes.css');
}
elseif( $p == 'productsDelete' && isset( $iProduct ) && is_numeric( $iProduct ) ){
  $oAttributes->deleteProductAttributes( $iProduct );
}

// New ...
elseif(preg_match('/^attributes(List|Form|Delete|Product)$/',$p) > 0){
  require_once DIR_CORE.'products-'.$config['db_type'].'.php';
  require_once DIR_CORE.'products-admin.php';
  require_once DIR_CORE.'products.php';
  require_once DIR_CORE.'categories-'.$config['db_type'].'.php';
  require_once DIR_CORE.'categories-admin.php';
  require_once DIR_CORE.'categories.php';

  if( $p == 'attributesList' ){
    if( isset( $sOption ) ){
      if( $sOption == 'del' )
        $content .= $tpl->tbHtml( 'messages.tpl', 'DELETED_SHORT' );
      elseif( $sOption == 'save' )
        $content .= $tpl->tbHtml( 'messages.tpl', 'SAVED_SHORT' );
    }
    $content .= $oAttributes->throwAttributesList();
  }
  elseif( $p == 'attributesForm' ){
    if( isset( $_POST['sOption'] ) && $_POST['sOption'] == 'save' ){
      $oAttributes->saveAttribute( $_POST );
      header( 'Location: '.$_SERVER['PHP_SELF'].'?p=attributesList&sOption=save' );
    }
    else{
      if( isset( $iAttribute ) ){
        $aAttribute = $oAttributes->getAttribute( $iAttribute );
      }
      $aAttribute['selectGroup'] = $oAttributes->throwSelectGroup();
      $content .= $tpl->tbHtml( $oAttributes->getTemplate(), 'FORM' );
    }
  }
  elseif( $p == 'attributesDelete' && isset( $iAttribute ) && is_numeric( $iAttribute ) ){
    $oAttributes->deleteAttribute( $iAttribute );
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p=attributesList&sOption=del' );
  }
  elseif( $p == 'attributesProduct' && isset( $iProduct ) && is_numeric( $iProduct ) && $iProduct > 0 ){
    if( isset( $_POST['sOption'] ) && $_POST['sOption'] == 'save' ){
      $oAttributes->saveProductAttributes( $_POST );
      header( 'Location: '.$_SERVER['PHP_SELF'].'?p=productsList&sOption=save' );
    }
    else{
      $content .= $oAttributes->throwAssignAttributes( $iProduct );
    }
  }
}
?>
