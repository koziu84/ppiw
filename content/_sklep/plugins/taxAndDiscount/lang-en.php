<?php
/*
* taxAndDiscount plugin - English language file
*/
$lang['Tax_description'] = 'VAT'; // displayed on order details. For example, UK VAT
$lang['Discount_description'] = 'Discount'; // displayed on order details
$lang['Tax_subtotalExTax'] = 'Subtotal Excluding ' . $lang['Tax_description'];

$lang['PMCI']['tax']['name'] = $lang['PMCI']['tax']['alt'] = 'Enable Tax';
$lang['PMCI']['discount']['name'] = $lang['PMCI']['discount']['alt'] = 'Enable Discount';
$lang['PMCI']['tax_includeDelivery']['name'] = $lang['PMCI']['tax_includeDelivery']['alt'] = 'Tax Delivery Cost';
$lang['PMCI']['tax_includeInTotal']['name'] = $lang['PMCI']['tax_includeTotal']['alt'] = 'Include Tax in Total';
$lang['PMCI']['tax_subtotalExTax']['name'] = $lang['PMCI']['tax_subtotalExTax']['alt'] = 'SubTotal Excluding Tax';
$lang['PMCI']['tax_displayAsAbsolute']['name'] = $lang['PMCI']['tax_displayAsAbsolute']['alt'] = 'Display Tax as Absolute';
$lang['PMCI']['discount_showRate']['name'] = $lang['PMCI']['discount_showRate']['alt'] = 'Show Discount Rate';
$lang['PMCI']['tax_rate']['name'] = $lang['PMCI']['tax_rate']['alt'] = 'Tax Rate';
$lang['PMCI']['discount_rates']['name'] = $lang['PMCI']['discount_rates']['alt'] = 'Discount Rates';
$lang['PMCI']['tax']['text'] = 'Enable/Disable Tax Calculation';
$lang['PMCI']['discount']['text'] = 'Enable/Disable Discount Calculation';
$lang['PMCI']['tax_includeDelivery']['text'] = 'Include the Delivery Cost in the Tax Calculation';
$lang['PMCI']['tax_includeInTotal']['text'] = 'Include the Calculated Tax in the Overall Total';
$lang['PMCI']['tax_subtotalExTax']['text'] = 'Include an additional Sub-Total field that shows the Overall Total <span style="text-decoration:underline">excluding</span> Tax. This flag only has any effect if Tax is enabled.';
$lang['PMCI']['tax_displayAsAbsolute']['text'] = 'Always DISPLAY the Calculated Tax as a Positive Amount';
$lang['PMCI']['discount_showRate']['text'] = 'Show the applicable discount rate (if non-zero) - automatically disabled if discount includes an absolute amount';
$lang['PMCI']['tax_rate']['text'] = 'Tax rate as percentage; can be negative';
$lang['PMCI']['discount_rates']['text'] = "<br clear='left' /><div align='left'>Each sub-array = ( value-of-items, number-of-items, discount, discount-type ).<br />
 To apply discount as an absolute amount, set discount-type to 'a'; if missing or invalid, the default is percentage ('%').
 If you use both percentage rates and absolute amounts, the relevant absolute amount (if any) is applied AFTER the relevant percentage rate.
<br />For any one type of discount, sub-arrays must be in ascending order of value-of-items, and number-of-items within that.
<br />Discount is non-cumulative. It is applied when the total value of items in the basket reaches or exceeds
 the value set AND the number of items in the basket equals or exceeds the value set.
<br />Discount is only applied to basket contents (not delivery costs), and is calculated BEFORE tax.</div>";
?>
