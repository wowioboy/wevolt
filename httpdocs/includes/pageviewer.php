<?php
include_once('init.php');
$ProjectID = $_SESSION['viewingproject'];
$UserID = $_SESSION['userid'];
$Remote = $_SERVER['REMOTE_ADDR'];
$Referal = urlencode(substr($_SERVER['HTTP_REFERER'],7,strlen($_SERVER['HTTP_REFERER'])-1));
$CurrentLink = curPageURL();
if ($ProjectID != '')
	insertPageView($ProjectID,$Pagetracking,$Remote,$_SESSION['userid'],$Referal,$CurrentLink,$_SESSION['IsPro']);
?>
