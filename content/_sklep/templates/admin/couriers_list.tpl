<!-- BEGIN HEAD -->
<div id="list_title">
  $lang[Courier_list]
</div>
<!-- END HEAD -->

<!-- BEGIN LIST_HEAD -->
<table id="list_table" cellspacing="0">
  <tr class="listhead">
    <td>
      ID
    </td>
    <td>
      $lang[Name]
    </td>
    <td>
      $lang[Price] [$config[currency_symbol]]
    </td>
    <td>
      &nbsp;
    </td>
  </tr>
<!-- END LIST_HEAD -->

<!-- BEGIN LIST_LIST -->
  <tr class="listbody_$aList[iStyle]">
    <td>
      $aList[iCourier]
    </td>
    <td>
      <a href="?p=$aActions[g]Form&amp;iCourier=$aList[iCourier]">$aList[sName]</a>
    </td>
    <td>
      $aList[fPrice]
    </td>
    <th>
      <a href="?p=$aActions[g]Form&amp;iCourier=$aList[iCourier]"><img src="$config[dir_files]img/edit.gif" alt="$lang[edit]" title="$lang[edit]" /></a>
      <a href="?p=$aActions[g]Delete&amp;iCourier=$aList[iCourier]" onclick="return del( );"><img src="$config[dir_files]img/del.gif" alt="$lang[delete]" title="$lang[delete]" /></a>
    </th>
  </tr>
<!-- END LIST_LIST -->
<!-- BEGIN LIST_FOOTER -->
	<tr class="listfooter">
    <td colspan="4">
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