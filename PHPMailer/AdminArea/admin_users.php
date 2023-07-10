<?php
include("../connection.php");
session_start();
if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true || $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: login.html");
    exit();
}

$_SESSION['admin_navbar'] = true;

$query = "SELECT * FROM `user` ORDER BY `user`.`userid` ASC";
/* prepare query */
if (!$stmt = $conn->prepare($query)) {
    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    exit("Something went wrong, visit us later\n");
}
/* execute query */
if (!$stmt->execute()) {
    error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    exit("Something went wrong, visit us later\n");
}
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users</title>

    <link rel="stylesheet" href="../css/stylehome.css">
  <link rel="stylesheet" href="../css/ourworks.css">
  <link rel="stylesheet" href="../css/button.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>


</head>

<body>
    <nav class="navbar">
        <div class="logo"><img src="../images/LOGO.png" alt="LOGO"> </div>
        <div class="push-left">
            <button id="menu-toggler" data-class="menu-active" class="hamburger">
                <span class="hamburger-line hamburger-line-top"></span>
                <span class="hamburger-line hamburger-line-middle"></span>
                <span class="hamburger-line hamburger-line-bottom"></span>
            </button>

            <!--  Menu compatible with wp_nav_menu  -->
            <ul id="primary-menu" class="menu nav-menu">
                <?php
                include("../navbar.php");
                ?>
            </ul>
        </div>
    </nav>

    <div style="margin: 50px;"></div>
    <div class="section">
        <div class="contet2">
            <p> Users area</p>
        </div>
        <div style="margin: 50px;"></div>
        <div class="row">
            <table id="example" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Admin</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr id = "' . $row["userid"] . '">
                                        <td>' . $row["userid"] . '</td>
                                        <td><input class="editInput" type="number" name="admin"  min= "-1" max = "1" value="' . $row["admin"] . '"></td>
                                        <td>' . $row['firstname'] . '</td>
                                        <td>' . $row['lastname'] . '</td>
                                        <td>' . $row['email'] . '</td>
                                        <td> <button type="button" class="btn_edit" >Edit</button> <button type="button" class="btn_delete" >Delete</button></td>
                                        </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        </div>
        <div style="margin: 50px;"></div>
</body>

</html>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable();

        $('.btn_delete').on('click', function() {
            var trObj = $(this).closest("tr");
            var ID = $(this).closest("tr").attr('id');
            var answer = confirm("Delete Client Information? Client ID = " + ID + ". This action is permanent and cannot be undone. Are you certain you wish to delete all of client personal information, including client account from our systems?");
            if (answer) {
                $.ajax({
                    type: 'POST',
                    url: 'userAction.php',
                    data: 'action=delete&id=' + ID,
                    success: function() {
                        trObj.remove();
                    }
                });
            }
        });

        $('.btn_edit').on('click', function() {
            var trObj = $(this).closest("tr");
            var ID = $(this).closest("tr").attr('id');
            var inputData = $(this).closest("tr").find(".editInput").serialize();
            var answer = confirm("Edit Client Information? Client ID = " + ID + ". This action is permanent and cannot be undone. Are you certain you wish to edit client personal information?");
            if (answer) {
                $.ajax({
                    type: 'POST',
                    url: 'userAction.php',
                    dataType: "json",
                    data: 'action=edit&id=' + ID + '&' + inputData,
                    success: function(response) {
                        alert("ciao Cammila");
                        if (response.status == 'ok') {
                            alert("HELLO WORLD");
                        } else {
                            alert(response.msg);
                        }
                    }
                });

            }
        });
    });
</script>