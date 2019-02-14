<?php
	session_start();
    include "components/header.php";
	$error = NULL;

	if ($_SERVER['REQUEST_METHOD'] === 'POST'){
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm-password'];
		
		$query = "SELECT * from `users` WHERE `email`='" . mysqli_real_escape_string($mysqli, $email) . "' OR `username`='" .  mysqli_real_escape_string($mysqli, $username)  . "'";
		$result = $mysqli->query($query);

		if ($result && $result->num_rows > 0){			
			$error = "User email or User name is already existed!";
		}else if ($password != $confirm){
			$error = "Password and confirm password are not matched!";
		}else{
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$mysqli->query("INSERT into `users` (`username`, `email`, `password`) VALUES ('" . $username . "','" . $email . "','" . $hash  . "')");
			$_SESSION['username'] = $username;			
			header('Location: index.php');
			exit();
		}
	}
?>

<div class="container login">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-login">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-6">
							<a href="login.php" id="login-form-link">Login</a>
						</div>
						<div class="col-xs-6">
							<a class="active" id="register-form-link">Register</a>
						</div>
					</div>
					<hr>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<form id="register-form" method="post" role="form">
								<?php 
									if (isset($error)){
										echo "<div class='alert alert-danger'>" . $error . "</div>";
									}
								?>
								<div class="form-group">
									<input type="text" name="username" class="form-control" placeholder="Username" value="" required>
								</div>
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="Email Address" value="" required>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Password" required>
								</div>
								<div class="form-group">
									<input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password" required>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" class="form-control btn btn-register" value="Register Now">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>