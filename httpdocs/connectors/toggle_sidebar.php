<?php 
session_start();
header( 'Content-Type: text/javascript' );
$_SESSION['sidebartoggle'] = $_GET['status'];

?>
window.location = '<? echo $_GET['ref'];?>';


 