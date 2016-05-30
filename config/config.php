<?php

//Define Directory Separator
define('DS', '/');

//Root Directory of the project
define('ROOT', str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', DS, dirname(__DIR__))));

//webroot of the project (contains css, js etc.)
define('WEBROOT', ROOT . DS . 'webroot/');

define('DIR_NAME', dirname(__DIR__));

define('FINAL_GALLERY_DIR', DIR_NAME . '/webroot/galleries/final/');
define('THUMBNAIL_GALLERY_DIR', DIR_NAME . '/webroot/galleries/thumbnail/');
define('THUMBNAIL_HEIGHT', 100);

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'imgDB');
define('DB_USER', 'imgDB');
define('DB_PW', '');
define('DB_PORT', '3306');

// if it is necessary you can define more constants


?>
