<?php
require_once('lib/DBConnector.php');
require_once('Model/Blog.php');
require_once('Model/Category.php');
require_once('Model/Comment.php');
require_once('Model/Entry.php');
require_once('Model/User.php');

class Model {

	public static function query($query) {
		$db = DBConnector::getInstance();
		if ($db) {
			$res = $db->query($query);
			return $res;
		}
	}

	public static function select($query) {
		$db = DBConnector::getInstance();
		$out = array();
		if ($db) {
			$result = $db->query($query);
			while ($row = $result->fetchArray(SQLITE3_BOTH)) {
		    	$out[] = $row;
			}
		}
		return $out;
	}

	public static function getLastId() {
		return DBConnector::getInstance()->lastInsertRowID();
	}

}

 ?>
