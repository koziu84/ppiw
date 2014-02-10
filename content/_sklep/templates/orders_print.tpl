<!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
<!-- BEGIN SHOW -->
<h2>$lang[Order_id] $iOrder</h2>
<table cellspacing="0" id="order_delivery">
  <tr>
    <th>
      $lang[First_name]:
    </th>
    <td>
      $aData[sFirstName]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Last_name]:
    </th>
    <td>
      $aData[sLastName]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Company]:
    </th>
    <td>
      $aData[sCompanyName]
    </td>
  </tr>
  <!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
  <tr>
    <th>
      $lang[NIP]:
    </th>
    <td>
      $aData[sNIP]
    </td>
  </tr>
  <!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
  <tr>
    <th>
      $lang[Street]:
    </th>
    <td>
      $aData[sStreet]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Zip_code]:
    </th>
    <td>
      $aData[sZipCode]
    </td>
  </tr>
  <tr>
    <th>
      $lang[City]:
    </th>
    <td>
      $aData[sCity]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Telephone]:
    </th>
    <td>
      $aData[sTelephone]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Email]:
    </th>
    <td>
      $aData[sEmail]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Ip]:
    </th>
    <td>
      $aData[sIp]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Date]:
    </th>
    <td>
      $aData[sDate]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Comment_order]:
    </th>
    <td>
      $aData[sComment]
    </td>
  </tr>
</table>
<!-- END SHOW -->

<!-- BEGIN LIST_HEAD -->
<table cellspacing="0" id="order_table">
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
  </tr>
<!-- END LIST_HEAD -->

<!-- BEGIN LIST_LIST -->
  <tr>
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
  <tr>
    <th colspan="3">
      $lang[Summary_basket]
    </th>
    <th>
      $aList[fSummary]
    </th>
  </tr>
<!-- END LIST_FOOTER -->

<!-- BEGIN COURIER -->
<!-- Modyfied by Wieslaw Klimiuk (07.03.2009) -->
<!--
  <tr>
    <td colspan="3">
      $lang[Delivery_cost] - $aData[sCourier]
    </td>
    <td>
      $aData[fCourierPrice]
    </td>
  </tr>
  <tr>
    <th colspan="3">
      $lang[Summary_cost]
    </th>
    <th>
      $aData[fSummary]
    </th>
  </tr>
-->
<!-- Modyfied by Wieslaw Klimiuk (07.03.2009) -->
</table>
<!-- Modyfied by Wieslaw Klimiuk (07.03.2009) -->
<small>$lang[Data_addresss_agreement]</small>
<!-- Modyfied by Wieslaw Klimiuk (07.03.2009) -->
<!-- END COURIER -->

<!-- BEGIN NOT_FOUND -->
<div id="message">
  <div id="error">
      $lang[basket_is_empty]<br />
      <a href="javascript:history.back();">&laquo; $lang[go_back]</a>
  </div>
</div>
<!-- END NOT_FOUND -->
