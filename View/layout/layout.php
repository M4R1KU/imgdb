<html>
    <head>
        <title>WebLog</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="<?= WEBROOT?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= WEBROOT?>css/main.css">
        <link rel="icon" href="<?= WEBROOT ?>favicon.ico">
        <script src="<?= WEBROOT?>js/jquery-2.1.4.min.js"></script>
        <script src="<?= WEBROOT?>js/bootstrap.min.js"></script>
        <script src="<?= WEBROOT?>js/main.js"></script>
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
                    <?php if (isset($this->request->session['user_id'])): ?>
                        <li><a class="navbar-link" href="<?=ROOT?>/blogs/index">Blogs</a></li>
                        <li><a class="navbar-link" href="<?=ROOT?>/login/logout">Logout</a></li>
                        <span class="navbar-brand">Logged in as <?= $this->request->session['nickname'] ?></span>
                    <?php else: ?>
                        <li><a class="navbar-link" href="<?=ROOT?>/login/index">Login</a></li>
                        <span class="navbar-brand">Hello</span>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="main-container col-lg-8 col-lg-offset-2">

                <?php
                    $this->_content();
                ?>

                <div class="footer">
                    <hr>
                    <p>2015 | Mario Kunz | mkweb.me</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
