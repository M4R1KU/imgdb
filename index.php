<?php

session_start();
/* loads config */
require_once('config/config.php');

require_once('lib/Dispatcher.php');
require_once('lib/Request.php');
require_once('lib/Response.php');
require_once ('lib/functions.php');

/* creates new instance of Dispatcher and invokes the dispatch method */
$dispatcher = new Dispatcher();
$dispatcher->dispatch(Request::createRequest(), new Response());
