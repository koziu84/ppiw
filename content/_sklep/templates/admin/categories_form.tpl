<!-- BEGIN CATEGORY_FORM -->
<script type="text/javascript">
<!--

var aCheckFormType = Array(
    Array( "sName" )
    ,Array( "iType" )
    ,Array( "iPosition", "int", "-99", null, ">=" )
    ,Array( "iPosition", "int", "999", null, "<=" )
  );
var aCheckFormNoType = Array(
    Array( "sName" )
    ,Array( "iPosition", "int", "-99", null, ">=" )
    ,Array( "iPosition", "int", "999", null, "<=" )
  );

aCheckForm = aCheckFormType;

function checkType( oCategorySelect ){
  if( !oCategorySelect )
    oCategorySelect = oCategorySelectDefault;
  if( oCategorySelect.value == "" ){
    gEBI( "oTrType" ).style.display = "";
    aCheckForm = aCheckFormType;
  }
  else{
    gEBI( "oTrType" ).style.display = "none";
    aCheckForm = aCheckFormNoType;
  }
} // end function checkType
/*
window.onload = function(){
  checkType( gEBI( "oCategorySelect" ) );
}
*/

//-->
</script>

<div id="list_title">
  $lang[Category_data]
</div>

<script type="text/javascript" src="$config[dir_js]checkForm.js"> </script>
<form action="?p=$p" method="post" id="form" enctype="multipart/form-data" onsubmit="return checkForm( this, aCheckForm );">
  <table cellspacing="0" id="form_table">
    <tr>
      <th>
        <strong>$lang[Name]</strong>
      </th>
      <td>
        <input type="text" name="sName" value="$aData[sName]" class="input" size="50" maxlength="70" /> $sDeleteSite
      </td>
    </tr>
    <tr>
      <th>
        $lang[ParentCategory]
      </th>
      <td>
        <select name="iParent" class="input" id="oCategorySelect" onchange="checkType( this );">
          <option value="">$lang[noSubcategory]</option>
          <option value="">-------------</option>
          $sCategorySelect
        </select>
      </td>
    </tr>
    <tr id='oTrType'>
      <th>
        <strong>$lang[Type]</strong>
      </th>
      <td>
        <select name="iType" class="input" id="oTypeSelect">
          <option value="">$lang[choose]</option>
          $sTypeSelect
        </select>
      </td>
    </tr>
    <tr>
      <th>
        $lang[Short_description]
      </th>
      <td>
        <textarea name="sDescriptionShort" class="input" rows="6" cols="80">$aData[sDescriptionShort]</textarea>
      </td>
    </tr>
    <tr>
      <th>
        $lang[Full_description]
      </th>
      <td>
        $sHtmlEditor
      </td>
    </tr>
    <tr>
      <td colspan="2">
        $lang[Position]&nbsp;
        <input type="text" name="iPosition" value="$aData[iPosition]" class="label" size="3" maxlength="3" />
        -99 ... 999
        &nbsp;&nbsp;|&nbsp;&nbsp;
        $lang[Visible]&nbsp;
        <select name="iStatus">
          $sStatusSelect
        </select>
      </td>
    </tr>
    $sFilesForm
    <tr class="formsave">
      <td colspan="2">
        <input type="hidden" name="iCategory" value="$iCategory" />
        <input type="hidden" name="sOption" value="save" />
        <input type="submit" value="$lang[save] &raquo;" />
      </td>
    </tr>    
  </table>
	<div id="form_back">
		&laquo; <a href="javascript:history.back()">$lang[go_back]</a>
	</div>
</form>

<script type="text/javascript">
<!--
var oCategorySelectDefault = gEBI( "oCategorySelect" );
window.onload = function(){
  checkType( );
  editInit( );
}
/*
AddOnload( 'checkType' );
AddOnload( 'editInit' );
*/
//-->
</script>

<!-- END CATEGORY_FORM -->

<!-- BEGIN FILES_FORM -->
    <tr>
      <th>$lang[Files]</th>
      <td>
        <table cellspacing="0" id="files_table">
          $aFiles[sPhotosDefault]
          $aFiles[sPhotos]
          $aFiles[sFiles]
          <tr>
            <td colspan="3" class="title">
              $lang[Add_file]
            </td>            
          </tr>
          <tr class="description">
            <td>
              $lang[File]
            </td>
            <td>
              $lang[Description]
            </td>
            <td>
              $lang[Image_size] [px]
            </td>
          </tr>
          <tr>
            <td>
              <input type="file" name="aFile[]" value="" size="30" />
            </td>
            <td>
              <input type="text" name="aFileDescription[]" value="" maxlength="40" size="25" />
            </td>
            <td>
              <input type="text" name="aPhotoSize[]" value="$config[categories_photo_size]" maxlength="3" size="5" />
            </td>
          </tr>
          <tr>
            <td>
              <input type="file" name="aFile[]" value="" size="30" />
            </td>
            <td>
              <input type="text" name="aFileDescription[]" value="" maxlength="40" size="25" />
            </td>
            <td>
              <input type="text" name="aPhotoSize[]"  value="$config[categories_photo_size]" maxlength="3" size="5" />
            </td>
          </tr>
          <tr>
            <td>
              <input type="file" name="aFile[]" value="" size="30" />
            </td>
            <td>
              <input type="text" name="aFileDescription[]" value="" maxlength="40" size="25" />
            </td>
            <td>
              <input type="text" name="aPhotoSize[]" value="$config[categories_photo_size]" maxlength="3" size="5" />
            </td>
          </tr>
        </table> 
      </td>
    </tr>
<!-- END FILES_FORM -->

<!-- BEGIN PHOTO_DEFAULT -->
  <tr>
		<td colspan="3" class="title">
			$lang[Added_files]
		</td>            
	</tr>
	<tr class="description">
    <td>
			$lang[Name]
		</td>
		<td>
      $lang[Description]
    </td>
		<td>
      $lang[Delete]
    </td>    
  </tr>
  <tr>
    <td>
			<strong>$aList[sFile]</strong> [<a href="javascript:windowPhoto( '$aList[sPhotoBig]' );">$lang[big]</a>] [<a href="javascript:windowPhoto( '$aList[sPhotoSmall]' );">$lang[small]</a>]
		</td>
		<td>
      <input type="text"    name="aFileDescriptionChange[$aList[iFile]]" value="$aList[sDescription]" maxlength="40" size="25" />
      <input type="hidden"  name="aFileNameChange[$aList[iFile]]" value="$aList[sFile]" />
      <input type="hidden"  name="aFileType[$aList[iFile]]" value="$aList[iType]" />
    </td>
		<td>
      <input type="checkbox" name="aDelFile[]" value="$aList[iFile]" />
    </td>
    
  </tr>
<!-- END PHOTO_DEFAULT -->

<!-- BEGIN PHOTO_HEAD -->
<!-- END PHOTO_HEAD -->

<!-- BEGIN PHOTO_LIST -->
  <tr>
    <td>  
			$aList[sFile] [<a href="javascript:windowPhoto( '$aList[sPhotoBig]' );">$lang[big]</a>] [<a href="javascript:windowPhoto( '$aList[sPhotoSmall]' );">$lang[small]</a>]
    </td>
		<td>
      <input type="text" name="aFileDescriptionChange[$aList[iFile]]" value="$aList[sDescription]" maxlength="40" size="25" />
      <input type="hidden"  name="aFileNameChange[$aList[iFile]]" value="$aList[sFile]" />
      <input type="hidden"  name="aFileType[$aList[iFile]]" value="$aList[iType]" />
    </td>
		<td>
      <input type="checkbox" name="aDelFile[]" value="$aList[iFile]" />
    </td>
    
  </tr>
<!-- END PHOTO_LIST -->

<!-- BEGIN PHOTO_FOOTER -->
<!-- END PHOTO_FOOTER -->

<!-- BEGIN FILES_HEAD -->
<!-- END FILES_HEAD -->

<!-- BEGIN FILES_LIST -->
  <tr>
    <td>
			<a href="$config[dir_files]$config[dir_categories_files]$aList[sFile]" target="_blank">$aList[sFile]</a>
    </td>
		<td>
      <input type="text" name="aFileDescriptionChange[$aList[iFile]]" value="$aList[sDescription]" maxlength="40" size="25" />
      <input type="hidden"  name="aFileNameChange[$aList[iFile]]" value="$aList[sFile]" />
      <input type="hidden"  name="aFileType[$aList[iFile]]" value="$aList[iType]" />
    </td>
		<td>
      <input type="checkbox" name="aDelFile[]" value="$aList[iFile]" />
    </td>
    
  </tr>
<!-- END FILES_LIST -->

<!-- BEGIN FILES_FOOTER -->
<!-- END FILES_FOOTER -->