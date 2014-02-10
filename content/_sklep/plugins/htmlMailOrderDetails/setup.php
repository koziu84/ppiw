<?php
/*
* setup.php for htmlMailOrderDetails
* (for use with Plugin Manager v2.0+)
*/
$setup = array( 'version'            => '2.0'
              , 'plugins.php'        => array('htmlMailOrderDetails.php')
              , 'actions_client.php' => array('actions_client.php')
              , 'actions_admin.php'  => array()
              , 'prerequisites'      => array('pluginManager v2.0+')
              , 'preloadLang'        => 0
              , 'triggerDisabled'    => array()
              );
?>
