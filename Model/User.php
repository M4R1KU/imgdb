<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 21.11.2015
 * Time: 14:52
 */

class User extends Model {

    private $id;
    private $email;
    private $nickname;
    private $password;


    public function __construct($id = null, $email = null, $nickname = null, $password = null) {
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
        $query = "SELECT * FROM User WHERE user_id = " . intval($id);
        $res = parent::select($query);
        if ($res) {
            return self::constructUser($res[0]);
        }
    }

    /**
     * gets user object where the email is like the given string
     *
     * @param mixed $email
     * @return User
     */
    public function constructUserByEmail($email = null) {
        $e = (is_null($email)) ? $this->email : $email;
        $query = "SELECT * FROM User WHERE email like '" . $e . "'";
        $res = parent::select($query);
        if ($res) {
            return self::constructUser($res[0]);
        }
    }

    /**
     * hashes the passwort given as parameter
     *
     * @param String $pw
     * @return String hashedpw
     */
    private static function hashPW($pw) {
        return hash('sha512', $pw);
    }

    /**
     * gets all rows of the table
     * @return array
     */
    public function getAll() {
        $query = "SELECT * FROM User";
        $res = parent::select($query);
        if ($res) {
            $out = array();
            foreach($res as $row) {
                $b = self::constructBlogByID($row['user_id']);
                $out[] = $b;
            }
            return $out;
        }
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO User (email, nickname, password) VALUES ('". $this->email . "', '". $this->nickname. "', '". $this->password ."')";
        $res = parent::query($query);
        if ($res) {
            $this->id = parent::getLastId();
            return true;
        }
    }

    /**
     *  checks if the email and the password is the same
     *
     * @return boolean
     */
    public function _equals($user) {
        return $user->getEmail() == $this->email && $user->getPassword() == $this->password;
    }

    /**
     * checks if the email wich is given is unique
     *
     * @param $email String
     * @return bool
     */
    public function isUniqueEmail($email) {
        $query = "SELECT user_id FROM User where email like '" . $email . "'";
        $res = parent::select($query);
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
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $this->hashPW($password);
    }



}
