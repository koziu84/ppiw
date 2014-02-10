<?php
if( !isset( $_SESSION['iCustomer'] ) )
  session_start( );

if( !isset( $_SESSION['iCustomer'] ) )
  $_SESSION['iCustomer'] = time( ).rand( 100, 999 );

require_once DIR_CORE.'couriers-'.$config['db_type'].'.php';
require_once DIR_CORE.'couriers.php';

require_once DIR_CORE.'orders-'.$config['db_type'].'.php';
require_once DIR_CORE.'orders.php';

require_once DIR_CORE.'products-'.$config['db_type'].'.php';
require_once DIR_CORE.'products.php';

if( $a == 'Basket' ){
 
  if( isset( $sOption ) ){
    
    $iOrder = throwOrderIdTemp( $_SESSION['iCustomer'], 'add' );

    if( $sOption == 'add' ){
      if( isset( $iProduct ) && is_numeric( $iProduct ) && isset( $iQuantity ) && is_numeric( $iQuantity ) && $iQuantity >= 1 && $iQuantity < 1000 ){
        addOrderProduct( $iProduct, $iQuantity, $iOrder );
      }
      header( 'Location: '.$_SERVER['PHP_SELF'].'?p=ordersBasket' );
      exit;
    }
    elseif( $sOption == 'del' ){
      if( isset( $iElement ) && is_numeric( $iElement ) )
        delOrderElement( $iOrder, $iElement );
    }
    elseif( $sOption == 'save' ){
      if( isset( $_POST['aElements'] ) && is_array( $_POST['aElements'] ) ){
        saveOrderProducts( $_POST );
      }

      if( isset( $_POST['sSave'] ) ){
        header( 'Location: '.$_SERVER['PHP_SELF'].'?p=ordersDelivery' );
        exit;
      }
    }
  }
  else
    $iOrder = throwOrderIdTemp( $_SESSION['iCustomer'], null );

  if( isset( $iOrder ) && is_numeric( $iOrder ) )
    $content .= listBasket( $iOrder );
  else
    $content .= $tpl->tbHtml( 'orders_basket.tpl', 'NOT_FOUND' );
}
elseif( $a == 'Delivery' ){
  $iOrder = throwOrderIdTemp( $_SESSION['iCustomer'], null );

  if( isset( $iOrder ) && is_numeric( $iOrder ) ){
    if( isset( $_POST['sOption'] ) && $_POST['sOption'] == 'send' ){
      if( checkOrderFields( $_POST ) === true && checkOrderProducts( $iOrder ) === true ){
        saveOrder( $iOrder, $_POST );
        $content .= $tpl->tbHtml( 'messages.tpl', 'ORDER_SAVED' );
      }
      else
        $content .= $tpl->tbHtml( 'messages.tpl', 'FORM_ERROR' );
    }
    else{
      if( checkOrderProducts( $iOrder ) === true ){
        $sCourierSelect = listCouriers( 'couriers_select.tpl' );
        $content .= $tpl->tbHtml( 'orders_delivery.tpl', 'FORM' );
        $content .= listBasket( $iOrder, 'orders_delivery.tpl' );
        $content .= $tpl->tbHtml( 'orders_delivery.tpl', 'COURIER' );
      }
      else
        $content .= $tpl->tbHtml( 'messages.tpl', 'NOT_EXISTS' );
    }
  }
  else
    $content .= $tpl->tbHtml( 'orders_basket.tpl', 'NOT_FOUND' );
}
elseif( $a == 'Print' && isset( $iOrder ) && is_numeric( $iOrder ) ){
  $aData = throwOrder( $iOrder );
  if( isset( $aData ) && is_array( $aData ) && $aData['iClient'] == $_SESSION['iCustomer'] && $aData['iStatus'] > 0 ){

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
else
  $content .= $tpl->tbHtml( 'messages.tpl', 'ERROR' );
?>