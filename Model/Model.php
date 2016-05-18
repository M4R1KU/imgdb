<?php
require_once('lib/DBConnector.php');
require_once('Model/User.php');

class Model {

    protected $currentTable;
	protected $connection;

	/**
	 * Model constructor.
	 */
	public function __construct($currentTable)
	{
        $this->currentTable = $currentTable;
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

    public function readById($id) {
        $query = $this->connection->prepare("SELECT * FROM {$this->currentTable} WHERE {$this->currentTable}_id = ?");
        $query->bind_param('i', $id);
        
    }
}

 ?>
