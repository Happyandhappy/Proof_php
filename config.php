<?php
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "password");
define("DBNAME", "pos");
define("HOST",  "http://34.227.61.129");
define("REMOTE", '54.91.26.122');

$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME, 3306);
if ($mysqli->connect_errno) {
    echo "Database Connection Error.";
    exit;
}