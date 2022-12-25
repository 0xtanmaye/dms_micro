<?php
$email = $_POST['logemail'];
$password = $_POST['logpass'];

if(!empty($email) || !empty($password)) {
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "qwerty";
	$dbname = "userdb";

	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
	
	if(mysqli_connect_error()) {
		die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
	} else

} else {
	echo "All fields are required";
	die();
}
