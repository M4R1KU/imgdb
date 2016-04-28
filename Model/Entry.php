<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 21.11.2015
 * Time: 14:52
 */
class Entry extends Model {

    private $id;
    private $blog;
    private $title;
    private $content;
    private $date;
    private $category;

    public function __construct($id = null, $title = null, $content = null, $date = null, $blog = null, $category = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->date = $date;
        $this->blog = Blog::constructBlogByID($blog);
        $this->category = Category::constructCatByID($category);
    }

    /**
     * if $entry is already instance of Entry it will return $com
     * if it is an array it will create a new Entry objcet
     *
     * @param $entry
     * @return Entry object
     */
    public static function constructEntry($entry) {
        if ($entry instanceof Entry) {
            return $entry;
        }
        else if (is_array($entry)) {
            return new static($entry['entry_id'], $entry['title'], $entry['content'], $entry['date'], $entry['id_blog'], $entry['id_category']);
        }
    }

    /**
     * constructs new object from database with the the id $id
     *
     * @param $id
     * @return Entry
     */
    public static function constructEntryByID($id) {
        $query = "SELECT * FROM Entry WHERE entry_id = " . intval($id);
        $res = parent::select($query);
        if ($res) {
            return self::constructEntry($res[0]);
        }
    }


    /**
     * gets all entries by the blog wich is given
     *
     * @param mixed $blog
     * @return array all entries
     */
    public function getByBlog($blog) {
        $id = ($blog instanceof Blog) ? $blog->getId() : $blog;

        $query = "SELECT * FROM Entry WHERE id_blog = " . intval($id) . " ORDER BY date DESC";
        $res = parent::select($query);
        if ($res) {
            $out = array();
            foreach ($res as $row) {
                $e = self::constructEntry($row);
                $out[] = $e;
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
        $query = "INSERT INTO Entry (id_blog, title, content, date, id_category) VALUES ('". $this->blog->getId() . "', '". $this->title . "', '". $this->content ."', '". $this->date ."', '". $this->category->getId() ."')";
        $res = parent::query($query);
        if ($res) {
            $this->id = parent::getLastId();
            return true;
        }
    }

    /**
     * updates the current object
     * with the values of the instancevariables
     *
     * @return bool
     */
    public function update() {
        $query = "UPDATE Entry SET title='" . $this->title . "', content='" . $this->content . "', id_category=" . intval($this->category->getId()) . " WHERE entry_id = " . intval($this->id);
        $res = parent::query($query);
        if ($res) {
             return true;
        }
    }

    /**
     * deletes the entry object with the id wich is given
     *
     * @param $id int id of object to delete
     * @return bool
     */
    public static function deleteById($id) {
        $comments = Comment::getByEntry($id);
        if ($comments !== null) {
            foreach ($comments as $c) {
                Comment::deleteById($c->getId());
            }
        }
        $query = "DELETE FROM Entry WHERE entry_id = '" . intval($id) . "'";
        $res = parent::query($query);
        if ($res) {
            return true;
        }
    }


    /**
     * sets $this->blog with a blog object where the id is $id
     *
     * @param $id
     */
    public function setBlogById($id) {
        $this->blog = Blog::constructBlogByID($id);
    }

    /**
     * sets $this->category with a category object where the id is $id
     *
     * @param $id
     */
    public function setCatById($id) {
        $this->category = Category::constructCatByID($id);
    }

    public function getId() {
        return $this->id;
    }

    public function getBlog() {
        return $this->blog;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date = null) {
        $this->date = is_null($date) || $date === 'now' ? date('Y.m.d') : $date;

    }

    public function getCategory() {
        return $this->category;
    }

}
