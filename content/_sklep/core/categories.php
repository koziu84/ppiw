<?php

class Categories {

  var $aData;
  var $aOnlyNames;
  var $aByParent;
  var $aMain;
  var $aParent;
  var $aMainByTypes;
  var $sFile =        null;
  var $aSelected =    null;
  var $iType =        null;
  var $sOption =      null;
  var $aTypes;
  var $aFirstFoto;
  var $aTreeForProduct;
  
  /**
  * Constructor
  */
  function Categories( ){
    global $lang;
    $this->aTypes = Array( 1 => $lang['products'], 2 => $lang['content'] );
  } // end function

  /**
  * Puts categories data to array
  * @return void
  * @param array  $aData
  */
  function listCategoriesToArray( $aData ){
    $iCount =   count( $aData );
    for( $i = 0; $i < $iCount; $i++ ){
      list( $aList['iCategory'], $aList['sName'], $aList['iParent'], $aList['iStatus'], $aList['iType'], $aList['iPosition'] ) = $aData[$i];

      $this->aData[$aList['iCategory']] =       $aList;
      $this->aOnlyNames[$aList['iCategory']] =  $aList['sName'];
      if( is_numeric( $aList['iParent'] ) && $aList['iParent'] > 0 ){
        $this->aByParent[$aList['iParent']][] = $aList['iCategory'];
        $this->aParent[$aList['iCategory']] =   $aList['iParent'];
      }
      else{
        $this->aMain[] =                          $aList['iCategory'];
        $this->aMainByTypes[$aList['iType']][] =  $aList['iCategory'];
        $this->aParent[$aList['iCategory']] =     $aList['iCategory'];
      }
    } // end for
  } // end function listCategoriesToArray

} // end class Categories

$oCategory = new Categories;

dbListCategories( throwStatus( ) );

if( !function_exists( 'throwCategoryExt' ) ){
  /**
  * Gets data extensions for categories and puts them in categories array
  * @return void
  */
  function throwCategoryExt( ){
    global $oCategory;
    $aExt =   dbThrowCategoryExt( );
    $iCount = count( $aExt );
    for( $i = 0; $i < $iCount; $i++ ){
      if( isset( $oCategory->aData[$aExt[$i][0]] ) ){
        $aExt[$i][1] = changeTxt( $aExt[$i][1], 'nlNds' );
        $aExt[$i][2] = changeTxt( $aExt[$i][2], 'nlNds' );
        $oCategory->aData[$aExt[$i][0]] =                       array_merge( $oCategory->aData[$aExt[$i][0]], $aExt[$i] ); 
        $oCategory->aData[$aExt[$i][0]]['sDescriptionShort'] =  $aExt[$i][1];
        $oCategory->aData[$aExt[$i][0]]['sDescriptionFull'] =   $aExt[$i][2];
      }
    } // end for
  } // end function throwCategoryExt
}

if( !function_exists( 'throwCategory' ) ){
  /**
  * Returns array for selected category
  * @return array
  * @param int $iCategory
  * @param bool $bExt
  * @param bool $bDesc
  */
  function throwCategory( $iCategory = null, $bExt = null, $bDesc = false ){
    global $oCategory;
    if( isset( $bExt ) && !isset( $oCategory->aData[$iCategory]['sDescriptionShort'] ) ){
      $aExt = throwCategoryExt( );
    }
    if( isset( $oCategory->aData[$iCategory] ) ){
      $aReturn = $oCategory->aData[$iCategory];
      if( ( !isset( $aReturn['sDescriptionFull'] ) || empty( $aReturn['sDescriptionFull'] ) ) && $bDesc == true ){
        if( isset( $aReturn['sDescriptionShort'] ) && !empty( $aReturn['sDescriptionShort'] ) )
          $aReturn['sDescriptionFull'] = $aReturn['sDescriptionShort'];
        else
          $aReturn['sDescriptionFull'] = '';
      }
      return $aReturn;
    }
    else
      return null;
  } // end function throwCategory
}

if( !function_exists( 'throwCategories' ) ){
  /**
  * Returns array with categories name as value and categories id as key
  * @return array
  */
  function throwCategories( ){
    return $GLOBALS['oCategory']->aOnlyNames;
  } // end function throwCategories
}

if( !function_exists( 'throwCategoryName' ) ){
  /**
  * Returns name of selected category
  * @return string
  * @param int $iCategory
  */
  function throwCategoryName( $iCategory = null ){
    global $oCategory;
    if( isset( $iCategory ) && isset( $oCategory->aOnlyNames[$iCategory] ) )
      return $oCategory->aOnlyNames[$iCategory];
    else
      return null;
  } // end function throwCategoryName
}

if( !function_exists( 'listCategories' ) ){
  /**
  * Returns list of categories
  * @return string
  * @param string $sFile
  * @param int    $iType
  * @param bool   $bParentOnly
  * @param array  $aSelected
  * @param string $sOption
  * @param bool   $bExt
  */
  function listCategories( $sFile, $iType = null, $bParentOnly = null, $aSelected = null, $sOption = null, $bExt = null ){
    global $tpl, $oCategory;

    if( !is_array( $aSelected ) )
      $aSelected = Array( );
    $oCategory->sFile =       $sFile;
    $oCategory->iType =       $iType;
    $oCategory->aSelected =   $aSelected;
    $oCategory->sOption =     $sOption;
    if( isset( $bExt ) && !isset( $oCategory->aFirstFoto ) )
      $oCategory->aFirstFoto =  throwFirstPhoto( 2 );

    if( is_numeric( $iType ) ){
      if( isset( $oCategory->aMainByTypes[$iType] ) )
        $aCategories = $oCategory->aMainByTypes[$iType];
      else
        $aCategories = null;
    }
    else
      $aCategories = $oCategory->aMain;

    if( isset( $aCategories ) && is_array( $aCategories ) ){
      $content =  null;
      $iCount =   count( $aCategories );
      for( $i = 0; $i < $iCount; $i++ ){
    
        $iCategory = $aCategories[$i];
        $content .= throwListContent( $iCategory );
        if( isset( $oCategory->aByParent[$iCategory] ) && ( !isset( $bParentOnly ) || checkListChildren( $iCategory ) ) )
          // jesli dana kategoria posiada dzieci i ( mozna wyswietlac podkategorie lub dana kategoria jest rodzicem wybranej )
          $content .= listCategoriesChildren( $iCategory );

      } // end for

      if( isset( $content ) )
        return $tpl->tbHtml( $sFile, 'LIST_HEAD' ) . $content . $tpl->tbHtml( $sFile, 'LIST_FOOTER' );
      else
        return $tpl->tbHtml( $sFile, 'NOT_FOUND' );
    }
    else
      return $tpl->tbHtml( $sFile, 'NOT_FOUND' );
  } // end function listCategories
}

if( !function_exists( 'checkListChildren' ) ){
  /**
  * Checks if current parent category should have listed children  
  * @return boolean
  * @param int $iCategory
  */
  function checkListChildren( $iCategory ){
    global $oCategory;
    $iCount = count( $oCategory->aSelected );
    for( $i = 0; $i < $iCount; $i++ ){
      if( isset( $oCategory->aParent[$oCategory->aSelected[$i]] ) && $oCategory->aParent[$oCategory->aSelected[$i]] == $iCategory )
        return true;
    } // end for
    return false;
  } // end function checkListChildren
}

if( !function_exists( 'listCategoriesChildren' ) ){
  /**
  * Returns subcategories list
  * @return string
  * @param int    $iParent
  * @param string $sFile
  * @param bool   $bExt
  */
  function listCategoriesChildren( $iParent, $sFile = null, $bExt = null ){
    global $oCategory;
    
    if( isset( $bExt ) && !isset( $oCategory->aFirstFoto ) )
      $oCategory->aFirstFoto =  throwFirstPhoto( 2 );

    if( isset( $sFile ) )
      $oCategory->sFile = $sFile;

    if( isset( $oCategory->aByParent[$iParent] ) )
      $aCategories = $oCategory->aByParent[$iParent];

    $content =  null;
    if( isset( $aCategories ) && is_array( $aCategories ) ){
      $iCount =   count( $aCategories );
      for( $i = 0; $i < $iCount; $i++ ){

        $iCategory = $aCategories[$i];
        $content .= throwListContent( $iCategory, 'SUB', $bExt );

      } // end for

    }

    if( isset( $sFile ) && isset( $content ) )
      $content = $GLOBALS['tpl']->tbHtml( $sFile, 'LIST_HEAD' ) . $content . $GLOBALS['tpl']->tbHtml( $sFile, 'LIST_FOOTER' );

    return $content;
  } // end function listCategoriesChildren
}

if( !function_exists( 'throwListContent' ) ){
  /**
  * Returns content while for categories list
  * @return string
  * @param int    $iCategory
  * @param string $sBlock
  * @param bool   $bExt
  */
  function throwListContent( $iCategory, $sBlock = null, $bExt = null ){
    global $tpl, $aList, $oCategory;

    if( isset( $bExt ) && !isset( $oCategory->aData[$iCategory]['sDescriptionShort'] ) )
      $aExt = throwCategoryExt( );

    $aList = $oCategory->aData[$iCategory];

    if( $oCategory->sOption == 'admin' ){
      if( $aList['iCategory'] != $GLOBALS['config']['contact_page'] )
        $aList['sDelLink'] = $tpl->tbHtml( $oCategory->sFile, 'DELETE_SITE' );
      else
        $aList['sDelLink'] = null;
    }
    
    if( isset( $oCategory->aSelected ) && in_array( $aList['iCategory'], $oCategory->aSelected ) )
      $aList['sSelected'] = $tpl->tbHtml( $oCategory->sFile, 'SELECTED' );
    else
      $aList['sSelected'] = null;

    if( isset( $oCategory->aFirstFoto[$aList['iCategory']] ) && is_file( DIR_CATEGORIES_FILES.$oCategory->aFirstFoto[$aList['iCategory']]['sPhoto'] ) ){
      global $oFF;
      $aName =                $oFF->throwNameExtOfFile( $oCategory->aFirstFoto[$aList['iCategory']]['sPhoto'] );
      $aList['file'] =        $oCategory->aFirstFoto[$aList['iCategory']]['sPhoto'];
      $aList['sPhotoSmall'] = DIR_CATEGORIES_FILES.$aName[0].'_m.'.$aName[1];
      $aList['sPhotoBig'] =   DIR_CATEGORIES_FILES.$oCategory->aFirstFoto[$aList['iCategory']]['sPhoto'];
      $aList['sPhoto'] =      $tpl->tbHtml( $oCategory->sFile, 'PHOTO' );
    }
    else
      $aList['sPhoto'] =      $tpl->tbHtml( $oCategory->sFile, 'NO_PHOTO' );

    if( empty( $aList['sDescriptionShort'] ) )
      $aList['sDescriptionShort'] = '&nbsp;';
    
    if( empty( $sBlock ) )
      $sBlock = 'LIST_LIST';
    elseif( isset( $aList['file'] ) )
      $sBlock .= '_PHOTO';

    return $tpl->tbHtml( $oCategory->sFile, $sBlock );
  } // end function throwListContent
}

if( !function_exists( 'throwTypesSelect' ) ){
  /**
  * Returns type select
  * @return string
  * @param int    $iSelected
  */
  function throwTypesSelect( $iSelected = null ){
    $sOption =  null;
    $aData =    $GLOBALS['oCategory']->aTypes;

    foreach( $aData as $iType => $sType ){
      if( isset( $iSelected ) && $iSelected == $iType )
        $sSelected = 'selected="selected"';
      else
        $sSelected = null;
    
      $sOption .= '<option value="'.$iType.'" '.$sSelected.'>'.$sType.'</option>';
    } // end for
    
    return $sOption;
  } // end function throwTypesSelect
}

if( !function_exists( 'throwCategoriesTree' ) ){
  /**
  * Returns subcategories array
  * @return string
  * @param int    $iParent
  */
  function throwCategoriesTree( $iParent ){
    if( isset( $GLOBALS['oCategory']->aByParent[$iParent] ) )
      $aReturn = $GLOBALS['oCategory']->aByParent[$iParent];
    $aReturn[] =  $iParent;
    return $aReturn;
  } // end function throwCategoriesTree
}

if( !function_exists( 'throwCategoriesParentId' ) ){
  /**
  * Returns parent id
  * @return int
  * @param int  $iCategory
  */  
  function throwCategoriesParentId( $iCategory ){
    return $GLOBALS['oCategory']->aParent[$iCategory];
  } // end function throwCategoriesParentId
}

if( !function_exists( 'throwTreeForProduct' ) ){
  /**
  * Returns categories tree for product
  * @return string
  * @param array  $aData
  * @param string $sFile
  */
  function throwTreeForProduct( $aData, $sFile ){
    global $oCategory, $tpl, $aListTree;

    $content = null;
    $iCount = count( $aData );
    for( $i = 0; $i < $iCount; $i++ ){
      $sReturn = null;
      $aListTree['iChild'] = $aData[$i];
      if( isset( $aListTree['iChild'] ) ){
        if( isset( $oCategory->aTreeForProduct[$aListTree['iChild']] ) ){
          $sReturn .= $oCategory->aTreeForProduct[$aListTree['iChild']]; 
        }
        else{
          $aListTree['iParent'] = throwCategoriesParentId( $aListTree['iChild'] );
          if( $aListTree['iParent'] != $aListTree['iChild'] && isset( $oCategory->aOnlyNames[$aListTree['iParent']] ) ){
            $aListTree['sParent'] = $oCategory->aOnlyNames[$aListTree['iParent']];
            $sReturn .= $tpl->tbHtml( $sFile, 'TREE_PARENT' ).$tpl->tbHtml( $sFile, 'PARENT_SEPARATOR' );
          }
          if( isset( $oCategory->aOnlyNames[$aListTree['iChild']] ) && ( !isset( $aListTree['iParent'] ) || isset( $oCategory->aOnlyNames[$aListTree['iParent']] ) ) ){
            $aListTree['sChild'] = $oCategory->aOnlyNames[$aListTree['iChild']];
            $sReturn .= $tpl->tbHtml( $sFile, 'TREE_CHILD' );
          }
          if( isset( $sReturn ) )
            $oCategory->aTreeForProduct[$aListTree['iChild']] = $sReturn; 
        }
        if( isset( $sReturn ) )
          $content .= ((isset($content))?$tpl->tbHtml( $sFile, 'TREE_SEPARATOR' ):'').$sReturn;
      }
    } // end for

    return $content;
  } // end function throwTreeForProduct
}

?>
