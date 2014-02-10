<?php
/*
* setup.php for taxAndDiscount
* (for use with Plugin Manager v2.0+)
*/
$setup = array( 'version'            => '2.1'
              , 'plugins.php'        => array('taxAndDiscount.php')
              , 'actions_client.php' => array('actions_client.php')
              , 'actions_admin.php'  => array('actions_admin.php')
              , 'prerequisites'      => array('pluginManager v2.0+')
              , 'preloadLang'        => 0
              );
?>
