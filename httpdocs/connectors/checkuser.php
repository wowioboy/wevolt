<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$ComicID = $_GET['comicid'];
$License = $_GET['l'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
 //print "MY ACTION = ". $Action."<br>";
 
$query = "SELECT * from comics where comiccrypt ='$ComicID'";
$result = mysql_query($query);
$comic = mysql_fetch_array($result);
$ComicAdmin = $comic['userid'];

$query = "SELECT * from users where encryptid ='$ComicAdmin'";
$result = mysql_query($query);
//print $query;
$user = mysql_fetch_array($result);
$UserID = $user['encryptid'];

$query = "SELECT * from pf_subscriptions where UserID='$UserID' and Status='active'";
$result = mysql_query($query);
$IsPro = mysql_num_rows($result);
echo $IsPro;

?>