<?php
      include("connection.php");
      ob_start();
      session_start();
      ini_set('display_errors', false);
      ini_set('error_log', 'log/registration.log');

      if (!isset($_SESSION['userid'])) {
        header("location: login.php");
        exit();
      }

      if (empty($_POST["city"]) && empty($_POST["selfdescription"]) && empty($_POST["socialurl"]) && empty($_POST["cf"]) )
      {
        header("location: show_profile.php");
        exit();
      }


      if(strlen($_POST["socialurl"]) > 0)
      {
        if(!filter_var($_POST["socialurl"],FILTER_VALIDATE_URL) )
        {
          header("Refresh: 2; url=show_profile.php");
          exit("socialurl wrong, Redirecting to your Account page\n");
        }
      }

      if(strlen($_POST["cf"]) > 0)
      {
        if(strlen($_POST["cf"]) != 16)
        {
          header("Refresh: 2; url=show_profile.php");
          exit("CF wrong, Redirecting to your Account page\n");
        }
      }

      $query = "INSERT INTO user_profile (userid,city,selfdescription,socialurl,cf) VALUES (?,?,?,?,?)";

      if (!$stmt = $conn->prepare($query))
      {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        header("Refresh: 2; url=show_profile.php");
        exit("Something went wrong, Redirecting to your Account page\n");
      }

      $stmt->bind_param("issss",$_SESSION['userid'], $_POST["city"] ,$_POST["selfdescription"], $_POST["socialurl"],$_POST["cf"]);

      if (!$stmt->execute())
      {
          if($stmt->errno == 1062)
          {
            header("Refresh: 2; url=show_profile.php");
            exit("This user_profile already exists on our system, Redirecting to your Account page\n");
          }
          error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
          header("Refresh: 2; url=show_profile.php");
          exit("Something went wrong, Redirecting to your Account page\n");
      }
      header("location: show_profile.php");
      mysqli_close($conn);

?>
