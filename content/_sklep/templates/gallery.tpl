<!-- BEGIN SHOW -->
<script type="text/javascript" src="$config[dir_js]gallery.js"></script>
<script type="text/javascript">
<!--

var aPhotos = Array( );
var aIndexes = Array( );
$aGalleryFiles[sPhotosDefault]
$aGalleryFiles[sPhotos]
var iPhoto = "$iId";

window.onload = function (){
  loadImg( aIndexes[iPhoto] );
  window.focus( );
} // end function 

//-->
</script>


<div id="oPhotoDiv"><img id="oPhoto" src="/" alt="" title="" /></div>
<div id="butt">
  <div>&nbsp;<a href="javascript:void(0);" id="oLL">&laquo; &laquo; &laquo; &laquo;</a>&nbsp;</div>
  <div>&nbsp;<a href="javascript:void(0);" id="oLR">&raquo; &raquo; &raquo; &raquo;</a>&nbsp;</div>
</div>
<!-- END SHOW -->

<!-- BEGIN PHOTO_DEFAULT -->
  aIndexes[$aList[iFile]] = aPhotos.length;
	aPhotos[aPhotos.length] = Array( "$aList[sPhotoSmall]", "$aList[sPhotoBig]", "$aList[sDescription]" );
<!-- END PHOTO_DEFAULT -->

<!-- BEGIN PHOTO_HEAD -->
<!-- END PHOTO_HEAD -->

<!-- BEGIN PHOTO_LIST -->
  aIndexes[$aList[iFile]] = aPhotos.length;
	aPhotos[aPhotos.length] = Array( "$aList[sPhotoSmall]", "$aList[sPhotoBig]", "$aList[sDescription]" );
<!-- END PHOTO_LIST -->

<!-- BEGIN PHOTO_FOOTER -->
<!-- END PHOTO_FOOTER -->

<!-- BEGIN FILES_HEAD -->
<!-- END FILES_HEAD -->

<!-- BEGIN FILES_LIST -->
<!-- END FILES_LIST -->

<!-- BEGIN FILES_FOOTER -->
<!-- END FILES_FOOTER -->