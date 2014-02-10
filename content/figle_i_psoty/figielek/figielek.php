<?php

// licznik
$fh=fopen("licznik.dat","r");
if($fh){
    fscanf($fh,"%d",$ile);
    fclose($fh);
};
$ile=$ile+1;
$fh=fopen("licznik.dat","w");
if($fh){
    fputs($fh,"$ile");
    fclose($fh);
}
?>
<HTML>
<HEAD>
<meta http-equiv=Content-Type content="text/html;  charset=iso8859-2">
<TITLE>Figielek</TITLE>
</HEAD><!--25D506-->
<BODY bgcolor="#669900">
<center>
<OBJECT 
 classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 WIDTH="600" 
 HEIGHT="420" 
 id="psotka" ALIGN="">
 <PARAM NAME=movie VALUE="psotka.swf">
 <PARAM NAME=quality VALUE=high>
 <PARAM NAME=bgcolor VALUE=#669900>
 <EMBED 
  src="psotka.swf" 
  quality=high 
  bgcolor=#669900  
  WIDTH="600" 
  HEIGHT="420" 
  NAME="psotka" ALIGN=""
  TYPE="application/x-shockwave-flash" 
  PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
</EMBED>
</OBJECT>
</center>
</BODY>
</HTML>
