<?php

/**
 * handles the connection to the Database
 * 
 * the class follows the singleton pattern
 * @author Mario Kunz
 *
 */
class DBConnector
{

    static private $instance;
    static private $dbfile = 'DB/weblog.db';


    /**
     * returns an instance of a sqlite connection
     * 
     * @return instance of this class
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new SQLite3(self::$dbfile);
        }
        return self::$instance;
    }


    /**
     * DBConnector constructor.
     */
    private function __construct(){}


}