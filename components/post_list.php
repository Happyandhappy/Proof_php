<?php

$query = "SELECT posting.*, images.url, users.username FROM posting LEFT JOIN images on posting.id=images.postid LEFT JOIN users on posting.userid=users.id ORDER BY posting.timestamps DESC";
$result = $mysqli->query($query);
if ($result) {
    $data = [];
    $images = [];
    $postid = null;
    $lastrow = null;

    while ($row = $result->fetch_assoc()) {
        if (!isset($postid)) {
            $postid = $row['id'];
        }

        if ($postid !== $row['id']) {
            array_push($data, array(
                'postid' => $postid,
                'username' => $lastrow['username'],
                'userid' => $lastrow['userid'],
                'content' => $lastrow['content'],
                "timestamps" => $lastrow['timestamps'],
                "images" => $images,
                "type" => "origin",
            ));
            $postid = $row['id'];
            $images = [];
        }
        if ($row['url'] != null) {
            array_push($images, $row['url']);
        }

        $lastrow = $row;
    }
    if (isset($lastrow)) {
        array_push($data, array(
            'postid' => $lastrow['id'],
            'username' => $lastrow['username'],
            'userid' => $lastrow['userid'],
            'content' => $lastrow['content'],
            "timestamps" => $lastrow['timestamps'],
            "images" => $images,
            "type" => "origin",
        ));
    }
}

$query = "SELECT rposting.*, rimages.url, rusers.username FROM rposting LEFT JOIN rimages on rposting.id=rimages.postid LEFT JOIN rusers on rposting.userid=rusers.id ORDER BY rposting.timestamps DESC";
$result = $mysqli->query($query);
if ($result) {
    $images = [];
    $postid = null;
    $lastrow = null;

    while ($row = $result->fetch_assoc()) {
        if (!isset($postid)) {
            $postid = $row['id'];
        }

        if ($postid !== $row['id']) {
            array_push($data, array(
                'postid' => $postid,
                'username' => $lastrow['username'],
                'userid' => $lastrow['userid'],
                'content' => $lastrow['content'],
                "timestamps" => $lastrow['timestamps'],
                "images" => $images,
                "type" => "remote",
            ));
            $postid = $row['id'];
            $images = [];
        }
        if ($row['url'] != null) {
            array_push($images, $row['url']);
        }

        $lastrow = $row;
    }
    if (isset($lastrow)) {
        array_push($data, array(
            'postid' => $lastrow['id'],
            'username' => $lastrow['username'],
            'userid' => $lastrow['userid'],
            'content' => $lastrow['content'],
            "timestamps" => $lastrow['timestamps'],
            "images" => $images,
            "type" => "remote",
        ));
    }
}
// Sort by Timestamps
$timestamps = array();
foreach ($data as $key => $row) {
    $timestamps[$key] = $row['timestamps'];
}
array_multisort($timestamps, SORT_DESC, $data);