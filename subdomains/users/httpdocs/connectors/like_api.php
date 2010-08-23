<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
header('Content-Type: text/javascript' );
header('Pragma: no-cache');
$ContentID = $_GET['d'];
$ContentType = $_GET['t'];
$Target = $_GET['target'];
$UserID = $_SESSION['userid'];
$ContentLink = $_GET['link'];
$ProjectID = $_GET['p'];
$DB = new DB();
$NOW = date('Y-m-d h:i:s');
$query = "SELECT count(*) from likes where ContentID='$ContentID' and ContentType='$ContentType' and UserID='$UserID'";
$NumLikes = $DB->queryUniqueValue($query);
if ($NumLikes == 0) {
	$query ="INSERT into likes (ContentID, ContentType, ContentLink, UserID, CreatedDate,ProjectID) values ('$ContentID', '$ContentType','$ContentLink','$UserID','$NOW','$ProjectID')";
	$DB->execute($query);
}
$query = "SELECT count(*) from likes where ContentID='$ContentID' and ContentType='$ContentType' and ProjectID='$ProjectID'";
$NumLikes = $DB->queryUniqueValue($query);
$DB->close();
?>

document.getElementById("<? echo $Target;?>").innerHTML = '<? echo $NumLikes;?> like<? if ($NumLikes != 1) echo 's';?>';
if (document.getElementById("like_cell") != null)
	document.getElementById("like_cell").style.display = 'none';
