<? 
/*
include 'includes/init.php';
if ($_SESSION['userid'] == '')
header("/products/".$_GET['id']."/?a=notauth");

$buyDB = new DB();
//$PurchaseID = randomPrefix(15); 
$RemoteIP = $_SERVER['REMOTE_ADDR'];
$Date = date('Y-m-d h:m:s');
$ProductID = $_GET['id'];
$UserID = $_SESSION['userid'];
$SessionID = session_id();
$query = "INSERT into pf_store_downloads (UserID, ProductID, Remote, DownloadDate) values ('$UserID', '$ProductID', '$Date','$RemoteIP')";

$buyDB->query($query);

$query = "SELECT DownloadFile from pf_store_items where EncryptID='$ProductID'";
$ProductFile = $buyDB->queryUniqueValue($query);

$buyDB->close();

header("location:/".$ProductFile);
*/

//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);
set_time_limit(0);
include 'includes/init.php';
include "includes/class.mime.php";	
include 'includes/download_content_functions.php';
$ProductID= $_GET['id'];
$buyDB = new DB();
$RemoteIP = $_SERVER['REMOTE_ADDR'];
$Date = date('Y-m-d h:m:s');
$ProductID = $_GET['id'];
$UserID = $_SESSION['userid'];
$Code = $_GET['code'];
$SessionID = session_id();
if ($_SESSION['userid'] == '')
	header("/products/".$_GET['id']."/?a=notauth");

if ($_GET['code'] != '') {
		$query = "SELECT * from pf_store_digital_delivery where DownloadID='$Code' and DownloadCount<5";
		$buyDB->query($query);
		//print $query.'<br/>';
		while ($orderitem = $buyDB->fetchNextObject()) { 
				$DownloadCount = $orderitem->DownloadCount;
		}
		
		$Valid = $buyDB->numRows();
		if ($Valid == 1) {
				$SessionID = session_id();
				$DownloadCount++;
				$query = "UPDATE pf_store_digital_delivery set Downloaded=1, Retrieved='$Date', RemoteIP='$RemoteIP',DownloadCount='$DownloadCount', SessionID='$SessionID' where DownloadID='$Code'";
				$buyDB->query($query);
				//print $query.'<br/>';
				$query = "SELECT ProductID from pf_store_digital_delivery where DownloadID='$Code'";
				$ProductID = $buyDB->queryUniqueValue($query);
				//print $query.'<br/>';
		}
} else {
	$Valid = 1;
}

$query = "SELECT DownloadFile,ShortTitle,Price from pf_store_items where EncryptID='$ProductID'";
		$ProductArray = $buyDB->queryUniqueObject($query);
		//print $query.'<br/>';
		$ProductFile= $ProductArray->DownloadFile;
		$ProductTitle= $ProductArray->ShortTitle;
		$Price = $ProductArray->Price;
		
if (($Price != '') && ($Price != 0) && (!isset($_GET['code']))) 
	$Valid = 0;
	
if ($Valid == 1) {
		$query = "INSERT into pf_store_downloads (UserID, ProductID, Remote, DownloadDate) values ('$UserID', '$ProductID', '$Date','$RemoteIP')";
		$buyDB->query($query);
		//print $query.'<br/>';
		$Filearray = explode('.',$ProductFile);
		//print $ProductFile.'<br/>';
		$ext = $Filearray[1];	
		$DlName = 'PF_DOWNLOAD_'.$ProductID.'.'.$ext;
		$mime = new MIMETypes();
		//print $DlName.'<br/>';
		$MineType = $mime -> getMimeType($ProductFile);
		$buyDB->close();
		output_file($ProductFile, $DlName, $MineType);
}

?>

