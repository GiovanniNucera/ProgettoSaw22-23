<?php
ini_set('display_errors', false);
ini_set('error_log', 'php.log');
include("../connection.php");
session_start();
if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true || $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: login.html");
    exit();
}
$_SESSION['admin_navbar'] = true;
?>
<!DOCTYPE html>
<html>

<head>


 <link rel="stylesheet" href="../css/stylehome.css">
  <link rel="stylesheet" href="../css/ourworks.css">
  <link rel="stylesheet" href="../css/button.css">

    <link rel="stylesheet" href="css/stylehome.css">
    <!-- Qwery Table-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>


    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />


    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan|Poppins:400,600,700&display=swap" rel="stylesheet">

    <style>
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="logo"><img src="../images/LOGO.png" alt="LOGO"></div>
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
    <!-- end header section -->


    <!-- contact section -->

    <div style="margin: 50px;"></div>
    <div class="contet2">
                    <p> Donations area</p>
                </div>
                <div style="margin: 50px;"></div>
<div class="section">
<div class="contet2">
                    <p> Insert new project</p>
                </div>
                <div style="margin: 50px;"></div>
    <div class="row">
    
                <form action="insert_crowdfunding.php" method="POST" id="usrform">
                    <button input type="submit">Insert Project</button>
                    <table id="insert" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Goal</th>
                                <th>Start date</th>
                                <th>Finish date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" id="name" name="name" placeholder="Project Name"></td>
                                <td><textarea rows="3" cols="40" form="usrform" type="text" id="description" name="description" placeholder="Project Description"></textarea> </td>
                                <td><input type="number" id="goal" name="goal" min="1" placeholder="1"></td>
                                <td><input type="datetime-local" id="date_1" name="date_1" value="<?php echo date("Y-m-d") . "T" . date("H:i") ?>" min="<?php echo date("Y-m-d") . "T" . date("H:i") ?>"></td>
                                <td><input type="datetime-local" id="date_2" name="date_2" min="<?php echo date("Y-m-d") . "T" . date("H:i") ?>"></td>
                            </tr>
                        </tbody>
                    </table>
                </form>        
    </div>
</div>
<div style="margin: 50px;"></div>
<div class="section">
<div class="contet2">
                    <p> Projects</p>
                </div>
                <div style="margin: 50px;"></div>
     <div class="row">
 
                <table id="donate" class="display" style="width: 100%">

                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Goal</th>
                            <th>Raised</th>
                            <th>Difference</th>
                            <th>Start date</th>
                            <th>Finish date</th>
                            <th>Remaining days</th>
                            <th>State</th>
                        </tr>
                    </thead>
                </table>
    </div>
</div>
<div style="margin: 50px;"></div>
<div class="section">
<div class="contet2">
                    <p> Donators</p>
                </div>
                <div style="margin: 50px;"></div>
    <div class="row">
    
                <table id="donators" class="display" style="width: 100%">

                    <thead>
                        <tr>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Email</th>
                            <th>Project name</th>
                            <th>Donations</th>
                        </tr>
                    </thead>
                </table>
    </div>
</div>
<div style="margin: 50px;"></div>


    <script>
        $(document).ready(function() {
            $('#donate').DataTable({
                ajax: 'selectall_crowdfunding.php',
                dom: 'Bfrtip',
                buttons: ['print'],
                order: [
                    [6, 'desc']
                ] // default sorting
            });
        });

        $(document).ready(function() {
            $('#donators').DataTable({
                ajax: 'selectall_donators.php',
                dom: 'Bfrtip',
                buttons: ['print'],
                order: [
                    [3, 'asc']
                ] // default sorting
            });
        });

        $(document).ready(function() {
            var table = $('#insert').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                bInfo: false
            });
        });
    </script>





    </div>

</body>

</html>