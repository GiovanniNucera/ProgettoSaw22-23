<?php
ini_set('display_errors', false);
ini_set('error_log', 'log/updateprofile.log');

include("connection.php");
session_start();

if (!isset($_SESSION['userid'])) {
    header("location: index.php");
    exit();
}

$userid = $_SESSION['userid'];
$query_2 = "SELECT * FROM user LEFT JOIN user_profile ON user.userid = user_profile.userid WHERE user.userid = '$userid'";

if ($result = $conn->query($query_2))
    if ($result->num_rows === 1)
        $row = $result->fetch_array(MYSQLI_ASSOC);

$firstname = htmlspecialchars($row['firstname']);
$lastname = htmlspecialchars($row['lastname']);
$email = htmlspecialchars($row['email']);
$city = $row['city'] !== NULL ? htmlspecialchars($row['city']) : "";
$selfdescription = $row['selfdescription'] !== NULL ? htmlspecialchars($row['selfdescription']) : "";
$socialurl = $row['socialurl'] !== NULL ? htmlspecialchars($row['socialurl']) : "";
$cf = $row['cf'] !== NULL ? htmlspecialchars($row['cf']) : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/stylehome.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
    <script src="js/navbar.js"></script>
    <title>Edit Profile</title>
</head>

<body>
    <nav class="navbar">
        <div class="logo"><img src="images/LOGO.png" alt="LOGO"></div>
        <div class="push-left">
            <button id="menu-toggler" data-class="menu-active" class="hamburger">
                <span class="hamburger-line hamburger-line-top"></span>
                <span class="hamburger-line hamburger-line-middle"></span>
                <span class="hamburger-line hamburger-line-bottom"></span>
            </button>
            <!--  Menu compatible with wp_nav_menu  -->
            <ul id="primary-menu" class="menu nav-menu">
                <?php
                include("navbar.php");
                ?>
            </ul>
        </div>
    </nav>
    <!-- contact section -->
    <div class="home">
        <h1>Edit Profile</h1>
    </div>
    <div class="section">
        <div class="row">
            <div class="column">
                <div class="form">
                    <form class="login-form" action="update_profile.php" method="post">
                        <?php
                        echo '<input type="text" id = "firstname" name="firstname" placeholder="First name" value="' . $firstname . '" required />
                                <input type="text" id = "lastname" name="lastname" placeholder="Last name" value="' . $lastname . '" required />
                                <input type="email" id = "email" name="email" placeholder="Email" value="' . $email . '" required />
                                <input type="text" id="city" name="city" placeholder="City" value="' . $city . '" />
                                <textarea id="selfdescription" name="selfdescription" rows="7" cols="50" maxlength="400" placeholder="Self description">' . $selfdescription . '</textarea>
                                <input type="url"  id="socialurl" name="socialurl" placeholder="Social url" value="' . $socialurl . '" />
                                <input type="cf" pattern="^[A-Z]{6}[A-Z0-9]{2}[A-Z][A-Z0-9]{2}[A-Z][A-Z0-9]{3}[A-Z]$" id="cf" name="cf" maxlength="16"  placeholder="Italian social number" value="' . $cf . '"/>
                                <span id="error" class="error"></span>
                                <button id=submit type="submit">SAVE </button> <br>
                                <hr><button id=reset type="reset"> CANCEL</button>';
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>

</html>
<script>
    var email = document.getElementById("email");

    function checkemail() {
        let options = {
            method: "post",
            headers: {
                "Content-type": "application/x-www-form-urlencoded"
            },
            body: "email=" + document.getElementById("email").value
        };
        fetch('https://saw21.dibris.unige.it/~S5066337/foodbanksaw/checkIfEmailExist.php', options)
            .then(response => response.text())
            .then(function(body) {
                if (body == "exist") {
                    email.setCustomValidity("This email address already exists on our system");
                } else {
                    email.setCustomValidity("");
                }
            });
    }
    email.onkeyup = checkemail;
</script>
<?php
$result->free();
?>