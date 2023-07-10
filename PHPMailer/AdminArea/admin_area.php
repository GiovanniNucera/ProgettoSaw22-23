<?php
ini_set('display_errors', false);
ini_set('error_log', 'php.log');
include("../connection.php");
session_start();
if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true || $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
  header("location: login.html");
  exit();
}

$_SESSION['admin_navbar'] = true;
?>
<!DOCTYPE html>
<html>

<head>

  <link rel="stylesheet" href="../css/stylehome.css">
  <link rel="stylesheet" href="../css/ourworks.css">
  <link rel="stylesheet" href="../css/button.css">

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

      <!--  Menu compatible with wp_nav_menu  -->
      <ul id="primary-menu" class="menu nav-menu">
        <?php
        include("../navbar.php");
        ?>
      </ul>
    </div>
  </nav>

  <div class="home">
        <h1>
            Admin Area
        </h1>
    </div>
  <div style="margin: 50px;"> </div>

  <div class="section">
    <div class="row">
      <div class="column">
        <a href="admin_product.php"> <img src="../images/shopping-bag.png" style="border-radius: 10px; max-width:100%;border: 5px solid #9212e3; height: 200px;"> </a>
        <p> Products Area </p>
      </div>
      <div class="column">
        <a href="admin_donate.php"><img src="../images/donation.png" style="border-radius: 10px; max-width:100%;border: 5px solid #9212e3; height: 200px;"></a>
        <p> Donations Area </p>
      </div>
      <div class="column">
        <a href="admin_users.php"> <img src="../images/people.png" style="border-radius: 10px; max-width:100%;border: 5px solid #9212e3; height: 200px;"> </a>
        <p>Users Area </p>
      </div>
    </div>
  </div>

  <div style="margin: 50px;"> </div>

</body>

</html>