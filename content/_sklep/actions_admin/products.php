<?php
require_once DIR_CORE.'files-'.$config['db_type'].'.php';
require_once DIR_CORE.'files-admin.php';
require_once DIR_CORE.'files.php';

require_once DIR_CORE.'products-'.$config['db_type'].'.php';
require_once DIR_CORE.'products-admin.php';
require_once DIR_CORE.'products.php';

require_once DIR_CORE.'categories-'.$config['db_type'].'.php';
require_once DIR_CORE.'categories.php';

if( $a == 'List' ){
  if( isset( $sOption ) ){
    if( $sOption == 'del' )
      $content .= $tpl->tbHtml( 'messages.tpl', 'DELETED_SHORT' );
    elseif( $sOption == 'save' )
      $content .= $tpl->tbHtml( 'messages.tpl', 'SAVED_SHORT' );    
  }
  
  if( isset( $iCategory ) && is_numeric( $iCategory ) ){
    $aCategory[] = $iCategory;
  }
  else{
    $iCategory = null;
    $aCategory = Array( );
  }
  
  $sSelectCategory = listCategories( 'categories_select.tpl', 1, null, $aCategory );

  $content .= $tpl->tbHtml( 'products_list.tpl', 'HEAD' );

  if( isset( $iCategory ) && is_numeric( $iCategory ) ){
    $content .= listProducts( 'products_list.tpl', 'category', $iCategory );
  }
  else{
    if( isset( $sWord ) && throwStrlen( $sWord ) > 0 ){
      $content .= listProducts( 'products_list.tpl', 'search', $sWord );
    }
    else{
      $content .= listProducts( 'products_list.tpl' );
    }
  }
}
elseif( $a == 'Form' ){
  if( isset( $_POST['sOption'] ) && $_POST['sOption'] == 'save' ){
    saveProduct( $_POST );
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['g'].'List&sOption=save' );  
  }
  else{
    if( isset( $iProduct ) && is_numeric( $iProduct ) )
      $aData = throwProduct( $iProduct );
    if( !isset( $iCategory ) )
      $iCategory = null;
      
    if( isset( $aData ) && is_array( $aData ) ){
      $aFiles   = listFiles( $iProduct, 'products_form.tpl', 1 );

      $aData['sDescriptionShort'] = changeTxt( $aData['sDescriptionShort'], 'nlNds' );
      $aData['sDescriptionFull']  = changeTxt( $aData['sDescriptionFull'], 'nlNds' );
    }
    else{
      $aData['aCategories']       = Array( );
      $aData['iStatus']           = 1;
      $aData['iPosition']         = 0;
      $aData['sDescriptionFull']  = null;
    }
    $sCategoriesSelect  = listCategories( 'categories_select.tpl', 1, null, $aData['aCategories'] );
    $sStatusSelect      = throwYesNoSelect( $aData['iStatus'] );

    $sHtmlEditor = htmlEditor ( 'sDescriptionFull', '300', '600', $aData['sDescriptionFull'] ) ;
    
    $content .= $tpl->tbHtml( 'products_form.tpl', 'FORM' );
  }
}
elseif( $a == 'Delete' && isset( $iProduct ) && is_numeric( $iProduct ) ){
  delProduct( $iProduct );
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['g'].'List&sOption=del' );
}
?>