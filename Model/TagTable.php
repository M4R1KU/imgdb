<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 31.05.2016
 * Time: 23:01
 */

namespace MKWeb\ImgDB\Model;


use MKWeb\ImgDB\Model\Entity\Tag;

class TagTable extends Model implements Table {
    /**
     * TagTable constructor.
     */
    public function __construct() {
        parent::__construct(Tag::class);
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
            return new Tag($tag['tag_id'], $tag['name']);
        }
        else return null;
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @param Tag $tag
     * @return bool|Tag
     */
    public function create($tag) {
        $query = $this->connection->prepare("INSERT INTO tag (name) VALUES (?)");
        $query->bind_param('s', $tag->getName());
        if (!$query->execute()) return false;
        $tag->setId($this->connection->insert_id);
        return $tag;
    }

    public function deleteById($id) {
        $query = $this->connection->prepare("DELETE FROM tag WHERE tag_id = ?");
        $query->bind_param('i', intval($id));
        return $this->exec($query);
    }

    /**
     * @param Tag $tag
     * @return bool
     */
    public function delete($tag) {
        return $this->deleteById($tag->getId());
    }

    public function exists($name) {
        $query = $this->connection->prepare("SELECT * FROM tag WHERE name = ?");
        $query->bind_param('s', $name);
        if (!$result = $this->readAllOrSingle($query)) {
            return false;
        } else {
            return self::constructTag($result);
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


}