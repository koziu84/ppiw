<!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
<!-- BEGIN SHOW -->
<h2>$lang[Order_id] $iOrder</h2>
<br />
<table cellspacing="0" class="order_delivery">
  <tr>
    <td class="label">
      $lang[First_name]:
    </td>
    <td>
      $aData[sFirstName]
    </td>
  </tr>
  <tr>
    <td class="label">
      $lang[Last_name]:
    </td>
    <td>
      $aData[sLastName]
    </td>
  </tr>
  <tr>
    <td class="label">
      $lang[Company]:
    </td>
    <td>
      $aData[sCompanyName]
    </td>
  </tr>
  <!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
  <tr>
    <td class="label">
      $lang[NIP]:
    </td>
    <td>
      $aData[sNIP]
    </td>
  </tr>
  <!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
  <tr>
    <td class="label">
      $lang[Street]:
    </td>
    <td>
      $aData[sStreet]
    </td>
  </tr>
  <tr>
    <td class="label">
      $lang[Zip_code]:
    </td>
    <td>
      $aData[sZipCode]
    </td>
  </tr>
  <tr>
    <td class="label">
      $lang[City]:
    </td>
    <td>
      $aData[sCity]
    </td>
  </tr>
  <tr>
    <td class="label">
      $lang[Telephone]:
    </td>
    <td>
      $aData[sTelephone]
    </td>
  </tr>
  <tr>
    <td class="label">
      $lang[Email]:
    </td>
    <td>
      $aData[sEmail]
    </td>
  </tr>
  <tr>
    <td class="label">
      $lang[Ip]:
    </td>
    <td>
      $aData[sIp]
    </td>
  </tr>
  <tr>
    <td class="label">
      $lang[Date]:
    </td>
    <td>
      $aData[sDate]
    </td>
  </tr>
  <tr>
    <td class="label">
      $lang[Comment_order]:
    </td>
    <td>
      $aData[sComment]
    </td>
  </tr>
</table>
<!-- END SHOW -->

<!-- BEGIN LIST_HEAD -->
<br />
<table cellspacing="0" class="order_table">
  <tr class="order_table_head">
    <td>
      $lang[Name]
    </td>
    <td>
      $lang[Price]&nbsp;[$config[currency_symbol]]
    </td>
    <td>
      $lang[Quantity]
    </td>
    <td>
      $lang[Summary]&nbsp;[$config[currency_symbol]]
    </td>
  </tr>
<!-- END LIST_HEAD -->

<!-- BEGIN LIST_LIST -->
  <tr class="order_table_body">
    <td>
      $aList[sProduct]
    </td>
    <td>
      $aList[fPrice]
    </td>
    <td>
      $aList[iQuantity]
    </td>
    <td>
      $aList[fSummary]
    </td>
  </tr>
<!-- END LIST_LIST -->
<!-- BEGIN LIST_FOOTER -->
  <tr class="order_table_footer">
    <td colspan="3">
      $lang[Summary_basket]
    </td>
    <td>
      $aList[fSummary]
    </td>
  </tr>
<!-- END LIST_FOOTER -->

<!-- BEGIN COURIER -->
  <tr class="order_table_body">
    <td colspan="3">
      $lang[Delivery_cost] - $aData[sCourier]
    </td>
    <td>
      $aData[fCourierPrice]
    </td>
  </tr>
  <tr class="order_table_footer">
    <td colspan="3">
      $lang[Summary_cost]
    </td>
    <td>
      $aData[fSummary]
    </td>
  </tr>
</table>
<!-- END COURIER -->

<!-- BEGIN NOT_FOUND -->
<div id="message">
  <div id="error">
    $lang[basket_is_empty]<br />
    <a href="javascript:history.back();">&laquo; $lang[go_back]</a>
  </div>
</div>
<!-- END NOT_FOUND -->
