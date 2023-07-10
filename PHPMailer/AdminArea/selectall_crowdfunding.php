<?php
include("../connection.php");
session_start();
if (!isset($_SESSION['connected']) || $_SESSION['connected'] !== true || $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: login.html");
    exit();
}
$query ="SELECT name, goal, SUM(donation.amount) AS 'sum_amount',(GOAL - SUM(donation.amount)) AS 'sum_total',DATE_FORMAT(datetime,'%e %M %Y') AS 'datetime', DATE_FORMAT(enddate,'%e %M %Y') AS 'enddate', (IF(DATEDIFF(crowdfunding.enddate,CURDATE())<=0,'FINISH',DATEDIFF(crowdfunding.enddate,CURDATE()))) AS 'days',(IF(DATEDIFF(crowdfunding.enddate,CURDATE())>0,'IN PROCESS',(IF(SUM(donation.amount)>goal,'SUCCESS','FAIL')))) AS 'success' FROM crowdfunding LEFT JOIN donation ON crowdfunding.id=donation.idCrowdfunding GROUP BY crowdfunding.id";
$result = $conn->query($query);
$size = $conn->affected_rows;
$counter = 1;
echo '{"data":[';
while ($row = $result->fetch_assoc()) {
    echo '["'.$row["name"].'","'.$row["goal"].'","'.$row["sum_amount"].'","'.$row["sum_total"].'","'.$row["datetime"].'","'.$row["enddate"].'","'.$row["days"].'","'.$row["success"].'"';
    if ($counter === $size) echo ']';
    else echo '],';
    $counter++;
}
echo ']}';
$result->free();
$conn->close();
?>