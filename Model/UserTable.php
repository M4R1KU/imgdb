<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 21.11.2015
 * Time: 14:52
 */
namespace MKWeb\ImgDB\Model;

use MKWeb\ImgDB\Model\Entity\User;

class UserTable extends Model implements Table {
    /**
     * UserTable constructor.
     */
    public function __construct() {
        parent::__construct(User::class);
    }
    
    /**
     * if $user is already instance of User it will return $com
     * if it is an array it will create a new User objcet
     *
     * @param $user
     * @return User object
     */
    public function constructUser($user) {
        if ($user instanceof User) {
            return $user;
        }
        else if (is_array($user)) {
            return new User($user['user_id'], $user['email'], $user['nickname'], $user['password']);
        }
        else return null;
    }
    

    /**
     * gets user object where the email is like the given string
     *
     * @param mixed $email
     * @return User
     */
    public function constructUserByEmail($email) {
        $query = $this->connection->prepare("SELECT * FROM user WHERE email like ?");
        $query->bind_param('s', $email);
        $res = $this->readAllOrSingle($query);
        return $this->constructUser($res);
        
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @param User $user
     * @return bool|User
     */
    public function create($user) {
        $query = $this->connection->prepare("INSERT INTO user (email, nickname, password) VALUES (?, ?, ?)");
        $query->bind_param('sss', $user->getEmail(), $user->getNickname(), password_hash($user->getPassword(), PASSWORD_BCRYPT));
        if (!$query->execute()) return false;
        $user->setId($this->connection->insert_id);
        return $user;
    }

    /**
     * @param $pw
     * @param User $user
     * @return bool
     */
    public function checkLogin($pw, $user) {
        return password_verify($pw, $user->getPassword());
    }


    /**
     * checks if the email which is given is unique
     *
     * @param $email String
     * @return bool
     */
    public function isUniqueEmail($email) {
        $query = $this->connection->prepare("SELECT user_id FROM user where email like ?");
        $query->bind_param('s', $email);
        $res = $this->readAllOrSingle($query);
        return empty($res);
    }

    /**
     * @return array
     */
    public function readAll() {
        $res = parent::readAll();
        $out = [];
        foreach ($res as $user) {
            $out[] = $this->constructUser($user);
        }
        return $out;
        
    }

    /**
     * @deprecated
     * @param $id
     * @return User
     */
    public function readById($id)
    {
        return $this->constructUser(parent::readById($id));
    }

    function delete($object)
    {
        return false;
    }

    /**
     * @deprecated
     * @param $id
     * @return bool
     */
    function deleteById($id)
    {
        return false;
    }
}
