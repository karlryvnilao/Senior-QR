<?php 
	session_start(); 
	if(isset($_SESSION['username'])){
		header('Location: dashboard.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'templates/header.php' ?>
	<title>Login - Barangay Management System</title>
	<!-- Ensure Bootstrap CSS is included in your header.php -->
	<style>
		.wrapper-login {
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			background-color: #f7f7f7;
		}

		.container-login {
			background: white;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
			max-width: 900px;
			width: 100%;
		}

		.container-login img {
			width: 100%;
			border-radius: 10px;
		}

		.login-form {
			display: flex;
			flex-direction: column;
			justify-content: center;
			padding: 20px;
		}

		.form-group {
			margin-bottom: 15px;
		}

		.alert {
			margin-bottom: 15px;
		}
	</style>
</head>

<body class="login">
	<?php include 'templates/loading_screen.php' ?>
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<div class="row">
				<!-- Left side image -->
				<div class="col-md-6">
					<img src="assets/img/login.jfif" alt="Login Image">
				</div>
				
				<!-- Right side login form -->
				<div class="col-md-6">
					<div class="login-form">
						<?php if(isset($_SESSION['message'])): ?>
							<div class="alert alert-<?= $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
								<?= $_SESSION['message']; ?>
							</div>
							<?php unset($_SESSION['message']); ?>
						<?php endif ?>
						<h3 class="text-center">Sign In Here</h3>
						<form method="POST" action="model/login.php">
							<div class="form-group form-floating-label">
								<input id="username" name="username" type="text" class="form-control input-border-bottom" required>
								<label for="username" class="placeholder">Username</label>
							</div>
							<div class="form-group form-floating-label">
								<input id="password" name="password" type="password" class="form-control input-border-bottom" required>
								<label for="password" class="placeholder">Password</label>
								<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							</div>
							<div class="form-action mb-3">
								<button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include 'templates/footer.php' ?>
</body>
</html>
