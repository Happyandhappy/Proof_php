<?php
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "pos");
$ip = getenv('REMOTE_ADDR', true) ?: getenv('REMOTE_ADDR');
define("HOST",  "http://" . $ip);

$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME, 3306);
if ($mysqli->connect_errno) {
    echo "Database Connection Error.";
    exit;
}