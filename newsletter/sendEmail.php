<?php
include("../connection.php");
session_start();
ini_set('display_errors', false);
ini_set('error_log', '../log/newsletter.log');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if (isset($_POST['oggetto'],$_POST['text'],$_POST['title']))
{
    require '../PHPMailer/PHPMailer/src/Exception.php';
    require '../PHPMailer/PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    $object = $_POST['oggetto'];
    $text = $_POST['text'];
    $title = $_POST['title'];

    $query = "INSERT INTO message (text,title,userid) VALUES (?,?,?)";

    if (!$stmt = $conn->prepare($query)) {
      error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
      exit();
    }
    if (!$stmt->bind_param("ssi", $_POST['text'], $_POST['title'],$_SESSION['userid'])) {
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


    $sql = "SELECT mail FROM newsletter";

    $result = $conn->query($sql);
    if (!$result) {
      error_log("Query failed:" . $conn->error);
      exit("Something went wrong, visit us later\n");
    }

    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'xxxxxx';
        $mail->Password = 'xxxxxx';
        $mail->SMTPSecure = 'TLS';
        $mail->Port = 587;

        $mail->setFrom('progetto@saw.com', 'FoodBank Italia');
        $email_template = 'newsletter.html';
        $message = file_get_contents($email_template);
        $message = str_replace('%title%', $title, $message);
        $message = str_replace('%text%', $text, $message);

        $mail->isHTML(true);
        $mail->MsgHTML($message);
        $mail->Subject = $object;

        while($row = $result->fetch_array(MYSQLI_ASSOC)){

            $mail->addAddress($row['mail'], '');
            $mail->send();
            $mail->clearAllRecipients();
        }


    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error:" .$mail->ErrorInfo);
    }
    mysqli_close($conn);
    header ("location: newsletter.php");
}
?>
