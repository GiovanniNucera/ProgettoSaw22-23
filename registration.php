<?php
      include("connection.php");
      ob_start();
      ini_set('display_errors', false);
      ini_set('error_log', 'log/registration.log');

      if (empty($_POST["email"]) || empty($_POST["firstname"])|| empty($_POST["lastname"]) || empty($_POST["pass"]) )
      {
        header('Refresh: 2; url=newAC.php');
        exit("Some fields are empty, Redirecting to Registration page\n");
      }

      $email = trim($_POST["email"]);
      $firstname = trim($_POST["firstname"]);
      $lastname = trim($_POST["lastname"]);

      if( !filter_var($email,FILTER_VALIDATE_EMAIL) )
      {
        header('Refresh: 2; url=newAC.php');
        exit("Input error , Redirecting to Registration page\n");
      }


      if($_POST['pass'] != $_POST['confirm'])
      {
          header('Refresh: 2; url=newAC.php');
          exit("<h1>passwords do not match, Redirecting to Registration page</h1>");
      }

      $query = "INSERT INTO user (firstname,lastname,email,pass) VALUES (?,?,?,?)";
      $pass=password_hash($_POST["pass"], PASSWORD_DEFAULT);
      if (!$stmt = $conn->prepare($query))
      {
          error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
          header('Refresh: 2; url=newAC.php');
          exit("Something went wrong, Redirecting to Registration page\n");
      }

      $stmt->bind_param("ssss", $firstname ,$lastname, $email,$pass);

      if (!$stmt->execute())
      {
          if($stmt->errno == 1062)
          {
            header('Refresh: 2; url=newAC.php');
            exit("This email address already exists on our system\n");
          }

          error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
          header('Refresh: 2; url=newAC.php');
          exit("Something went wrong, Redirecting to Registration page\n");
      }


      session_start();

      $query2 = "SELECT * FROM user WHERE email = ?";
      /* prepare query */
      if (!$stmt2 = $conn->prepare($query2)) {
          error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
          header("location: loginform.php"); //se per qualche motivo non riesco a recuperare userid, non riesco a creare la sessione e quindi conviene reindirizzare alla pagina di login
      }
      /* bind parameters */
      if (!$stmt2->bind_param("s", $email)) {
          error_log("Binding parameters failed: (" . $stmt2->errno . ") " . $stmt2->error);
          header("location: loginform.php");//se per qualche motivo non riesco a recuperare userid, non riesco a creare la sessione e quindi conviene reindirizzare alla pagina di login
      };
      /* execute query */
      if (!$stmt2->execute()) {
          error_log("Execute failed: (" . $stmt2->errno . ") " . $stmt2->error);
          header("location: loginform.php"); //se per qualche motivo non riesco a recuperare userid, non riesco a creare la sessione e quindi conviene reindirizzare alla pagina di login
      }
      $result2 = $stmt2->get_result();

      $row2 = $result2->fetch_assoc();


      $_SESSION['userid'] = $row2['userid'];
      $_SESSION['admin'] = false;


      header("location: optionalRegistration.php");
      mysqli_close($conn);

?>
