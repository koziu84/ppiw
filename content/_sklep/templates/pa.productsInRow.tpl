<!-- BEGIN LIST_LIST -->
  <td>
    <h2><a href='?p=productsMore&amp;iProduct=$aList[iProduct]'>$aList[sName]</a></h2>
    $aList[sPhoto]
    <h5>$aList[sCategories]</h5>
    <p>$aList[sDescriptionShort]</p>
    $aList[sFormattedPrices]
  </td>
<!-- END LIST_LIST -->
<!-- BEGIN FORMATTED_STANDARD_PRICE -->
<a href="?p=ordersBasket&amp;sOption=add&amp;iProduct=$aList[iProduct]&amp;iQuantity=1" class="cart" title="$lang[Add_to_basket]"><img src="templates/img/cart_image_small.gif" alt="" />$aList[fPrice]&nbsp;$config[currency_symbol]</a>
<!-- END FORMATTED_STANDARD_PRICE -->
<!-- BEGIN FORMATTED_SPECIAL_PRICE -->
<a href="?p=ordersBasket&amp;sOption=add&amp;iProduct=$aList[iProduct]&amp;iQuantity=1" class="cart" title="$lang[Add_to_basket]"><img src="templates/img/cart_image_small.gif" alt="" /><span id='paSpecialPrice'>$aList[fSpecialPrice]&nbsp;$config[currency_symbol]</span> <span id='paOldPrice'>$aList[fPrice]&nbsp;$config[currency_symbol]</span></a>
<!-- END FORMATTED_SPECIAL_PRICE -->
