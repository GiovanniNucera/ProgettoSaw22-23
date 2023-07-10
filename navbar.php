<?php
if (!isset($_SESSION['userid'])) {

  echo '<li class="menu-item "><a class="nav__link"  href="/~S5066337/foodbanksaw/index.php">HOME</a></li>';
  echo '<li class="menu-item current-menu-item"><a class="nav__link"  href="/~S5066337/foodbanksaw/crowdfunding/crowdfunding.php">Crowdfunding</a></li>';
  echo '<li class="menu-item "><a class="nav__link"  href="/~S5066337/foodbanksaw/loginform.php">LOGIN</a></li>';
}

if (isset($_SESSION['userid'])) {
  include("connection.php");
  $userid = $_SESSION['userid'];
  $query = "SELECT * FROM user WHERE user.userid = '$userid'";


  $rs = $conn->query($query);
  if (!$rs)
  {
      error_log("Query failed:" . $conn->error);
      exit("Something went wrong, visit us later\n");
  }


  $row = $rs->fetch_array(MYSQLI_ASSOC);

  $admin = ($row['admin']);
  echo '<li class="menu-item "><a class="nav__link"  href="/~S5066337/foodbanksaw/index.php">HOME</a></li>';
  echo '<li class="menu-item current-menu-item"><a class="nav__link"  href="/~S5066337/foodbanksaw/crowdfunding/crowdfunding.php">Crowdfunding</a></li>';
  echo '<li class="menu-item "><a class="nav__link"  href="/~S5066337/foodbanksaw/show_product.php">products</a></li>';
  echo '<li class="menu-item "><a class="nav__link"  href="/~S5066337/foodbanksaw/show_profile.php">account</a></li>';

  if ($admin) {
  echo '<li class="menu-item "><a class="nav__link"  href="/~S5066337/foodbanksaw/AdminArea/admin_area.php">admin</a></li>';
  }
  echo '<li class="menu-item "><a class="nav__link"  href="/~S5066337/foodbanksaw/logout.php">logout</a></li>';
}
