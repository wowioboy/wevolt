<?php 
session_start();

header( 'Content-Type: text/javascript' );
$_SESSION['newflashpages'] = $_GET['p'];
$_SESSION['readerpage'] = $_GET['page'];
?>


window.location = '<? echo $_GET['ref'];?>';