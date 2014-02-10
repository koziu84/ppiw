<?php
/*
* productAttributes.class.php
* Wizzud : 31/01/06 productAttributes plugin
*/
require_once DIR_PLUGINS.'productAttributes/attributes-'.$config['db_type'].'.php';

class productAttributes{
  var $sTemplate;
  var $iAttCount;
  var $iGrpCount;
  var $iLastAttId;
  var $aAtt = array();        // array of attributes (attributes id => array of attribute properties)
  var $aGrp = array();        // array of groups ('sName'=>group name, 'aIds'=>array of attribute ids), starting at [1]

  function productAttributes(){ //constructor
    $this->sTemplate = 'productAttributes.tpl';
    $this->iGrpCount = $this->iAttCount = $iLastAttId = 0;
    if(dbCheckAttrFile(DB_ATTRIBUTES) && dbCheckAttrFile(DB_PRODUCT_ATTRIBUTES)){
      $this->_load();
    }
  }
/******************/
/* PUBLIC methods */
/******************/
// GETTERS ...
  /* Indicates whether or not a product has attributes
  * @param integer product id
  * @return boolean
  */
  function productHasAttributes($iProduct){
    return (($rtn = $this->_getProductAttributes($iProduct)) !== false && count($rtn['attributes']) > 0);
  } // end function productHasAttributes

  /* Checks for attributes being supplied for a product; returns true if missing, else formatted comma-delimited string
  * @param integer product id
  * @return string boolean
  */
  function missingAttributes($iProduct){
    $rtn = false; $fmt = $fmtUI = array();
    if(($aData = $this->_productAttributeGroups($iProduct)) !== false){
      foreach($aData['group'] as $group=>$atts){
        if($group == $GLOBALS['lang']['attrReservedGroup']){
          foreach($atts as $ui){
            $attId = $ui['iId']; $uiId = "sUI$attId";
            // need to prevent malicious script injection - but NOTE this could cause problems with mis-representation of text entered!
            if(isset($_GET[$uiId])){ $_GET[$uiId] = changeSpecialChars( htmlspecialchars( stripslashes($_GET[$uiId]) ) ); }
            // if not set/empty and not optional, fail it as missing
            if(isset($_GET[$uiId]) && $_GET[$uiId] != ''){ $fmtUI[] = $attId.'{{'.$_GET[$uiId].'}}'; }
            elseif(!$ui['bOptional']){ $rtn = true; }
          }
        }else{
          if(!isset($_GET[$group])){ $rtn = true; }
          else{ $fmt[] = $_GET[$group]; }
        }
      }
      unset($aData);
    }
    return ( $rtn === true ? $rtn : implode(',', array_merge($fmt,$fmtUI)) );
  } // end function missingAttributes

  /* Returns the price modified according to any attributes and/or special prices
  * @param integer product id
  * @param string product price formatted as float
  * @param string comma-delimited list of attributes
  * @return string adjusted price formatted as float
  */
  function getActualPrice($iProduct, $fPrice, $sAttr){
    if(($special = $this->getSpecialPrice($iProduct)) !== false) $fPrice = $special;
    if($sAttr == '') return tPrice($fPrice);
    // remove User Input because it may have commas in it (and it doesn't affect the price anyway) ...
    $sAttr = preg_replace('/,?[\d]+\{\{.*\}\}/', '', $sAttr);
    if($sAttr == '') return tPrice($fPrice);

    $aExp = explode(',',  $sAttr); $fOffset = 0;
    foreach($aExp as $att){
      if($att != '' && isset($this->aAtt[$att])){
        if($this->aAtt[$att]['bPercent']){ // percentage - always calculated against original price
          $fOffset += tPrice(( ($fPrice * $this->aAtt[$att]['fOffset']) / 100 ) + 0.000001 );
        }else{ // amount
          $fOffset += $this->aAtt[$att]['fOffset'];
        }
      }
    }
    return tPrice($fPrice + $fOffset);
  } // end function getActualPrice

  /* Get the current template
  * @return string template
  */
  function getTemplate(){
    return $this->sTemplate;
  } // end function getTemplate

  /* Get special price
  * @param integer product id
  * @return string price
  */
  function getSpecialPrice($iProduct){
    if( ($aData = $this->_getProductAttributes($iProduct)) !== false && $aData['price'] != '' ){
      return $aData['price'];
    }else{
      return false;
    }
  } // end function getSpecialPrice

  /* Get one specific attribute
  * @param int  $iAttribute
  * @return array
  */
  function getAttribute( $iAttribute ){
    if(isset($this->aAtt[$iAttribute]))
      return array( 'group'=>$this->aAtt[$iAttribute]['sGroup']
                  , 'name'=>$this->aAtt[$iAttribute]['sName']
                  , 'id'=>$iAttribute
                  , 'offset'=>$this->aAtt[$iAttribute]['sOffset']
                  , 'percent'=>($this->aAtt[$iAttribute]['bPercent'] ? 'checked="checked"' : '')
                  , 'optional'=>($this->aAtt[$iAttribute]['bOptional'] ? 'checked="checked"' : '')
                  );
    else
      return null;
  } // end function getAttribute

  /* Get all attributes
  * @return array
  */
  function getAttributes(){
    return dbReadAllAttr();
  } // end function getAttributes

  /* Get a product's attributes
  * @param integer product id
  * @return array false if not found
  */
  function getProductAttributes($iProduct){
    return $this->_getProductAttributes($iProduct);
  } // end function getProductAttributes

// GETTERS that return (or set up) HTML ...
  /* User : HTML of the selected attributes for an element in the basket
  * @param string comma-delimited list of attributes
  * @return string
  */
  function throwBasketAttributes( $sAttrs ){
    global $tpl, $aAttributes, $sBlockPage;

    $rtn = $aUI = array();
    // first get the User Input stuff - it may have commas which will bugger up the explode ...
    if(($pm = preg_match_all('/([\d]+\{\{.*\}\})/U',$sAttrs,$m)) !== false && $pm > 0){ $aUI = $m[1]; }
    if(($pm = strpos($sAttrs,'{{')) !== false){
      $sAttrs = substr($sAttrs,0,$pm);
      if(($pm = strrpos($sAttrs,',')) !== false){ $sAttrs = substr($sAttrs,0,$pm); }
      else{ $sAttrs = ''; }
    }
    $exp = explode(',', $sAttrs);
    foreach($exp as $att){
      if( isset($this->aAtt[$att]) ){
        if(in_array($GLOBALS['config']['attrInclGroupInBasket'], array('select','both'))){ $rtn[] = $this->aAtt[$att]['sGroup'] . ':' . $this->aAtt[$att]['sName']; }
        else{ $rtn[] = $this->aAtt[$att]['sName']; }
      }
    }
    foreach($aUI as $ui){
      if(($pm = preg_match('/^([\d]+)\{\{(.*)\}\}$/', $ui, $mui)) > 0){
        if(isset($this->aAtt[$mui[1]])){
          if(in_array($GLOBALS['config']['attrInclGroupInBasket'], array('ui','both'))){ $rtn[] = $this->aAtt[$mui[1]]['sName'] . ':"' . $mui[2] . '"'; }
          else{ $rtn[] = '"' . $mui[2] . '"'; }
        }
      }
    }
    unset($exp,$m,$mui,$aUI);
    if(count($rtn) > 0){
      $aAttributes['basketList'] = implode(', ', $rtn);
      return $tpl->tbHtml($this->sTemplate, 'BASKET_ATTRIBUTES'.$sBlockPage);
    }else{
      return '';
    }
  }
  /* Admin : HTML list all attributes
  * @return string
  */
  function throwAttributesList(){
    global $tpl, $aAttributes;

    $rtn = $tpl->tbHtml( $this->sTemplate, 'ATTRIBUTES_HEAD' );
    if($this->iAttCount == 0){
      $rtn .= $tpl->tbHtml( $this->sTemplate, 'NOT_FOUND' );
    }else{
      $group = ''; $style = 0;
      $rtn .= $tpl->tbHtml( $this->sTemplate, 'LIST_HEAD' );
      foreach($this->aAtt as $id=>$att){
        $aAttributes['id'] = $id;
        $aAttributes['group'] = $att['sGroup'];
        $aAttributes['name'] = $att['sName'];
        $aAttributes['offset'] = $att['sOffsetFormatted'] != '' ? $att['sOffsetFormatted'] : '&nbsp;' ; // IE doesn't like empty cells
        $aAttributes['percent'] = $att['bPercent'] ? LANG_YES_SHORT : LANG_NO_SHORT ;
        $aAttributes['optional'] = $att['bOptional'] ? LANG_YES_SHORT : '&nbsp;' ; // IE doesn't like empty cells
        if( $aAttributes['group'] != $group ){ $group = $aAttributes['group']; $style++; }
        $aAttributes['iStyle'] = ( $style % 2 );
        $rtn .= $tpl->tbHtml( $this->sTemplate, 'LIST_LIST' );
      }
      $rtn .= $tpl->tbHtml( $this->sTemplate, 'LIST_FOOTER' );
    }
    return $rtn;
  } // end function throwAttributesList

  /* Admin : HTML for selection of an existing group
  * @return string
  */
  function throwSelectGroup(){
    global $tpl, $aAttributes;

    if($this->iGrpCount == 0){
      $rtn = '';
    }else{
      $rtn = $tpl->tbHtml( $this->sTemplate, 'SELECT_GROUP_HEAD' );
      foreach($this->aGrp as $k=>$grp){
        $aAttributes['group'] = $grp['sName'];
        $rtn .= $tpl->tbHtml( $this->sTemplate, 'SELECT_GROUP_OPTION' );
      }
      $rtn .= $tpl->tbHtml( $this->sTemplate, 'SELECT_GROUP_FOOT' );
    }
    return $rtn;
  } // end function throwSelectGroup

  /* Admin : HTML of all attributes as checkboxes for product assignment
  * @param integer $iProduct
  * @return string
  */
  function throwAssignAttributes( $iProduct ){
    global $tpl, $aAttributes;

    if($this->iGrpCount == 0){
      $rtn = '';
    }else{
      $aProdAttr = $this->_getProductAttributes($iProduct); // get attributes for this product
      $aProd = throwProduct($iProduct); // get product data for this product
      $aAttributes = array('addupdate'=>( $aProdAttr !== false ? 'u' : 'a' ), 'scrip'=>'', 'groupCount'=>1, 'prodName'=>$aProd['sName'], 'specialPrice'=>( $aProdAttr !== false ? $aProdAttr['price'] : '' ));
      $rtn = $tpl->tbHtml( $this->sTemplate, 'CHECKBOX_ATTRIBUTE_HEAD' );

      for($i=1;$i<=$this->iGrpCount;$i++){
        $aAttributes['group'] = $this->aGrp[$i]['sName'];
        $aAttributes['groupCount'] = $i;
        $rtn .= $tpl->tbHtml( $this->sTemplate, 'CHECKBOX_ATTRIBUTE_START' );
        $aAttributes['scrip'] .= "if(iAG==$i){var attids = Array(";
        foreach($this->aGrp[$i]['aIds'] as $att){
          $aAttributes['name'] = $this->aAtt[$att]['sName'];
          $aAttributes['id'] = $att;
          $aAttributes['optional'] = $this->aAtt[$att]['bOptional'] ? trim($tpl->tbHtml( $this->sTemplate, 'CHECKBOX_ATTRIBUTE_OPTIONAL' )) : '';
          $aAttributes['checked'] = ($aProdAttr !== false && in_array($att, $aProdAttr['attributes'])) ? 'checked="checked"' : '' ;
          $rtn .= $tpl->tbHtml( $this->sTemplate, 'CHECKBOX_ATTRIBUTE_OPTION' );
          $aAttributes['scrip'] .= "'{$aAttributes['name']}$att',";
        }
        $rtn .= $tpl->tbHtml( $this->sTemplate, 'CHECKBOX_ATTRIBUTE_END' );
        $aAttributes['scrip'] = rtrim($aAttributes['scrip'], ',') . ");}\n";
      }
      $rtn .= $tpl->tbHtml( $this->sTemplate, 'CHECKBOX_ATTRIBUTE_FOOT' );
    }
    return $rtn;
  } // end function throwAssignAttributes

  /* User : HTML of all assigned product attributes as selects; all output is held in global variables, not returned to the caller
  * @param integer $iProduct
  * @return void
  */
  function throwAttributeSelectors( $iProduct ){
    global $tpl, $sBlockPage, $bPrint, $aAttributes, $sAttributePicklists, $sAttributeGroupsCheck, $sAttributesUserInputCheck;

    $ui = $sAttributeGroupsCheck = $sAttributePicklists = $sAttributesUserInputCheck = '';
    if( ($bPrint !== true || $GLOBALS['config']['attrShowAttrOnProdPrint']!='no') && $this->iGrpCount > 0 && isset($iProduct) && is_numeric($iProduct) && ($aProdAttr = $this->_getProductAttributes($iProduct)) !== false && count($aProdAttr['attributes']) > 0){
      for($i=1;$i<=$this->iGrpCount;$i++){
        $intersect = array_intersect($this->aGrp[$i]['aIds'], $aProdAttr['attributes']);
        if(count($intersect) > 0){
          if($this->aGrp[$i]['sName'] == $GLOBALS['lang']['attrReservedGroup']){
            if($bPrint !== true || in_array($GLOBALS['config']['attrShowAttrOnProdPrint'],array('both','ui'))){
              foreach($intersect as $att){
                $aAttributes['id'] = $att;
                $aAttributes['name'] = $this->aAtt[$att]['sName'];
                $ui .= $tpl->tbHtml( $this->sTemplate, 'PICKLIST_USER_INPUT'.$sBlockPage );
                if(!$this->aAtt[$att]['bOptional']){ $sAttributesUserInputCheck .= ",Array('sUI$att')"; }
              }
            }
          }else{
            if($bPrint !== true || in_array($GLOBALS['config']['attrShowAttrOnProdPrint'],array('both','select'))){
              $aAttributes['group'] = $this->aGrp[$i]['sName'];
              $sAttributeGroupsCheck .= "'{$aAttributes['group']}',";
              $sAttributePicklists .= $tpl->tbHtml( $this->sTemplate, 'PICKLIST_START'.$sBlockPage );
              foreach($intersect as $att){
                $aAttributes['id'] = $att;
                $aAttributes['name'] = $this->aAtt[$att]['sName'];
                $aAttributes['offset'] = $this->aAtt[$att]['sOffsetFormatted'] == '' ? '' : "({$this->aAtt[$att]['sOffsetFormatted']})";
                $sAttributePicklists .= $tpl->tbHtml( $this->sTemplate, 'PICKLIST_OPTION'.$sBlockPage );
              }
              $sAttributePicklists .= $tpl->tbHtml( $this->sTemplate, 'PICKLIST_END'.$sBlockPage );
            }
          }
        }
        unset($intersect);
      }
      unset($aProdAttr);
    }
    $sAttributePicklists .= $ui;
    $sAttributeGroupsCheck = 'Array(' . rtrim($sAttributeGroupsCheck,',') . ')';
  } // end function throwAttributeSelectors

  /* Admin : HTML Sets up the attributes link and tooltip on the Admin products list
  * Its sole use is to be called from the setProdListHasAttr() run-before function on the extended tpl intercept of products_list.tpl/LIST_LIST.
  * @param integer product id
  * @return void
  */
  function throwAdminProdList($iProduct){
    global $tpl, $aList, $aToolTip;

    $aList['sProdListHasAttr'] = $aList['sProdListAttrTT'] = $aList['fSpecialPrice'] = '';
    if(($aData = $this->_productAttributeGroups($iProduct)) === false || count($aData['group']) == 0){ // no tooltip if no attributes!
      $aList['sProdListHasAttr'] = 'no_'; // controls the image displayed for the link
    }else{
      $aToolTip = array('sContent'=>'');
      if($GLOBALS['config']['attrTTonProdList']){ // only if enabled!
        foreach($aData['group'] as $group=>$aAttr){
          $aToolTip['sGroup'] = $group.'&nbsp;:&nbsp;';
          foreach($aAttr as $attr){
            $aToolTip['sAttribute'] = $attr['sName'];
            if($group == $GLOBALS['lang']['attrReservedGroup'])
              $aToolTip['sOffset'] = $attr['bOptional'] ? "&nbsp;({$GLOBALS['lang']['Optional']})" : '';
            else
              $aToolTip['sOffset'] = $attr['sOffsetFormatted'] == '' ? '' : "&nbsp;({$attr['sOffsetFormatted']})";
            $aToolTip['sContent'] .= $tpl->xtbHtml($this->sTemplate, 'PRODLIST_TOOLTIP_LIST');
            $aToolTip['sGroup'] = '';
          }
        }
        // add the header and footer, and clean it up for inclusion in the javascript call ...
        $aToolTip['sContent'] = $tpl->xtbHtml($this->sTemplate, 'PRODLIST_TOOLTIP_HEAD') . $aToolTip['sContent'] . $tpl->xtbHtml($this->sTemplate, 'PRODLIST_TOOLTIP_FOOT');
        $aToolTip['sContent'] = extendTplParser::cleanToolTip($aToolTip['sContent']);
        // put the content inside the event handlers ...
        $aList['sProdListAttrTT'] = $tpl->xtbHtml($this->sTemplate, 'PRODLIST_TOOLTIP_EVENT');
      }
    }
    if($aData !== false && $aData['price'] != ''){
      $aList['fSpecialPrice'] = $aData['price'];
      $aList['sFormattedPrices'] = $tpl->xtbHtml($this->sTemplate, 'FORMATTED_SPECIAL_PRICE');
    }else{
      $aList['sFormattedPrices'] = $tpl->xtbHtml($this->sTemplate, 'FORMATTED_STANDARD_PRICE');
    }
  } // end function throwAdminProdList

// SETTERS ...
  /* Set the template file
  * @param string template
  * @return void
  */
  function setTemplate($template){
    $this->sTemplate = $template;
  } // end function setTemplate

  /* Save attribute
  * @param int  $aForm
  * @return void
  */
  function saveAttribute( $aForm ){
    if( is_numeric( $aForm['iAttribute'] ) ){ $bExist = true; }
    else{
      $aForm['iAttribute'] = $this->iLastAttId + 1;
      $bExist = false; }
    $aForm['sGroup']  = changeTxt( $aForm['sGroup'] );
    $aForm['sName']  = changeTxt( $aForm['sName'] );
    if($aForm['sGroup'] == $GLOBALS['lang']['attrReservedGroup']){
      $aForm['fOffset'] = '';
      $aForm['iPercent'] = 0;
      if (!isset($aForm['iOptional'])){ $aForm['iOptional'] = '0'; }
    }else{
      $aForm['fOffset'] = (isset($aForm['fOffset'])) ? ereg_replace( ',', '.', $aForm['fOffset'] ) : '0.00';
      $aForm['fOffset'] = tPrice( $aForm['fOffset'] );
      if (!isset($aForm['iPercent'])){ $aForm['iPercent'] = '0'; }
      $aForm['iOptional'] = 0;
    }
    dbSaveAttr( $aForm, $bExist );
  } // end function saveAttribute

  /* Delete attribute
  * @param int  $iAttribute
  * @return void
  */
  function deleteAttribute( $iAttribute ){
    dbDeleteAttr( $iAttribute );
    if(($aData = $this->_getAllProductAttributes()) !== false){
      foreach($aData as $prod=>$rec){
        if( in_array($iAttribute,$rec['attributes']) ){
          $newAttr = array_diff($rec['attributes'], array($iAttribute));
          dbSaveProdAttr(array('iProduct'=>$prod, implode(',', $newAttr), $rec['price']), true);
          unset($newAttr);
        }
      }
    }
    unset($aData);
  } // end function deleteAttribute

  /* Save product attributes
  * @param integer $aForm
  * @return void
  */
  function saveProductAttributes( $aForm ){
    $bExist = ($aForm['sAddUpdate'] != 'a');
    if( !isset($aForm['fSpecialPrice']) ){ $aForm['fSpecialPrice'] = ''; }
    dbSaveProdAttr( $this->_formatProductAndAttributes( $aForm ), $bExist );
  } // end function saveProductAttributes

  /* Delete product attributes
  * @param integer product id
  * @return void
  */
  function deleteProductAttributes( $iProduct ){
    dbDeleteProdAttr( $iProduct );
  } // end function deleteProductAttributes

/*******************/
/* PRIVATE methods */
/*******************/
  /* Gets array of attribute groups, with the attribute data, for a product. Primary key is group name
  * @param integer product id
  * @return array false if none found
  */
  function _productAttributeGroups($iProduct){
    $rtn = false;
    if(($aData = $this->_getProductAttributes($iProduct)) !== false){
      $rtn = array('group'=>array(), 'price'=>$aData['price']);
      foreach($aData['attributes'] as $attId){ $rtn['group'][$this->aAtt[$attId]['sGroup']][] = ($this->aAtt[$attId] + array('iId'=>$attId)); }
      unset($aData);
      if(count($rtn['group']) == 0 && $rtn['price'] == ''){ $rtn = false; }
    }
    return $rtn;
  } // end function _productAttributeGroups

  /* Get a product's attributes
  * @param integer product id
  * @return array false if not found
  */
  function _getProductAttributes($iProduct){
    if(($aData = dbReadProdAttr($iProduct)) === false){
      return false;
    }else{
      return array( 'attributes'=>$this->_extractAttributes($aData), 'price'=>$aData[2]);
    }
  } // end function _getProductAttributes

  /* Get attributes for all products
  * @return array false if none found
  */
  function _getAllProductAttributes(){
    $rtn = false;
    if(($aData = dbReadAllProdAttr()) !== false){
      $rtn = array();
      $iCount = count($aData);
      for($i=0; $i<$iCount; $i++){
        $attrs = $this->_extractAttributes($aData[$i]);
        if(count($attrs) > 0){ $rtn[$aData[$i][0]] = array('attributes'=>$attrs, 'price'=>$aData[$i][2]); }
      }
      unset($aData, $attrs);
      if(count($rtn) == 0){ $rtn = false; }
    }
    return $rtn;
  } // end function _getAllProductAttributes

  /* Extracts attributes from a product attributes record
  * @param array record
  * @return array
  */
  function _extractAttributes($rec){
    return ($rec[1] == '' ? array() : explode(',', $rec[1]));
  } // end function _extractAttributes

  /* Loads attributes
  * @return void
  */
  function _load(){
    if(($aData = dbReadAllAttr()) !== false){
      $this->iAttCount = count($aData);
      $sLastGroup = '';
      for($i=0;$i<$this->iAttCount;$i++){
        list($group, $name, $id, $offset, $percent, $optional, $spare_1, $spare_2, $spare_3) = $aData[$i];
        if($group!=$sLastGroup){
          $this->iGrpCount++;
          $sLastGroup = $group;
          $this->aGrp[$this->iGrpCount] = array('sName'=>$group, 'aIds'=>array());
        }
        $id = (int)$id;
        // quick check in case someone tries setting up the attributes then changing the reserved User Input group!
        if($group == $GLOBALS['lang']['attrReservedGroup']){ $offset = ''; $percent = '0'; }
        else{ $optional = '0'; }
        $this->iLastAttId = max($this->iLastAttId, $id);
        $this->aGrp[$this->iGrpCount]['aIds'][] = $id;
        $this->aAtt[$id] = array('iGroup'=>$this->iGrpCount, 'sGroup'=>$group, 'sName'=>$name,
                                 'sOffset'=>$offset, 'fOffset'=>(float)$offset,
                                 'bPercent'=>($percent=='1'), 'bOptional'=>($optional=='1'), 'sOffsetFormatted'=>'',
                                 'sSpare_1'=>$spare_1, 'sSpare_2'=>$spare_2, 'sSpare_3'=>$spare_3);
        if($this->aAtt[$id]['fOffset'] != 0){ // format offset ...
          $this->aAtt[$id]['sOffsetFormatted']  = $this->aAtt[$id]['fOffset'] > 0 ? '+' : '';
          $this->aAtt[$id]['sOffsetFormatted'] .= ($this->aAtt[$id]['bPercent'] && strpos($offset, '.')!==false) ? rtrim(rtrim($offset, '0'), '.') : tPrice($this->aAtt[$id]['fOffset']);
          if($this->aAtt[$id]['bPercent']){ $this->aAtt[$id]['sOffsetFormatted'] .= '%'; }
          elseif($GLOBALS['config']['attrShowCurrencyOnOffset'] == 'before'){ $this->aAtt[$id]['sOffsetFormatted'] = $GLOBALS['config']['currency_symbol'] . $this->aAtt[$id]['sOffsetFormatted']; }
          elseif($GLOBALS['config']['attrShowCurrencyOnOffset'] == 'after'){ $this->aAtt[$id]['sOffsetFormatted'] .= $GLOBALS['config']['currency_symbol']; }
          elseif($GLOBALS['config']['attrShowCurrencyOnOffset'] == 'afterpm'){ $this->aAtt[$id]['sOffsetFormatted'] = (preg_match('/^([^0-9]?)(.*)$/',$this->aAtt[$id]['sOffsetFormatted'],$m)>0) ? $m[1].$GLOBALS['config']['currency_symbol'].$m[2] : $GLOBALS['config']['currency_symbol'].$this->aAtt[$id]['sOffsetFormatted']; }
//          elseif($GLOBALS['config']['attrShowCurrencyOnOffset'] == 'afterpm'){ $this->aAtt[$id]['sOffsetFormatted'] = in_array(substr($this->aAtt[$id]['sOffsetFormatted'],0,1), array('+','-')) ? substr($this->aAtt[$id]['sOffsetFormatted'],0,1).$GLOBALS['config']['currency_symbol'].substr($this->aAtt[$id]['sOffsetFormatted'],1) : $GLOBALS['config']['currency_symbol'].$this->aAtt[$id]['sOffsetFormatted']; }
        }
      }
      unset($aData);
    }
  } // end function _load

  /* Reduce an array to the format of a product_attributes record
  * @param array
  * @return array
  */
  function _formatProductAndAttributes($A){
    $B = array();
    foreach($A as $k=>$v){ if(false !== strpos($k,'_PA_')){ $B[] = $v; } }
    $rtn = array( 'iProduct'=>$A['iProduct'], implode(',', $B), $A['fSpecialPrice'] );
    return $rtn;
  }// end of function _stripProductAndAttributes

} // end class productAttributes
?>
