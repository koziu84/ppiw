<?php
/*
* actions_client/tax.php for taxAndDiscount plugin v2.1
* Wizzud : 01/02/06
* 23/02/06 : v2.1 has an extra config flag enabling subtotal excluding tax tobe shown where tax is already included in product price
*            and tax rate is set negative and for non-inclusion in total
*            With historical data (ie. v2.0 orders) you won't see the new field eben if the ocnfiguration is set to show it. The reason
*            being twofold, in that (a) the order should only show what the customer originally saw, and (b) the extra fields used to
*            capture relevant configuration settings at the time the order is placed are not available on the historical data.
*/
if(!function_exists('throwTaxAndDiscount')){
  /*
  * Run-Before function called on the intercept of the orders delivery page display; sets up the additional variables for
  * output on the page
  * @return void
  */
  function throwTaxAndDiscount(){
    global $tpl, $config, $aList, $iOrder;

    if(($scan = dbScanTheBasket($iOrder)) !== false){
      $aList['fDiscountRate'] = $aList['fDiscount'] = $aList['sDiscountRate'] = '';
      if($config['discount']){
        calculateDiscount($scan, $aList['fDiscountRate'], $aList['fDiscount'], $aList['fSummary'], $aList['sDiscountRate']);
      }
      // javascript routine needs these ...
      $aList['iTadItems'] = $scan['items'];
      $aList['bTadTaxToTotal'] = $config['tax_includeInTotal'] ? 'true' : 'false';
      $aList['bTadTaxAbsolute'] = $config['tax_displayAsAbsolute'] ? 'true' : 'false';
      $aList['bTadTaxDelivery'] = $config['tax_includeDelivery'] ? 'true' : 'false';
      // put the consituents of the costs table into one string ...
      $aList['sTadDelivery'] = '';
      if($config['discount']){ $aList['sTadDelivery'] .= $tpl->tbHtml( 'taxAndDiscount.tpl', 'DELIVERY_DISCOUNT' ); }
      if($config['tax']){
        if($config['tax_subtotalExTax']){
          $aList['sTadDelivery'] .= $tpl->tbHtml( 'taxAndDiscount.tpl', 'DELIVERY_SUBEXTAX' );
        $aList['sTadDelivery'] .= $tpl->tbHtml( 'taxAndDiscount.tpl', 'DELIVERY_TAX' );
        }
      }
      $aList['sTadDelivery'] .= $tpl->tbHtml( 'taxAndDiscount.tpl', 'DELIVERY_SUMMARY' );

    }
  } // end function throwTaxAndDiscount
}

if(!function_exists('throwTaxAndDiscountPrint')){
  /*
  * Run-Before function called on the intercept of the order print pages (user and admin) and order more (admin);
  * sets up the additional variables for output on the page(s)
  * @return void
  */
  function throwTaxAndDiscountPrint(){
    global $tpl, $aData, $iOrder, $bPrint, $sBlockPage;

    $prt = (isset($bPrint) && isset($sBlockPage) && $bPrint===true) ? $sBlockPage : '';
    $data = dbThrowOrderExt( $iOrder );
    if( isset( $data ) && is_array( $data ) ){
      list( , /*Time*/, /*iCourier*/, /*sCourier*/, /*fCourierPrice*/, /*sFirstName*/, /*sLastName*/, /*sCompanyName*/, /*sStreet*/, /*sZipCode*/, /*sCity*/, /*sTelephone*/, /*sEmail*/, /*sIp*/, /*sComment*/
            , $sTAD, $discountRate, $aData['fDiscount'], $aData['fTax'], $aData['fSummary'] ) = $data;
      if($GLOBALS['config']['discount_showRate'] && $discountRate != '' && preg_match('/\(/',$discountRate,$m1) == 0){
        $aData['fDiscountrate'] = $discountRate.'%';
      }
      $bTax = (substr($sTAD,0,1) == '1');
      $bDiscount = (substr($sTAD,1,1) == '1');
      $bAbsolute = (strlen($sTAD) > 2 && substr($sTAD,2,1) == '1');
      $bSubExTax = (strlen($sTAD) > 3 && substr($sTAD,3,1) == '1');
      if($bSubExTax){
        $aData['fSubExTax'] = tPrice((float)$aData['fSummary'] - abs((float)$aData['fTax']));
      }
      if($bAbsolute && (float)$aData['fTax'] < 0){
        $aData['fTax'] = ltrim($aData['fTax'], '-');
      }
      // put the consituents of the costs table into one string ...
      $aData['sTadDelivery'] = '';
      if($bDiscount){ $aData['sTadDelivery'] .= $tpl->tbHtml( 'taxAndDiscount.tpl', 'DELIVERY_DISCOUNT'.$prt ); }
      if($bTax){
        if($bSubExTax){
          $aData['sTadDelivery'] .= $tpl->tbHtml( 'taxAndDiscount.tpl', 'DELIVERY_SUBEXTAX'.$prt );
        }
        $aData['sTadDelivery'] .= $tpl->tbHtml( 'taxAndDiscount.tpl', 'DELIVERY_TAX'.$prt );
      }
      $aData['sTadDelivery'] .= $tpl->tbHtml( 'taxAndDiscount.tpl', 'DELIVERY_SUMMARY'.$prt );
      unset($data);
    }
  } // end function throwTaxAndDiscountPrint
}

if(!function_exists('calculateDiscount')){
  /*
  * Calculates the discount to be applied
  * @param array basket values
  * @param string discount rate (for output)
  * @param string discount amount (for output)
  * @param string discounted total (for output)
  * @param string displayed discount rate (for output)
  * @return void
  */
  function calculateDiscount($scan, &$discountrate, &$discount, &$discountedsummary, &$displayrate){
    global $config;

    $aDR = $config['discount_rates'];
    $fDR = $fDA = 0;
    for($i=0;$i<count($aDR);$i++){ // find the applicable rate ...
      if($scan['value'] >= $aDR[$i][0] && $scan['items'] >= $aDR[$i][1] && (!isset($aDR[$i][3]) || $aDR[$i][3]!='a')) $fDR = $aDR[$i][2];
    }
    for($i=0;$i<count($aDR);$i++){ // find the applicable amount ...
      if($scan['value'] >= $aDR[$i][0] && $scan['items'] >= $aDR[$i][1] && isset($aDR[$i][3]) && $aDR[$i][3]=='a') $fDA = $aDR[$i][2];
    }
    $discountrate = (($fDR>0) ? $fDR : '') . (($fDA>0) ? "($fDA)" : '');
    $discount = ($fDR>0) ? tprice( (-1) * (($scan['value'] * $fDR / 100) + $fDA) ) : tprice( (-1) * $fDA );
    $discountedsummary = ($fDR>0 || $fDA>0) ? tprice($scan['value'] + (float)$discount) : tprice($scan['value']);
    $displayrate = (!$config['discount_showRate']) ? '' : (($fDR>0 && $fDA==0) ? "{$fDR}%" : '');
  } // end function calculateDiscount
}

if(!function_exists('setTaxAndDiscount')){
  /*
  * Given the information submitted from the delivery screen, this function calculates the tax/discount fields and
  * places the values in a global array for saving to the order extension file. Its called (in-line) from actions_client.php
  * @param integer order nunmber
  * @param array POSTed variables from delivery page
  * @return void
  */
  function setTaxAndDiscount($iOrder, $aForm){
    global $config, $aTadSaveOrderExt;

    $aTadSaveOrderExt = array(); // this is what's used by taxAndDiscount's version of dbAddOrderExtensions()
    if(($scan = dbScanTheBasket($iOrder)) !== false){
      $fDiscountRate = $fDiscount = $sDiscountRate = '';
      $fDiscountedSummary = tprice($scan['value']);
      if($config['discount']){
        calculateDiscount($scan, $fDiscountRate, $fDiscount, $fDiscountedSummary, $sDiscountRate);
      }
      if( isset( $aForm['iCourier'] ) ){
        $aCourier = explode( '|', $aForm['iCourier'] );
        $fDeliveryCost = isset($aCourier[1]) ? (float)$aCourier[1] : 0;
      }else{
        $fDeliveryCost = 0;
      }

      if($config['tax']){
        if($config['tax_includeDelivery']) // include delivery
          $fT = ((float)$fDiscountedSummary + $fDeliveryCost) * $config['tax_rate'] / 100;
        else
          $fT = (float)$fDiscountedSummary * $config['tax_rate'] / 100;
        $sT = tprice($fT + 0.00001); // make sure we get 0.5 to round the right way (ie. to match javascript)
        if($config['tax_includeInTotal']) // include in total
          $sS = tprice((float)$fDiscountedSummary + $fDeliveryCost + (float)$sT);
        else
          $sS = tprice((float)$fDiscountedSummary + $fDeliveryCost);
//      if($config['tax_displayAsAbsolute'] && $fT < 0) // display as absolute
//        $sT = ltrim($sT,'-');
      }else{
        $sS = tprice((float)$fDiscountedSummary + $fDeliveryCost);
        $sT = '';
      }
      $aTadSaveOrderExt['sTAD'] = ($config['tax'] ? '1' : '0').($config['discount'] ? '1' : '0').($config['tax_displayAsAbsolute'] ? '1' : '0').($config['tax_subtotalExTax'] ? '1' : '0');
      $aTadSaveOrderExt['fDiscountRate'] = $fDiscountRate;
      $aTadSaveOrderExt['fDiscount'] = $fDiscount;
      $aTadSaveOrderExt['fTax'] = $sT;
      $aTadSaveOrderExt['fSummary'] = $sS;
    }
  } // end function setTaxAndDiscount
}
?>
