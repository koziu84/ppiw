<?php
/*
* pluginManagerConfig.class.php
* Wizzud: 17/10/05
*/
class pluginManagerConfig {
  var $sName;                      // plugin name (ie. its folder under the plugins/ dir)
  var $bStatus;                    // enabled/disabled
  var $sVersion;                   // plugin version (from setup.php or config/plugins.php)
  var $versionMismatch = false;    // discrepancy between versions in config/plugins.php and this plugin's setup.php; holds false, or the discrepant version
  var $sTemplate;                  // template file
  var $bConfigExists = false;      // config exists?
  var $bConfigWritable = false;    // config writable?
  var $bAboutExists = false;       // AboutThisPlugin.html exists?
  var $bIgnore = false;            // whether or not the plugin should be ignored for listing
  var $aC = array();               // associative array of all the relevant config variables and their specified settings
  var $sCheckForm;                 // if field validation specified = "onsubmit='return checkForm( this,  Array(......) );'"
  var $aRequire = array();         // associative array of arrays; level 1 : 'plugins.php' 'actions_client.php' 'actions_admin.php' (from setup.php or config/plugins.php)
  var $iPreloadLang;               // 0=no, 1=if enabled, 2=always (from setup.php or config/plugins.php)
  var $aPrerequisite = array();    // array of specified prerequisites for this plugin to function correctly (from setup.php or config/plugins.php)
  var $aTriggerDisabled = array(); // array of $p settings from setup.php requiring an intercept error message if plugin is disabled

  // @params: string, array, string
  function pluginManagerConfig($name,$setup,$template){ // constructor
    global $config;

    $this->sName = $name;
    $this->_loadSetup($setup);
    $this->sTemplate = $template;
    $this->bIgnore = in_array($name, $config['aPM_ignorePlugins']);
    $this->sCheckForm = '';
    $this->_checkConfig();
    $this->bAboutExists = file_exists(DIR_PLUGINS."{$this->sName}/AboutThisPlugin.html");
  } // end of constructor
/*
* Public Functions
*/
  function getAboutExists(){
    return $this->bAboutExists;
  } // end of function getAboutExists
  function getConfigWritable(){
    $this->_checkConfig();
    return $this->bConfigWritable;
  } // end of function getConfigWritable
  function getConfigExists(){
    $this->_checkConfig();
    return $this->bConfigExists;
  } // end of function getConfigExists
  function getIgnore(){
    return $this->bIgnore;  // boolean
  } // end of function getIgnore
  function getRequiredFiles($sF){
    return (!$this->getIgnore() && $this->getStatus() && isset($this->aRequire[$sF]) ? $this->aRequire[$sF] : array());
  } // end of function getRequiredFiles
  function getStatus(){
    return $this->bStatus; // boolean
  } // end of function getStatus
  function getVersion(){
    return $this->sVersion; // string
  } // end function getVersion
  function getTriggerDisabled(){
    return (count($this->aTriggerDisabled) > 0 ? $this->aTriggerDisabled : false); // array or false
  } // end of function getTriggerDisabled
  function getVersionMismatch(){
    return $this->versionMismatch; // false or string
  } // end function getVersionMismatch
  function getPreloadLang(){
    return ($this->iPreloadLang == 2 || ($this->getStatus() && $this->iPreloadLang == 1));
  } // end function getPreloadLang
  function getSetupToSave(){
    $rtn  = "\$pluginManager['{$this->sName}']=array( 'enabled'=>".($this->getStatus()?'true':'false').", 'version'=>'".$this->getVersion()."', ";
    foreach($this->aRequire as $k=>$v){
      $rtn .= "'$k'=>array(";
      for($i=0;$i<count($v);$i++){ $rtn .= "'{$v[$i]}', "; }
      $rtn = rtrim($rtn,', ') . "), ";
    }
    $rtn .= "'prerequisites'=>array(";
    for($i=0;$i<count($this->aPrerequisite);$i++){ $rtn .= "'{$this->aPrerequisite[$i]}', "; }
    $rtn = rtrim($rtn,', ') . "), 'preloadLang'=>{$this->iPreloadLang}, 'triggerDisabled'=>array(";
    for($i=0;$i<count($this->aTriggerDisabled);$i++){ $rtn .= "'{$this->aTriggerDisabled[$i]}', "; }
    $rtn = rtrim($rtn,', ') . ") );\n";
    return $rtn;
  } // end getSetupToSave
  function getSetupInfoHtml(){
    global $tpl, $lang, $aPluginInfo;
    $aPluginInfo['name'] = $this->sName;
    $aPluginInfo['version'] = $this->getVersion();
    $aPluginInfo['prerequisites'] = count($this->aPrerequisite)==0 ? '&nbsp;' : implode('<br />',$this->aPrerequisite);
    $aPluginInfo['includes'] = '';
    foreach($this->aRequire as $k=>$v){
      $aPluginInfo['file'] = $k;
      $aPluginInfo['list'] = count($v)==0 ? '&nbsp;' : implode('<br />',$v);
      $aPluginInfo['includes'] .= $tpl->tbHtml( $this->sTemplate, 'PLUGINS_FORM_TOOLTIP_INCL' );
    }
    switch($this->iPreloadLang){
      case 0: $aPluginInfo['preloadLang'] = LANG_NO_SHORT; break;
      case 1: $aPluginInfo['preloadLang'] = $lang['PMwhenEnabled']; break;
      case 2: $aPluginInfo['preloadLang'] = $lang['PMalways']; break;
    }
    return $tpl->tbToolTip( $this->sTemplate, 'PLUGINS_FORM_TOOLTIP' );
  } // end function getSetupInfoHtml
  function getConfigFormHtml(){
    global $tpl, $aPMConfig;
    if(!isset($aPMConfig) || !is_array($aPMConfig)) $aPMConfig = array();
    $content = ''; $bToSave = false;
    foreach($this->aC as $n=>$aV){
      if(!$aV['hide']){
        if(!$aV['disable'] && !$bToSave) $bToSave = true; // this means there's at least 1 saveable field
        $aPMConfig['sName'] = $aV['sName'];
        $aPMConfig['sVersion'] = $this->getVersion();
        $aPMConfig['sFormat'] = $aV['sFormat'];
        $aPMConfig['sConfig'] = $aV['sConfig'];
        $aPMConfig['sConfigTip'] = "config['".preg_replace('/,/', "']['", $aV['sConfig'])."']";
        $aPMConfig['sFormatTip'] = $this->_expandFormat($aV['sFormat']);
        $aPMConfig['sText'] = $aV['sText'];
        $aPMConfig['sField'] = $this->_setInputField($n);
        $aPMConfig['sTooltip'] = $tpl->tbToolTip($this->sTemplate, 'PLUGINS_CONFIG_LIST_TOOLTIP');
        $aPMConfig['sHint'] = $aV['sText']=='' ? '' : $tpl->tbHtml($this->sTemplate, 'PLUGINS_CONFIG_LIST_HINT');
        $aPMConfig['sHidden'] = $aV['disable']===true ? '' : $tpl->tbHtml($this->sTemplate, 'PLUGINS_CONFIG_LIST_HIDDEN');
        $content .= $tpl->tbHtml($this->sTemplate, 'PLUGINS_CONFIG_LIST');
      }
    }
    $aPMConfig['sCheckForm'] = $this->sCheckForm;
    $aPMConfig['sPlugin'] = $this->sName;
    $aPMConfig['sHelp'] = $tpl->tbToolTip($this->sTemplate, 'PLUGINS_CONFIG_HELP_TOOLTIP');
    $aPMConfig['sSave'] = $bToSave ? $tpl->tbHtml($this->sTemplate, ($this->getConfigWritable()?'PLUGINS_CONFIG_FOOTER_SAVE':'PLUGINS_CONFIG_FOOTER_NO_SAVE')) : '';
    return $tpl->tbHtml($this->sTemplate, 'PLUGINS_CONFIG_HEAD') . $content . $tpl->tbHtml($this->sTemplate, 'PLUGINS_CONFIG_FOOTER');
  } // end of function getConfigFormHtml

  function setIgnore($bI=true){
    $this->bIgnore = is_bool($bI) ? $bI : true;
  } // end of function setIgnore
  function setStatus($bS=false){
    $this->bStatus = is_bool($bS) ? $bS : false;
  } // end of function setStatus
  function setVersion($sV=''){
    $this->sVersion = (string)$sV;
  } // end of function setVersion
  function setPreloadLang($iPL=true){
    $this->iPreloadLang = is_int($iPL) && in_array($iPL,array(0,1,2)) ? $iPL : 0;
  } // end function setPreloadLang
  function setTemplate($sT=null){
    if($sT) $this->sTemplate = $sT;
  } // end of function setTemplate
  function setTriggerDisabled($mTD=null){
    $this->aTriggerDisabled = array();
    if($mTD){
      if(is_string($mTD) && $mTD != '') { $this->aTriggerDisabled = array($mTD); }
      elseif(is_array($mTD)) { foreach($mTD as $v) { if(is_string($v) && $v != '') $this->aTriggerDisabled[] = $v; } }
    }
  } // end function setTriggerDisabled
  function setPrerequisites($mP=null){
    $this->aPrerequisite = array();
    if($mP){
      if(is_string($mP) && $mP != '') { $this->aPrerequisite = array($mP); }
      elseif(is_array($mP)) { foreach($mP as $v) { if(is_string($v) && $v != '') $this->aPrerequisite[] = $v; } }
    }
  } // end function setPrerequisites
  function setSetup($aS){
    $this->_loadSetup($aS);
  } // end function setSetup
  function setPluginConfig($aF){
    $ccount = isset($aF['sConfig']) ? count($aF['sConfig']) : 0;
    if($ccount==0 || !$this->getConfigWritable()) return false; // there's either nothing to write, or we couldn't write it anyway
    $this->aC = array();
    if(($sCfg = file_get_contents( DIR_PLUGINS."{$this->sName}/config.php" )) === false) return false; // can't read the current contents
    for($i=0;$i<$ccount;$i++){ // for each config variable in the form set up the true config variable
      $aExp = explode(',',$aF['sConfig'][$i]);
      $name = implode('__',$aExp);
      $this->aC[$name] = array();
      $this->aC[$name]['cfg'] = "\$config['{$aExp[0]}']" . ( isset($aExp[1]) ? "['{$aExp[1]}']" : '') . ' = ';
      $this->aC[$name]['fmt'] = $aF['sFormat'][$i];
      $this->aC[$name]['val'] = isset($aF[$name]) ? ( (is_array($aF[$name])) ? implode(',',$aF[$name]) : $aF[$name] ) : '';
      // format the value according to the format setting
      $this->aC[$name]['valX'] = $this->_setValue($name);
    }
    $block = $line = array(); unset($aExp);
    // find, store, then remove, the block comments
    if(preg_match_all('@\/\*.*\*\/@sUm',$sCfg,$block)>0) { $sCfg = preg_replace('@\/\*.*\*\/@sUm','{!blockComment!}',$sCfg); }
    // find, store, then remove, the line comments
    if(preg_match_all('@[\n|\r]\s*\/\/.*[\n|\r]@U',$sCfg,$line)>0) { $sCfg = preg_replace('@[\n|\r]\s*\/\/.*[\n|\r]@U','{!lineComment!}',$sCfg); }
    // now find all the valid $config variables defined in the destination file
    if(preg_match_all('/(\$config\[\s*[\'|"]{1}\w+[\'|"]{1}\s*\](?:\[\s*[\'|"]{1}\w+[\'|"]{1}\s*\])?\s*=)(.*);/sUm', $sCfg, $m)>0){
      $mcount = count($m[1]); $n = array();
      // for each $config variable found clear out surplus spaces and set double quotes to single so we can match up accurately
      for($i=0;$i<$mcount;$i++) { $n[$i] = preg_replace(array('/"/','/\s*([\[|\]])\s*/','/\s*=\s*/'),array('\'','$1',' = '),$m[1][$i]); }
      $pat = $rep = array();
      // for each variable in our form find its corresponding definition from the destination file - including the value
      foreach($this->aC as $name=>$aV){
        for($i=0;$i<$mcount;$i++){
          if($aV['cfg'] == $n[$i]){
            $pat[] = $m[0][$i];
            $rep[] = $aV['cfg'].stripslashes($aV['valX']);
          }
        }
      }
      // replace old with new
      $sCfg = str_replace($pat,$rep,$sCfg);
      unset($pat); unset($rep); unset($m); unset($n);
      // put the comments back ...
      for($i=0;$i<count($block[0]);$i++) { $sCfg = preg_replace('/\{!blockComment!\}/',$block[0][$i],$sCfg,1); }
      for($i=0;$i<count($line[0]);$i++)  { $sCfg = preg_replace('/\{!lineComment!\}/',$line[0][$i],$sCfg,1); }
      unset($block); unset($line);
      // write out the file ...
      if(($rFile = fopen( DIR_PLUGINS."{$this->sName}/config.php", 'wb' )) !== false){
        fwrite( $rFile, $sCfg, strlen($sCfg) );
        fclose( $rFile ); unset($rFile); unset($sCfg);
        return true; // succesful save!
      }
    }
    return false; // either we failed to write the file out, or we couldn't find any '$config' declarations in the target file
  } // end of function setPluginConfig
  function loadConfig(){
    global $config, $lang, $PMCI;
    if(!isset($aPMConfig) || !is_array($aPMConfig)) $aPMConfig = array();
    $this->aC = $check = array();
    $mcount = 0;
    if(($tCfg = file_get_contents( DIR_PLUGINS."{$this->sName}/config.php" )) !== false){
      // get rid of comments
      $tCfg = preg_replace(array('@\/\*.*\*\/@sUm','@[\n|\r]\s*\/\/.*([\n|\r])@U'),array('','$1'),$tCfg);
      if(preg_match_all('/\$config\[\s*[\'|"]{1}(\w+)[\'|"]{1}\s*\](?:\[\s*[\'|"]{1}(\w+)[\'|"]{1}\s*\])?\s*=(.*);/sUm', $tCfg, $m)>0){
        $mcount = count($m[1]);
      }
      unset($tCfg);
    }
    for($i=0;$i<$mcount;$i++){
      // got 1 or more matches...
      $inst = array();
      $name = rtrim($m[1][$i].'__'.$m[2][$i], '_'); // use double underbar to join array keys
      $this->aC[$name] = array(); // sFid = $name
      $this->aC[$name]['sConfig'] = rtrim($m[1][$i].','.$m[2][$i], ','); // this is how you later identify the config variable when the form is POSTed back
      if($m[2][$i]!=''){ // ie. $config['levelOne']['levelTwo'] = ...
        if(isset($PMCI[$m[1][$i]][$m[2][$i]]) && is_array($PMCI[$m[1][$i]][$m[2][$i]])) { $inst = $PMCI[$m[1][$i]][$m[2][$i]]; }
        $tempconfig = $config[$m[1][$i]][$m[2][$i]]; // the current setting of the config variable
      }else{ // ie. $config['levelOne'] = ...
        if(isset($PMCI[$m[1][$i]]) && is_array($PMCI[$m[1][$i]])) { $inst = $PMCI[$m[1][$i]]; }
        $tempconfig = $config[$m[1][$i]]; // the current setting of the config variable
      }
      $exactconfig = trim($m[3][$i]); // the value of the config variable as typed in the file
      $this->aC[$name]['hide'] = (isset($inst['hide']) && $inst['hide']===true) ? true : false;
      if(!$this->aC[$name]['hide']){
        if(isset($lang['PMCI'][$name]) && is_array($lang['PMCI'][$name])) { // use instructions from language file only if config instructions aren't available
          foreach($lang['PMCI'][$name] as $k=>$v){ if(!isset($inst[$k])) $inst[$k] = $v; }
        }
        $this->aC[$name]['disable'] = (isset($inst['disable']) && $inst['disable']===true) ? true : false; // value can't be modified
        $this->aC[$name]['sName'] = isset($inst['name']) ? $inst['name'] : $name ; // this is the text descriptor of the field
        $this->aC[$name]['alt'] = isset($inst['alt']) ? $inst['alt'] : $name ; // this is the alt and title attributes for the field
        $this->aC[$name]['sText'] = isset($inst['text']) ? $inst['text'] : ($this->aC[$name]['disable'] ? $lang['PMunmodifiable'] : '' ); // this is the 'hint' text for the field
        if(!$this->aC[$name]['disable'] && isset($inst['check'])) { // these are the parts of the call to checkForm
          if(is_array($inst['check'])) {
            $t = 'Array("'.$name.'"';
            foreach($inst['check'] as $cv) { $t .= ', "'.$cv.'"'; }
            $check[] = $t.')';
          }else{
            $check[] = 'Array("'.$name.'", "'.$inst['check'].'")';
          }
        }
        $this->aC[$name]['sFormat'] = $this->_checkFormat($tempconfig,(isset($inst['format'])?$inst['format']:null)); // this gives some indication of the structure of the config variable
        $this->aC[$name]['type'] = isset($inst['type']) ? $inst['type'] : ( $this->aC[$name]['sFormat']=='b' ? 'checkbox' : 'input' ); // this is the type of field for capture of the config value
        $this->aC[$name]['value'] = $this->_getValue($this->aC[$name]['sFormat'],$tempconfig,$exactconfig); // this is the current value of the config variable
        $this->_checkType($name);
      }
      unset($inst);
    }
    $ccount = count($check);
    if($ccount>0){
      $this->sCheckForm = "onsubmit='return checkForm( this,  Array(";
      for($i=0;$i<$ccount;$i++){ $this->sCheckForm .= $check[$i].','; }
      $this->sCheckForm = rtrim($this->sCheckForm,',')."));'";
    }
    unset($check); unset($m); unset($tempconfig); unset($exactconfig);
  } // end of function loadConfig

/*
* Private Functions
*/
  function _checkConfig(){
    $this->bConfigExists = file_exists(DIR_PLUGINS."{$this->sName}/config.php");
    if(!$this->bConfigExists){
      $this->bConfigWritable = false;
    }else if(is_writable(DIR_PLUGINS."{$this->sName}/config.php")){
      $this->bConfigWritable = true;
    }else{
      @chmod(DIR_PLUGINS."{$this->sName}/config.php",0644);
      if(is_writable(DIR_PLUGINS."{$this->sName}/config.php")){
        $this->bConfigWritable = true;
      }else{
        $this->bConfigWritable = false;
      }
    }
  } // end of function _checkConfig

  function _getValue($fmt,$tc,$act){
    if($fmt=='e'){
      return $act;
    }else if($fmt=='a(e)'){
      if(preg_match('/^array\s*\((.*)\)$/sUm',$act,$a)>0){
        return preg_replace(array('/\t/','/(\n\r?)\s*/'),array(' ','\1'),trim($a[1]));
      }else{
        return '';
      }
    }else if(preg_match('/^a\((.*)\)$/',$fmt,$a)>0){
      $a[1] = preg_replace(array('/(s|b|n)(\*)/e','/(s|b|n)(\d)/e','/,,/','/,$/'),
                           array('str_repeat("\1,",count($tc))','str_repeat("\1,",\2)',',',''),$a[1]);
      $exp = explode(',',$a[1]);
      $i=0; $rtn = '';
      while($i<count($exp) && $i<count($tc)){
        $rtn .= $this->_getValue($exp[$i],$tc[$i],'').', ';
        $i++;
      }
      return rtrim($rtn,', ');
    }else if($fmt == 'b'){
      return (($tc===true)?'true':'false');
    }else if($fmt=='n'){
      return $tc;
    }else{
      return $tc;
    }
  } // end of function _getValue

  function _setValue($n){
    $rtn = '';
    if(preg_match('/^(a|s|b|n|e)(?:\(([s|b|n|e])(.*)\))?$/',$this->aC[$n]['fmt'],$part)==0) { $part=array($this->aC[$n]['fmt'],'e'); }
    if($part[1]=='a'){ // its an array...
      if(!isset($part[2]) || $part[2]=='e'){ // exact format...
        $rtn = 'array('.$this->aC[$n]['val'].');';
      }else{
        $vX = explode(',',$this->aC[$n]['val']);
        if($part[3] == '*') { $ff = preg_split('//',str_repeat($part[2],count($vX)),-1,PREG_SPLIT_NO_EMPTY); } // all parts have the same format...
        else                { $ff = explode(',',$part[2].$part[3]); }
        // we now have an array of formats, but we need to fully expand all elements to cope with fixed no. of elements
        // eg. s4,b2,n3,etc
        $ff_exp = array();
        foreach($ff as $el){
          if(preg_match('/^([s|b|n|e])([\d]+)$/',$el,$expand) > 0){ for($i=0;$i<$expand[2]; $ff_exp[]=$expand[1], $i++); }
          else{ $ff_exp[] = $el; } }
        $ff = $ff_exp; unset($ff_exp);
        // at this point we have an array of formats and an array of parts...
        // however, if $ff is empty we have a special case (unset checkboxes? missing numbers?)
        if(count($ff)==0){
          if($part[2]=='b')      { $rtn .= 'false'; }
          else if($part[2]=='n') { $rtn .= '0'; }
          else                   { $rtn .= "''"; }
        }else{
          // if its a string, trim and quote it, otherwise just tag it on the end...
          for($j=0;$j<count($ff);$j++) { $rtn .= ($ff[$j]=='s') ? "'".trim($vX[$j])."', " : $vX[$j].', '; }
        }
        $rtn = 'array('.rtrim($rtn,', ').');'; // surround it with 'array(...);'
      }
    } // end of array handling
    else if($part[1]=='s') { $rtn = "'".trim($this->aC[$n]['val'])."';"; }
    else if($part[1]=='b') { $rtn = ($this->aC[$n]['val']=='') ? 'false;' : $this->aC[$n]['val'].';'; }
    else if($part[1]=='n') { $rtn = ($this->aC[$n]['val']=='') ? '0;' : $this->aC[$n]['val'].';'; }
    else                   { $rtn = ($this->aC[$n]['val']=='') ? "'';" : $this->aC[$n]['val'].';'; }
    return $rtn;
  } // end of function _setValue

  function _checkFormat($v,$f){
    if(is_array($v)){
      if($f=='a'){ return 'a(e)'; }
      else if(!$f){
        $s = array();
        foreach($v as $ve){ $s[] = $this->_checkFormat($ve,'a'); }
        if(in_array('a(e)',$s)){ return 'a(e)'; }
        else{
          $same=true; for($k=1;$k<count($s);$k++){ if($s[$k]!=$s[$k-1]) $same=false; }
          if($same){ return 'a('.$s[0].count($s).')'; }
          else{ return 'a('.implode(',',$s).')'; }
        } }
      else if(preg_match('/^a\(.*\)$/',$f)>0){ return $f; }
      else{ return "a($f)"; } }
    else if($f && $f!='a'){ return $f; }
    else if(is_string($v)){ return 's'; }
    else if(is_bool($v)){ return 'b'; }
    else{ return 'n'; }
  } // end function _checkFormat

  function _checkType($n){
    $default = ( $this->aC[$n]['sFormat']=='b' ) ? 'checkbox' : 'input';
    if(preg_match('/^([^\(]+)(\([^\)]*\))?$/',$this->aC[$n]['type'],$m)>0){
      $p = isset($m[2]) ? explode(',',trim($m[2],'( )')) : array();
      for($i=0;$i<count($p);$i++){ $p[$i] = explode('=',trim($p[$i])); }
      // special case for 'exact' format - must be a textarea
      if($m[1]!='textarea' && strpos($this->aC[$n]['sFormat'],'e')!==false) $this->aC[$n]['type']='textarea';
      else switch($m[1]){
        case 'input': // can be just 'input', or with a bracketed number
          if(isset($m[2]) && (count($p)>1 || preg_match('/^[1-9]{1}[0-9]*$/',$p[0][0])==0)) $this->aC[$n]['type'] = $default;
          break;
        case 'radio': // n/a for arrays; must have labels and at least 2 values
          if(substr($this->aC[$n]['sFormat'],0,1)=='a' || count($p)<2){ $this->aC[$n]['type'] = $default; }
          else{
            $bT = true;
            for($i=0;$i<count($p);$i++){ if($p[$i][0]=='' || !isset($p[$i][1]) || $p[$i][1]=='') $bT=false; }
            if(!$bT) $this->aC[$n]['type'] = $default;
          }
        case 'select': // n/a for arrays; must have at least 1 value
          if(substr($this->aC[$n]['sFormat'],0,1)=='a' || count($p)<1){ $this->aC[$n]['type'] = $default; }
          break;
        case 'checkbox': // can be empty for boolean or number; single checkbox does not need label, but string arrays do
          if(!isset($m[2]) || (count($p)<2 && ($p[0][0]=='' || (isset($p[0][1]) && $p[0][1]=='')))){
            if($this->aC[$n]['sFormat'] = 'b') $this->aC[$n]['type'] = 'checkbox(true)';
            else if($this->aC[$n]['sFormat'] = 'n') $this->aC[$n]['type'] = 'checkbox(1)';
            else $this->aC[$n]['type'] = $default;
          }else if(($this->aC[$n]['sFormat']=='b' || $this->aC[$n]['sFormat']=='n') && count($p)>1){ $this->aC[$n]['type'] = $default; }
          else if(substr($this->aC[$n]['sFormat'],0,1)=='a' && count($p)<2){ $this->aC[$n]['type'] = $default; }
          else if(count($p)>1){
            $bT = true;
            for($i=0;$i<count($p);$i++){ if($p[$i][0]=='' || !isset($p[$i][1]) || $p[$i][1]=='') $bT=false; }
            if(!$bT) $this->aC[$n]['type'] = $default;
          }
          break;
        case 'textarea': // can be emtpy; not applicable for boolean or number
          if($this->aC[$n]['sFormat']=='b' || $this->aC[$n]['sFormat']=='n'){ $this->aC[$n]['type'] = $default; }
          else if(isset($m[2]) && preg_match('/^[1-9]{1}[0-9]*\s*,\s*[1-9]{1}[0-9]*$/',trim($m[2],'( )'))==0){
            $this->aC[$n]['type'] = 'textarea';
          }
          break;
        default:
          $this->aC[$n]['type'] = $default;
      }
    }else{
      $this->aC[$n]['type'] = $default;
    }
    // for checkboxes the value needs to be an array...
    if(substr($this->aC[$n]['type'],0,8)=='checkbox') $this->aC[$n]['value'] = preg_split('/,[ ]?/',$this->aC[$n]['value'],-1,PREG_SPLIT_NO_EMPTY);
  } // end of function _checkType

  function _setInputField($n){
    global $tpl, $aPMConfig;
    
    $rtn = $t = '';
    $p = array();
    if(preg_match('/^([^\(]+)(\([^\)]*\))?$/',$this->aC[$n]['type'],$m)>0){
      $t = $m[1]; $p = isset($m[2]) ? explode(',',trim($m[2],'( )')) : array();
    }
    for($i=0;$i<count($p);$i++){ $p[$i] = explode('=',trim($p[$i])); if(!isset($p[$i][1])) $p[$i][1]=''; }
    $aPMConfig['sFid'] = $n;
    $aPMConfig['sAlt'] = $this->aC[$n]['alt'];
    $aPMConfig['sDisabled'] = ($this->aC[$n]['disable']===true) ? "disabled='disabled'" : '';
    switch($t){
      case 'checkbox':
        $aPMConfig['sFid'] .= "[]";
        for($i=0;$i<count($p);$i++){
          $aPMConfig['sLabel'] = $p[$i][1];
          $aPMConfig['sValue'] = $p[$i][0];
          $aPMConfig['sPicked'] = in_array( $p[$i][0], $this->aC[$n]['value'] ) ? "checked='checked'" : '';
          $rtn .= $tpl->tbHtml( $this->sTemplate, 'PLUGINS_CONFIG_CHECKBOX' );
        }
        break;
      case 'radio':
        for($i=0;$i<count($p);$i++){
          $aPMConfig['sLabel'] = $p[$i][1];
          $aPMConfig['sValue'] = $p[$i][0];
          $aPMConfig['sPicked'] = $p[$i][0] == $this->aC[$n]['value'] ? "checked='checked'" : '';
          $rtn .= $tpl->tbHtml( $this->sTemplate, 'PLUGINS_CONFIG_RADIO' );
        }
        break;
      case 'select':
        $rtn .= $tpl->tbHtml( $this->sTemplate, 'PLUGINS_CONFIG_SELECT_START' );
        for($i=0;$i<count($p);$i++){
          $aPMConfig['sLabel'] = $p[$i][1] != '' ? $p[$i][1] : $p[$i][0];
          $aPMConfig['sValue'] = $p[$i][0];
          $aPMConfig['sPicked'] = $p[$i][0] == $this->aC[$n]['value'] ? "selected='selected'" : '';
          $rtn .= $tpl->tbHtml( $this->sTemplate, 'PLUGINS_CONFIG_SELECT_OPTION' );
        }
        $rtn .= $tpl->tbHtml( $this->sTemplate, 'PLUGINS_CONFIG_SELECT_END' );
        break;
      case 'textarea':
        $aPMConfig['sRows'] = isset($p[0][0]) ? $p[0][0] : 4;
        $aPMConfig['sCols'] = isset($p[1][0]) ? $p[1][0] : 40;
        $aPMConfig['sValue'] = htmlspecialchars($this->aC[$n]['value']);
        $rtn .= $tpl->tbHtml( $this->sTemplate, 'PLUGINS_CONFIG_TEXTAREA' );
        break;
      case 'input':
      default:
        $aPMConfig['sSize'] = isset($p[0][0]) ? $p[0][0] : 50;
        $aPMConfig['sValue'] = htmlspecialchars($this->aC[$n]['value']);
        $rtn .= $tpl->tbHtml( $this->sTemplate, 'PLUGINS_CONFIG_INPUT' );
    }
    unset($m); unset($p); unset($t);
    return $rtn;
  } // end function _setInputField

  function _loadSetup($aSetup){
    $this->setStatus(isset($aSetup['enabled']) ? $aSetup['enabled'] : false);
    $this->setVersion(isset($aSetup['version']) ? $aSetup['version'] : '');
    $aT = array('plugins.php', 'actions_client.php', 'actions_admin.php');
    for($i=0;$i<count($aT);$i++){
      $this->aRequire[$aT[$i]] = array();
      if(isset($aSetup[$aT[$i]]) && is_array($aSetup[$aT[$i]]))
        { foreach($aSetup[$aT[$i]] as $v) { if(is_string($v) && $v != '') $this->aRequire[$aT[$i]][] = $v; } }
    }
    unset($aT);
    $this->setPreloadLang(isset($aSetup['preloadLang']) ? $aSetup['preloadLang'] : false);
    $this->setPrerequisites(isset($aSetup['prerequisites']) ? $aSetup['prerequisites'] : array());
    if(isset($aSetup['checkVersion']) && $aSetup['checkVersion']===true) $this->_setVersionMismatch();
    $this->setTriggerDisabled(isset($aSetup['triggerDisabled']) ? $aSetup['triggerDisabled'] : array());
  } // end of function _loadSetup
  
  function _setVersionMismatch(){
    global $config;
    // mismatched version only IF a setup.php file exists AND it has a different version than the one currently set
    if(isset($setup)) unset($setup);
    @include (DIR_PLUGINS."{$this->sName}/setup.php");
    $this->versionMismatch = (isset($setup['version']) && $setup['version']!=$this->getVersion()) ? $setup['version'] : false;
    if($this->versionMismatch!==false && $config['bPM_versionChecking']) $this->setStatus(false);
  } // end function _setVersionMismatch

  function _expandFormat($sF){
    global $lang;
    return strtolower( preg_replace( array( '/S/', '/N/', '/B/', '/E/', '/A/'),
                                     array( $lang['PMstringFormat'],
                                            $lang['PMnumberFormat'],
                                            $lang['PMbooleanFormat'],
                                            $lang['PMexactFormat'],
                                            $lang['PMarrayFormat'] ),
                                     strtoupper( $sF ) ) );
  } // end function _expandFormat

} // end of class pluginManagerConfig
?>
