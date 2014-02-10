<?php

/*
 * wstawianie element�w tre�ci strony
 */
function content_throw ($content_list_strings, $go, $sub1) {
	switch ($content_list_strings[0])
	{
	case 'headtab':	//nag��wek sekcji
			//sk�adnia: headtab####nazwa klasy stylu####tekst tytu�u nag��wka####authors####tekst z nazwiskami autor�w lub inne informacje w tym znaczniki HTML
		echo ('<div align="right"><table class="'.$content_list_strings[1].'Table" cellspacing="0" cellpadding="0"><tr><td class="'.$content_list_strings[1].'-top">');
		echo ('<h3 class="'.$content_list_strings[1].'">'.$content_list_strings[2].'</h3>');
		echo ('</td></tr><tr><td class="'.$content_list_strings[1].'-bottom">');
		echo ('<p class="'.$content_list_strings[3].'">'.$content_list_strings[4].'</p>');
		echo ('</td></tr></table></div>');
		break;
//*******************************************************************//		
	case 'head4':	//nag��wek
			//sk�adnia: head4####nazwa klasy stylu####tekst nag��wka
		echo ('<h4 class="'.$content_list_strings[1].'">'.$content_list_strings[2].'</h4>');
		break;
//*******************************************************************//
	case 'par':	//akapit
			//sk�adnia: par####nazwa klasy stylu####tekst paragrafu; dozwolone s� znaczniki HTML
		echo ('<p class="'.$content_list_strings[1].'">'.$content_list_strings[2].'</p>');
		break;
//*******************************************************************//
	case 'ol':	//lista numerowana
			//sk�adnia: ol####new####nazwa klasy stylu <- rozpocz�cie �rodowiska <ol>
			//sk�adnia: ol####next####nazwa klasy stylu####tekst punktu <- kolejny element �rodowiska <ol>
			//sk�adnia: ol####end <- zako�czenie �rodowiska <ol>
			//uwaga: w arkuszu styl�w muz� istnie� definicje styl�w dla dw�ch klas obiekt�w: <ol> oraz <li>; nazwy klas musz� zaczyna� si� odpowiednio: ol-[...] oraz li-[...], przy czym w kodzie �r�d�owym wstawia si� tylko [...] pomijaj�c ol- lub li-; nale�y zwr�ci� uwag�, �e temat nazw klas styl�w w pliku CSS powinien by� TAKI SAM
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
			//sk�adnia: ul####new####nazwa klasy stylu <- rozpocz�cie �rodowiska <ul>
			//sk�adnia: ul####next####nazwa klasy stylu####tekst punktu <- kolejny element �rodowiska <ul>
			//sk�adnia: ul####end <- zako�czenie �rodowiska <ul>
			//uwaga: w arkuszu styl�w musz� istnie� definicje styl�w dla dw�ch klas obiekt�w: <ul> oraz <li>; nazwy klas musz� zaczyna� si� odpowiednio: ul-[...] oraz li-[...], przy czym w kodzie �r�d�owym wstawia si� tylko [...] pomijaj�c ul- lub li-; nale�y zwr�ci� uwag�, �e temat nazw klas styl�w w pliku CSS powinien by� TAKI SAM
		if ($content_list_strings[1] == "next") {
			echo ('<li class="li-'.$content_list_strings[2].'">'.$content_list_strings[3].'</li>');
		} else if ($content_list_strings[1] == "new") {
			echo ('<ul class="ul-'.$content_list_strings[2].'">');
		} else {
			echo ('</ul>');
		}
		break;
//*******************************************************************//
	case 'column':	//uk�ad dokumentu kolumnowy
			//sk�adnia: column####new####nazwa klasy tabeli####nazwa klasy kolumny <- rozpocz�cie kolumnowego uk�adu strony
			//sk�adnia: column####next####nazwa klasy kolumny <- wstawienie nowej kolumny
			//sk�adnia: column####end <- zako�czenie kolumnowego uk�adu strony
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
			//sk�adnia: img####nazwa klasy stylu####�cie�ka do obrazka####tekst alternatywny (alt)####ramki (1-tak, 0-nie)####warto�� hspace####warto�� vspace####warto�� align
		echo ('<img class="'.$content_list_strings[1].'" src="'.$content_list_strings[2].'" alt="'.$content_list_strings[3].'" border="'.$content_list_strings[4].'" hspace='.$content_list_strings[5].'px vspace='.$content_list_strings[6].'px align="'.$content_list_strings[7].'">');
		break;
//*******************************************************************//
	case 'thumb': 	//miniaturka obrazka
			//sk�adnia: thumb####justowanie obiektu####liczba obrazk�w####�cie�ka do obrazk�w[####nazwa obrazka][####podpis pod obrazkiem]####styl obramowania obrazka powi�kszonego####warto�� HSPACE####warto�� VSPACE####warto�� ALIGN
		echo ('<'.$content_list_strings[1].'><table class="'.$content_list_strings[0].'"><tr>');
		for ($i=0; $i<$content_list_strings[2]; $i++) {
			list($width, $height, $type, $attr)=getimagesize($content_list_strings[3].substr($content_list_strings[4+$i], 6));
			echo ('<td class="'.$content_list_strings[0].'"><a href="javascript: enlarge_picture(\''.$content_list_strings[3].substr($content_list_strings[4+$i], 6).'\','.$width.'+40,'.$height.'+60,\''.$content_list_strings[4+$content_list_strings[2]+$i].'\')" title="Powi�ksz w nowym oknie"><img class="'.$content_list_strings[1].'" src="'.$content_list_strings[3].$content_list_strings[4+$i].'" alt="'.$content_list_strings[4+$content_list_strings[2]+$i].'" border="'.$content_list_strings[4+2*$content_list_strings[2]].'" hspace="'.$content_list_strings[5+2*$content_list_strings[2]].'" vspace="'.$content_list_strings[6+2*$content_list_strings[2]].'" align="'.$content_list_strings[7+2*$content_list_strings[2]].'"></a></td>');
		}
		echo ('</tr><tr>');
		for ($i=0; $i<$content_list_strings[2]; $i++) {
			echo ('<td><p>'.$content_list_strings[4+$content_list_strings[2]+$i].'</p></td>');
		}
		echo ('</tr></table></'.$content_list_strings[1].'>');
		break;
//*******************************************************************//
	case 'map_b':	//mapa odsy�aczy podstawowa (basic)
			//sk�adnia: map####nazwa klasy stylu####�cie�ka do obrazka####nazwa mapy####liczba element�w mapy[####kszta�t mapy####sekwencja parametr�w opisu kszta�tu mapy####warto�� parametru HREF####warto�� parametru ALT]
			//uwaga: sekwencja zawarta w [] powinna by� powt�rzona tyle razy ile wynosi liczba element�w mapy [] oczywi��cie nale�y pomin��
		echo ('<img class="'.$content_list_strings[1].'" src="'.$content_list_strings[2].'" usemap="'.$content_list_strings[3].'">');
		echo ('<map name ="'.$content_list_strings[3].'">');
		for ($i=0; $i<$content_list_strings[4]; $i++) {
			echo ('<area shape="'.$content_list_strings[5+$i*4].'" coords="'.$content_list_strings[6+$i*4].'" href="'.$content_list_strings[7+$i*4].'" alt="'.$content_list_strings[8+$i*4].'">');
		}
		echo ('</map>');
		break;
//*******************************************************************//
	case 'map_e':	//mapa odsy�aczy z powi�kszaniem obrazka (enlarge)
			//sk�adnia: map####nazwa klasy stylu####�cie�ka i nazwa pliku obrazka####nazwa mapy####liczba element�w mapy[####kszta�t mapy####sekwencja parametr�w opisu kszta�tu mapy####�cie�ka i nazwa pliku obrazka####warto�� parametru ALT]
			//uwaga: sekwencja zawarta w [] powinna by� powt�rzona tyle razy ile wynosi liczba element�w mapy [] oczywi��cie nale�y pomin��; na pocz�tku pliku content.txt powinien znale�� si� skrypt javy: <script Language="JavaScript1.1">function enlarge_picture(picture_path, wwidth, wheight, wdescription){EnlargedWindow=window.open('', '','width='+wwidth+',height='+wheight+',toolbar=no,directories=no,menubar=no,locations=no,status=no,scrollbars=no,resizable=no,screenX=10,screenY=10,fullscreen=no'); EnlargedWindow.document.open(); EnlargedWindow.document.writeln("<html>\n<head>\n</head>"); EnlargedWindow.document.writeln("<title>Powi�kszony obrazek</title>"); EnlargedWindow.document.writeln("<body leftmargin=0 topmargin=0 style=\"font-family:Arial, Helvetica, sans-serif; font-size:11pt; background-color:#ffffff; background: url(_images/layout/bg.jpg) fixed repeat-x top\">"); EnlargedWindow.document.writeln("<table width=100% height=100% style=\"font-family:Arial, Helvetica, sans-serif; font-size:11pt;\">"); EnlargedWindow.document.writeln("<tr><td valign=center align=center>\n<a href=\"javascript:window.close();\" title=\"Zamknij okno\"><img src="+picture_path+" border=0></a></td></tr>"); EnlargedWindow.document.writeln("<tr><td align=center style=\"font-family:Arial, Helvetica, sans-serif; font-size:10pt; font-color:#000022; background-color:#ffffff\">"+wdescription+"\n</td></tr>"); EnlargedWindow.document.writeln("</table>"); EnlargedWindow.document.writeln("</body>\n</html>\n"); EnlargedWindow.document.close(); EnlargedWindow.focus(); return;}</script>
			//<script Language="JavaScript1.1">function enlarge_picture(picture_path, wwidth, wheight, wdescription){EnlargedWindow=window.open('', '','width='+wwidth+',height='+wheight+',toolbar=no,directories=no,menubar=no,locations=no,status=no,scrollbars=no,resizable=no,screenX=10,screenY=10,fullscreen=no'); EnlargedWindow.document.open(); EnlargedWindow.document.writeln("<html>\n<head>\n</head>"); EnlargedWindow.document.writeln("<title>Powi�kszony obrazek</title>"); EnlargedWindow.document.writeln("<body leftmargin=0 topmargin=0 style=\"font-family:Arial, Helvetica, sans-serif; font-size:11pt; background-color:#ffffff; background: url(_images/layout/bg.jpg) fixed repeat-x top\">"); EnlargedWindow.document.writeln("<table width=100% height=100% style=\"font-family:Arial, Helvetica, sans-serif; font-size:11pt;\">"); EnlargedWindow.document.writeln("<tr><td valign=center align=center>\n<a href=\"javascript:window.close();\" title=\"Zamknij okno\"><img src="+picture_path+" style=\"border-width: 1px; border-color: #CCCCCC; border-style: solid;\"></a></td></tr>"); EnlargedWindow.document.writeln("<tr><td align=center style=\"font-family:Arial, Helvetica, sans-serif; font-size:10pt; font-color:#000022; background-color:#ffffff\">"+wdescription+"\n</td></tr>"); EnlargedWindow.document.writeln("</table>"); EnlargedWindow.document.writeln("</body>\n</html>\n"); EnlargedWindow.document.close(); EnlargedWindow.focus(); return;}</script>
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
			//sk�adnia: anchor####etykieta kotwicy
		echo ('<a name="'.$content_list_strings[1].'"></a>');
		break;
//*******************************************************************//
	case 'contact-form':	//formularz kontaktowy
				//sk�adnie: contact-form####
		include("_include/vrf-frm.js");
		echo ('<form action="_require/mlr.php" method="post" name="frm1" id="frm1" style="margin:0px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px; width:300px;" onsubmit="MM_validateForm(\'from\',\'\',\'RisEmail\',\'subject\',\'\',\'R\',\'verif_box\',\'\',\'R\',\'message\',\'\',\'R\');return document.MM_returnValue">');
		echo ('Tw�j e-mail:<br />');
		echo ('<input name="from" type="text" id="from" style="padding:2px; border:1px solid #B0B1FF; width:180px; height:20px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;" value="');/*<?php*/ echo $_GET['from'];/*?>;*/echo ('"/><br /><br />');
		echo ('Temat: <br />');
		echo ('<input name="subject" type="text" id="subject" style="padding:2px; border:1px solid #B0B1FF; width:180px; height:20px;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;" value="');/*<?php*/ echo $_GET['subject'];/*?>*/echo ('"/><br /><br />');
		echo ('Wpisz cyfry z obrazka obok<br />');
		echo ('<input name="verif_box" type="text" id="verif_box" style="padding:2px; border:1px solid #B0B1FF; width:180px; height:20px;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;"/>&nbsp;');
		echo ('<img src="_require/vrf-img.php?');/*<?php */echo rand(0,9999);/*?>*/ echo('" alt="Obrazek testowy. Wpisz tekst w pole obok." width="50" height="20" align="absbottom" /><br /><br />');
		/*echo ('<?php*/ if(isset($_GET['wrong_code'])){/*?>*/ echo ('<div style="border:1px solid #990000; background-color:#D70000; color:#FFFFFF; padding:4px; padding-left:6px;width:287px;">B��dny kod weryfikuj�cy!</div><br />');/*<?php ;*/}/*?>')*/;
		echo ('Wiadomo��:<br />');
		echo ('<textarea name="message" cols="6" rows="5" id="message" style="padding:2px; border:1px solid #B0B1FF; width:300px; height:100px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">');/*<?php*/ echo $_GET['message'];/*?>*/echo ('</textarea>');
		echo ('<input name="Submit" type="submit" style="margin-top:10px; display:block; border:1px solid #A0A1EF; width:100px; height:20px;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; padding-left:2px; padding-right:2px; padding-top:0px; padding-bottom:2px; line-height:14px; background-color:#EFEFEF;" value="Wy�lij"/>');
		echo ('</form>');
		break;
//*******************************************************************//
	case 'shop': //odsy�acz do sklepu
		   //sk�adnia: shop####url produktu####nazwa linku do sklepu
		   //uwaga: s�owo kluczowe: 'wyczerpany' wymusza zablokowanie odsy�acza do sklepu i zmienia grafik� 
		echo ('<div style="float: left; width 50%; text-align: left;">');
		if ($content_list_strings[1] != 'wyczerpany') {      
         echo ('<a href="'.$content_list_strings[1].'" target="_self" onMouseOver="self.status=\'Sklep internetowy PPiW\'; return true;" onMouseOut="self.status=\'\'; return true;" title="Przejd� do sklepu internetowego PPiW"><img src="_images/layout/zamow.jpg" alt="^&nbsp;"></a>');
      } else {
         echo ('<img src="_images/layout/wyczerpany.jpg" alt="^&nbsp;"></a>');
      }
      echo ('</div>');
		break;
//*******************************************************************//
	case 'shop&up&back': //odsy�acz do sklepu oraz linki: [W g�r�] | [Wstecz]
		   //sk�adnia: shop&up&back####url produktu####nazwa linku do sklepu
		   //uwaga: s�owo kluczowe: 'wyczerpany' wymusza zablokowanie odsy�acza do sklepu i zmienia grafik�
		echo ('<br />');
		echo ('<div style="float: left; width 50%; text-align: left;">');
		if ($content_list_strings[1] != 'wyczerpany') {
		   echo ('<a href="'.$content_list_strings[1].'" target="_self" onMouseOver="self.status=\'Sklep internetowy PPiW\'; return true;" onMouseOut="self.status=\'\'; return true;" title="Przejd� do sklepu internetowego PPiW"><img src="_images/layout/zamow.jpg" alt="^&nbsp;"></a>');
		} else {
		   echo ('<img src="_images/layout/wyczerpany.jpg" alt="^&nbsp;"></a>');
		}
		echo ('</div>');
		echo ('<div style="float: right; width: 50%; text-align: right;">');
		echo ('<a href="#" target="_self" onMouseOver="self.status=\'Do g�ry\'; return true;" onMouseOut="self.status=\'\'; return true;" title="Przejd� na pocz�tek strony"><img src="_images/layout/pictograms/top.gif" alt="^&nbsp;">Do g�ry</a>&nbsp;|&nbsp;<a href="javascript:history.back();" target="_self" onMouseOver="self.status=\'Wstecz\'; return true;" onMouseOut="self.status=\'\'; return true;" title="Wr�� do poprzedniej strony"><img src="_images/layout/pictograms/back.gif" alt="<&nbsp;">Wstecz</a>');
		echo ('</div>');
		echo ('<br /><br />');
		break;
//*******************************************************************//	
	case 'up&back': //linki: [W g�r�] | [Wstecz]
			//sk�adnia: up&back####
			//uwaga: linki dodawane z pliku up&back.txt z katalogu _include
		include("_include/up&back.txt");
		break;
//*******************************************************************//
	case 'hr':	//linia pozioma
			//sk�adnia: hr####�cie�ka do pliku z grafik�
		echo ('<div align="center"><img src="'.$content_list_strings[1].'" alt="______________________"></div>');
		break;
//*******************************************************************//
	case 'br':	//z�amanie wiersza
			//sk�adnia: br####liczba z�ama�
		for ($j=0; $j<$content_list_strings[1]; $j++) {
			echo ('<br />');
		}
		break;
//*******************************************************************//
  case 'submenu':   //budowa menu dodatkowego na podstawie pliku /submenu.txt/ w podkatalogu
                    //sk�adnia: submenu####
    if (is_file("content/".$go."/submenu.txt")) {
      $sub_list = file("content/".$go."/submenu.txt");
      
      /*przetworzenie zawarto�ci submenu*/
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
			//sk�adnia: script####kod �r�d�owy skryptu
		echo ($content_list_strings[1]);
		echo ("\n");
		break;
//*******************************************************************//
	case 'httags':	//znaczniki html
			//sk�adnia: httags####kod html
		echo ($content_list_strings[1]);
		break;
//*******************************************************************//
	default:
	}
}

/*
 * wstawianie element�w menu
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
 * funkcja sprawdzaj�ca typ przegl�darki
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
