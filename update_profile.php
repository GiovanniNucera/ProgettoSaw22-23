<?php
ini_set('display_errors', false);
ini_set('error_log', 'log/updateprofile.log');

include("connection.php");
session_start();

if (!isset($_SESSION['userid'])) {
    header("location: index.php");
    exit();
}

if (!empty($_POST["firstname"]) & !empty($_POST["lastname"]) & !empty($_POST["email"])) {
    $userid = $_SESSION['userid'];

    $query_1 = "UPDATE `user` SET `firstname` = ?, `lastname` = ?, `email` = ? WHERE `user`.`userid` = ?";
    $query_2 = "INSERT INTO user_profile (userid,city,selfdescription,socialurl,cf) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE `city` = ?, `selfdescription` = ?, `socialurl` = ?, `cf` = ?";

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        header('Refresh: 2; url=show_profile.php');
        exit("Input error , Redirecting to Edit profile page\n");
    }
    $email = $_POST["email"];
    if ((!$stmt_1 = $conn->prepare($query_1))) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later\n");
    }
    if (!$stmt_1->bind_param("sssi", $firstname, $lastname, $email, $userid)) {
        error_log("Binding parameters failed: (" . $stmt_1->errno . ") " . $stmt_1->error);
        exit("Something went wrong, visit us later\n");
    }
    if (!$stmt_1->execute()) {
        error_log("Execute failed: (" . $stmt_1->errno . ") " . $stmt_1->error);
        exit("Something went wrong, visit us later\n");
    }
    if ($stmt_1->affected_rows > 1) {
        header("location: index.php");
        exit();
    }
    if (!empty($_POST['city']) || !empty($_POST['selfdescription']) || !empty($_POST['socialurl']) || !empty($_POST['cf'])) {
        $city = isset($_POST['city']) ? $_POST['city'] : "";
        $selfdescription = isset($_POST['selfdescription']) ? $_POST['selfdescription'] : "";
        $socialurl = isset($_POST['socialurl']) ? $_POST['socialurl'] : "";
        $cf = isset($_POST['cf']) ? $_POST['cf'] : "";
        if ((!$stmt_2 = $conn->prepare($query_2))) {
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later\n");
        }
        if (!$stmt_2->bind_param("issssssss", $userid, $city, $selfdescription, $socialurl, $cf, $city, $selfdescription, $socialurl, $cf)) {
            error_log("Binding parameters failed: (" . $stmt_2->errno . ") " . $stmt_2->error);
            exit("Something went wrong, visit us later\n");
        }
        if (!$stmt_2->execute()) {
            error_log("Execute failed: (" . $stmt_2->errno . ") " . $stmt_2->error);
            exit("Something went wrong, visit us later\n");
        }
        if ($stmt_2->affected_rows > 2) {
            header("location: index.php");
            exit();
        }
        $stmt_2->close();
        header("location: show_profile.php");
        exit();
    }else{
        $query_3 = "DELETE FROM user_profile WHERE userid = ?";
        if ((!$stmt_3 = $conn->prepare($query_3))) {
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later\n");
        }
        if (!$stmt_3->bind_param("i", $userid)) {
            error_log("Binding parameters failed: (" . $stmt_3->errno . ") " . $stmt_3->error);
            exit("Something went wrong, visit us later\n");
        }
        if (!$stmt_3->execute()) {
            error_log("Execute failed: (" . $stmt_3->errno . ") " . $stmt_3->error);
            exit("Something went wrong, visit us later\n");
        }
        if ($stmt_3->affected_rows != 1) {
            header("location: update_profileform.php");
            exit();
        }
        $stmt_3->close();
        header("location: show_profile.php");
        exit();
    }
    $stmt_1->close();
    $conn->close();
    
    header("location: show_profile.php");
    exit();
}else {
    header("location: show_profile.php");
    exit();
}
?>

