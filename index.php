<?php

session_start();
/* loads config */
require_once('config/config.php');
require_once('autoloader.php');
require_once('util/functions.php');

use MKWeb\ImgDB\Network\Dispatcher;
use MKWeb\ImgDB\Network\Request;
use MKWeb\ImgDB\Network\Response;

/* creates new instance of Dispatcher and invokes the dispatch method */
$dispatcher = new Dispatcher();
$dispatcher->dispatch(Request::createRequest(), new Response());
