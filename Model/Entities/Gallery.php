<?php


/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 08.06.2016
 * Time: 22:40
 */

namespace MKWeb\ImgDB\Model\Entity;

class Gallery extends Entity{
    
    private $name;
    private $description;
    /**
     * @var User
     */
    private $user;
    private $private;

    /**
     * Gallery constructor.
     * @param $id
     * @param $name
     * @param $description
     * @param User $user
     * @param $private
     */
    public function __construct($id, $name, $description, User $user, $private)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->user = $user;
        $this->private = $private;
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

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    

    /**
     * @param mixed $private
     */
    public function setPrivate($private)
    {
        $this->private = $private;
    }

    public function isPrivate() {
        return $this->private;
    }


}