<?php
/*
* attributes-ff.php
* Author: Wizzud 31/01/06 Product-Attributes
* FlatFile driver 
* Attributes file format: Group(string) Name(string) ID(integer) Offset(float) Percentage(0/1) Optional(0/1)
* Product-Attributes file format: Product-ID(integer) Attributes(comma-delimited list of integers)
*/

if( !function_exists('dbCheckAttrFile') ){
  /* Checks that a data file exists and is writable; tries to create it if it doesn't exist
  * @param string file name
  * @return boolean
  */
  function dbCheckAttrFile($sF){
    if(!file_exists($sF)){
      $GLOBALS['oFF']->setString('<'."?php exit ('NO ENTRY '); ?>");
      $GLOBALS['oFF']->addToFile($sF, '', 'ab');
    }
    if(!file_exists($sF)){ return false; }
    elseif(!is_writable($sF)){ return (@chmod($sF, '0644')); }
    else{ return true; }
  } // end function dbCheckAttrFile
}

if( !function_exists('dbReadAllAttr') ){
  /* Reads attribute data
  * @return array false if not found
  */
  function dbReadAllAttr(){
    $aData = $GLOBALS['oFF']->throwFileArray( DB_ATTRIBUTES, 'sort' );
    return ((isset($aData) && is_array($aData)) ? $aData : false);
  } // end function dbReadAllAttr
}

if( !function_exists('dbSaveAttr') ){
  /* Save attribute (includes 3 spare fields for possible future expansion)
  * @param array  $aForm
  * @param boolean $bExist
  * @return void
  */
  function dbSaveAttr( $aForm, $bExist=false ){
    $GLOBALS['oFF']->setRow( Array( $aForm['sGroup'], $aForm['sName'], $aForm['iAttribute'], $aForm['fOffset'], $aForm['iPercent'], $aForm['iOptional'], ''/*spare_1*/, ''/*spare_2*/, ''/*spare_3*/ ) );
    if( $bExist === true )
      $GLOBALS['oFF']->changeInFile( DB_ATTRIBUTES, $aForm['iAttribute'], 2 );
    else
      $GLOBALS['oFF']->addToFile( DB_ATTRIBUTES );
  } // end function dbSaveAttr
}

if( !function_exists('dbDeleteAttr') ){
  /* Delete attribute
  * @param integer attribute id
  * @return void
  */
  function dbDeleteAttr($iAttribute){
    $GLOBALS['oFF']->deleteInFile( DB_ATTRIBUTES, $iAttribute, 2 );
  } // end function dbDeleteAttr
}

if( !function_exists('dbReadProdAttr') ){
  /* Reads product attribute data for a product
  * @param integer product id
  * return array false if not found
  */
  function dbReadProdAttr($iProduct){
    $aData = $GLOBALS['oFF']->throwData( DB_PRODUCT_ATTRIBUTES, $iProduct, 0 );
    return (isset($aData) ? $aData : false);
  } // end function dbReadProdAttr
}

if( !function_exists('dbReadAllProdAttr') ){
  /* List all attributes for all products
  * @return array false if none found
  */
  function dbReadAllProdAttr(){
    $aData = $GLOBALS['oFF']->throwFileArray( DB_PRODUCT_ATTRIBUTES );
    return ((isset($aData) && is_array($aData)) ? $aData : false);
  } // end function dbReadAllProdAttr
}

if( !function_exists('dbSaveProdAttr') ){
  /* Save attributes for a product
  * @param array $aForm
  * @param boolean $bExists
  * @return void
  */
  function dbSaveProdAttr($aForm, $bExist=false){
    $GLOBALS['oFF']->setRow( $aForm );
    if($bExist === true){ $GLOBALS['oFF']->changeInFile( DB_PRODUCT_ATTRIBUTES, $aForm['iProduct'], 0 ); }
    else{ $GLOBALS['oFF']->addToFile( DB_PRODUCT_ATTRIBUTES ); }
  } // end function dbSaveProdAttr
}

if( !function_exists('dbDeleteProdAttr') ){
  /* Delete product's attributes
  * @param integer product id
  * @return void
  */
  function dbDeleteProdAttr($iProduct){
    $GLOBALS['oFF']->deleteInFile( DB_PRODUCT_ATTRIBUTES, $iProduct, 0 );
  } // end function dbDeleteProdAttr
}
?>
