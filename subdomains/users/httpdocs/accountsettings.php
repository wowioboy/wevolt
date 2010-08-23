<?php 
include 'includes/init.php';
include 'includes/comments_inc.php';
include 'includes/favorites_inc.php';
include_once('includes/db.class.php');
?>

<?php 
//print "MY SESSION ID = " . trim($_SESSION['userid']);
$purchaseString ='';
$unfinishedpurchaseString ='';
$ID = trim($_SESSION['userid']);
if ($ID == "") { 
	header("Location:/index.php");
}
include 'includes/dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
     $query = "select * from $usertable where encryptid='$ID'";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     $Notify = $user['notify'];
	 $Comments = $user['allowcomments'];
	 $HostedAccount =  $user['HostedAccount'];
	 $FaceID = $user['FaceID'];
	  $Twittername = $user['Twittername'];
	   $TwitterCount = $user['TwitterCount'];
	$UserDB = new DB();
	$purchaseDB = new DB();
	$query ="SELECT * from pf_subscriptions where UserID='$ID' and Status='active'";	 
	$UserDB->query($query);

while ($purchase = $UserDB->fetchNextObject()) {
	$TypeID= $purchase->TypeID;
	$purchaseString .='<div><b>Type:</b> '.$purchase->SubscriptionType.' | SubscriptionID = '.$purchase->PayPalSubID;
	if ($purchase->SubscriptionType == 'domain') {
		$purchaseString .= ' | domain: '.$purchase->SubscriptionDomain;
	}	
	
	$purchaseString .='</div>';
	if ($purchase->SubscriptionType == 'application') {
		$ApplicationPurchased = 1;
		$query ="SELECT * from licenses where UserID='$ID'";
		$LicenseArray = $purchaseDB->queryUniqueObject($query);
		$LicenseID = $LicenseArray->LicenseID;
		$Domains = $LicenseArray->DomainsPurchased;
		$TimesDownloaded = $LicenseArray->TimesDownloaded;
	}
}
$query = "SELECT * from purchases where UserID='$ID' and Completed = 0";	 
$UserDB->query($query);
while ($purchase = $UserDB->fetchNextObject()) { 
$unfinishedpurchaseString .='<div>Purchase Type: '.$purchase->Type.' | Started Date = '.$purchase->Start.'</div>';
}

$query = "SELECT * from Applications where LicenseID='$LicenseID'";	 
$UserDB->query($query);
while ($purchase = $UserDB->fetchNextObject()) { 
$licensestring .='<div>Active Domain: '.$purchase->Domain.' | Installed = '.$purchase->InstallDate.'</div>';
}

$query = "SELECT * from pf_subscription_types where ID='$TypeID'";
$SubArray = $UserDB->queryUniqueObject($query);
$SubscriptionName = $SubArray->Name;
$SubDescription = $SubArray->Description;
$SubPrice = $SubArray->Price;

$UserDB->close();
$purchaseDB->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - ACCOUNT SETTINGS</title>
</head>


<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 

     <div class='contentwrapper'>
<div align="center" style=" padding-left:13px;">


	<table width="502" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"> 
    
   
<table border="0" cellpadding="0" cellspacing="0" width="550">
<tr>
<td id="profilemodtopleft"></td>
<td id="profilemodcenter" width="518">
</td>
<td id="profilemodtopright"></td>
</tr>
<tr>
<td id="profilemodcontent" colspan='3'>

<div class="pageheader">EDIT ACCOUNT SETTINGS</div><div class="lgspacer"></div><form method="post" action="/profile/<? echo trim($_SESSION['username']);?>/" style="margin:0px; padding:0px;"><input type="image" src="images/apply.png" style="border:none;background-color:#e5e5e5;" /><div class="lgspacer"></div>
<input type="hidden" name="editaccount" value="1" style="border:none;"/>NOTIFY ME OF PANEL FLOW UPDATES, NEWS AND MODULES<br /><input type="radio" value="1" name="notify" style="border:none; background-color:#e5e5e5;" <? if ($Notify == 1) echo 'checked';?>/> YES <input type="radio" value="0" name="notify" style="border:none;background-color:#ffffff;" <? if ($Notify == 0) echo 'checked';?>/> NO<div class="medspacer"></div>ALLOW COMMENTS ON MY PROFILE<br />

<input type="radio" value="1" name="profilecomments" style="border:none;background-color:#e5e5e5;"<? if ($Comments == 1) echo 'checked';?>/>YES <input type="radio" value="0" name="profilecomments" style="border:none;background-color:#ffffff;"<? if ($Comments == 0) echo 'checked';?>/> NO
<div class='spacer'></div>
<strong>Your Facebook UserID</strong> 
<input type="text" name="txtFace" value="<? echo $FaceID;?>"/> <div class='smspacer'></div>
This can be found after the ?id= when you click on your facebook profile. Enter in this number to give you access to the Panel Flow Facebook application, to syndicate your comics on your Facebook profile. 

<div class='spacer'></div>
<strong>Your Twitter Username</strong> 
<input type="text" name="Twittername" value="<? echo $Twittername;?>"/> <div class='smspacer'></div>
<input type="text" name="TwitterCount" value="<? echo $TwitterCount;?>" size="5" maxlength="3"/>&nbsp;&nbsp;Number of updates to show<div class='smspacer'></div>
This will turn on the twitter syndication on your profile, as well as open up the twitter comic module on your comics. 
</form>
<div class='spacer'></div>
<? if (($HostedAccount == 1) || ($HostedAccount == 2)) { ?>
<strong>CURRENT COMINCS HOSTING:</strong> <br />
<? echo $SubscriptionName;?><br />
<? echo $SubDescription;?><br />
<? echo $SubPrice;?>/month<br />
<div class='spacer'></div>

<? }?>
<? if ($ApplicationPurchased == 1) { ?>
<b>PANEL FLOW APPLICATION:</b><br />
Panel Flow License Key : <? echo $LicenseID;?><br />
<!--
# of Licensed Domains: <? //echo $Domains;?>&nbsp;&nbsp;[<a href="purchase_license.php">purchase licenses</a>]<br />
# of Downloads left: <? //echo (5 - $TimesDownloaded); if ((5 - $TimesDownloaded) > 0) echo '&nbsp;&nbsp;[<a href="/download_pro_package.php">download again</a>]';?><br />
-->
<div class='spacer'></div><b>YOUR ACTIVE INSTALLATIONS</b><br />
<?  echo $licensestring;?><div class='spacer'></div>
<? }?>
<? if ($purchaseString != '') { ?>
<strong>Your Purchase History</strong>:<br />
<? echo $purchaseString;}?><div class='spacer'></div>
<? if ($unfinishedpurchaseString != '') { ?>
<strong>Your Incomplete Purchases</strong><br />
<? echo $unfinishedpurchaseString; }?>

</td>
</tr>
</table>

</td>
    </tr>
</table>
	
	</div>
  </div>
</div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>
</body>
</html>

