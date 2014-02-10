<!-- BEGIN DELIVERY -->
        <tr>
          <td colspan="3">
            $lang[Delivery_cost]
          </td>
          <td id="deliveryCost">
            0.00
          </td>
        </tr>
$aList[sTadDelivery]
<!-- END DELIVERY -->
<!-- BEGIN DELIVERY_DISCOUNT -->
        <tr>
          <td colspan='3'>
            $aList[sDiscountRate] $lang[Discount_description]
          </td>
          <td id='discountCost'>
            $aList[fDiscount]
          </td>
        </tr>
<!-- END DELIVERY_DISCOUNT -->
<!-- BEGIN DELIVERY_SUBEXTAX -->
        <tr>
          <td colspan='3'>
            $lang[Tax_subtotalExTax]
          </td>
          <td id='exTaxCost' style='font-weight:bold;'>
            0.00
          </td>
        </tr>
<!-- END DELIVERY_SUBEXTAX -->
<!-- BEGIN DELIVERY_TAX -->
        <tr>
          <td colspan='3'>
            $lang[Tax_description]
          </td>
          <td id='taxCost'>
            0.00
          </td>
        </tr>
<!-- END DELIVERY_TAX -->
<!-- BEGIN DELIVERY_SUMMARY -->
        <tr class="order_table">
          <th colspan="3">
            $lang[Summary_cost]
          </th>
          <th id="summaryCost">
            $aList[fSummary]
          </th>
        </tr>
        <tr class="tfoot">
          <td colspan="4">
            <input type="submit" value="$lang[send]" class="submit" />
          </td>
        </tr>
      </table>
    </div>
  </fieldset>
</form>
<script language="javascript" type="text/javascript">
<!--
var tadTaxRate = $config[tax_rate];
var tadDiscountedValue = $aList[fSummary];
var tadAddTaxToTotal = $aList[bTadTaxToTotal];
var tadTaxAsAbsolute = $aList[bTadTaxAbsolute];
var tadTaxDelivery = $aList[bTadTaxDelivery];
//-->
</script>
<script type='text/javascript' src='$config[dir_plugins]taxAndDiscount/taxAndDiscount.js'> </script>
<!-- END DELIVERY_SUMMARY -->

<!-- BEGIN DELIVERY_PRINT -->
  <tr>
    <td colspan="3">
      $lang[Delivery_cost] - $aData[sCourier]
    </td>
    <td>
      $aData[fCourierPrice]
    </td>
  </tr>
$aData[sTadDelivery]
<!-- END DELIVERY_PRINT -->
<!-- BEGIN DELIVERY_DISCOUNT_PRINT -->
  <tr>
    <td colspan='3'>
      $aData[fDiscountRate] $lang[Discount_description]
    </td>
    <td>
      $aData[fDiscount]
    </td>
  </tr>
<!-- END DELIVERY_DISCOUNT_PRINT -->
<!-- BEGIN DELIVERY_SUBEXTAX_PRINT -->
  <tr>
    <td colspan='3'>
      $lang[Tax_subtotalExTax]
    </td>
    <td style='font-weight:bold;'>
      $aData[fSubExTax]
    </td>
  </tr>
<!-- END DELIVERY_SUBEXTAX_PRINT -->
<!-- BEGIN DELIVERY_TAX_PRINT -->
  <tr>
    <td colspan='3'>
      $lang[Tax_description]
    </td>
    <td>
      $aData[fTax]
    </td>
  </tr>
<!-- END DELIVERY_TAX_PRINT -->
<!-- BEGIN DELIVERY_SUMMARY_PRINT -->
  <tr>
    <th colspan="3">
      $lang[Summary_cost]
    </th>
    <th>
      $aData[fSummary]
    </th>
  </tr>
</table>
<!-- END DELIVERY_SUMMARY_PRINT -->

<!-- BEGIN SELECT_COUNTRY -->
<option value='$aCountries[code2]' $aCountries[selected]>$aCountries[name]</option>
<!-- END SELECT_COUNTRY -->
