<?php 
include_once('../includes/init.php'); 
$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

$userid = $_SESSION['userid'];
$id = $_REQUEST['id'];
$type = trim($_REQUEST['type']);

//var_dump($id, $type); exit;

if (!$userid || !$id || !$type) {
	echo 3;
	return;
}
$count = $db->countOf('follows', "user_id = '$userid' and follow_id = '$id' and type = '$type'");
if ($count) {
	$query = "delete from follows where user_id = '$userid' and follow_id = '$id' and type = '$type'";
	$db->query($query);
	echo 2;
} else {
	$query = "insert into follows (user_id, follow_id, type) values ('$userid', '$id', '$type')";
	$db->query($query);
	echo 1;
}