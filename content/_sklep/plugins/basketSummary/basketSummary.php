<?php
/*
* basketSummary.php for QCv1.0+
* Wizzud : 22/02/06
*/
if( !function_exists( 'throwBasketSummary' ) ){
  /*
  * Sets the global variable $sBasketSummary with the total value of the basket's current contents
  * return void
  */
  function throwBasketSummary() {
    global $tpl, $sBasketSummaryAmount, $sBasketSummary;

    if(!isset($_SESSION['iCustomer'])){ session_start(); }
    if(!isset($_SESSION['iCustomer'])){ $_SESSION['iCustomer'] = time().rand(100,999); }

    $sBasketSummaryAmount = 0;
    $iOrder = throwOrderIdTemp( $_SESSION['iCustomer'], null );
    if( isset( $iOrder ) && is_numeric( $iOrder ) ) {
      $aBasket = dbListBasket( $iOrder );
      if( isset( $aBasket ) ){
        $iCount = count( $aBasket );
        for( $i = 0; $i < $iCount; $i++ ){
          list( $id, $orderId, $productId, $quantity, $price ) = $aBasket[$i];
          $sBasketSummaryAmount += tPrice( $quantity * $price );
        } // end for
      }
      unset($aBasket);
    }
    $sBasketSummaryAmount = tPrice($sBasketSummaryAmount);
    $sBasketSummary = $tpl->tbHtml('basketSummary.tpl','BASKET_SUMMARY');
  } // end function throwBasketSummary
}
?>
