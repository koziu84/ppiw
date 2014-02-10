<!-- BEGIN SHOW -->
<div class="fullentry">
  <div id="addcart">
		<div id="addcart_title">
			$lang[Buy_now]
		</div>
		<div id="cart">
			$lang[Price]:&nbsp;$aData[fPrice]&nbsp;$config[currency_symbol]
		</div>		
  </div>
	
	<div class="title">
		<h5>$aData[sCategories]</h5>
		<h2>$aData[sName]</h2>
	</div>

  $aFiles[sPhotosDefault]
	
	<p>
    $aData[sDescriptionFull]
  </p>
	<div class="clear"></div>
  <div>
    $aFiles[sPhotos]
  </div>
	
	<div class="clear"></div>
</div>
<!-- END SHOW -->

<!-- BEGIN PHOTO_DEFAULT -->
<div class="photo">
  <img src="$aList[sPhotoSmall]"  alt="$aList[sDescription]" title="$aList[sDescription]" />
</div>
<!-- END PHOTO_DEFAULT -->

<!-- BEGIN PHOTO_HEAD -->
<div>
<!-- END PHOTO_HEAD -->

<!-- BEGIN PHOTO_LIST -->
<div class="photo">
	<img src="$aList[sPhotoSmall]" alt="$aList[sDescription]" title="$aList[sDescription]" />
</div>
<!-- END PHOTO_LIST -->

<!-- BEGIN PHOTO_FOOTER -->
</div>
<!-- END PHOTO_FOOTER -->

<!-- BEGIN FILES_HEAD -->
<!-- END FILES_HEAD -->

<!-- BEGIN FILES_LIST -->
<!-- END FILES_LIST -->

<!-- BEGIN FILES_FOOTER -->
<!-- END FILES_FOOTER -->

<!-- BEGIN TREE_PARENT -->
$aListTree[sParent]
<!-- END TREE_PARENT -->

<!-- BEGIN PARENT_SEPARATOR -->
 &raquo; 
<!-- END PARENT_SEPARATOR -->

<!-- BEGIN TREE_CHILD -->
$aListTree[sChild]
<!-- END TREE_CHILD -->

<!-- BEGIN TREE_SEPARATOR --> | <!-- END TREE_SEPARATOR -->