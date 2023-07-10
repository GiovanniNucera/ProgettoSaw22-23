<?php
include("../connection.php");
ini_set('display_errors', false);
ini_set('error_log', '../log/newsletter.log');
session_start();

if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
{
  header('Refresh: 2; url=../index.php');
  exit("Input error , Redirecting to Home page\n");
}

$query = "INSERT INTO `newsletter`(`mail`) VALUES (?)";
if (!$stmt = $conn->prepare($query)) {
  error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
  exit();
}
if (!$stmt->bind_param("s", $_POST['email'])) {
  error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  exit();
}
if (!$stmt->execute()) {
  error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  exit();
}
if ($stmt->affected_rows !== 1) {
  header('Refresh: 1; url=../index.php');
  exit("<h1>Something went wrong, redirect to home</h1>");
}
header("location: confirm.html");
exit();
