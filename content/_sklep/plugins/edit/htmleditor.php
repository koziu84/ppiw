<?php
/**
* Funckja zwracajaca edytor;
* @return string
* @param  string  $sName
* @param  int     $iH
* @param  int     $iW
* @param  string  $sContent
*/
function htmlEditor( $sName = 'tresc', $iH = '300', $iW = '400', $sContent = '' ) {
  global $tpl, $aHtmlConfig;
  
  $sReturn = null;
  $aHtmlConfig['iH'] = $iH.'px';
  $aHtmlConfig['iW'] = $iW.'px';
  $aHtmlConfig['sName'] = $sName;
  $aHtmlConfig['sContent'] = $sContent;
  
  $sReturn = $tpl->tbHtml( 'edit.tpl', 'EDIT' );

  return $sReturn;
}
?>