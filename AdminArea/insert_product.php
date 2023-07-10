<?php
include("../connection.php");
ini_set('display_errors', false);
ini_set('error_log', '../log/admin.log');
session_start();

if ( $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
  header("location: ../loginform.php");
  exit();
}
if (empty($_POST['ide'])||empty($_POST['name'])||empty($_POST['description'])){
  header("location: admin_product.php");
  exit();
}
$query = "INSERT INTO `product`(`id`, `name`, `description`) VALUES (?,?,?)";
if (!$stmt = $conn->prepare($query)) {
  error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
  exit();
}
if (!$stmt->bind_param("iss", $_POST['ide'], $_POST['name'],$_POST['description'])) {
  error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  exit();
}
if (!$stmt->execute()) {
  error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  exit();
}
if ($stmt->affected_rows !== 1) {
  header('Refresh: 1; url=admin_product.php');
  exit("<h1>Something went wrong, redirect to Admin Donate </h1>");
}
header("location: admin_product.php");
exit();
