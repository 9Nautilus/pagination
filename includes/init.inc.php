<?php
/***********************************
 | Class name  : init.inc.php      |
 | Last Modify : Sep 2012          |
 | By          : Narong Rammanee   |
 | E-mail      : ranarong@live.com |
 ***********************************/

// Include database configuration
require_once dirname(__FILE__) . '/dbconfig.inc.php';

// Document root
define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']);

// Define project name.
define(PROJ_NAME, '/thaiphpdev/demos/php-classes/pagination/');

// Data source name..
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

// Default charset.
$charset = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

try {
    // Connect to postgres object databse.
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $charset);
} catch(PDOException $e) {
    // If can't connect display error message
    throw new PDOException(
        '<pre class="error"><h1>Connection failed:</h1> ' . $e . '</pre>'
    );
}

// Automatically called in case you are trying to use a class.
function __autoload($classname) 
{
    // Class file path.
    $filepath = DOC_ROOT . PROJ_NAME . '/classes/' . $classname . '.class.php';
    if(file_exists($filepath)) {
        // Include class file.
        include $filepath;
    } else {
        // If can't load class display error message.
        throw new Exception(
            '<pre class="error"><h1>Unable to load:</h1> ' . $filepath . '</pre>'
        );
    }
}
