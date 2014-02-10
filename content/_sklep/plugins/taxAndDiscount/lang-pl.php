<?php
/*
* taxAndDiscount plugin - English language file
*/
$lang['Tax_description'] = 'VAT'; // displayed on order details. For example, UK VAT
$lang['Discount_description'] = 'Upust'; // displayed on order details
$lang['Tax_subtotalExTax'] = 'Suma bez ' . $lang['Tax_description'];

$lang['PMCI']['tax']['name'] = $lang['PMCI']['tax']['alt'] = 'Aktywuj podatek';
$lang['PMCI']['discount']['name'] = $lang['PMCI']['discount']['alt'] = 'Aktywuj upusty';
$lang['PMCI']['tax_includeDelivery']['name'] = $lang['PMCI']['tax_includeDelivery']['alt'] = 'Podatek od koszt�w dostawy';
$lang['PMCI']['tax_includeInTotal']['name'] = $lang['PMCI']['tax_includeTotal']['alt'] = 'Dodaj podatek do sumy';
$lang['PMCI']['tax_subtotalExTax']['name'] = $lang['PMCI']['tax_subtotalExTax']['alt'] = 'Suma bez podatku';
$lang['PMCI']['tax_displayAsAbsolute']['name'] = $lang['PMCI']['tax_displayAsAbsolute']['alt'] = 'Wy�wietlaj warto�� bezwzgl�dn� podatku';
$lang['PMCI']['discount_showRate']['name'] = $lang['PMCI']['discount_showRate']['alt'] = 'Poka� wielko�� upustu';
$lang['PMCI']['tax_rate']['name'] = $lang['PMCI']['tax_rate']['alt'] = 'Wysoko�� podatku';
$lang['PMCI']['discount_rates']['name'] = $lang['PMCI']['discount_rates']['alt'] = 'Wielko�ci upust�w';
$lang['PMCI']['tax']['text'] = 'W��cz/wy��cz obliczanie podatku';
$lang['PMCI']['discount']['text'] = 'W��cz/wy��cz obliczanie upust�w';
$lang['PMCI']['tax_includeDelivery']['text'] = 'Do��cz koszty dostawy w obliczeniach podatku';
$lang['PMCI']['tax_includeInTotal']['text'] = 'Dodaj obliczony podatek do koszt�w ca�kowitych';
$lang['PMCI']['tax_subtotalExTax']['text'] = 'Do��czaj dodatkow� rubryk� z kosztami ca�kowitymi <span style="text-decoration:underline">bez</span> podatku. Zaznaczenie tego pola b�dzie mia�o efekt tylko je�li obliczanie podatku jest aktywne.';
$lang['PMCI']['tax_displayAsAbsolute']['text'] = 'Zawsze WY�WIETLAJ obliczony podatek jako wielko�� dodatni�';
$lang['PMCI']['discount_showRate']['text'] = 'Poka� wielko�� upustu (gdy nie zerowy) - automatycznie wy��czane przy sta�ej wielko�ci upustu';
$lang['PMCI']['tax_rate']['text'] = 'Wysoko�� podatku w procentach; mo�e by� ujemna';
$lang['PMCI']['discount_rates']['text'] = "<br clear='left' /><div align='left'>Each sub-array = ( value-of-items, number-of-items, discount, discount-type ).<br />
 To apply discount as an absolute amount, set discount-type to 'a'; if missing or invalid, the default is percentage ('%').
 If you use both percentage rates and absolute amounts, the relevant absolute amount (if any) is applied AFTER the relevant percentage rate.
<br />For any one type of discount, sub-arrays must be in ascending order of value-of-items, and number-of-items within that.
<br />Discount is non-cumulative. It is applied when the total value of items in the basket reaches or exceeds
 the value set AND the number of items in the basket equals or exceeds the value set.
<br />Discount is only applied to basket contents (not delivery costs), and is calculated BEFORE tax.</div>";
?>
