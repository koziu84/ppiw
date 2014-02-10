/**
* Checks that any attributes have been selected
* @return boolean
* @param object (form)
* @param array (parameter array for checking attributes selected)
* @param string (error message)
* @param array (parameter array for passing to checkForm)
*/
function checkAttributes( form, ids, msg, chkFm ){
  var bValid = true;
  var oFocus;
  var obj;

  for( i in ids ){
    obj = form[ids[i]];
    if( obj.options[obj.selectedIndex].value == '' ){
      if( bValid ){
        bValid = false;
        oFocus = obj;
      }
 		  obj.style.backgroundColor = '#ff8080';
    }else{
		  obj.style.backgroundColor = '#ffffff';
		}
  }

  if( !bValid ) {
    if( msg != '' ){
      alert(msg);
    }
    oFocus.focus();
    return false;
  } else {
    if( chkFm == null ){
      return true;
    }else{
      return checkForm(form, chkFm);
    }
  }
} // end function checkAttributes
/**
* Checks each attribute select and adjusts the display price appropriately
* @return void
* @param object (select)
*/
function checkAttributes_Offset(obj){
  var aOff = attributeOffsets;
  aOff[obj.name][1] = false;
  if( obj.options[obj.selectedIndex].value == '' ){aOff[obj.name][0] = 0;}
  else{
    // pattern looks for containing brackets, and allows for optional currency symbol in 3 places...
    var pattern = /\(.*[+|-].*\d+\.?\d*%?[^%]*\)$/g;
	  var result = obj.options[obj.selectedIndex].text.match(pattern);
  	if( result != null ){
      var replacement = new RegExp(attributeCurrencySymbol);
      // slice removes containing brackets...
      var offset = result[result.length-1].slice(1,-1);
      // remove currency symbol if present...
      var offset = offset.replace(replacement,'');
      if( offset.substr(offset.length-1) == '%' ){
        aOff[obj.name][0] = offset.substr(0,offset.length-1);
        aOff[obj.name][1] = true;
      }else{aOff[obj.name][0] = offset;}
    }else{aOff[obj.name][0] = 0;}
  }
  var show = gEBI('price');
  var hide = gEBI('fPrice');
  var nPrice = parseFloat(hide.firstChild.nodeValue);
  var oPrice = parseFloat(hide.firstChild.nodeValue);
  for(var i in aOff){
    if(parseFloat(aOff[i][0]) != 0){
      //percentages are based on original price
      if(aOff[i][1] == true){nPrice = nPrice + ((oPrice * parseFloat(aOff[i][0])) / 100);}
      else{nPrice = nPrice + parseFloat(aOff[i][0]);}
    }
  }
  show.firstChild.nodeValue = fix(nPrice);
} // end function checkAttributes_Offset
/**
* Sets up the array for use by the checkAttributes_Offset function above
* @return object (of array[s])
* @param array
*/
function checkAttributes_Setup(ary){
  var rtn = new Object();
  for(var i in ary){rtn[ary[i]] = Array(0,false);}
  return rtn;
} // end function checkAttributes_Setup
/**
* Clears down the selects so that a redisplay of the page won't keep any previously selected options
* @return void
*/
function checkAttributes_Clear(){
  for(var i in attributeOffsets){var j=gEBI(i);j.selectedIndex=0;}
}
