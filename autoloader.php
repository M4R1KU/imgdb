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
    "MKWeb\\ImgDB\\Controller\\GalleryController" => __DIR__ . "/Controller/GalleryController.php",
    "MKWeb\\ImgDB\\Controller\\ImageController" => __DIR__ . "/Controller/ImageController.php",
    "MKWeb\\ImgDB\\Controller\\ErrorController" => __DIR__ . "/Controller/ErrorController.php",
    "MKWeb\\ImgDB\\Controller\\AjaxController" => __DIR__ . "/Controller/AjaxController.php",

    "MKWeb\\ImgDB\\Model\\Model" => __DIR__ . "/Model/Model.php",
    "MKWeb\\ImgDB\\Model\\Table" => __DIR__ . "/Model/Table.php",
    "MKWeb\\ImgDB\\Model\\UserTable" => __DIR__ . "/Model/UserTable.php",
    "MKWeb\\ImgDB\\Model\\GalleryTable" => __DIR__ . "/Model/GalleryTable.php",
    "MKWeb\\ImgDB\\Model\\ImageTable" => __DIR__ . "/Model/ImageTable.php",
    "MKWeb\\ImgDB\\Model\\TagTable" => __DIR__ . "/Model/TagTable.php",
    "MKWeb\\ImgDB\\Model\\ImageTagTable" => __DIR__ . "/Model/ImageTagTable.php",
    "MKWeb\\ImgDB\\Model\\Ajax" => __DIR__ . "/Model/Ajax.php",

    "MKWeb\\ImgDB\\Model\\Entity\\Entity" => __DIR__ . "/Model/Entities/Entity.php",
    "MKWeb\\ImgDB\\Model\\Entity\\User" => __DIR__ . "/Model/Entities/User.php",
    "MKWeb\\ImgDB\\Model\\Entity\\Gallery" => __DIR__ . "/Model/Entities/Gallery.php",
    "MKWeb\\ImgDB\\Model\\Entity\\Image" => __DIR__ . "/Model/Entities/Image.php",
    "MKWeb\\ImgDB\\Model\\Entity\\Tag" => __DIR__ . "/Model/Entities/Tag.php",
    "MKWeb\\ImgDB\\Model\\Entity\\ImageTag" => __DIR__ . "/Model/Entities/ImageTag.php",
    
    
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
 * @return bool
 * @throws Exception
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