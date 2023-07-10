<?php
ini_set('display_errors', false);
ini_set('error_log', 'log/index.log');

include("connection.php");
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>FoodBank Italia</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/ourworks.css">
  <link rel="stylesheet" href="css/stylehome.css">
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="js/navbar.js"></script>
</head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<body>

  <nav class="navbar">
    <div class="logo">
      <img alt=""  src="images/LOGO.png" alt=""> 
    </div>
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
      </ul>
    </div>
  </nav>


  <img alt=""  src="images/HOME.png" style="width:100%;">


  <div style="margin: 50px;"></div>

  <div class="contet2">
    <p>We fight hunger by sourcing food for people in need</p>
  </div>

  <div style="margin: 50px;"> </div>


  <div class="row">
    <div class="column">
      <img alt=""  src="images/camion.jpg"> <p> The hunger crisis <br> More than 2 million households have run out of food in the last year.</p>
    </div>
    <div class="column">
      <img alt=""  src="images/piatto.png" > <p>What we do <br> Foodbank Italia is the pantry to the charity sector in Italia. </p>
    </div>
    <div class="column">
      <img alt=""  src="images/risultati.png" > <p>The result <br> Last year alone, we sourced enough food for over 86.7 million meals. </p>
    </div>
  </div>

  <div style="margin: 50px;"> </div>

  <div class="contet2">
    <h1>LAST NEWS</h1>
  </div>

  <div style="margin: 50px;"> </div>

  <div class="section">

    <div class="row">
      <div class="column">
        <img alt=""  src="images/bill.jpeg" style="border-radius: 10px; max-width:100%;"> <p> <a href="undercostruction.html">  Bill Gates' Big Donation: $5 Million to Charity </a> </p>
      </div>
      <div class="column">
        <img alt=""  src="images/cibotavola.png" style="border-radius: 10px; max-width:100%;" > <p> <a href="undercostruction.html"> Millions struggling to put food on table </a> </p>
      </div>
      <div class="column">
        <img alt=""  src="images/maratona.png" style="border-radius: 10px; max-width:100%;" > <p> <a href="undercostruction.html">  £1 million raised through the marathon </a> </p>
      </div>
    </div>

  </div>

  <div style="margin: 50px;"> </div>

  <div class="contet2">
    <h1>HOW TO SUPPORT US</h1>
  </div>

  <div style="margin: 50px;"> </div>

  <div class="section">

    <div class="row">
      <div class="column">
        <img alt=""  src="images/volontariato.jpeg" style="border-radius: 10px; max-width:100%;"> <p> <a href="undercostruction.html">Volunteer at FoodBank Italia <a></p>
      </div>
      <div class="column">
        <img alt=""  src="images/donazione.jpeg" style="border-radius: 10px; max-width:100%;" > <p><a href="undercostruction.html"> Donate food or goods <a></p>
      </div>
      <div class="column">
        <img alt=""  src="images/fondi.jpeg" style="border-radius: 10px; max-width:100%;" > <p><a href="undercostruction.html"> Fundraise for us <a></p>
      </div>
    </div>

  </div>

  <div style="margin: 100px;"> </div>

  <form class="newsletter" action="newsletter/addEmail.php" METHOD="POST">

      <p> Subscribe to our newsletter</p>
      <input type="text" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" name="email" placeholder="email..." required> <br>
      <button type="submit" name="submit"> SUBSCRIBE</button>

  </form>

<div style="margin: 100px"></div>

<?php  include("footer.php"); ?>

</body>
</html>
