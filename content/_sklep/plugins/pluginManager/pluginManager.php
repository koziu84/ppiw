<?php
/*
* pluginManager.php v2.0
* Wizzud: 30/10/05
*/


@include_once (DIR_PLUGINS.'pluginManager/lang-en.php'); // default
@include_once (DIR_PLUGINS."pluginManager/lang-{$config['language']}.php");
@include_once (DIR_PLUGINS.'pluginManager/config.php');

require_once (DIR_PLUGINS.'pluginManager/extendTplParser.class.php');
require_once (DIR_PLUGINS.'pluginManager/pluginManager.class.php');

// It is possible for some plugins (templateEdit being one) to be implemented in such a manner as to need their language file(s)
// loaded by the plugin manager. In certain cases, they could also be required even when the plugin itself is disabled. Hence ...
if(($templist = $oPlugMan->getLanguagePreloads()) !== false){
  foreach($templist as $v){
    @include_once (DIR_PLUGINS."$v/lang-en.php");
    @include_once (DIR_PLUGINS."$v/lang-{$config['language']}.php");
  }
}
unset($templist);


/****************************
** MISCELLANEOUS FUNCTIONS **
****************************/
if( !function_exists( 'scanOrderBasics' ) ){
  /* Reads the order and basket, tallies the number of products, the number of items, the total value of the items in the basket, and sets an array of the product IDs; returns false if order not found
  * @param int  $iOrder
  * @return array
  */
  function scanOrderBasics( $iOrder ){
    global $config;
    require_once DIR_CORE.'orders-'.$config['db_type'].'.php';
    require_once DIR_CORE.'orders.php';

    $rtn = false;
    $order = throwOrder($iOrder);
    if(isset($order)){
      $basket = dbListBasket($iOrder);
      if(isset($basket)){
        $rtn = array('iProducts'=>0, 'iItems'=>0, 'fValue'=>0, 'fCourier'=>0, 'fTotal'=>0, 'aProductId'=>array());
        $rtn['fCourier'] = (float)$order['Courier'];
        $iCount = count( $basket );
        for( $i = 1; $i < $iCount; $i++ ){
          $aExp = explode( '$', $basket[$i] );
          $rtn['iProducts']++; // product
          $rtn['aProductId'][] = $aExp[2]; // product ID
          $rtn['iItems'] += (int)$aExp[3]; // quantity of product
          $rtn['fValue'] += (int)$aExp[3] * (float)$aExp[4]; // quantity * price of product
        }
        $rtn['fTotal'] = $rtn['fValue'] + $rtn['fCourier'];
        unset($basket);
      }
      unset($order);
    }
    return $rtn;
  } // end function scanOrderBasics
}


/*****************************
** PLUGIN MANAGER FUNCTIONS **
*****************************/

/**
* Plugins are disabled by default
* @return bool
* @param string
*/
if(!function_exists('pluginIsEnabled')){
  function pluginIsEnabled( $sPlugin ) {
    global $oPlugMan;
    return $oPlugMan->getPluginStatus($sPlugin);
  } // end function pluginIsEnabled
}

if( basename( $_SERVER['PHP_SELF'] ) == 'admin.php' ) {
  /**
  * Formats the output for the plugin manager
  * @return string
  * @param string
  */
  if(!function_exists('throwPluginsList')){
    function throwPluginsList ( $sFile='pluginManager.tpl' ) {
      global $oPlugMan;

      extendedTplParser();
      $oPlugMan->setTemplate($sFile);
      return $oPlugMan->getPluginFormHtml();
    } // end function throwPluginsList
  }

  /**
  * (Re)loads the setup for a named plugin
  * @return void
  * @param string
  */
  if(!function_exists('reloadPluginSetup')){
    function reloadPluginSetup( $sP ) {
      global $oPlugMan;
      return $oPlugMan->setResetPlugin($sP);
    } // end function reloadPluginSetup
  }
  
  /**
  * Saves the plugins configuration
  * @return void
  * @param array
  */
  if(!function_exists('savePlugins')){
    function savePlugins( $aForm ) {
      global $oPlugMan;

      return $oPlugMan->setPlugins($aForm);
    } // end function savePlugins
  }

  /**
  * Saves the plugins individual configuration
  * @return void
  * @param array
  */
  if(!function_exists('savePluginsConfiguration')){
    function savePluginsConfiguration( $aForm ) {
      global $oPlugMan;

      if(($oPMC = $oPlugMan->getPlugin($aForm['sPlgn'])) !== false){
        return $oPMC->setPluginConfig($aForm);
      }
    } // end function savePluginsConfiguration
  }

  /**
  * Formats the output for the plugin manager configuration
  * @return string
  * @param string
  */
  if(!function_exists('throwPluginsConfiguration')){
    function throwPluginsConfiguration( $sP, $sFile='pluginManager.tpl' ){
      global $oPlugMan;

      extendedTplParser();
      if(($oPMC = $oPlugMan->getPlugin($sP)) !== false){
        $oPMC->loadConfig();
        $oPMC->setTemplate($sFile);
        return $oPMC->getConfigFormHtml();
      }else{
        return '';
      }
    } // end of function throwPluginsConfiguration
  }
}

if(!function_exists('setPMCIthemeSelect')){
  /* Sets list of themes
  * @return string PMCI type string
  */
  function setPMCIthemeSelect(){
    global $oPlugMan, $PMCI;
    $PMCI['theme']['type'] = 'select(';
    if(($themes = $oPlugMan->getThemes()) !== false){
      foreach($themes as $k=>$v){ $PMCI['theme']['type'] .= "$v=$k,"; }
    }
    $PMCI['theme']['type'] = rtrim($PMCI['theme']['type'],',').')';
  }
}

/**************************
** REPLACEMENT FUNCTIONS **
**************************/

if( !function_exists( 'throwTemplatesSelect' ) ){
  /**
  * Returns select of style files
  * @return string
  * @param string $sFileName
  */
  function throwTemplatesSelect( $sFileName = null ){
    global $oPlugMan;
    $rtn = '';
    if(($css = $oPlugMan->getThemeTemplates()) !== false){
      foreach($css as $sFile){
        if( isset( $sFileName ) && $sFileName == $sFile ){ $sSelected = "selected='selected'"; }
        else{ $sSelected = ''; }
        $rtn .= "<option value='$sFile' $sSelected>$sFile</option>";
      }
    }
    return $rtn;
  } // end function throwTemplatesSelect
}


/********************
** MANAGED PLUGINS **
********************/
$aPMRequiredFiles = $oPlugMan->getPluginRequires('plugins.php');
foreach($aPMRequiredFiles as $k=>$v){
  foreach($v as $w) { require_once DIR_PLUGINS."$k/$w"; }
}
unset($aPMRequiredFiles);
?>
