<html>
<head>
<title>Photo</title>
<style>
body{margin:0;padding:0;}
</style>
<script>
var isNN,isIE;
if( parseInt( navigator.appVersion.charAt( 0 ) ) >= 4 ){
  isNN = ( navigator.appName == "Netscape" ) ? 1 : 0;
  isIE = ( navigator.appName.indexOf( "Microsoft" ) != -1 ) ? 1 : 0;
}
var iPlusHeight = 0;
function reSizeToImage( ){
  if ( isNN ){
    width   = document.images["photo"].width;
    height  = document.images["photo"].height;

    if( width > screen.availWidth ){
      width = screen.availWidth - screen.availWidth/5;
      document.body.scroll = "yes";
    }
    if( height > screen.availHeight ){
      height = screen.availHeight - screen.availHeight/5;
    document.body.scroll = "yes";
    }
    window.innerWidth =		width;
    window.innerHeight =	height+iPlusHeight;
  }
  else {
    window.resizeTo( 130, 130 );
    width =		130 - ( document.body.clientWidth - document.images[0].width );
    height =	130 - ( document.body.clientHeight - document.images[0].height );

    if( width > screen.availWidth ){
      width = screen.availWidth - screen.availWidth / 5;
      document.body.scroll = "yes";
    }
    if( height > screen.availHeight ){
      height = screen.availHeight - screen.availHeight / 5;
      document.body.scroll = "yes";
    }
    window.resizeTo( width, height+iPlusHeight );
  }

  moveWindowToImage( width, height+iPlusHeight );

}

function moveWindowToImage( iWindowWidth, iWindowHeight ){

  var iPosX = ( screen.availWidth - iWindowWidth ) / 2;
  var iPosY = ( screen.availHeight - iWindowHeight ) / 2;

  window.moveTo( iPosX, iPosY );

} // end function moveWindowImage
function doTitle( ){
	document.title = "<?php echo $_GET['sPageTitle']; ?>";
} // end function doTitle
</script>
</head>
<body bgcolor="#ffffff" scroll="no" onload="reSizeToImage( ); doTitle( ); self.focus( );"><img name="photo" onclick="window.close( )" src="<?php echo $_GET['adresFoto']; ?>" alt="<?php echo $_GET['sPageTitle']; ?>" title="<?php echo $_GET['sPageTitle']; ?>" style="display:block;" /></body>
</html>