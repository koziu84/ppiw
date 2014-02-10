<?php
if( !function_exists( 'saveOrderStatus' ) ){
  /**
  * Save order status
  * @return void
  * @param int    $iOrder
  * @param int    $iStatus
  */
  function saveOrderStatus( $iOrder, $iStatus ){
    dbSaveOrderStatus( $iOrder, $iStatus );
  } // end function saveOrderStatus
}

if( !function_exists( 'listOrders' ) ){
  /**
  * Wyswietlanie spisu zamowien
  * @return string
  * @param string $sFile
  * @param string $sOption
  */
  function listOrders( $sFile = 'orders_list.tpl', $sOption = 'list' ){
    global $tpl, $aList;
    
    if( !isset( $GLOBALS['iPage'] ) || !is_numeric( $GLOBALS['iPage'] ) || $GLOBALS['iPage'] < 1 ) 
      $GLOBALS['iPage'] = 1;

    if( $sOption == 'status' ){
      $aData = dbListOrdersStatus( $_GET['iStatus'] );
      $sPage = $GLOBALS['p'].'&amp;iStatus='.$GLOBALS['iStatus'];
    }
    elseif( $sOption == 'search' ){
      $aData = dbListOrdersSearch( trim( $_GET['sWord'] ) );
      $sPage = $GLOBALS['p'].'&amp;sWord='.$GLOBALS['sWord'];
    }
    else{
      $aData = dbListOrders( );
      $sPage = $GLOBALS['p'];  
    }

    $content  = null;

    if( isset( $aData ) ){
      $iCount   = count( $aData );
      $aStatus  = dbThrowOrdersStatus( );

      for( $i = 0; $i < $iCount; $i++ ){  
        list( $aList['iOrder'], $aList['iTime'], $aList['iCourier'], $aList['sCourier'], $aList['fCourierPrice'], $aList['sFirstName'], $aList['sLastName'], $aList['sCompanyName'], $aList['sStreet'], $aList['sZipCode'], $aList['sCity'], $aList['sTelephone'], $aList['sEmail'], $aList['sIp'], $aList['sComment'] ) = $aData[$i];
        
        if( $i % 2 )
          $aList['iStyle'] = 0;
        else
          $aList['iStyle'] = 1;

        $aList =            changeMassTxt( $aList, '' );
        $aList['sDate'] =   date( 'Y-m-d H:i:s', $aList['iTime'] );
        $aList['sStatus']=  throwOrderStatus( $aStatus[$aList['iOrder']] );

        if( $aStatus[$aList['iOrder']] == 1 )
          $aList['sStatus'] = '<b>'.$aList['sStatus'].'</b>';

        $content .= $tpl->tbHtml( $sFile, 'LIST_LIST' );
      } // end for

      $aList['sPages'] = countPages( $aData[0]['iFindAll'], ADMIN_LIST, $GLOBALS['iPage'], $sPage );
      
      return $tpl->tbHtml( $sFile, 'LIST_HEAD' ).$content.$tpl->tbHtml( $sFile, 'LIST_FOOTER' );
    }
    else
      return $tpl->tbHtml( $sFile, 'NOT_FOUND' );
  } // end function listOrders
}

if( !function_exists( 'delOrderMass' ) ){
  /**
  * Delete older then 24 hours not finished orders 
  * @return void
  */
  function delOrderMass( ){
    dbDelOrderMass( );
  } // end function delOrderMass
}

if( !function_exists( 'throwOrderStatus' ) ){
  /**
  * Change orders status
  * @return string
  * @param int    $iStatus
  * @param bool   $bAll
  */
  function throwOrderStatus( $iStatus = 1, $bAll = null ){
    global $lang;
    $aStatus[1] = $lang['Pending'];
    $aStatus[2] = $lang['Processing'];
    $aStatus[3] = $lang['Finished'];
    $aStatus[4] = $lang['Canceled'];
    if( isset( $bAll ) )
      return $aStatus;
    else
      return $aStatus[$iStatus];
  } // end function throwOrderStatus
}

if( !function_exists( 'throwOrderStatusSelect' ) ){
  /**
  * Return status select
  * @return string
  * @param int  $iStatus
  */
  function throwOrderStatusSelect( $iStatus = null ){
    return throwSelectFromArray( throwOrderStatus( null, true ), $iStatus );
  } // end function throwOrderStatusSelect
}
?>