<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 08.06.2016
 * Time: 22:42
 */

namespace MKWeb\ImgDB\Model\Entity;


class Tag extends Entity{

    private $name;

    /**
     * Tag constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}