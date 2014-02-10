<?php
require_once DIR_CORE.'couriers-'.$config['db_type'].'.php';
require_once DIR_CORE.'couriers-admin.php';
require_once DIR_CORE.'couriers.php';

require_once DIR_CORE.'orders-'.$config['db_type'].'.php';
require_once DIR_CORE.'orders-admin.php';
require_once DIR_CORE.'orders.php';

require_once DIR_CORE.'products-'.$config['db_type'].'.php';
require_once DIR_CORE.'products.php';

if( $a == 'List' ){

  if( isset( $sOption ) ){
    if( $sOption == 'del' )
      $content .= $tpl->tbHtml( 'messages.tpl', 'DELETED_SHORT' );
    elseif( $sOption == 'save' )
      $content .= $tpl->tbHtml( 'messages.tpl', 'SAVED_SHORT' );    
  }

  if( !isset( $iStatus ) )
    $iStatus = null;

  $sSelectStatus = throwOrderStatusSelect( $iStatus );

  $content .= $tpl->tbHtml( 'orders_list.tpl', 'HEAD' );

  if( isset( $iStatus ) && is_numeric( $iStatus ) ){
    $content .= listOrders( 'orders_list.tpl', 'status' );
  }
  else{
    if( isset( $sWord ) && throwStrlen( $sWord ) > 0 ){
      $content .= listOrders( 'orders_list.tpl', 'search' );
    }
    else{
      $content .= listOrders( 'orders_list.tpl' );
    }
  }
}
elseif( $a == 'Delete' && isset( $iOrder ) && is_numeric( $iOrder ) ){
  delOrder( $iOrder );
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['g'].'List&sOption=del' );
}
elseif( $a == 'More' && isset( $iOrder ) && is_numeric( $iOrder ) ){
  
  delOrderMass( );

  if( isset( $sOption ) && $sOption == 'save' ){
    saveOrderStatus( $iOrder, $iStatus );
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p='.$aActions['g'].'List&sOption=save' );  
  }
  else{
    $aData = throwOrder( $iOrder );
    if( isset( $aData ) && is_array( $aData ) ){
      $sStatusSelect      = throwOrderStatusSelect( $aData['iStatus'] );
      $aData['sComment']  = ereg_replace( '\|n\|', "<br />" , $aData['sComment'] );

      $content .= $tpl->tbHtml( 'orders_more.tpl', 'SHOW' );

      if( checkOrderProducts( $iOrder ) === true ){
        $content .= listBasket( $iOrder, 'orders_more.tpl' );
        $aData['fSummary'] = sprintf( '%01.2f', $aData['fCourierPrice'] + $aList['fSummary'] );
        $content .= $tpl->tbHtml( 'orders_more.tpl', 'COURIER' );
      }
      else{
        $content .= $tpl->tbHtml( 'messages.tpl', 'NOT_EXISTS' );
      }
    }
    else
      $content .= $tpl->tbHtml( 'messages.tpl', 'NOT_EXISTS' );
  }
}
elseif( $a == 'Print' && isset( $iOrder ) && is_numeric( $iOrder ) ){
  $aData = throwOrder( $iOrder );
  if( isset( $aData ) && is_array( $aData ) ){
    
    $aData['sComment']  = ereg_replace( '\|n\|', "<br />" , $aData['sComment'] );

    $content .= $tpl->tbHtml( 'orders_print.tpl', 'SHOW' );

    if( checkOrderProducts( $iOrder ) === true ){
      $content .= listBasket( $iOrder, 'orders_print.tpl' );
      $aData['fSummary'] = sprintf( '%01.2f', $aData['fCourierPrice'] + $aList['fSummary'] );
      $content .= $tpl->tbHtml( 'orders_print.tpl', 'COURIER' );
    }
  }
  else{
    $content .= $tpl->tbHtml( 'messages.tpl', 'ERROR' );
  }
}
?>