<?php
ini_set('display_errors', false);
ini_set('error_log', 'log/updateprofile.log');
include("connection.php");
session_start();

if (!isset($_SESSION['userid'])) {
    header("location: index.php");
    exit();
}

if (!empty($_POST["pass_old"]) && !empty($_POST["pass_new"]) && !empty($_POST["confirm"])){

    if ($_POST['pass_new'] != $_POST['confirm']) {
        header("location: update_password.php");
        exit();
    }

    $query = "SELECT * FROM user WHERE userid = ?";
    /* prepare query */
    if (!$stmt = $conn->prepare($query)) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later\n");
    }
    /* bind parameters */
    if (!$stmt->bind_param("i", $_SESSION['userid'])) {
        error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    };
    /* execute query */
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    }
    $result = $stmt->get_result();
    if ($result->num_rows != 1) {
        // email don't exists
        header("location: index.php");
        exit();
    } else {
        $row = $result->fetch_assoc();
        if (password_verify($_POST['pass_old'], $row['pass'])) {
            $pass_new = password_hash($_POST['pass_new'], PASSWORD_DEFAULT);

            $query_1 = "UPDATE `user` SET `pass` = ? WHERE `user`.`userid` = ?";
            /* prepare query_1 */
            if ((!$stmt_1 = $conn->prepare($query_1))) {
                error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                exit("Something went wrong, visit us later\n");
             }
            if (!$stmt_1->bind_param("si", $pass_new, $_SESSION['userid'])) {
                error_log("Binding parameters failed: (" . $stmt_1->errno . ") " . $stmt_1->error);
                exit("Something went wrong, visit us later\n");
            }
            /* execute query_1 */
            if (!$stmt_1->execute()) {
                error_log("Execute failed: (" . $stmt_1->errno . ") " . $stmt_1->error);
                exit("Something went wrong, visit us later\n");
            }
            if ($stmt_1->affected_rows === 1) {
                $stmt_1->close();
                $conn->close();
                header("location: show_profile.php");
                exit();
            }
            $result->free();
            $conn->close();
             $stmt->close();
            header("location: index.php");
            exit();
        } else {
            header("location: index.php");
            exit();
        }
    }
}
?>


