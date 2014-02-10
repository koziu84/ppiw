<?php
if( !function_exists( 'sendEmail' ) ){
  /**
  * Send e-mail
  * @return string
  * @param array  $aForm
  * @param string $sFile
  * @param string $sTargetMail
  */
  function sendEmail( $aForm, $sFile = 'contact_send.tpl', $sTargetEmail = null ){
    global $tpl;
    extract( $aForm );
    
    if( checkLength( $sTopic, 2 ) === true && checkLength( $sMailContent, 2 ) === true && checkEmail( $sSender ) == true ){
      $sMailContent = changePolishToIso( $sMailContent );
      $sTopic =       changePolishToIso( $sTopic );

      if( !isset( $sTargetEmail ) )
        $sTargetEmail = EMAIL;

      if( @mail( $sTargetEmail, $sTopic, $sMailContent, 'From: '.$sSender ) ){
        $content = $tpl->tbHtml( $sFile, 'SEND_GOOD' );
      }
      else
        $content = $tpl->tbHtml( $sFile, 'SEND_ALERT' );
    }
    else
      $content = $tpl->tbHtml( $sFile, 'WRONG_WORD' );
    return $content;
  } // end function sendEmail
}

if( !function_exists( 'tPrice' ) ){
  /**
  * Return price format
  * @return float
  * @param float  $fPrice
  */
  function tPrice( $fPrice ){
    return sprintf( '%01.2f', $fPrice );
  } // end function tPrice
}

if( !function_exists( 'throwLastId' ) ){
  /**
  * Return last inserted id
  * @return int
  * @param  string  $sDb
  * @param  int     $iPosition
  */
  function throwLastId( $sDb = null, $iPosition = 0 ){
    if( !isset( $sDb ) )
      $sDb = DB_PRODUCTS;
    return dbThrowLastId( $sDb, $iPosition );
  } // end function throwLastId
}

if( !function_exists( 'dbThrowLastId' ) ){
  /**
  * Return last inserted id from db file
  * @return int
  * @param  string  $sDb
  * @param  int     $iPosition
  */
  function dbThrowLastId( $sDb, $iPosition ){
    return $GLOBALS['oFF']->throwLastId( $sDb, $iPosition );
  } // end function dbThrowLastId
}

if( !function_exists( 'checkEmail' ) ){
  /**
  * Check that e-mail is correct
  * @return bool
  * @param  string  $sEmail
  */
  function checkEmail( $sEmail ){
    return eregi( "^[a-z0-9_.-]+([_\\.-][a-z0-9]+)*@([a-z0-9_\.-]+([\.][a-z]{2,4}))+$", $sEmail );
  } // end function checkEmail
}

if( !function_exists( 'throwStatus' ) ){
  /**
  * Return status limit
  * @return int
  */
  function throwStatus( ){
    if( isset( $_SESSION['bUserQC'] ) && $_SESSION['bUserQC'] === true )
      return 0;
    else
      return 1;
  } // end function throwStatus
}

if( !function_exists( 'throwIconsFromExt' ) ){
  /**
  * Returns extensions icons
  * @return array
  */
  function throwIconsFromExt( ){
    
    $aExt['rar'] = 'zip';
    $aExt['zip'] = 'zip';
    $aExt['bz2'] = 'zip';
    $aExt['gz']  = 'zip';
  
    $aExt['fla'] = 'fla';
  
    $aExt['mp3']  = 'media';
    $aExt['mpeg'] = 'media';
    $aExt['mpe']  = 'media';
    $aExt['mov']  = 'media';
    $aExt['mid']  = 'media';
    $aExt['midi'] = 'media';
    $aExt['asf']  = 'media';
    $aExt['avi']  = 'media';
    $aExt['wav']  = 'media';
    $aExt['wma']  = 'media';
  
    $aExt['msg']  = 'msg';
    $aExt['eml']  = 'msg';
  
    $aExt['pdf']  = 'pdf';
  
    $aExt['jpg']  = 'pic';
    $aExt['jpeg'] = 'pic';
    $aExt['jpe']  = 'pic';
    $aExt['gif']  = 'pic';
    $aExt['bmp']  = 'pic';
    $aExt['tif']  = 'pic';
    $aExt['tiff'] = 'pic';
    $aExt['wmf']  = 'pic';
  
    $aExt['png']  = 'png';
  
    $aExt['chm']  = 'chm';
    $aExt['hlp']  = 'chm';
  
    $aExt['psd']  = 'psd';
  
    $aExt['swf']  = 'swf';
  
    $aExt['pps']  = 'pps';
    $aExt['ppt']  = 'pps';
  
    $aExt['sys']  = 'sys';
    $aExt['dll']  = 'sys';
  
    $aExt['txt']  = 'txt';
    $aExt['doc']  = 'txt';
    $aExt['rtf']  = 'txt';
    $aExt['swx']  = 'txt';
    $aExt['odt']  = 'txt';
  
    $aExt['vcf']  = 'vcf';
  
    $aExt['xls']  = 'xls';
    $aExt['sxc']  = 'xls';
    $aExt['ods']  = 'xls';
  
    $aExt['xml']  = 'xml';
  
    $aExt['tpl']  = 'web';
    $aExt['html'] = 'web';
    $aExt['htm']  = 'web';
    $aExt['com']  = 'exe';
    $aExt['bat']  = 'exe';
    $aExt['exe']  = 'exe';
  
    return $aExt;
  } // end function throwIconsFromExt
}
?>