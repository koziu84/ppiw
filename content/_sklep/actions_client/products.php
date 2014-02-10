<?php
require_once DIR_CORE.'files-'.$config['db_type'].'.php';
require_once DIR_CORE.'files.php';

require_once DIR_CORE.'products-'.$config['db_type'].'.php';
require_once DIR_CORE.'products.php';

if( $a == 'List' ){
  $sCategoryDescription = null;
  if( isset( $iCategory ) && is_numeric( $iCategory ) ){
    $aData  = throwCategory( $iCategory, true, true );
    if( isset( $aData ) && is_array( $aData ) ){

      if( is_numeric( $aData['iParent'] ) )
        $aData['sName'] = throwCategoryName( $aData['iParent'] ).' &#8211; '.$aData['sName'];

      $sTitleBefore = $aData['sName'].' &#8211;';
      $aFiles       = listFiles( $iCategory, 'products_category.tpl', 2 );

      if( isset( $aFiles['sPhotosDefault'] ) )
        $sContentPanel = $aFiles['sPhotosDefault'];
      if( isset( $aFiles['sPhotos'] ) )
        $sContentPanel .= $aFiles['sPhotos'];

      if( isset( $sContentPanel ) && !empty( $sContentPanel ) )
        $sBlock = 'COLUMNS_TWO';
      else
        $sBlock = 'COLUMNS_ONE';

      $sCategoryDesc = $tpl->tbHtml( 'products_category.tpl', $sBlock );
      $content      .= listProducts( 'products_list.tpl', 'category', $iCategory );
    }
    else{
      $content .= $tpl->tbHtml( 'messages.tpl', 'NOT_EXISTS' );
    }
  }
  else{
    if( isset( $sWord ) && throwStrlen( $sWord ) > 0 ){
      $content .= listProducts( 'products_list.tpl', 'search', $sWord );
    }
    else{
      $content .= listProducts( 'products_list.tpl' );
    }
  }
}
elseif( $a == 'More' && isset( $iProduct ) && is_numeric( $iProduct ) ){
  if( isset( $bPrint ) )
    $sFile = 'products_print.tpl';
  else
    $sFile = 'products_more.tpl';
  
  $aData = throwProduct( $iProduct );
  if( isset( $aData ) ){
    $aFiles =  listFiles( $iProduct, $sFile, 1 );

    if( empty( $aData['sDescriptionFull'] ) ){
      $aData['sDescriptionFull'] = $aData['sDescriptionShort'];
    }

    $aData['sDescriptionFull']  = changeTxt( $aData['sDescriptionFull'], 'nlNds' );
    $aData['sCategories']       = throwTreeForProduct( $aData['aCategories'], $sFile );

    $sTitleBefore = $aData['sName'].' &#8211; ';

    $content .= $tpl->tbHtml( $sFile, 'SHOW' );
  }
  else
    $content .= $tpl->tbHtml( 'messages.tpl', 'NOT_EXISTS' );
}
else
  $content .= $tpl->tbHtml( 'messages.tpl', 'ERROR' ); 
?>
