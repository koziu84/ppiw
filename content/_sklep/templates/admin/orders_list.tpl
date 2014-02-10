<!-- BEGIN HEAD -->
<div id="list_title">
  $lang[Orders_list]
</div>

<div id="list_form">
  <div class="search_form">
    <form action="" method="get">
      <input type="hidden" name="p" value="$p" />
      <input type="text" name="sWord" value="$sWord" size="30" />
      <input type="submit" value="$lang[Search]" />
    </form>
  </div>
  <div class="status_form">
    <form action="" method="get">
      $lang[Status]:
      <input type="hidden" name="p" value="$p" />
      <select name="iStatus">
        <option value="">$lang[All]</option>
        $sSelectStatus
      </select>
      <input type="submit" value="Ok" />
    </form>
  </div>
</div>
<!-- END HEAD -->

<!-- BEGIN LIST_HEAD -->
<table id="list_table" cellspacing="0">
  <tr class="listhead">
    <td>
      ID
    </td>
    <td>
      $lang[First_last_name]
    </td>
    <td>
      $lang[Date]
    </td>
    <td>
      $lang[Status]
    </td>
    <td style="width:60px;">
      &nbsp;
    </td>
  </tr>
<!-- END LIST_HEAD -->

<!-- BEGIN LIST_LIST -->
  <tr class="listbody_$aList[iStyle]">
    <td>
      $aList[iOrder]
    </td>
    <td>
      $aList[sFirstName] $aList[sLastName]
    </td>
    <td>
      $aList[sDate]
    </td>
    <td>
      <a href="?p=$aActions[g]More&amp;iOrder=$aList[iOrder]">$aList[sStatus]</a>
    </td>
    <td>
      <a href="javascript:windowNew( '?p=$aActions[g]WindowPrint&amp;iOrder=$aList[iOrder]' );"><img src="$config[dir_files]img/print.gif"  alt="$lang[print]" title="$lang[print]" /></a>
      <a href="?p=$aActions[g]More&amp;iOrder=$aList[iOrder]"><img src="$config[dir_files]img/show.gif" alt="$lang[more]" title="$lang[more]" /></a>
      <a href="?p=$aActions[g]Delete&amp;iOrder=$aList[iOrder]" onclick="return del( );"><img src="$config[dir_files]img/del.gif" alt="$lang[delete]" title="$lang[delete]" /></a>
    </td>
  </tr>
<!-- END LIST_LIST -->
<!-- BEGIN LIST_FOOTER -->
       <tr class="listfooter">
    <td colspan="5">
      $lang[Pages]: $aList[sPages]
    </td>    
  </tr>
</table>
<!-- END LIST_FOOTER -->
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
