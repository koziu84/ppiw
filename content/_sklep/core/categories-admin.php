<?php
if( !function_exists( 'saveCategory' ) ){
  /**
  * Save category
  * @return int
  * @param array $aForm
  */
  function saveCategory( $aForm ){

    $aForm['sName'] =             changeTxt( $aForm['sName'] );
    $aForm['sDescriptionShort'] = changeTxt( $aForm['sDescriptionShort'], 'Nds' );
    $aForm['sDescriptionFull'] =  changeTxt( $aForm['sDescriptionFull'],  'Nds' );

    if( !isset( $aForm['iPosition'] ) || !is_numeric( $aForm['iPosition'] ) || $aForm['iPosition'] < -99 || $aForm['iPosition'] > 999 )
      $aForm['iPosition'] = 0;

    if( is_numeric( $aForm['iCategory'] ) ){
      $bExist = true;
    }
    else{
      $bExist =             null;
      $aForm['iCategory'] = throwLastId( DB_CATEGORIES, 0 ) + 1;
    }

    dbSaveCategory( $aForm, $bExist );
    dbAddCategoryExtension( Array( $aForm['iCategory'], $aForm['sDescriptionShort'], $aForm['sDescriptionFull'] ) );
    if( isset( $_FILES['aFile'] ) )
      addFiles( $aForm, $aForm['iCategory'], CATEGORIES_PHOTO_SIZE, 2 );

    if( isset( $aForm['aFileDescriptionChange'] ) && is_array( $aForm['aFileDescriptionChange'] ) ){
      foreach( $aForm['aFileDescriptionChange'] as $iKey => $sValue ){
        dbChangeFileDescription( Array( $iKey, $aForm['iCategory'], $aForm['aFileNameChange'][$iKey], changeTxt( ereg_replace( '\'', '', $sValue ) ), $aForm['aFileType'][$iKey] ), 2 );
      }
    }

    if( isset( $aForm['aDelFile'] ) && is_array( $aForm['aDelFile'] ) ){
      $iCount = count( $aForm['aDelFile'] );
      for( $i = 0; $i < $iCount; $i++ )
        delFile( $aForm['aDelFile'][$i], 2 );
    }

    return $aForm['iCategory'];
  } // end function saveCategory
}


if( !function_exists( 'delCategory' ) ){
  /**
  * Deletes selected category
  * @return void
  * @param array $iCategory
  */
  function delCategory( $iCategory ){
    delFiles( $iCategory, 2 );
    dbDelCategory( $iCategory );
    delCategoryChildren( $iCategory );
  } // end function delCategory
}

if( !function_exists( 'delCategoryChildren' ) ){
  /**
  * Deletes subcategories
  * @return void
  * @param int    $iParent
  */
  function delCategoryChildren( $iParent ){
    global $oCategory;
    
    if( isset( $oCategory->aByParent[$iParent] ) )
      $aCategories = $oCategory->aByParent[$iParent];

    $content =  null;
    if( isset( $aCategories ) && is_array( $aCategories ) ){
      $iCount =   count( $aCategories );
      for( $i = 0; $i < $iCount; $i++ ){
        $iCategory = $aCategories[$i];
        delFiles( $iCategory, 2 );
        dbDelCategory( $iCategory );
      } // end for
    }
  } // end function delCategoryChildren
}

if( !function_exists( 'listCategoriesByTypes' ) ){
  /**
  * List categories by types
  * @return string
  * @param string $sFile
  * @param bool   $bParentOnly
  * @param array  $aSelected
  * @param string $sOption
  */
  function listCategoriesByTypes( $sFile, $bParentOnly = null, $aSelected = null, $sOption = null ){
    global $tpl, $oCategory, $aTypes;

    if( !is_array( $aSelected ) )
      $aSelected = Array( );
    $oCategory->sFile =       $sFile;
    $oCategory->aSelected =   $aSelected;
    $oCategory->sOption =     $sOption;

    $content =  null;

    foreach( $oCategory->aTypes as $aTypes['iType'] => $aTypes['sName'] ){
      if( isset( $oCategory->aMainByTypes[$aTypes['iType']] ) ){
        $aCategories = $oCategory->aMainByTypes[$aTypes['iType']];
        $content .= $tpl->tbHtml( $sFile, 'LIST_TYPE' );
        $iCount = count( $aCategories );
        for( $i = 0; $i < $iCount; $i++ ){
          $iCategory = $aCategories[$i];
          $content .= throwListContent( $iCategory );
          if( isset( $oCategory->aByParent[$iCategory] ) && !isset( $bParentOnly ) )
            // jesli dana kategoria posiada dzieci
            $content .= listCategoriesChildren( $iCategory );
        } // end for
      }    
    } // end foreach

    if( isset( $content ) )
      return $tpl->tbHtml( $sFile, 'LIST_HEAD' ) . $content . $tpl->tbHtml( $sFile, 'LIST_FOOTER' );
    else
      return null;
  } // end function listCategoriesByTypes
}

?>