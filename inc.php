<?php
require_once( 'autoloader.php' );
require_once('lib/Block/Block.php' );
require_once('lib/App/Request.php' );
require_once('lib/App/Session.php' );

define("APP_PATH" , dirname(__FILE__));

define("TPL_PATH" ,APP_PATH.'/template/' );

define("LIB_PATH" ,APP_PATH.'/lib/' );
define("LIBLK_PATH" ,APP_PATH.'/lib/Block/' );

define("STATIC_PATH" ,APP_PATH.'/static/' );
define("IMAGE_PATH" , STATIC_PATH.'img/' );

//define("AVATAR_PATH" ,IMG_PATH.'avatar/' );
//define("PREVIW_PATH" ,IMG_PATH.'48/' );

require_once('lib/App/saveClassCache.php' );

if (file_exists( APP_PATH.'/tmp/classes.cache.php')) {
    require_once(APP_PATH.'/tmp/classes.cache.php' );
} else {
     $classesCache = array();
}

global $classesCache,$isSaveClassCache;     
$isSaveClassCache = false;

     