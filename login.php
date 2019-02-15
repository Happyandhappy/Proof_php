<?php
	session_start();
    include "components/header.php";
	$error = NULL;

	unset($_SESSION['username']);
	unset($_SESSION['userid']);
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
								<input type="hidden" name="type" value="login">
								<div class="alert alert-danger alert-dismissible hidden" id="alert">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<p id="alert_content"></p>
								</div>
								<div class="form-group">
									<input type="text" name="username" class="form-control" placeholder="Username" value="" minlength="4" required>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Password" minlength="4" required>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In"
											 id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Posting">
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


<?php 
	include "components/footer.php"; 
