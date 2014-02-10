<?php
require_once DIR_CORE.'couriers-'.$config['db_type'].'.php';
require_once DIR_CORE.'couriers-admin.php';
require_once DIR_CORE.'couriers.php';

if( $a == 'List' ){
  if( isset( $sOption ) ){
    if( $sOption == 'del' )
      $content .= $tpl->tbHtml( 'messages.tpl', 'DELETED_SHORT' );
    elseif( $sOption == 'save' )
      $content .= $tpl->tbHtml( 'messages.tpl', 'SAVED_SHORT' );    
  }

  $content .= $tpl->tbHtml( 'couriers_list.tpl', 'HEAD' );
  $content .= listCouriers( );
}
elseif( $a == 'Form' ){
  if( isset( $_POST['sOption'] ) && $_POST['sOption'] == 'save' ){
    saveCourier( $_POST );
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['g'].'List&sOption=save' );
  }
  else{
    if( isset( $iCourier ) && is_numeric( $iCourier ) ){
      $aData = throwCourier( $iCourier );
    }
    
    $content .= $tpl->tbHtml( 'couriers_form.tpl', 'FORM' );
  }
}
elseif( $a == 'Delete' && isset( $iCourier ) && is_numeric( $iCourier ) ){
  delCourier( $iCourier );
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['g'].'List&sOption=del' );
}
?>