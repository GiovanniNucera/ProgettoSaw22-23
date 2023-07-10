</head>

<body>

    <nav class="navbar">
        <div class="logo"><a href="../index.php"><img src="../images/LOGO.png" alt=""></a></div>
        <div class="push-left">
            <button id="menu-toggler" data-class="menu-active" class="hamburger">
                <span class="hamburger-line hamburger-line-top"></span>
                <span class="hamburger-line hamburger-line-middle"></span>
                <span class="hamburger-line hamburger-line-bottom"></span>
            </button>
            <!--  Menu compatible with wp_nav_menu  -->
            <ul id="primary-menu" class="menu nav-menu">
                <?php
                if (isset($_SESSION['userid'])) {
                    $userid = $_SESSION['userid'];
                    $query = "SELECT * FROM user WHERE user.userid = '$userid'";

                    if ($rs = $conn->query($query))
                        if ($rs->num_rows === 1)
                            $row = $rs->fetch_array(MYSQLI_ASSOC);

                    $admin = ($row['admin']);
                    if ($admin) {
                        if (isset($_SESSION['admin_navbar']) && ($_SESSION['admin_navbar'] === true)) {
                            echo '<li class="menu-item "><a class="nav__link"  href="../index.php">HOME</a>';
                            echo '<li class="menu-item "><a class="nav__link"  href="../AdminArea/admin_donate.php">Donations Area</a>';
                            echo '<li class="menu-item "><a class="nav__link"  href="../AdminArea/admin_users.php">Users Area</a>';
                            echo '<li class="menu-item "><a class="nav__link"  href="../AdminArea/admin_product.php">Products Area</a>';
                            echo '<li class="menu-item "><a class="nav__link"  href="../newsletter/newsletter.php">Newsletters</a>';
                        }
                    }
                }

                ?>
            </ul>
        </div>
    </nav>