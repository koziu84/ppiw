<?php
if( !function_exists( 'throwPagesSelect' ) ){
  /**
  * Returns pages as select
  * @return string
  * @param string $sStartPage
  */
  function throwPagesSelect( $sStartPage = null ){
    $aStartPage[] = 'productsList';

    $iCount =   count( $aStartPage );
    $sOption =  null;

    for( $i = 0; $i < $iCount; $i++ ){
      if( isset( $sStartPage ) && $sStartPage == $aStartPage[$i] )
        $sSelected = 'selected="selected"';
      else
        $sSelected = null;
      $sOption .= '<option value="'.$aStartPage[$i].'" '.$sSelected.' >'.$aStartPage[$i].'</option>'."\n";
    } // end for
    return $sOption.listCategories( 'categories_content_select.tpl', 2, null, Array( substr( $sStartPage, 2 ) ) );
  } // end function throwPagesSelect
}

if( !function_exists( 'throwTemplatesSelect' ) ){
  /**
  * Returns select of style files
  * @return string
  * @param string $sFileName
  */
  function throwTemplatesSelect( $sFileName = null ){
    global $oFF;

    $sOption  = null;
    $oDir     = dir( TPL );

    while( false !== ( $sFile = $oDir->read( ) ) ){
      if( is_file( TPL.$sFile ) && $oFF->checkCorrectFile( $sFile, 'css' ) ){
        if( isset( $sFileName ) && $sFileName == $sFile )
          $sSelected = 'selected="selected"';
        else
          $sSelected = null;
          
        $sOption .= '<option value="'.$sFile.'" '.$sSelected.'>'.$sFile.'</option>';
      }
    } // end while

    $oDir->close( );

    return $sOption;
  } // end function throwTemplatesSelect
}

if( !function_exists( 'loginActions' ) ){
  /**
  * Log in and out actions
  * @return void
  * @param string $p
  * @param string $sKey
  * @date 2004-10-28 10:30:22
  */
  function loginActions( $p, $sKey = 'iUser' ){
    global $tpl, $sLoginInfo, $sLoginPage, $sLoginPageNext;
    
    if( !isset( $_SESSION[$sKey] ) || $_SESSION[$sKey] !== TRUE ){
      $sLoginPage = '?p=login';
      if( $p == 'login' && isset( $_POST['sLogin'] ) && isset( $_POST['sPass'] ) ){
        $iCheckLogin = checkLogin( $_POST['sLogin'], $_POST['sPass'] );
        if( $iCheckLogin == 1 ){
          if( !isset( $_COOKIE['sLogin'] ) || $_COOKIE['sLogin'] != $_POST['sLogin'] )
            @setCookie( 'sLogin', $_POST['sLogin'], time( ) + 2592000 );
          $sLoginInfo = $tpl->tbHtml( 'login.tpl', 'LOGIN_CORRECT' );
        }
        elseif( $iCheckLogin == 2 ){
          $sLoginPage = $_SERVER['PHP_SELF'];
          $sLoginInfo = $tpl->tbHtml( 'login.tpl', 'LOGIN_NOT_ACTIVE' );
        }
        else{
          $sLoginPage = $_SERVER['PHP_SELF'];
          $sLoginInfo = $tpl->tbHtml( 'login.tpl', 'LOGIN_ERROR' );
        }
      }
      else{
        $sLoginInfo = $tpl->tbHtml( 'login.tpl', 'LOGIN_FORM' );
      }

      $tpl->dbHtml( 'login.tpl', 'LOGIN_TABLE' );
      exit;
    }
    else{
      if( $p == 'logout' ){
        unset( $_SESSION[$sKey] );
        $sLoginPage = $_SERVER['PHP_SELF'];
        $sLoginInfo = $tpl->tbHtml( 'login.tpl', 'LOGOUT' );
        $tpl->dbHtml( 'login.tpl', 'LOGIN_TABLE' );
        exit;
      }
    }
  } // end function loginActions
}

if( !function_exists( 'saveConfig' ) ){
  /**
  * Saves configuration
  * @return void
  * @param array $aForm
  */
  function saveConfig( $aForm ){
    global $oFoto;

    $aForm = changeMassTxt( $aForm, 'nl' );

    if( is_uploaded_file( $_FILES['logo']['tmp_name'] ) && is_file( $_FILES['logo']['tmp_name'] ) && filesize( $_FILES['logo']['tmp_name'] ) > 0 && $oFoto->checkCorrectFile( $_FILES['logo']['name'], 'jpg|jpeg|gif|png' ) == true ){
      $sNewImg      = $oFoto->uploadFile( $_FILES['logo'], DIR_FILES.'img/', $_FILES['logo']['name'] );
      $aNewImgSize  = $oFoto->throwImgSize( DIR_FILES.'img/'.$sNewImg );
      if( $aNewImgSize['width'] <= 760 && $aNewImgSize['height'] <= 500 ){
        unlink( DIR_FILES.'img/'.$GLOBALS['config']['logo_img'] );
        $aForm['logo_img'] = $sNewImg;
      }
      else
        unlink( DIR_FILES.'img/'.$sNewImg );
    }

    $aFile  = file( DB_CONFIG );
    $iCount = count( $aFile );
    $rFile  = fopen( DB_CONFIG, 'w' );

    for( $i = 0; $i < $iCount; $i++ ){
      foreach( $aForm as $sKey => $sValue ){
        if( ereg( "config\['".$sKey."'\]", $aFile[$i] ) && ereg( '=', $aFile[$i] ) ){
          if( is_numeric( $sValue ) || checkCorrect( $sValue, 'true|false' ) == true )
            $aFile[$i] = "\$config['".$sKey."']\t\t= ".$sValue.";\n";
          else
            $aFile[$i] = "\$config['".$sKey."']\t\t= \"".$sValue."\";\n";
        }
      } // end foreach

      fwrite( $rFile, $aFile[$i] );

    } // end for
    fclose( $rFile );
  } // end function saveConfig
}

if( !function_exists( 'throwTrueFalseSelect' ) ){
  /**
  * Return true/false select
  * @return string
  * @param bool $bTrueFalse
  */
  function throwTrueFalseSelect( $bTrueFalse = false ){
    
    $aSelect = Array( null, null );
    
    if( $bTrueFalse == true )
      $aSelect[1] = 'selected="selected"';
    else
      $aSelect[0] = 'selected="selected"';
    
    $sOption =  '<option value="true" '.$aSelect[1].'>'.LANG_YES_SHORT.'</option>';
    $sOption .= '<option value="false" '.$aSelect[0].'>'.LANG_NO_SHORT.'</option>';
    return $sOption;
  } // end function throwTrueFalseSelect
}

if( !function_exists( 'throwLangSelect' ) ){
  /**
  * Return language files select
  * @return string
  * @param string $sLang
  */
  function throwLangSelect( $sLang = null ){
    global $oFF;
    
    $sOption  =  null;
    $oDir     = dir( DIR_LANG );

    while( false !== ( $sFile = $oDir->read( ) ) ) {
      if( is_file( DIR_LANG.$sFile ) )
        $sFileName = $oFF->throwNameOfFile( $sFile );
      else
        $sFileName = null;

      if( isset( $sFileName ) && strlen( $sFileName ) == 2 ){
        if( isset( $sLang ) && $sLang == $sFileName )
          $sSelected = 'selected="selected"';
        else
          $sSelected = null;

        $sOption .= '<option value="'.$sFileName.'" '.$sSelected.'>'.$sFileName.'</option>';
      }
    } // end while

    $oDir->close( );
    return $sOption;
  } // end function throwLangSelect
}

if( !function_exists( 'checkLogin' ) ){
  /**
  * Check login and password saved in config/general.php
  * @return int
  * @param string $sLogin
  * @param string $sPass
  */
  function checkLogin( $sLogin, $sPass ){
    global $config;
    if( $config['login'] == $sLogin && $config['pass'] == $sPass ){
      $_SESSION['bUserQC'] = true;
      return 1;
    }
    else
      return 0;
  } // end function checkLogin
}

if( !function_exists( 'throwWarnings' ) ){
  /**
  * Returns messages/warnings
  * @return string
  * @param string $sFile
  */
  function throwWarnings( $sFile ){
    global $tpl, $aWarning, $lang;
    
    $content = null;
    
    $sPhpVer = ereg_replace( '\.', '', phpversion( ) );
    if( $sPhpVer < 433 ){
      $aWarning['sTitle'] = $lang['msg_php_version'];
      $aWarning['sInfo']  = $lang['msg_php_version_info'];
      $content .= $tpl->tbHtml( $sFile, 'WARNING_INFO' );
    }

    if( !is_writable( DB_ORDERS ) ){
      $aWarning['sTitle'] = $lang['msg_files_permission'];
      $aWarning['sInfo']  = $lang['msg_files_permission_info'];
      $content .= $tpl->tbHtml( $sFile, 'WARNING_INFO' );
    }

    if( !is_writable( 'config/general.php' ) ){
      $aWarning['sTitle'] = $lang['msg_config_permission'];
      $aWarning['sInfo']  = $lang['msg_config_permission_info'];
      $content .= $tpl->tbHtml( $sFile, 'WARNING_INFO' );
    }

    if( $GLOBALS['config']['login'] == 'admin' && $GLOBALS['config']['pass'] == 'admin' ){
      $aWarning['sTitle'] = $lang['msg_login'];
      $aWarning['sInfo']  = $lang['msg_login_info'];
      $content .= $tpl->tbHtml( $sFile, 'WARNING_INFO' );    
    }
    
    if( !function_exists( 'ImageCreateFromJpeg' ) ){
      $aWarning['sTitle'] = $lang['msg_gd2'];
      $aWarning['sInfo']  = $lang['msg_gd2_info'];
      $content .= $tpl->tbHtml( $sFile, 'WARNING_INFO' );    
    }

    if( fopen( DIR_FILES.'ext/test', 'w' ) ){
      unlink( DIR_FILES.'ext/test' );      
    }
    else{
      $aWarning['sTitle'] = $lang['msg_dirs_permission'];
      $aWarning['sInfo']  = $lang['msg_dirs_permission_info'];
      $content .= $tpl->tbHtml( $sFile, 'WARNING_INFO' );        
    }

    if( isset( $content ) )
      return $tpl->tbHtml( $sFile, 'WARNING_HEAD' ).$content.$tpl->tbHtml( $sFile, 'WARNING_FOOTER' );
    else
      return $tpl->tbHtml( $sFile, 'DONE' );
  } // end function throwWarnings
}
?>