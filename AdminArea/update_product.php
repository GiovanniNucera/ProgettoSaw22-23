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

$query = "SELECT * FROM `product` WHERE `id` = ? ";
/* prepare query */
if (!$stmt = $conn->prepare($query)) {
    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    exit();
}
/* bind parameters */
if (!$stmt->bind_param("i", $_GET['id'])) {
    error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    exit();
};
/* execute query */
if (!$stmt->execute()) {
    error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    exit();
}
$result = $stmt->get_result();
if ($result->num_rows != 1) {
    header("location: admin_product.php");
    exit();
}
$row = $result->fetch_assoc();
?>
<?php include("head_admin.php"); ?>

<title>Products Area</title>

<?php include("navbar_admin.php"); ?>

<div style="margin: 50px;"></div>
<div class="section">
    <div class="contet2">
        <p> Edit product</p>
    </div>
    <div style="margin: 50px;"></div>
    <div class="row">
        <form method="POST">
            <button input type="submit">Edit Product</button>
            <table id="insert" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php echo '
                                <td><input type="text" name="name" placeholder="name" value="'.$row['name'].'" required/> </td>
                                <td><textarea rows="3" cols="40" name="description" placeholder="Product Description" required>'.$row['description'].'</textarea> </td>';  
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

if (isset($_POST['name'])&&isset($_POST['description'])) {
    $query  = "UPDATE `product` SET `name`= ?,`description`= ? WHERE `id`= ?";
    /* prepare query */
    if (!$stmt = $conn->prepare($query)) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later\n");
    }
    /* bind parameters */
    if (!$stmt->bind_param("ssi", $_POST['name'], $_POST['description'], $_GET['id'])) {
        error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    };
    /* execute query */
    if (!$stmt->execute()) {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later\n");
    }
    if ($stmt->affected_rows !== 1) {
        header('Refresh: 1; url=admin_product.php');
        exit("<h1>Something went wrong, redirect to Admin Product </h1>");
    } else {
        $conn->close();
        $stmt->close();
        header("location: admin_product.php");
        exit();
    }
}

?>