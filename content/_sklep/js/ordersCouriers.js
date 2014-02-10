/**
* Przelicza wartosc zamowienia po wybraniu kuriera
* @return void
* @param object
*/
function ordersCouriers( obj ){

  if( obj.value != '' )
    aCourier = obj.value.split( "|" );
  else
    aCourier = Array( '0.00', '0.00' );

  fDeliveryCost = Math.abs( aCourier[1] );

  gEBI( "deliveryCost" ).innerHTML  = fix( fDeliveryCost );
  gEBI( "summaryCost" ).innerHTML   = fix( +gEBI( "orderCost" ).innerHTML + fDeliveryCost );
} // end function ordersCouriers
