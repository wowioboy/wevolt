<? 

//include 'includes/db.class.php';
include 'includes/init.php';
$buyDB = new DB();
$UserID=$_SESSION['userid'];
$ProductCode = 'PF16PRO';

$query ="SELECT * from pf_subscriptions where UserID='$UserID' and Status='active' and SubscriptionType='application'";
$buyDB->query($query);
$Found = $buyDB->numRows();

if ($Found > 0){
$query = "SELECT DownloadFile from pf_store_items where ProductCode='$ProductCode'";
$ProductFile = $buyDB->queryUniqueValue($query);


$query = "SELECT TimesDownloaded from licenses where UserID='$UserID'";
$TimesDownloaded = $buyDB->queryUniqueValue($query);

$TimesDownloaded++;

$query ="UPDATE licenses set TimesDownloaded='$TimesDownloaded' where UserID='$UserID'"; 
$buyDB->execute($query);

$buyDB->close();
header("location:/store/products/downloads/".$ProductFile);

} else {
	if ($_SESSION['userid'] == '') 
		header("location:index.php");
	else 
		header("location:/profile/".trim($_SESSION['username'])."/");

}


?>
