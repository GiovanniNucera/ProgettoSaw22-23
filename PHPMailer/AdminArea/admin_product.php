<?php
include("../connection.php");
session_start();
if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true || $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: login.html");
    exit();
}
$_SESSION['admin_navbar'] = true;

$query = "SELECT * FROM `product` ORDER BY `id` ";
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

  <div class="contet2"> <p> Product area</p> </div>

  <div style="margin: 50px;"></div>

  <div class="row"> 
  <table id="t_search" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="userData">
                            <?php
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<form action="admin_delete_user.php">
                                    <td>' . $row['id'] . '</td>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . $row['description'] . '</td>
                                    <td> <button type="button" >Edit</button>
                                    <button input type="submit">Delete</button>
                                    </td>
                                    </tr>
                                    </form>
                                    ';
                                }
                            } else {
                                echo '<tr><td colspan="5">No user(s) found......</td></tr>';
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
        $('#t_search').DataTable({
            dom: 'Bfrtip',
            buttons: ['print']
        });
    });
</script>