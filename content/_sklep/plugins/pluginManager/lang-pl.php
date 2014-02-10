<?php
/*
* pluginManager plugin - polski plik jêzykowy
*/
$lang['Plugin_manager'] = 'Plugin Manager';
$lang['plugins'] = 'Pluginy';
$lang['Online'] = 'Online';
$lang['Offline'] = 'Offline';
$lang['CatalogueOnly'] = 'Tylko katalog';
$lang['shopStatusCatalogue'] = 'W serwisie trwaj± prace koserwacyjne.<br />Dlatego mo¿liwo¶æ sk³adania zamówien<br />zosta³a czasowo zablokowana.<br />Proszê spróbowaæ ponownie w pó¼niejszym czasie.';
$lang['shopStatusOffline'] = 'Serwis jest w trakcie aktualizacji.<br />Dlatego przegl±danie produktów jak i dokonywanie zamówieñ<br />zosta³o czasowo zablokowane.<br />Proszê spróbowaæ ponownie w pó¼niejszym czasie.';

$lang['PMdollar'] = '$';
$lang['PMdisabledMissing'] = 'Plugin jest wy³±czony lub b³êdnie zainstalowany';
$lang['PMunmodifiable'] = 'Nie mo¿e byæ zmodyfikowane.';
$lang['PMunwritable'] = 'Nie mo¿na zapisaæ w pliku config.php - sprawd¼ uprawienia';
$lang['PMversionMismatch'] = 'Wersja w setup.php to $aPlugin[badVersion]!';
$lang['PMreloadSetup'] = 'Prze³aduj Setup dla $aPlugin[name]';
$lang['PMprerequisites'] = 'Wymagane modu³y';
$lang['PMpreloadLang'] = 'Pre-Load Language';
$lang['PMsetupInformation'] = 'Setup Information:';
$lang['PMrequiredFiles'] = 'Wymagane pliki.';
$lang['PMwhenEnabled'] = 'Tylko gdy aktywne';
$lang['PMalways'] = 'Zawsze';
$lang['PMvariable'] = 'Zmienna';
$lang['PMformat'] = 'Format';
$lang['PMstringFormat'] = 'string';
$lang['PMnumberFormat'] = 'number';
$lang['PMbooleanFormat'] = 'boolean';
$lang['PMexactFormat'] = 'exact';
$lang['PMarrayFormat'] = 'array';
$lang['PMhelp'] = 'Help';
$lang['PMabout'] = 'O:';
$lang['PMclickToHide'] = 'Kliknij by ukryæ';

$lang['PMconfigHelp']  = '<p>Hover over the field label and a tooltip will show the Variable and Format relating to the field. ';
$lang['PMconfigHelp'] .= 'The Format indicates the type of the Variable, and how it should be entered in the form\'s input field.</p>';
$lang['PMconfigHelp'] .= '<p><b>string</b> : specifies a string format, but surrounding quotes are not required - they will be added when the form is submitted.</p>';
$lang['PMconfigHelp'] .= '<p><b>number</b> : specifies a number format; this covers all number formats, and any specific requirement will be enforced by field validation routines.</p>';
$lang['PMconfigHelp'] .= '<p><b>boolean</b> : indicates that the field is of the true/false type; options will usualy be governed by checkbox, radio buttons, or dropdowns.</p>';
$lang['PMconfigHelp'] .= '<p><b>exact</b> : this is the catch-all for any variables that do not fit the above types; ';
$lang['PMconfigHelp'] .= 'in this case, with the exception of the surrounding array if one is indicated, the fields have to be entered exactly as they will be stored - this includes ny quotes around strings.</p>';
$lang['PMconfigHelp'] .= '<p><b>array(..)</b> : this indicates that the variable is stored as an array once the form is submitted; ';
$lang['PMconfigHelp'] .= 'the Format inside the brackets gives the actual formats expected in the input field.</p>';
$lang['PMconfigHelp'] .= '<p>The Formats inside array(..) brackets will usually either be a single Format followed by an asterisk - eg. string* - or a comma separated list of Formats. ';
$lang['PMconfigHelp'] .= 'The asterisk signifies an expandable array of one or more elements (any limitations will be handled by field validation routines). ';
$lang['PMconfigHelp'] .= 'A list of Formats indicates the the array is expected to consist solely of the specified number of elements, and in the specified order and Format.</p>';
$lang['PMconfigHelp'] .= '<p>The notes alongside each field will often give more details about the expected variable contents and valid values.</p>';

$lang['PMCI']['db_plugins']['name'] = 'Plik danych pluginu';
$lang['PMCI']['themesFolder']['name'] = $lang['PMCI']['themesFolder']['alt'] = 'Folder tematów';
$lang['PMCI']['theme']['name'] = $lang['PMCI']['theme']['alt'] = 'Szablon tematu';
$lang['PMCI']['theme']['text'] = 'Wybierz temat. Ka¿dy temat ma swój w³asny folder w /templates/[Themes Folder]. W obrêbie tematu mo¿e byæ kolka arkuszy stylów, wybieranych z panelu administracyjnego. BE AWARE that changing Theme here may affect the selected style because the program will attempt to find your current style in the new Theme, and will then look for and set a default if it can\'t find a match!';
$lang['PMCI']['aPM_ignorePlugins']['name'] = 'Pluginy do pominiêcia';
$lang['PMCI']['aPM_ignorePlugins']['alt'] = 'Lista pominiêtych pluginów, odseparowane przecinkami';
$lang['PMCI']['aPM_ignorePlugins']['text'] = 'Comma-separated list of the plugins that cannot be enabled/disabled. You don\'t need to specify pluginManager - it is ignored automatically. Don\'t enter any quotation marks - these will be applied automatically.';
$lang['PMCI']['bPM_versionChecking']['name'] = 'Version Checking';
$lang['PMCI']['bPM_versionChecking']['alt'] = 'Enable Version Checking';
$lang['PMCI']['bPM_versionChecking']['text'] = 'Enables or disables Version Checking of plugins. Version Checking automatically disables the plugin if it finds a version mismatch, and you will not be allowed to re-enable or configure it until the mismatch is resolved.';
$lang['PMCI']['bPMshortMsgClickHide']['name'] = $lang['PMCI']['bPMshortMsgClickHide']['alt'] = '"Click-to-hide" Short Messages';
$lang['PMCI']['bPMshortMsgClickHide']['text'] = 'If enabled, provides script which allows the short message for successfully Saved or Deleted Admin items to be hidden by clicking the message.';
$lang['PMCI']['shopStatus']['name'] = $lang['PMCI']['shopStatus']['alt'] = 'Shop Status';
$lang['PMCI']['shopStatus']['text'] = 'Shop status can be set to : Online (default), which means all functionality is enabled; Offline, which means that all product listings are disabled, and only content pages are visible; and Catalogue Only, which means that all products and product information can be viewed <b>but not placed in the Basket</b>.';
?>
