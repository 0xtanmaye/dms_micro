<?php
session_start();

// user is already logged in?
if(isset($_SESSION['logemail'])) {
    header("location: welcome.php");
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
                            header("location: welcome.php");
					}
				}
			}
		}
	}
}
?>
