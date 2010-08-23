<? include '../includes/db.class.php';
$buyDB = new DB();
$Code = $_GET['code'];
$query = "SELECT ProductID  from pf_store_digital_delivery where DownloadID='$Code'";
$ProductID = $buyDB->queryUniqueValue($query);
$query = "SELECT DownloadFile from pf_store_items where ID='$ProductID'";
$ProductFile = $buyDB->queryUniqueValue($query);
header("location:/store/products/downloads/".$ProductFile);
?>
