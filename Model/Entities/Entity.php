<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 08.06.2016
 * Time: 22:46
 */

namespace MKWeb\ImgDB\Model\Entity;


class Entity {

    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



}