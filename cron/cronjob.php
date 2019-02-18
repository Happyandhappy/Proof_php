<?php
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "pos");
define("HOST", "localhost/proof");
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

$splits = explode('||', $res);

$postingStr = $splits[0];

$usersStr = $splits[1];
$data = json_decode($postingStr);

foreach ($data as $row) {
    $query1 = "INSERT INTO `rposting` (id, userid, content, timestamps) VALUES (" . $row->postid . "," . $row->userid . ",'" . $mysqli->real_escape_string($row->content) . "','" . $row->timestamps . "')";
    $mysqli->query($query1);
    foreach ($row->images as $image) {
        $query2 = "INSERT INTO `rimages` (id, postid, url, timestamps) VALUES (" . $image->id . "," . $row->postid . ",'" . $image->url . "','" . $row->timestamps . "')";
        $mysqli->query($query2);
    }
}

$data = json_decode($usersStr);
foreach ($data as $row) {
    $query = "INSERT INTO `rusers` (id, username, email, `password`, created_at) VALUES ( " . $row->id . ",'" . $row->username . "','" . $row->email . "','" . $row->password . "','" . $row->created_at . "')";
    $mysqli->query($query);
}