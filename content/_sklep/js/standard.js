function windowNew( sAdres, iWidth, iHeight, sTitle, iReturn ){
  if ( !sTitle )
    sTitle = '';
  if( !iReturn )
    iReturn = false;

	if( !iWidth )
		var iWidth = 750;
	if( !iHeight )
		var iHeight = 530;

	if( +iWidth > 750 )
		iWidth = 750;
	else
		iWidth = +iWidth + 40;

	if( +iHeight > 530 )
		iHeight = 530
	else
		iHeight = +iHeight + 40;

	var iX = ( screen.availWidth - iWidth ) / 2;
	var iY = ( screen.availHeight - iHeight ) / 2;

  var refOpen = window.open( sAdres, sTitle, "height="+iHeight+",width="+iWidth+",top="+iY+",left="+iX+",resizable=yes,scrollbars=yes,status=0;" );
  
  if( iReturn == true )
  	return refOpen
}


function windowPhoto( sPhotoAdres, sTitle, sPageUrl, iReturn ){
	if( !sTitle )
		sTitle = 'Photo';
  if( !iReturn )
    iReturn = false;
  if( !sPageUrl )
    sPageUrl = '';

  var refFoto = window.open( sPageUrl + "window.php?p=showPhoto&adresFoto=" + sPhotoAdres + "&sPageTitle=" + sTitle, 'Photo', "heigth=500,width=700,top=20,left=20,resizable=yes,scrollbars=yes,status=0;" );

  if( iReturn == true )
  	return refOpen
}

function windowGallery( iId, iIdLink, iType ){
  var refFoto = window.open( "index.php?p=galleryGalleryShow&iId=" + iId + "&iIdLink="+ iIdLink +"&iType=" + iType, 'Photo', "heigth=500,width=700,top=20,left=20,resizable=yes,scrollbars=yes,status=0;" );
}

function gEBI( objId ){

  return document.getElementById( objId );

}

function fix( f ){
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

  var poprawnyFloat = /^-?[0-9]{1,}[.]{1}[0-9]{1,}$/i;
	if( w.search( poprawnyFloat ) == -1 )
		w = '0.00';
	return w;

}

_bUa=navigator.userAgent.toLowerCase();
_bOp=(_bUa.indexOf("opera")!=-1?true:false);
_bIe=(_bUa.indexOf("msie")!=-1&&!_bOp?true:false);
_bIe4=(_bIe&&(_bUa.indexOf("msie 2.")!=-1||_bUa.indexOf("msie 3.")!=-1||_bUa.indexOf("msie 4.")!=-1)&&!_bOp?true:false)
isIe=function(){return _bIe;}
isOldIe=function(){return _bIe4;}
var olArray=[];

function AddOnload( f ){
  if( isIe && isOldIe ){
    window.onload = ReadOnload;
    olArray[olArray.length] = f;
  }
  else if( window.onload ){
    if( window.onload != ReadOnload ){
      olArray[0] = window.onload;
      window.onload = ReadOnload;
    }
    olArray[olArray.length] = f;
  }
  else
    window.onload=f;
}
function ReadOnload(){
  for( var i=0; i < olArray.length; i++ ){
    alert( olArray[i] );
    olArray[i]();
  }
}
