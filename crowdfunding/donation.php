<?php
ob_start();
ini_set('display_errors', false);
ini_set('error_log', '../log/crowdfunding.log');

session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Donate</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="../css/stylehome.css">
  <link rel="stylesheet" href="../css/login.css">
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="../js/navbar.js"></script>
  <style>
        .row{
          margin-left: 47px;
          margin-right: 25px;
        }
        .login-page {
            padding: 3% 0 0;
        }
  </style>
</head>

<body>

<nav class="navbar">
    <div class="logo"><img src="../images/LOGO.png" alt=""> </div>
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

  <div class="home">
      <h1>DONATE</h1>
    </div>

    <?php
    if(filter_var($_POST["idCrowdfunding"],FILTER_VALIDATE_INT))
    {
      $query = "SELECT * FROM crowdfunding WHERE".$_POST["idCrowdfunding"];
      $res = $conn->query($query);
      if (!$res) {
          error_log("Query failed:" . $conn->error);
          exit("Something went wrong, visit us later\n");
      }

      $row = $res->fetch_assoc();
      echo '<div class="section">
              <div class="row">';
      echo      '<h3>Project ' .$_POST["idCrowdfunding"]. ': ' .$row['name']. '</h3>';
      echo      "<p>".$row['description']."</p>";
      echo    "</div>";
      echo  "</div>";

      $res->free();
      $conn->close();
    }
    ?>
    <div class="login-page">
      <div class="form">
        <form class="login-form" action="addDonation.php"  id="myForm"  method="post"  enctype="multipart/form-data">
              <?php

                if($_SESSION['thisdonation'] == $_POST["uniqueDonation"])
                {
                    echo'<input type="text" id="firstname" name="firstname" placeholder="Firstname" required>
                        <input type="text" id="lastname" name="lastname" placeholder="Lastname" required>
                        <input type="hidden" id="uniqueDonation" name="uniqueDonation" value="'.$_POST["uniqueDonation"].'">
                        <input type="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}"  id="email" name="email" placeholder="Email" required>';
                    if(!isset($_POST["idCrowdfunding"]))
                    {
                      header('Location: crowdfunding.php');
                    }
                    if(!isset($_POST["amount"]))
                    {
                        $_POST["amount"]="";
                    }
                    echo '<input type="hidden" id="idCrowdfunding" name="idCrowdfunding" value="'.$_POST["idCrowdfunding"].'">';
                    echo '<input type="number" id="amount" min="1" name="amount" placeholder="Amount" value="'.$_POST["amount"].'" required>';
                }else{

                  header('Location: crowdfunding.php');
                }
              ?>

              <button id="buttonSubmit" type="submit">
                DONATE
              </button>
        </form>
      </div>
    </div>

<script>  //rimozione automatica degli spazi iniziali e finali .
    document.getElementById("firstname").addEventListener("keyup", function() {
     this.value=this.value.trim();
    })

    document.getElementById("lastname").addEventListener("change", function() {
     this.value=this.value.trim();
    })

    document.getElementById("email").addEventListener("keyup", function() {
     this.value=this.value.trim();
    })
</script>
<?php  include("../footer.php"); ?>
</body>

</html>
