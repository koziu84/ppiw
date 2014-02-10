<?php
/*
* pluginManager.class.php
* Wizzud: 17/10/05
*/

require_once (DIR_PLUGINS.'pluginManager/pluginManagerConfig.class.php');

class PluginManager {
  var $aPlugins = array();
  var $sTemplate;               // the Plugin Manager template file
  var $sPM;                     // the folder containing the Plugin Manager plugin
  var $sShopURL;                // URL to the shop folder, including trailing slash, eg. 'http://www.myQCshop.com/'
  var $aStylesheets = array();  // list of any stylesheets that have been requested
  var $aThemes = array();       // array holding theme info

  function PluginManager(){ // constructor
    $this->sPM = basename(dirname(__FILE__));
    $this->sTemplate = 'pluginManager.tpl';
    $this->sShopURL = dirname ( ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='') ? 'https' : 'http' ) . "://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}" ) . '/';
    $this->_buildPluginList();
    $this->_setThemes();
  } // end of constructor

/********************/
/* Public Functions */
/********************/
// GETTERS
  /* Get template
  * @return string
  */
  function getTemplate(){
    return $this->sTemplate;
  } // end function getTemplate

  /* Get Shop URL
  * @return string
  */
  function getShopURL(){
    return $this->sShopURL;
  } // end function getShopURL

  /* Get a plugin's settings
  * @param string plugin name
  * @return array
  */
  function getPlugin($sP){
    return (isset($this->aPlugins[$sP]) ? $this->aPlugins[$sP] : false);
  } // end of function getPlugin

  /* Get array of include files to load
  * @param string type of include (actions_client/actions_admin/plugins)
  * @return array
  */
  function getPluginRequires($sF){
    $aRtn = array();
    foreach($this->aPlugins as $key=>$obj) { $aRtn[$key] = $obj->getRequiredFiles($sF); }
    return $aRtn;
  } // end of function getPluginRequires

  /* Get plugin's enabled/disabled status
  * @param string plugin name
  * @return boolean
  */
  function getPluginStatus($sP){
    return (isset($this->aPlugins[$sP]) ? $this->aPlugins[$sP]->getStatus() : false);
  } // end of function getPluginStatus

  /* Get list of plugins
  * @param boolean matching status
  * @return array
  */
  function getPluginList($bEnabled=0){ //true=enabled, false=disabled, anything else = all
    $bAll = !is_bool($bEnabled);
    $aRtn = array();
    foreach($this->aPlugins as $key=>$obj){
      if(!$obj->getIgnore())
        if($bAll || $bEnabled === $obj->getStatus())
          $aRtn[] = $key;
    }
    return $aRtn;
  } // end of function getPluginList

  /* List all plugins with status of each
  * @return array
  */
  function getPluginStatusList(){
    $aRtn = array();
    foreach($this->aPlugins as $key=>$obj){
      if(!$obj->getIgnore())
        $aRtn[$key] = $obj->getStatus();
    }
    return $aRtn;
  } // end of function getPluginList

  /* Get names of plugins that have preLoad Language set
  * @return array false if none found
  */
  function getLanguagePreloads(){
    $aRtn = array();
    foreach($this->aPlugins as $key=>$obj) { if($obj->getPreloadLang()) $aRtn[] = $key; }
    return (count($aRtn) > 0 ? $aRtn : false);
  } // end function getLanguagePreloads

  /* Gets triggers for disabled message of any disabled plugins that have the trigger set
  * @return array
  */
  function getDisabledTriggers(){
    $aRtn = array();
    foreach($this->aPlugins as $key=>$obj){
      if($obj->getStatus() === false && (($aTD = $obj->getTriggerDisabled()) !== false)) {
        foreach($aTD as $v){ $aRtn[] = $v; }
      }
    }
    return $aRtn;
  } // end function getDisabledTrigger

  /* Throw main plugins form
  * @return string HTML
  */
  function getPluginFormHtml(){
    global $config, $tpl, $aPlugin;
    $aPlugin = array();
    // pluginManager is special case..
    $aPlugin['name'] = 'pluginManager';
    $aPlugin['version'] = $this->aPlugins[$aPlugin['name']]->getVersion();
    $aPlugin['config'] = $this->aPlugins[$aPlugin['name']]->getConfigExists() ? $tpl->tbHtml($this->sTemplate, 'PLUGINS_FORM_LINK_CONFIG') : '&nbsp;';
    $rtn = $tpl->tbHtml($this->sTemplate, 'PLUGINS_FORM_HEAD');
    $i = 0;
		foreach ($this->aPlugins as $key=>$obj) {
      if(!$obj->getIgnore()){
        $aPlugin['name'] = $key;
        $aPlugin['iStyle'] = ($i % 2);
        if(($aPlugin['badVersion'] = $obj->getVersionMismatch())!==false){
          $aPlugin['rowColor'] = $tpl->tbHtml($this->sTemplate, 'PLUGINS_FORM_PROBLEM');
          $aPlugin['message'] = $tpl->tbHtml($this->sTemplate, 'PLUGINS_FORM_BAD_VERSION');
          $aPlugin['config'] = $obj->getConfigExists() ? $tpl->tbHtml($this->sTemplate, ($config['bPM_versionChecking']?'PLUGINS_FORM_NO_LINK_CONFIG':'PLUGINS_FORM_LINK_CONFIG')) : '';
        }else{
          $aPlugin['message'] = $aPlugin['rowColor'] = '';
          $aPlugin['config'] = $obj->getConfigExists() ? $tpl->tbHtml($this->sTemplate, 'PLUGINS_FORM_LINK_CONFIG') : '';
        }
        $aPlugin['version'] = (($vsn = $obj->getVersion()) == '') ? '&nbsp;' : $vsn;
        $aPlugin['on'] = $this->_throwPluginRadio($obj->getStatus(),'true');
        $aPlugin['off'] = $this->_throwPluginRadio(!$obj->getStatus(),'false');
        $aPlugin['about'] = $obj->getAboutExists() ? $tpl->tbHtml($this->sTemplate, 'PLUGINS_FORM_LINK_ABOUT') : '&nbsp;';
        $aPlugin['tooltip'] = $obj->getSetupInfoHtml();
        $rtn .= $tpl->tbHtml($this->sTemplate, 'PLUGINS_FORM_LIST');
        $i++;
      }
    }
		$rtn .= $tpl->tbHtml($this->sTemplate, 'PLUGINS_FORM_FOOTER');
    return $rtn;
  } // end of function getPluginFormHtml

  /* Returns javascript for loading a stylesheet into the HEAD section
  * @param string stylesheet filename
  * @param string path to file (optional)
  * @return string javascript, including start and end SCRIPT tags
  */
  function loadStylesheet($sCSSin, $sPath=null){
    if($this && isset($this->aStylesheets[$sCSSin])){
      return $this->_stylesheetScript($this->aStylesheets[$sCSSin]);
    }else{
      $sCSS = basename($sCSSin); // just in case its not just a file name
      if(!$sPath){ // no path supplied so I'll do my best to find it ...
        if(basename($_SERVER['PHP_SELF']) == 'admin.php'){
          $sRelPath = $this->aThemes['pathAdmin'] . $sCSS;
          if(!file_exists($sRelPath)){
            $look = $GLOBALS['config']['dir_tpl'] . 'admin/' . $sCSS;
            if(file_exists($look)) $sRelPath = $look;
          }
        }else{
          $sRelPath = $this->aThemes['path'] . $sCSS;
          if(!file_exists($sRelPath)){
            $look = $GLOBALS['config']['dir_tpl'] . $sCSS;
            if(file_exists($look)) $sRelPath = $look;
          }
        }
      }else{
        $sRelPath = rtrim($sPath,'/') . '/' . $sCSS;
      }
      if($this){ $this->aStylesheets[$sCSSin] = $sRelPath; }
      return $this->_stylesheetScript($sRelPath);
    }
  } // end function loadStylesheet

  /* Returns HTML for loading all the stylesheets that the plugin manager knows about, and using FULL urls
  * @return string
  */
  function getAllStylesheets(){
    $rtn = '';
    foreach($this->aStylesheets as $path){
      if(strtolower(substr($path,0,4)) == 'http'){ $rtn .= $this->_stylesheetHTML($path); }
      else{ $rtn .= $this->_stylesheetHTML($this->getShopURL() . ltrim($path,'./')); } // trim both slashes and dots just in case someone tries to give a relative path beginning with './'
    }
    return $rtn;
  } // end function getAllStylesheets

  /* Gets an associative array of [modified theme folder name] => [theme folder name]
  * return array false if none
  */
  function getThemes($bAll=false){
    $rtn = array();
    foreach($this->aThemes['themes'] as $k=>$v){ if($bAll || count($v['css']) > 0) $rtn[$v['name']] = $k; }
    return (count($rtn) > 0 ? $rtn : false);
  } // end function getThemes
  
  /* Gets current theme path
  * @param boolean
  * @return string
  */
  function getThemePath($bAdmin=false){
    return ($bAdmin ? $this->aThemes['pathAdmin'] : $this->aThemes['path']);
  }

  /* Gets templates for current theme
  * @return array false if none
  */
  function getThemeTemplates(){
    return (count($this->aThemes['themes'][$GLOBALS['config']['theme']]['css']) > 0 ? $this->aThemes['themes'][$GLOBALS['config']['theme']]['css'] : false);
  }

  /* Checks versions. Formats: [=|==|<|<=|>|>=][v]digits[.digits[...]][+|=|-]. The leading comparator is optional; the 'v' preceding the digits is optional, as is the trailing comparator. If the leading comparator is missing then the trailing comparator is used. Trailing comparators equate as follows: '+' is '>=', '-' is '<=', '=' is '=='. If no comparator is supplied the default is '>='.
  * @param string
  * @param string optional version number to check against; uses QC version if none supplied
  * @return boolean
  */
  function checkVersion($compare, $version=null){
    if(!$version) $version = $GLOBALS['config']['version'];
    // Example $compare formats: 'v1.2+' (gte 1.2), '<=1.2' (lte 1.2), '>1' (gt 1), '=1.0' (eq 1), 'v2.0-' (lte 2.0), '0.3' (gte 0.3)
    // Any illegal $compare or $version format will return true
    if(preg_match('/^([=|<|>]{1}[=]?)?v?(\d+(?:\.\d+)*)([\+|=|-]?)$/', $compare, $mc) > 0 &&
       preg_match('/^[^\d]*(\d+(?:\.\d+)*)[^\d]*.*$/', $version, $mv) > 0){
      if($mc[1] == '='){ $mc[1] .= '='; }
      else if($mc[1] == ''){ $mc[1] = ($mc[3] == '-') ? '<=' : (($mc[3] == '=') ? '==' : '>='); }
      $com = explode('.', $mc[2]);
      $ver = explode('.', $mv[1]);
      $ct = max(count($com), count($ver));
      for($i=0;$i<$ct;$i++){
        if(!isset($com[$i]))                         $com[$i] = str_pad('',strlen($ver[$i]),'0',STR_PAD_LEFT);
        else if(!isset($ver[$i]))                    $ver[$i] = str_pad('',strlen($com[$i]),'0',STR_PAD_LEFT);
        else if(strlen($com[$i]) > strlen($ver[$i])) $ver[$i] = str_pad($ver[$i],strlen($com[$i]),'0',STR_PAD_LEFT);
        else                                         $com[$i] = str_pad($com[$i],strlen($ver[$i]),'0',STR_PAD_LEFT);
      }
      $scom = (int)implode('', $com); $sver = (int)implode('', $ver);
      eval('$res = ($sver '.$mc[1].' $scom);');
      return $res;
    }else{
      return true;
    }
  } // end function checkVersion

// SETTERS
  /* Override Shop URL
  * @param string
  * @return void
  */
  function setShopURL($sU){
    $this->sShopURL = $sU;
  } // end function setShopURL

  /* Set plugin manager template
  * @param string
  * @return void
  */
  function setTemplate($sT=null){
    if($sT) $this->sTemplate = $sT;
  } // end of function setTemplate

  /* Reload one plugin from setup.php, and save all
  * @param string plugin
  * @return void
  */
  function setResetPlugin($sP){
    if(isset($this->aPlugins[$sP])){
      $aS = $this->_loadFromSetup($sP);
      $aS['enabled'] = $this->aPlugins[$sP]->getStatus();
      $this->aPlugins[$sP]->setSetup($aS);
      $this->setPlugins();
      unset($aS);
    }
  } // end function setResetPlugin

  /* Writes out db/plugins.php file
  * @param array
  * @reutn boolean
  */
  function setPlugins($aP=null){
    if(!is_writable(DB_PLUGINS)) @chmod( DB_PLUGINS, 0644 );
    $bForm = true;
    if(!$aP){ $bForm = false; $aP = $this->getPluginStatusList(); }
    // there are no values we need to preserve so simply overwrite the existing file
    if(($file = fopen( DB_PLUGINS, 'wb' ))!==false){
      fwrite( $file, "<?php\n" );
      foreach( $aP as $k => $v ) {
        if($bForm) $this->aPlugins[$k]->setStatus( ($v=='true'?true:false) );
        $sWrite = $this->aPlugins[$k]->getSetupToSave();
        fwrite( $file, $sWrite, strlen($sWrite) );
      }
      fwrite( $file, "?>\n" );
      fclose( $file ); unset($file);
      return true;
    }else{
      return false;
    }
  } // end of function setPluginlist

/*********************/
/* Private Functions */
/*********************/
  /* Throws a radio input field
  * @param boolean enabled/disabled
  * @param string value
  * @return string
  */
  function _throwPluginRadio( $bTrueFalse, $sValue ) {
    global $config, $tpl, $aPlugin;
    $aPlugin['value'] = $sValue;
    $aPlugin['checked'] = $bTrueFalse ? "checked='checked'" : '';
    $aPlugin['disabled'] = ($aPlugin['badVersion']===false || !$config['bPM_versionChecking']) ? '' : "disabled='disabled'";
    return $tpl->tbHtml($this->sTemplate, 'PLUGINS_FORM_RADIO_BUTTON');
  } // end function _throwPluginRadio

  /* Builds internal list of plugins
  * @return void
  */
  function _buildPluginList(){
    global $config;

    // just in case the pluginManager config.php could not be found ...
    if( !isset($config['aPM_ignorePlugins']) || !is_array($config['aPM_ignorePlugins']) ){
      $config['aPM_ignorePlugins'] = array();
    }

    $tPlugins = array();
    // get the stored list of plugins and their status
    @include_once (DB_PLUGINS);
    if (isset($pluginManager)){ // if found, save contents and clear down the array from the file
      if(is_array($pluginManager)){
        // convert to array if necessary - this is for version upgrade from when $pluginManager[<plugin>] = bool(<status>) to
        // the new extended format of $pluginManager[<plugin>] = array(), where array() is associative collection of variables
        foreach($pluginManager as $k=>$v){
          if(is_bool($v)){
            $tPlugins[$k] = $this->_loadFromSetup($k);
            $tPlugins[$k]['enabled'] = $v;
          }else if(is_array($v)){
            $tPlugins[$k] = $this->_getSetupArray($v, true);
          }else{ // don't know what format its in so look for a setup.php file; and set to disabled!
            $tPlugins[$k] = $this->_loadFromSetup($k);
            $tPlugins[$k]['enabled'] = false;
          }
        }
      }
      unset($pluginManager);
    }
    // for each actual plugin folder found, make sure we have an entry in the list
    $aDirs = array();
    $folder = dir(DIR_PLUGINS);
   	while(false !== ($mydir = $folder->read())) { // loop through all items
      if (is_dir(DIR_PLUGINS.$mydir) && substr($mydir,0,1) != '.') {
        if (!isset($tPlugins[$mydir])) { $tPlugins[$mydir] = $this->_loadFromSetup($mydir); }
        $aDirs[] = $mydir;
		  }
		}
		$folder->close(); unset($folder);
    // now check that we have a folder for each plugin left in the list
    $clear = array();
    foreach($tPlugins as $k=>$v){ if(!in_array($k,$aDirs)){ $clear[] = $k; } }
    foreach($clear as $w){ unset($tPlugins[$w]); }
    unset($clear); unset($aDirs);
    // sort the list alphabetically by plugin name
		ksort($tPlugins);
		// set pluginManagerConfig object per plugin
		foreach($tPlugins as $k=>$v){
      $this->aPlugins[$k] = new pluginManagerConfig($k,$v,$this->sTemplate);
    }
    unset($tPlugins);
    // pluginManager itself MUST be enabled AND ignored
    $this->aPlugins[$this->sPM]->setStatus(true);
    $this->aPlugins[$this->sPM]->setIgnore(true);
  } // end of function _buildPluginList

  /* Reads a plugins setup.php file and returns a formatted setup array
  * @param string plugin
  * @return array
  */
  function _loadFromSetup($sP){
    if(isset($setup)) unset($setup);
    @include (DIR_PLUGINS."$sP/setup.php");
    if(isset($setup) && is_array($setup)){
      if(isset($setup['enabled'])) unset($setup['enabled']); // just in case anyone tries to enable from the setup file!
      $rtn = $this->_getSetupArray($setup);
    }else{
      $rtn = $this->_getSetupArray();
    }
    return $rtn;
  } // end function _loadFromSetup

  /* Returns an associative 'setup'a array with all elements filled as supplied, or with their defaults
  * @param array from a setup.php file
  * @param boolean checkVersion setting
  * @return array
  */
  function _getSetupArray($setup=null, $bCheckVersion=false){
    if(!$setup) $setup = array('enabled'=>false);
    $rtn = array(  'enabled'=>(isset($setup['enabled']) && is_bool($setup['enabled']) ? $setup['enabled'] : false)
                 , 'version'=>(isset($setup['version']) ? $setup['version'] : '')
                 , 'preloadLang'=>(isset($setup['preloadLang']) && is_int($setup['preloadLang']) && in_array($setup['preloadLang'],array(0,1,2)) ? $setup['preloadLang'] : 0)
                 , 'prerequisites'=>(isset($setup['prerequisites']) ? (is_array($setup['prerequisites'])?$setup['prerequisites']:array($setup['prerequisites'])) : array())
                 , 'plugins.php'=>(isset($setup['plugins.php']) ? (is_array($setup['plugins.php'])?$setup['plugins.php']:array($setup['plugins.php'])) : array())
                 , 'actions_client.php'=>(isset($setup['actions_client.php']) ? (is_array($setup['actions_client.php'])?$setup['actions_client.php']:array($setup['actions_client.php'])) : array())
                 , 'actions_admin.php'=>(isset($setup['actions_admin.php']) ? (is_array($setup['actions_admin.php'])?$setup['actions_admin.php']:array($setup['actions_admin.php'])) : array())
                 , 'checkVersion'=>$bCheckVersion
                 , 'triggerDisabled'=>(isset($setup['triggerDisabled']) ? (is_array($setup['triggerDisabled'])?$setup['triggerDisabled']:array($setup['triggerDisabled'])) : array())
                 );
     return $rtn;
  } // end function _getSetupArray

  /* Sets theme path, admin theme path, and available stylesheets within the theme
  * @return void
  */
  function _setThemes(){
    global $config;
    // set defaults ...
    $this->aThemes = array( 'path'=>$config['dir_tpl']
                          , 'pathAdmin'=>$config['dir_tpl'].'admin/'
                          , 'themes'=>array()
                          );
    // get available themes (themes folder cannot be 'admin', and theme cannot be 'default') ...
    $config['theme'] = trim($config['theme'],'/');
    $config['themesFolder'] = trim($config['themesFolder'],'/');
    if(isset($config['themesFolder']) && $config['themesFolder'] != '' && $config['themesFolder'] != 'admin'){
      $themedir = $config['dir_tpl'].rtrim($config['themesFolder'],'/').'/';
      if(is_dir($themedir)){
        $oDir = dir($themedir);
        while(($name = $oDir->read()) !== false){
          if(substr($name,0,1)!='.' && $name!='default' && is_dir($themedir.$name)){
            $theme = ucwords(str_replace('_', ' ', $name));
            $this->aThemes['themes'][$name] = array( 'name'=>$theme, 'css'=>$this->_listCSSfiles($themedir.$name));
          }
        }
        $oDir->close();
      }
    }
    if($config['theme'] != 'default'){ // if we're using default there's nothing else to do
      // set the paths if the theme is valid (valid = at least one css file) ...
      if(isset($this->aThemes['themes'][$config['theme']]) && count($this->aThemes['themes'][$config['theme']]['css']) > 0){
        $this->aThemes['path'] = $config['dir_tpl'].$config['themesFolder'].'/'.$config['theme'].'/';
        // admin stays set to default if theme/admin does not exist ...
        if(is_dir($this->aThemes['path'].'admin/')){ $this->aThemes['pathAdmin'] = $this->aThemes['path'].'admin/'; }
        // we found the theme but which css do we use
        if(!in_array($config['template'], $this->aThemes['themes'][$config['theme']]['css'])){ // we haven't got the currently set one ...
          if(in_array('default.css', $this->aThemes['themes'][$config['theme']]['css'])){ // we have a default.css so use that
            $config['template'] = 'default.css';
          }else{ // use the first one found
            $config['template'] = $this->aThemes['themes'][$config['theme']]['css'][0];
          }
        }
      }else{ // we coudn't find the theme we were looking for, so reset to 'default'; we only need to set the name because the paths and stylesheets will be from default anyway
        $config['theme'] = 'default';
      }
    }
    $this->aThemes['themes']['default'] = array('name'=>'Default', 'css'=>$this->_listCSSfiles($config['dir_tpl']));
    $config['dir_theme'] = $this->aThemes['path'];
  } // end function _setThemes
  
  /* Sets the available stylesheets
  * @return array
  */
  function _listCSSfiles($path){
    $rtn = array();
    $oDir = dir($path);
    while(($sFile = $oDir->read()) !== false){
      if( is_file( $path.$sFile ) && substr($sFile,-4) == '.css' )
        // don't include stylesheets that match the name of a plugin!
        if(!isset($this->aPlugins[substr($sFile,0,-4)])){ $rtn[] = $sFile; }
    }
    $oDir->close();
    return $rtn;
  } // end function _listCSSfiles

  /* return javascript for loading script link into HEAD
  * @param string
  * @return string
  */
  function _stylesheetScript($path){
    $rtn  = "<script type='text/javascript'>\n<!--\n";
    $rtn .= "var link = document.createElement('link');\n";
    $rtn .= "link.setAttribute('href', '$path');\n";
    $rtn .= "link.setAttribute('rel', 'stylesheet');\n";
    $rtn .= "link.setAttribute('type', 'text/css');\n";
    $rtn .= "var head = document.getElementsByTagName('head').item(0);\n";
    $rtn .= "head.appendChild(link);\n";
    $rtn .= "//-->\n</script>\n";
    return $rtn;
  } // end function _stylesheetScript

  /* return HTML for loading script link into HEAD
  * @param string
  * @return string
  */
  function _stylesheetHTML($path){
    $rtn  = "<link type='text/css' rel='stylesheet' href='$path' />\n";
    return $rtn;
  } // end function _stylesheetHTML
} // end of class PluginManager

$oPlugMan = new PluginManager();
?>
