<? include 'includes/init.php';?>
<? include 'includes/db.class.php';
$buyDB = new DB();
$Remote = $_SERVER['REMOTE_ADDR'];
$UserID = $_SESSION['userid'];
$Version = 'Pro 1.5';
$query = "SELECT TimesDownloaded from licenses where UserID='$UserID'";
$TimesDownloaded = $buyDB->queryUniqueValue($query);
if (($TimesDownloaded == '') || ($TimesDownloaded == 0)) {
	$TimesDownloaded = 1;
}
$TimesDownloaded++;
if ($TimesDownloaded > 5) {
	header("Location:/profile/".trim($_SESSION['username'])."/");
} else {
	$query = "UPDATE licenses set TimesDownloaded='$TimesDownloaded' where UserID='$UserID'";
	$buyDB->query($query);
	$query = "INSERT into downloads (ipaddress, userid, version) values ('$Remote', '$UserID', '$Version')";
	$buyDB->query($query);
	header("Location:/getprodownload.php");
}
?>