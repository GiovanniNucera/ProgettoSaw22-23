<?php
ini_set('display_errors', false);
ini_set('error_log', 'log/updateprofile.log');
include("connection.php");
session_start();
if (!isset($_SESSION['userid'])) {
  header("location: index.php");
  exit();
}
$_SESSION['admin_navbar'] = false;

$userid = $_SESSION['userid'];
$query = "SELECT * FROM user WHERE user.userid = '$userid'";

$result = $conn->query($query);
if (!$result ) {
    error_log("Query failed:" . $conn->error);
    exit("Something went wrong, visit us later\n");
}

if ($result->num_rows === 1)
  $row = $result->fetch_array(MYSQLI_ASSOC);

$firstname = htmlspecialchars($row['firstname']);
$lastname = htmlspecialchars($row['lastname']);
$email = htmlspecialchars($row['email']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Account Information</title>
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/ourworks.css">
  <link rel="stylesheet" href="css/stylehome.css">
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="js/navbar.js"></script>
</head>

<body>

<nav class="navbar">
    <div class="logo"><img src="images/LOGO.png" alt=""></div>
    <div class="push-left">
      <button id="menu-toggler" data-class="menu-active" class="hamburger">
        <span class="hamburger-line hamburger-line-top"></span>
        <span class="hamburger-line hamburger-line-middle"></span>
        <span class="hamburger-line hamburger-line-bottom"></span>
      </button>

      <!--  Menu compatible with wp_nav_menu  -->
      <ul id="primary-menu" class="menu nav-menu">
        <?php
            include("navbar.php");
        ?>
      </ul>
    </div>
  </nav>

  <div style="margin: 50px;"></div>
    <!-- end header section -->
  <div class="home">
    <h1>Account Information</h1>
  </div>
  <div class="section">
  <div class="row">
    <div class="column">
        <div class="form">
        <form class="login-form" id="myForm" method="post" enctype="multipart/form-data">
                <div><?php echo '<dl><dt>First Name</dt><dd><span style="text-transform: uppercase;"><h3>' . $firstname . '</h3></dd></dl>';?><br></div>
                <div> <?php echo '<dl><dt>Last Name</dt> <dd><span style="text-transform: uppercase;"><h3>' . $lastname . '</h3></dd></dl>';?><br> </div>
                <div><?php echo '<dl><dt>Email Address</dt><dd><h3>' . $email . '</h3></dd></dl>';?></div>
                <div> <br> <button> <a href="update_profileform.php">Edit Profile</a> </button><br><br>
                <button><a href="update_passwordform.php">Edit Password</a></button><br><br>
                <button> <a href="delete_profile.php"onclick="return confirm('Delete Personal Information? This action is permanent and cannot be undone. Are you certain you wish to delete all of your personal information, including your account from our systems?')">Delete Account</a> </button></div>
        </form>
      </div>
  </div>
</div>
</div>


<div style="margin: 100px;"></div>
<?php  include("footer.php"); ?>
</body>



</html>
