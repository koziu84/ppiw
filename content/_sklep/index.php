<?php
/*
* Quick.Cart by OpenSolution.org
*
* Contact: info@opensolution.org
* www.opensolution.org
*/
extract( $_GET );

require 'config/general.php';

if( !isset( $p ) || $p == '' ){
  $p  = $config['start_page'];
}

if( ereg( 'Window', $p ) ){
  $p          = ereg_replace( 'Window', '', $p );
  $bPrint     = true;
  $sBlockPage = '_PRINT';
}
elseif( ereg( 'Gallery', $p ) ){
  $p          = ereg_replace( 'Gallery', '', $p );
  $bGallery   = true;
  $sBlockPage = '_GALLERY';
}

if( !isset( $iCategory ) )
  $iCategory = null;

require_once DIR_LANG.LANGUAGE.'.php';

require_once DIR_LIBRARIES.'TplParser.php';
require_once DIR_LIBRARIES.'FileJobs.php';
require_once DIR_LIBRARIES.'FlatFiles.php';
require_once DIR_LIBRARIES.'Trash.php';

if( isset( $sWord ) && !empty( $sWord ) )
  $sWord = htmlspecialchars( changeSpecialChars( stripslashes( $sWord ) ) );

/*
* Add-ons functions
*/
if( filesize( DIR_PLUGINS.'plugins.php' ) > 30 )
  require DIR_PLUGINS.'plugins.php';

$tpl    = new TplParser;
$oFF    = new FlatFiles;
$content= null;
$tpl->setDir( TPL );

require_once DIR_CORE.'other.php';
require_once DIR_CORE.'categories-'.$config['db_type'].'.php';
require_once DIR_CORE.'categories.php';

/*
* Add-ons actions
*/
if( filesize( DIR_PLUGINS.'actions_client.php' ) > 30 )
  require DIR_PLUGINS.'actions_client.php';

getAction( $p, 'actions_client/' );

if( is_file( $sActionFile ) )
  require_once $sActionFile;
else{
  require_once DIR_CORE.'files-'.$config['db_type'].'.php';
  require_once DIR_CORE.'files.php';

  if( !isset( $bDisplayedPage ) ){
    if( strlen( $p ) > 2 )
      $iCategory = substr( $p, 2 );

    if( !is_numeric( $iCategory ) )
      $iCategory = $config['contact_page'];

    $aData = throwCategory( $iCategory, true, true );

    if( !isset( $aData['sDescriptionFull'] ) ){
      $iCategory  = $config['contact_page'];
      $aData      = throwCategory( $iCategory, true, true );
    }

    $sBlock         = 'COLUMNS_ONE';
    $sTitleBefore   = $aData['sName'].' &#8211; ';
    $sSubcategories = listCategoriesChildren( $iCategory, 'contents_more.tpl', true );
    $aFiles         = listFiles( $iCategory, 'contents_more.tpl', 2 );

    if( $iCategory == $config['contact_page'] ){
      if( isset( $_POST['sSend'] ) )
        $sContentPanel =  sendEmail( $_POST, 'contact.tpl' );
      else
        $sContentPanel =  $tpl->tbHtml( 'contact.tpl', 'FORM' );
      $sBlock = 'COLUMNS_TWO_CONTACT';
    }
    else{
      if( isset( $aFiles['sPhotosDefault'] ) )
        $sContentPanel = $aFiles['sPhotosDefault'];
      if( isset( $aFiles['sPhotos'] ) )
        $sContentPanel .= $aFiles['sPhotos'];
      
      if( isset( $sContentPanel ) && !empty( $sContentPanel ) )
        $sBlock = 'COLUMNS_TWO';
    }
    $content .= $tpl->tbHtml( 'contents_more.tpl', $sBlock );
  }
}

if( !isset( $sBlockPage ) ){
  if( !isset( $sCategoriesMenu ) )
    $sCategoriesMenu = listCategories( 'categories_menu.tpl', 1, true, Array( $iCategory ) );
  if( !isset( $sContentsMenu ) )
    $sContentsMenu = listCategories( 'contents_menu.tpl', 2, true, Array( $iCategory ) );
  $sBlockPage = null;
}

echo $tpl->tbHtml( 'page.tpl', 'HEAD'.$sBlockPage ).$content.$tpl->tbHtml( 'page.tpl', 'FOOTER'.$sBlockPage );
?>
