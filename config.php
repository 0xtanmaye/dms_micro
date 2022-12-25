<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'qwerty');
	define('DB_NAME', 'userdb');

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conn == false) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
	}
?>
