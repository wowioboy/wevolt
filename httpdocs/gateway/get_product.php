<? include '../includes/db.class.php';
$buyDB = new DB();
$Code = $_GET['code'];
//$PurchaseID = randomPrefix(15); 
$RemoteIP = $_SERVER['REMOTE_ADDR'];
$Date = date('Y-m-d h:m:s');
$query = "SELECT * from pf_store_digital_delivery where DownloadID='$Code' and DownloadCount<5";
$buyDB->query($query);
while ($orderitem = $DB->fetchNextObject()) { 
		$DownloadCount = $orderitem->DownloadCount;
}
$Valid = $buyDB->numRows();
if ($Valid != 1) {
$DownloadCount++;
$query = "UPDATE pf_store_digital_delivery set Downloaded=1, Retrieved='$Date', RemoteIP='$RemoteIP',DownloadCount='$DownloadCount' where DownloadID='$Code'";
$buyDB->query($query);
$butDB->close();
header("Location:/gateway/start_download.php?id=$Code");

}
?>