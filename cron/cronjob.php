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

$curl = curl_init(REMOTE . "/api.php");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
$res = curl_exec($curl);
curl_close($curl);

$data = json_decode($res);

foreach ($data as $row) {
    $query1 = "INSERT INTO `rposting` (id, userid, content, timestamps) VALUES (" . $row->postid . "," . $row->userid . ",'" . $mysqli->real_escape_string($row->content) . "','" . $row->timestamps . "')";
    $mysqli->query($query1);
    foreach ($row->images as $image) {
        $query2 = "INSERT INTO `rimages` (id, postid, url, timestamps) VALUES (" . $image->id . "," . $row->postid . ",'" . $image->url . "','" . $row->timestamps . "')";
        $mysqli->query($query2);
    }
}