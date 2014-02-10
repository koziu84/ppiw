<?php
if( !function_exists( 'addFile' ) ){
  /**
  * Add new file
  * @return void
  * @param int    $iLink
  * @param string $sFileName
  * @param string $sDescription
  * @param int    $iType
  * @param int    $iLinkType
  */
  function addFile( $iLink, $sFileName, $sDescription, $iType, $iLinkType = 1 ){
    dbAddFile( $iLink, $sFileName, changeTxt( ereg_replace( '\'', '', $sDescription ) ), $iType, $iLinkType );
  } // end function addFile
}

if( !function_exists( 'delFile' ) ){
  /**
  * Delete file
  * @return void
  * @param int  $iFile
  * @param int  $iType
  */
  function delFile( $iFile, $iType = 1 ){
    global $oFoto;
    $sDir       = throwFilesDir( $iType );
    $sFileName  = dbDelFile( $iFile, $iType );
    if( isset( $sFileName ) ){
      $aName = $oFoto->throwNameExtOfFile( $sFileName );
      if( is_file( $sDir.$aName[0].'_m.'.$aName[1] ) )
        unlink( $sDir.$aName[0].'_m.'.$aName[1] );
      unlink( $sDir.$sFileName );
    }
  } // end function delFile
}

if( !function_exists( 'addFiles' ) ){
  /**
  * Save all files and photos
  * @return void
  * @param array  $aForm
  * @param int    $iLink
  * @param int    $iSize
  * @param int    $iType
  */
  function addFiles( $aForm, $iLink, $iSize, $iType = 1 ){
    global $oFoto;
      
    $sDir   = throwFilesDir( $iType );
    $iCount = count( $_FILES['aFile']['name'] );
    
    for( $i = 0; $i < $iCount; $i++ ){
      if( !empty( $_FILES['aFile']['name'][$i] ) ){

        $aFile['tmp_name']  = $_FILES['aFile']['tmp_name'][$i];
        $aFile['name']      = $_FILES['aFile']['name'][$i];
        
        if( $oFoto->checkCorrectFile( $aFile['name'], 'gif|jpg|png|jpeg' ) == true ){
          if( !empty( $aForm['aPhotoSize'][$i] ) && is_numeric( $aForm['aPhotoSize'][$i] ) )
            $oFoto->setThumbSize( $aForm['aPhotoSize'][$i] );
          else
            $oFoto->setThumbSize( $iSize );

          $mFotos     = $oFoto->copyAndCreateThumb( $sDir, $aFile, $aFile['name'], 'upload' );
          $iFileType  = 1;

          if( isset( $mFotos ) )
            $sFileName = $mFotos['bFile'];
          else
            $sFileName = null;
        }
        else{
          $sFileName = $oFoto->uploadFile( $aFile, $sDir );
          $iFileType = 0;
        }
  
        if( isset( $sFileName ) )        
          addFile( $iLink, $sFileName, $aForm['aFileDescription'][$i], $iFileType, $iType );
      }
    } // end for
  } // end function addFiles
}

if( !function_exists( 'delFiles' ) ){
  /**
  * Delete files and photos
  * @return void
  * @param int  $iLink
  * @param int  $iType
  */
  function delFiles( $iLink, $iType = 1 ){
    $aData = dbListFiles( $iLink, $iType );
    if( isset( $aData[0] ) ){
      $iCount = count( $aData[0] );
      for( $i = 0; $i < $iCount; $i++ ){
        delFile( $aData[0][$i][0], $iType );
      } // end for  
    }
    
    if( isset( $aData[1] ) ){
      $iCount = count( $aData[1] );
      for( $i = 0; $i < $iCount; $i++ ){
        delFile( $aData[1][$i][0], $iType );
      } // end for  
    }    
  } // end function delFiles
}
?>