<?php
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "pos");
define("REMOTE", "http://" . $_SERVER['SERVER_NAME']);

$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME, 3306);
if ($mysqli->connect_errno) {
    echo "Database Connection Error.";
    exit;
}