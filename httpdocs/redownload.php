<? include 'includes/init.php';?>
<? include 'includes/db.class.php';
include 'includes/message_functions.php';
$buyDB = new DB();
$Remote = $_SERVER['REMOTE_ADDR'];
$UserID = $_SESSION['userid'];
$Version = 'Pro 1.5';
$query = "SELECT TimesDownloaded from licenses where UserID='$UserID'";
$buyDB->query($query);
$Num = $buyDB->numRows();
if ($Num == 1) {
$TimesDownloaded = $buyDB->queryUniqueValue($query);
if (($TimesDownloaded == '') || ($TimesDownloaded == 0)) {
	$TimesDownloaded = 1;
}
$TimesDownloaded++;
if ($TimesDownloaded > 3) {
$Subject = 'You have exceeded your Maximum downloads.';
$Message ='You have exceeded your maximum number of downloads, if you need to download the application again, please send an email to us here : <a href="contact.php">CONTACT</a>';
	SendMessage($_SESSION['userid'], 'Panel Flow', '9778d5d252', $Subject, $Message);
	header("Location:/profile/".trim($_SESSION['username'])."/");
} else {
	$query = "UPDATE licenses set TimesDownloaded='$TimesDownloaded' where UserID='$UserID'";
	$buyDB->query($query);
	$query = "INSERT into downloads (ipaddress, userid, version) values ('$Remote', '$UserID', '$Version')";
	$buyDB->query($query);
	header("Location:/getprodownload.php");
}
} else {
header("Location:/profile/".trim($_SESSION['username'])."/");

}
?>