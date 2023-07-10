<?php
ini_set('display_errors', false);
ini_set('error_log', '../log/newsletter.log');
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

$query2 = "SELECT * FROM `message` WHERE `id` = ? ";
/* prepare query */
if (!$stmt = $conn->prepare($query2)) {
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
$row2 = $result->fetch_assoc();
?>
<?php include("../AdminArea/head_admin.php"); ?>

<title>Show newsletter</title>

<?php include("../AdminArea/navbar_admin.php"); ?>

<div class="contet2">

<?php      
            echo '
                    <div>
                        <p> Title </p>
                        <span> '.$row2['title'].' <span>
                    </div>

                    <div style="margin: 50px;">

                    <div>
                        <p> Text </p>
                        <span> '.$row2['text'].' <span>
                    </div>

            ';

?>

</div>


</body>
</html>