<?php
session_start();

// user is already logged in?
if(isset($_SESSION['logemail'])) {
    header("location: ./welcome.php");
    exit;
}

require_once "config.php";

$email = $password = "";
$err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty(trim($_POST['logemail'])) || empty(trim($_POST['logpass']))) {
                $err = "Please enter username + password";
    }
    else {
		$email = trim($_POST['logemail']);
		$password = trim($_POST['logpass']);
	}
	
	if(empty($err)) {
		$SELECT = "SELECT id, full_name, email, password FROM usertb WHERE email = ?";
        $stmt = mysqli_prepare($conn, $SELECT);
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;

        if(mysqli_stmt_execute($stmt)) {
			mysqli_stmt_store_result($stmt);
			if(mysqli_stmt_num_rows($stmt) == 1) {
				mysqli_stmt_bind_result($stmt, $id, $full_name, $email, $hashed_password);
				if(mysqli_stmt_fetch($stmt)) {
					if(password_verify($password, $hashed_password)) {
						// this means the password is corrct. Allow user to login
						session_start();
						$_SESSION["email"] = $email;
						$_SESSION["id"] = $id;
						$_SESSION["loggedin"] = true;
						//Redirect user to welcome page
						header("location: ./welcome.php");
					}
				}
			}
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login/Sign Up Page</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<a href="https://front.codes/" class="logo" target="_blank">
		<img src="https://assets.codepen.io/1462889/fcy.png" alt="">
	</a>

	<div class="section">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
			          	<input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
			          	<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Log In</h4>
											<form action="" method="post">
											<div class="form-group">
												<input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off" required>
												<i class="input-icon uil uil-at"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off" required>
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
											<button type="submit" class="btn btn-primary mt-4">submit</button>
											</form>
                            				<p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p>
				      					</div>
			      					</div>
			      				</div>
								<div class="card-back">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Sign Up</h4>
											<form action="" method="post">
											<div class="form-group">
												<input type="text" name="logname" class="form-style" placeholder="Your Full Name" id="logname" autocomplete="off" required>
												<i class="input-icon uil uil-user"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off" required>
												<i class="input-icon uil uil-at"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off" required>
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
											<button type="submit" class="btn btn-primary mt-4">submit</a>
											</form>
				      					</div>
			      					</div>
			      				</div>
			      			</div>
			      		</div>
			      	</div>
		      	</div>
	      	</div>
	    </div>
	</div>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
