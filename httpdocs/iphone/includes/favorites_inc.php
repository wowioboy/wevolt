<?php 
function addfavorite($ComicID, $CreatorID, $UserID) {
include 'dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "INSERT into $favtable (comicid, creatorid, userid)" .  
			 	 "values ('$ComicID', '$CreatorID','$UserID')";
$result = mysql_query($query) or die ('Could Find user');		
}

function NotifyFavorite($FavID) {
include 'dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "UPDATE $favtable set notify=1 where favid='$FavID'";
$result = mysql_query($query) or die ('Could Find user');		
}

function RemoveNotify($FavID) {
include 'dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "UPDATE $favtable set notify=0 where favid='$FavID'";
$result = mysql_query($query) or die ('Could Find user');		
}


function deletefavorite($ComicID, $FavID, $UserID) {
include 'dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "DELETE from $favtable WHERE favid='$FavID' and comicid='$ComicID'";
$result = mysql_query($query) or die ('Could Find user');
}

?>