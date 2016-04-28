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
    /**
     * returns an instance of a sqlite connection
     * 
     * @return mysqli instance of this class
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_PORT);
        }
        return self::$instance;
    }


    /**
     * DBConnector constructor.
     */
    private function __construct(){}


}