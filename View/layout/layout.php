<html>
<head>
    <title>imgDB</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="/css/materialize.min.css" media="screen,projection"/>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/animate.css">
    <script src="/js/jquery-2.1.4.min.js"></script>
</head>
<body>
<nav class="blue-grey darken-4">
    <div class="nav-wrapper main-navbar">
        <div>
            <?= linkHelper(['controller' => 'index', 'action' => 'index'], 'imgDB', ['class' => 'brand-logo']) ?>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
        <?php if (isset($this->request->session['user_id'])): ?>
        <ul class="right hide-on-med-and-down">
            <li><?= linkHelper(['controller' => 'index', 'action' => 'index'], 'Galleries') ?></li>
            <li><?= linkHelper(['controller' => 'login', 'action' => 'logout'], 'Logout') ?></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
            <li><?= linkHelper(['controller' => 'index', 'action' => 'index'], 'Galleries') ?></li>
            <li><?= linkHelper(['controller' => 'login', 'action' => 'logout'], 'Logout') ?></li>
        </ul>
        <?php endif; ?>
    </div>
</nav>
<nav class="flat blue-grey darken-3" id="search-bar">
    <div class="nav-wrapper">
        <form class="search-bar">
            <div class="input-field">
                <input id="search" type="search" required autocomplete="off">
                <label for="search"><i class="material-icons">search</i></label>
                <i class="material-icons" onclick="removeOverlay()">close</i>
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
<script type="text/javascript" src="/js/materialize.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/search.js"></script>
</body>
</html>