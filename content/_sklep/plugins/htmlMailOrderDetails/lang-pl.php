<?php
/*
* htmlMailOderDetails plugin - Polski plik jêzykowy (t³umaczenie: Wies³aw Klimiuk)
*/
$lang['hmodSubjectAdmin'] = 'Nowe zamówienie. Szczegó³y dostêpne przez panel administracyjny sklepu';
$lang['hmodSubjectClient'] = 'Dziêkujemy za z³o¿one zamówienie. Bêdzie ono zrealizowane najszybciej jak to mo¿liwe.';
$lang['hmodHtml'] = 'HTML';
$lang['hmodText'] = 'Text';

$lang['PMCI']['hmod__adminName']['name'] = $lang['PMCI']['hmod__adminName']['alt'] = 'Imiê/nazwa Administratora sklepu';
$lang['PMCI']['hmod__adminName']['text'] = 'To jest nazwa/imiê Administratora sklepu, które bêdzie u¿yte do adresowania e-maili administracyjnych.';
$lang['PMCI']['hmod__sendAdmin']['name'] = 'Wy¶lij powiadomienie do Administratora';
$lang['PMCI']['hmod__sendAdmin']['alt'] = 'W³±cz/wy³±cz wysy³anie e-maila o nowym zamówieniu do Administratora';
$lang['PMCI']['hmod__sendAdmin']['text'] = 'Kontroluje wysy³anie e-maila o nowym zamówieniu do Administratora. Je¶li nie chcesz otrzymywaæ 2&nbsp;e-maili, <span style="text-decoration:underline;">nie zapomnij</span> wy³±czyæ \''.$lang['Mail_informing'].'\' w menu Konfiguracja.';
$lang['PMCI']['hmod__sendClient']['name'] = 'Wy¶lij powiadomienie do Klienta';
$lang['PMCI']['hmod__sendClient']['alt'] = 'W³±cz/wy³±cz wysy³anie e-maila o z³o¿onym zamówieniu do Klienta';
$lang['PMCI']['hmod__sendClient']['text'] = 'Kontroluje wysy³anie e-maili powiadamiaj±cych o z³o¿onym zamówieniu do Klienta.';
$lang['PMCI']['hmod__reportErrors']['name'] = $lang['PMCI']['hmod__reportErrors']['alt'] = 'Raportuj b³êdy';
$lang['PMCI']['hmod__reportErrors']['text'] = 'Wy¶wietlaj na ekranie wszystkieb³êdy, które wyst±pi± przy wysy³aniu e-maila.';
$lang['PMCI']['hmod__showAndStop']['name'] = $lang['PMCI']['hmod__showAndStop']['alt'] = 'Poka¿ tekst wiadomo¶ci e-mail i zatrzymaj';
$lang['PMCI']['hmod__showAndStop']['text'] = 'Wy¶wietl na ekranie format wiadomo¶ci, która bêdzie wys³ana i anuluj wysy³anie. U¿ywane przy debugowaniu - nie wysy³a wiadomo¶ci e-mail.';
$lang['PMCI']['hmod__formatAdmin']['name'] = $lang['PMCI']['hmod__formatAdmin']['alt'] = 'Format wiadomo¶ci e-mail: Administrator';
$lang['PMCI']['hmod__formatAdmin']['text'] = 'Wybierz, czy e-maile do Administratora maj± byæ wysy³ane w formacie HTML, Tekstowym, czy HTML i Tekstowym.';
$lang['PMCI']['hmod__formatClient']['name'] = $lang['PMCI']['hmod__formatClient']['alt'] = 'Format wiadomo¶ci e-mail: Klient';
$lang['PMCI']['hmod__formatClient']['text'] = 'Wybierz, czy e-maile do Klienta maj± byæ wysy³ane w formacie HTML, Tekstowym, czy HTML i Tekstowym.';
$lang['PMCI']['hmod__method']['name'] = $lang['PMCI']['hmod__method']['alt'] = 'Program';
$lang['PMCI']['hmod__method']['text'] = 'Wybierz program, który bêdzie u¿yty do wysy³ania e-maili.';
$lang['PMCI']['hmod__sendmailPath']['name'] = 'Sendmail: ¶cie¿ka';
$lang['PMCI']['hmod__sendmailPath']['alt'] = '¦cie¿ka do: sendmail';
$lang['PMCI']['hmod__sendmailPath']['text'] = '¦cie¿ka do programu sendmail, je¶li zosta³ on u¿yty do wysy³ania wiadomo¶ci.';
$lang['PMCI']['hmod__qmailPath']['name'] = 'Qmail: ¶cie¿ka';
$lang['PMCI']['hmod__qmailPath']['alt'] = '¦cie¿ka do: qmail';
$lang['PMCI']['hmod__qmailPath']['text'] = '¦cie¿ka do programu qmail, je¶li zosta³ on u¿yty do wysy³ania wiadomo¶ci.';
$lang['PMCI']['hmod__smtpHosts']['name'] = 'SMTP: Host(-y)';
$lang['PMCI']['hmod__smtpHosts']['alt'] = 'SMTP Server(s)';
$lang['PMCI']['hmod__smtpHosts']['text'] = 'Je¶li u¿yto SMTP, wprowad¼ adres serwera SMTP. Kilka adresów mo¿e byæ wprowadzone przez odseparowanie ich znakiem ¶rednika (;). Mo¿esz wymusiæ zmianê domy¶lnego portu (poni¿ej) przez dodanie jego numeru do adresu SMTP po ¶redniku (:) (np: adres1.pl:25;adres2.pl:26).';
$lang['PMCI']['hmod__smtpPort']['name'] = 'SMTP: Port';
$lang['PMCI']['hmod__smtpPort']['alt'] = 'Domy¶lny port SMTP';
$lang['PMCI']['hmod__smtpPort']['text'] = 'To jest domy¶lny numer portu przy wysy³aniu e-maili przez SMTP.';
$lang['PMCI']['hmod__smtpAuth']['name'] = 'SMTP: Autoryzacja';
$lang['PMCI']['hmod__smtpAuth']['alt'] = 'U¿yj autoryzacji SMTP';
$lang['PMCI']['hmod__smtpAuth']['text'] = 'Wymusza autoryzacjê SMTP, przy u¿yciu nazwy U¿ytkownika i Has³a z pól poni¿ej.';
$lang['PMCI']['hmod__smtpUser']['name'] = 'SMTP: U¿ytkownik';
$lang['PMCI']['hmod__smtpUser']['alt'] = 'Nazwa U¿ytkownika do autoryzacji';
$lang['PMCI']['hmod__smtpUser']['text'] = 'Wymagane je¶li u¿ywasz autoryzacji SMTP';
$lang['PMCI']['hmod__smtpPword']['name'] = 'SMTP: Has³o';
$lang['PMCI']['hmod__smtpPword']['alt'] = 'Has³o autoryzacji';
$lang['PMCI']['hmod__smtpPword']['text'] = 'Wymagane je¶li u¿ywasz autoryzacji SMTP';
?>
