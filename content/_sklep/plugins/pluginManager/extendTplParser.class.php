<?php
/*
* extendTplParser.class.php
* Wizzud: 28/10/05
*
* Whats in this file?
*   function extendedTplParser
*   class tplIntercept
*   class extendTplParser, extending TplParser
* Why?
*    The external function declaration - extendedTplParser() - and the tplIntercept class, have been placed in this file so that
*    all the functionality is in a single file should it be necessary to include somewhere other than from the pluginManager plugin.
*    Just "require_once (path-to-folder/extendTplParser.class.php);".
*
* The extendTplParser class extension effectively runs interference on the parent TplParser class. It allows you to intercept calls
* to the parser and substitute template files or blocks of your own. What this means is that if the QC code has a $tpl call with a
* hard-coded template file you can change that template file to one of your own when it gets called. For writing plugins, this is a boon
* because it can alleviate the need to get installers to edit code simply to change what template is called at a particular moment.
*
* New methods: newIntercept( Template [, Replacement Template [, Template Block, Replacement Template Block [, Run-Before Function [, Condition Function [, Append TPL ] ] ] ] ] )
*                          returning an array index to the stored intercept
*            : getThisIntercept( Array Index to Intercept )
*                          returning the intercept's settings and flags in an array; returns false if index not found
*            : getActiveIntercepts( )
*                          returning an array of arrays, each sub-array containing the same information as returned by getThisIntercept(); returns empty array if no intercepts found
*            : getInterceptCount()
*                          returning the number of intercepts currently held
*            : getActiveInterceptCount()
*                          returning the number of active intercepts currently held
*            : removeIntercept( Array Index to Intercept )
*            : thisIntercept( Array Index to Intercept )
*                          returning the actual tplIntercept object
* Example 1: $iIntercept = $tpl->newIntercept( 'orders_saved.tpl', 'my_orders_saved.tpl' ); // wherever the code calls a $tpl method with 'orders_saved.tpl', use 'my_orders_saved.tpl' instead
* Example 2: $iIntercept = $tpl->newIntercept( 'orders_delivery.tpl', 'orders_delivery.tpl', 'LIST_LIST', 'MY_LIST_LIST' ); // in orders_delivery.tpl there is a new block of code - MY_LIST_LIST - that should be used in place of the LIST_LIST block
* Example 3: $iIntercept = $tpl->newIntercept( 'orders_saved.tpl', '' ); // wherever the code calls a $tpl method with 'orders_saved.tpl', don't return or output anything!
* Example 4: $iIntercept = $tpl->newIntercept( 'orders_delivery.tpl', 'orders_delivery.tpl', 'LIST_HEAD', '' ); // similar to example 4, but only block the output when calling the LIST_HEAD block!
* Example 5: $iIntercept = $tpl->newIntercept( 'tpl_A.tpl', 'tpl_B.tpl', 'BLOCK_A', 'BLOCK_B', 'my_function', '' ); // call my_function() BEFORE actioning the intercept; my_function must exist at the time the intercept gets actioned, and cannot require parameters
* Example 6: $iIntercept = $tpl->newIntercept( 'tpl_A.tpl', 'tpl_B.tpl', 'BLOCK_A', 'BLOCK_B', 'my_function', 'my_condition' ); // before doing anything else (including calling my_function()), call my_condition() (no parameters!) and only continue applying the intercept if my_condition() returns true (boolean); anything else returned will cause the intercept to be ignored and the original tpl call to be performed
* Example 7: $iIntercept = $tpl->newIntercept( 'tpl_A.tpl', null, 'BLOCK_A', 'BLOCK_A', '', '', array('my_script.tpl', 'SCRIPT_A') ); // on any $tpl call for BLOCK_A in the tpl_A.tpl file, run it (ie. no interecpt) but immediately afterwards run another $tpl call for block SCRIPT_A from the file my_script.tpl. Note that $tpl calls appended in this manner are NOT re-parsed for intercepts!
*
* Precede all the examples above with 'if(extendedTplParser()) ...' and away you go!
*
* IMPORTANT: Because of where $tpl is set in the QC index.php file, you can only use the extended stuff in your actions_client/admin code,
* not in code that gets linked into plugins/plugins.php!
*
* The tplIntercept class has some public methods that allow you to modify intercepts. For example:
* Example 7: // this initiates a new intercept, making all tpl calls using 'orders_saved.tpl' use 'my_orders_saved.tpl' instead
*            $iIntercept = $tpl->newIntercept( 'orders_saved.tpl', 'my_orders_saved.tpl' );
*            // get the tplIntercept object
*            $oIntercept = $tpl->thisIntercept($iIntercept);
*            // use the tplIntercept object to modify the intercept ...
*            $oIntercept->setBlock( 'LIST_LIST', '' );                  // a call to $tpl->tbHtml('orders_saved.tpl', 'LIST_LIST') will be intercepted and blocked, ie. no output
*            $oIntercept->setBlock( 'LIST_LIST' );                      // the block and block replacement are both set to 'LIST_LIST', which means that a call to $tpl->tbHtml('orders_saved.tpl', 'LIST_LIST') will be intercepted and actioned as $tpl->tbHtml('my_orders_saved.tpl', 'LIST_LIST')
*            $oIntercept->setBlock( 'LIST_LIST', 'MY_LIST_LIST' );      // a call to $tpl->tbHtml('orders_saved.tpl', 'LIST_LIST') will be intercepted and actioned as $tpl->tbHtml('my_orders_saved.tpl', 'MY_LIST_LIST')
*            $oIntercept->setAppend( );                                 // removes an appended TPL call
*            $oIntercept->setAppend( 'specials.tpl', 'NEW_DIV' );       // added a TPL call to be run after, or appended to, the intercepted call
*            $oIntercept->setCondition( 'my_condition' );               // added a condition function call
*            $oIntercept->setCondition( '' );                           // removes the condition function call
*            $oIntercept->setRunBefore( 'my_runBefore' );               // added a run-before function call; NOTe that run-before functions get passed an associative array containing keys newFile, oldFile, newBlock and oldBlock, each of which has the relevant values for the tpl call in progress at the time
*            $oIntercept->setBlockReplacement( 'ANOTHER_LIST_LIST' );   // changes the block replacement (from 'MY_LIST_LIST') to 'ANOTHER_LIST_LIST' - note that the action block remains unchanged as 'LIST_LIST'
*            $oIntercept->setTemplateReplacement( '' );                 // clears the template replacement, which means that any template-only calls using 'orders_saved.tpl' (eg. $tpl->tHtml('orders_saved.tpl')) will be blocked ie. no output, but template-and-block calls will only be blocked if the block is 'LIST_LIST'
*            $oIntercept->setTemplateReplacement( 'orders_saved.tpl' ); // sets the template replacement to 'orders_saved.tpl' - which is now the same as the template - so that the effect of the intercept is to switch blocks from 'LIST_LIST' to 'ANOTHER_LIST_LIST' within the same 'orders_saved.tpl' template file
*            $oIntercept->setBlockReplacement( '' );                    // clears the block replacement, which means that any calls to $tpl->tbHtml('orders_saved.tpl', 'LIST_LIST') will be blocked ie. no output; template-only calls using 'orders_saved.tpl' are unaffected by the intercept
*            $aSettings = $oIntercept->getIntercept();                  // returns the same information as $tpl->getThisIntercept( $iIntercept ), namely ...
*            var_dump($aSettings);                                      // array(12) { ["template"]=>string(16) "orders_saved.tpl"
*                                                                                      ["templateReplacement"]=>string(18) "orders_saved.tpl"
*                                                                                      ["block"]=>string(0) "LIST_LIST"
*                                                                                      ["blockReplacement"]=>string(9) ""
*                                                                                      ["condition"]=>string(0) ""
*                                                                                      ["runBefore"]=>string(24) "my_runBefore"
*                                                                                      ["appendTpl"]=>array(2) { ["file"]=>string(12) "specials.tpl"
*                                                                                                                ["block"]=>string(7) "NEW_DIV" }
*                                                                                      ["bReplaceFile"]=>bool(false)
*                                                                                      ["bReplaceBlock"]=>bool(true)
*                                                                                      ["bBlockFile"]=>bool(false)
*                                                                                      ["bBlockBlock"]=>bool(true)
*                                                                                      ["bCondition"]=>bool(false)
*                                                                                      ["bRunBefore"]=>bool(true)
*                                                                                      ["bAppend"]=>bool(true) }
*
* Note: The extended class intercepts all 4 standard calls to the template parser (eg. the d[b]Html and t[b]Html methods).
* It also supplies 4 new methods which bypass the intercept functionality and call the equivalent parent tpl methods directly.
* This is so that plugins can write run-before functions that can call the template parser WITHOUT going through the intercept-checking
* functionality which is already in progress for the call that instigated the run-before code! Sounds confusing? Its not really; its
* simply providing some calls which won't be in the standard code, and can be used to circumvent the intercept checks. These calls
* are the original methods, prefixed with an 'x', ie. xd[b]Html and xt[b]Html, so to call a template block without checking for
* intercepts would be $tpl->xtbHtml( .., ..).
*/

if(!function_exists('extendedTplParser')){
  /**
  * Resets $tpl to use the extended class provided by pluginManager - if it hasn't already been, and if the extended class exists!
  * @return bool
  */
  function extendedTplParser(){
    global $tpl;
    if(!$tpl || strtolower(get_class($tpl)) != 'extendtplparser'){
      if(class_exists('extendTplParser')){
        $dir = (!$tpl) ? ( basename($_SERVER['PHP_SELF']) == 'admin.php' ? $GLOBALS['config']['dir_tpl'].'admin/' : $GLOBALS['config']['dir_tpl'] ) : $tpl->getDir();
        $tpl = new extendTplParser();
        $tpl->setDir($dir);
        return true;
      }else{
        return false;
      }
    }
    return true;
  }
}

if(!class_exists('tplIntercept')){
  class tplIntercept{
    var $sFile;
    var $sBlock;
    var $sFileReplace;
    var $sBlockReplace;
    var $sCondition;    // external function, returning true/false, governing whether or not to perform the intercept
    var $sRunBefore;    // external function to run Before calling the template
    var $aAppend;       // array containing file and block (optional) parameters to an appended TPL call. Note: appended TPL calls cannot themselves be intercepted
    var $bReplaceFile;  // replace the template file
    var $bReplaceBlock; // replace the block
    var $bBlockFile;    // no output, where the originating $tpl call is for a template only (ie. tHtml or dHtml methods)
    var $bBlockBlock;   // no output, where the originating $tpl call involves a block (ie. tbHtml or dbHtml methods)
    var $bRunBefore;    // indicates whether or not we have a callable function to run before template call (or block)
    var $bCondition;    // indicates whether or not we have a callable function to use as a condition for actioning the intercept
    var $bAppend;       // indicates whether or not we have an additional TPL call to append to the intercepted one

    /* Constructor for tplIntercept class
    * @param string template file to intercept
    * @param string replacement template file
    * @return object intercept
    */
    function tplIntercept($template, $templateReplacement=null){
      if(!$templateReplacement) $templateReplacement = $template;
      $this->sFile = $template;
      $this->sBlock = '';
      $this->sBlockReplace = '';
      $this->sRunBefore = '';
      $this->sCondition = '';
      $this->aAppend = array();
      $this->setTemplateReplacement($templateReplacement);
    }
// Public functions
// GETTERS
    /* Get the template
    * @return string
    */
    function getTemplate(){
      return $this->sFile;
    }
    /* Get the intercept parameters as an associative array
    * @return array
    */
    function getIntercept(){
      $rtn = array();
      $rtn['template']            = $this->sFile;
      $rtn['templateReplacement'] = $this->sFileReplace;
      $rtn['block']               = $this->sBlock;
      $rtn['blockReplacement']    = $this->sBlockReplace;
      $rtn['condition']           = $this->sCondition;
      $rtn['runBefore']           = $this->sRunBefore;
      $rtn['appendTpl']           = $this->aAppend;
      $rtn['bReplaceFile']        = $this->bReplaceFile;
      $rtn['bReplaceBlock']       = $this->bReplaceBlock;
      $rtn['bBlockFile']          = $this->bBlockFile;
      $rtn['bBlockBlock']         = $this->bBlockBlock;
      $rtn['bCondition']          = $this->bCondition;
      $rtn['bRunBefore']          = $this->bRunBefore;
      $rtn['bAppend']             = $this->bAppend;
      return $rtn;
    }
// SETTERS
    /* Sets template replacement file
    * @param string replacement template file
    * @return void
    */
    function setTemplateReplacement( $templateReplacement='' ){
      $this->sFileReplace = $templateReplacement;
      $this->_setFlags();
    }
    /* Sets the block to intercept, and its replacement
    * @param string block to intercept
    * @param string replacement block (set to same as intercept block if not supplied)
    * @return void
    */
    function setBlock( $block='', $replacementBlock=null ){
      $this->sBlock = $block;
      $this->sBlockReplace = (!$replacementBlock) ? $this->sBlock : $replacementBlock;
      $this->_setFlags();
    }
    /* Sets the replacement block
    * @param string replacement block
    * @return void
    */
    function setBlockReplacement( $replacementBlock='' ){
      $this->sBlockReplace = $replacementBlock;
      $this->_setFlags();
    }
    /* Sets the Run Before function
    * @param string name of a function
    * @return void
    */
    function setRunBefore($function){
      $this->sRunBefore = $function;
      $this->_setFlags();
    }
    /* Sets the Condition function for determining whether or not to action the intercept
    * @param string name of a function that returns true/false
    * @return void
    */
    function setCondition($function){
      $this->sCondition = $function;
      $this->_setFlags();
    }
    /* Sets the parameters for an appended TPL
    * @param string tpl file
    * @param string tpl block
    * @return void
    */
    function setAppend($file=null, $block=null){
      if(!isset($file)){ $this->aAppend = array(); }
      elseif(is_string($file)){
        $this->aAppend['file'] = $file;
        if(isset($block) && is_string($block)){ $this->aAppend['block'] = $block; }
      }
      $this->_setFlags();
    }
// Private functions
    /* Sets flags according to the intercept file and block information available
    * @return void
    */
    function _setFlags(){
      $this->bRunBefore = ($this->sRunBefore != '' && is_callable($this->sRunBefore,true));
      $this->bCondition = ($this->sCondition != '' && is_callable($this->sCondition,true));
      $this->bReplaceFile = ($this->sFile != $this->sFileReplace);
      $this->bReplaceBlock = ($this->sBlock != $this->sBlockReplace);
      $this->bBlockFile = ($this->sFileReplace == '');
      $this->bBlockBlock = ($this->bBlockFile || (!$this->bReplaceFile && $this->bReplaceBlock && $this->sBlockReplace == ''));
      $this->bAppend = (count($this->aAppend) > 0);
    }
  } // end of class
}

if(!class_exists('extendTplParser')){
  class extendTplParser extends TplParser {
    var $iInterceptCount;
    var $aIntercept = array();
    var $aByTemplate = array();

    /* Constructor for extendTplParser class, extending TplParser
    * @return object extendTplParser
    */
    function extendTplParser(){
      parent::TplParser(); // run parent constructor
      $this->_setInterceptCount();
    }

// overloaded parent functions ...
    /* Sets the template folder using theme (if set). Note that a theme does NOT have to have its own admin folder - the default will be used
    * @param string path
    * @return void
    */
    function setDir($dir){
      global $oPlugMan;
      $dirTheme = $oPlugMan->getThemePath( (substr($dir,(strlen($dir)-6)) == 'admin/') );
      parent::setDir($dirTheme);
    }
    /* Checks for intercepts, then parses and dumps the relevant template file
    * @param string template file
    * @param bool
    * @param bool
    * @return void
    */
  	function dHtml( $sFile, $bCache = true, $bIso = true ){
      $sBlock = ''; // we need this in case the Intercept converts it to a block call
      if(($cfi = $this->_checkFileIntercept($sFile, $sBlock)) !== false){
        if($sBlock == '')
          parent::dHtml( $sFile, $bCache , $bIso);
        else
          parent::dbHtml( $sFile, $sBlock, $bCache, $bIso );
        if($cfi !== true){ $this->_runAppend($cfi, false); }
      }
	  } // end function dHtml

    /* Checks for intercepts, then parses and returns the relevant template file
    * @param string template file
    * @param bool
    * @param bool
    * @return string
    */
  	function tHtml( $sFile, $bCache = true, $bIso = true ){
      $rtn = $sBlock = ''; // we need this in case the Intercept converts it to a block call
      if(($cfi = $this->_checkFileIntercept($sFile, $sBlock)) !== false){
        if($sBlock == '')
          $rtn = parent::tHtml( $sFile, $bCache, $bIso );
        else
          $rtn = parent::tbHtml( $sFile, $sBlock, $bCache, $bIso );
        if($cfi !== true){ $rtn .= $this->_runAppend($cfi); }
      }
      return $rtn;
	  } // end function tHtml

    /* Checks for intercepts, then parses and dumps the appropriate block of the relevant template file
    * @param string template file
    * @param string block
    * @param bool
    * @param bool
    * @return void
    */
  	function dbHtml( $sFile, $sBlock, $bCache = true, $bIso = true ){
      if(($cbi = $this->_checkBlockIntercept($sFile, $sBlock)) !== false){
        parent::dbHtml( $sFile, $sBlock, $bCache, $bIso );
        if($cbi !== true){ $this->_runAppend($cbi, false); }
      }
  	} // end function dbHtml

    /* Checks for intercepts, then parses and returns the appropriate block of the relevant template file
    * @param string template file
    * @param string block
    * @param bool
    * @param bool
    * @return string
    */
  	function tbHtml( $sFile, $sBlock, $bCache = true, $bIso = true ){
      $rtn = '';
      if(($cbi = $this->_checkBlockIntercept($sFile, $sBlock)) !== false){
        $rtn = parent::tbHtml( $sFile, $sBlock, $bCache, $bIso );
        if($cbi !== true){ $rtn .= $this->_runAppend($cbi); }
      }
      return $rtn;
  	} // end function tbHtml

// new replacement methods that bypass the intercept checking and call the corresponding parent methods directly ...
    /* Runs the parent function without checking for intercepts
    * @param string template file
    * @param bool
    * @param bool
    * @return void
    */
  	function xdHtml( $sFile, $bCache = true, $bIso = true ){
      parent::dHtml( $sFile, $bCache, $bIso );
	  } // end function xdHtml

    /* Runs the parent method without checking for intercepts
    * @param string template file
    * @param bool
    * @param bool
    * @return string
    */
  	function xtHtml( $sFile, $bCache = true, $bIso = true ){
      return parent::tHtml( $sFile, $bCache, $bIso );
	  } // end function xtHtml

    /* Runs the parent method without checking for intercepts
    * @param string template file
    * @param string block
    * @param bool
    * @param bool
    * @return void
    */
  	function xdbHtml( $sFile, $sBlock, $bCache = true, $bIso = true ){
      parent::dbHtml( $sFile, $sBlock, $bCache, $bIso );
  	} // end function xdbHtml

    /* Runs the parent method without checking for intercepts
    * @param string template file
    * @param string block
    * @param bool
    * @param bool
    * @return string
    */
  	function xtbHtml( $sFile, $sBlock, $bCache = true, $bIso = true ){
      return parent::tbHtml( $sFile, $sBlock, $bCache, $bIso );
  	} // end function xtbHtml

// own PUBLIC Intercept functions...
    /* Returns the Intercept object
    * @param integer index into array of intercepts
    * @return object tplIntercept
    */
    function thisIntercept($iIndex){
      return (isset($this->aIntercept[$iIndex]) ? $this->aIntercept[$iIndex] : false);
    } // end function thisIntercept

    /* Returns an associative array of the intercept settings, or false if the intercept has been 'removed' or does not exist
    * @param integer index into array of intercepts
    * @return array
    */
    function getThisIntercept($iIndex){
      $rtn = false;
      if(isset($this->aIntercept[$iIndex]) && $this->aIntercept[$iIndex] !== false){
        $rtn = $this->aIntercept[$iIndex]->getIntercept();
      }
      return $rtn;
    } // end function getThisIntercept

    /* Returns an array of associative arrays containing the (active) intercept settings, with an additonal 'index' setting giving the array index of the intercept
    * @return array
    */
    function getActiveIntercepts(){
      $rtn = array(); $c = $this->getInterceptCount(); $j = 0;
      for($i=0;$i<$c;$i++)
        if(($aI = $this->getThisIntercept($i)) !== false){
          $rtn[$j] = $aI;
          $rtn[$j]['index'] = $i;
          $j++;
        }
      return $rtn;
    } // end function getActiveIntercepts

    /* Returns total number of array elements allocated, regardless of whether the intercept is active or not
    * @return integer
    */
    function getInterceptCount(){
      return $this->iInterceptCount;
    } // end function getInterceptCount

    /* Returns total number of active intercepts
    * @return integer
    */
    function getActiveInterceptCount(){
      $c = $this->getInterceptCount();
      $rtn = 0;
      for($i=0;$i<$c;$i++){ if($this->aIntercept[$i] !== false) $rtn++; }
      return $rtn;
    } // end function getActiveInterceptCount

    /* Returns an array of associative arrays containing matching intercept settings, with an additonal 'index' setting giving the array index of the intercept; returns false if no match found
    * @param string template
    * @param string block
    * @return array
    */
    function matchIntercept($template, $block=''){
      $rtn = false;
      if(isset($this->aByTemplate[$template])){
        $aSpecific = $aGeneral = array();
        foreach($this->aByTemplate[$template] as $iIndex){
          $aI = $this->getThisIntercept($iIndex);
          if($aI['template'] == $template){ // if it doesn't there's a problem!
            $aI['index'] = $iIndex;
            if($aI['block'] == $block) $aSpecific[] = $aI;
            else if($block == '') $aGeneral[] = $aI;
          }
        }
        $rtn = (count($aSpecific)>0 || count($aGeneral)>0) ? array_merge($aSpecific, $aGeneral) : false;
        unset($aSpecific, $aGeneral);
      }
      return $rtn;
    } // end function matchIntercept

    /* Deactivates an intercept
    * @param integer index into array of intercepts
    * @return void
    */
    function removeIntercept($iIndex){
      if(isset($this->aIntercept[$iIndex]) && $this->aIntercept[$iIndex] !== false){
        $file = $this->aIntercept[$iIndex]->getTemplate();
        $this->aIntercept[$iIndex] = false;
        if(($key = array_search($iIndex,$this->aByTemplate[$file])) !== false){ array_splice($this->aByTemplate[$file], $key, 1); }
        if(count($this->aByTemplate[$file]) == 0){ unset($this->aByTemplate[$file]); }
      }
    } // end function removeIntercept

    /* Adds an intercept, returning the array index containing the intercept reference, or false
    * @param string template to intercept
    * @param string optional replacement template
    * @param string optional block to intercept
    * @param string optional replacement block
    * @param string optional function to be run before actioning the intercept
    * @param string optional function returning true/false, acting as a condition for the intercept to be actioned
    * @param array  optional parameters of an additional tpl call to be run after the intercepted call
    * @return integer index into array of intercepts
    */
    function newIntercept( $sTemplate, $sTemplateReplacement=null, $sBlock='', $sBlockReplacement='', $sRunBefore='', $sCondition='', $aAppend=false ){
      if(!is_string($sTemplate) || $sTemplate == ''){ return false; }
      if(!$sTemplateReplacement){ $sTemplateReplacement = $sTemplate; }
      else if(!is_string($sTemplateReplacement)){ $sTemplateReplacement = ''; }

      $oI = new tplIntercept($sTemplate, $sTemplateReplacement);
      if($sBlock != '' || $sBlockReplacement != ''){ $oI->setBlock($sBlock, $sBlockReplacement); }
      if($sRunBefore != ''){ $oI->setRunBefore($sRunBefore); }
      if($sCondition != ''){ $oI->setCondition($sCondition); }
      if($aAppend !== false) { $oI->setAppend( (is_array($aAppend)?$aAppend[0]:$aAppend), ((is_array($aAppend) && isset($aAppend[1]))?$aAppend[1]:null) ); }
      $iIndex = $this->getInterceptCount();
      $this->aIntercept[$iIndex] = $oI;
      if(isset($this->aByTemplate[$sTemplate])){ $this->aByTemplate[$sTemplate][] = $iIndex; }
      else{ $this->aByTemplate[$sTemplate] = array($iIndex); }
      $this->_setInterceptCount();
      return $iIndex;
    } // end function newIntercept

// Own PUBLIC ToolTip functions
    /* Checks for intercepts, then parses and returns a version of the relevant template file suitable for use within domTT tooltips
    * @param string template file
    * @param bool
    * @param bool
    * @return string
    */
    function tToolTip( $sFile, $bCache = true, $bIso = true ){
      return $this->cleanToolTip( $this->tHtml( $sFile, $bCache, $bIso ) );
    } // end function tToolTip

    /* Checks for intercepts, then parses and returns a version of the appropriate block of the relevant template file suitable for use within domTT tooltips
    * @param string template file
    * @param string block
    * @param bool
    * @param bool
    * @return string
    */
    function tbToolTip( $sFile, $sBlock, $bCache = true, $bIso = true ){
      return $this->cleanToolTip( $this->tbHtml( $sFile, $sBlock, $bCache, $bIso ) );
    } // end function tbToolTip

    /* Given the result of a template parse (ie. HTML) this returns code optimised for passing to a Javascript routine
    * @param string HTML
    * @return string escaped HTML with no line breaks and converted special characters
    */
    function cleanToolTip($sTT){
      return addslashes( htmlspecialchars( preg_replace( array('/\r/','/\n/'), '', $sTT ) ) );
    } // end function cleanToolTip

// Own PRIVATE functions...
    /* Checks an originating template-only call to see if an Intercept applies and can be actioned; returns false if the call to the parser is to be blocked (ie. no output). This function could result in the template-only call being changed to a template-and-block call, depending upon the Intercept settings
    * @param &string template
    * @param &string block
    * @return bool
    */
    function _checkFileIntercept(&$sFile, &$sBlock){
      $continue = true;
      if($sFile != '' && isset($this->aByTemplate[$sFile])){
        // while you can add more than one intercept for a file-only call it does not make sense; so just use the first one found
        $aI = $this->getThisIntercept($this->aByTemplate[$sFile][0]);
        if($aI['template'] == $sFile){ // if the file doesn't match there's a problem!
          $cond = $aI['condition'];
          if($aI['bCondition'] && function_exists($aI['condition']) && $cond() !== true){ /* do nothing */ }
          else{
            if($continue && $aI['bRunBefore'] && function_exists($aI['runBefore'])){
              $run = $aI['runBefore'];
              $run( $this->_getInProgress($aI, $sFile, $sBlock) ); }
            if($continue && $aI['bBlockFile']){ $continue = false; }
            if($continue && $aI['bReplaceFile']){ $sFile = $aI['templateReplacement']; }
            if($continue){ $sBlock = $aI['blockReplacement']; } // this gives us the ability to change a non-block call to a block call
            if($continue && $aI['bAppend']){ $continue = $aI['appendTpl']; }
          }
        }
      }
      return $continue;
    } // end function _checkFileIntercept

    /* Checks an originating template-and-block call to see if an Intercept applies and can be actioned; returns false if the call to the parser is to be blocked (ie. no output). Template-and-block calls cannot be converted to template-only calls
    * @param &string template
    * @param &string block
    * @return bool
    */
    function _checkBlockIntercept(&$sFile, &$sBlock){
      // There are a couple of possibilities for block replacement:
      // 1. specific : template and block match
      // 2. general  : template matches, block is empty
      // Specific takes priority over general.
      // Within either specific or general, duplicates do not make sense so take the first one found
      $continue = true;
      if($sFile != '' && $sBlock != '' && isset($this->aByTemplate[$sFile])){ // must have both a file and a block
        $specific = $general = false;
        foreach($this->aByTemplate[$sFile] as $iIndex){
          $aI = $this->getThisIntercept($iIndex);
          if($aI['template'] == $sFile){ // if the file doesn't match there's a problem!
            if($general === false && $aI['block'] == ''){ $general = $iIndex; }
            if($specific === false && $aI['block'] == $sBlock){ $specific = $iIndex; }
          }
        }
        if($specific!==false || $general!==false){
          $iIndex = $specific!==false ? $specific : $general;
          $aI = $this->getThisIntercept($iIndex);
          $cond = $aI['condition'];
          if($aI['bCondition'] && function_exists($cond) && $cond() !== true){ /* do nothing */ }
          else{
            if($continue && $aI['bRunBefore'] && function_exists($aI['runBefore'])){
              $run = $aI['runBefore'];
              $run( $this->_getInProgress($aI, $sFile, $sBlock) ); }
            if($continue && $aI['bBlockBlock']){ $continue = false; }
            if($continue && $aI['bReplaceFile']){ $sFile = $aI['templateReplacement']; }
            if($continue && $aI['bReplaceBlock']){ $sBlock = $aI['blockReplacement']; }
            if($continue && $aI['bAppend']){ $continue = $aI['appendTpl']; }
          }
        }
      }
      return $continue;
    } // end function _checkBlockInterccept

    /* Returns an inProgress array for a tpl thats currently in progress
    * @return void
    */
    function _getInProgress($aI, $sFile, $sBlock){
      return array( 'oldFile'=>$sFile
                   ,'oldBlock'=>$sBlock
                   ,'newFile'=>($aI['bReplaceFile'] ? $aI['templateReplacement'] : $sFile)
                   ,'newBlock'=>($aI['bReplaceBlock'] ? $aI['blockReplacement'] : $sBlock)
                  );
    } // end function _getInProgress

    /* Sets the intercept count
    * @return void
    */
    function _setInterceptCount(){
      $this->iInterceptCount = count($this->aIntercept);
    } // end function _setInterceptCount

    /* Runs an appended tpl call WITHOUT parsing for intercepts
    * @param array file and optional block
    * @param boolean return a string
    * @return string
    */
    function _runAppend($aParam, $return=true){
      if($return){
        if(isset($aParam['block']))
          return parent::tbHtml($aParam['file'], $aParam['block']);
        else
          return parent::tHtml($aParam['file']);
      }else{
        if(isset($aParam['block']))
          parent::dbHtml($aParam['file'], $aParam['block']);
        else
          parent::dHtml($aParam['file']);
        return true;
      }
    } // end function _runAppend
  } // end of class
} // end if not exists ...
?>
