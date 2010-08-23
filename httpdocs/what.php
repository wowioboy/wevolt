<?php 
include 'includes/init.php';
//SUPRISE CODE
$_SESSION['suprise_code'] ='saywhat_50';
$_SESSION['suprise_redirect'] =$_SESSION['refurl'];
//include 'includes/functions.php';
header("location:suprise_me.php");
?>