<!-- BEGIN PICKLIST_START -->
<div><select name='$aAttributes[group]' id='$aAttributes[group]' onchange='checkAttributes_Offset(this);' title='$aAttributes[group] $lang[Attributes]'>
<option value=''>$aAttributes[group]...</option>
<!-- END PICKLIST_START -->
<!-- BEGIN PICKLIST_OPTION -->
<option value='$aAttributes[id]'>$aAttributes[name]&nbsp;$aAttributes[offset]</option>
<!-- END PICKLIST_OPTION -->
<!-- BEGIN PICKLIST_END -->
</select></div>
<!-- END PICKLIST_END -->
<!-- BEGIN PICKLIST_USER_INPUT -->
<div class='paUI'><label>$aAttributes[name]:<br /><input type='text' name='sUI$aAttributes[id]' value='' title='$lang[attrReservedGroupButton] : $aAttributes[name]' /></label></div>
<!-- END PICKLIST_USER_INPUT -->

<!-- BEGIN PICKLIST_START_PRINT -->
<div><table cellspacing='0'><tr><th>$aAttributes[group]&nbsp;</th>
<!-- END PICKLIST_START_PRINT -->
<!-- BEGIN PICKLIST_OPTION_PRINT -->
<td>$aAttributes[name]<span>&nbsp;$aAttributes[offset]</span></td>
<!-- END PICKLIST_OPTION_PRINT -->
<!-- BEGIN PICKLIST_END_PRINT -->
</tr></table></div>
<!-- END PICKLIST_END_PRINT -->
<!-- BEGIN PICKLIST_USER_INPUT_PRINT -->
<div><table cellspacing='0'><tr><th>$aAttributes[name]&nbsp;</th><td><span class='paBasketAttrPrint'>($lang[attrReservedGroupButton])</span></td></tr></table></div>
<!-- END PICKLIST_USER_INPUT_PRINT -->

<!-- BEGIN BASKET_ATTRIBUTES -->
<span class='paBasketAttr'>($aAttributes[basketList])</span>
<!-- END BASKET_ATTRIBUTES -->
<!-- BEGIN BASKET_ATTRIBUTES_PRINT -->
<span class='paBasketAttrPrint'>($aAttributes[basketList])</span>
<!-- END BASKET_ATTRIBUTES_PRINT -->
<!-- BEGIN BASKET_LIST_LIST -->
    <tr>
      <td>
        <a href="?p=productsMore&amp;iProduct=$aList[iProduct]">$aList[sProduct]</a><br />$aList[sAttributes]
      </td>
      <td>
        $aList[fPrice]
      </td>
      <td>
        <fieldset><input type="text" name="aElements[$aList[iElement]]" value="$aList[iQuantity]" maxlength="3" size="2" /></fieldset>
      </td>
      <td>
        $aList[fSummary]
      </td>
      <td>
        <a href="?p=$p&amp;sOption=del&amp;iElement=$aList[iElement]">$lang[Delete]</a>
      </td>
    </tr>
<!-- END BASKET_LIST_LIST -->
<!-- BEGIN BASKET_LIST_LIST_DELIVERY -->
  <tr>
    <td>
      <a href="?p=productsMore&amp;iProduct=$aList[iProduct]">$aList[sProduct]</a><br />$aList[sAttributes]
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
<!-- END BASKET_LIST_LIST_DELIVERY -->
<!-- BEGIN BASKET_LIST_LIST_PRINT -->
  <tr>
    <td>
      $aList[sProduct]<br />$aList[sAttributes]
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
