<?php
$config['tax'] = false;                     // false = no tax
$config['discount'] = false;                // false = no discount
$config['tax_rate'] = 22.0;              // tax rate as percentage; can be negative
$config['tax_includeDelivery'] = true;     // include the delivery cost in the tax calculation
$config['tax_includeInTotal'] = true;      // include the calculated tax in the overall total
$config['tax_displayAsAbsolute'] = true;  // always DISPLAY the calculated tax as a positive number
$config['tax_subtotalExTax'] = true;      // include an extra field that shows a subtotal excluding tax
$config['discount_showRate'] = true;      // show the applicable discount rate (if non-zero) - automatically disabled if discount includes an absolute amount
// DISCOUNT RATES:                      value-of-items , number-of-items , discount , discount-type
$config['discount_rates'] = array(array(     0 ,              5 ,          4.95 ,        'a' ),
array(    75 ,              0 ,          4.95 ,        'a' ),
array(    50 ,              3 ,             5 ,        '%' ),
array(   100 ,              3 ,             7 ,        '%' ),
array(   250 ,              3 ,            10 ,        '%' ),
array(   250 ,              5 ,            12 ,        '%' ));
/* DISCOUNT RATES: An array of arrays:
** Each sub-array = ( value-of-items, number-of-items , discount , discount-type ).
** To set the discount to an absolute amount, set discount-type to 'a'. Default is always percentage ('%') for missing or non-'a' values.
** If you use both percentage rates and absolute amounts, the relevant absolute amount (if any) is applied AFTER the relevant percentage rate.
** For any one type of discount, sub-arrays must be in ascending order of value-of-items, and number-of-items within that.
** Discount is non-cumulative. Discount is applied when the total value of the items in the basket reaches or exceeds
** the value set AND the number of items in the basket is greater than or equal to the value set.
** Discount is only applied to the basket contents (not the delivery costs), and is calculated BEFORE tax.
*/

/* Plugin Manager, Configuration Instructions ... */
$PMCI['tax']['type'] = $PMCI['discount']['type'] = $PMCI['tax_includeDelivery']['type'] = $PMCI['tax_includeInTotal']['type'] = 'checkbox';
$PMCI['tax_displayAsAbsolute']['type'] = $PMCI['discount_showRate']['type'] = 'checkbox';
$PMCI['tax_rate']['type'] = 'input(7)';
$PMCI['tax_rate']['check'] = array('regexp','^-?[0-9]+\\\\.[0-9]{1,3}$lang[PMdollar]','','Tax Rate must be a number with between 1 and 3 decimal places');
$PMCI['discount_rates']['type'] = 'textarea(6,50)';
?>
