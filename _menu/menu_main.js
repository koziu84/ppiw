<!--
// menu style customization //
YOffset=305; // no quotes!!!
XOffset=200; // no quotes!!!
staticYOffset=50; // no quotes!!!
slideSpeed=20 // no quotes!!!
waitTime=100; // no quotes!!! this sets the time the menu stays out for after the mouse goes off it.
menuBGColor="black";
menuIsStatic="yes"; //this sets whether menu should stay static on the screen
menuWidth=190; // Must be a multiple of 10! no quotes!!!
menuCols=2;
hdrFontFamily="verdana";
hdrFontSize="2";
hdrFontColor="white";
hdrBGColor="#170088";
hdrAlign="center";
hdrVAlign="center";
hdrHeight="15";
linkFontFamily="Verdana";
linkFontSize="2";
linkBGColor="white";
linkOverBGColor="#FFFF99";
linkTarget="_top";
linkAlign="right";
barBGColor="#444444";
barFontFamily="Verdana";
barFontSize="1";
barFontColor="white";
barVAlign="center";
barWidth=0; // no quotes!!!
barText=""; // <IMG> tag supported. Put exact html for an image to show.

// browser detection //
NS6 = (document.getElementById && !document.all)
NS = (navigator.appName=="Netscape" && navigator.appVersion.charAt(0)=="4")
IE = (document.all)

tempBar='';
barBuilt=0;
ssmItems=new Array();

function truebody() {
	return (document.compatMode!="BackCompat")?document.documentElement:document.body
}

moving=setTimeout('null',1)

function makeStatic() {
	if (NS||NS6) {
		winY = window.pageYOffset;
	}
	if (IE) {
		winY = truebody().scrollTop;
	}
	if (NS6||IE||NS) {
		if (winY!=lastY&&winY>YOffset-staticYOffset) {
			smooth = .2*(winY-lastY-YOffset+staticYOffset);
		} else if (YOffset-staticYOffset+lastY>YOffset-staticYOffset) {
			smooth = .2*(winY-lastY-(YOffset-(YOffset-winY)));
		} else {
			smooth=0;
		}

		if(smooth > 0)
			smooth = Math.ceil(smooth);
		else
			smooth = Math.floor(smooth);

		if (IE) bssm.pixelTop+=smooth;
		if (NS6) bssm.top=parseInt(bssm.top)+smooth+"px";
		if (NS) bssm.top=parseInt(bssm.top)+smooth;

		lastY = lastY+smooth;

		setTimeout('makeStatic()', 1)
	}
}

function buildBar() {
	if (barText.indexOf('<IMG')>-1) {
		tempBar=barText
	} else {
		for (b=0;b<barText.length;b++) {
			tempBar+=barText.charAt(b)+"<BR>"
		}
	}
	document.write('<td align="center" rowspan="100" width="'+barWidth+'" bgcolor="'+barBGColor+'" valign="'+barVAlign+'"><p align="center"><font face="'+barFontFamily+'" Size="'+barFontSize+'" COLOR="'+barFontColor+'"><B>'+tempBar+'</B></font></p></TD>')
}

function initSlide() {
	if (NS6) {
		ssm=document.getElementById("thessm").style;
		bssm=document.getElementById("basessm").style;
		ssm.visibility="visible";
	} else if (IE) {
		ssm=document.all("thessm").style;
		bssm=document.all("basessm").style
		bssm.visibility = "visible";
	} else if (NS) {
		bssm=document.layers["basessm1"];
		bssm2=bssm.document.layers["basessm2"];
		ssm=bssm2.document.layers["thessm"];
		ssm.visibility = "show";
	}
	if (menuIsStatic=="yes") makeStatic();
}

function menuPosition() {
	menuX = 0;

	if (typeof(window.innerWidth) == 'number') {
		//Non-IE
		menuX = window.innerWidth;
	} else if (document.body && (document.body.clientWidth)) {
		//IE 4 compatible
		menuX = document.body.clientWidth;
	} else if (document.documentElement && (document.documentElement.clientWidth)) {
		//IE 6+ in 'standards compliant mode'
		menuX = document.documentElement.clientWidth;
	}

	menuX = (menuX-900)/2;
	
	if (IE) {
		if (menuX<10) menuX=10;
		menuX+=8
	} else if (menuX<10) menuX = 10;

	return menuX+XOffset;
}

function buildMenu(dynamicXOffset) {
	if (IE||NS6) {document.write('<DIV ID="basessm" style="position: absolute; left: '+dynamicXOffset+'px; top: '+YOffset+'px; z-Index: 20;"><DIV ID="thessm" style="position: absolute; left: '+(-menuWidth)+'px; top: 0px; z-index: 20;">')}
	if (NS) {document.write('<LAYER name="basessm1" top="'+YOffset+'" left='+dynamicXOffset+' visibility="show"><ILAYER name="basessm2"><LAYER visibility="hide" name="thessm" left="'+(-menuWidth)+'">')}
/*	if (NS6) {document.write('<table border="0" cellpadding="0" cellspacing="0" width="'+(menuWidth+barWidth+2)+'px"><TR><TD>')}
*/
	document.write('<table class="menuTable" cellpadding="0" cellspacing="0">');

	for(i=0;i<ssmItems.length;i++) {
/*		if(!ssmItems[i][3]) {
			ssmItems[i][3]=menuCols;
			ssmItems[i][5]=menuWidth-1
		}
		else if(ssmItems[i][3]!=menuCols)
			ssmItems[i][5]=Math.round(menuWidth*(ssmItems[i][3]/menuCols)-1);

*/		if(ssmItems[i-1]&&ssmItems[i-1][4]!="no") {
			document.write('<tr>')
		}

		if(!ssmItems[i][1]) {
			document.write('<td class="menuTdEmpty"><!-- /* vertical spacer */ --></td>')
		} else {
			if(!ssmItems[i][2])ssmItems[i][2]=linkTarget;
			document.write('<td class="menuTd"><a href="'+ssmItems[i][1]+'" target="'+ssmItems[i][2]+'" class="'+ssmItems[i][3]+'">'+ssmItems[i][0]+'</a></td>')
		}

/*		if(ssmItems[i][4]!="no"&&barBuilt==0) {
			buildBar();
			barBuilt=1
		}
*/
		if(ssmItems[i][4]!="no") {
			document.write('</tr>')
		}
	}
	document.write('</table>')

/*	if (NS6) {document.write('</TD></TR></TABLE>')}
*/	if (NS) {document.write('</LAYER></ILAYER></LAYER>')}
	if (IE||NS6) {document.write('</DIV></DIV>')}

	theleft=-menuWidth;
	lastY=0;
	setTimeout('initSlide();', 1)
}

//-->
