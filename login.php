<?php
	session_start();
    include "components/header.php";
	$error = NULL;

	unset($_SESSION['username']);
	unset($_SESSION['userid']);
	
	/* verify credentials with database user information */
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];        
        $result = $mysqli->query("SELECT * from `users` WHERE `username`='" . mysqli_real_escape_string($mysqli, $username) . "'");
        if ($result){
            $data = $result->fetch_assoc();
            if (!password_verify($password, $data['password'])){
                $error = "Invalid Password";
            }else{
				$error = "Successfully login";
				$_SESSION['username'] = $username;				
				header('Location: index.php');
            }            
        }else{
            $error = "The user is not existed.";
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
							<a class="active" id="login-form-link">Login</a>
						</div>
						<div class="col-xs-6">
							<a href="register.php" id="register-form-link">Register</a>
						</div>
					</div>
					<hr>
				</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<form id="login-form" method="post" role="form">
								<?php 
									if (isset($error)){
										echo "<div class='alert alert-danger'>" . $error . "</div>";
									}
								?>
								<div class="form-group">
									<input type="text" name="username" class="form-control" placeholder="Username" value="" autocomplete="off" required>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
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