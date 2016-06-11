<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 11.06.2016
 * Time: 17:27
 */

namespace MKWeb\ImgDB\Model;


interface Table
{
    function create($object);
    function readAll();
    function readById($id);
    function delete($object);
    function deleteById($id);
}