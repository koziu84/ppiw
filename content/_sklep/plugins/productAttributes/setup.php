<?php
/*
* setup.php for productAttributes
* (for use with Plugin Manager v2.0+)
*/
$setup = array( 'version'            => '2.0'
              , 'plugins.php'        => array('productAttributes.php')
              , 'actions_client.php' => array('actions_client.php')
              , 'actions_admin.php'  => array('actions_admin.php')
              , 'prerequisites'      => array('pluginManager v2.0+')
              , 'preloadLang'        => 2
              , 'triggerDisabled'    => array('attributesList', 'attributesForm')
              );
?>
