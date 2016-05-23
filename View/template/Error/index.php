<div class="row">
    <h1>Error: <?= $this->status_code ?></h1>
    <?php
    if (strpos($this->status_code, '4') === 0) {
        echo '<h5>Client Error</h5>';
    } else if (strpos($this->status_code, '5') === 0) {
        echo '<h5>Internal Server Error</h5>';
    }
    ?>
    <img src="http://http.cat/<?= $this->status_code ?>" class="center-align">
</div>