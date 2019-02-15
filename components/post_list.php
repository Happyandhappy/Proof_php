<?php

$query = "SELECT posting.*, images.url, users.username FROM posting LEFT JOIN images on posting.id=images.postid LEFT JOIN users on posting.userid=users.id ORDER BY posting.timestamps DESC";
$result = $mysqli->query($query);
if ($result){
    $data = [];
    $images = [];
    $postid = NULL;
    $lastrow = NULL;

    while($row = $result->fetch_assoc()){			
        if (!isset($postid)) $postid = $row['id'];
        if ($postid !== $row['id']){
            array_push($data, array(
                'postid'  => $postid,
                'username' => $lastrow['username'],
                'userid'  => $lastrow['userid'],
                'content' => $lastrow['content'],
                "timestamps" => $lastrow['timestamps'],
                "images" => $images
            ));
            $postid = $row['id'];
            $images = [];
        }			
        if ($row['url'] != NULL)array_push($images, $row['url']);
        $lastrow = $row;
    }
    if (isset($lastrow)){
        array_push($data, array(
            'postid'  => $lastrow['id'],
            'username' => $lastrow['username'],
            'userid'  => $lastrow['userid'],
            'content' => $lastrow['content'],
            "timestamps" => $lastrow['timestamps'],
            "images" => $images
        ));
    }
}