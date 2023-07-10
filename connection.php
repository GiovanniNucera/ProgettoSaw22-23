<?php
$host = "localhost";
$user = "xxxxxx";
$pwd  = "xxxxxx";
$db = "xxxxxx";

$conn = mysqli_connect($host, $user, $pwd, $db);
 if ($conn === false) {
	die("Connection error: " . mysqli_connect_error($conn) . "\n");
}

?>
