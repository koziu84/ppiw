<?php
if( !function_exists( 'dbThrowFirstPhoto' ) ){
  /**
  * Return first photos
  * @return array
  * @param int  $iType
  */
  function dbThrowFirstPhoto( $iType = 1 ){
    $aFile  = file( dbThrowFile( $iType ) );
    $iCount = count( $aFile );
    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( !isset( $aPhoto[$aExp[1]] ) && $aExp[4] == 1 ){
        $aData[]          = $aExp;
        $aPhoto[$aExp[1]] = true;
      }
    } // end for
    if( isset( $aData ) )
      return $aData;
  } // end function dbThrowFirstPhoto
}

if( !function_exists( 'dbListFiles' ) ){
  /**
  * List files and photos
  * @return array
  * @param int  $iLink
  * @param int  $iType
  */
  function dbListFiles( $iLink, $iType = 1 ){
    $aFile  = file( dbThrowFile( $iType ) );
    $iCount = count( $aFile );
    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( $aExp[1] == $iLink )
        $aData[$aExp[4]][] = $aExp;
    } // end for
    
    if( isset( $aData ) )
      return $aData;
  } // end function dbListFiles
}

if( !function_exists( 'dbThrowFile' ) ){
  /**
  * Return db file name
  * @return string
  * @param int  $iType
  */
  function dbThrowFile( $iType = 1 ){
    if( $iType == 1 )
      return DB_PRODUCTS_FILES;
    else
      return DB_CATEGORIES_FILES;
  } // end function dbThrowFile
}

if( !function_exists( 'dbAddFile' ) ){
  /**
  * Add file or photo data to file
  * @return void
  * @param int    $iLink
  * @param string $sFileName
  * @param string $sDescription
  * @param int    $iType
  * @param int    $iLinkType
  */
  function dbAddFile( $iLink, $sFileName, $sDescription, $iType, $iLinkType = 1 ){
    global $oFF;
    $sFile = dbThrowFile( $iLinkType );
    $oFF->setRow( Array( throwLastId( $sFile ) + 1, $iLink, $sFileName, $sDescription, $iType ) );
    $oFF->addToFile( $sFile );
  } // end function dbAddFile
}

if( !function_exists( 'dbDelFile' ) ){
  /**
  * Delete file or photo from db file
  * @return string
  * @param int  $iFile
  * @param int  $iType
  */
  function dbDelFile( $iFile, $iType = 1 ){
    global $oFF;

    $sFile  = dbThrowFile( $iType );
    $aFile  = file( $sFile );
    $rFile  = fopen( $sFile, 'w' );
    $iCount = count( $aFile );

    for( $i = 0; $i < $iCount; $i++ ){
      if( $i > 0 ){
        $aFile[$i]  = ereg_replace( "\r", "", $aFile[$i] );
        $aExp       = explode( '$', $aFile[$i] );
        
        if( $aExp[0] == $iFile ){
          $aFile[$i] = '';
          $sDel = $aExp[2];
        }
      }
      fwrite( $rFile, $aFile[$i] );
    } // end for
    fclose( $rFile );

    if( isset( $sDel ) )
      return $sDel;
  } // end function dbDelFile
}

if( !function_exists( 'dbChangeFileDescription' ) ){
  /**
  * Change file or photo description
  * @return void
  * @param array  $aForm
  * @param int    $iType
  */
  function dbChangeFileDescription( $aForm, $iType = 1 ){
    global $oFF;
    $oFF->setRow( $aForm );
    $oFF->changeInFile( dbThrowFile( $iType ), $aForm[0], 0 );
  } // end function dbChangeFileDescription
}
?>