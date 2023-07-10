<?php
ini_set('display_errors', false);
ini_set('error_log', '../log/admin.log');
include("../connection.php");
session_start();
if ( $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: ../loginform.php");
    exit();
}
if(($_POST['action'] == 'product') && !empty($_POST['id'])){
    $query = "DELETE FROM `product` WHERE `id` = ?";
    if (!$stmt = $conn->prepare($query)) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later\n");
    }
    if (!$stmt->bind_param("i", $_POST['id'])) {
        error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    };
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error,);
        exit("Something went wrong, visit us later\n");
    } 

    if ($stmt->affected_rows !== 1) {
        header('Refresh: 1; url=admin_products.php');
        exit("<Something went wrong, redirect to Admin Product");
    }
    return true;

}else if(($_POST['action'] == 'user') && !empty($_POST['id'])){
    $query = "DELETE FROM `user` WHERE `user`.`userid` = ?";
    if (!$stmt = $conn->prepare($query)) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later\n");
    }
    if (!$stmt->bind_param("i", $_POST['id'])) {
        error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    }
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    } 
    if ($stmt->affected_rows !== 1) {
        header('Refresh: 1; url=admin_users.php');
        exit("<Something went wrong, redirect to Admin Product");
    }
    return true;

      
}
?>