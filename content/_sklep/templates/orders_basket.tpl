<!-- BEGIN LIST_HEAD -->
<div class="order">
  <h2>$lang[Order] &#8211; $lang[basket]</h2>
  <form action="?p=$p&amp;sOption=save" method="post"><fieldset>
  <table id="order_table" cellspacing="0">
    <tr>
      <th>
        $lang[Name]
      </th>
      <th>
        $lang[Price]&nbsp;[$config[currency_symbol]]
      </th>
      <th>
        $lang[Quantity]
      </th>
      <th>
        $lang[Summary]&nbsp;[$config[currency_symbol]]
      </th>
      <th>
        &nbsp;
      </th>
    </tr>
<!-- END LIST_HEAD -->
<!-- BEGIN LIST_LIST -->
    <tr>
      <td>
        <a href="?p=productsMore&amp;iProduct=$aList[iProduct]">$aList[sProduct]</a>
      </td>
      <td>
        $aList[fPrice]
      </td>
      <td>
        <fieldset><input type="text" name="aElements[$aList[iElement]]" value="$aList[iQuantity]" maxlength="3" size="2" /></fieldset>
      </td>
      <td>
        $aList[fSummary]
      </td>
      <td>
        <a href="?p=$p&amp;sOption=del&amp;iElement=$aList[iElement]">$lang[Delete]</a>
      </td>
    </tr>
<!-- END LIST_LIST -->
<!-- BEGIN LIST_FOOTER -->
    <tr>
      <th colspan="3">
        $lang[Summary_basket]
      </th>
      <th>
        $aList[fSummary]
      </th>
      <th>
        &nbsp;
      </th>
    </tr>
    <tr class="tfoot">
      <td colspan="3">
        <fieldset><input type="submit" value="$lang[Calc]" class="submit" /></fieldset>
      </td>
      <td colspan="2">
        <fieldset><input type="submit" name="sSave" value="$lang[Next] &raquo;" class="submit" /></fieldset>
      </td>
    </tr>
  </table>
  </fieldset>
  </form>
  <div id="back">&laquo; <a href="javascript:history.back();">$lang[back]</a></div>
</div>
<!-- END LIST_FOOTER -->
<!-- BEGIN NOT_FOUND -->
<div id="message">
  <div id="error">
    $lang[basket_is_empty]<br />
    <a href="?p=">&laquo; $lang[homepage]</a>
  </div>
</div>
<!-- END NOT_FOUND -->
