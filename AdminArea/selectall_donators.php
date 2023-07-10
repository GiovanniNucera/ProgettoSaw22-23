<?php
include("../connection.php");
ini_set('display_errors', false);
ini_set('error_log', '../log/admin.log');
session_start();

if ( $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: ../loginform.php");
    exit();
}

$query = "SELECT lastname, firstname, email, name, SUM(donation.amount)AS 'amount' FROM `donation` JOIN `crowdfunding` ON donation.idCrowdfunding= crowdfunding.id GROUP BY donation.lastname, donation.firstname, donation.email,donation.idCrowdfunding";

$result = $conn->query($query);

$data = array();
/* fetch object array */
while ($row = $result->fetch_row()) {
    $data[] = $row;
}

$json_data = array(
    "data" => $data
);

echo json_encode($json_data);

?>