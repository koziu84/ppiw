<?php
require_once DIR_CORE.'categories-'.$config['db_type'].'.php';
require_once DIR_CORE.'categories-admin.php';
require_once DIR_CORE.'categories.php';

require_once DIR_CORE.'files-'.$config['db_type'].'.php';
require_once DIR_CORE.'files-admin.php';
require_once DIR_CORE.'files.php';

if( $a == 'List' ){
  if( isset( $sOption ) ){
    if( $sOption == 'del' )
      $content .= $tpl->tbHtml( 'messages.tpl', 'DELETED_SHORT' );
    elseif( $sOption == 'save' )
      $content .= $tpl->tbHtml( 'messages.tpl', 'SAVED_SHORT' );    
  }
  
  $content .= $tpl->tbHtml( 'categories_list.tpl', 'HEAD' );
  $sCategoriesList = listCategoriesByTypes( 'categories_list.tpl', null, Array( ), 'admin' );
  if( empty( $sCategoriesList ) )
    $content .= $tpl->tbHtml( 'categories_list.tpl', 'NOT_FOUND' );
  else
    $content .= $sCategoriesList;
}
elseif( $a == 'Form' ){
  if( isset( $_POST['sOption'] ) && $_POST['sOption'] == 'save' ){
    saveCategory( $_POST );
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['g'].'List&sOption=save' );  
  }
  else{
    if( isset( $iCategory ) && is_numeric( $iCategory ) ){
      $aData  = throwCategory( $iCategory, true );
      $aFiles = listFiles( $iCategory, 'categories_form.tpl', 2 );
    }

    if( !isset( $aData ) || !is_array( $aData ) ){
      $iCategory                  = null;
      $aData['iPosition']         = 0;
      $aData['iParent']           = null;
      $aData['iType']             = null;
      $aData['sDescriptionFull']  = null;
      $aData['iStatus']           = 1;
    }
    $sHtmlEditor =      htmlEditor ( 'sDescriptionFull', '300', '600', $aData['sDescriptionFull'] ) ;

    $sCategorySelect =  listCategoriesByTypes( 'categories_parent_select.tpl', true, Array(  $aData['iParent'] ), 'admin' );
    $sTypeSelect =      throwTypesSelect( $aData['iType'] );
    $sStatusSelect =    throwYesNoSelect( $aData['iStatus'] );

    if( ( is_numeric( $iCategory ) && $iCategory != $config['contact_page'] ) || ( !is_numeric( $iCategory ) && empty( $iCategory ) ) )
      $sFilesForm = $tpl->tbHtml( 'categories_form.tpl', 'FILES_FORM' );

    $content .= $tpl->tbHtml( 'categories_form.tpl', 'CATEGORY_FORM' );
  }
}
elseif( $a == 'Delete' ){
  delCategory( $iCategory );
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['g'].'List&sOption=del' );
}
?>