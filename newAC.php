<?php
ini_set('display_errors', false);
ini_set('error_log', 'log/registration.log');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/stylehome.css">
  <link rel="stylesheet" href="css/login.css">
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="js/navbar.js"></script>
  <style>
    .error {
      color: #DC143C;
    }
  </style>
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

    <div class="home">
      <h1>NEW ACCOUNT</h1>
    </div>


    <div class="login-page">
      <div class="form">
          <form class="login-form" action="registration.php"  id="myForm"  method="post"  enctype="multipart/form-data">

          <input type="text" id = "firstname" name="firstname" placeholder="Firstname" required>

          <input type="text" id = "lastname" name="lastname" placeholder="Lastname" required>

          <input type="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" id = "email" name="email" placeholder="Email" required>

          <input type="password" id = "pass" name="pass" placeholder="Password" required>

          <input type="password" id = "confirm" name="confirm" placeholder="Confirm password" required>

          <span id="error" class="error"></span>

          <button id="buttonSubmit" type="submit">CREATE</button>
        </form>
      </div>
    </div>
    <script>
    var pass = document.getElementById("pass");
    var email = document.getElementById("email");
    var confirm = document.getElementById("confirm");
    var buttonForm = document.getElementById("buttonSubmit");


    document.getElementById("firstname").addEventListener("keyup", function() {
     this.value=this.value.trim();
    })
    document.getElementById("lastname").addEventListener("change", function() {
     this.value=this.value.trim();
     console.log("ciao");
    })
    document.getElementById("email").addEventListener("keyup", function() {
     this.value=this.value.trim();
    })



    function validatePassword()
    {
      if(pass.value != confirm.value)
      {
        document.getElementById("error").innerHTML = "<h4>Passwords Don't Match.</h4>"
        return false;
      }else{document.getElementById("error").innerHTML = "";}
      return true;
    }


    function checkemail(event)
    {
      event.preventDefault();
      let options = { method: "post",
      headers: { "Content-type": "application/x-www-form-urlencoded" },
      body: "email=" + document.getElementById("email").value
      };

      //nel caso in cui la risposta da parte dell'endpoint tarda ad arrivare invio comunque il form tanto verrà gestito comunque il tutto lato server
      let timeoutId = setTimeout(() =>
      {
        if(!document.getElementById("myForm").checkValidity())
        {
            document.getElementById("error").innerHTML = "<h4>Invalid input format.</h4>";
            return;
        }else{document.getElementById("myForm").submit();}
      }, 1500);

      fetch('https://saw21.dibris.unige.it/~S5066337/foodbanksaw/checkIfEmailExist.php',options)
      .then((response) =>
          {
            //la risposta da parte dell'endpoint è arrivata, non serve piu il settimeout di prima
              clearTimeout(timeoutId);
             if (response.ok)
             {
              return response.text();
             }
            //nel caso in cui la risposta da parte dell'endpoint arriva rejected invio comunque il form tanto verrà gestito comunque il tutto lato server
             if(!document.getElementById("myForm").checkValidity())
             {
                 document.getElementById("error").innerHTML = "<h4>Invalid email or password format.</h4>";
                 return;
             }else{document.getElementById("myForm").submit();}
          })
      .then(function (body)
      {
        if(body == "exist")
        {
          document.getElementById("error").innerHTML = "<h4>This email address already exists on our system.</h4>";
        }
        else{
          if(validatePassword())
          {
            if(document.getElementById("myForm").checkValidity())
              {
                document.getElementById("myForm").submit();
              }else
              {
                document.getElementById("error").innerHTML = "<h4>Invalid input format.</h4>";
              }
          }
        }
      });
    }
    buttonForm.onclick = checkemail;
    confirm.onkeyup = validatePassword;


    //pulisce i campi di input quando torni indietro con il tasto del browser
    window.addEventListener("pageshow", () => {
      document.getElementById("firstname").value ="";
      document.getElementById("lastname").value ="";
      document.getElementById("email").value ="";
      document.getElementById("pass").value ="";
      document.getElementById("confirm").value ="";
    });
    </script>
</body>
</html>
