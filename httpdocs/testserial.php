<?php 
$ID = '22';
$userhost = 'localhost';
$dbuser = 'outland_users';
$userpass='kugtov.02';
$userdb = 'outland_users';
 mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 mysql_select_db ($userdb) or die ('Could not select database.');
// print "MY ACTION = ". $Action."<br>";
 $query = "SELECT * from $usertable where userid='$ID'";
 $result = mysql_query($query);
 $user = mysql_fetch_array($result);

$users = 'Fuck this piece of fucking shite you know what I mean? ';

$myValues = array (
 'username' => $users,
 'friendly' => 'db1',
 'user' => 'root',
 'pass' => 'temp'
);

echo serialize ($myValues);

?>