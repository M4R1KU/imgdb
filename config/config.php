<?php

//Define Directory Separator
define('DS', '/');

//Root Directory of the project
$p = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', DS, dirname(__DIR__))) . '/webroot/';
define('ROOT', $_SERVER['DOCUMENT_ROOT'] == $p ? $p : '/');


//webroot of the project (contains css, js etc.)
define('WEBROOT', ROOT . 'webroot/');

define('DIR_NAME', dirname(dirname(__DIR__)));

define('REL_FINAL_GALLERY_DIR', WEBROOT . 'galleries/final/');
define('REL_THUMBNAIL_GALLERY_DIR', WEBROOT . 'galleries/thumbnail/');

define('ABS_FINAL_GALLERY_DIR', DIR_NAME . REL_FINAL_GALLERY_DIR);
define('ABS_THUMBNAIL_GALLERY_DIR', DIR_NAME . REL_THUMBNAIL_GALLERY_DIR);
define('THUMBNAIL_HEIGHT', 200);

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'imgdb');
define('DB_USER', 'imgdb');
define('DB_PW', '');
define('DB_PORT', '3306');

print_r(ROOT . '<br>');
print_r(WEBROOT . '<br>');
print_r($_SERVER['DOCUMENT_ROOT'] . '<br>');
print_r(DIR_NAME . '<br>');
print_r(__DIR__ . '<br>');

// if it is necessary you can define more constants


?>
