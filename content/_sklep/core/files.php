<?php
if( !function_exists( 'throwFilesDir' ) ){
  /**
  * Returns name of dir
  * @return string
  * @param int  $iType
  */
  function throwFilesDir( $iType = 1 ){
    if( $iType == 1 )
      return DIR_PRODUCTS_FILES;
    else
      return DIR_CATEGORIES_FILES;
  } // end function throwFilesDir
}

if( !function_exists( 'listFiles' ) ){
  /**
  * Returns all files and photos of product or category etc
  * @return array
  * @param int    $iLink
  * @param string $sFile
  * @param int    $iType
  */
  function listFiles( $iLink, $sFile = null, $iType = 1 ){
    global $aList, $oFF, $tpl;

    $sDir   = throwFilesDir( $iType );
    $aData  = dbListFiles( $iLink, $iType );
    
    if( isset( $aData[0] ) && is_array( $aData[0] ) ){
      $aExt   = throwIconsFromExt( );
      $iCount = count( $aData[0] );

      for( $i = 0; $i < $iCount; $i++ ){
        list( $aList['iFile'], $aList['iPosition'], $aList['sFile'], $aList['sDescription'], $aList['iType'] ) = $aData[0][$i];
        
        if( is_file( $sDir.$aList['sFile'] ) ){
         
          $aName = $oFF->throwNameExtOfFile( $aList['sFile'] );
          
          if( !isset( $aExt[$aName[1]] ) )
            $aExt[$aName[1]] = 'nn';
          
          $aList['sIcon'] = 'ico_'.$aExt[$aName[1]];

          if( !isset( $aReturn['sFiles'] ) )
            $aReturn['sFiles'] = $tpl->tbHtml( $sFile, 'FILES_HEAD' );

          $aReturn['sFiles'] .= $tpl->tbHtml( $sFile, 'FILES_LIST' );
          
        }
      } // end for

      if( isset( $aReturn['sFiles'] ) )
        $aReturn['sFiles'] .= $tpl->tbHtml( $sFile, 'FILES_FOOTER' );
    }

    if( isset( $aData[1] ) && is_array( $aData[1] ) ){

      $iCount = count( $aData[1] );

      for( $i = 0; $i < $iCount; $i++ ){
        list( $aList['iFile'], $aList['iPosition'], $aList['sFile'], $aList['sDescription'], $aList['iType'] ) = $aData[1][$i];
        
        if( is_file( $sDir.$aList['sFile'] ) ){

          $aName = $oFF->throwNameExtOfFile( $aList['sFile'] );
          $aList['sPhotoSmall'] = $sDir.$aName[0].'_m.'.$aName[1];
          $aList['sPhotoBig']   = $sDir.$aList['sFile'];

          if( isset( $aReturn['sPhotosDefault'] ) ){
            if( !isset( $aReturn['sPhotos'] ) )
              $aReturn['sPhotos'] = $tpl->tbHtml( $sFile, 'PHOTO_HEAD' );

            $aReturn['sPhotos'] .= $tpl->tbHtml( $sFile, 'PHOTO_LIST' );            
          }
          else
            $aReturn['sPhotosDefault'] = $tpl->tbHtml( $sFile, 'PHOTO_DEFAULT' );
          
        }
      } // end for
            
      if( isset( $aReturn['sPhotos'] ) )
        $aReturn['sPhotos'] .= $tpl->tbHtml( $sFile, 'PHOTO_FOOTER' );
    }
  
    if( isset( $aReturn ) )
      return $aReturn;
  } // end function listFiles
}

if( !function_exists( 'throwFirstPhoto' ) ){
  /**
  * Return first photos of products, categories etc
  * @return array
  * @param int  $iType
  */
  function throwFirstPhoto( $iType ){
    $aData  = dbThrowFirstPhoto( $iType );
    $iCount = count( $aData );
    $aPhoto  = null;

    for( $i = 0; $i < $iCount; $i++ ){
      list( $aPhoto[$aData[$i][1]]['iFile'], $aPhoto[$aData[$i][1]]['iLink'], $aPhoto[$aData[$i][1]]['sPhoto'], $aPhoto[$aData[$i][1]]['sDescription'] ) = $aData[$i];
    } // end for
    return $aPhoto;
  } // end function throwFirstPhoto
}
?>