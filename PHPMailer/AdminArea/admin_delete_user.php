<?php
ini_set('display_errors', false);
ini_set('error_log', 'php.log');
include("../connection.php");
session_start();

if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true|| $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: ../login.html");
    exit();
}
echo "....sono qua";
if (empty($_POST['userid'])){
    header('Refresh: 2; url=admin_users.php');
    exit("<h1>Something went wrong, visit us later</h1>");
}
$query = "DELETE FROM `user` WHERE `user`.`userid` = ?";
/* prepare query */
if (!$stmt = $conn->prepare($query)) {
    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    exit("Something went wrong, visit us later\n");
}
/* bind parameters */
if (!$stmt->bind_param("i", $_POST['userid'])) {
    error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    exit("Something went wrong, visit us later\n");
};
/* execute query */
if (!$stmt->execute()) {
    error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    exit("Something went wrong, visit us later\n");
} 
if ($stmt->affected_rows !== 1) {
        header('Refresh: 2; url=admin_users.php');
        exit("<h1>Something went wrong, visit us later</h1>");
}
        $_SESSION = array();
        session_unset();
        session_destroy();
        $conn->close();
        $stmt->close();

        header('Refresh: 2; url = admin_users.php');
        exit("<h1>Delete ok</h1>");

?>