<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 18.05.2016
 * Time: 20:05
 * 
 * 
 * featured by Joel Messerli
 * 
 **/

const classes = [
    "MKWeb\\ImgDB\\Controller\\Controller" => __DIR__ . "/Controller/Controller.php",
    "MKWeb\\ImgDB\\Controller\\IndexController" => __DIR__ . "/Controller/IndexController.php",
    "MKWeb\\ImgDB\\Controller\\LoginController" => __DIR__ . "/Controller/LoginController.php",
    "MKWeb\\ImgDB\\Controller\\NotFoundController" => __DIR__ . "/Controller/NotFoundController.php",

    "MKWeb\\ImgDB\\Model\\Model" => __DIR__ . "/Model/Model.php",
    "MKWeb\\ImgDB\\Model\\User" => __DIR__ . "/Model/User.php",
    //"\\MKWeb\\ImgDB\\Model\\Model" => ROOT . "/Model/Model.php"
    
    "MKWeb\\ImgDB\\View\\View" => __DIR__ . "/View/View.php",
    
    "MKWeb\\ImgDB\\Network\\Request" => __DIR__ . "/Network/Request.php",
    "MKWeb\\ImgDB\\Network\\Response" => __DIR__ . "/Network/Response.php",
    "MKWeb\\ImgDB\\Network\\Dispatcher" => __DIR__ . "/Network/Dispatcher.php",
    "MKWeb\\ImgDB\\Network\\ControllerResolver" => __DIR__ . "/Network/ControllerResolver.php",

    "MKWeb\\ImgDB\\lib\\DBConnector" => __DIR__ . "/lib/DBConnector.php",

    "MKWeb\\ImgDB\\Util\\Validator" => __DIR__ . "/util/Validator.php"
];

/**
 * @param $className
 */
function __autoload($className) {
    $map = classes;
    if (isset($map[$className])) {
        /** @noinspection PhpIncludeInspection */
        require(classes[$className]);

        return true;
    } else {
        throw new Exception("Unknown Class " . $className);
    }
}