<?php
ini_set('display_errors', false);
ini_set('error_log', 'php.log');
include("connection.php");

$email = $_POST['email'];
$pass = $_POST['pass'];
$query = "SELECT * FROM user WHERE email = ?";
/* prepare query */
if (!$stmt = $conn->prepare($query)) {
    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    exit("Something went wrong, visit us later\n");
}
/* bind parameters */
if (!$stmt->bind_param("s", $email)) {
    error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    exit("Something went wrong, visit us later\n");
};
/* execute query */
if (!$stmt->execute()) {
    error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    exit("Something went wrong, visit us later\n");
}


$result = $stmt->get_result();

$row = $result->fetch_assoc();

if ($row)
{// email exists
    echo "emailexist";
}else{// email not exists
    echo "emailnotexist";
    exit();
}

if (password_verify($pass, $row['pass']))
{
  echo "passwordmatch";
  exit();
}else{
  echo "passwordnotmatch";
  exit();
}
?>
