<?php
include("../connection.php");
ini_set('display_errors', false);
ini_set('error_log', '../log/admin.log');
session_start();
if ($_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
  header("location: ../loginform.php");
  exit();
}

if (empty($_POST["name"]) || empty($_POST["description"]) || empty($_POST["goal"]) || empty($_POST["date_1"]) || empty($_POST["date_2"])) {
  header("location: ../loginform.php");
  exit();
}

if (strtotime($_POST['date_1']) > strtotime($_POST['date_2']) || $_POST["goal"] <= 0) {
  header('Refresh: 2; url=admin_donate.php');
  exit("Something went wrong...\n");
}

$query = "INSERT INTO crowdfunding (name,description,goal,datetime,enddate) VALUES (?,?,?,?,?)";
if (!$stmt = $conn->prepare($query)) {
  error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
  exit();
}
if (!$stmt->bind_param("ssiss", $_POST["name"], $_POST["description"], $_POST["goal"], $_POST["date_1"], $_POST["date_2"])) {
  error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  exit();
}
if (!$stmt->execute()) {
  error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  exit();
}
if ($stmt->affected_rows !== 1) {
  header('Refresh: 1; url=admin_donate.php');
  exit("<h1>Something went wrong, redirect to Admin Donate </h1>");
}
header("location: admin_donate.php");
exit();
?>