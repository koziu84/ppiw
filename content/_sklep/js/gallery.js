/*
* ver. 1.0-rc2
*/

var isNN,isIE;
if ( parseInt( navigator.appVersion.charAt( 0 ) ) >= 4 ){
  isNN = ( navigator.appName == "Netscape" ) ? 1 : 0;
  isIE = ( navigator.appName.indexOf( "Microsoft" ) != -1 ) ? 1 : 0;
  isOp = ( navigator.appName == "Opera" ) ? 1 : 0;
}
var iPlusWidth = 50;
var iPlusHeight = 30;
var sId = "oPhoto";
function reSizeToImage( ){
  window.resizeTo( 100, 100 );

  if( isNN || isIE ){
    var bodyWidth = document.documentElement.clientWidth;
    var bodyHeight = document.documentElement.clientHeight;
  }
  else{ 
    var bodyWidth = document.body.clientWidth;
    var bodyHeight = document.body.clientHeight;
  }
  gEBI( "butt" ).style.margin = "auto";
  width =		100 - ( bodyWidth - gEBI( sId ).width );
  height =	100 - ( bodyHeight - gEBI( sId ).height );

  if( width > screen.availWidth ){
    width = screen.availWidth - screen.availWidth / 5;
    document.body.scroll = "yes";
  }
  if( height > screen.availHeight ){
    height = screen.availHeight - screen.availHeight / 5;
    document.body.scroll = "yes";
  }
  window.resizeTo( width+iPlusWidth, height+iPlusHeight );
  moveWindowToImage( width+iPlusWidth, height+iPlusHeight );

}

function moveWindowToImage( iWindowWidth, iWindowHeight ){

  var iPosX = ( screen.availWidth - iWindowWidth ) / 2;
  var iPosY = ( screen.availHeight - iWindowHeight ) / 2;

  window.moveTo( iPosX, iPosY );

} // end function moveWindowImage
function doTitle( sTitle ){
	document.title = sTitle;
	gEBI( sId ).title = sTitle;
	gEBI( sId ).alt = sTitle;
	gEBI( sId ).onmouseover = function () {
    window.status = sTitle;
  }
}

function showLinks( iPhoto ){
  if( aPhotos[iPhoto][2] != '' )
    doTitle( aPhotos[iPhoto][2] );
  else
    doTitle( opener.document.title );
  if( aPhotos[iPhoto+1] ){
    gEBI( "oLR" ).style.display = "";
    var iNext = iPhoto+1;
    gEBI( "oLR" ).onclick = 'loadImg( '+ iNext +' );';
    gEBI( "oLR" ).href = 'javascript:loadImg( '+ iNext +' );';
  }
  else
    gEBI( "oLR" ).style.display = "none";
  if( aPhotos[iPhoto-1] ){
    gEBI( "oLL" ).style.display = "";
    var iPrev = iPhoto-1;
    gEBI( "oLL" ).onclick = 'loadImg( '+ iPrev +' );';
    gEBI( "oLL" ).href = 'javascript:loadImg( '+ iPrev +' );';
  }
  else
    gEBI( "oLL" ).style.display = "none";
} // end function showPict

function loadImg( iPhoto ){
  var img = new Image();
  img.onload = function( e ) {
    var im = document.createElement( 'IMG' );
    var obj= document.getElementById( 'oPhotoDiv' );
    im.src = this.src;
    obj.innerHTML = '';
    obj.appendChild( im );
    im.id = "oPhoto";
    gEBI( 'oPhoto' ).onclick = function(){
      window.close( );
    }
    reSizeToImage( );
    showLinks( iPhoto );
  }
  img.src = aPhotos[iPhoto][1];
}