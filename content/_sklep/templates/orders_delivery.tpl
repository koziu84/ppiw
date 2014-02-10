<!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
<!-- BEGIN FORM -->
<script type="text/javascript" src="$config[dir_js]checkForm.js"></script>
<script type="text/javascript" src="$config[dir_js]ordersCouriers.js"></script>
<form action="?p=$p" method="post" onsubmit="return checkForm( this,   Array(
Array( 'sFirstName' )
,Array( 'sLastName' )
,Array( 'sStreet' )
,Array( 'sZipCode' )
,Array( 'sCity' )     
,Array( 'sTelephone' )
,Array( 'sEmail', 'email' )
,Array( 'iCourier', 'simple', '$lang[Choose_courier]' )
) );">
  <fieldset>
    <input type="hidden" name="sOption" value="send" />
    <div class="order">
      <h2>$lang[Order] &#8211; $lang[delivery_addres]</h2>
      $lang[Order_instructions]
      <br /><br />
      <table cellspacing="0">
        <tr>
          <td>
            <table cellspacing="0" id="order_delivery">
              <tr>
                <th>
                  $lang[First_name]:
                </th>
                <td>
                  <input type="text" name="sFirstName" maxlength="20" />
                </td>
              </tr>
              <tr>
                <th>
                  $lang[Last_name]:
                </th>
                <td>
                  <input type="text" name="sLastName" maxlength="40" />
                </td>
              </tr>
              <tr>
                <th>
                  $lang[Company]:
                </th>
                <td>
                  <input type="text" name="sCompanyName" maxlength="100" />
                </td>
              </tr>
              <!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
              <tr>
                <th>
                  $lang[NIP]:
                </th>
                <td>
                  <input type="text" name="sNIP" maxlength="13" />
                </td>
              </tr>
              <!-- Modyfied by Wieslaw Klimiuk (22.03.2006) -->
              <tr>
                <th>
                  $lang[Street]:
                </th>
                <td>
                  <input type="text" name="sStreet" maxlength="40" />
                </td>
              </tr>
              <tr>
                <th>
                  $lang[Zip_code]:
                </th>
                <td>
                  <input type="text" name="sZipCode" maxlength="20" />
                </td>
              </tr>
              <tr>
                <th>
                  $lang[City]:
                </th>
                <td>
                  <input type="text" name="sCity" maxlength="40" />
                </td>
              </tr>
              <tr>
                <th>
                  $lang[Telephone]:
                </th>
                <td>
                  <input type="text" name="sTelephone" maxlength="30" />
                </td>
              </tr>
              <tr>
                <th>
                  $lang[Email]:
                </th>
                <td>
                  <input type="text" name="sEmail" maxlength="40" />
                </td>
              </tr>
              <tr>
                <th>
                  $lang[Courier]:
                </th>
                <td>
                  <select name="iCourier" onchange="ordersCouriers( this );">
                    <option value="">
                    $lang[choose]
                    </option>
                    $sCourierSelect
                  </select>
                </td>
              </tr>
            </table>
          </td>
          <td id="order_comment">
            $lang[Comment_order]:
            <br />
            <textarea name="sComment" rows="7" cols=""></textarea>
          </td>
        </tr>
      </table>
<!-- END FORM -->
<!-- BEGIN LIST_HEAD -->
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
    <th id="orderCost">
      $aList[fSummary]
    </th>
  </tr>
<!-- END LIST_FOOTER -->
<!-- BEGIN COURIER -->
<!-- Modyfied by Wieslaw Klimiuk (07.03.2009) -->
<!--
        <tr>
          <td colspan="3">
            $lang[Delivery_cost]
          </td>
          <td id="deliveryCost">
            0.00
          </td>
        </tr>
        <tr class="order_table">
          <th colspan="3">
            $lang[Summary_cost]
          </th>
          <th id="summaryCost">
            $aList[fSummary]
          </th>
        </tr>
-->
<!-- Modyfied by Wieslaw Klimiuk (07.03.2009) -->
        <tr class="tfoot">
          <td colspan="4">
<!-- Modyfied by Wieslaw Klimiuk (07.03.2009) -->
            <small>$lang[Data_addresss_agreement]</small><br/>
<!-- Modyfied by Wieslaw Klimiuk (07.03.2009) -->
            <input type="submit" value="$lang[send]" class="submit" />
          </td>
        </tr>
      </table>
    </div>
  </fieldset>
</form>
<!-- END COURIER -->
<!-- BEGIN NOT_FOUND -->
<div id="message">
  <div id="error">
    $lang[basket_is_empty]
    <br />
    <a href="javascript:history.back();">&laquo; $lang[go_back]</a>
  </div>
</div>
<!-- END NOT_FOUND -->
