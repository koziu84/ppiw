<!-- BEGIN SHOW -->
<div class="fullentry">
  <div id="addcart">
		<div id="addcart_title">
			$lang[Buy_now]
		</div>
		<div id="cart">
			$lang[Price]:&nbsp;$aData[sFormattedPrices]
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
  <div id="attrPrint">$sAttributePicklists</div>
  <div>
    $aFiles[sPhotos]
  </div>
	
	<div class="clear"></div>
</div>
<!-- END SHOW -->
<!-- BEGIN FORMATTED_STANDARD_PRICE -->
$config[currency_symbol]&nbsp;$aData[fPrice]
<!-- END FORMATTED_STANDARD_PRICE -->
<!-- BEGIN FORMATTED_SPECIAL_PRICE -->
<span id='paSpecialPrice'>$config[currency_symbol]&nbsp;$aData[fSpecialPrice]</span><br /><span id='paOldPrice'>$config[currency_symbol]&nbsp;$aData[fPrice]</span>
<!-- END FORMATTED_SPECIAL_PRICE -->
