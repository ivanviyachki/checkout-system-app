<?php 

declare(strict_types = 1);

namespace Checkout_System;

require_once('config.php');

/**
 * Class responsible for the establishment and closure of a database connection.
 */
class Database 
{
    /**
	 * Database username
	 *
	 * @var string
	 */
    private string $user;

    /**
	 * Database password.
	 *
	 * @var string
	 */
    private string $password;

    /**
	 * Database host.
	 *
	 * @var string
	 */
    private string $host;

    /**
	 * Database name.
	 *
	 * @var string
	 */
    private string $database;

    public function __construct()
    {
        $this->user = DB_USER;
        $this->password = DB_PASSWORD;
        $this->host = DB_HOST;
        $this->database = DB_NAME;
    }

    /**
     * Method used to return database connection
     *
     * @return object MySQLi 
     */
    protected function connect(): object
    {
        $mysqli = new \MySQLi($this->host, $this->user, $this->password, $this->database);

        return $mysqli;
    }
}