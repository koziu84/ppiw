<?php
# categories.php      - iCategory, sName, iCategoryParent, iStatus, iType, iPosition
# categories_ext.php  - iCategory, sDescriptionShort, sDescriptionFull

if( !function_exists( 'dbThrowCategory' ) ){
  /**
  * Returns data for selected category
  * @return array
  * @param int $iCategory
  */
  function dbThrowCategory( $iCategory ){
    return $GLOBALS['oFF']->throwData( DB_CATEGORIES, $iCategory, 0 );
  } // end function dbThrowCategory
}

if( !function_exists( 'dbSaveCategory' ) ){
  /**
  * Save category to file
  * @return void
  * @param array $aForm
  * @param bool   $bExist
  */
  function dbSaveCategory( $aForm, $bExist = null ){
    global $oFF, $oCategory;
    if( !isset( $aForm['iType'] ) || empty( $aForm['iType'] ) ){
      if( is_numeric( $aForm['iParent'] ) && is_array( $oCategory->aData[$aForm['iParent']] ) ){
        $aForm['iType'] = $oCategory->aData[$aForm['iParent']]['iType'];
      }
      else{
        $aForm['iType'] = 1;
      }
    }
    $oFF->setRow( Array( $aForm['iCategory'], $aForm['sName'], $aForm['iParent'], $aForm['iStatus'], $aForm['iType'], $aForm['iPosition'] ) );

    $oFF->setData( Array( 5, 4, 2, 1, 0, 3 ) );
    if( isset( $bExist ) )
      $oFF->changeInFile( DB_CATEGORIES, $aForm['iCategory'], 0, 'sort' );
    else
      $oFF->addToFile( DB_CATEGORIES, 'sort' );

    if( $aForm['iStatus'] == 0 && empty( $aForm['iParent'] ) && is_numeric( $aForm['iCategory'] ) && $aForm['iStatus'] != $oCategory->aData[$aForm['iCategory']]['iStatus'] )
      dbChangeChildrenStatus( $aForm['iStatus'], $aForm['iCategory'] );

    return $aForm['iCategory'];
  } // end function dbSaveCategory
}

if( !function_exists( 'dbChangeChildrenStatus' ) ){
  /**
  * Returns categories list in array
  * @return void
  * @param int $iStatus
  * @param int $iParent
  */
  function dbChangeChildrenStatus( $iStatus, $iParent ){
    global $oFF, $oCategory;
    if( isset( $oCategory->aByParent[$iParent] ) ){
      $aChildren = $oCategory->aByParent[$iParent];
      $iCount = count( $aChildren );
      for( $i = 0; $i < $iCount; $i++ ){
        $aData = $oCategory->aData[$aChildren[$i]];
        if( $aData['iStatus'] != $iStatus ){
          $oFF->setRow( Array( $aData['iCategory'], $aData['sName'], $aData['iParent'], $iStatus, $aData['iType'], $aData['iPosition'] ) );
          $oFF->changeInFile( DB_CATEGORIES, $aData['iCategory'], 0 );
        }
      } // end for
    }
  } // end function dbChangeChildrenStatus
}

if( !function_exists( 'dbAddCategoryExtension' ) ){
  /**
  * Add category extensions to file
  * @return void
  * @param array  $aData
  * @param bool   $bErase
  */
  function dbAddCategoryExtension( $aData, $bErase = true ){
    global $oFF;
    if( isset( $bErase ) )
      $oFF->deleteInFile( DB_CATEGORIES_EXT, $aData[0], 0 );
    $oFF->setRow( $aData );
    $oFF->addToFile( DB_CATEGORIES_EXT );
  } // end function dbAddCategoryExtension
}

if( !function_exists( 'dbListCategories' ) ){
  /**
  * Returns categories list in array
  * @return void
  * @param int $iStatus
  */
  function dbListCategories( $iStatus ){
    $aFile =  file( DB_CATEGORIES );
    $iCount = count( $aFile );
    $aData =  null;
    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( $aExp[3] >= $iStatus )
        $aData[] = $aExp;
    } // end for
  
    $GLOBALS['oCategory']->listCategoriesToArray( $aData );
  } // end function dbListCategories
}

if( !function_exists( 'dbDelCategory' ) ){
  /**
  * Deletes selected category
  * @return void
  * @param int $iCategory
  */
  function dbDelCategory( $iCategory ){
    $GLOBALS['oFF']->deleteInFile( DB_CATEGORIES, $iCategory, 0 );
    $GLOBALS['oFF']->deleteInFile( DB_CATEGORIES_EXT, $iCategory, 0 );
    $GLOBALS['oFF']->deleteInFile( DB_PRODUCTS_CATEGORIES, $iCategory, 0 );
  } // end function dbDelCategory
}

if( !function_exists( 'dbThrowCategoryExt' ) ){
  /**
  * Throw categories data extension
  * @return array
  */
  function dbThrowCategoryExt( ){
    return $GLOBALS['oFF']->throwFileArray( DB_CATEGORIES_EXT );
  } // end function dbThrowCategoryExt
}

?>