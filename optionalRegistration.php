<?php
session_start();
ini_set('display_errors', false);
ini_set('error_log', 'log/registration.log');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Optional Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/stylehome.css">
  <link rel="stylesheet" href="css/login.css">
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="js/navbar.js"></script>
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

      <ul id="primary-menu" class="menu nav-menu">
          <?php
              include("navbar.php");
          ?>

        </li>
      </ul>


    </div>
  </nav>

    <div class="home">
      <h1>OPTIONAL REGISTRATION</h1>
    </div>


    <div class="login-page">
      <div class="form">
          <form class="login-form" action="addoptionalRegistration.php"  id="myForm" onsubmit="return checkIfAllFieldEmpty()"  method="post"  enctype="multipart/form-data">

            <input type="text" id="city" name="city" placeholder="City">

            <textarea id="selfdescription" name="selfdescription" rows="7" cols="50" maxlength="400" placeholder="Self Description"></textarea>

            <input type="url"  id="socialurl" name="socialurl" placeholder="Social url" >


            <input type="text" pattern="^[A-Z]{6}[A-Z0-9]{2}[A-Z][A-Z0-9]{2}[A-Z][A-Z0-9]{3}[A-Z]$" id="cf" name="cf" maxlength="16"  placeholder="Italian Social number">

          <span id="error" class="error"></span>

          <button id="buttonSubmit" type="submit">INVIA</button> <hr>
          <button id="buttonSkip" type="submit">SKIP FOR NOW</button>
        </form>
      </div>
    </div>

</html>

<script>
var buttonForm = document.getElementById("buttonSkip");


function checkIfAllFieldEmpty()
{
    var city = document.getElementById("city").value;
    var selfdescription = document.getElementById("selfdescription").value;
    var socialurl = document.getElementById("socialurl").value;
    var cf = document.getElementById("cf").value;
    if (city == "" && selfdescription == "" && socialurl == "" && cf == "" )
    {
        skip(event);
    }else {
        return true;
    }
}


function skip(event)
{
  event.preventDefault();
  window.location.replace('show_profile.php');
}


buttonForm.onclick = skip;

</script>
