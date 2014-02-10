<?php
//error_reporting( E_ALL );

/*
* List of directories 
*/
$config['dir_core']             = 'core/';
$config['dir_db']               = 'db/';
$config['dir_js']               = 'js/';
$config['dir_libraries']        = 'libraries/';
$config['dir_lang']             = 'lang/';
$config['dir_tpl']              = 'templates/';
$config['dir_files']            = 'files/';
$config['dir_ext']              = 'ext/';
$config['dir_products_files']   = 'products/';
$config['dir_categories_files'] = 'categories/';
$config['dir_plugins']          = 'plugins/';

$config['template']		= "ppiw.css";

/*
* List of database files 
*/
$config['db_products']            = $config['dir_db'].'products.php';
$config['db_products_files']      = $config['dir_db'].'products_files.php';
$config['db_products_ext']        = $config['dir_db'].'products_ext.php';
$config['db_products_categories'] = $config['dir_db'].'products_categories.php';

$config['db_categories']          = $config['dir_db'].'categories.php';
$config['db_categories_ext']      = $config['dir_db'].'categories_ext.php';
$config['db_categories_files']    = $config['dir_db'].'categories_files.php';

$config['db_couriers']            = $config['dir_db'].'couriers.php';

$config['db_orders']              = $config['dir_db'].'orders.php';
$config['db_orders_ext']          = $config['dir_db'].'orders_ext.php';
$config['db_orders_products']     = $config['dir_db'].'orders_products.php';

$config['db_config']         = 'config/general.php';

/*
* Logo file
*/
$config['logo_img']		= "ppiw_shop_header.jpg";

$config['products_photo_size']		= 150;
$config['categories_photo_size']		= 150;

$config['max_dimension_of_image'] = 900;
$config['foto_jobs_ratio'] = 0.80;

$config['products_list']		= 6;
$config['admin_list']		= 30;

$config['contact_page']		= 1;

/*
* Contact email
*/
$config['email']		= "sprzedaz@ppiw.com.pl";

/*
* Information on mail about new order true/false
*/
$config['mail_informing']		= false;

/*
* Start page 
*/
$config['start_page']		= "p_13";

$config['login']		= "AdministratorSklepu";
$config['pass']		= "SuperAdmin";

/*
* Title, description and keywords to Your website 
*/
$config['title']		= "sklep internetowy Pracowni Pedagogicznej i Wydawniczej";
$config['description']		= "Pracownia Pedagogiczna i Wydawnicza - sklep internetowy";
$config['keywords']		= "abcelki,Bursztynowy Dom,ppiw,kszta³cenie,podrêczniki,kszta³cenie zintegrowane,figielek,psotka,wydawnictwo,edukacja jutra,edukacja,szkolenia,abc,program abc,program kszta³cenia zintegrowanego,klasa I,klasa II, klasa III,zerówka,klasa 0,nauczyciel";

/*
* Language and currency 
*/
$config['language']		= "pl";
$config['currency_symbol']		= "z³";

$config['version'] = '1.2';


#####################
# Dont change below #
#####################

$config['db_type'] = 'ff';

define( 'DIR_CORE',             $config['dir_core'] );
define( 'DIR_DB',               $config['dir_db'] );
define( 'DIR_FILES',            $config['dir_files'] );
define( 'DIR_LIBRARIES',        $config['dir_libraries'] );
define( 'DIR_PRODUCTS_FILES',   $config['dir_files'].$config['dir_products_files'] );
define( 'DIR_CATEGORIES_FILES', $config['dir_files'].$config['dir_categories_files'] );
define( 'DIR_PLUGINS',          $config['dir_plugins'] );
define( 'DIR_LANG',             $config['dir_lang'] );
define( 'TPL',                  $config['dir_tpl'] );

define( 'PRODUCTS_LIST',        $config['products_list'] );
define( 'ADMIN_LIST',           $config['admin_list'] );

define( 'PRODUCTS_PHOTO_SIZE',   $config['products_photo_size'] );
define( 'CATEGORIES_PHOTO_SIZE', $config['categories_photo_size'] );

define( 'MAX_DIMENSION_OF_IMAGE', $config['max_dimension_of_image'] );

define( 'DB_PRODUCTS',              $config['db_products'] );
define( 'DB_PRODUCTS_EXT',          $config['db_products_ext'] );
define( 'DB_PRODUCTS_FILES',        $config['db_products_files'] );
define( 'DB_PRODUCTS_CATEGORIES',   $config['db_products_categories'] );

define( 'DB_CATEGORIES',        $config['db_categories'] );
define( 'DB_CATEGORIES_EXT',    $config['db_categories_ext'] );
define( 'DB_CATEGORIES_FILES',  $config['db_categories_files'] );

define( 'DB_COURIERS',        $config['db_couriers'] );

define( 'DB_ORDERS',          $config['db_orders'] );
define( 'DB_ORDERS_EXT',      $config['db_orders_ext'] );
define( 'DB_ORDERS_PRODUCTS', $config['db_orders_products'] );

define( 'DB_CONFIG',     $config['db_config'] );

define( 'EMAIL',              $config['email'] );
define( 'VERSION',            $config['version'] );
define( 'LANGUAGE',           $config['language'] );
?>
