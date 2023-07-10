<?php
ini_set('display_errors', false);
ini_set('error_log', 'php.log');
include("../connection.php");
session_start();

if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true|| $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: ../login.html");
    exit();
}

if(($_POST['action'] == 'edit') && !empty($_POST['id'])&& !empty($_POST['admin']) && $_POST['admin']>=-1&&$_POST['admin']<=1){

    $query = "UPDATE `user` SET `admin` = ? WHERE `user`.`userid` = ?";
    /* prepare query */
    if (!$stmt = $conn->prepare($query)) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later\n");
    }
    /* bind parameters */
    if (!$stmt->bind_param("ii", $_POST['admin'],$_POST['id'] )) {
        error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    };
    /* execute query */
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    } 
    if ($stmt->affected_rows !== 1) {

        $returnData = array('status' => 'error','msg' => 'Some problem occurred, please try again.');
        }else{
            $conn->close();
            $stmt->close();
           
            $returnData = array('status' => 'ok','msg' => 'User data has been updated successfully.');
        }
        echo json_encode($returnData);

}elseif(($_POST['action'] == 'delete') && !empty($_POST['id'])){

    
    $query = "DELETE FROM `user` WHERE `user`.`userid` = ?";
    /* prepare query */
    if (!$stmt = $conn->prepare($query)) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error, 3,'php.log');
        exit("Something went wrong, visit us later\n");
    }
    /* bind parameters */
    if (!$stmt->bind_param("i", $_POST['id'])) {
        error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error,3,'php.log');
        exit("Something went wrong, visit us later\n");
    };
    /* execute query */
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error,3,'php.log');
        exit("Something went wrong, visit us later\n");
    } 
    if ($stmt->affected_rows !== 1) {
        $returnData = array('status' => 'error','msg' => 'Some problem occurred, please try again.');  
    }  
            
    //$returnData = array('status' => 'ok','msg' => 'User data has been deleted successfully.');  
    
    //echo json_encode($returnData);  
    return 'ok';  
}
header('Refresh: 2; url=admin_users.php');
exit("<h1>Something went wrong, visit us later</h1>");
?>