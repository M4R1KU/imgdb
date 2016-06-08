<?php

$validation = validateFlash();

if ($validation) {
    ?>
    <div class="row animated fadeInDown">
        <div class="card alert-<?= $_GET['flashType'] ?>">
            <div class="card-content">
                <i class="material-icons right" id="flash-closer">close</i>
                <h5><?= ucfirst($_GET['flashType']) ?></h5>
                <p><?= $_GET['flash'] ?></p>
            </div>
        </div>
    </div>
    <?php
} ?>