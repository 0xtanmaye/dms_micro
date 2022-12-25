<?php
$full_name = $_POST['logname'];
$email = $_POST['logemail'];
$password = $_POST['logpass'];

if(!empty($email) || !empty($password) || !empty($full_name)) {
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "qwerty";
	$dbName = "userdb";

	$conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);
	
	if(mysqli_connect_error()) {
		die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
	} else {
		$SELECT = "SELECT email FROM usertb where email = ? Limit 1";
		$INSERT = "INSERT INTO usertb (full_name, email, password) values(?, ?, ?)";
		
		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if($rnum==0) {
			$stmt->close();

			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param($full_name, $email, $password);
			$stmt->execute();
			echo "1 row inserted successfully";
		} else {
			echo "Email already in use";
		}
		$stmt->close();
		$conn->close();
	}

} else {
	echo "All fields are required";
	die();
}
?>
