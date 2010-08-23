<?php 
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';

header( 'Content-Type: text/javascript' );
$Series = $_GET['s'];
$Episode = $_GET['e'];
$Page = $_GET['p'];
$Action = $_GET['a'];
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
if ($_GET['a'] == 'clear') {
	$query = "DELETE from user_bookmarks where user_id='".$_SESSION['userid']."' and project_id='".$_SESSION['viewingproject']."'";
		$DB->execute($query);
?>alert('Your bookmark has been removed'); <?	
} else {
$query = "SELECT count(*) from user_bookmarks where project_id='".$_SESSION['viewingproject']."' and user_id='".$_SESSION['userid']."'";
$Found = $DB->queryUniqueValue($query);
if ($Found == 0) {
		$query = "INSERT into user_bookmarks (user_id, project_id, series_num, episode_num, position) values ('".$_SESSION['userid']."', '".$_SESSION['viewingproject']."', '$Series', '$Episode', '$Page')";
		$DB->execute($query);
	
} else {
	$query = "update user_bookmarks set series_num='$Series', episode_num='$Episode', position='$Page' where user_id='".$_SESSION['userid']."' and project_id='".$_SESSION['viewingproject']."'";
		$DB->execute($query);
	
}
$DB->close();
?>
alert('Your place has been saved'); 

<? }?>
