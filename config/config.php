<?php

//Define Directory Separator
define('DS', '/');

//Root Directory of the project
define('ROOT', dirname(__DIR__));


//webroot of the project (contains css, js etc.)
define('WEBROOT', ROOT . DS . 'webroot');

define('DIR_NAME', dirname(dirname(__DIR__)));

define('REL_FINAL_GALLERY_DIR', '/galleries/final/');
define('REL_THUMBNAIL_GALLERY_DIR', '/galleries/thumbnail/');

define('ABS_FINAL_GALLERY_DIR', WEBROOT . REL_FINAL_GALLERY_DIR);
define('ABS_THUMBNAIL_GALLERY_DIR', WEBROOT . REL_THUMBNAIL_GALLERY_DIR);
define('THUMBNAIL_HEIGHT', 200);

define('SECRET', 'U-:9=040eco?aMqmQTc');

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'imgdb');
define('DB_USER', 'imgdb');
define('DB_PW', '');
define('DB_PORT', '3306');

// if it is necessary you can define more constants


?>
