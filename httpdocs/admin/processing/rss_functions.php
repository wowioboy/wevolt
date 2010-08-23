<? 
if (($_GET['a'] == 'rss') && ($_POST['btnsubmit'] == 'SAVE RSS FEED')) {
	$rssDB = new DB();
	$Published = $_POST['txtPublish'];
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Description = mysql_escape_string($_POST['txtDescription']);
	$Category = $_POST['txtCategory'];
	$PostLimit = $_POST['txtPostLimit'];
$query = "update rss set Description='$Description',Title='$Title',PostLimit='$PostLimit', Category='$Category' where ID='$RSSID'";
	$rssDB->query($query);	
}	

?>