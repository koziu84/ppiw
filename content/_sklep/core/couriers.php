<?php
if( !function_exists( 'listCouriers' ) ){
  /**
  * List couriers
  * @return string
  * @param string $sFile
  */
  function listCouriers( $sFile = 'couriers_list.tpl' ){
    global $tpl, $aList;

    $aData  = dbListCouriers( );

    if( isset( $aData ) && is_array( $aData ) ){
      $iCount   = count( $aData );
      $content  = null;

      for( $i = 0; $i < $iCount; $i++ ){
        list( $aList['iCourier'], $aList['sName'], $aList['fPrice'] ) = $aData[$i];
        
        if( $i % 2 )
          $aList['iStyle'] = 0;
        else
          $aList['iStyle'] = 1;

        $content .= $tpl->tbHtml( $sFile, 'LIST_LIST' );
      } // end for

      return $tpl->tbHtml( $sFile, 'LIST_HEAD' ).$content.$tpl->tbHtml( $sFile, 'LIST_FOOTER' );
    }
    else
      return $tpl->tbHtml( $sFile, 'NOT_FOUND' );
  } // end function listCouriers
}

if( !function_exists( 'throwCourier' ) ){
  /**
  * Return courier data
  * @return array
  * @param int  $iCourier
  */
  function throwCourier( $iCourier ){
    $aData =  dbThrowCourier( $iCourier );
    if( isset( $aData ) ){
      list( $aList['iCourier'], $aList['sName'], $aList['fPrice'] ) = $aData;
      return $aList;
    }
    else
      return null;
  } // end function throwCourier
}
?>