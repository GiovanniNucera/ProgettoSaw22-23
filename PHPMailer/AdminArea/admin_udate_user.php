<?php
ini_set('display_errors', false);
ini_set('error_log', 'php.log');

include("../connection.php");
session_start();

if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true|| $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: login.html");
    exit();
}
echo "......sono qua";
if (empty($_POST['userid']) || empty($_POST['admin'])){
    header('Refresh: 2; url=admin_users.php');
    exit("<h1>Something went wrong, visit us later</h1>");
}

$query = "UPDATE `user` SET `admin` = ? WHERE `user`.`userid` = ?";

/* prepare query */
if (!$stmt = $conn->prepare($query)) {
    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    exit("Something went wrong, visit us later\n");
}
/* bind parameters */
if (!$stmt->bind_param("ii", $_POST['admin'],$_POST['userid'] )) {
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
        if($_POST['admin']==0){
            $_SESSION['admin'] = $_SESSION['ban'] = false;
        }
        if($_POST['admin']==-1){
            $_SESSION['admin'] = false;
            $_SESSION['ban'] = true;
        }
        if($_POST['admin']==1){
            $_SESSION['admin'] = true;
            $_SESSION['ban'] = false;
        }

        header('Refresh: 2; url = admin_users.php');
        exit("<h1>Delete ok</h1>");

?>