<?php
if( !function_exists( 'listProducts' ) ){
  /**
  * List products and return content
  * @return string
  * @param string $sFile
  * @param string $sOption
  * @param mixed  $mValue
  * @param int    $iList
  */
  function listProducts( $sFile = 'products_list.tpl', $sOption = 'list', $mValue = null, $iList = null ){

    if( !isset( $GLOBALS['iPage'] ) || !is_numeric( $GLOBALS['iPage'] ) || $GLOBALS['iPage'] < 1 ) 
      $GLOBALS['iPage'] = 1;

    $iStatus = throwStatus( );

    if( !isset( $iList ) ){
      if( $iStatus == 1 )
        $iList = PRODUCTS_LIST;
      else
        $iList = ADMIN_LIST;
    }

    if( $sOption == 'category' ){
      $aData        = dbListProductsCategory( $iStatus, $mValue, $iList );
      $sPage        = $GLOBALS['p'].'&amp;iCategory='.$GLOBALS['iCategory'];
    }
    elseif( $sOption == 'search' ){
      $aData = dbListProductsSearch( $iStatus, trim( $mValue ), $iList );
      $sPage = $GLOBALS['p'].'&amp;sWord='.$GLOBALS['sWord'];
    }
    else{
      $aData = dbListProducts( $iStatus, $iList );
      $sPage = $GLOBALS['p'];
    }

    if( isset( $aData ) && is_array( $aData ) )
      $content = throwProductsData( $sFile, $aData, $sPage, $iList );
    else
      $content = $GLOBALS['tpl']->tbHtml( $sFile, 'NOT_FOUND' );

    return $content;
  } // end function listProducts
}

if( !function_exists( 'throwProductsData' ) ){
  /**
  * Create products list from array
  * @return string
  * @param string $sFile
  * @param array  $aData
  * @param string $sPage
  * @param int    $iList
  */
  function throwProductsData( $sFile, $aData, $sPage, $iList ){
    global $tpl, $aList, $oFF;
    
    $aPhoto       = throwFirstPhoto( 1 );
    $iCount       = count( $aData );
    $content      = null;
    $aCategories  = throwProductsCategories( );

    for( $i = 0; $i < $iCount; $i++ ){  
      list( $aList['iProduct'], $aList['sName'], $aList['fPrice'], $aList['sDescriptionShort'], $aList['iStatus'], $aList['iPosition'] ) = $aData[$i];

      if( isset( $aPhoto[$aList['iProduct']] ) && is_file( DIR_PRODUCTS_FILES.$aPhoto[$aList['iProduct']]['sPhoto'] ) ){
        $aName = $oFF->throwNameExtOfFile( $aPhoto[$aList['iProduct']]['sPhoto'] );
        $aList['sFile']       = $aPhoto[$aList['iProduct']]['sPhoto'];
        $aList['sPhotoSmall'] = DIR_PRODUCTS_FILES.$aName[0].'_m.'.$aName[1];
        $aList['sPhotoBig']   = DIR_PRODUCTS_FILES.$aPhoto[$aList['iProduct']]['sPhoto'];
        $aList['sPhoto']      = $tpl->tbHtml( $sFile, 'PHOTO' );    
      }
      else{
        $aList['sPhoto'] = '&nbsp;';
      }

      if( $i % 2 )
        $aList['iStyle'] = 0;
      else
        $aList['iStyle'] = 1;

      if( empty( $aList['sDescriptionShort'] ) )
        $aList['sDescriptionShort'] = '&nbsp;';
      else
        $aList['sDescriptionShort'] = ereg_replace( '\|n\|', '', $aList['sDescriptionShort'] );

      $aList['sCategories'] = throwTreeForProduct( $aCategories[$aList['iProduct']], $sFile );

      $content .= $tpl->tbHtml( $sFile, 'LIST_LIST' );

    } // end for

    $aList['sPages'] = countPages( $aData[0]['iFindAll'], $iList, $GLOBALS['iPage'], $sPage );
    return $tpl->tbHtml( $sFile, 'LIST_HEAD' ).$content.$tpl->tbHtml( $sFile, 'LIST_FOOTER' );
  } // end function throwProductsData
}

if( !function_exists( 'throwProduct' ) ){
  /**
  * Return product data
  * @return array
  * @param int  $iProduct
  */
  function throwProduct( $iProduct ){
    global $oFF;
    $iStatus      = throwStatus( );
    $aData        = dbThrowProduct( $iProduct, $iStatus );
    $aCategories  = throwProductCategories( $iProduct );
    if( isset( $aData ) && ( $iStatus === 0 || ( isset( $aCategories ) && is_array( $aCategories ) ) ) ){
      $aList = dbThrowProductExt( $iProduct );

      $aList['sDescriptionFull'] = $aList[1];
      list( $aList['iProduct'], $aList['sName'], $aList['fPrice'], $aList['sDescriptionShort'], $aList['iStatus'], $aList['iPosition'] ) = $aData;

      $aList['aCategories'] = $aCategories;

      return $aList;
    }
    else
      return null;
  } // end function throwProduct
}

if( !function_exists( 'throwProducts' ) ){
  /**
  * Returns products in array
  * index - iProduct
  * value - sName
  * @return array
  */
  function throwProducts( ){
    return dbThrowProducts( );
  } // end function throwProducts
}

if( !function_exists( 'throwProductCategories' ) ){
  /**
  * Returns categories defined to product
  * @return array
  * @param int  $iProduct
  */
  function throwProductCategories( $iProduct ){
    $aData = dbThrowProductCategories( );
    if( isset( $aData[$iProduct] ) )
      return $aData[$iProduct];
  } // end function throwProductCategories
}

if( !function_exists( 'throwProductsCategories' ) ){
  /**
  * Returns categories defined to products
  * @return array
  */
  function throwProductsCategories( ){
    return dbThrowProductCategories( );
  } // end function throwProductsCategories
}
?>