<!-- BEGIN COLUMNS_ONE -->
<div id="category_content">
  <h2>$aData[sName]</h2>
  $aData[sDescriptionFull]
  $aFiles[sFiles]
</div>
<!-- END COLUMNS_ONE -->

<!-- BEGIN COLUMNS_TWO -->
<div>
  <div id="category_content">
    <div id="panel">
      $sContentPanel
    </div>
    <h2>$aData[sName]</h2>
    $aData[sDescriptionFull]
    $aFiles[sFiles]
    <div class="clear"></div>
  </div>
</div>
<!-- END COLUMNS_TWO -->

<!-- BEGIN PHOTO_DEFAULT -->
<div>
  <a href="javascript:windowGallery( $aList[iFile], $aData[iCategory], 2 );"><img src="$aList[sPhotoSmall]"  alt="$aList[sDescription]" title="$aList[sDescription]" /></a>
</div>
<!-- END PHOTO_DEFAULT -->

<!-- BEGIN PHOTO_HEAD -->
<!-- END PHOTO_HEAD -->

<!-- BEGIN PHOTO_LIST -->
<div>
  <a href="javascript:windowGallery( $aList[iFile], $aData[iCategory], 2 );"><img src="$aList[sPhotoSmall]"  alt="$aList[sDescription]" title="$aList[sDescription]" /></a>
</div>
<!-- END PHOTO_LIST -->

<!-- BEGIN PHOTO_FOOTER -->
<!-- END PHOTO_FOOTER -->

<!-- BEGIN FILES_HEAD -->
<!-- END FILES_HEAD -->

<!-- BEGIN FILES_LIST -->
<div class="content_flist">
  <img src="$config[dir_files]$config[dir_ext]$aList[sIcon].gif" alt="" />&nbsp;<a href="javascript:windowNew( '$config[dir_files]$config[dir_categories_files]$aList[sFile]' );" title="$aList[sDescription]">$aList[sFile]</a>, $aList[sDescription]
</div>
<!-- END FILES_LIST -->

<!-- BEGIN FILES_FOOTER -->
<!-- END FILES_FOOTER -->