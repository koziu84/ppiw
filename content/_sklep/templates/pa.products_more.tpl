<!-- BEGIN SHOW -->
<script type="text/javascript" src="$config[dir_js]checkForm.js"> </script>
<script type='text/javascript' src='$config[dir_plugins]productAttributes/checkAttributes.js'> </script>
<script type="text/javascript">
<!--
  sTitle = "$aData[sName]";
  var attributeCurrencySymbol = '$config[currency_symbol]';
  var attributeOffsets = checkAttributes_Setup($sAttributeGroupsCheck);
//-->
</script>
<div class="fullentry">
       <div id="addcart">
              <h4>$lang[Buy_now]</h4>
              <div>
                     $lang[Price]:&nbsp;$aData[sFormattedPrices]$config[currency_symbol]
              </div>
              <form action="" method="get" onsubmit="return checkAttributes( this, $sAttributeGroupsCheck, '$lang[Attributes_required]', Array(Array('iQuantity','int','0',null,'>')$sAttributesUserInputCheck) );">
                     <fieldset>
                            <input type="hidden" name="p" value="ordersBasket" />
                            <input type="hidden" name="sOption" value="add" />
                            <input type="hidden" name="iProduct" value="$aData[iProduct]" />
                            $lang[Quantity]:
                            <input type="text"   name="iQuantity" value="1" maxlength="3" size="2" /><br />
        <div id="attrSelect">$sAttributePicklists</div>
                            <input type="submit" value="$lang[Add_to_basket]" class="submit" />
                     </fieldset>
              </form>
              <a href="javascript:windowNew( '?p=productsWindowMore&amp;iProduct=$aData[iProduct]' );" id="print">$lang[print]</a>
              <script type='text/javascript'>
              checkAttributes_Clear();
              </script>
  </div>
       
       <h5>$aData[sCategories]</h5>
       <h2>$aData[sName]</h2>
       $aFiles[sPhotosDefault]
       <p>
    $aData[sDescriptionFull]
  </p>
       <div class="clear"></div>
  $aFiles[sPhotos]
  <div class="clear"></div>
  $aFiles[sFiles]
  <div id="back"> &laquo; <a href="javascript:history.back();">$lang[back]</a></div>
</div>
<!-- END SHOW -->
<!-- BEGIN FORMATTED_STANDARD_PRICE -->
<span id='price'>$aData[fPrice]</span><div id='fPrice'>$aData[fPrice]&nbsp;$config[currency_symbol]</div>
<!-- END FORMATTED_STANDARD_PRICE -->
<!-- BEGIN FORMATTED_SPECIAL_PRICE -->
<span id='paSpecialPrice'><span id='price'>$aData[fSpecialPrice]</span>&nbsp;$config[currency_symbol]</span><br /><span id='paOldPrice'>$aData[fPrice]<div id='fPrice'>$aData[fSpecialPrice]</div>&nbsp;$config[currency_symbol]</span>
<!-- END FORMATTED_SPECIAL_PRICE -->

