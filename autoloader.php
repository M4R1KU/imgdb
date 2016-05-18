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
    "MKWeb\\ImgDB\\Controller\\IndexController" => ROOT . "/Controller/IndexController.php",
    "MKWeb\\ImgDB\\Controller\\LoginController" => ROOT . "/Controller/LoginController.php",
    "MKWeb\\ImgDB\\Controller\\NotFoundController" => ROOT . "/Controller/NotFoundController.php",

    "MKWeb\\ImgDB\\Model\\Model" => ROOT . "/Model/Model.php",
    "MKWeb\\ImgDB\\Model\\User" => ROOT . "/Model/User.php",
    //"\\MKWeb\\ImgDB\\Model\\Model" => ROOT . "/Model/Model.php"
    
    "MKWeb\\ImgDB\\View\\View" => ROOT . "/View/View.php",
    
    "MKWeb\\ImgDB\\Network\\Request" => ROOT . "/Network/Request.php",
    "MKWeb\\ImgDB\\Network\\Response" => ROOT . "/Network/Response.php",
    "MKWeb\\ImgDB\\Network\\Dispatcher" => __DIR__ . "/Network/Dispatcher.php",
    "MKWeb\\ImgDB\\Network\\ControllerResolver" => ROOT . "/Network/ControllerResolver.php"
];

/**
 * @param $className
 */
function __autoload($className) {
    print_r($className);
    print_r(classes);
    $map = classes;
    if (isset($map[$className])) {
        /** @noinspection PhpIncludeInspection */
        require(classes[$className]);

        return true;
    } else {
        throw new Exception("Unknown Class " . $className);
    }
}