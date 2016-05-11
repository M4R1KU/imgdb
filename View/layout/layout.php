<html>
<head>
    <title>imgDB</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="<?= WEBROOT ?>/css/materialize.min.css" media="screen,projection"/>
    <link rel="stylesheet" href="<?= WEBROOT ?>/css/main.css">


</head>
<body>
<nav class="blue-grey darken-4">
    <div class="nav-wrapper main-navbar">
            <div>
                <a href="#!" class="brand-logo">imgDB</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
            <ul class="right hide-on-med-and-down">
                <li><a href="<?= ROOT?>/login/index">Login</a></li>
            </ul>
        <ul class="side-nav" id="mobile-demo">
            <li><a href="sass.html">Sass</a></li>
            <li><a href="badges.html">Components</a></li>
            <li><a href="collapsible.html">Javascript</a></li>
            <li><a href="mobile.html">Mobile</a></li>
        </ul>
    </div>
</nav>
<nav class="flat blue-grey darken-3">
    <div class="nav-wrapper">
        <form class="search-bar">
            <div class="input-field">
                <input id="search" type="search" required>
                <label for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </div>
        </form>
    </div>
</nav>
<main>
    <div class="container">
    <?php
        $this->_content();
    ?>
    </div>
</main>
<script src="<?= WEBROOT ?>/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?= WEBROOT ?>/js/materialize.js"></script>
<script type="text/javascript" src="<?= WEBROOT ?>/js/main.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>-->
</body>
</html>


<!--<html>
    <head>
        <title>WebLog</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="<? /*= WEBROOT*/ ?>css/material.css">
        <link rel="stylesheet" href="<? /*= WEBROOT*/ ?>css/main.css">
        <link rel="icon" href="<? /*= WEBROOT */ ?>favicon.ico">
        <script src="<? /*= WEBROOT*/ ?>js/jquery-2.1.4.min.js"></script>
        <script src="<? /*= WEBROOT*/ ?>js/material.min.js"></script>
        <script src="<? /*= WEBROOT*/ ?>js/main.js"></script>
        <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
        </script>
    </head>
    <body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <span class="navbar-brand">WebLog</span>
        <div class="navbar-right container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <?php /*if (isset($this->request->session['user_id'])): */ ?>
                        <li><a class="navbar-link" href="<? /*=ROOT*/ ?>/blogs/index">Blogs</a></li>
                        <li><a class="navbar-link" href="<? /*=ROOT*/ ?>/login/logout">Logout</a></li>
                        <span class="navbar-brand">Logged in as <? /*= $this->request->session['nickname'] */ ?></span>
                    <?php /*else: */ ?>
                        <li><a class="navbar-link" href="<? /*=ROOT*/ ?>/login/index">Login</a></li>
                        <span class="navbar-brand">Hello</span>
                    <?php /*endif; */ ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="main-container col-lg-8 col-lg-offset-2">

                <?php
/*                    $this->_content();
                */ ?>

                <div class="footer">
                    <hr>
                    <p>2015 | Mario Kunz | mkweb.me</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
-->