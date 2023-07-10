<?php
ini_set('display_errors', false);
ini_set('error_log', 'log/login.log');
include("connection.php");

if (!empty($_POST["email"]) & !empty($_POST["pass"]) & $_SERVER["REQUEST_METHOD"] === "POST") {

    session_start();

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
      header('Refresh: 2; url=loginform.php');
      exit("Input error , Redirecting to Login page\n");
    }

    $pass = $_POST['pass'];
    $email = $_POST['email'];

    $query = "SELECT * FROM user WHERE email = ?";
    /* prepare query */
    if (!$stmt = $conn->prepare($query)) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit();
    }
    /* bind parameters */
    if (!$stmt->bind_param("s", $email)) {
        error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        exit();
    };
    /* execute query */
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        exit();
    }

    $result = $stmt->get_result();

    if ($result->num_rows != 1) {
        // email don't exists
        header('Refresh: 2; url=loginform.php');
        exit("Email or password wrong , Redirecting to Login page\n");
    } else {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['pass'])) {
            if($row['admin'] != - 1){
                $_SESSION['userid'] = $row['userid'];
                $row['admin']? $_SESSION['admin'] = true: $_SESSION['admin'] = false;
            }else{
                header("location: show_profile.php");
                exit();
            }
            $result->free();
            $conn->close();
            $stmt->close();

            header("location: show_profile.php");
            exit();
        } else {
            // password != password
            header('Refresh: 2; url=loginform.php');
            exit("Email or password wrong , Redirecting to Login page\n");
        }
    }
}
?>
