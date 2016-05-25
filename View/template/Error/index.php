<div class="row">
    <h1>Error: <?= h($this->status_code) ?></h1>
    <?php
    if (strpos($this->status_code, '4') === 0) {
        echo '<h4>Client Error</h4>';
    } else if (strpos($this->status_code, '5') === 0) {
        echo '<h4>Internal Server Error</h4>';
    }
    echo '<h5>' . h($this->msg) . '</h5>';

    ?>

    <img src="http://http.cat/<?= $this->status_code ?>" class="center-align">
</div>