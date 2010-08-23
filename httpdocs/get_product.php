<? include 'includes/init.php';
$buyDB = new DB();
$Code = $_GET['code'];
//$PurchaseID = randomPrefix(15); 
$RemoteIP = $_SERVER['REMOTE_ADDR'];
$Date = date('Y-m-d h:m:s');
$query = "SELECT * from pf_store_digital_delivery where DownloadID='$Code' and DownloadCount<5";
$buyDB->query($query);

while ($orderitem = $buyDB->fetchNextObject()) { 
		$DownloadCount = $orderitem->DownloadCount;
}
$Valid = $buyDB->numRows();
if ($Valid == 1) {
$SessionID = session_id();
$DownloadCount++;
$query = "UPDATE pf_store_digital_delivery set Downloaded=1, Retrieved='$Date', RemoteIP='$RemoteIP',DownloadCount='$DownloadCount', SessionID='$SessionID' where DownloadID='$Code'";
$buyDB->query($query);
$buyDB->close();
header("Location:/gateway/start_download.php?code=$Code");
}
?>

<div class="pageheader">Sorry you have exceed the number of times you can download this item. If you require help, please use our contact page to contact us. </div>