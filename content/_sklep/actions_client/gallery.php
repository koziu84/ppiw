<?php
require_once DIR_CORE.'files-'.$config['db_type'].'.php';
require_once DIR_CORE.'files.php';

require_once DIR_CORE.'products-'.$config['db_type'].'.php';
require_once DIR_CORE.'products.php';

if( $a == 'Show' ){
  if( isset( $iIdLink ) && is_numeric( $iIdLink ) && isset( $iType ) && is_numeric( $iType ) ){
    if( $iType == 1 )
      $aData  = throwProduct( $iIdLink );
    else
      $aData  = throwCategory( $iIdLink, true, true );
  }

  if( isset( $aData ) && is_array( $aData ) ){
    $aGalleryFiles  = listFiles( $iIdLink, 'gallery.tpl', $iType );
    $content .= $tpl->tbHtml( 'gallery.tpl', 'SHOW' );
  }
  else
    $content .= $tpl->tbHtml( 'messages.tpl', 'ERROR' );
}
?>