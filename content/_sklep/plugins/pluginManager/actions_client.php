<?php
####################
## Author: wizzud ##
####################
extendedTplParser();

// Shop Status checks ...
if($config['shopStatus'] == 'catalogue' && $p == 'ordersBasket'){
  $p = 'shopstatus'.ucwords($config['shopStatus']);
  $bDisplayedPage = true;
  $content .= $tpl->tbHtml('pluginManager.tpl', strtoupper($config['shopStatus']));
}elseif($config['shopStatus'] == 'offline' && (substr(strtolower($p),0,8) == 'products' || substr(strtolower($p),0,6) == 'orders')){
  $p = 'shopstatus'.ucwords($config['shopStatus']);
  $bDisplayedPage = true;
  $content .= $tpl->tbHtml('pluginManager.tpl', strtoupper($config['shopStatus']));
}

$aPMRequiredFiles = $oPlugMan->getPluginRequires('actions_client.php');
foreach($aPMRequiredFiles as $k=>$v){
  foreach($v as $w) { require DIR_PLUGINS."$k/$w"; }
}
unset($aPMRequiredFiles);
?>
