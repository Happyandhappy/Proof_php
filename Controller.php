<?php
	include('config.php');
	$target_dir = "uploads/";
	if ($_SERVER['REQUEST_METHOD'] === 'POST'){
		switch($_POST['type']){
			case 'posting':
				$title = "";
				$content = "";
				if (isset($_POST['content'])) $content = $mysqli->real_escape_string($_POST['content']);			
				$image = "";
				//if there was an error uploading the file
				if ( isset($_FILES["file"])) {
					if ($_FILES["file"]["error"] > 0) {
						$image = "";
					}
					else {
						// file upload and read csv file as array
						$words = explode(".", $_FILES["file"]["name"]);
						$name = uniqid(). '.' . end($words);
						$storagename = $target_dir . $name;			
						@move_uploaded_file($_FILES["file"]["tmp_name"], $storagename);
						$image = $storagename;		        
					}
				}
				if ( $content != "" || $image != ""){
					$query = "insert into `posting` (`content`,`image`) values('" . $content . "','" . $image . "')";
					
					$result = $mysqli->query($query);
					if ($result){
						echo json_encode(array('status' => 'success','message' => 'Successfully saved!'));	
					}else{
						echo json_encode(array('status' => 'danger','message' => 'Invalid Data in store to database'));
					}		
				}else echo json_encode(array('status' => 'danger','message' => 'Invalid Data, Either of Content and Image is required!'));
				break;
			case 'posting':
				$query = "SELECT * FROM `posting` ORDER BY `timestamps` ASC";
				$result = $mysqli->query($query);
				if ($result){
					$data = [];
					while($row = $result->fetch_assoc()){
						array_push($data, $row);
					}
					echo json_encode($data);
				}
			case 'register':
				$username = $_POST['username'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$confirm = $_POST['confirm-password'];
				
				$query = "SELECT * from `users` WHERE `email`='" . mysqli_real_escape_string($mysqli, $email) . "' OR `username`='" .  mysqli_real_escape_string($mysqli, $username)  . "'";
				$result = $mysqli->query($query);
								
				if ($result && $result->num_rows > 0){
					$res = array('status' => 'failed', 'message'=> 'User email or User name is already existed!');					
				}else if ($password != $confirm){
					$res = array('status' => 'failed', 'message'=> "Password and confirm password are not matched!");
				}else{
					$hash = password_hash($password, PASSWORD_DEFAULT);
					$mysqli->query("INSERT into `users` (`username`, `email`, `password`) VALUES ('" . $username . "','" . $email . "','" . $hash  . "')");
					$res = array('status' => 'success', 'message'=> "Successfully Registered!");
				}
				echo json_encode($res);
				break;
			
			case 'login':
				$username = $_POST['username'];
				$password = $_POST['password'];        
				$result = $mysqli->query("SELECT * from `users` WHERE `username`='" . mysqli_real_escape_string($mysqli, $username) . "'");
				if ($result){
					$data = $result->fetch_assoc();
					if (!password_verify($password, $data['password'])){
						$res = array('status' => 'failed', 'message'=> "Invalid Password");
					}else{
						$res = array('status' => 'success', 'message'=> "Successfully login");
						$_SESSION['username'] = $username;
						$_SESSION['userid'] = $data['id'];
					}
				}else{
					$res = array('status' => 'failed', 'message'=> "The user is not existed");
				}
				echo json_encode($res);
				break;
			default:
				echo json_encode(array("status => 'failed", 'message' => 'No type action'));
		}
	}
