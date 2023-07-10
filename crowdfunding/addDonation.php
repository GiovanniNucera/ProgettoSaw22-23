<?php
      include("../connection.php");
      session_start();
      ini_set('display_errors', false);
      ini_set('error_log', '../log/crowdfunding.log');


      if($_SESSION['thisdonation'] != $_POST["uniqueDonation"])
      {
        header('Refresh: 2; url=crowdfunding.php');
        exit("Something went wrong, Redirecting to Crowdfunding page\n");
      }


      if (empty($_POST["email"]) || empty($_POST["firstname"])|| empty($_POST["lastname"]) || empty($_POST["amount"])|| empty($_POST["idCrowdfunding"]) )
      {
        header('Refresh: 2; url=crowdfunding.php');
        exit("Some fields are empty, Redirecting to Crowdfunding page\n");
      }

      $email = trim($_POST["email"]);
      $firstname = trim($_POST["firstname"]);
      $lastname = trim($_POST["lastname"]);

      if(!(filter_var($email,FILTER_VALIDATE_EMAIL) && filter_var($_POST["amount"],FILTER_VALIDATE_INT) && filter_var($_POST["idCrowdfunding"],FILTER_VALIDATE_INT)))
      {
        header('Refresh: 2; url=crowdfunding.php');
        exit("Input error , Redirecting to Crowdfunding page\n");
      }

      if($_POST["amount"]<=0)
      {
        header('Refresh: 2; url=crowdfunding.php');
        exit("Input error , Redirecting to Crowdfunding page\n");
      }
      
      $_SESSION['emailcrowdfunding'] = $email;

      $query2 = "SELECT * FROM crowdfunding WHERE id=".$_POST["idCrowdfunding"];
      $res2 = $conn->query($query2);
      if (!$res2) {
          error_log("Query failed:" . $conn->error);
          exit("Something went wrong, visit us later\n");
      }

      $row2 = $res2->fetch_assoc();

      $enddate = strtotime($row2['enddate']);
      $currdate = strtotime(date('Y-m-d H:i:s'))+3600;
      $startdate =  strtotime($row2['datetime']);

      if($enddate <= $currdate)
      {
        header('Refresh: 2; url=crowdfunding.php');
        exit("Crowdfunding expired, Redirecting to Crowdfunding page\n");
      }

      if($startdate >= $currdate)
      {
        header('Refresh: 2; url=crowdfunding.php');
        exit("Crowdfunding will start soon, Redirecting to Crowdfunding page\n");
      }

      $query = "INSERT INTO donation (firstname,lastname,email,amount,idCrowdfunding) VALUES (?,?,?,?,?)";
      if (!$stmt = $conn->prepare($query))
      {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        header('Refresh: 2; url=crowdfunding.php');
        exit("Something went wrong, Redirecting to Donation page\n");
      }

      $stmt->bind_param("sssii", $firstname ,$lastname,$email,$_POST["amount"],$_POST["idCrowdfunding"]);

      if (!$stmt->execute())
      {
          error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
          header('Refresh: 2; url=crowdfunding.php');
          exit("Something went wrong, Redirecting to Donation page\n");
      }
      unset($_SESSION['thisdonation']);
      $stmt->close();
      $res2->free();
      $conn->close();
      header('Location: donationSuccessful.php');
?>
