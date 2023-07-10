<?php
include("../connection.php");
session_start();
ini_set('display_errors', false);
ini_set('error_log', '../log/newsletter.log');
if ($_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
  header("location: ../loginform.php");
  exit();
}
$query = "SELECT message.userid, message.id, message.text, message.title, user.firstname, user.lastname, DATE_FORMAT(message.date,'%e %M %Y %H:%i')as'date'\n"

    . "FROM message\n"

    . "LEFT JOIN user\n"

    . "ON message.userid=user.userid";

if (!$stmt = $conn->prepare($query)) {
    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    exit("Something went wrong, visit us later\n");
}
if (!$stmt->execute()) {
    error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    exit("Something went wrong, visit us later\n");
}
$result = $stmt->get_result();
?>

<?php include("../AdminArea/head_admin.php"); ?>

<title>newsletter</title>

<?php include("../AdminArea/navbar_admin.php"); ?>

<div class="contet2" style="margin-top: 5%">
    <p> Last newsletter </p>
</div>
<div style="margin: 50px;"></div>
<div class="row">
 <div class="center">
    <table id="example" class="display" style=" width: 100%">
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>MessageID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    <?php

                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr id = "' . $row["id"] . '">
                                    <td>' . $row["userid"] . '</td>
                                    <td>' . $row["firstname"] . '</td>
                                    <td>' . $row["lastname"] . '</td>
                                    <td>' . $row["id"] . '</td>
                                    <td>' . $row['title'] . '</td>
                                    <td>' . $row['date'] . '</td>
                                    <td> <button type="button"  onclick="show('.$row["id"].')" >See</button> </td>
                                </tr>';
                        }
                    }

                    ?>
            </tbody>
        </table>
 </div>
</div>




    <div class="contet2" style="margin-top: 5%">
        <p> New newsletter </p>
    </div>

    <div class="login-page">
      <div class="form">
        <form class="login-form" method="post" action="sendEmail.php">
          <input type="text" name="oggetto" placeholder="Object" required>
          <input type="text" name="title" placeholder="Title" required>
          <textarea name="text" placeholder="Text" maxlenght="1000" required></textarea>
          <input type="submit" name="submit" value="Send">
        </form>
      </div>
    </div>

</body>

<script src="../AdminArea/script.js"></script>

</html>
