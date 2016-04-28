<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 21.11.2015
 * Time: 14:53
 */
class Category extends Model {

    private $id;
    private $name;

    public function __construct($id = null, $name = null) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * if $cat is already instance of Category it will return $com
     * if it is an array it will create a new Category objcet
     *
     * @param $cat
     * @return Category object
     */
    public static function constructCat($cat) {
        if ($cat instanceof User) {
            return $cat;
        }
        else if (is_array($cat)) {
            return new static($cat['category_id'], $cat['name']);
        }
    }


    /**
     * constructs new object from database with the the id $id
     *
     * @param $id
     * @return Category
     */
    public static function constructCatByID($id) {
        $query = "SELECT * FROM Category WHERE category_id = " . intval($id);
        $res = parent::select($query);
        if ($res) {
            return self::constructCat($res[0]);
        }
    }

    /**
     * gets all rows of the table
     * @return array
     */
    public function getAll() {
        $query = "SELECT * FROM Category";
        $res = parent::select($query);
        if ($res) {
            $out = array();
            foreach($res as $row) {
                $b = self::constructCatByID($row['category_id']);
                $out[] = $b;
            }
            return $out;
        }
    }


    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

}
