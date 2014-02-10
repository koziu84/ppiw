/**
* Author: Wizzud
* taxAndDiscount.js for taxAndDiscount plugin
* Version 2.1 : added 'subtotal excluding tax' field
*
* @return void
* @param object
*/
function taxAndDiscount( obj ){

  if( obj.value != '' )
    var aCourier = obj.value.split( "|" );
  else
    var aCourier = Array( '0.00', '0.00' );
  var fDeliveryCost = Math.abs( aCourier[1] );

  gEBI( "summaryCost" ).innerHTML = fix( tadDiscountedValue + fDeliveryCost );
  if(gEBI("taxCost")){
    if(tadTaxDelivery){
      var fTax = ( tadDiscountedValue + fDeliveryCost ) * tadTaxRate / 100;
    }else{
      var fTax = tadDiscountedValue * tadTaxRate / 100;
    }
    gEBI( "taxCost" ).innerHTML = fix( fTax );
    if(tadAddTaxToTotal){
      gEBI( "summaryCost" ).innerHTML = fix( tadDiscountedValue + fDeliveryCost + parseFloat(gEBI( "taxCost" ).innerHTML) );
    }
    if(tadTaxAsAbsolute && fTax < 0){
      gEBI( "taxCost" ).innerHTML = gEBI( "taxCost" ).innerHTML.substring(1);
    }
    if(gEBI("exTaxCost")){
      gEBI( "exTaxCost" ).innerHTML = fix(parseFloat(gEBI( "summaryCost" ).innerHTML) - Math.abs(fTax));
    }
  }

  gEBI( "deliveryCost" ).innerHTML = fix( fDeliveryCost );
} // end function taxAndDiscount

// set a new onchange function for the courier select ...
var tadIcourier = document.getElementsByName('iCourier');
tadIcourier[0].onchange = new Function("taxAndDiscount(this);");
// call taxAndDiscount() to set initial values ...
taxAndDiscount(tadIcourier[0]);

