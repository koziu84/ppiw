<?php
/**
* attributes.php
* Wizzud 31/01/06 Product-Attributes plugin
*/
if( !function_exists( 'productHasAttributes' ) ){
  /* Checks to see if a product has attributes assigned or not
  * @param integer $iProduct
  * @return boolean
  */
  function productHasAttributes( $iProduct=null ){
    global $oAttributes;

    if(!isset($iProduct) && isset($GLOBALS['iProduct'])) $iProduct = $GLOBALS['iProduct'];
    if(isset($iProduct)){
      return ($oAttributes->productHasAttributes($iProduct));
    }else{
      return false;
    }
  } // end function productHasAttributes
}
if( !function_exists( 'throwAttrSpecialPrice' ) ){
  /* 'Run Before' function that modifies the price for a product to the special price (if there is one)
  *   NOTE: This function will only run properly as 'run-before' function, specified as part of a TPL intercept!
  *         It is not intended to be called from in-line code.
  * @return void
  */
  function throwAttrSpecialPrice($inProgress){
    global $tpl, $oAttributes, $aData, $aList;

    if(isset($aList['iProduct']) && isset($aList['fPrice'])){ $myData =& $aList; }
    elseif(isset($aData['iProduct']) && isset($aData['fPrice'])){ $myData =& $aData; }
    else{ return; }

    $template = $inProgress['newFile'];
    if(($myData['fSpecialPrice'] = $oAttributes->getSpecialPrice($myData['iProduct'])) !== false){
      $myData['sFormattedPrices'] = $tpl->xtbHtml($template, 'FORMATTED_SPECIAL_PRICE');
    }else{
      $myData['sFormattedPrices'] = $tpl->xtbHtml($template, 'FORMATTED_STANDARD_PRICE');
    }
  } // end function throwAttrSpecialPrice
}
?>
