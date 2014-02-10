<?php
if( !function_exists( 'dbListProducts' ) ){
  /**
  * Return array of products list
  * @return array
  * @param int  $iStatus
  * @param int  $iList
  */
  function dbListProducts( $iStatus, $iList ){

    $aFile        = file( DB_PRODUCTS );
    $iCount       = count( $aFile );
    $iFindPage    = 0;
    $iFindAll     = 0;
    $aCategories  = dbThrowProductCategories( );

    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( $iStatus === 0 || ( isset( $aCategories[$aExp[0]] ) && $aExp[4] >= $iStatus ) ){
        $iFindPage++;
        $iFindAll++;
        
        if( $iFindPage == 1 )
          $aPageStart[] = $i;

        if( isset( $aPageStart[$GLOBALS['iPage'] - 1] ) && !isset( $aPageEnd[$GLOBALS['iPage'] - 1] ) ){
          $aData[] = $aExp;
        }

        if( $iFindPage == $iList ){
          $aPageEnd[] = $i;
          $iFindPage =  0;
        }
      }
    } // end for

    if( isset( $aData ) ){
      $aData[0]['iFindAll'] = $iFindAll;
      return $aData;
    }
    else
      return null;
  } // end function dbListProducts
}

if( !function_exists( 'dbListProductsSearch' ) ){
  /**
  * Return array of products list, search by word
  * @return array
  * @param int    $iStatus
  * @param string $sWord
  * @param int    $iList
  */
  function dbListProductsSearch( $iStatus, $sWord, $iList ){

    $aFile        = file( DB_PRODUCTS );
    $iCount       = count( $aFile );
    $iFindPage    = 0;
    $iFindAll     = 0;
    $aCategories  = dbThrowProductCategories( );
    $sWord        = preg_quote( $sWord );

    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( isset( $aCategories[$aExp[0]] ) && $aExp[4] >= $iStatus && eregi( $sWord, $aFile[$i] ) ){
        $iFindPage++;
        $iFindAll++;
        
        if( $iFindPage == 1 )
          $aPageStart[] = $i;

        if( isset( $aPageStart[$GLOBALS['iPage'] - 1] ) && !isset( $aPageEnd[$GLOBALS['iPage'] - 1] ) ){
          $aData[] = $aExp;
        }

        if( $iFindPage == $iList ){
          $aPageEnd[] = $i;
          $iFindPage =  0;
        }
      }
    } // end for

    if( isset( $aData ) ){
      $aData[0]['iFindAll'] = $iFindAll;
      return $aData;
    }
    else
      return null;
  } // end function dbListProductsSearch
}

if( !function_exists( 'dbListProductsCategory' ) ){
  /**
  * Return array of products list, search by category
  * @return array
  * @param int  $iStatus
  * @param int  $iCategory
  * @param int  $iList
  */
  function dbListProductsCategory( $iStatus, $iCategory, $iList ){

    $aFile        = file( DB_PRODUCTS );
    $iCount       = count( $aFile );
    $iFindPage    = 0;
    $iFindAll     = 0;
    $aCategories  = dbThrowProductCategories( true );

    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );

      if( isset( $aCategories[$aExp[0]] ) && in_array( $iCategory, $aCategories[$aExp[0]] ) && $aExp[4] >= $iStatus ){
        $iFindPage++;
        $iFindAll++;
        
        if( $iFindPage == 1 )
          $aPageStart[] = $i;

        if( isset( $aPageStart[$GLOBALS['iPage'] - 1] ) && !isset( $aPageEnd[$GLOBALS['iPage'] - 1] ) ){
          $aData[] = $aExp;
        }

        if( $iFindPage == $iList ){
          $aPageEnd[] = $i;
          $iFindPage =  0;
        }
      }
    } // end for

    if( isset( $aData ) ){
      $aData[0]['iFindAll'] = $iFindAll;
      return $aData;
    }
    else
      return null;
  } // end function dbListProductsCategory
}

if( !function_exists( 'dbThrowProduct' ) ){
  /**
  * Throw product data
  * @return array
  * @param int  $iProduct
  * @param int  $iStatus
  */
  function dbThrowProduct( $iProduct, $iStatus ){
    $aFile  = file( DB_PRODUCTS );
    $iCount = count( $aFile );

    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( $aExp[0] == $iProduct && $aExp[4] >= $iStatus ){
        return $aExp;
      }
    } // end for
    return null;
  } // end function dbThrowProduct
}

if( !function_exists( 'dbThrowProductExt' ) ){
  /**
  * Throw products data extension
  * @return array
  * @param int  $iProduct
  */
  function dbThrowProductExt( $iProduct ){
    return $GLOBALS['oFF']->throwData( DB_PRODUCTS_EXT, $iProduct );
  } // end function dbThrowProductExt
}

if( !function_exists( 'dbThrowProductCategories' ) ){
  /**
  * Returns categories defined to product
  * @return array
  * @param  $bParent
  */
  function dbThrowProductCategories( $bParent = null ){
    global $oCategory;
    $aCategories  = throwCategories( );
    $aFile        = file( DB_PRODUCTS_CATEGORIES );
    $iCount       = count( $aFile );
    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( isset( $aCategories[$aExp[0]] ) && isset( $oCategory->aData[$oCategory->aParent[$aExp[0]]] ) ){
        $aData[$aExp[1]][]  = $aExp[0];
        if( isset( $bParent ) )
          $aData[$aExp[1]][]  = $oCategory->aParent[$aExp[0]];
      }
    } // end for
    if( isset( $aData ) )
      return $aData;
  } // end function dbThrowProductCategories
}

if( !function_exists( 'dbThrowProducts' ) ){
  /**
  * Return products in array
  * index - iProduct
  * value - sName
  * @return array
  */
  function dbThrowProducts( ){
    return $GLOBALS['oFF']->throwFileArraySmall( DB_PRODUCTS, null, 0, 1 );
  } // end function dbThrowProducts
}

if( !function_exists( 'dbAddCategoriesProduct' ) ){
  /**
  * Save categories to product
  * @return void
  * @param int  $iCategory
  * @param int  $iProduct
  * @param bool $bErase
  */
  function dbAddCategoriesProduct( $iCategory, $iProduct, $bErase = true ){
    global $oFF;
    if( isset( $bErase ) )
      $oFF->deleteInFile( DB_PRODUCTS_CATEGORIES, $iProduct, 1 );
    $oFF->setRow( Array( $iCategory, $iProduct )  );
    $oFF->addToFile( DB_PRODUCTS_CATEGORIES );
  } // end function dbAddCategoriesProduct
}

if( !function_exists( 'dbSaveProduct' ) ){
  /**
  * Add product to file
  * @return void
  * @param array  $aForm
  * @param bool   $bExist
  */
  function dbSaveProduct( $aForm, $bExist = null ){
    global $oFF;
    extract( $aForm );
    $oFF->setRow( Array( $iProduct, $sName, $fPrice, $sDescriptionShort, $iStatus, $iPosition ) );
    $oFF->setData( Array( 5, 1, 0, 2, 3, 4 ) );
    if( isset( $bExist ) )
      $oFF->changeInFile( DB_PRODUCTS, $iProduct, 0, 'sort' );
    else
      $oFF->addToFile( DB_PRODUCTS, 'sort' );
  } // end function dbSaveProduct
}

if( !function_exists( 'dbAddProductExtension' ) ){
  /**
  * Add product extensions to file
  * @return void
  * @param array  $aData
  * @param bool   $bErase
  */
  function dbAddProductExtensions( $aData, $bErase = true ){
    global $oFF;
    if( isset( $bErase ) )
      $oFF->deleteInFile( DB_PRODUCTS_EXT, $aData[0], 0 );

    $oFF->setRow( $aData );
    $oFF->addToFile( DB_PRODUCTS_EXT );  
  } // end function dbAddProductExtensions
}

if( !function_exists( 'dbDelProduct' ) ){
  /**
  * Usuwanie danych produktu
  * @return void
  * @param int  $iProduct
  */
  function dbDelProduct( $iProduct ){
    global $oFF;
    $oFF->deleteInFile( DB_PRODUCTS_EXT, $iProduct, 0 );
    $oFF->deleteInFile( DB_PRODUCTS_CATEGORIES, $iProduct, 1 );
    $oFF->deleteInFile( DB_PRODUCTS, $iProduct, 0 );
  } // end function dbDelProduct
}
?>