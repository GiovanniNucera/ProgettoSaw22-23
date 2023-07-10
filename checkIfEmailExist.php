<?php
      ini_set('display_errors', false);
      ini_set('error_log', 'php.log');
      include("connection.php");
      ob_start();

      $beforequery = "SELECT * FROM user WHERE email=?";

      if (!$beforestmt = $conn->prepare($beforequery))
      {
          error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
          exit("Something went wrong, visit us later\n");
      }


      //execute the statement
      $beforestmt->bind_param("s",$_POST["email"]);
      if (!$beforestmt->execute())
      {
          error_log("Execute failed: (" . $beforestmt->errno . ") " . $beforestmt->error);
          exit("Something went wrong, visit us later\n");
      }

      $beforestmt->execute();
      //fetch result
      $check = $beforestmt->fetch();
      if ($check)
      {// email exists
          echo "exist";
      }else{// email not exists
          echo "notExist";
      }

?>
