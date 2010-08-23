<? 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$PageTitle = 'order processing';
$TrackPage = 0;
if ($_SESSION['userid'] == '')
	header("Location:/register.php?a=pro");
$UserID = $_SESSION['userid'];
$date = date('Y-m-d h:m:s');
$Type = $_POST['type'];

if ($Type == '')
	$Type = $_GET['type'];

if ($ProductID == '')
	$ProductID = $_GET['id'];
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
if ((!isset($_SESSION['userid'])) && (($Type == 'pdf') || ($Type == 'ebook') || ($Type == 'selfpdf')))
	header("location:/login.php");

$Error = '';
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
		if ($Type == 'domain')
			header("location:/subscription/domain/?error=".$Error);
		else if ($Type == 'application')
			header("location:/subscription/app/?error=".$Error);
			
	}
}
$Error= '';
$Clear = 0;

if ($Type == 'hosted'){
	$query = "SELECT * from pf_subscriptions where UserID='$UserID' and (SubscriptionType ='hosted' or SubscriptionType='application' or SubscriptionType='fan') and Status='active'";
	$InitDB->query($query);

	$AlreadyPurchased = $InitDB->numRows();

	if ($AlreadyPurchased == 0) {
		$Clear = 1;
		header("location:/paypal_start.php?t=sub&type=".$Type."&subid=".$SubID);
	} else {
	$Error = 'WAIT! You already have an active PRO subscription. <div class="spacer"></div> If you wish to make changes to your plan, <br/>you can access that in your <a href="http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/?t=settings">ACCOUNT SETTINGS</a>.';
	}
} else if ($Type == 'fan'){
	$query = "SELECT * from pf_subscriptions where UserID='$UserID' and (SubscriptionType ='hosted' or SubscriptionType='application' or SubscriptionType='fan') and Status='active'";
	$InitDB->query($query);

	$AlreadyPurchased = $InitDB->numRows();

	if ($AlreadyPurchased == 0) {
		$Clear = 1;
		header("location:/paypal_start.php?t=sub&type=".$Type."&subid=".$SubID);
	} else {
	$Error = 'WAIT! You already have an active PRO subscription. <div class="spacer"></div> If you wish to make changes to your plan, <br/>you can access that in your <a href="http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/?t=settings">ACCOUNT SETTINGS</a>.';
	}
}else if ($Type == 'application'){
	$query = "SELECT * from pf_subscriptions where UserID='$UserID' and (SubscriptionType ='hosted' or SubscriptionType='application') and Status='active'";
	$InitDB->query($query);
	$AlreadyPurchased = $buyDB->numRows();
	if ($AlreadyPurchased == 0) {
		$Clear = 1;
		header("location:/paypal_start.php?t=sub&type=".$Type."&subid=".$SubID);
	} else {
	$Error = 'You already have an active subscription.<br/> If you wish to make changes to your plan, you can access that in your account settings. <a href="http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/?t=settings">ACCOUNT SETTINGS</a>.';
	}
}else if ($Type == 'domain'){

	$query = "SELECT * from pf_subscriptions where UserID='$UserID' and SubscriptionDomain='$Domain' and Status='active'";
	$InitDB->query($query);
	$AlreadyPurchased = $buyDB->numRows();
	if ($AlreadyPurchased == 0) {
		$Clear = 1;
		header("location:/paypal_start.php?t=sub&type=".$Type."&subid=".$SubID."&domain=".$Domain);
	} else {
	$Error = '<div class="pageheader">This domain is already setup on our servers. </div><br />


If you need help configuring your domain, please email info@panelflow.com. 
<br />
If you wish to make changes to your plan, you can access that in your account settings. <a href="http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/?t=settings">ACCOUNT SETTINGS</a>.';
	}
 }else {
	$query = "SELECT * from pf_store_items where EncryptID='$ProductID' and ProductType='$Type'";
	$ProductArray = $InitDB->queryUniqueObject($query);
	if (($Type == 'ebook') || ($Type == 'pdf')|| ($Type == 'selfpdf')) {
	    header("location:/store/paypal/?t=product&type=".$Type."&id=".$ProductID);
		//print "location:/store/paypal/?t=product&type=".$Type."&id=".$ProductID;
	} else if (($Type == 'podbook') || ($Type == 'podmerch')|| ($Type == 'podprint')) {
	      header("http://www.zazzle.com");
	}
	
}


include 'includes/header_template_new.php';
$Site->drawModuleCSS();
?>

<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <? if ($_SESSION['IsPro'] == 1) {
           $_SESSION['noads'] = 1;
		?>
    <td valign="top" style="padding:5px; color:#FFFFFF;width:60px;"><? include 'includes/site_menu_popup_inc.php';?></td>
    <? } else {?>
    <td width="<? echo $SideMenuWidth;?>" valign="top"><? include 'includes/site_menu_inc.php';?></td>
    <? }?>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
<? if (($Type == 'selfbook') || ($Type == 'selfmerch') || ($Type == 'selfprint')) 
include 'cart/productshippingInfo.php';?>
<? if ($Error != '') {?>
  <div class="spacer"></div>
                <img src="http://www.wevolt.com/images/go_pro_header.png" />   <div class="spacer"></div>
<div class="messageinfo_white" style="padding-top:10px;">
<? echo $Error;?></div><? }?>

 </div></td>
  </tr>
</table>
</div>
<?php include 'includes/footer_template_new.php';?>
