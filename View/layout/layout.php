<html>
<head>
    <title>imgDB</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="/css/materialize.min.css" media="screen,projection"/>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/animate.css">


</head>
<body>
<nav class="blue-grey darken-4">
    <div class="nav-wrapper main-navbar">
            <div>
                <?= linkHelper(['controller' =>'index','action' => 'index'], 'imgDB', ['class' => 'brand-logo']) ?>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
            <ul class="right hide-on-med-and-down">
                <li><?= linkHelper(['controller' => 'login', 'action' => 'index'], 'Login')?></li>
                <li><?= linkHelper(['controller' => 'login', 'action' => 'logout'], 'Logout')?></li>
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
<script src="/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/js/materialize.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
</body>
</html>