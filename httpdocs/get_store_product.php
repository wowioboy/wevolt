<? include 'includes/init.php';
$buyDB = new DB();
$Code = $_GET['code'];
$PageTitle = 'Download Product';
$RemoteIP = $_SERVER['REMOTE_ADDR'];
$Date = date('Y-m-d h:m:s');
$query = "SELECT * from pf_store_digital_delivery where DownloadID='$Code' and DownloadCount<5";
$orderitem = $buyDB->queryUniqueObject($query);
$DownloadCount = $orderitem->DownloadCount;
$OrderItemID =  $orderitem->OrderItemID;
$OrderID = $orderitem->OrderID;
$ProductID = $orderitem->ProductID;

if ($ProductID != '') {
$SessionID = session_id();
$DownloadCount++;
$query = "UPDATE pf_store_digital_delivery set Downloaded=1, Retrieved='$Date', RemoteIP='$RemoteIP',DownloadCount='$DownloadCount', SessionID='$SessionID' where DownloadID='$Code'";
$buyDB->query($query);

$query = "UPDATE tbl_order_item set Complete=5 where od_id='$OrderID' and pd_id='$ProductID' and id='OrderItemID'";
$buyDB->query($query);

$buyDB->close();
header("Location:/store_download.php?code=$Code");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
 
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?> - <?php echo $PageTitle; ?></title>

</head>

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<div class="contentdiv" style="padding:50px 25px 50px 25px;">
<div class="pageheader"><? if ($Valid != 1) {?>Sorry you have exceed the number of times you can download this item. <br /><br />

If you require help, please use our <a href="/contact/">contact page</a> to contact us. <? } else { ?>Your file is being retrieved. Do not hit your back button or navigate away from this page until you have fully downloaded your product.<? }?></div>

</div>
  </div>
  <?php include 'includes/footer_v2.php';?>

</body>
</html>

