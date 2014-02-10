<!-- BEGIN LIST_LIST -->
<div class="entry">
  <h2><a href="?p=productsMore&amp;iProduct=$aList[iProduct]" title="$aList[sName]">$aList[sName]</a></h2>
  <h5>$aList[sCategories]</h5>
  $aList[sPhoto]
  <p>$aList[sDescriptionShort]</p>
  $aList[sFormattedPrices]
  <div class="clear"></div>
</div>
<!-- END LIST_LIST -->
<!-- BEGIN FORMATTED_STANDARD_PRICE -->
<a href="?p=ordersBasket&amp;sOption=add&amp;iProduct=$aList[iProduct]&amp;iQuantity=1" class="cart" title="$lang[Add_to_basket]">$aList[fPrice]&nbsp;$config[currency_symbol]</a>
<!-- END FORMATTED_STANDARD_PRICE -->
<!-- BEGIN FORMATTED_SPECIAL_PRICE -->
<a href="?p=ordersBasket&amp;sOption=add&amp;iProduct=$aList[iProduct]&amp;iQuantity=1" class="cart" title="$lang[Add_to_basket]"><span id='paSpecialPrice'>$aList[fSpecialPrice]&nbsp;$config[currency_symbol]</span><br /><span id='paOldPrice'>$aList[fPrice]&nbsp;$config[currency_symbol]</span></a>
<!-- END FORMATTED_SPECIAL_PRICE -->
