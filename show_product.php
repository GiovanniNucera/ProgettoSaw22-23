<?php
include("connection.php");
session_start();
ini_set('display_errors', false);
ini_set('error_log', 'log/product.log');

if (!isset($_SESSION['userid'])) {
    header("location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/stylehome.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/ourworks.css">
    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
    <script src="js/navbar.js"></script>

    <style>
        .error {
            color: red;
            text-align: center;
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
                echo'<li class="menu-item "><div><form action="" id="myForm"method="GET">
                <input id="searchquery" class="searchBar" type="text" name="searchquery" placeholder="Search product..."autofocus>
                <button>Search</button>
                </form>
                </div>';
                include("navbar.php");
                ?>
            </ul>


        </div>
    </nav>

    <!-- end header section -->


    <div class="home">
        <h1>
            PRODUCTS
        </h1>
    </div>

    </div>
    <div class="section">
        <div class="row" id="products">
            <?php



            if(isset($_GET['searchquery']))
            {
                $query2 = "SELECT * FROM product where name  LIKE CONCAT( '%',?,'%')";
                if (!$stmt = $conn->prepare($query2))
                {
                    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                    exit("Something went wrong\n");
                }

                $stmt->bind_param("s", $_GET['searchquery'] );

                if (!$stmt->execute())
                {
                    error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
                    exit("Something went wrong\n");
                }

                $result2 = $stmt->get_result();
            }else{
              $query2 = "SELECT * FROM product";
              $result2 = $conn->query($query2);
              if (!$result2 ) {
                  error_log("Query failed:" . $conn->error);
                  exit("Something went wrong, visit us later\n");
              }
            }

            while ($row2 = $result2->fetch_assoc()) {
                echo '<div class="column">
                        <img src="products/' . $row2['id'] . '.png" alt="" style="border-radius: 10px; height: 200px; max-width:100%; ">
                        <h3>' . $row2['name'] . ' id: ' . $row2['id'] . '</h3>
                        <p>' . $row2['description'] . '</p>
                        </div>';
            }
            ?>

        </div>
    </div>

</body>
<?php  include("footer.php"); ?>
<script>  //Ogni volta che si  inserisce un carattere nella barra di ricerca la pagina si riaggiorna con query sql aggiornata
    let searchParams = new URLSearchParams(window.location.search);
    let val = searchParams.get('searchquery');

    document.getElementById("searchquery").addEventListener("keyup", function() {
      setTimeout(() => {}, 1000);
      document.getElementById("myForm").submit();
    })

    window.onload = function()
    {
      document.getElementById("searchquery").value = val;
    };

</script>
</html>
