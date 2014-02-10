<?php
/*
* Quick.Cart by OpenSolution.org
*
* Contact: info@opensolution.org
* www.opensolution.org
*/
session_start( );

extract( $_GET );

if( !isset( $p ) || $p == '' )
  $p  = '';

if( ereg( 'Window', $p ) ){
  $p          = ereg_replace( 'Window', '', $p );
  $bPrint     = true;
  $sBlockPage = '_PRINT';
}

require 'config/general.php';
require_once DIR_LANG.LANGUAGE.'.php';
header( 'Content-Type: text/html; charset='.$config['charset'] );
require_once DIR_LIBRARIES.'TplParser.php';
require_once DIR_LIBRARIES.'FileJobs.php';
require_once DIR_LIBRARIES.'FotoJobs.php';
require_once DIR_LIBRARIES.'FlatFiles.php';
require_once DIR_LIBRARIES.'Trash.php';

if( isset( $sWord ) && !empty( $sWord ) )
  $sWord = htmlspecialchars( changeSpecialChars( stripslashes( $sWord ) ) );

/*
* Add-ons functions 
*/
if( filesize( DIR_PLUGINS.'plugins.php' ) > 30 )
  require_once DIR_PLUGINS.'plugins.php';

require_once DIR_CORE.'other.php';
require_once DIR_CORE.'preferences.php';

require_once DIR_PLUGINS.'edit/htmleditor.php';

$tpl    = new TplParser;
$oFoto  = new FotoJobs;
$oFF    = new FlatFiles;

$tpl->setDir( TPL.'admin/' );
$oFoto->setRatio( $config['foto_jobs_ratio'] );

/*
* Login 
*/
loginActions( $p, 'bUserQC' );

$content = null;

/*
* Add-ons actions
*/
if( filesize( DIR_PLUGINS.'actions_admin.php' ) > 30 )
  require_once DIR_PLUGINS.'actions_admin.php';

getAction( $p, 'actions_admin/' );  

if( is_file( $sActionFile ) )
  require $sActionFile;

if( !isset( $bPrint ) )
  $sBlockPage = null;

echo $tpl->tbHtml( 'page.tpl', 'HEAD'.$sBlockPage ).$content.$tpl->tbHtml( 'page.tpl', 'FOOTER'.$sBlockPage );
?>