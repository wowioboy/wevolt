<? 
function randomPrefix($length)
{
$random= "";

srand((double)microtime()*1000000);

$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
$data .= "0FGH45OP89";

for($i = 0; $i < $length; $i++)
{
$random .= substr($data, (rand()%(strlen($data))), 1);
}

return $random;
}

include 'includes/init.php';
$buyDB = new DB();
$UserID = $_SESSION['userid'];
$Type = $_POST['type'];
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
		header("location:domain_hosting.php?error=".$Error);
	}
}

$Clear = 0;
if ($Type == 'application') {
	$query = "SELECT * from purchases where UserID='$UserID' and Type='application' and Completed=1";
	$buyDB->query($query);
	$AlreadyPurchased = $buyDB->numRows();
	if ($AlreadyPurchased == 0) {
		$query = "SELECT * from purchases where UserID='$UserID' and Type='application' and Completed=0";
		$buyDB->query($query);
		$AlreadyStarted = $buyDB->numRows();
		if ($AlreadyStarted == 0) {
			$PurchaseID = randomPrefix(15); 
			$query = "INSERT into purchases (UserID, Type, PurchaseID) values ('$UserID', '$Type','$PurchaseID')";
			$buyDB->query($query);
		} else {
			$query = "UPDATE purchases set PurchaseID='$PurchaseID' where UserID='$UserID' and Type='$Type'";
			$buyDB->query($query);
		}
		$buyDB->close();
		$Clear = 1;
	} else {
	
	$Error = 'You have already purchased Panel Flow. <br/>If you need to run it on another domain, just purchase another Domain License <a href="purchase_license.php">here</a> for a $1.';
	}
} else if ($Type == 'license'){
	$query = "SELECT * from purchases where UserID='$UserID' and Type='application' and Completed=1";
	$buyDB->query($query);
	$AlreadyPurchased = $buyDB->numRows();
	if ($AlreadyPurchased == 1) {
		$PurchaseID = randomPrefix(15); 
		$query = "SELECT * from purchases where UserID='$UserID' and Type='license' and Completed=0";
		$buyDB->query($query);
		$AlreadyStarted = $buyDB->numRows();
		if ($AlreadyStarted == 0) {
			$query = "INSERT into purchases (UserID, Type, Quanity, PurchaseID) values ('$UserID', '$Type', '$SelectedQuanity', '$PurchaseID')";
			$buyDB->query($query);
		} else {
			$query = "UPDATE purchases set PurchaseID='$PurchaseID' where UserID='$UserID' and Type='$Type'";
			$buyDB->query($query);
		}
		$buyDB->close();
		$Clear = 1;
	
	}else {
	
	$Error = 'You have not purchased the Panel Flow application yet. <a href="download.php">VIEW PACKAGES</a>.';
	}
}else if ($Type == 'hosted'){
	$query = "SELECT * from purchases where UserID='$UserID' and Type='hosted' and Completed=1";
	$buyDB->query($query);
	$AlreadyPurchased = $buyDB->numRows();
	
	if ($AlreadyPurchased == 0) {
		$query = "SELECT * from purchases where UserID='$UserID' and Type='hosted' and Completed=0";
		$buyDB->query($query);
		$AlreadyStarted = $buyDB->numRows();
		$PurchaseID = randomPrefix(15); 
		if ($AlreadyStarted == 0) {
			$query = "INSERT into purchases (UserID, Type, Quanity, PurchaseID) values ('$UserID', '$Type', '$SelectedQuanity','$PurchaseID')";
			$buyDB->query($query);
		} else {
			$query = "UPDATE purchases set PurchaseID='$PurchaseID' where UserID='$UserID' and Type='$Type'";
			$buyDB->query($query);
		}
		$buyDB->close();
		$Clear = 1;
	
	}else {
	
	$Error = 'You already have purchased comic hosting, if you wish to make changes to your plan, you can access that in your account settings. <a href="accountsettings.php">ACCOUNT SETTINGS</a>.';
	}
}else if ($Type == 'domain'){
	$query = "SELECT * from purchases where UserID='$UserID' and Type='domain' and Completed=1";
	$buyDB->query($query);
	$AlreadyPurchased = $buyDB->numRows();
	if ($AlreadyPurchased == 0) {
	$PurchaseID = randomPrefix(15); 
		$query = "SELECT * from purchases where UserID='$UserID' and Type='domain' and Completed=0";
		$buyDB->query($query);
		$AlreadyStarted = $buyDB->numRows();
		if ($AlreadyStarted == 0) {
			$query = "INSERT into purchases (UserID, Type, Domain, PurchaseID) values ('$UserID', '$Type','$Domain','$PurchaseID')";
			$buyDB->query($query);
		}  else {
			$query = "UPDATE purchases set PurchaseID='$PurchaseID' where UserID='$UserID' and Type='$Type'";
			$buyDB->query($query);
		}
		$query = "SELECT * from purchases where UserID='$UserID' and Type='application' and Completed=1";
		$buyDB->query($query);
		$AlreadyPurchased = $buyDB->numRows();
		if ($AlreadyPurchased == 0) {
			$query = "SELECT * from purchases where UserID='$UserID' and Type='application' and Completed=0";
			$buyDB->query($query);
			$AlreadyStarted = $buyDB->numRows();
			if ($AlreadyStarted == 0) {
				$query = "INSERT into purchases (UserID, Type) values ('$UserID', 'application')";
				$buyDB->query($query);
			}
		}
		$buyDB->close();
		$Clear = 1;
	}else {
	$Error = 'You already have purchased domain hosting, if you wish to make changes to your plan, you can access that in your account settings. <a href="accountsettings.php">ACCOUNT SETTINGS</a>.';
	}
}

?>

<? if ($Clear == 0) {

//header("location:download.php");

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REDIRECT CONFIRMATION | Please proceed to PayPal to purchase</title>
<SCRIPT language="JavaScript">
function submitform()
{
  document.buy.submit();
}
</SCRIPT> 
</head>

<body>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="buy">
<?php include 'includes/header_content.php';?>
     <div class='contentwrapper' align="center">
     <input type="hidden" name="invoice" value="<? echo $PurchaseID;?>" />
<? if ($Type == 'application') { ?>
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="1227417">
<? } else if ($Type == 'license') {?>
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="1227744">
<input type="hidden" name="on0" value="Quanity">
<input type="hidden" name="os0" value="<? echo $_POST['txtQuanity'];?>">
<input type="hidden" name="currency_code" value="USD">
<? }  else if (($Type == 'hosted') && ($Quanity == 'With Ads')) {?>
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="1227574">
<? } else if (($Type == 'hosted') && ($Quanity == 'No Ads')) {?>
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="1227593">
<? }  else if ($Type == 'domain') {?>
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="1227620">
<? } ?>
<? if ($Clear == 1) {?>
<div style="height:200px; font-size:14px; padding-top:40px; font-weight:bold;">
After you click the submit button, you will be redirected to PayPal<br/><br/>After you complete the purchase, please wait to be redirected back to Panel Flow from Paypal to verify your purchase.<br/><br/><input type="submit" value="PROCEED TO PAYPAL" />
</div> 
<? } else { ?>
<div style="height:300px; padding-left:20px;padding-right:25px; font-size:12px; padding-top:40px; font-weight:bold;">
<? echo $Error;?>
</div>
<? }?> 
</form> </div>
  <?php include 'includes/footer_v2.php';?>
</body>
</html>
