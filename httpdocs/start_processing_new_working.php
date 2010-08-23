<? 
include 'includes/init.php';
$buyDB = new DB();
$UserID = $_SESSION['userid'];
$date = date('Y-m-d h:m:s');
$Type = $_POST['type'];
$SubID = $_POST['txtSubType'];
//$Type = 'hosted';
//$SubID = '1';
$Quanity = $_POST['txtQuanity'];
$Domain = $_POST['txtDomain'];
if ($Quanity == '1 Domain') {
	$SelectedQuanity = 1;
} else if ($Quanity == '2 Domains') {
$SelectedQuanity = 2;
} else if ($Quanity == '3 Domains') {
$SelectedQuanity = 3;
}else if ($Quanity == '4 Domains') {
$SelectedQuanity = 4;
}else if ($Quanity == '5 Domains') {
$SelectedQuanity = 5;
}else if ($Quanity == 'With Ads') {
	$SelectedQuanity = 1;
} else if ($Quanity == 'No Ads') {
	$SelectedQuanity = 2;
}
if (!isset($_SESSION['userid'])) {
header("location:/login.php");
}
$Error = 0;
if ($Type == 'domain') {
	if ($Domain == '') {
		$Error = 1;
	}
	$DomainArray = explode('.',$Domain);
	if ($DomainArray[0] == 'www') {
		$Error = 2;
	} else if (strlen($DomainArray[1]) > 3) {

		$Error = 2;
	} else if (sizeof($DomainArray) != 2) {
		$Error = 2;
	}
	if ($Error != 0) {
		header("location:/subscription/domain/?error=".$Error);
	}
}
$Clear = 0;
if ($Type == 'hosted'){
	$query = "SELECT * from pf_subscriptions where UserID='$UserID' and (SubscriptionType ='hosted' or SubscriptionType='application') and Status='active'";
	$buyDB->query($query);
	$AlreadyPurchased = $buyDB->numRows();
	$buyDB->close();
	if ($AlreadyPurchased == 0) {
		$Clear = 1;
		header("location:/store/paypal/?t=sub&type=".$Type."&subid=".$SubID);
	} else {
	$Error = 'You already have an active subscription, if you wish to make changes to your plan, you can access that in your account settings. <a href="accountsettings.php">ACCOUNT SETTINGS</a>.';
	}
}else if ($Type == 'application'){
	$query = "SELECT * from pf_subscriptions where UserID='$UserID' and (SubscriptionType ='hosted' or SubscriptionType='application') and Status='active'";
	$buyDB->query($query);
	$AlreadyPurchased = $buyDB->numRows();
	$buyDB->close();
	if ($AlreadyPurchased == 0) {
		$Clear = 1;
		header("location:/store/paypal/?t=sub&type=".$Type."&subid=".$SubID);
	} else {
	$Error = 'You already have an active subscription, if you wish to make changes to your plan, you can access that in your account settings. <a href="/profile/account/">ACCOUNT SETTINGS</a>.';
	}
}else if ($Type == 'domain'){

	$query = "SELECT * from pf_subscriptions where UserID='$UserID' and SubscriptionDomain='$Domain'";
	$buyDB->query($query);
	$AlreadyPurchased = $buyDB->numRows();
	$buyDB->close();
	if ($AlreadyPurchased == 0) {
		$Clear = 1;
		header("location:/store/paypal/?t=sub&type=".$Type."&subid=".$SubID);
	} else {
	$Error = 'This domain is already setup on our servers. If you need help configuring your domain, please email info@panelflow.com. If you wish to make changes to your plan, you can access that in your account settings. <a href="/profile/account/">ACCOUNT SETTINGS</a>.';
	}
}
$PageTitle = ' | Order Processing';
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
<div style="height:300px; padding-left:20px;padding-right:25px; font-size:12px; padding-top:40px; font-weight:bold;">
<? echo $Error;?>
</div>
  <?php include 'includes/footer_v2.php';?>
</body>
</html>
