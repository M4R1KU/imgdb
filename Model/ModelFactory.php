<?php
require_once('Model.php');

class ModelFactory {

    public static function createModel($name) {
        return new $name();
    }

}

 ?>
