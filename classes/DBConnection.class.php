<?php
/**************************************
 | Class name  : DBConnection.inc.php |
 | Last Modify : Sep 2012             |
 | By          : Narong Rammanee      |
 | E-mail      : ranarong@live.com    |
 **************************************/

class DBConnection
{
    /**
     * Stores a debuger object
     *
     * @var object A debuger object
     */
    public $debug;

    /**
     * Stores a database object
     *
     * @var object A database object
     */
    public $db;

    /**
     * __construct — Initialization connect to database. 
     *
     * @param object $pdo a database object
     * @return No value is returned.
     */
    public function __construct( $pdo=null )
    {
        // Checks for a DB object or creates one if one isn't found
        if (is_object($pdo)) {
            $this->db = $pdo;
        } else {
            // Data source name.
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

            // Set Default charset.
            $charset = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            try {
                // Connect to postgres object databse
                $this->db = new PDO($dsn, DB_USER, DB_PASS, $charset);
            } catch (PDOException $e) {
                // If can't connect display error message
                throw new PDOException(
                    '<pre class="error"><h1>Connection failed:</h1> ' . $e->getMessage() . '</pre>'
                );
            }
        }
    }

    /**
     * __destruct — Database close connection
     * 
     * @return No value is returned.
     */
    public function __destruct( )
    {
        // Database disconnect
        if ( !empty($this->db) ) $this->db = null;
    }
}
