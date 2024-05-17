<?php
// Database configuration
define('DB_SERVER', 'localhost:3360'); // Database server
define('DB_USERNAME', 'root'); // Database username
define('DB_PASSWORD', ''); // Database password
define('DB_NAME', 'lib'); // Database name

// Attempt to connect to the database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
