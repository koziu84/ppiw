<!-- BEGIN SHOW -->
<script type="text/javascript">
<!--
  sTitle = "$aData[sName]";
//-->
</script>
<script type="text/javascript" src="$config[dir_js]checkForm.js"> </script>
<div class="fullentry">
	<div id="addcart">
		<h4>$lang[Buy_now]</h4>
		<div>
			$lang[Price]:&nbsp;$aData[fPrice]&nbsp;$config[currency_symbol]
		</div>
		<form action="" method="get" onsubmit="return checkForm( this, 
			Array(
				Array( 'iQuantity', 'int', '0', null, '>' )
			) );">
			<fieldset>
				<input type="hidden" name="p" value="ordersBasket" />
				<input type="hidden" name="sOption" value="add" />
				<input type="hidden" name="iProduct" value="$aData[iProduct]" />
				$lang[Quantity]:
				<input type="text"   name="iQuantity" value="1" maxlength="3" size="2" /><br />
				<input type="submit" value="$lang[Add_to_basket]" class="submit" />
			</fieldset>
		</form>
		<a href="javascript:windowNew( '?p=productsWindowMore&amp;iProduct=$aData[iProduct]' );" id="print">$lang[print]</a>
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

<!-- BEGIN PHOTO_DEFAULT -->
<div class="photo"><a href="javascript:windowGallery( $aList[iFile], $aData[iProduct], 1 );"><img src="$aList[sPhotoSmall]"  alt="$aList[sDescription]" title="$aList[sDescription]" /></a></div>
<!-- END PHOTO_DEFAULT -->

<!-- BEGIN PHOTO_HEAD --><div><!-- END PHOTO_HEAD -->

<!-- BEGIN PHOTO_LIST -->
<div class="photo"><a href="javascript:windowGallery( $aList[iFile], $aData[iProduct], 1 );"><img src="$aList[sPhotoSmall]" alt="$aList[sDescription]" title="$aList[sDescription]" /></a></div>
<!-- END PHOTO_LIST -->

<!-- BEGIN PHOTO_FOOTER --></div><!-- END PHOTO_FOOTER -->

<!-- BEGIN FILES_HEAD -->
<div class="filelist">
  <ul>
<!-- END FILES_HEAD -->

<!-- BEGIN FILES_LIST -->
    <li><img src="$config[dir_files]$config[dir_ext]$aList[sIcon].gif" alt="" /><a href="javascript:windowNew( '$config[dir_files]$config[dir_products_files]$aList[sFile]' );">$aList[sFile]</a>, $aList[sDescription]</li>
<!-- END FILES_LIST -->

<!-- BEGIN FILES_FOOTER -->
  </ul>
</div>
<!-- END FILES_FOOTER -->

<!-- BEGIN TREE_PARENT -->
<a href="?p=productsList&amp;iCategory=$aListTree[iParent]">$aListTree[sParent]</a>
<!-- END TREE_PARENT -->

<!-- BEGIN PARENT_SEPARATOR -->
 &raquo; 
<!-- END PARENT_SEPARATOR -->

<!-- BEGIN TREE_CHILD -->
<a href="?p=productsList&amp;iCategory=$aListTree[iChild]">$aListTree[sChild]</a>
<!-- END TREE_CHILD -->

<!-- BEGIN TREE_SEPARATOR --> | <!-- END TREE_SEPARATOR -->