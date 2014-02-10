<!-- BEGIN DELIVERY -->
  <tr class="listbody_0">
    <td colspan="3" style="text-align: right;">
      $aData[sCourier]
    </td>
    <td style="text-align: right;">
      $aData[fCourierPrice]
    </td>
  </tr>
$aData[sTadDelivery]
<!-- END DELIVERY -->
<!-- BEGIN DELIVERY_DISCOUNT -->
  <tr class="listbody_0">
    <td colspan="3" style="text-align: right;">
      $aOrder[fDiscountRate] $lang[Discount_description]
    </td>
    <td style="text-align: right;">
      $aData[fDiscount]
    </td>
  </tr>
<!-- END DELIVERY_DISCOUNT -->
<!-- BEGIN DELIVERY_SUBEXTAX -->
  <tr class="listbody_0">
    <td colspan="3" style="text-align: right;">
      $lang[Tax_subtotalExTax]
    </td>
    <td style="text-align: right; font-weight: bold;">
      $aData[fSubExTax]
    </td>
  </tr>
<!-- END DELIVERY_SUBEXTAX -->
<!-- BEGIN DELIVERY_TAX -->
  <tr class="listbody_0">
    <td colspan="3" style="text-align: right;">
      $lang[Tax_description]
    </td>
    <td style="text-align: right;">
      $aData[fTax]
    </td>
  </tr>
<!-- END DELIVERY_TAX -->
<!-- BEGIN DELIVERY_SUMMARY -->
  <tr class="listbody_0">
    <td colspan="3" style="text-align: right;">
      $lang[Summary_cost]
    </td>
    <td style="text-align: right; font-weight: bold;">
      $aData[fSummary]
    </td>
  </tr>
</table>
<div id="form_back">
  &laquo; <a href="javascript:history.back()">$lang[go_back]</a>
</div>
<!-- END DELIVERY_SUMMARY -->

<!-- BEGIN DELIVERY_PRINT -->
  <tr class="order_table_body">
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
  <tr class="order_table_body">
    <td colspan="3">
      $aData[fDiscountRate] $lang[Discount_description]
    </td>
    <td>
      $aData[fDiscount]
    </td>
  </tr>
<!-- END DELIVERY_DISCOUNT_PRINT -->
<!-- BEGIN DELIVERY_SUBEXTAX_PRINT -->
  <tr class="order_table_body">
    <td colspan="3">
      $lang[Tax_subtotalExTax]
    </td>
    <td style='font-weight:bold;'>
      $aData[fSubExTax]
    </td>
  </tr>
<!-- END DELIVERY_SUBEXTAX_PRINT -->
<!-- BEGIN DELIVERY_TAX_PRINT -->
  <tr class="order_table_body">
    <td colspan="3">
      $lang[Tax_description]
    </td>
    <td>
      $aData[fTax]
    </td>
  </tr>
<!-- END DELIVERY_TAX_PRINT -->
<!-- BEGIN DELIVERY_SUMMARY_PRINT -->
  <tr class="order_table_footer">
    <td colspan="3">
      $lang[Summary_cost]
    </td>
    <td>
      $aData[fSummary]
    </td>
  </tr>
</table>
<!-- END DELIVERY_SUMMARY_PRINT -->
