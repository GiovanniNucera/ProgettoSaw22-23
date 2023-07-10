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
$query = "SELECT * FROM `product` ORDER BY `id` ";
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

<title>Products Area</title>

<?php include("navbar_admin.php"); ?>

<div style="margin: 50px;"></div>

<div class="contet2">
    <p> Products area</p>
</div>

<div style="margin: 50px;"></div>
<div class="section">
    <div class="contet2">
        <p> Insert new product</p>
    </div>
    <div style="margin: 50px;"></div>
    <div class="row">
    <div class="center">
        <form action="insert_product.php" method="POST">
            <button><input type="submit" value="Insert New Product"></button>
            <table id="insert" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="number" name="ide" placeholder="id" min = "1" required></td>
                        <td><input type="text" name="name" placeholder="name" required ></td>
                        <td><textarea rows="3" cols="40" name="description" placeholder="Product Description" required></textarea> </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    </div>
</div>
<div style="margin: 50px;"></div>
<div class="section">
    <div class="contet2">
        <p> Products</p>
    </div>
    <div style="margin: 50px;"></div>
    <div class="row">
    <div class="center">
        <table id="example" class="display" style="width: 100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr id = "' . $row["id"] . '">
                                    <td>' . $row["id"] . '</td>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . $row['description'] . '</td>
                                    <td> <button type="button"  onclick="edt('.$row["id"].')" >Edit</button>
                                        <button type="button"  onclick="dlt('.$row["id"].')" >Delete</button> </td>
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