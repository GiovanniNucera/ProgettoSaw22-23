<?php
ini_set('display_errors', false);
ini_set('error_log', '../log/admin.log');
include("../connection.php");
session_start();
if ($_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
  header("location: ../index.php");
  exit();
}

$_SESSION['admin_navbar'] = true;
?>

<?php include("head_admin.php"); ?>

<title> Administration Area </title>

<?php include("navbar_admin.php"); ?>

<div class="home">
  <h1> Administration Area </h1>
</div>
<div style="margin: 50px;"> </div>

<div class="section">
  <div class="row">

    <div class="column">
      <a href="admin_donate.php"><img alt="Donations Area" src="../images/donation.png" style="border-radius: 10px; max-width:100%;border: 5px solid #9212e3; height: 200px;"></a>
      <p> Donations Area </p>
    </div>
    <div class="column">
      <a href="admin_users.php"> <img alt="Users Area" src="../images/people.png" style="border-radius: 10px; max-width:100%;border: 5px solid #9212e3; height: 200px;"> </a>
      <p>Users Area </p>
    </div>
    </div>
</div>
<div style="margin: 50px;"> </div>
<div class="section">
  <div class="row">
    <div class="column">
      <a href="admin_product.php"> <img alt="Products Area" src="../images/shopping-bag.png" style="border-radius: 10px; max-width:100%;border: 5px solid #9212e3; height: 200px;"> </a>
      <p> Products Area </p>
    </div>
    <div class="column">
      <a href="../newsletter/newsletter.php"> <img alt="Newsletter" src="../images/newsletter.png" style="border-radius: 10px; max-width:100%;border: 5px solid #9212e3; height: 200px;"> </a>
      <p> Newsletters</p>
    </div>
    </div>
</div>
<div style="margin: 50px;"> </div>



</body>

</html>
