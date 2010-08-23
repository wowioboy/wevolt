<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$Email = $_GET['email'];
$UserID = $_GET['userid'];
$ComicID = $_GET['comic'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
 $query = "SELECT userid from comics where comiccrypt='$ComicID'";
 $result = mysql_query($query);
 $user = mysql_fetch_array($result);
 $num_rows = mysql_num_rows($result);
if ($num_rows == 0) {

} else {
 	if ($user['userid'] == $UserID) {
   		$query = "SELECT email from users where encryptid='$UserID'";
   		$result = mysql_query($query);
   		$UserEmail = mysql_fetch_array($result);
   		$SelectedEmail = $UserEmail['email'];
   		if ($SelectedEmail = $Email) {
   				$query = "DELETE from comics where comiccrypt='$ComicID'";
				$result = mysql_query($query);
   		}
 	}
}
?>


