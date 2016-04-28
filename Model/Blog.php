<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 21.11.2015
 * Time: 14:53
 */
class Blog extends Model {

    private $id;
    private $user;
    private $name;

    public function __construct($user = null, $id = null, $name = null) {
        $this->user = User::constructUserByID($user);
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * if $blog is already instance of Blog it will return $com
     * if it is an array it will create a new Blog objcet
     *
     * @param $blog
     * @return Blog object
     */
    public static function constructBlog($blog) {
        if ($blog instanceof Blog) {
            return $blog;
        }
        else if (is_array($blog)) {
            return new static($blog['id_user'], $blog['blog_id'], $blog['name']);
        }
    }

    /**
     * gets all rows of the table
     * @return array
     */
    public function getAll() {
        $query = "SELECT * FROM Blog";
        $res = parent::select($query);
        if ($res) {
            $out = array();
            foreach($res as $row) {
                $b = self::constructBlogByID($row['blog_id']);
                $out[] = $b;
            }
            return $out;
        }
    }

    /**
     * constructs new object from database with the the id $id
     *
     * @param $id
     * @return Blog
     */
    public static function constructBlogByID($id) {
        $query = "SELECT * FROM Blog WHERE blog_id = " . intval($id);
        $res = parent::select($query);
        if ($res) {
            return self::constructBlog($res[0]);
        }
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO Blog (name, id_user) VALUES ('". $this->name . "', '". $this->user->getId(). "')";
        $res = parent::query($query);
        if ($res) {
            $this->id = parent::getLastId();
            return true;
        }
    }

    /**
     * sets $this->user with a user object where the id is $id
     *
     * @param $id
     */
    public function setUserById($id) {
        $this->user = User::constructUserByID($id);
    }

    public function getUser() {
        return $this->user;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

}
