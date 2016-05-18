<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 21.11.2015
 * Time: 14:52
 */
namespace MKWeb\ImgDB\Model\User;

use MKWeb\ImgDB\lib\DBConnector;
use MKWeb\ImgDB\Model\Model;

class User extends Model {

    private $id;
    private $email;
    private $nickname;
    private $password;


    public function __construct($id = null, $email = null, $nickname = null, $password = null) {
        parent::__construct('user');
        $this->id = $id;
        $this->email = $email;
        $this->nickname = $nickname;
        $this->password = $password;
    }

    /**
     * if $user is already instance of User it will return $com
     * if it is an array it will create a new User objcet
     *
     * @param $user
     * @return User object
     */
    public static function constructUser($user) {
        if ($user instanceof User) {
            return $user;
        }
        else if (is_array($user)) {
            return new static($user['user_id'], $user['email'], $user['nickname'], $user['password']);
        }
    }

    /**
     * constructs new object from database with the the id $id
     *
     * @param $id
     * @return User
     */
    public static function constructUserByID($id) {
        $query = DBConnector::getInstance()->prepare('SELECT * FROM User WHERE user_id = ?');
        $query->bind_param('i', intval($id));
        $res = parent::readAllOrSingle($query);
        return $res;
    }

    /**
     * gets user object where the email is like the given string
     *
     * @param mixed $email
     * @return User
     */
    public function constructUserByEmail($email = null) {
        $e = (is_null($email)) ? $this->email : $email;
        $query = $this->connection->prepare("SELECT * FROM User WHERE email like ?");
        $query->bind_param('s', $e);
        $res = $this->readAllOrSingle($query);
        return self::constructUser($res);
        
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @return bool
     */
    public function create() {
        $query = $this->connection->prepare("INSERT INTO User (email, nickname, password) VALUES (?, ?, ?)");
        $query->bind_param('sss', $this->email, $this->nickname, password_hash($this->password, PASSWORD_BCRYPT));
        if (!$query->execute()) return false;
        $this->id = $this->connection->insert_id;
        return true;

    }
    
    public function checkLogin($password) {
        return password_verify($password, $this->getPassword());
    }


    /**
     * checks if the email wich is given is unique
     *
     * @param $email String
     * @return bool
     */
    public function isUniqueEmail($email) {
        $db = DBConnector::getInstance();
        $query = $db->prepare("SELECT user_id FROM User where email like ?");
        $query->bind_param('s', $email);
        $res = $this->readAllOrSingle($query);
        return empty($res);
    }

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
     * @param $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

}
