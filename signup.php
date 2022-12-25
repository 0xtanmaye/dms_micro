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
				header("location: login.php");
			} else {
				echo "Something went wrong... cannot redirect!";
			}
		}
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
}
?>
