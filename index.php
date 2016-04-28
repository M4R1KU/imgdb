<?php

/*  __        __   _     _
    \ \      / /__| |__ | |    ___   __ _
     \ \ /\ / / _ \ '_ \| |   / _ \ / _` |
      \ V  V /  __/ |_) | |__| (_) | (_| |
       \_/\_/ \___|_.__/|_____\___/ \__, |
                                     |___/ by Mario Kunz
 */

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
