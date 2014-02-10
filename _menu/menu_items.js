// ssmItems[...]=[name, link, target, colspan, endrow?] - leave 'link' and 'target' blank to make a header
ssmItems[0]=["<b>Strona g³ówna</b>", "index.php?go=strona_glowna&sub1=", "", "menuLinkTop"]
ssmItems[1]=["Aktualno¶ci", "index.php?go=aktualnosci&sub1=", "", "menuLink"]
ssmItems[2]=["", "", "", ""]
ssmItems[3]=["<b>Dla sze¶ciolatków</b>", "index.php?go=dla_szesciolatkow&sub1=", "", "menuLinkBlinkTop"]
ssmItems[4]=["Dla nauczyciela", "index.php?go=dla_nauczyciela&sub1=", "", "menuLink"]
ssmItems[5]=["Podrêczniki dla klas I-III", "index.php?go=podreczniki&sub1=", "", "menuLink"]
ssmItems[6]=["Dla przedszkolaka i dla ucznia", "index.php?go=dla_przedszkolaka_i_dla_ucznia&sub1=", "", "menuLink"]
ssmItems[7]=["", "", "", ""]
ssmItems[8]=["Archiwum", "index.php?go=archiwum&sub1=", "", "menuLinkTop"]
//ssmItems[7]=["Zaprezentuj siê", "index.php?go=zaprezentuj_sie&sub1=", "", "menuLinkTop"]
//ssmItems[8]=["Spotkania z Abecelkami", "index.php?go=spotkania_z_abecelkami&sub1=", "", "menuLink"]
//ssmItems[9]=["Dzieci pisz±", "index.php?go=prace_dzieci&sub1=", "", "menuLink"]
ssmItems[9]=["<b>Figle i psoty</b>", "index.php?go=figle_i_psoty&sub1=", "", "menuLink"]
ssmItems[10]=["", "", "", ""]
ssmItems[11]=["Do pobrania", "index.php?go=do_pobrania&sub1=", "", "menuLinkTop"]
ssmItems[12]=["Kontakt", "index.php?go=kontakt&sub1=", "", "menuLink"]
ssmItems[13]=["<b>Sklep internetowy PPiW</b>", "content/_sklep/index.php", "_new", "menuLink"]
ssmItems[14]=["", "", "", ""]
ssmItems[15]=["<b>Archiwum &#8222;Edukacja Jutra&#8221;</b>", "http://edukacjajutra.org.pl", "", "menuLinkSeparated"]
Offset = menuPosition();
buildMenu(Offset);

