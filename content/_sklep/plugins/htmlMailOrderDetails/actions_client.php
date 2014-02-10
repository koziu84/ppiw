<?php
/*
* actions_client.php for htmlMailOrderDetails plugin
* Wizzud: 31/01/06
*/
if(extendedTplParser() && $oMail->isSetIntercept() === false)
  $oMail->setInterceptID( $tpl->newIntercept('messages.tpl', 'messages.tpl', 'ORDER_SAVED', 'ORDER_SAVED', 'sendHtmlMailDetails', '') );
?>
