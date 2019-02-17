<?php
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "password");
define("DBNAME", "pos");
define("HOST",  "http://" . $_SERVER['SERVER_NAME']);
define("REMOTE", '54.91.26.122');

$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME, 3306);
if ($mysqli->connect_errno) {
    echo "Database Connection Error.";
    exit;
}