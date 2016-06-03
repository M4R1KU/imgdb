<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 31.05.2016
 * Time: 23:01
 */

namespace MKWeb\ImgDB\Model;


class Tag extends Model {

    private $id;
    private $name;

    /**
     * Tag constructor.
     * @param null $id
     * @param null $name
     */
    public function __construct($id = null, $name = null)
    {
        parent::__construct(__CLASS__);
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * if $tag is already instance of Tag it will return $com
     * if it is an array it will create a new Tag object
     * @param $tag
     * @return Tag|static
     */
    public static function constructTag($tag) {
        if ($tag instanceof Tag) {
            return $tag;
        }
        else if (is_array($tag)) {
            return new static($tag['tag_id'], $tag['name']);
        }
        else return null;
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @return bool
     */
    public function create() {
        $query = $this->connection->prepare("INSERT INTO Tag (name) VALUES (?)");
        $query->bind_param('s', $this->name);
        if (!$query->execute()) return false;
        $this->id = $this->connection->insert_id;
        return true;
    }

    public function deleteById($id) {
        $query = $this->connection->prepare("DELETE FROM Tag WHERE tag_id = ?");
        $query->bind_param('i', intval($id));
        return $this->exec($query);
    }

    public function delete() {
        return $this->deleteById($this->id);
    }

    public function exists($name = null) {
        if ($name === null) {
            $name = $this->name; 
        } else {
            $this->name = $name;
        }
        $query = $this->connection->prepare("SELECT * FROM Tag WHERE name = ?");
        $query->bind_param('s', $name);
        if (!$result = $this->readAllOrSingle($query)) {
            return false;
        } else {
            $this->id = isset($result['tag_id']) ? $result['tag_id'] : $result[0]['tag_id'];
            return true;
        }
    }

    /**
     * return an array with every Tag in it which are available in the database
     *
     * @return array
     */
    public function readAll() {
        $res = parent::readAll();
        $out = [];
        foreach ($res as $tag) {
            $out[] = $this->constructTag($tag);
        }
        return $out;

    }


    /**
     * returns the Tag with the given id
     *
     * @param $id
     * @return Tag
     */
    public function readById($id)
    {
        return $this->constructTag(parent::readById($id));
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
    
    


}