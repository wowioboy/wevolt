<?php
include '../includes/dbconfig.php';
$ID = $_POST['userid'];
$Location = $_POST['userlocation'];
$About = $_POST['about'];
$Hobbies = $_POST['hobbies'];
$Website = $_POST['website'];
$Link1 = $_POST['link1'];
$Link2 = $_POST['link2'];
$Link3 = $_POST['link3'];
$Link4 = $_POST['link4'];
$Credits = $_POST['credits'];
$Music = $_POST['music'];
$Books = $_POST['books'];
$Influences = $_POST['influences'];

mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
// print "MY ACTION = ". $Action."<br>";
$query = "UPDATE $usertable SET location='$Location' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET about='$About' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET hobbies='$Hobbies' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET music='$Music' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET books='$Books' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET influences='$Influences' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET website='$Website' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET credits='$Credits' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET link1='$Link1' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET link2='$Link2' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET link3='$Link3' WHERE userid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET link4='$Link4' WHERE userid='$ID'";
$result = mysql_query($query);

?>
