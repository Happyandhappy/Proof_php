<?php
	session_start();
	
	include('config.php');
	$target_dir = "uploads/";
	if ($_SERVER['REQUEST_METHOD'] === 'POST'){
		switch($_POST['type']){
			/**
			 * Upload new article
			 */
			case 'posting':
				$title = "";
				$content = "";
				if (isset($_POST['content'])) $content = $mysqli->real_escape_string($_POST['content']);
				$images = array();
				//if there was an error uploading the file				
				if (isset($_FILES["files"])) {
					foreach($_FILES['files']['name'] as $key=>$val){
						$image_name = $_FILES['files']['name'][$key];
						$tmp_name   = $_FILES['files']['tmp_name'][$key];
						$size       = $_FILES['files']['size'][$key];
						$type       = $_FILES['files']['type'][$key];
						$error      = $_FILES['files']['error'][$key];

						if ($error == 0) {
							// file upload & store to upload directory
							$words = explode(".", $image_name);
							$name = uniqid() . '.' . end($words);
							$storagename = $target_dir . $name;			
							@move_uploaded_file($tmp_name, $storagename);
							$image = $storagename;
							array_push($images, $storagename);
						}
					}
				}

				if ( $content != "" || count($images) > 0){
					$query = "insert into `posting` (`userid`,`content`) values (" . $_SESSION['userid'] . ",'" . $content . "')";
					$mysqli->query($query);
					$res = $mysqli->query("SELECT LAST_INSERT_ID()");
					$postid = NULL;
					if ($res){
						$data = $res->fetch_assoc();
						$postid = $data['LAST_INSERT_ID()'];
					}
					
					if (isset($postid)){
						foreach($images as $image){
							$query = "insert into `images` (`postid`,`url`) values(" . $postid . ",'" . $image . "')";					
							$result = $mysqli->query($query);
							if (!$result){							
								echo json_encode(array('status' => 'danger','message' => 'Invalid Data in store to database')); exit;
							}
						}
						echo json_encode(array('status' => 'success','message' => 'Successfully saved!')); exit;
					}										
				}else echo json_encode(array('status' => 'danger','message' => 'Invalid Data, Either of Content and Image is required!'));
				break;

			/**
			 * List of Articles
			 */
			case 'listing':
				$query = "SELECT posting.*, images.url FROM posting INNER JOIN images on posting.id=images.postid ORDER BY posting.timestamps ASC";
				$result = $mysqli->query($query);
				if ($result){
					$data = [];
					while($row = $result->fetch_assoc()){
						array_push($data, $row);
					}
					echo json_encode($data);
				}
			/**
			 * Register new user
			 */
			case 'register':
				$username = $_POST['username'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$confirm = $_POST['confirm-password'];
				
				$query = "SELECT * from `users` WHERE `email`='" . mysqli_real_escape_string($mysqli, $email) . "' OR `username`='" .  mysqli_real_escape_string($mysqli, $username)  . "'";
				
				$result = $mysqli->query($query);
								
				if ($result && $result->num_rows > 0){
					$res = array('status' => 'danger', 'message'=> 'User email or User name is already existed!');					
				}else if ($password != $confirm){
					$res = array('status' => 'danger', 'message'=> "Password and confirm password are not matched!");
				}else{
					$hash = password_hash($password, PASSWORD_DEFAULT);
					$mysqli->query("INSERT into `users` (`username`, `email`, `password`) VALUES ('" . $username . "','" . $email . "','" . $hash  . "')");
					$res = array('status' => 'success', 'message'=> "Successfully Registered!");
				}
				echo json_encode($res);
				break;
				
			/**
			 * Login User
			 */
			case 'login':
				$username = $_POST['username'];
				$password = $_POST['password'];
				$query = "SELECT * from `users` WHERE `username`='" . mysqli_real_escape_string($mysqli, $username) . "'";				
				$result = $mysqli->query($query);
				
				if ($result && $result->num_rows > 0){
					$data = $result->fetch_assoc();
					if (!password_verify($password, $data['password'])){
						$res = array('status' => 'danger', 'message'=> "Invalid Password");
					}else{
						$res = array('status' => 'success', 'message'=> "Successfully login");
						$_SESSION['username'] = $username;
						$_SESSION['userid'] = $data['id'];
					}
				}else{
					$res = array('status' => 'danger', 'message'=> "The user is not existed");
				}
				echo json_encode($res);
				break;
			default:
				echo json_encode(array("status => 'danger", 'message' => 'No type action'));
		}
	}
