<?php
ob_start(); session_start();
require ("_require/functions.php");
$browser = check_browser_type ();
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-2">
<meta name="language" content="pl">
<meta name="description" content="Pracownia Pedagogiczna i Wydawnicza - strona domowa">
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<?php
  echo ("<meta name=\"keywords\" content=\"");
  include ("_include/keywords.txt");
  echo ("\">");
?>
<meta name="pragma" content="no-cache">
<meta name="robots" content="index, follow">

<title>&nbsp;&nbsp;Pracownia Pedagogiczna i Wydawnicza</title>

<!-- stylesheets include */ -->
<?php
link_stylesheets ($browser);
?>

<!-- /* icon */ -->
<link rel="SHORTCUT ICON" href="_images/icon.gif">

</head>

<!-- /* body section */ -->
<body class="main">

<?

$go=""; $sub1="";
$go=$_GET["go"]; $sub1=$_GET["sub1"];

if (isset($go)){ /*sprawdzenie ustawienia parametru $go*/
	if (is_file("content/".$go."/content.txt")) { /*sprawdzenie poprawności ustawienia parametru $go*/
		$menu_list = file("content/menu.txt"); /*wczytanie zawarości pliku menu.txt*/
		$header = file("content/".$go."/header.txt"); /*wczytanie zawarości pliku header.txt*/
		$content_list = file("content/".$go."/content.txt"); /*wczytanie zawartości pliku content.txt*/
		
		if (isset($sub1) && is_file("content/".$go."/".$sub1."/content.txt")) { /*sprawdzenie poprawności ustawienia parametru $sub1*/
			$sub_content_list = file("content/".$go."/".$sub1."/content.txt"); /*wczytywanie zawartości podstrony*/
			for ($i=0; $i<sizeof($sub_content_list); $i++) { /*przetworzenie zawartości podstrony*/
				$sub_content_list[$i] = rtrim($sub_content_list[$i]);
				$sub_content_list_strings[$i] = explode("####", $sub_content_list[$i]);
			}
		}
	} else { /*niepoprawne ustawienie parametru $go*/
		$menu_list = file("content/menu.txt");
		$header = file("content/strona_glowna/header.txt");
		$content_list = file("content/strona_glowna/content.txt");
	}
} else { /*nieustawiony parametr $go*/
	$menu_list = file("content/menu.txt");
	$header = file("content/strona_glowna/header.txt");
	$content_list = file("content/strona_glowna/content.txt");
}

/*przetworzenie zawartości menu*/
for ($i=0; $i<sizeof($menu_list); $i++) {
	$menu_list[$i] = rtrim($menu_list[$i]);
	$menu_list_url[$i] = explode("####", $menu_list[$i]);
}

/*przetworzenie zawartości strony*/
for ($i=0; $i<sizeof($content_list); $i++) {
	$content_list[$i] = rtrim($content_list[$i]);
	$content_list_strings[$i] = explode("####", $content_list[$i]);
}

/*przetworzenie zawartości nagłowka strony*/
$header_list = explode("####", $header[0]);
/*echo $header_list[2];*/
?>

<center>
<table class="layoutTable" cellpadding=0 cellspacing=0>
	<tr>
		<td class="tabela01" colspan=2 rowspan=2>
			<!-- /* graphics */ -->
			&nbsp;
		</td>
		<td class="tabela02" colspan=3>
			<!-- /* graphics */ -->
			&nbsp;
		</td>
	</tr>
	<tr>
		<td class="tabela03">
			<!-- /* graphics */ -->
			&nbsp;
		</td>
		<td class="tabela04">
			<!-- /* page title section */ -->
<?php
echo ('<div align="right"><h2 class="'.$header_list[1].'">'.$header_list[2].'</h2></div>'); /*wpisanie nagłówka strony*/
?>
		</td>
		<td class="tabela05" rowspan=3>
			<!-- /* white colour background */ -->
			&nbsp;
		</td>
	</tr>
	<tr>
		<td class="tabela06" rowspan=2>
			<!-- /* white colour background */ -->
			&nbsp;
		</td>
		<td class="tabela07">
			<!-- /* menu section */ -->
			<table class="menuTable" cellspacing="0" cellpadding="0">
<?php
/*menu_throw ($menu_list_url); /*zbudowanie menu*/
?>
			</table>

		</td>
		<td class="tabela08" colspan=2>
			<!-- /* main content section */ -->
<?php
$list_ou = array (0, 0);

// ckeditor

if (isset($go)) {
		$file = "content/".$go."/content.txt"; $zmienna2=file_get_contents($file);
	}
	else {
		$file = "content/strona_glowna/content.txt"; $zmienna2=file_get_contents($file);
	};
if(isset($_SESSION['uzytkownik']) && $_SESSION['uzytkownik']!="")
        {
		if($_POST['save']=="Edytuj") {
// uchwyt pliku, otwarcie do dopisania
$fp = fopen($file, "w");

// blokada pliku do zapisu
flock($fp, 2);
$dane=$_POST['editor1'];
// zapisanie danych do pliku
fwrite($fp, $dane);

// odblokowanie pliku
flock($fp, 3);

// zamknięcie pliku
fclose($fp); 
echo '<center><b>Treć została zmieniona.</b><br/><hr/></center>';
} else {
?>
<b>Zmień treć:</b><br/>
<form method="post" action="#">
		<textarea id="editor1" name="editor1" rows="10" cols="80"><? echo $zmienna2; ?></textarea>
		<br />
		<script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
		<center><input type="submit" name="save" value="Edytuj" /><input type="reset" name="reset" value="Reset" /></center>
</form><br/><hr/>
<? }; }; $zmienna=file_get_contents($file); echo $zmienna;

// ckeditor

if (isset($sub1)) { //generowanie zawartości podstrony
	for ($i=0; $i<sizeof($sub_content_list); $i++) {
		content_throw ($sub_content_list_strings[$i], $go, $sub1);
	}
} else { //generowanie zawartości strony
	for ($i=0; $i<sizeof($content_list); $i++) {
		content_throw ($content_list_strings[$i], $go, $sub1);
	}
}
?>
		</td>
	</tr>
	<tr>
		<td class="tabela09" colspan=3>
			<!-- /* footer section */ -->
<?php
include("_include/footer.txt");

if(isset($_SESSION['uzytkownik']) && $_SESSION['uzytkownik']!="")
        {
echo '<br/><a href="admin.php?wyloguj=tak">Wyloguj</a>';
		};
?>
		</td>
	</tr>
</table>
</center>

</body>
<!-- /* end body section */ -->

<!-- /* menu script */ -->
<script src="_menu/menu_main.js" language="JavaScript1.2"></script>
<script src="_menu/menu_items.js" language="JavaScript1.2"></script>

</html>
