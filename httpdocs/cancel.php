<?
include 'includes/init.php';
include 'includes/db.class.php';
$buyDB = new DB();
$UserID = $_SESSION['userid'];
if (!is_authed()) {
	header("location:download.php");
}
	$query = "DELETE from purchases where UserID='$UserID' and Completed=0";
	$buyDB->query($query);
	$query = "SELECT username from users where encryptid='$UserID'";
	$Username = $buyDB->queryUniqueValue($query);
$buyDB->close();


header("location:/profile/".trim($Username)."/");
?>