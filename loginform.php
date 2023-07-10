<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/stylehome.css">
  <link rel="stylesheet" href="css/login.css">
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script src="js/navbar.js"></script>
  <title>Login</title>
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
        </ul>
    </div>
  </nav>

  <div class="home">
    <h1>LOGIN</h1>
  </div>


  <div class="login-page">
    <div class="form">
      <form class="login-form" action="login.php" id="myForm" method="post" enctype="multipart/form-data">
        <input type="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" id="email" name="email" placeholder="Email" required >
        <input type="password" id="pass" name="pass" placeholder="Password" required >
        <span id="error" class="error" style="color: #DC143C;"></span>
        <button id="buttonSubmit" type="submit">LOGIN</button>
        <hr><br>
        <button> <a href="#"
            onclick="return prompt('Reset Password: provide your account email address to receive an email to reset your password. Email Address: ')">Forgot
            password?</a> </button> <br>
        <p class="message"><h4>Don't have an account yet?</h4> <a href="newAC.php"><h4>Create an account</h4></a></p>
      </form>
    </div>
  </div>
  <script>
    var pass = document.getElementById("pass");
    var email = document.getElementById("email");
    var buttonForm = document.getElementById("buttonSubmit");

    document.getElementById("email").addEventListener("keyup", function() {
     this.value=this.value.trim();
    })

    function checkdata(event) {
      event.preventDefault();
      let options = {
        method: "post",
        headers: { "Content-type": "application/x-www-form-urlencoded" },
        body: "email=" + document.getElementById("email").value + "&pass=" + document.getElementById("pass").value
      };


      //nel caso in cui la risposta da parte dell'endpoint tarda ad arrivare invio comunque il form tanto verrà gestito comunque il tutto lato server
      let timeoutId = setTimeout(() =>
      {
        if(!document.getElementById("myForm").checkValidity())
        {
            document.getElementById("error").innerHTML = "<h4>Invalid email or password format.</h4>";
            return;
        }else{document.getElementById("myForm").submit();}
      }, 1500);

      fetch('https://saw21.dibris.unige.it/~S5066337/foodbanksaw/checkIfPasswordExist.php', options)
        .then((response) =>
            {
              //la risposta da parte dell'endpoint è arrivata, non server piu il settimer di prima
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
        .then(function (body) {
          if (document.getElementById("myForm").checkValidity()) {
            switch (body) {
              case "emailnotexist":
                document.getElementById("error").innerHTML = "<h4>This email address not exists on our system</h4>";
                break;
              case "emailexistpasswordnotmatch":
                document.getElementById("error").innerHTML = "<h4>Wrong password</h4>";
                break;
              case "emailexistpasswordmatch":
                document.getElementById("myForm").submit();
                break;
            }
          }else{document.getElementById("error").innerHTML = "<h4>Invalid email or password format.</h4>";}

        });
    }
    buttonForm.onclick = checkdata;

    window.addEventListener("pageshow", () => {
    document.getElementById("email").value ="";
    document.getElementById("pass").value ="";
  });
  </script>
</body>
</html>
