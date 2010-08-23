<?php 
include '../includes/init.php';
$SessionID = session_id();
?>
<LINK href="../css/cart.css" rel="stylesheet" type="text/css"><?
$Code = $_GET['code'];
//if (!isset($_SESSION['userid'])) {
	//header("location:login.php?ref=hosting_discount.php?id=".$Code);
//}
//$UserID = $_SESSION['userid'];
//include 'includes/db.class.php';
$buyDB = new DB();
//SELECT THE CODE, SEE IF IT'S VALID THEN DISPLAY THE BUTTON.
$query = "SELECT * from pf_store_digital_delivery where DownloadID='$Code' and (Downloaded=0 or (SessionID='$SessionID' and DownloadCount<5))";
$buyDB->query($query);
while ($orderitem = $buyDB->fetchNextObject()) { 
		$ProductID = $orderitem->ID;
}
$Valid = $buyDB->numRows();

if ($Valid == 0) {


}
if ($Valid != 1) {
$Error = '<div class="pageheader">Sorry your Download code has either already been used or is not valid. </div><br/><br/><div class="carttext">If you had an error while downloading and need to request another link please email us in our Contact section and another link will be sent to you.</div>';
}
$buyDB->close();

?>
<div style="padding:25px;"><? if ($Error == '') {?><div class="pageheader">Your Download Link is below. Please do not close this page until you have successfully downloaded your product.</div><div align="center" style="padding:10px;">
<a href="/get_product.php?code=<? echo $Code;?>">CLICK HERE TO DOWNLOAD YOUR PURCHASE</a></div><? } else { echo $Error; }
?></div>