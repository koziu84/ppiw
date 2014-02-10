<?php
if( !defined( 'MAX_PAGES' ) )
  define( 'MAX_PAGES', 10 );

if( !defined( 'P_PREFIX' ) )
  define( 'P_PREFIX', '' );

if( !defined( 'LANG_YES_SHORT' ) )
  define( 'LANG_YES_SHORT', 'Tak' );

if( !defined( 'LANG_NO_SHORT' ) )
  define( 'LANG_NO_SHORT', 'Nie' );

if( !defined( 'MAX_STR_LEN' ) )
  define( 'MAX_STR_LEN', 40 );


/**
* Funkcje ze sprawdzaniem i wyswietlanie danych
* @author daniel hydzik <daniel.hydzik@ox.pl>
* @version 0.5.1-bf2
* @date 2005-12-13 08:38:03
*/

/**
* Zwracanie selekta tak/nie 
* @return string
* @param int    $nr
*/
function throwYesNoSelect( $nr ){
  for( $l = 0; $l < 2; $l++ ){
    if( is_numeric( $nr ) && $nr == $l ) 
      $select[$l] = 'selected="selected"';
    else		
      $select[$l] = '';
  } // end for

  $option =  '<option value="1" '.$select[1].'>'.LANG_YES_SHORT.'</option>';
  $option .= '<option value="0" '.$select[0].'>'.LANG_NO_SHORT.'</option>';

  return $option;
} // end function throwYesOrNoSelect

/**
* Zwracanie checkbox'a
* @return string
* @param string $sBoxName
* @param int    $iYesNo
*/
function throwYesNoBox( $sBoxName, $iYesNo = 0 ){
  if( $iYesNo == 1 )
    $sChecked = 'checked="checked"';
  else
    $sChecked = null;

  return '<input type="checkbox" '.$sChecked.' name="'.$sBoxName.'" value="1" />';
} // end function throwYesNoBox

/**
* Zwracanie tak/nie
* @return string
* @param int $nr
*/
function throwYesNoTxt( $nr = false ){
  if( $nr == 1 )
    return LANG_YES_SHORT;
  else
    return LANG_NO_SHORT;
} // end function throwYesNoTxt

/**
* Zwracanie przemienionego tekstu
* @return string
* @param string $txt
* @param mixed  $opcja - b/d
*/
function changeTxt( $txt, $opcja = '' ){

  if( eregi( 'tag', $opcja ) )
    $txt = changeHtmlEditorTags( $txt );

  if( eregi( 'h', $opcja ) )
    $txt = htmlspecialchars( $txt );

  $txt = changeSpecialChars( $txt );

  if( !eregi( 'nds', $opcja ) )
    $txt = ereg_replace( '"', "&quot;", $txt );

  if( eregi( 'sl', $opcja ) )
    $txt = addslashes( $txt );
  else
    $txt = stripslashes( $txt );

  $txt = ereg_replace( "\r", '', $txt );

  if( eregi( 'len', $opcja ) )
    $txt = checkLengthOfTxt( $txt );

  if( eregi( 'nl', $opcja ) ){
    $txt = ereg_replace( "\n", '', $txt );
    $txt = ereg_replace( '\|n\|', "\n" , $txt );
  }
  else{
    if( eregi( 'br', $opcja ) )
      $txt = ereg_replace( "\n", '<br />', $txt );
    else
      $txt = ereg_replace( "\n", '|n|', $txt );
  }

  if( eregi( 'space', $opcja ) )
    $txt = ereg_replace(' ','',$txt);

  return $txt;
} // end function changeTxt

/**
* Masowe zmienianie pol na podstawie changeTxt
* @return array
* @param array  $aData
* @param string $sOption
* 1. $aData = changeMassTxt( $aData, 'sl' );
* 2. $aData = changeMassTxt( $aData, 'sl', Array( 'index1', 'Nds' ), Array( 'index2', 'SlNds' ) );
*/
function changeMassTxt( $aData, $sOption = null ){
  $iParams = func_num_args( );
  if( $iParams > 2 ){
    $aParam = func_get_args( );
    for( $i = 2; $i < $iParams; $i++ ){
      $aData[$aParam[$i][0]] =    changeTxt( $aData[$aParam[$i][0]], $aParam[$i][1] );
      $aDontDo[$aParam[$i][0]] =  true;
    } // end for
  }
    
  foreach( $aData as $mKey => $mValue )
    if( !isset( $aDontDo[$mKey] ) && !is_numeric( $mValue ) && !is_array( $mValue ) )
      $aData[$mKey] = changeTxt( $mValue, $sOption );
  return $aData;
} // end function changeMassTxt

/**
* Masowa zamiana wartosci numerycznych w tablicy na format float z okreslona liczba miejsc po przecinku
* @return array
* @param array  $aData
* @param int    $iAfterDot
*/
function changeMassFloat( $aData, $iAfterDot = 2 ){
    
  foreach( $aData as $mKey => $mValue )
    if( is_numeric( $mValue ) )
      $aData[$mKey] = sprintf( '%01.'.$iAfterDot.'f', $mValue );

  return $aData;
} // end function changeMassFloat


/**
* Sprawdzanie dlugosci wyrazow i dodawanie nowej linii
* w przypadku gdy wyraz przekracza okreslona limitowana
* dlugosc
* @return string
* @param string $txt
*/
function checkLengthOfTxt( $txt ){
  return wordwrap( $txt, MAX_STR_LEN, " ", 1 );
} // end function checkLengthOfTxt

/**
* Sprawdzanie czy dlugosc wyrazu pomijajac spacje
* nowe linie, bez znacznikow html jest dluzszy niz przekazywana
* dlugosc w atrybucie
* @return boolean
* @param string $txt
* @param int    $length
*/
function checkLength( $txt, $length = 3 ){
  if( strlen( changeTxt( $txt, 'hBrSpace' ) ) > $length )
    return true;
  else
    return false;
} // end function checkLength

/**
* Zwracanie time na podstawie podanej daty i godziny
* @return int
* @param string $date
* @param string $time
* @param string $dateFormat
* @param string $sepDate
* @param string $sepTime
*/
function dateToTime( $date, $time = null, $dateFormat = 'ymd', $sepDate = '-', $sepTime = ':' ){
  
  if( $dateFormat == 'dmy' ){
    $y	= 2;
    $m	= 1;
    $d	= 0;
  }
  else{
    $y	= 0;
    $m	= 1;
    $d	= 2;
  }

  $exp =		@explode( $sepDate, $date );
  $year =		$exp[$y];
  $month =	sprintf( '%01.0f', $exp[$m] );
  $day =		sprintf( '%01.0f', $exp[$d] );

  if( empty( $time ) )
    $time = '00'.$sepTime.'00'.$sepTime.'00';
  
  $exp =		@explode( $sepTime, $time );
  $hour=		sprintf( '%01.0f', $exp[0] );
  $minute=	sprintf( '%01.0f', $exp[1] );

  if( count( $exp ) == 3 )
    $second=	sprintf( '%01.0f', $exp[2] );
  else
    $second=	0;

  return @mktime( $hour, $minute, $second, $month, $day, $year );
} // end function dateToTime

/**
* Zliczanie i podzial na strony
* @return string
* @param int    $iMax
* @param int    $iMaxPerPage
* @param int    $iPage
* @param string $sAddress
* @param string $sSeparator
* @param int    $iMaxPagesPerPage
*/
function countPages( $iMax, $iMaxPerPage, $iPage, $sAddress, $sSeparator = '|', $iMaxPagesPerPage = MAX_PAGES ){

  $iSubPages= ceil( $iMax / $iMaxPerPage ); 
  $sPages   = null;
  
  if( $iSubPages > $iPage ) 
    $iNext = 1; 
  else  
    $iNext = 0; 

  $iMax = ceil( $iPage + ( $iMaxPagesPerPage / 2 ) );
  $iMin = ceil( $iPage - ( $iMaxPagesPerPage / 2 ) );
  if( $iMin < 0 )
    $iMax += -( $iMin );
  if( $iMax > $iSubPages )
    $iMin -= $iMax - $iSubPages;

  $l['min'] = 0;
  $l['max'] = 0;
  for ( $i = 1; $i <= $iSubPages; $i++ ) { 
    if( $i >= $iMin && $i <= $iMax ) {
      if ( $i == $iPage ) 
        $sPages .= $sSeparator.' <strong>'.$i.'</strong> '; 
      else 
        $sPages .= $sSeparator.' <a href="?p='.P_PREFIX.$sAddress.'&amp;iPage='.$i.'">'.$i.'</a> '; 
    }
    elseif( $i < $iMin ) {
      if( $i == 1 )
        $sPages .= $sSeparator.' <a href="?p='.P_PREFIX.$sAddress.'&amp;iPage='.$i.'">'.$i.'</a> '; 
      else{
        if( $l['min'] == 0 ){
          $sPages .= $sSeparator.' ... '; 
          $l['min'] = 1;
        }
      }
    }
    elseif( $i > $iMin ) {
      if( $i == $iSubPages ){
        $sPages .= $sSeparator.' <a href="?p='.P_PREFIX.$sAddress.'&amp;iPage='.$i.'">'.$i.'</a> '; 
      }
      else{
        if( $l['max'] == 0 ){
          $sPages .= $sSeparator.' ... '; 
          $l['max'] = 1;
        }
      }
    }
  } // end for
  $sPages .= $sSeparator;

  return $sPages;
} // end function countPages

/**
* sprawdzanie czy dane sa zbiezne z tym co jest przesylane
* $dane = 'jpg' np. $check = 'jpg|gif|jpeg'
* sprawdzanie czy $dane posiada jedno z tych co ma $check
* @return boolean
* @param string $dane
* @param string $check
*/
function checkCorrect( $dane, $check ){
  return preg_match( '/'.$check.'/', $dane );
} // end function checkCorrect

/**
* Zmiana polskich znakow na znaki "nie polskie"
* @return string
* @param string $txt
*/
function changePolishToNotPolish( $txt ){
  $aStr[] = '/œ/';
  $aStr[] = '/¹/';
  $aStr[] = '/Ÿ/';
  $aStr[] = '/Œ/';
  $aStr[] = '/¥/';
  $aStr[] = '//';
  $aStr[] = '/¶/';
  $aStr[] = '/¦/';
  $aStr[] = '/±/';
  $aStr[] = '/¡/';
  $aStr[] = '/¼/';
  $aStr[] = '/¬/';
  $aStr[] = '/¯/';
  $aStr[] = '/¿/';
  $aStr[] = '/Ñ/';
  $aStr[] = '/ñ/';
  $aStr[] = '/Æ/';
  $aStr[] = '/æ/';
  $aStr[] = '/Ê/';
  $aStr[] = '/ê/';
  $aStr[] = '/£/';
  $aStr[] = '/³/';
  $aStr[] = '/Ó/';
  $aStr[] = '/ó/';

  $aRep[] = 's';
  $aRep[] = 'a';
  $aRep[] = 'z';
  $aRep[] = 'S';
  $aRep[] = 'A';
  $aRep[] = 'Z';
  $aRep[] = 's';
  $aRep[] = 'S';
  $aRep[] = 'a';
  $aRep[] = 'A';
  $aRep[] = 'z';
  $aRep[] = 'Z';
  $aRep[] = 'Z';
  $aRep[] = 'z';
  $aRep[] = 'N';
  $aRep[] = 'n';
  $aRep[] = 'C';
  $aRep[] = 'c';
  $aRep[] = 'e';
  $aRep[] = 'e';
  $aRep[] = 'L';
  $aRep[] = 'l';
  $aRep[] = 'O';
  $aRep[] = 'o';

  return preg_replace( $aStr, $aRep, $txt );
} // end function changePolishToNotPolish

/**
* Zmiana polskich znakow na iso-8859-2
* @return string
* @param string $txt
*/
function changePolishToIso( $txt ){
  $aStr[] = '/œ/';
  $aStr[] = '/¹/';
  $aStr[] = '/Ÿ/';
  $aStr[] = '/Œ/';
  $aStr[] = '/¥/';
  $aStr[] = '//';

  $aRep[] = '¶';
  $aRep[] = '±';
  $aRep[] = '¼';
  $aRep[] = '¦';
  $aRep[] = '¡';
  $aRep[] = '¬';
  return preg_replace( $aStr, $aRep, $txt );
} // end function changePolishToIso

/**
* Zmiana znakow w stylu '$' na '&#36;'
* @return string
* @param string $sTxt
*/
function changeSpecialChars( $sTxt ){
  $aStr[] = '/\$/';
  $aRep[] = '&#36;';
  return preg_replace( $aStr, $aRep, $sTxt );
} // end function changeSpecialChars

/**
* Sprawdzanie poprawnosci daty
* @return boolean
* @param string $date
* @param string $format
* @param string $separator
*/
function is_date( $date, $format='ymd', $separator='-' ){

  $f['y'] = 4;
  $f['m'] = 2;
  $f['d'] = 2;

  if ( ereg( "([0-9]{".$f[$format[0]]."})".$separator."([0-9]{".$f[$format[1]]."})".$separator."([0-9]{".$f[$format[2]]."})", $date ) ){
    
    $y =    strpos( $format, 'y' );
    $m =    strpos( $format, 'm' );
    $d =    strpos( $format, 'd' );
    $dates= explode( $separator, $date );

    return  checkdate( $dates[$m], $dates[$d], $dates[$y] );
  }
  else
    return false;
} // end function is_date





/**
* Zliczanie dlugosci stringa
* @return boolean
* @param string $txt
*/
function throwStrLen( $sTxt ){
  return strlen( changeTxt( $sTxt, 'hBrSpace' ) );
} // end function throwStrLen

/**
* Zwracanie MicroTime 
* @return float
*/
function throwMicroTime( ){ 
  $exp =  explode( " ", microtime( ) ); 
  return  ( (float) $exp[0] + (float) $exp[1] ); 
} // end function throwMicroTime

/**
* Zwraca selecta z pliku tpl
* @return string
* @param  object  $tpl
* @param  int     $selected - id wybranej pozycji
* @param  mixed   $opcja
*/
function throwSelectFromTpl( $tpl, $sFile, $mSelected = null ){
  global $aSelected;
  $aSelected[$mSelected] = ' selected="selected" ';
    $sSelect = $tpl->tHtml( $sFile );
  $aSelected[$mSelected] = '';
  return $sSelect;
} // end function throwSelectFromTpl

/**
* Zwracanie select'a z array'a
* @return string
* @param array  $aData
* @param mixed  $mData
*/
function throwSelectFromArray( $aData, $mData = null ){
  $sOption  = null;

  foreach( $aData as $iKey => $mValue ){
    if( isset( $mData ) && $mData == $iKey )
      $sSelected = 'selected="selected"';
    else
      $sSelected = null;

    $sOption .= '<option value="'.$iKey.'" '.$sSelected.'>'.$mValue.'</option>';  
  }

  return $sOption;
} // end function throwSelectFromArray

/**
* Wyswietlanie checkbox'a na podstawie arraya
* @return string
* @param array  $aBox
* @param string $sName
* @param mixed  $mValue
* @param string $sSeperator
*/
function throwBoxFromArray( $aBox, $sName = 'nazwa', $mValue = -1, $sSeperator = ' ' ){
  $content =	    null;
  $iCountBox =    count( $aBox );
  if( is_array( $mValue ) )
    $iCountValues = count( $mValue );

  for( $i = 0; $i < $iCountBox; $i++ ){
    $sChecked = null;

    if( is_array( $mValue ) ){
      if( isset( $mValue[$i] ) && $mValue[$i] == 1 )
        $sChecked = 'checked="checked"';
    }
    else {
      if( $mValue == 1 )
        $sChecked = 'checked="checked"';
    }

    $content .= '<input type="checkbox" name="'.$sName.'['.$i.']" '.$sChecked.'  value="1" />'.$aBox[$i].$sSeperator;

  } // end for

  return $content;
} // end function throwBoxFromArray



/**
* Zwracanie minut z wartosci dziesietnej godziny ( np. wartosc dziesietna 3.20 to [0] -> 3, [1] -> 12
* @return array
* @param  float   $fHour
*/
function throwMinutesFromDecimal( $fHour ){
  $fHour  = sprintf( '%01.2f', $fHour );
  $aDec   = explode( '.', $fHour );

  $aMinutes[0] = $aDec[0];
  $aMinutes[1] = (int) ( 60 * ( $aDec[1] / 100 ) );

  return $aMinutes;
} // end function throwMinutesFromDecimal

/**
* Zwracanie tablicy z minutami i godzinami z podanej ilosci minut ( np. wartosc dziesietna 70 to [0] -> 1, [1] -> 10
* @return array
* @param  float   $iMinutes
*/
function throwMinutesFromInt( $iMinutes = 0 ){

  $aMinutes[0] = ( int ) ( $iMinutes / 60 );
  $aMinutes[1] = $iMinutes % 60;

  return $aMinutes;
} // end function throwMinutesFromInt

/**
* Zamienia znaki '&' w zmiennej na {and}
* @return string
* @param string $sLink
* @param string $option
*/
function parseAnd( $sLink, $option = 'parse' ){
  if( $option == 'parse' ){
    $sLink = ereg_replace( "&", "{and}", $sLink );
  }
  elseif( $option == 'unparse' ){
    $sLink = ereg_replace( "{and}", "&", $sLink );
  }	
  return $sLink;
} // end function parseAnd

/**
* Obcina tekst zwracajac cale wyrazy ktore miaszcza sie w podanej ilosci znakow
* @return string
* @param string $sText
* @param int    $iLen
*/
function cutText( $sText, $iLen = 100 ){

  $sText = substr( $sText, 0, $iLen );

  $iSpacja  = strrpos( $sText, " " );
  $sText    = substr( $sText, 0, $iSpacja );

  return $sText;
} // end function cutText

/**
* Pobieranie pliku do wykonania akcji
* @return string
* @param string   $p
* @param string   $sDir
*/
function getAction( $p, $sDir ){
  global $a, $aActions, $sActionFile;

  $iStrlen = strlen( $p );

  if( $iStrlen > 0 ){
    $aActions['g']  = null;
    $aActions['a']  = null;

    for( $i = 0; $i < $iStrlen; $i++ ){

      if( ereg( "[a-z_]", $p[$i] ) && $aActions['a'] == '' )
        $aActions['g'] .= $p[$i];
      else
        $aActions['a'] .= $p[$i];

    } // end for

    $a            = $aActions['a'];
    $sActionFile  = $sDir.$aActions['g'].'.php';
  }
  else{
    $a            = null;
    $sActionFile  = null;
  }
} // end function getAction
?>
