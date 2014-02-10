<?php

/*
 * wstawianie elementów tre¶ci strony
 */
function content_throw ($content_list_strings, $go, $sub1) {
	switch ($content_list_strings[0])
	{
	case 'headtab':	//nag³ówek sekcji
			//sk³adnia: headtab####nazwa klasy stylu####tekst tytu³u nag³ówka####authors####tekst z nazwiskami autorów lub inne informacje w tym znaczniki HTML
		echo ('<div align="right"><table class="'.$content_list_strings[1].'Table" cellspacing="0" cellpadding="0"><tr><td class="'.$content_list_strings[1].'-top">');
		echo ('<h3 class="'.$content_list_strings[1].'">'.$content_list_strings[2].'</h3>');
		echo ('</td></tr><tr><td class="'.$content_list_strings[1].'-bottom">');
		echo ('<p class="'.$content_list_strings[3].'">'.$content_list_strings[4].'</p>');
		echo ('</td></tr></table></div>');
		break;
//*******************************************************************//		
	case 'head4':	//nag³ówek
			//sk³adnia: head4####nazwa klasy stylu####tekst nag³ówka
		echo ('<h4 class="'.$content_list_strings[1].'">'.$content_list_strings[2].'</h4>');
		break;
//*******************************************************************//
	case 'par':	//akapit
			//sk³adnia: par####nazwa klasy stylu####tekst paragrafu; dozwolone s± znaczniki HTML
		echo ('<p class="'.$content_list_strings[1].'">'.$content_list_strings[2].'</p>');
		break;
//*******************************************************************//
	case 'ol':	//lista numerowana
			//sk³adnia: ol####new####nazwa klasy stylu <- rozpoczêcie ¶rodowiska <ol>
			//sk³adnia: ol####next####nazwa klasy stylu####tekst punktu <- kolejny element ¶rodowiska <ol>
			//sk³adnia: ol####end <- zakoñczenie ¶rodowiska <ol>
			//uwaga: w arkuszu stylów muz± istnieæ definicje stylów dla dwóch klas obiektów: <ol> oraz <li>; nazwy klas musz± zaczynaæ siê odpowiednio: ol-[...] oraz li-[...], przy czym w kodzie ¼ród³owym wstawia siê tylko [...] pomijaj±c ol- lub li-; nale¿y zwróciæ uwagê, ¿e temat nazw klas stylów w pliku CSS powinien byæ TAKI SAM
		if ($content_list_strings[1] == "next") {
			echo ('<li class="li-'.$content_list_strings[2].'">'.$content_list_strings[3].'</li>');
		} else if ($content_list_strings[1] == "new") {
			echo ('<ol class="ol-'.$content_list_strings[2].'">');
		} else {
			echo ('</ol>');
		}
		break;
//*******************************************************************//
	case 'ul': 	//lista nienumerowana
			//sk³adnia: ul####new####nazwa klasy stylu <- rozpoczêcie ¶rodowiska <ul>
			//sk³adnia: ul####next####nazwa klasy stylu####tekst punktu <- kolejny element ¶rodowiska <ul>
			//sk³adnia: ul####end <- zakoñczenie ¶rodowiska <ul>
			//uwaga: w arkuszu stylów musz± istnieæ definicje stylów dla dwóch klas obiektów: <ul> oraz <li>; nazwy klas musz± zaczynaæ siê odpowiednio: ul-[...] oraz li-[...], przy czym w kodzie ¼ród³owym wstawia siê tylko [...] pomijaj±c ul- lub li-; nale¿y zwróciæ uwagê, ¿e temat nazw klas stylów w pliku CSS powinien byæ TAKI SAM
		if ($content_list_strings[1] == "next") {
			echo ('<li class="li-'.$content_list_strings[2].'">'.$content_list_strings[3].'</li>');
		} else if ($content_list_strings[1] == "new") {
			echo ('<ul class="ul-'.$content_list_strings[2].'">');
		} else {
			echo ('</ul>');
		}
		break;
//*******************************************************************//
	case 'column':	//uk³ad dokumentu kolumnowy
			//sk³adnia: column####new####nazwa klasy tabeli####nazwa klasy kolumny <- rozpoczêcie kolumnowego uk³adu strony
			//sk³adnia: column####next####nazwa klasy kolumny <- wstawienie nowej kolumny
			//sk³adnia: column####end <- zakoñczenie kolumnowego uk³adu strony
		if ($content_list_strings[1] == "next") {
			echo ('</td><td class="'.$content_list_strings[2].'">');
		} else if ($content_list_strings[1] == "new") {
			echo ('<table class="'.$content_list_strings[2].'"><tr><td class="'.$content_list_strings[3].'">');
		} else {
			echo ('</td></tr></table>');
		}
		break;
//*******************************************************************//
	case 'img':	//obrazek
			//sk³adnia: img####nazwa klasy stylu####¶cie¿ka do obrazka####tekst alternatywny (alt)####ramki (1-tak, 0-nie)####warto¶æ hspace####warto¶æ vspace####warto¶æ align
		echo ('<img class="'.$content_list_strings[1].'" src="'.$content_list_strings[2].'" alt="'.$content_list_strings[3].'" border="'.$content_list_strings[4].'" hspace='.$content_list_strings[5].'px vspace='.$content_list_strings[6].'px align="'.$content_list_strings[7].'">');
		break;
//*******************************************************************//
	case 'thumb': 	//miniaturka obrazka
			//sk³adnia: thumb####justowanie obiektu####liczba obrazków####¶cie¿ka do obrazków[####nazwa obrazka][####podpis pod obrazkiem]####styl obramowania obrazka powiêkszonego####warto¶æ HSPACE####warto¶æ VSPACE####warto¶æ ALIGN
		echo ('<'.$content_list_strings[1].'><table class="'.$content_list_strings[0].'"><tr>');
		for ($i=0; $i<$content_list_strings[2]; $i++) {
			list($width, $height, $type, $attr)=getimagesize($content_list_strings[3].substr($content_list_strings[4+$i], 6));
			echo ('<td class="'.$content_list_strings[0].'"><a href="javascript: enlarge_picture(\''.$content_list_strings[3].substr($content_list_strings[4+$i], 6).'\','.$width.'+40,'.$height.'+60,\''.$content_list_strings[4+$content_list_strings[2]+$i].'\')" title="Powiêksz w nowym oknie"><img class="'.$content_list_strings[1].'" src="'.$content_list_strings[3].$content_list_strings[4+$i].'" alt="'.$content_list_strings[4+$content_list_strings[2]+$i].'" border="'.$content_list_strings[4+2*$content_list_strings[2]].'" hspace="'.$content_list_strings[5+2*$content_list_strings[2]].'" vspace="'.$content_list_strings[6+2*$content_list_strings[2]].'" align="'.$content_list_strings[7+2*$content_list_strings[2]].'"></a></td>');
		}
		echo ('</tr><tr>');
		for ($i=0; $i<$content_list_strings[2]; $i++) {
			echo ('<td><p>'.$content_list_strings[4+$content_list_strings[2]+$i].'</p></td>');
		}
		echo ('</tr></table></'.$content_list_strings[1].'>');
		break;
//*******************************************************************//
	case 'map_b':	//mapa odsy³aczy podstawowa (basic)
			//sk³adnia: map####nazwa klasy stylu####¶cie¿ka do obrazka####nazwa mapy####liczba elementów mapy[####kszta³t mapy####sekwencja parametrów opisu kszta³tu mapy####warto¶æ parametru HREF####warto¶æ parametru ALT]
			//uwaga: sekwencja zawarta w [] powinna byæ powtórzona tyle razy ile wynosi liczba elementów mapy [] oczywi¶œcie nale¿y pomin±æ
		echo ('<img class="'.$content_list_strings[1].'" src="'.$content_list_strings[2].'" usemap="'.$content_list_strings[3].'">');
		echo ('<map name ="'.$content_list_strings[3].'">');
		for ($i=0; $i<$content_list_strings[4]; $i++) {
			echo ('<area shape="'.$content_list_strings[5+$i*4].'" coords="'.$content_list_strings[6+$i*4].'" href="'.$content_list_strings[7+$i*4].'" alt="'.$content_list_strings[8+$i*4].'">');
		}
		echo ('</map>');
		break;
//*******************************************************************//
	case 'map_e':	//mapa odsy³aczy z powiêkszaniem obrazka (enlarge)
			//sk³adnia: map####nazwa klasy stylu####¶cie¿ka i nazwa pliku obrazka####nazwa mapy####liczba elementów mapy[####kszta³t mapy####sekwencja parametrów opisu kszta³tu mapy####¶cie¿ka i nazwa pliku obrazka####warto¶æ parametru ALT]
			//uwaga: sekwencja zawarta w [] powinna byæ powtórzona tyle razy ile wynosi liczba elementów mapy [] oczywi¶œcie nale¿y pomin±æ; na pocz±tku pliku content.txt powinien znale¼æ siê skrypt javy: <script Language="JavaScript1.1">function enlarge_picture(picture_path, wwidth, wheight, wdescription){EnlargedWindow=window.open('', '','width='+wwidth+',height='+wheight+',toolbar=no,directories=no,menubar=no,locations=no,status=no,scrollbars=no,resizable=no,screenX=10,screenY=10,fullscreen=no'); EnlargedWindow.document.open(); EnlargedWindow.document.writeln("<html>\n<head>\n</head>"); EnlargedWindow.document.writeln("<title>Powiêkszony obrazek</title>"); EnlargedWindow.document.writeln("<body leftmargin=0 topmargin=0 style=\"font-family:Arial, Helvetica, sans-serif; font-size:11pt; background-color:#ffffff; background: url(_images/layout/bg.jpg) fixed repeat-x top\">"); EnlargedWindow.document.writeln("<table width=100% height=100% style=\"font-family:Arial, Helvetica, sans-serif; font-size:11pt;\">"); EnlargedWindow.document.writeln("<tr><td valign=center align=center>\n<a href=\"javascript:window.close();\" title=\"Zamknij okno\"><img src="+picture_path+" border=0></a></td></tr>"); EnlargedWindow.document.writeln("<tr><td align=center style=\"font-family:Arial, Helvetica, sans-serif; font-size:10pt; font-color:#000022; background-color:#ffffff\">"+wdescription+"\n</td></tr>"); EnlargedWindow.document.writeln("</table>"); EnlargedWindow.document.writeln("</body>\n</html>\n"); EnlargedWindow.document.close(); EnlargedWindow.focus(); return;}</script>
			//<script Language="JavaScript1.1">function enlarge_picture(picture_path, wwidth, wheight, wdescription){EnlargedWindow=window.open('', '','width='+wwidth+',height='+wheight+',toolbar=no,directories=no,menubar=no,locations=no,status=no,scrollbars=no,resizable=no,screenX=10,screenY=10,fullscreen=no'); EnlargedWindow.document.open(); EnlargedWindow.document.writeln("<html>\n<head>\n</head>"); EnlargedWindow.document.writeln("<title>Powiêkszony obrazek</title>"); EnlargedWindow.document.writeln("<body leftmargin=0 topmargin=0 style=\"font-family:Arial, Helvetica, sans-serif; font-size:11pt; background-color:#ffffff; background: url(_images/layout/bg.jpg) fixed repeat-x top\">"); EnlargedWindow.document.writeln("<table width=100% height=100% style=\"font-family:Arial, Helvetica, sans-serif; font-size:11pt;\">"); EnlargedWindow.document.writeln("<tr><td valign=center align=center>\n<a href=\"javascript:window.close();\" title=\"Zamknij okno\"><img src="+picture_path+" style=\"border-width: 1px; border-color: #CCCCCC; border-style: solid;\"></a></td></tr>"); EnlargedWindow.document.writeln("<tr><td align=center style=\"font-family:Arial, Helvetica, sans-serif; font-size:10pt; font-color:#000022; background-color:#ffffff\">"+wdescription+"\n</td></tr>"); EnlargedWindow.document.writeln("</table>"); EnlargedWindow.document.writeln("</body>\n</html>\n"); EnlargedWindow.document.close(); EnlargedWindow.focus(); return;}</script>
		echo ('<img class="'.$content_list_strings[1].'" src="'.$content_list_strings[2].'" usemap="#'.$content_list_strings[3].'">');
		echo ('<map name ="'.$content_list_strings[3].'">');
		for ($i=0; $i<$content_list_strings[4]; $i++) {
			list($width, $height, $type, $attr)=getimagesize($content_list_strings[7+$i*4]);
			echo ('<area shape="'.$content_list_strings[5+$i*4].'" coords="'.$content_list_strings[6+$i*4].'" href="javascript: enlarge_picture(\''.$content_list_strings[7+$i*4].'\','.$width.'+40,'.$height.'+60,\''.$content_list_strings[8+$i*4].'\')" alt="'.$content_list_strings[8+$i*4].'">');
		}
		echo ('</map>');
		break;
//*******************************************************************//
	case 'anchor':	//kotwica
			//sk³adnia: anchor####etykieta kotwicy
		echo ('<a name="'.$content_list_strings[1].'"></a>');
		break;
//*******************************************************************//
	case 'contact-form':	//formularz kontaktowy
				//sk³adnie: contact-form####
		include("_include/vrf-frm.js");
		echo ('<form action="_require/mlr.php" method="post" name="frm1" id="frm1" style="margin:0px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px; width:300px;" onsubmit="MM_validateForm(\'from\',\'\',\'RisEmail\',\'subject\',\'\',\'R\',\'verif_box\',\'\',\'R\',\'message\',\'\',\'R\');return document.MM_returnValue">');
		echo ('Twój e-mail:<br />');
		echo ('<input name="from" type="text" id="from" style="padding:2px; border:1px solid #B0B1FF; width:180px; height:20px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;" value="');/*<?php*/ echo $_GET['from'];/*?>;*/echo ('"/><br /><br />');
		echo ('Temat: <br />');
		echo ('<input name="subject" type="text" id="subject" style="padding:2px; border:1px solid #B0B1FF; width:180px; height:20px;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;" value="');/*<?php*/ echo $_GET['subject'];/*?>*/echo ('"/><br /><br />');
		echo ('Wpisz cyfry z obrazka obok<br />');
		echo ('<input name="verif_box" type="text" id="verif_box" style="padding:2px; border:1px solid #B0B1FF; width:180px; height:20px;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;"/>&nbsp;');
		echo ('<img src="_require/vrf-img.php?');/*<?php */echo rand(0,9999);/*?>*/ echo('" alt="Obrazek testowy. Wpisz tekst w pole obok." width="50" height="20" align="absbottom" /><br /><br />');
		/*echo ('<?php*/ if(isset($_GET['wrong_code'])){/*?>*/ echo ('<div style="border:1px solid #990000; background-color:#D70000; color:#FFFFFF; padding:4px; padding-left:6px;width:287px;">B³êdny kod weryfikuj±cy!</div><br />');/*<?php ;*/}/*?>')*/;
		echo ('Wiadomo¶æ:<br />');
		echo ('<textarea name="message" cols="6" rows="5" id="message" style="padding:2px; border:1px solid #B0B1FF; width:300px; height:100px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">');/*<?php*/ echo $_GET['message'];/*?>*/echo ('</textarea>');
		echo ('<input name="Submit" type="submit" style="margin-top:10px; display:block; border:1px solid #A0A1EF; width:100px; height:20px;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; padding-left:2px; padding-right:2px; padding-top:0px; padding-bottom:2px; line-height:14px; background-color:#EFEFEF;" value="Wy¶lij"/>');
		echo ('</form>');
		break;
//*******************************************************************//
	case 'shop': //odsy³acz do sklepu
		   //sk³adnia: shop####url produktu####nazwa linku do sklepu
		   //uwaga: s³owo kluczowe: 'wyczerpany' wymusza zablokowanie odsy³acza do sklepu i zmienia grafikê 
		echo ('<div style="float: left; width 50%; text-align: left;">');
		if ($content_list_strings[1] != 'wyczerpany') {      
         echo ('<a href="'.$content_list_strings[1].'" target="_self" onMouseOver="self.status=\'Sklep internetowy PPiW\'; return true;" onMouseOut="self.status=\'\'; return true;" title="Przejd¼ do sklepu internetowego PPiW"><img src="_images/layout/zamow.jpg" alt="^&nbsp;"></a>');
      } else {
         echo ('<img src="_images/layout/wyczerpany.jpg" alt="^&nbsp;"></a>');
      }
      echo ('</div>');
		break;
//*******************************************************************//
	case 'shop&up&back': //odsy³acz do sklepu oraz linki: [W górê] | [Wstecz]
		   //sk³adnia: shop&up&back####url produktu####nazwa linku do sklepu
		   //uwaga: s³owo kluczowe: 'wyczerpany' wymusza zablokowanie odsy³acza do sklepu i zmienia grafikê
		echo ('<br />');
		echo ('<div style="float: left; width 50%; text-align: left;">');
		if ($content_list_strings[1] != 'wyczerpany') {
		   echo ('<a href="'.$content_list_strings[1].'" target="_self" onMouseOver="self.status=\'Sklep internetowy PPiW\'; return true;" onMouseOut="self.status=\'\'; return true;" title="Przejd¼ do sklepu internetowego PPiW"><img src="_images/layout/zamow.jpg" alt="^&nbsp;"></a>');
		} else {
		   echo ('<img src="_images/layout/wyczerpany.jpg" alt="^&nbsp;"></a>');
		}
		echo ('</div>');
		echo ('<div style="float: right; width: 50%; text-align: right;">');
		echo ('<a href="#" target="_self" onMouseOver="self.status=\'Do góry\'; return true;" onMouseOut="self.status=\'\'; return true;" title="Przejd¼ na pocz±tek strony"><img src="_images/layout/pictograms/top.gif" alt="^&nbsp;">Do góry</a>&nbsp;|&nbsp;<a href="javascript:history.back();" target="_self" onMouseOver="self.status=\'Wstecz\'; return true;" onMouseOut="self.status=\'\'; return true;" title="Wróæ do poprzedniej strony"><img src="_images/layout/pictograms/back.gif" alt="<&nbsp;">Wstecz</a>');
		echo ('</div>');
		echo ('<br /><br />');
		break;
//*******************************************************************//	
	case 'up&back': //linki: [W górê] | [Wstecz]
			//sk³adnia: up&back####
			//uwaga: linki dodawane z pliku up&back.txt z katalogu _include
		include("_include/up&back.txt");
		break;
//*******************************************************************//
	case 'hr':	//linia pozioma
			//sk³adnia: hr####¶cie¿ka do pliku z grafik±
		echo ('<div align="center"><img src="'.$content_list_strings[1].'" alt="______________________"></div>');
		break;
//*******************************************************************//
	case 'br':	//z³amanie wiersza
			//sk³adnia: br####liczba z³amañ
		for ($j=0; $j<$content_list_strings[1]; $j++) {
			echo ('<br />');
		}
		break;
//*******************************************************************//
  case 'submenu':   //budowa menu dodatkowego na podstawie pliku /submenu.txt/ w podkatalogu
                    //sk³adnia: submenu####
    if (is_file("content/".$go."/submenu.txt")) {
      $sub_list = file("content/".$go."/submenu.txt");
      
      /*przetworzenie zawarto¶ci submenu*/
      for ($i=0; $i<sizeof($sub_list); $i++) {
        $sub_list[$i] = rtrim($sub_list[$i]);
        $sub_list_strings[$i] = explode("####", $sub_list[$i]);
      }
      
      /*utworzenie submenu*/
      echo ("<div class=\"submenu-1\">[&nbsp;&nbsp;");      
      for ($i=0; $i<sizeof($sub_list); $i++) {
        if ($sub1 != $sub_list_strings[$i][1]) {
          echo ("<a href=\"index.php?go=".$go."&sub1=".$sub_list_strings[$i][1]."\" target=\"_self\" onMouseOver=\"self.status='".$sub_list_strings[$i][0]."'; return true;\" title=\"".$sub_list_strings[$i][0]."\">".$sub_list_strings[$i][0]."</a>");
        } else {
          echo ("<b>".$sub_list_strings[$i][0]."</b>"); //link do aktywnej podstrony jest pogrubiony
        }
        
        if ($i < sizeof($sub_list)-1) {
          echo ("&nbsp;&nbsp;|&nbsp;&nbsp;");
        }
      }
      echo ("&nbsp;&nbsp;]</div>");
    } else {
    }
    break;
//*******************************************************************//
	case 'script':	//skrypt Javy
			//sk³adnia: script####kod ¼ród³owy skryptu
		echo ($content_list_strings[1]);
		echo ("\n");
		break;
//*******************************************************************//
	case 'httags':	//znaczniki html
			//sk³adnia: httags####kod html
		echo ($content_list_strings[1]);
		break;
//*******************************************************************//
	default:
	}
}

/*
 * wstawianie elementów menu
 */
function menu_throw ($menu_list_url) {
	for ($i=0; $i<sizeof($menu_list_url); $i++) {
		switch ($menu_list_url[$i][0]) {
		case 'menuTd':
			echo ('<tr><td class="'.$menu_list_url[$i][0].'"><a class="'.$menu_list_url[$i][1].'" href="'.$menu_list_url[$i][2].'" target="'.$menu_list_url[$i][3].'" title="'.$menu_list_url[$i][4].'">'.$menu_list_url[$i][5].'</a></td></tr>');
			break;
		case 'menuTdEmpty':
			echo ('<tr><td class="'.$menu_list_url[$i][0].'"><!-- /* vertical spacer */ --></td></tr>');
			break;
		case 'menuCustom':
			echo ('<tr><td>');
			echo ($menu_list_url[$i][1]);
			echo ('</td></tr>');
			break;
		default:
		}
	}
}

/*
 * budowa menu w pliku *.js
 */
function java_menu_throw ($menu_list_url) {
}

/*
 * funkcja sprawdzaj¹ca typ przegl¹darki
 */
function check_browser_type () {
	$browser_string = explode (" ", $_SERVER['HTTP_USER_AGENT']);
	$browser = "MZ";
	for ($i=0; $i<sizeof($browser_string); $i++) {
		if ($browser_string[$i] == "MSIE") {
			$browser = "IE";
			break;
		}
	}

	return $browser;
}

function link_stylesheets ($browser) {
	if ($browser == "IE") {
		echo ('<link rel="stylesheet" type="text/css" href="_css/style_ie.css">');
	} else {
		echo ('<link rel="stylesheet" type="text/css" href="_css/style_mz.css">');
	}
}
?>
