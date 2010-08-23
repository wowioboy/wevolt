<?php 
include '../includes/db.class.php';
$UserID = $_GET['u'];
$db = new DB();
if ($_GET['a'] == 'twitter') {
	$query = "SELECT Twittername from users where encryptid = '$UserID'";
	$Value = $db->queryUniqueValue($query);
}
$db->close();
echo $Value;
?>