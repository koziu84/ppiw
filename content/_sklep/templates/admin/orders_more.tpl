<!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
<!-- BEGIN SHOW -->
<div id="list_title">
  $lang[Order_id] $iOrder
</div>
<table cellspacing="0" id="form_table">
  <tr>
    <th>
      $lang[First_name]
    </th>
    <td>
      $aData[sFirstName]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Last_name]
    </th>
    <td>
      $aData[sLastName]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Company]
    </th>
    <td>
      $aData[sCompanyName]&nbsp;
    </td>
  </tr>
  <!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
  <tr>
    <th>
      $lang[NIP]
    </th>
    <td>
      $aData[sNIP]
    </td>
  </tr>
  <!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
  <tr>
    <th>
      $lang[Street]
    </th>
    <td>
      $aData[sStreet]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Zip_code]
    </th>
    <td>
      $aData[sZipCode]
    </td>
  </tr>
  <tr>
    <th>
      $lang[City]
    </th>
    <td>
      $aData[sCity]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Telephone]
    </th>
    <td>
      $aData[sTelephone]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Email]
    </th>
    <td>
      $aData[sEmail]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Ip]
    </th>
    <td>
      $aData[sIp]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Date]
    </th>
    <td>
      $aData[sDate]
    </td>
  </tr>
  <tr>
    <th>
      $lang[Comment_order]
    </th>
    <td>
      $aData[sComment]&nbsp;
    </td>
  </tr>
  <tr>
    <th>
      $lang[Status]
    </th>
    <td>
      <form action="" method="get" class="form">
        <input type="hidden" name="p" value="$p" />
        <input type="hidden" name="iOrder" value="$iOrder" />
        <input type="hidden" name="sOption" value="save" />
        <select name="iStatus" class="input" >
          $sStatusSelect
        </select>
        <input type="submit" value="$lang[save]" />
      </form>        
    </td>
  </tr>
</table>
<br />
<!-- END SHOW -->

<!-- BEGIN LIST_HEAD -->
<table id="list_table" cellspacing="0">
<tr class="listhead">
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
    $lang[Summary] [$config[currency_symbol]]
  </td>
</tr>
<!-- END LIST_HEAD -->

<!-- BEGIN LIST_LIST -->
<tr class="listbody_$aList[iStyle]">
  <td>
    $aList[sProduct]
  </td>
  <td class="label">
    $aList[fPrice]
  </td>
  <td class="label">
    $aList[iQuantity]
  </td>
  <td class="label">
    $aList[fSummary]
  </td>
</tr>
<!-- END LIST_LIST -->
<!-- BEGIN LIST_FOOTER -->
<tr class="listbody_0">
  <td colspan="3" class="label">
    $lang[Summary_basket]
  </td>
  <td class="label">
    $aList[fSummary]
  </td>
</tr>
<!-- END LIST_FOOTER -->

<!-- BEGIN COURIER -->
  <tr class="listbody_0">
    <td colspan="3" class="label">
      $aData[sCourier]
    </td>
    <td class="label">
      $aData[fCourierPrice]
    </td>
  </tr>
  <tr class="listbody_0">
    <td colspan="3" class="label">
      $lang[Summary_cost]
    </td>
    <td class="label">
      <b>$aData[fSummary]</b>
    </td>
  </tr>
</table>
<div id="form_back">
  &laquo; <a href="javascript:history.back();">$lang[go_back]</a>
</div>
<!-- END COURIER -->


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
