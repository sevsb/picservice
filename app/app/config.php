<?php

if (file_exists(dirname(__FILE__) . "/../../PATH.php")) {
    include_once(dirname(__FILE__) . "/../../PATH.php");
}

include_once(dirname(__FILE__) . "/../../framework/config.php");
include_once(dirname(__FILE__) . "/database/db_init.class.php");

include_once(dirname(__FILE__) . "/database/db_picservice.class.php");
include_once(dirname(__FILE__) . "/upload.php");
include_once(dirname(__FILE__) . "/thumbnail.php");


include_once(FRAMEWORK_PATH . "/helper.php");
include_once(FRAMEWORK_PATH . "/logging.php");
include_once(FRAMEWORK_PATH . "/tpl.php");


defined('UPLOAD_DIR') or define('UPLOAD_DIR', ROOT_PATH . '/upload/images');
defined('UPLOAD_URL') or define('UPLOAD_URL', rtrim(INSTANCE_URL, "/") . '/upload/images');
defined('THUMBNAIL_DIR') or define('THUMBNAIL_DIR', ROOT_PATH . '/upload/thumbnails');
defined('THUMBNAIL_URL') or define('THUMBNAIL_URL', rtrim(INSTANCE_URL, "/") . '/upload/thumbnails');
defined('UPLOAD_LIMIT') or define('UPLOAD_LIMIT', 10 * 1024 * 1024);


// security
defined('ALLOW_ROOT') or define('ALLOW_ROOT', true);

// database
defined('MYSQL_SERVER') or define('MYSQL_SERVER', '180.76.188.68');
defined('MYSQL_USERNAME') or define('MYSQL_USERNAME', 'picservice');
defined('MYSQL_PASSWORD') or define('MYSQL_PASSWORD', 'picservice');
defined('MYSQL_DATABASE') or define('MYSQL_DATABASE', 'picservice');
defined('MYSQL_PREFIX') or define('MYSQL_PREFIX', 'common_');


// db_settings
defined('TABLE_SETTINGS') or define('TABLE_SETTINGS', MYSQL_PREFIX . "settings");

// db_user
defined('EXPIRED_TIME') or define('EXPIRED_TIME', 3600);












