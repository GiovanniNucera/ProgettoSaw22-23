<?php
include("../connection.php");
ini_set('display_errors', false);
ini_set('error_log', '../log/admin.log');
session_start();

if ( $_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: ../loginform.php");
    exit();
}

$query ="SELECT name, goal, SUM(donation.amount) AS 'sum_amount',(GOAL - SUM(donation.amount)) AS 'sum_total',DATE_FORMAT(datetime,'%e %M %Y') AS 'datetime', DATE_FORMAT(enddate,'%e %M %Y') AS 'enddate', (IF(DATEDIFF(crowdfunding.enddate,CURDATE())<=0,'FINISH',DATEDIFF(crowdfunding.enddate,CURDATE()))) AS 'days',(IF(DATEDIFF(crowdfunding.enddate,CURDATE())>0,'IN PROCESS',(IF(SUM(donation.amount)>goal,'SUCCESS','FAIL')))) AS 'success' FROM crowdfunding LEFT JOIN donation ON crowdfunding.id=donation.idCrowdfunding GROUP BY crowdfunding.id";

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