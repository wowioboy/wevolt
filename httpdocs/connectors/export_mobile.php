<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$ComicID = $_POST['c'];
$ItemID = $_POST['p'];
$UserID = $_POST['u'];
$Section = $_POST['s'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
// print "MY ACTION = ". $Action."<br>";
$query = "SELECT * from comics where userid='$UserID' and comiccrypt='$ComicID'";
//print "MY query on PROPDUICTION= ". $query."<br>";
 $result = mysql_query($query);
 $comic = mysql_fetch_array($result);
 $num_rows = mysql_num_rows($result);
 $ComicFolder = $comic['HostedUrl'];
 if ($num_rows == 1) {
 	$query = "SELECT * from mobile_content where EncryptID ='$ItemID'";
 	$result = mysql_query($query);
 	$page = mysql_fetch_array($result);
	$myValues = array (
 	'title' => trim($page['Title']),
	'image' => 'comics/'.$ComicFolder.'/'.trim($page['Image']),
	 'thumb' => 'comics/'.$ComicFolder.'/'.trim($page['Thumb']),
	 'CreateDate' =>  trim($page['CreateDate']),
	 'type' => trim($page['Type']));
	echo serialize ($myValues);
 }


?>


