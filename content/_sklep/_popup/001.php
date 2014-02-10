<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-2">
        <meta http-equiv="Creation-date" content="2005-10-18">
        <meta name="Content-language" content="pl">
        <meta name="description" content="Pracownia Pedagogiczna i Wydawnicza - strona domowa">
        <meta name="keywords" content="abcelki, Bursztynowy Dom, ppiw,kształcenie,podręczniki,kształcenie zintegrowane,figielek,psotka,wydawnictwo,edukacja jutra,edukacja,szkolenia,abc,program abc,program kształcenia zintegrowanego,klasa I,klasa II, klasa III,zerówka,klasa 0,nauczyciel,uczniowie,szkoła,klasa,uczeń,podstawówka,szkoła podstawowa,przedszkole,atlas,rodzice,pedagogika,książka,skoroszyt,materiały,rozkład zajęć,dyplomy,druki,ocenianie opisowe,ocenianie,scenariusze,stowarzyszenie,informator edukacyjny,informator,sklep">
        <meta name="pragma" content="no-cache">
        <meta name="robots" content="index, follow">

        <title>&nbsp;&nbsp;Oferta tygodnia&nbsp;&nbsp;</title>

<?php

$browser_string = explode (" ", $_SERVER['HTTP_USER_AGENT']);
$browser = "MZ";
for ($i=0; $i<sizeof($browser_string); $i++)
{
        if ($browser_string[$i] == "MSIE")
        {
                $browser = "IE";
                break;
        }
}

if ($browser == "IE")
{
        echo '<link rel="stylesheet" type="text/css" href="../../../_css/style_ie.css">';
}
else
{
        echo '<link rel="stylesheet" type="text/css" href="../../../_css/style_mz.css">';
}
?>

<link rel="SHORTCUT ICON" href="../../../_images/icon.gif">


</head>

<!-- /* body section */ -->
<body style="margin: 0px 0px 0px 0px; background-image: none; background-color: #FFFFFF;">

<script language="JavaScript1.2">
	function popup_exit ()
	{
		shop_window = window.open("../index.php?p=productsList&sWord=moje+literki+i+cyferki", "popup_parent");
	}
</script>

	<a href="javascript:window.close()" onclick="popup_exit();"><img src="../../../_images/content/_popup/promocja_20070130.jpg" alt="Oferta tygodnia"></a>
</body>
<!-- /* end body section */ -->

</html>
