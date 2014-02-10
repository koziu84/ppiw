<!-- BEGIN COLUMNS_ONE -->
<div id="category_content">
  <h2>$aData[sName]</h2>
  $aData[sDescriptionFull]
  $aFiles[sFiles]
  $sSubcategories
</div>
<div style="clear: right;"></div>
<!-- END COLUMNS_ONE -->

<!-- BEGIN COLUMNS_TWO -->
<div id="category_content">
  <div id="panel">
    $sContentPanel
  </div>
  <h2>$aData[sName]</h2>
  $aData[sDescriptionFull]
  $aFiles[sFiles]
  $sSubcategories
</div>
<!-- END COLUMNS_TWO -->

<!-- BEGIN COLUMNS_TWO_CONTACT -->
<div id="category_content">
  <div id="contact">
    <h2>$aData[sName]</h2>
    $aData[sDescriptionFull]
    $aFiles[sFiles]
    $sSubcategories
  </div>
  <div id="contact_panel">
      $sContentPanel
  </div>
  <div class="clear"></div>
</div>
<!-- END COLUMNS_TWO_CONTACT -->

<!-- BEGIN PHOTO_DEFAULT -->
<div>
  <a href="javascript:windowGallery( $aList[iFile], $aData[iCategory], 2 );"><img src="$aList[sPhotoSmall]"  alt="$aList[sDescription]" title="$aList[sDescription]" /></a>
</div>
<!-- END PHOTO_DEFAULT -->

<!-- BEGIN PHOTO_HEAD -->
<!-- END PHOTO_HEAD -->

<!-- BEGIN PHOTO_LIST -->
<div>
  <a href="javascript:windowGallery( $aList[iFile], $aData[iCategory], 2 );"><img src="$aList[sPhotoSmall]" alt="$aList[sDescription]" title="$aList[sDescription]" /></a> 
</div>
<!-- END PHOTO_LIST -->

<!-- BEGIN PHOTO_FOOTER -->
<!-- END PHOTO_FOOTER -->

<!-- BEGIN FILES_HEAD -->
	<div class="content_flist">$lang[Files]:</div>
<!-- END FILES_HEAD -->

<!-- BEGIN FILES_LIST -->
<div class="content_flist">
  <img src="$config[dir_files]$config[dir_ext]$aList[sIcon].gif" alt="" />&nbsp;<a href="javascript:windowNew( '$config[dir_files]$config[dir_categories_files]$aList[sFile]' );" title="$aList[sDescription]">$aList[sFile]</a>,&nbsp;$aList[sDescription]
</div>
<!-- END FILES_LIST -->

<!-- BEGIN FILES_FOOTER -->
<!-- END FILES_FOOTER -->

<!-- BEGIN LIST_HEAD -->
<div class="subList">
<!-- END LIST_HEAD -->

<!-- BEGIN SUB -->
<div class="subListItem">
  <a href="?p=p_$aList[iCategory]&amp;sName=$aList[sName]">$aList[sName]</a>
  <p>$aList[sDescriptionShort]</p>
</div>
<!-- END SUB -->

<!-- BEGIN SUB_PHOTO -->
<div class="subListItem">
  <div class="itemPhoto">$aList[sPhoto]</div>
  <a href="?p=p_$aList[iCategory]&amp;sName=$aList[sName]">$aList[sName]</a>
  <p>$aList[sDescriptionShort]</p>
  <div class="clear">&nbsp;</div>
</div>
<!-- END SUB_PHOTO -->

<!-- BEGIN LIST_FOOTER -->
</div>
<!-- END LIST_FOOTER -->

<!-- BEGIN PHOTO -->
<a href="?p=p_$aList[iCategory]&amp;sName=$aList[sName]"><img src="$aList[sPhotoSmall]" class="photo" alt="" /></a>
<!-- END PHOTO -->

<!-- BEGIN NO_PHOTO -->
<!-- END NO_PHOTO -->
