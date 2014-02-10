/**
* Zbiór funkcji sprawdzaj¹cych pola formularza
* @version  0.1.0-bf1
* @date     2005-08-09 15:08:00
*/

/**
* Modified by Wizzud for pluginManager v2.0, to include regexp processing
*/

// 'normalny' kolor ramki inputa
var cfBorderColor   = '#000000';
var cfWarningColor  = '#ff0000';

// zmienne pomocnicze
var sAllWarnings = '';
var oFirstWrong;
var bIsWarnings = false;
var bAllGood 		= true;

// wyrazenia reguralne
var	reS = /\s/gi;
var reEmail = /^[a-z0-9_.-]+([_\\.-][a-z0-9]+)*@([a-z0-9_\.-]+([\.][a-z]{2,4}))+$/i;
var	reFloat = /^-?[0-9]{1,}[.]{1}[0-9]{1,}$/i;
var	reInt = /^-?[0-9]{1,}$/i;
var	reDot = /\,/gi;


function fieldOperations( oObj, bCheck, sInfo ){

	if( bCheck === true ) {
    if( oObj.type != 'hidden' )
      oObj.style.borderColor = cfBorderColor;
	}
	else {
    if( sInfo )
  		sAllWarnings += sInfo +'\n';
		if( oObj.type != 'hidden' ){
  		oObj.style.borderColor = cfWarningColor;
      if( bIsWarnings == false )
        oFirstWrong = oObj;
		}
		bIsWarnings = true;
		return false;
	}

return true;
} // end function fieldOperations


function checkText( oObj, sInfo ) {

	checkT = oObj.value.replace( reS, "" );

  var bCheck = true;
	if( checkT == '' )
    bCheck = false;

  return fieldOperations( oObj, bCheck, sInfo );
} // end function checkText


function checkEmail( oObj ) {

	var sEmail = oObj.value.replace( reS, "" );

  var bCheck = true;
	if ( sEmail.search( reEmail ) == -1 )
    bCheck = false;

  return fieldOperations( oObj, bCheck, cfLangMail );
} // end function checkEmail


function checkFloat( oObj, sInfo ) {

  var bCheck = true;
	if( oObj.value.search( reFloat ) == -1 && oObj.value.search( reInt ) == -1 ){
    if( !sInfo )
      var sInfo = cfWrongValue;
    bCheck = false;
  }

  return fieldOperations( oObj, bCheck, sInfo );
} // end function checkFloat


function checkInt( oObj, sInfo ) {

  var bCheck = true;
	if( oObj.value.search( reInt ) == -1 ) {
    if( !sInfo )
      var sInfo = cfWrongValue;
    bCheck = false;
  }

  return fieldOperations( oObj, bCheck, sInfo );
} // end function checkInt


function checkFloatValue( oObj, iMinFloat, sInfo ) {

  var bCheck = true;
	if( +oObj.value <= +iMinFloat ) {
    if( !sInfo )
      var sInfo = cfToSmallValue;
    bCheck = false;
  }

  return fieldOperations( oObj, bCheck, sInfo );
} // end function checkFloatValue

function checkIntValue( oObj, minInt, sign, sInfo ) {
  if( !minInt )
    var minInt = 0;
  if( !sign )
    var sign = '==';
  if( !sInfo )
    var sInfo = cfWrongValue;

	eval ( 'var bCheck = ( '+ +oObj.value +' '+ sign +' '+ +minInt +' );' );

  return fieldOperations( oObj, bCheck, sInfo );
} // end function checkIntValue


function checkTxt( oObj, iMin, sInfo ) {
	if( !iMin )
		var iMin = 6;

	var check = oObj.value.replace( reS, "" );

  var bCheck = true;
	if( check.length < iMin ){
    bCheck = false;
    if( !sInfo )
      var sInfo = cfTxtToShort;
  }
  return fieldOperations( oObj, bCheck, sInfo );
} // end function checkTxt

// Added by Wizzud ...
function checkRegexp( oObj, sRegexp, sInfo ) {

  oRegexp = new RegExp( sRegexp );

  var bCheck = true;
	if ( oObj.value.search( oRegexp ) == -1 ) {
    bCheck = false;
	}
  return fieldOperations( oObj, bCheck, sInfo );
} // end function checkRegexp


function cfDot( oObj ){
	return oObj.value.replace(reDot, "\.");
}  // end function cfDot

function cfFix( f ){
	f	= f.toString( );
	var re	= /\,/gi;
	f	= f.replace( re, "\." );

	f = Math.round( f * 100 );
	f = f.toString( );
	var sMinus = f.slice( 0, 1 );
	if( sMinus == '-' ){
	 f = f.slice( 1, f.length )
	}
	else
	 sMinus = '';
	if( f.length < 3 ) {
		while( f.length < 3 )
			f = '0' + f;
	}

	var w = sMinus + f.slice( 0, f.length-2 ) + "." + f.slice( f.length-2, f.length );

	if( w.search( reFloat ) == -1 )
		w = '0.00';
	return w;
} // end function cfFix

function checkForm( form, aA ) {

  sAllWarnings 	= '';
  bIsWarnings 	= false;
  bAllGood			= true;
  oFirstWrong 	= '';
  var oO; 
  var sT; // typ
  
  for( i in aA ) {

    if( typeof(aA[i][0])=="object" && aA[i][0].constructor == Array ){
      oO = [form[aA[i][0][0]], form[aA[i][0][1]]];
    }
    else
      oO = form[aA[i][0]];

    if( aA[i][1] )
      sT = aA[i][1];
    else
      sT = false;

		if( !sT || sT == 'simple' ) {
			bAllGood = checkText( oO, aA[i][2] );
		}
		else if( ( sT == 'email' ) && ( ( aA[i][2] === true && oO.value ) || !aA[i][2] ) ) {
			bAllGood = checkEmail( oO );
		}
		else if( ( sT == 'float' ) && ( ( aA[i][3] === true && oO.value ) || !aA[i][3] ) ) {
			oO.value = cfDot( oO );
			bAllGood = checkFloat( oO );
			if( bAllGood ){
				oO.value = cfFix( oO.value );
				if(	aA[i][2] != '' )
					bAllGood = checkFloatValue( oO, aA[i][2] );
			}
		}
		else if( ( sT == 'txt' ) && ( ( aA[i][4] === true && oO.value ) || !aA[i][4] ) ) {
			bAllGood = checkTxt( oO, aA[i][2], aA[i][3] );
		}
		else if( ( sT == 'int' ) && ( ( aA[i][5] === true && oO.value ) || !aA[i][5] ) ) {
			bAllGood = checkInt( oO, aA[i][3] );
			if( aA[i][2] && bAllGood ) {
				if( aA[i][4] ) {
					bAllGood = checkIntValue( oO, aA[i][2], aA[i][4], aA[i][3] );
				}
				else
					bAllGood = checkFloatValue( oO, aA[i][2], aA[i][3] );
			}
		}
    // Added by Wizzud ...
		else if( ( sT == 'regexp' ) && ( ( aA[i][5] === true && oO.value ) || !aA[i][5] ) ) {
      // aA[i][2] is the regex, aA[i][3] is not used (kept for backward compatibility), and aA[i][4] is the optional error message
			bAllGood = checkRegexp( oO, aA[i][2], aA[i][4] );
		}

	} // end for

  if( bIsWarnings == true ) {
		sAllWarnings = cfLangNoWord + '\n' + sAllWarnings;
    alert ( sAllWarnings );
    if( oFirstWrong )
      oFirstWrong.focus();
    return false;
	}
return true;
} // end function checkForm

