<?php 
include_once($_SERVER['DOCUMENT_ROOT']. '/includes/init.php'); 
$db = new DB('wevolt', '74.208.185.115', 'wevolt', 'wX4eY.xUDaFHZxEY');

$query = "select * from users where encryptid = 'd67d8ab427'";
$user = $db->queryUniqueObject($query);
var_dump($user);

?>