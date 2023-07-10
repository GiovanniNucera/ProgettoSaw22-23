<?php
include("../connection.php");
ini_set('display_errors', false);
ini_set('error_log', '../log/admin.log');
session_start();
if ($_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: ../loginform.php");
    exit();
}
$_SESSION['admin_navbar'] = true;
$query = "SELECT * FROM `user` ORDER BY `user`.`userid` ASC";
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

<?php include("head_admin.php"); ?>

<title>Users Area</title>

<?php include("navbar_admin.php"); ?>

<div style="margin: 50px;"></div>
<div class="section">
    <div class="contet2">
        <p> Users area</p>
    </div>
    <div style="margin: 50px;"></div>

    <div class="row">
    <div class="center">
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
                                        <td>' . $row["admin"] . '</td>
                                        <td>' . $row['firstname'] . '</td>
                                        <td>' . $row['lastname'] . '</td>
                                        <td>' . $row['email'] . '</td>
                                        <td>
                                        <button type="button" onclick="edt_1(' . $row["userid"] . ')" >Edit</button>
                                        <button type="button" onclick="dlt_1(' . $row["userid"] . ')" >Delete</button>
                                        </td>
                                        </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<div style="margin: 50px;"></div>
</body>

</html>
<script src="script.js"></script>