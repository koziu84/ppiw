<?php
/*
* see instructions.txt
*
* Can cope with 2 levels of $config, ie. $config['one']= and $config['one']['two']=, but no more. Any further
* levels have to be of the form $config['one'] = array(array(..), array(..), ..);.
* DO NOT use comments part-way through declarations (in-line comments will be parsed incorrectly, and block comments will disappear after the first update)
* eg. these are OK :
*   <newline>// this is a comment
*   <newline>$config['one'] = 'two'; // this is a comment
* BUT this is NOT:
*   <newline>$config[array_one] = 'ten',     // this comment will be parsed incorrectly as part of the variable value
*   <newline>                     'eleven'); // this comment is ok
*/
$config['db_plugins'] = 'config/plugins.php';
define('DB_PLUGINS', $config['db_plugins']);
$config['themesFolder'] = 'themes';
$config['aPM_ignorePlugins'] = array('edit');
$config['bPM_versionChecking'] = true;
$config['bPMshortMsgClickHide'] = true;
$config['theme'] = 'default';
$config['shopStatus'] = 'online';
/* Plugin Manager Configuration Instructions */
$PMCI['db_plugins']['disable'] = $PMCI['themesFolder']['disable'] = true;
$PMCI['aPM_ignorePlugins']['format'] = 's*';
// $PMCI['theme']['type'] is set in actions_admin.php by a call to setPMCIthemeSelect()
$PMCI['shopStatus']['type'] = 'select(online='.$lang['Online'].',offline='.$lang['Offline'].',catalogue='.$lang['CatalogueOnly'].')';
?>
