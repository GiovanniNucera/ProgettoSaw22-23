<?php
session_start();
if( isset($_SESSION['userid'])){

$_SESSION = array();

session_unset();

session_destroy();

setcookie(session_name(),'',time()-42000);

header("location:index.php");
exit();
}
header("location:index.php");
exit();
?>