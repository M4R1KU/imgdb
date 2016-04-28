<?php

//Define Directory Separator
define('DS', '/');

//Root Directory of the project
define('ROOT', str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', DS, dirname(__DIR__))));

//webroot of the project (contains css, js etc.)
define('WEBROOT', ROOT . DS . 'webroot/');

define('SALT', '@i2SN$y2hnYy62DEYrG3qbV8ydFI^Q%W');

define('CSRF_TOKEN_NAME', 'csrfToken');

define('CSRF_ENABLED', false)

// if it is necessary you can define more constants


?>
