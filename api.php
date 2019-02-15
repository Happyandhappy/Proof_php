<?php
include "config.php";

/*if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!isset($_POST['username'])){
        echo json_encode(array('error' => 'Username is required!'));
        exit;
    }
    $username = $_POST['username'];
}else{
    echo json_encode(array('error' => 'POST method is only allowed'));
}*/


include "components/post_list.php";
echo json_encode($data);