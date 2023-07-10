<?php

include("connection.php");
session_start();

if (!isset($_SESSION['userid'])) {
    header("location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/stylehome.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
    <title>Edit Password</title>
</head>
    <body>
        <nav class="navbar">
            <div class="logo"><img src="images/LOGO.png" alt="LOGO"></div>
            <div class="push-left">
                <button id="menu-toggler" data-class="menu-active" class="hamburger">
                    <span class="hamburger-line hamburger-line-top"></span>
                    <span class="hamburger-line hamburger-line-middle"></span>
                    <span class="hamburger-line hamburger-line-bottom"></span>
                </button>
                <!--  Menu compatible with wp_nav_menu  -->
                <ul id="primary-menu" class="menu nav-menu">
                    <?php include("navbar.php");?>
                </ul>
            </div>
        </nav>

        <div style="margin: 50px;"></div>
        <div class="home">
            <h1>Edit Password</h1>
        </div>
        <div class="section">
            <div class="row">
                <div class="column">
                        <div class="form">
                            <form action="update_password.php" method="post" class="login-form" id="myForm" enctype="multipart/form-data">
                                <input type="password" id="pass_old" name="pass_old" placeholder="Password" required />
                                <input type="password" id="pass_new" name="pass_new" placeholder="New Password" required />
                                <input type="password" id="confirm" name="confirm" placeholder="Confirm" required />
                                <span id="error" class="error" style="color: #DC143C;"></span>
                                <button id=submit type="submit">SAVE </button>
                                <hr><button id=reset type="reset"> CANCEL</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
        <div style="margin: 50px;"></div>
    </body>
    <?php  include("footer.php"); ?>

</html>

<script>
    var pass = document.getElementById("pass_new");
    var confirm = document.getElementById("confirm");

    function validatePassword() {
        if (pass.value != confirm.value) {
            document.getElementById("error").innerHTML = "Passwords Don't Match"
            return false;
        } else {
            document.getElementById("error").innerHTML = "";
        }
        return true;
    }
    confirm.onkeyup = validatePassword;
</script>
