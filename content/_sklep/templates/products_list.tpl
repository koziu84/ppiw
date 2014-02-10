<!-- BEGIN LIST_HEAD -->
<div class="category_desc">
  $sCategoryDesc
</div>				
<!-- END LIST_HEAD -->
<!-- BEGIN PHOTO -->
<div class="photo">
  <a href="?p=productsMore&amp;iProduct=$aList[iProduct]"><img src="$aList[sPhotoSmall]" alt="$aList[sName]" title="$aList[sName]" /></a>
</div>
<!-- END PHOTO -->
<!-- BEGIN LIST_LIST -->
<div class="entry">
  <h2><a href="?p=productsMore&amp;iProduct=$aList[iProduct]" title="$aList[sName]">$aList[sName]</a></h2>
  <h5>$aList[sCategories]</h5>
  $aList[sPhoto]
  <p>$aList[sDescriptionShort]</p>
  <a href="?p=ordersBasket&amp;sOption=add&amp;iProduct=$aList[iProduct]&amp;iQuantity=1" class="cart" title="$lang[Add_to_basket]">$aList[fPrice]&nbsp;$config[currency_symbol]</a>
  <div class="clear"></div>
</div>
<!-- END LIST_LIST -->
<!-- BEGIN LIST_FOOTER -->
<div id="pages">$lang[Pages]: $aList[sPages]</div>
<!-- END LIST_FOOTER -->
<!-- BEGIN NOT_FOUND -->
<div id="message">
  <div id="error">
      $lang[products_not_found]<br />
      <a href="javascript:history.back();">&laquo; $lang[go_back]</a>
  </div>
</div>
<!-- END NOT_FOUND -->

<!-- BEGIN TREE_PARENT --><a href="?p=productsList&amp;iCategory=$aListTree[iParent]">$aListTree[sParent]</a><!-- END TREE_PARENT -->

<!-- BEGIN PARENT_SEPARATOR -->&raquo;<!-- END PARENT_SEPARATOR -->

<!-- BEGIN TREE_CHILD --><a href="?p=productsList&amp;iCategory=$aListTree[iChild]">$aListTree[sChild]</a><!-- END TREE_CHILD -->

<!-- BEGIN TREE_SEPARATOR -->|<!-- END TREE_SEPARATOR -->
