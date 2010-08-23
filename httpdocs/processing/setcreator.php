<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$Email = $_GET['creator'];
$AdminID = $_GET['adminid'];
$ComicTitle = $_GET['comic'];
$ComicID = $_GET['id'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
// print "MY ACTION = ". $Action."<br>";
 $query = "SELECT * from comics where comiccrypt='$ComicID' and userid='$AdminID'";
 $result = mysql_query($query);
 $num_rows = mysql_num_rows($result);
if ($num_rows == 0) {
echo 'no';
} else {
$query = "SELECT * from users where email='$Email'";
 $result = mysql_query($query);
 $user = mysql_fetch_array($result);
 $ID = $user['encryptid'];
 $query = "UPDATE comics set CreatorID='$ID' where comiccrypt='$ComicID' and userid='$AdminID'";
 $result = mysql_query($query);
 echo 'set';
}
?>


