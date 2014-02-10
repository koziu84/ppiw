<?php
/**
* attributes-admin.php
* Wizzud 31/01/06 Product-Attributes
*/
if( !function_exists( 'setProdListHasAttr' ) ){
  /**
  * Sets a flag indicating whether or not there is an entry in the product-attributes file for a product.
  * Its sole use is as a run-before function on the extended tpl intercept of products_list.tpl/LIST_LIST.
  * @return void
  */
  function setProdListHasAttr($inProgress){
    global $oAttributes;
    if( isset($GLOBALS['aList']['iProduct']) ){ $oAttributes->throwAdminProdList($GLOBALS['aList']['iProduct']); }
  } // end function setProdListHasAttr
}
?>
