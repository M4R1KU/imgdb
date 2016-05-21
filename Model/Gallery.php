<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.05.2016
 * Time: 13:44
 */

namespace MKWeb\ImgDB\Model;


class Gallery extends Model
{

    private $id;
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
    public function __construct($id = null, $user = null, $name = null, $description = null, $private = null)
    {
        parent::__construct(__CLASS__);
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->user = $user;
        $this->private = $private;
    }

    /**
     * if $gallery is already instance of Gallery it will return $com
     * if it is an array it will create a new Gallery objcet
     *
     * @param $gallery
     * @return Gallery object
     */
    public static function constructGallery($gallery) {
        if ($gallery instanceof Gallery) {
            return $gallery;
        }
        else if (is_array($gallery)) {
            return new static($gallery['gallery_id'],(new User)->readById($gallery['id_user']), $gallery['name'], $gallery['description'], $gallery['private']);
        }
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @return bool
     */
    public function create() {
        $query = $this->connection->prepare("INSERT INTO Gallery (id_user, name, description, private) VALUES (?, ?, ?, ?)");
        $query->bind_param('issi', $this->user->getId(), $this->name, $this->description, $this->private);
        if (!$query->execute()) return false;
        $this->id = $this->connection->insert_id;
        return true;

    }

    /**
     * return an array with every gallery in it which are available in the database
     *
     * @return array
     */
    public function readAll() {
        $res = parent::readAll();
        $out = [];
        foreach ($res as $user) {
            $out[] = $this->constructGallery($user);
        }
        return $out;

    }


    /**
     * returns the gallery id with the given id
     *
     * @param $id
     * @return Gallery
     */
    public function readById($id)
    {
        return $this->constructGallery(parent::readById($id));
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param null $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return null
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * @param null $private
     */
    public function setPrivate($private)
    {
        $this->private = $private;
    }


    
    


}