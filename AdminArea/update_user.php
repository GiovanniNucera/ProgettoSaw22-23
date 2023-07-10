<?php
ini_set('display_errors', false);
ini_set('error_log', '../log/admin.log');
include("../connection.php");
session_start();
if ($_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: ../loginform.php");
    exit();
}
$_SESSION['admin_navbar'] = true;
if (!isset($_GET['id'])) {
    header("location: ../loginform.php");
    exit();
}

?>
<?php include("head_admin.php"); ?>

<title>Users Area</title>

<?php include("navbar_admin.php"); ?>

<div style="margin: 50px;"></div>
<div class="section">
    <div class="contet2">
        <p> Edit user</p>
    </div>
    <div style="margin: 50px;"></div>
    <div class="row">
        <form method="POST">
            <button input type="submit">Edit User</button>
            <table id="insert" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php echo '
                                <td><input type="number" name="admin" min = "-1" max = "1" required/> </td>';
                        ?>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
</body>

</html>

<script src="script.js"></script>

<?php
if (isset($_POST['admin'])) {
    $query  = "UPDATE `user` SET `admin`=? WHERE `userid`= ?";
    if (!$stmt = $conn->prepare($query)) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later\n");
    }
    if (!$stmt->bind_param("ii", $_POST['admin'], $_GET['id'])) {
        error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    };
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    }
    if ($stmt->affected_rows !== 1) {
        header('Refresh: 1; url=admin_users.php');
        exit("<Something went wrong, redirect to Admin Product");
    } else {
        $conn->close();
        $stmt->close();
        header("location: admin_users.php");
        exit();
    }
}

?>