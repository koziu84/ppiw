<!-- BEGIN HEAD -->
<div id="list_title">
  $lang[Category_list]
</div>
<!-- END HEAD -->

<!-- BEGIN LIST_HEAD -->
<table id="list_table" cellspacing="0">
  <tr class="listhead">
    <td>
      ID
    </td>
    <td>
      $lang[Title]
    </td>
    <td>
      $lang[Position]
    </td>
    <td>
      &nbsp;
    </td>
  </tr>
<!-- END LIST_HEAD -->

<!-- BEGIN LIST_TYPE -->
  <tr class="listbody_type">
    <td colspan="4">
      $aTypes[iType] - $aTypes[sName]
    </td>
  </tr>
<!-- END LIST_TYPE -->

<!-- BEGIN LIST_LIST -->
  <tr class="listbody_0">
    <td>
      $aList[iCategory]
    </td>
    <td class="listbodystatus_$aList[iStatus]">
      <a href='?p=$aActions[g]Form&amp;iCategory=$aList[iCategory]'>$aList[sName]</a> 
    </td>
    <td>
      $aList[iPosition]
    </td>
    <th>
      <a href='?p=$aActions[g]Form&amp;iCategory=$aList[iCategory]'><img src='$config[dir_files]img/edit.gif' alt='$lang[edit]' title='$lang[edit]' /></a>$aList[sDelLink]
    </th>
  </tr>
<!-- END LIST_LIST -->

<!-- BEGIN SUB -->
  <tr class="listbody_1">
    <td>
      $aList[iCategory]
    </td>
    <td class="listbodystatus_$aList[iStatus]">
      <a href='?p=$aActions[g]Form&amp;iCategory=$aList[iCategory]'>$aList[sName]</a>
    </td>
    <td>
      $aList[iPosition]
    </td>
    <th>
      <a href="?p=$aActions[g]Form&amp;iCategory=$aList[iCategory]"><img src="$config[dir_files]img/edit.gif" alt="$lang[edit]" title="$lang[edit]" /></a>$aList[sDelLink]
    </th>
  </tr>
<!-- END SUB -->

<!-- BEGIN LIST_FOOTER -->
	<tr class="listfooter">
    <td colspan="4">
    </td>    
  </tr>
</table>
<!-- END LIST_FOOTER -->

<!-- BEGIN DELETE_SITE -->
      <a href="?p=$aActions[g]Delete&amp;iCategory=$aList[iCategory]" onclick="return del( );"><img src="$config[dir_files]img/del.gif" alt="$lang[delete]" title="$lang[delete]" /></a>
<!-- END DELETE_SITE -->

<!-- BEGIN NO_PHOTO -->
<!-- END NO_PHOTO -->

<!-- BEGIN NOT_FOUND -->
<br /><br />
<div id="message">
  <div id="error">
      $lang[Not_found]
      <br />
      <a href="javascript:history.back()">$lang[go_back]</a>
  </div>
</div>
<!-- END NOT_FOUND -->
