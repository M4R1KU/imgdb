<?php

namespace MKWeb\ImgDB\Model;

use MKWeb\ImgDB\lib\DBConnector;

class Model {

    protected $currentTable;
	protected $connection;

    /**
     * Model constructor.
     * @param $currentTable
     */
	public function __construct($currentTable)
	{
        $this->currentTable = ucfirst(str_replace(__NAMESPACE__ . '\\', '', $currentTable));
		$this->connection = DBConnector::getInstance();
	}

    /**
     * If there is only one result, return the result
     * If there are multiple lines, read them all into an array and return
     *
     * @param $statementOrQuery string|\mysqli_stmt String or prepared statement
     * @return array|null
     */
    protected function readAllOrSingle($statementOrQuery)
    {
        if (is_string($statementOrQuery)) {
            $result = $this->connection->query($statementOrQuery);
        } else if (is_object($statementOrQuery) && is_a($statementOrQuery, 'mysqli_stmt')) {
            /** @var \mysqli_stmt $statementOrQuery */
            if ($statementOrQuery->execute())
                $result = $statementOrQuery->get_result();
            else
                return null;
        }

        $rows = array();
        /** @var \mysqli_result $result */
        if ($result->num_rows === 1)
            return $result->fetch_assoc();

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }
    
    protected function exec(\mysqli_stmt $query) {
        return $query->execute();
    }

    public function readAll() {
        $query = "SELECT * FROM {$this->currentTable}";
        return $this->connection->query($query);
    }

    public function readById($id) {
        $str = "SELECT * FROM {$this->currentTable} WHERE {$this->currentTable}_id = ?";
        $query = $this->connection->prepare($str);
        $query->bind_param('i', intval($id));
        return $this->readAllOrSingle($query);

    }
}

 ?>
