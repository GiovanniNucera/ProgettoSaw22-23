<?php
session_start();
ini_set('display_errors', false);
ini_set('error_log', '../log/crowdfunding.log');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Donation Successful</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="../css/stylehome.css">
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="../css/bootstrap.css">
</head>

<body>

<nav class="navbar">
    <div class="logo"><img src="../images/LOGO.png" alt="LOGO"> </div>
    <div class="push-left">
      <button id="menu-toggler" data-class="menu-active" class="hamburger">
        <span class="hamburger-line hamburger-line-top"></span>
        <span class="hamburger-line hamburger-line-middle"></span>
        <span class="hamburger-line hamburger-line-bottom"></span>
      </button>


      <ul id="primary-menu" class="menu nav-menu">
        <?php
            include("../navbar.php");
        ?>
      </ul>
    </div>
  </nav>

    <div class="container mt-5 text-center">
      <div class="row">
          <div class="col-md-12">
              <h1 class="text-success">Donation Successful!</h1>
              <p class="lead">Thank you for your donation. Your transaction has been completed successfully.</p>
              <p>You will receive a confirmation email shortly.</p>
              <p id="redirect-message">Redirecting you back to the homepage in <span id="countdown">5</span> seconds...</p>
              <p>If the redirect does not work, please <a href="crowdfunding.php" class="text-success">click here</a> to go back to the homepage.</p>
          </div>
      </div>
  </div>


  <?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require '../PHPMailer/PHPMailer/src/Exception.php';
  require '../PHPMailer/PHPMailer/src/PHPMailer.php';
  require '../PHPMailer/PHPMailer/src/SMTP.php';

      $mail = new PHPMailer(true);

      try {
          //Server settings
          $mail->SMTPDebug = 0;
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'smtpscuola@gmail.com';
          $mail->Password = 'ewafcjnjqjfzvtcl';
          $mail->SMTPSecure = 'TLS';
          $mail->Port = 587;                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

          $mail->setFrom('progetto@saw.com', 'FoodBank Italia');
          $email_template = 'mail.html';
          $message = file_get_contents($email_template);
          $object = "Donation Confirmation";

          $mail->addAddress($_SESSION['emailcrowdfunding'], '');
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->MsgHTML($message);
          $mail->Subject = $object;
          $mail->send();
          $mail->clearAllRecipients();



      } catch (Exception $e) {
          error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
      }
  unset($_SESSION['emailcrowdfunding']);

  ?>

  <script>
      setTimeout(function() {
          window.location.href = "crowdfunding.php";
      }, 5000);

      let count = 5;
      setInterval(function() {
          count--;
          document.getElementById("countdown").innerHTML = count;
      }, 1000);

  </script>
<?php  include("../footer.php"); ?>
</body>

</html>
