<?php

/**
 * Model for Comment Table
 *
 * @author Mario Kunz
 */
class Comment extends Model {


        private $id;
        private $entry;
        private $user;
        private $comment;

        public function __construct($id = null, $entry = null, $user = null, $comment = null) {
            $this->id = $id;
            $this->user = User::constructUserByID($user);
            $this->entry = Entry::constructEntryByID($entry);
            $this->comment = $comment;
        }

        /**
         * if $com is already instance of Comment it will return $com
         * if it is an array it will create a new Comment objcet
         *
         * @param $com
         * @return Comment object
         */
        public static function constructCom($com) {
            if ($com instanceof Comment) {
                return $com;
            }
            else if (is_array($com)) {
                return new static($com['comment_id'], $com['id_entry'], $com['id_user'], $com['comment']);
            }
        }

        /**
         * constructs new object from database with the the id $id
         *
         * @param $id
         * @return Comment
         */
        public static function constructComByID($id) {
            $query = "SELECT * FROM Comment WHERE comment_id = " . intval($id);
            $res = parent::select($query);
            if ($res) {
                return self::constructCom($res[0]);
            }
        }

        /**
        * gets all comments by the entry wich is given
        *
        * @param mixed $entry
        * @return array all comment
        */
        public static function getByEntry($entry) {
            $id = ($entry instanceof Entry) ? $entry->getId() : $entry;

            $query = "SELECT * FROM Comment WHERE id_entry = " . intval($id);
            $res = parent::select($query);
            if ($res) {
                $out = array();
                foreach ($res as $row) {
                    $e = self::constructCom($row);
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
            $query = "INSERT INTO Comment (id_entry, id_user, comment) VALUES ('" . $this->entry->getId() . "', '" . $this->user->getId() . "', '" . $this->comment . "')";
            $res = parent::query($query);
            if ($res) {
                $this->id = parent::getLastId();
                return true;
            }
        }

        /**
         * deletes the comment with the id $id
         *
         * @param int $id
         * @return bool
         */
        public static function deleteById($id) {
            $query = "DELETE FROM Comment WHERE comment_id = '" . intval($id) . "'";
            $res = parent::query($query);
            return $res;
        }

        /**
         * updates the current object
         *
         * @return mixed
         */
        public function update() {
            $query = "UPDATE Comment SET comment='" . $this->comment . "' WHERE comment_id = " . intval($this->id);
            $res = parent::query($query);
            return $res;
        }

        /**
         * sets $this->entry with a entry object where the id is $id
         *
         * @param $id
         */
        public function setEntryById($id) {
            $this->entry = Entry::constructEntryByID($id);
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

        public function getEntry() {
            return $this->entry;
        }

        public function getComment() {
            return $this->comment;
        }

        public function setComment($comment) {
            $this->comment = $comment;
        }

        public function getId() {
            return $this->id;
        }

}
