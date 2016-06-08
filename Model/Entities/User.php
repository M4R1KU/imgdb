<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 08.06.2016
 * Time: 22:40
 */

namespace MKWeb\ImgDB\Model\Entity;


class User extends Entity{

    private $email;
    private $nickname;
    private $password;

    /**
     * User constructor.
     * @param $id
     * @param $email
     * @param $nickname
     * @param $password
     */
    public function __construct($id, $email, $nickname, $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->nickname = $nickname;
        $this->password = $password;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    

}