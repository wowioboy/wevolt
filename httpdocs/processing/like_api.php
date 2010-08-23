<?php 
include '../includes/init.php';
header('Content-Type: text/javascript' );
header('Pragma: no-cache');
$ContentID = $_GET['id'];
$ContentType = $_GET['type'];
$Target = $_GET['target'];
$UserID = $_SESSION['userid'];
$ContentLink = $_GET['link'];

$DB = new DB();
$NOW = date('Y-m-d h:i:s');
$query ="INSERT into likes (ContentID, ContentType, ContentLink, UserID, CreatedDate) values ('$ContentID', '$ContentType','$ContentLink','$UserID','$NOW')";
$DB->execute($query);

$query = "SELECT count(*) from likes where ContentID='$ContentID' and ContentType='$ContentType'";
$NumLikes = $DB->queryUniqueValue($query);
$DB->close();
?>
document.getElementById("<? echo $Target;?>").innerHTML = '<? echo $NumLikes;?> like<? if ($NumLikes != 1) echo 's';?>';
