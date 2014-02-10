<?php
/*
* htmlMailOrderDetails.php
*/
@include_once (DIR_PLUGINS.'htmlMailOrderDetails/lang-en.php'); // default
@include_once (DIR_PLUGINS."htmlMailOrderDetails/lang-{$config['language']}.php");
@include_once (DIR_PLUGINS.'htmlMailOrderDetails/config.php');

require_once DIR_PLUGINS.'htmlMailOrderDetails/qcMailer.class.php';

$oMail = new qcMailer();

/* Run Before function ONLY. Sends emails
* @return void
*/
function sendHtmlMailDetails(){
  global $tpl, $oPlugMan, $oMail, $iOrder, $sBlockPage, $bPrint, $aList, $aData;
  if(isset($iOrder) && is_numeric($iOrder)){
    $body = ''; $reset_sBlockpage = $sBlockPage; $reset_bPrint = $bPrint; $sBlockPage = '_PRINT'; $bPrint = true;

// This section, from here ...
    $aData = throwOrder( $iOrder );
    if( isset( $aData ) && is_array( $aData ) && $aData['iClient'] == $_SESSION['iCustomer'] && $aData['iStatus'] > 0 ){

      $aData['sComment']  = ereg_replace( '\|n\|', "<br />" , $aData['sComment'] );

      $body .= $tpl->tbHtml( 'orders_print.tpl', 'SHOW' );
      if( checkOrderProducts( $iOrder ) === true ){
        $body .= listBasket( $iOrder, 'orders_print.tpl' );
        $aData['fSummary'] = sprintf( '%01.2f', $aData['fCourierPrice'] + $aList['fSummary'] );
        $body .= $tpl->tbHtml( 'orders_print.tpl', 'COURIER' );
      }
// ... through to here, is lifted from actions_client/orders.php, the part for printing an order.

      $aData['hmodStylesheets'] = $oPlugMan->getAllStylesheets();
      $oMail->setSendTo($aData['sEmail'], $aData['sFirstName'].' '.$aData['sLastName']);
      $oMail->sMailBody = $tpl->tbHtml( $oMail->getTemplate(), 'HEAD_EMAIL' ) . $body . $tpl->tbHtml( 'page.tpl', 'FOOTER'.$sBlockPage );
      $oMail->Send();
    }
    $sBlockPage = $reset_sBlockpage; $bPrint = $reset_bPrint;
    unset($body);
  }
} // end function sendHtmlMailDetails
?>
