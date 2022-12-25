<?php
require_once "config.php";

$full_name = trim($_POST['logname']);
$email = $password = "";
$email_err = $password_err = "";

if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(empty(trim($_POST["logemail"]))) {
                echo "All fields are required";
                die();
        }
        else {
                $SELECT = "SELECT email FROM usertb where email = ?";
                $stmt = mysqli_prepare($conn, $SELECT);
                if($stmt) {
                        mysqli_stmt_bind_param($stmt, "s", $param_email);

                        $param_email = trim($_POST['logemail']);

                        if(mysqli_stmt_execute($stmt)) {
                                mysqli_stmt_store_result($stmt);
                                if(mysqli_stmt_num_rows($stmt) == 1) {
                                        $email_err = "This email is already taken";
                                } else {
                                        $email=trim($_POST['logemail']);
                                }
                        } else {
                                echo "Something went wrong";
                        }
                }
        }

        mysqli_stmt_close($stmt);

        if(empty(trim($_POST["logpass"]))) {
                $password_err = "Password cannot be blank";
        }
        elseif(strlen(trim($_POST['logpass'])) < 5) {
                $password_err = "Password cannot be less than 5 characters";
        }
        else {
                $password = trim($_POST['logpass']);
        }

        if(empty($password_err) && empty($email_err)) {
                $INSERT = "INSERT INTO usertb (full_name, email, password) VALUES(?, ?, ?)";
                $stmt = mysqli_prepare($conn, $INSERT);
                if($stmt) {
                        mysqli_stmt_bind_param($stmt, "sss", $param_full_name, $param_email, $param_password);

                        $param_full_name = $full_name;
                        $param_email= $email;
                        $param_password = password_hash($password, PASSWORD_DEFAULT);

                        if(mysqli_stmt_execute($stmt)) {
							header("location: ./login.php");
                        } else {
                                echo "Something went wrong... cannot redirect!";
                        }
                }
                mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
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
