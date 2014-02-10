<!-- BEGIN ATTRIBUTES_HEAD -->
<div id="list_title">
  $lang[Attribute_list]
</div>
<!-- END ATTRIBUTES_HEAD -->

<!-- BEGIN LIST_HEAD -->
<table id='list_table' cellspacing='0'>
  <tr class='listhead'>
    <td>
      $lang[Group]
    </td>
    <td>
      $lang[Attribute]
    </td>
    <td>
      $lang[Offset]
    </td>
    <td>
      $lang[Optional]
    </td>
    <td>
      &nbsp;
    </td>
  </tr>
<!-- END LIST_HEAD -->

<!-- BEGIN LIST_LIST -->
  <tr class='listbody_$aAttributes[iStyle]'>
    <td>
      $aAttributes[group]
    </td>
    <td>
      $aAttributes[name]
    </td>
    <td>
      $aAttributes[offset]
    </td>
    <td>
      $aAttributes[optional]
    </td>
    <th>
      <a href='?p=attributesForm&amp;iAttribute=$aAttributes[id]'><img src='$config[dir_files]img/edit.gif' alt='$lang[edit]' title='$lang[edit]' /></a>
      <a href='?p=attributesDelete&amp;iAttribute=$aAttributes[id]' onclick='return del();'><img src='$config[dir_files]img/del.gif' alt='$lang[delete]' title='$lang[delete]' /></a>
    </th>
  </tr>
<!-- END LIST_LIST -->
<!-- BEGIN LIST_FOOTER -->
  <tr class='listfooter'>
    <td colspan='5'>
    </td>
  </tr>
</table>
<!-- END LIST_FOOTER -->
<!-- BEGIN FORM -->
<script type='text/javascript' src='$config[dir_plugins]pluginManager/checkForm.js'> </script>
<script language='javascript' type='text/javascript'>
function selectAttrGroup(obj){if(obj.options[obj.selectedIndex].value!=''){document.attForm.sGroup.value=obj.options[obj.selectedIndex].value;document.attForm.sName.focus();}}
function setAttrGroupUI(){document.attForm.sGroup.value='$lang[attrReservedGroup]';document.attForm.sName.focus();return false;}
</script>
<div id="list_title">
  $lang[Attribute_data]
</div>
<form name='attForm' id='attForm' action='?p=$p&amp;iAttribute=$iAttribute' method='post' enctype='multipart/form-data' onsubmit='return checkForm( this,
  Array(
    Array( "sGroup", "regexp", "^[\\w]+&#36;", "", "$lang[Attribute_groupRequired]" )
    ,Array( "sName", "simple", "$lang[Attribute_nameRequired]" )
    ,Array( "fOffset", "float", "", "false" )
  )
);'>
  <input type='hidden' name='iAttribute'  value="$iAttribute" />
  <input type='hidden' name='sOption'      value="save" />
  <table cellspacing="0" id="form_table">
    <tr>
      <th>
        $lang[Group]:&nbsp;
      </th>
      <td>
        <input type='text' name='sGroup' id='sGroup' value="$aAttribute[group]" size='30' />$aAttribute[selectGroup]
        &nbsp;&nbsp;&nbsp;<input type='submit' name='sUserInput' value='$lang[attrReservedGroupButton]' onclick="return setAttrGroupUI();" />
      </td>
    </tr>
    <tr>
      <th>
        $lang[Attribute]:&nbsp;
      </th>
      <td>
        <input type='text' name='sName' value="$aAttribute[name]" size='30' />
        <span style='padding:5px 5px 5px 15px;'>$lang[Optional]?</span><input class='borderless' type='checkbox' name='iOptional' value='1' $aAttribute[optional] />
        &nbsp;&nbsp;<span style='font-style:italic;color:#808080;'>$lang[OptionalFootnote]</span>
      </td>
    </tr>
    <tr>
      <th>
        $lang[Offset]:&nbsp;
      </th>
      <td>
        <input type='text' name='fOffset' value="$aAttribute[offset]" size='8' maxlength='8' style='text-align: right;' />
        <span style="padding:5px 5px 5px 15px;">$lang[Percentage]?</span><input class='borderless' type="checkbox" name="iPercent" value="1" $aAttribute[percent] />
      </td>
    </tr>
    <tr class='formsave'>
      <td colspan='2'>
        <input type='submit' value='$lang[save] &raquo;' />
      </td>
    </tr>
  </table>
  <div id="form_back">
	  &laquo; <a href="javascript:history.back();">$lang[go_back]</a>
  </div>
</form>
<!-- END FORM -->

<!-- BEGIN SELECT_GROUP_HEAD -->
        &nbsp;&nbsp;&nbsp;<select name='sSelectGroup' onchange='selectAttrGroup(this);'>
          <option value=''>Existing groups...</option>
<!-- END SELECT_GROUP_HEAD -->
<!-- BEGIN SELECT_GROUP_OPTION -->
          <option value='$aAttributes[group]'>$aAttributes[group]</option>
<!-- END SELECT_GROUP_OPTION -->
<!-- BEGIN SELECT_GROUP_FOOT -->
        </select>
<!-- END SELECT_GROUP_FOOT -->

<!-- BEGIN CHECKBOX_ATTRIBUTE_HEAD -->
<div id="list_title">
  $lang[Attribute_Prod_data]
</div>
<script type="text/javascript" src="$config[dir_js]checkForm.js"> </script>
<form name='attForm' id='attForm' action='?p=$p&amp;iProduct=$iProduct' method='post' onsubmit="return checkForm( this, Array( Array( 'fSpecialPrice', 'float', '', true ) ) );">
  <input type='hidden' name='iProduct' value="$iProduct" />
  <input type='hidden' name='sOption' value="save" />
  <input type='hidden' name='sAddUpdate' value='$aAttributes[addupdate]' />
  <table cellspacing="0" id="form_table">
    <tr style='background-color:#bbbbbb; text-align:center;'>
      <td colspan='3' style='text-align:center; font-weight:bold; font-size:14px;'>
        $aAttributes[prodName]
      </td>
    </tr>
    <tr>
      <th colspan='2'>
        $lang[SpecialPrice]
      </th>
      <td>
        <input type='text' name='fSpecialPrice' id='fSpecialPrice' value='$aAttributes[specialPrice]' size='8' maxlength='8' class='label' />
        $config[currency_symbol]
        <input style='margin-left:20px;' type='submit' value='$lang[clear]' onclick="document.attForm.fSpecialPrice.value='';return false;" />
      </td>
    </tr>
    <tr style='background-color:#bbbbbb; text-align:center;'>
      <td colspan='3' style='text-align:center; font-size:14px;'>
        $lang[Attributes]
      </td>
    </tr>
<!-- END CHECKBOX_ATTRIBUTE_HEAD -->
<!-- BEGIN CHECKBOX_ATTRIBUTE_START -->
    <tr>
      <th style='vertical-align:middle;'>
        $aAttributes[group]:
      </th>
      <td style='width:40px; text-align:center;'>
        <img style='cursor:pointer; margin-bottom:14px;' src='$config[dir_plugins]productAttributes/check.gif' onclick="setAllAttributes($aAttributes[groupCount],true);" alt='$lang[check_all]' title='$lang[check_all]' />
        <img style='cursor:pointer; margin-top:14px;' src='$config[dir_plugins]productAttributes/uncheck.gif' onclick="setAllAttributes($aAttributes[groupCount],false);" alt='$lang[uncheck_all]' title='$lang[uncheck_all]' />
      </td>
      <td style='vertical-align:middle;'>
<!-- END CHECKBOX_ATTRIBUTE_START -->
<!-- BEGIN CHECKBOX_ATTRIBUTE_OPTION -->
          $aAttributes[name]<input class='borderless' type='checkbox' name='$aAttributes[group]_PA_$aAttributes[id]' id='$aAttributes[name]$aAttributes[id]' value='$aAttributes[id]' $aAttributes[checked] />$aAttributes[optional]&nbsp;&nbsp;
<!-- END CHECKBOX_ATTRIBUTE_OPTION -->
<!-- BEGIN CHECKBOX_ATTRIBUTE_OPTIONAL -->
<span title='$lang[Optional]' style='cursor:default;color:#808080;'>(!)</span>
<!-- END CHECKBOX_ATTRIBUTE_OPTIONAL -->
<!-- BEGIN CHECKBOX_ATTRIBUTE_END -->
      </td>
    </tr>
<!-- END CHECKBOX_ATTRIBUTE_END -->
<!-- BEGIN CHECKBOX_ATTRIBUTE_FOOT -->
    <tr class='formsave'>
      <td colspan='3'>
        <input type='submit' value='$lang[save] &raquo;' />
<script type='text/javascript' language='javascript'>
function setAllAttributes(iAG,bChkd){
$aAttributes[scrip]
for(var i=0;i<attids.length;i++){if(gEBI(attids[i])){gEBI(attids[i]).checked=bChkd;}}}
</script>
      </td>
    </tr>
  </table>
  <div id="form_back">
	  &laquo; <a href="javascript:history.back();">$lang[go_back]</a>
  </div>
</form>
<!-- END CHECKBOX_ATTRIBUTE_FOOT -->

<!-- BEGIN NOT_FOUND -->
<br /><br />
<div id="message">
  <div id="error">
      $lang[Not_found]
      <br />
      <a href="javascript:history.back();">$lang[go_back]</a>
  </div>
</div>
<!-- END NOT_FOUND -->

<!-- BEGIN PRODLIST_TOOLTIP_SCRIP -->
<script type='text/javascript' src='$config[dir_plugins]pluginManager/domLib_071.stripped.js'></script>
<script type='text/javascript' src='$config[dir_plugins]pluginManager/domTT_071.stripped.js'></script>
<!-- END PRODLIST_TOOLTIP_SCRIP -->
<!-- BEGIN PRODLIST_TOOLTIP_HEAD -->
<table style='font-size:11px; border:1px solid #333366; padding:0px;' cellspacing='0'><tr style='background-color:#333366; color:#ffffff;'><td colspan='3' style='text-align:center;'>$lang[Attributes]</td></tr>
<!-- END PRODLIST_TOOLTIP_HEAD -->
<!-- BEGIN PRODLIST_TOOLTIP_LIST -->
<tr style='background-color:#f1f1ff; color:#333366;'><td style='font-weight:bold;'>$aToolTip[sGroup]</td><td>$aToolTip[sAttribute]</td><td><span style='font-style:italic;'>$aToolTip[sOffset]</span></td></tr>
<!-- END PRODLIST_TOOLTIP_LIST -->
<!-- BEGIN PRODLIST_TOOLTIP_FOOT -->
</table>
<!-- END PRODLIST_TOOLTIP_FOOT -->
<!-- BEGIN PRODLIST_TOOLTIP_EVENT -->
onmouseout="domTT_mouseout(this, event);" onmouseover="domTT_activate(this, event, 'content', '$aToolTip[sContent]', 'trail', true, 'direction', 'northwest', 'delay', 0);"
<!-- END PRODLIST_TOOLTIP_EVENT -->

<!-- BEGIN PRODUCTS_LIST_LIST -->
  <tr class="listbody_$aList[iStyle]">
    <td>
      $aList[iProduct]
    </td>
    <td class="listbodystatus_$aList[iStatus]">
      <a href="?p=$aActions[g]Form&amp;iProduct=$aList[iProduct]">$aList[sName]</a>
    </td>
    <td>
      $aList[sCategories]
    </td>
    <td>$aList[sFormattedPrices]</td>
    <td>
      $aList[iPosition]
    </td>
    <th class='paProdList'>
      <a href="?p=attributesProduct&amp;iProduct=$aList[iProduct]"><img src="$config[dir_plugins]productAttributes/$aList[sProdListHasAttr]attributes.gif" $aList[sProdListAttrTT] alt="$lang[attributes]" title="$lang[attributes]" /></a>&nbsp;
      <a href="?p=$aActions[g]Form&amp;iProduct=$aList[iProduct]"><img src="$config[dir_files]img/edit.gif" alt="$lang[edit]" title="$lang[edit]" /></a>
      <a href="?p=$aActions[g]Delete&amp;iProduct=$aList[iProduct]" onclick="return del( );"><img src="$config[dir_files]img/del.gif" alt="$lang[delete]" title="$lang[delete]" /></a>
    </th>
  </tr>
<!-- END PRODUCTS_LIST_LIST -->
<!-- BEGIN FORMATTED_STANDARD_PRICE -->
$aList[fPrice]
<!-- END FORMATTED_STANDARD_PRICE -->
<!-- BEGIN FORMATTED_SPECIAL_PRICE -->
<a href='?p=attributesProduct&amp;iProduct=$aList[iProduct]'><span id='paSpecialPrice'>$aList[fSpecialPrice]</span></a><span id='paOldPrice'>$aList[fPrice]</span>
<!-- END FORMATTED_SPECIAL_PRICE -->

<!-- BEGIN BASKET_ATTRIBUTES -->
<span style='font-style:italic;'> ($aAttributes[basketList])</span>
<!-- END BASKET_ATTRIBUTES -->
<!-- BEGIN BASKET_ATTRIBUTES_PRINT -->
<span style='font-style:italic;'> ($aAttributes[basketList])</span>
<!-- END BASKET_ATTRIBUTES_PRINT -->
<!-- BEGIN BASKET_LIST_LIST -->
<tr class="listbody_$aList[iStyle]">
  <td>
    $aList[sProduct]$aList[sAttributes]
  </td>
  <td style="text-align: right;">
    $aList[fPrice]
  </td>
  <td style="text-align: right;">
    $aList[iQuantity]
  </td>
  <td style="text-align: right;">
    $aList[fSummary]
  </td>
</tr>
<!-- END BASKET_LIST_LIST -->
<!-- BEGIN BASKET_LIST_LIST_PRINT -->
  <tr class="order_table_body">
    <td>
      $aList[sProduct]$aList[sAttributes]
    </td>
    <td>
      $aList[fPrice]
    </td>
    <td>
      $aList[iQuantity]
    </td>
    <td>
      $aList[fSummary]
    </td>
  </tr>
<!-- END BASKET_LIST_LIST_PRINT -->
