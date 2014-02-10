<?php
if( !function_exists( 'dbThrowOrderIdTemp' ) ){
  /**
  * Return temporary order id
  * @return int
  * @param int    $iClient
  * @param string $sOption
  */
  function dbThrowOrderIdTemp( $iClient, $sOption = null ){
    global $oFF;
    
    $iOrder = null;
    $aFile  = file( DB_ORDERS );
    $iCount = count( $aFile );

    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( $iClient == $aExp[1] && $aExp[2] == 0 )
        $iOrder = $aExp[0];
    }

    if( !isset( $iOrder ) && $sOption == 'add' ){
      $iOrder = throwLastId( DB_ORDERS, 0 ) + 1;
      $oFF->setRow( Array( $iOrder, $iClient, 0 ) );
      $oFF->addToFile( DB_ORDERS, 'rsort' ); 
    }

    return $iOrder;
  } // end function dbThrowOrderIdTemp
}

if( !function_exists( 'dbThrowOrder' ) ){
  /**
  * Return order basic data
  * @return array
  * @param int  $iOrder
  */
  function dbThrowOrder( $iOrder ){
    return $GLOBALS['oFF']->throwData( DB_ORDERS, $iOrder, 0 );
  } // end function dbThrowOrder
}

if( !function_exists( 'dbThrowOrderExt' ) ){
  /**
  * Return order extensions
  * @return array
  * @param int  $iOrder
  */
  function dbThrowOrderExt( $iOrder ){
    return $GLOBALS['oFF']->throwData( DB_ORDERS_EXT, $iOrder, 0 );
  } // end function dbThrowOrderExt
}

if( !function_exists( 'dbCheckOrderProducts' ) ){
  /**
  * Check exist any product in basket
  * @return bool
  * @param int  $iOrder
  */
  function dbCheckOrderProducts( $iOrder ){
    $aFile  = file( DB_ORDERS_PRODUCTS );
    $iCount = count( $aFile );
    for( $i = 1; $i < $iCount; $i++ ){
      $aExp =  explode( '$', $aFile[$i] );
      if( $aExp[1] == $iOrder ){
        return true;
      }
    }
    return null;
  } // end function dbCheckOrderProducts
}

if( !function_exists( 'dbCheckOrderProduct' ) ){
  /**
  * Check exist product in basket
  * @return bool
  * @param int  $iOrder
  $ @param int  $iProduct
  */
  function dbCheckOrderProduct( $iOrder, $iProduct ){
    $aFile =  file( DB_ORDERS_PRODUCTS );
    $iCount = count( $aFile );
    for( $i = 1; $i < $iCount; $i++ ){
      $aFile[$i]  = rtrim( $aFile[$i] );
      $aExp       = explode( '$', $aFile[$i] );
      if( $aExp[1] == $iOrder && $aExp[2] == $iProduct ){
        return $aExp;
      }
    }
    return null;
  } // end function dbCheckOrderProduct
}

if( !function_exists( 'dbAddOrderProduct' ) ){
  /**
  * Add product to basket
  * @return void
  * @param array  $aProduct
  * @param int    $iQuantity
  * @param int    $iOrder
  */
  function dbAddOrderProduct( $aProduct, $iQuantity, $iOrder ){
    global $oFF;
    $iElement = throwLastId( DB_ORDERS_PRODUCTS, 0 ) + 1;
    $oFF->setRow( Array( $iElement, $iOrder, $aProduct['iProduct'], $iQuantity, $aProduct['fPrice'], $aProduct['sName'] ) );
    $oFF->addToFile( DB_ORDERS_PRODUCTS, 'end' );
  } // end function dbAddOrderProduct
}

if( !function_exists( 'dbSaveOrderProduct' ) ){
  /**
  * Save product to file
  * @return void
  * @param array  $aData
  */
  function dbSaveOrderProduct( $aData ){
    global $oFF;
    $oFF->setRow( Array( $aData[0], $aData[1], $aData[2], $aData[3], $aData[4], $aData[5] ) );
    $oFF->changeInFile( DB_ORDERS_PRODUCTS, $aData[0], 0 );
  } // end function dbSaveOrderProduct
}

if( !function_exists( 'dbSaveOrderProducts' ) ){
  /**
  * Save products quantity to file
  * @return void
  * @param array  $aElements
  */
  function dbSaveOrderProducts( $aElements ){
    $aFile  = file( DB_ORDERS_PRODUCTS );
    $rFile  = fopen( DB_ORDERS_PRODUCTS, 'w' );
    $iCount = count( $aFile );

    for( $i = 0; $i < $iCount; $i++ ){
      if( $i > 0 ){
        $aFile[$i]  = rtrim( $aFile[$i] );
        $aExp       = explode( '$', $aFile[$i] );
        if( isset( $aElements[$aExp[0]] ) && $aElements[$aExp[0]] >= 1 )
          $aFile[$i] = $aExp[0].'$'.$aExp[1].'$'.$aExp[2].'$'.sprintf( '%01.0f', $aElements[$aExp[0]] ).'$'.$aExp[4].'$'.$aExp[5].'$'."\n";
        else
          $aFile[$i] .= "\n";
      }

      fwrite( $rFile, $aFile[$i] );
    } // end for

    fclose( $rFile );
  } // end function dbSaveOrderProducts
}

if( !function_exists( 'dbDelOrderElement' ) ){
  /**
  * Delete products in basket
  * @return void
  * @param int  $iOrder
  * @param int  $iElement
  */
  function dbDelOrderElement( $iOrder, $iElement ){
    $aFile =  file( DB_ORDERS_PRODUCTS );
    $rFile =  fopen( DB_ORDERS_PRODUCTS, 'w' );
    $iCount = count( $aFile );

    for( $i = 0; $i < $iCount; $i++ ){
      if( $i > 0 ){
        $aFile[$i] = ereg_replace( "\r", "", $aFile[$i] );
        $aExp =      explode( '$', $aFile[$i] );
        if( isset( $iElement ) ){
          if( $aExp[0] == $iElement && $aExp[1] == $iOrder )
            $aFile[$i] = '';
        }
        else{
          if( $aExp[1] == $iOrder )
            $aFile[$i] = '';
        }
      }

      fwrite( $rFile, $aFile[$i] );
    } // end for
    fclose( $rFile );
  } // end function dbDelOrderElement
}

if( !function_exists( 'dbDelOrderMass' ) ){
  /**
  * Delete older then 24h not finished orders
  * @return void
  */
  function dbDelOrderMass( ){

    $aFile  = file( DB_ORDERS );
    $iCount = count( $aFile );
    $rFile  = fopen( DB_ORDERS, 'w' );
    $iTime  = time( );

    for( $i = 0; $i < $iCount; $i++ ){
      if( $i > 0 ){
        $aExp = explode( '$', $aFile[$i] );
        $iDiff = $iTime - substr( $aExp[1], 0, 10 );
        if( $aExp[2] == 0 && $iDiff >= 86400 ){
          $aFile[$i]      = null;
          $aId[$aExp[0]]  = true;
        }
      }
      fwrite( $rFile, $aFile[$i] );
    } // end for
    
    fclose( $rFile );
    
    if( isset( $aId ) && is_array( $aId ) ){
      $aFile  = file( DB_ORDERS_PRODUCTS );
      $iCount = count( $aFile );
      $rFile  = fopen( DB_ORDERS_PRODUCTS, 'w' );

      for( $i = 0; $i < $iCount; $i++ ){
        if( $i > 0 ){
          $aExp = explode( '$', $aFile[$i] );
          if( isset( $aId[$aExp[1]] ) ){
            $aFile[$i]  = null;
          }
        }
        fwrite( $rFile, $aFile[$i] );
      } // end for
      
      fclose( $rFile );
    }
  } // end function dbDelOrderMass
}

if( !function_exists( 'dbDelOrder' ) ){
  /**
  * Delete order
  * @return void
  * @param int  $iOrder
  */
  function dbDelOrder( $iOrder ){
    global $oFF;
    $oFF->deleteInFile( DB_ORDERS, $iOrder, 0 );
    $oFF->deleteInFile( DB_ORDERS_EXT, $iOrder, 0 );
  } // end function dbDelOrder
}

if( !function_exists( 'dbListBasket' ) ){
  /**
  * Return basket
  * @return array
  * @param int  $iOrder
  */
  function dbListBasket( $iOrder ){
    return $GLOBALS['oFF']->throwFileArrayClause( DB_ORDERS_PRODUCTS, null, 1, $iOrder );
  } // end function dbListBasket
}

if( !function_exists( 'dbListOrders' ) ){
  /**
  * Return order to array
  * @return array
  */
  function dbListOrders( ){
    return $GLOBALS['oFF']->throwFileArrayPages( DB_ORDERS_EXT, null, $GLOBALS['iPage'], ADMIN_LIST );
  } // end function dbListOrders
}

if( !function_exists( 'dbThrowOrdersStatus' ) ){
  /**
  * Return array
  * index - id order
  * value - order status
  * @return array
  */
  function dbThrowOrdersStatus( ){
    return $GLOBALS['oFF']->throwFileArraySmall( DB_ORDERS, null, 0, 2 );
  } // end function dbThrowOrdersStatus
}

if( !function_exists( 'dbListOrdersStatus' ) ){
  /**
  * Return orders array of selected status
  * @return array
  * @param int  $iStatus
  */
  function dbListOrdersStatus( $iStatus ){

    $aFile      = file( DB_ORDERS_EXT );
    $iCount     = count( $aFile );
    $iFindPage  = 0;
    $iFindAll   = 0;
    $aStatus    = dbThrowOrdersStatus( );

    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( isset( $aStatus[$aExp[0]] ) && $aStatus[$aExp[0]] == $iStatus ){
        $iFindPage++;
        $iFindAll++;
        
        if( $iFindPage == 1 )
          $aPageStart[] = $i;

        if( isset( $aPageStart[$GLOBALS['iPage'] - 1] ) && !isset( $aPageEnd[$GLOBALS['iPage'] - 1] ) ){
          $aData[] = $aExp;
        }

        if( $iFindPage == ADMIN_LIST ){
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
  } // end function dbListOrdersStatus
}

if( !function_exists( 'dbListOrdersSearch' ) ){
  /**
  * Search orders
  * @return array
  * @param string $sWord
  */
  function dbListOrdersSearch( $sWord ){

    $aFile      = file( DB_ORDERS_EXT );
    $iCount     = count( $aFile );
    $iFindPage  = 0;
    $iFindAll   = 0;
    $sWord      = preg_quote( $sWord );

    for( $i = 1; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i] );
      if( eregi( $sWord, $aFile[$i] ) ){
        $iFindPage++;
        $iFindAll++;
        
        if( $iFindPage == 1 )
          $aPageStart[] = $i;

        if( isset( $aPageStart[$GLOBALS['iPage'] - 1] ) && !isset( $aPageEnd[$GLOBALS['iPage'] - 1] ) ){
          $aData[] = $aExp;
        }

        if( $iFindPage == ADMIN_LIST ){
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
  } // end function dbListOrdersSearch
}

if( !function_exists( 'dbSaveOrder' ) ){
  /**
  * Save order
  * @return void
  * @param array  $aForm
  */
  function dbSaveOrder( $aForm ){
    global $oFF;
    $oFF->setRow( Array( $aForm['iOrder'], $_SESSION['iCustomer'], 1 ) );
    $oFF->changeInFile( DB_ORDERS , $aForm['iOrder'], 0 );
  } // end function dbSaveOrder
}

if( !function_exists( 'dbAddOrderExtension' ) ){
  /**
  * Add order extensions to file
  * @return void
  * @param array  $aData
  * @param bool   $bErase
  */
  function dbAddOrderExtensions( $aData, $bErase = true ){
    global $oFF;
    if( isset( $bErase ) )
      $oFF->deleteInFile( DB_ORDERS_EXT, $aData[0], 0 );

    $oFF->setRow( $aData );
    $oFF->addToFile( DB_ORDERS_EXT, 'rsort' );  
  } // end function dbAddOrderExtension
}

if( !function_exists( 'dbSaveOrderStatus' ) ){
  /**
  * Save order status to file
  * @return void
  * @param int    $iOrder
  * @param int    $iStatus
  */
  function dbSaveOrderStatus( $iOrder, $iStatus ){
    $aFile  = file( DB_ORDERS );
    $rFile  = fopen( DB_ORDERS, 'w' );
    $iCount = count( $aFile );

    for( $i = 0; $i < $iCount; $i++ ){
      if( $i > 0 ){
        $aFile[$i]  = ereg_replace( "\r", '', $aFile[$i] );
        $aExp       = explode( '$', $aFile[$i] );
        if( $aExp[0] == $iOrder )
          $aFile[$i] = $aExp[0].'$'.$aExp[1].'$'.$iStatus."$\n";
      }

      fwrite( $rFile, $aFile[$i] );
    } // end for
    fclose( $rFile );
  } // end function dbSaveOrderStatus
}
?>