<?php
####################
## Author: wizzud ##
####################
extendedTplParser();
if($config['bPMshortMsgClickHide'] === true){
  // add an appended TPL call to both short message TP calls ...
  $tpl->newIntercept('messages.tpl', null, 'SAVED_SHORT', 'SAVED_SHORT', '', '', array($oPlugMan->getTemplate(), 'HIDE_MESSAGE_ON_CLICK'));
  $tpl->newIntercept('messages.tpl', null, 'DELETED_SHORT', 'DELETED_SHORT', '', '', array($oPlugMan->getTemplate(), 'HIDE_MESSAGE_ON_CLICK'));
}

$content .= $oPlugMan->loadStylesheet('pluginManager.css');

if ( $p == 'pluginsConfig' ){
  if ( !isset($sPlgn) && !isset($_POST['sPlgn']) ){
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p=pluginsEdit' );
    exit();
  } else {
    if ( isset( $sOption ) && $sOption == 'save' ){
      savePluginsConfiguration( $_POST );
      header( 'Location: '.$_SERVER['PHP_SELF'].'?p=pluginsEdit&sOption=saved');
      exit();
    } else {
      // the includes ensure that a plugin can be configured without having to enable it
      @include_once (DIR_PLUGINS."$sPlgn/lang-en.php"); // default
      @include_once (DIR_PLUGINS."$sPlgn/lang-{$config['language']}.php");
      @include_once (DIR_PLUGINS."$sPlgn/config.php");
      setPMCIthemeSelect();
      $content .= throwPluginsConfiguration($sPlgn);
    }
  }
}else if ( $p == 'pluginsSetup' ){
  if ( isset($sPlgn) ){
    reloadPluginSetup($sPlgn);
  }
  header( 'Location: '.$_SERVER['PHP_SELF'].'?p=pluginsEdit' );
  exit();
}else if ( $p == 'pluginsEdit') {
  if ( isset( $sOption ) ){
    if( $sOption == 'disabled' ){
      $content .= $tpl->tbHtml( $oPlugMan->getTemplate(), 'PLUGIN_DISABLED_MESSAGE' );
    }elseif( $sOption == 'saved' ){
      $content .= $tpl->tbHtml( 'messages.tpl', 'SAVED_SHORT' );
    }elseif( $sOption == 'save' ){
      savePlugins( $_POST );
      header( 'Location: '.$_SERVER['PHP_SELF'].'?p=pluginsEdit&sOption=saved');
      exit();
    }
  }
  $content .= throwPluginsList();
}

// check for disabled admin functions that are set up for interception
if(($aPMdisabledTriggers = $oPlugMan->getDisabledTriggers()) !== false){
  if(in_array($p, $aPMdisabledTriggers)){
    header( 'Location: '.$_SERVER['PHP_SELF'].'?p=pluginsEdit&sOption=disabled');
    exit();
  }
}

// auto-load the actions_admin files
$aPMRequiredFiles = $oPlugMan->getPluginRequires('actions_admin.php');
foreach($aPMRequiredFiles as $k=>$v){
  foreach($v as $w) { require DIR_PLUGINS."$k/$w"; }
}
unset($aPMRequiredFiles);
?>
