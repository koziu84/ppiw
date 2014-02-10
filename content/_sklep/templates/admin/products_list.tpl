<!-- BEGIN HEAD -->
<div id="list_title">
  $lang[Products_list]
</div>

<div id="list_form">
  <div class="search_form" style="">
    <form action="" method="get">
      <input type="hidden" name="p" value="$p" />
      <input type="text" name="sWord" value="$sWord" class="input" size="30" />
      <input type="submit" value="$lang[Search]" />
    </form>
  </div>
  <div class="categories_form">
    <form action="" method="get">
      $lang[Category]:
      <input type="hidden" name="p" value="$p" />
      <select name="iCategory" class="input">
        <option value="">$lang[All]</option>
        $sSelectCategory
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
      $lang[Name]
    </td>
    <td>
      $lang[Categories]
    </td>
    <td>
      $lang[Price] [$config[currency_symbol]]
    </td>
    <td>
      $lang[Position]
    </td>
    <td>
      &nbsp;
    </td>
  </tr>
<!-- END LIST_HEAD -->
<!-- BEGIN PHOTO -->
<!-- END PHOTO -->
<!-- BEGIN LIST_LIST -->
  <tr class="listbody_$aList[iStyle]">
    <td>
      $aList[iProduct]
    </td>
    <td class="listbodystatus_$aList[iStatus]">
      <a href="?p=$aActions[g]Form&amp;iProduct=$aList[iProduct]">$aList[sName]</a>
    </td>
    <td>
      $aList[sCategories]
    </td>
    <td>
      $aList[fPrice]
    </td>
    <td>
      $aList[iPosition]
    </td>
    <th>
      <a href="?p=$aActions[g]Form&amp;iProduct=$aList[iProduct]"><img src="$config[dir_files]img/edit.gif" alt="$lang[edit]" title="$lang[edit]" /></a>
      <a href="?p=$aActions[g]Delete&amp;iProduct=$aList[iProduct]" onclick="return del( );"><img src="$config[dir_files]img/del.gif" alt="$lang[delete]" title="$lang[delete]" /></a>
    </th>
  </tr>
<!-- END LIST_LIST -->
<!-- BEGIN LIST_FOOTER -->
       <tr class="listfooter">
    <td colspan="6">
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

<!-- BEGIN TREE_PARENT -->
$aListTree[sParent]
<!-- END TREE_PARENT -->

<!-- BEGIN PARENT_SEPARATOR -->
 &raquo; 
<!-- END PARENT_SEPARATOR -->

<!-- BEGIN TREE_CHILD -->
$aListTree[sChild]
<!-- END TREE_CHILD -->

<!-- BEGIN TREE_SEPARATOR -->
 | 
<!-- END TREE_SEPARATOR -->
