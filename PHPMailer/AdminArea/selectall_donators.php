<?php
include("../connection.php");
session_start();
if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true || $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: login.html");
    exit();
}
$query = "SELECT lastname, firstname, email, name, SUM(donation.amount)AS 'amount' FROM `donation` JOIN `crowdfunding` ON donation.idCrowdfunding= crowdfunding.id GROUP BY donation.lastname, donation.firstname, donation.email,donation.idCrowdfunding";
$result = $conn->query($query);
$size = $conn->affected_rows;
$counter = 1;
echo '{"data":[';
while ($row = $result->fetch_assoc()) {
    echo '["'.$row["firstname"].'","'.$row["lastname"].'","'.$row["email"].'","'.$row["name"].'","'.$row["amount"].'"';
    if ($counter === $size) echo ']';
    else echo '],';
    $counter++;
}
echo ']}';
$result->free();
$conn->close();
?>