<?
include 'includes/init.php';
include 'includes/email_functions.php';
$buyDB = new DB();
$UserID = $_SESSION['userid'];
$Type = $_GET['type'];

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

$Done = 1;
if (!is_authed()) {
	header("location:download.php");
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-synch';

$tx_token = $_GET['tx'];

$auth_token = "AXvpNFY7wdiG_curXOT6v8Piqc0cL4B_kRPHzQ4AsxTDawM72URIW6WhEs0";

$req .= "&tx=$tx_token&at=$auth_token";


// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
// If possible, securely post back to paypal using HTTPS
// Your PHP server will need to be SSL enabled
// $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
// read the body data
$res = '';
$headerdone = false;
while (!feof($fp)) {
$line = fgets ($fp, 1024);
if (strcmp($line, "\r\n") == 0) {
// read the header
$headerdone = true;
}
else if ($headerdone)
{
// header has been read. now read the contents
$res .= $line;
}
}

// parse the data
$lines = explode("\n", $res);
$keyarray = array();
if (strcmp ($lines[0], "SUCCESS") == 0) {
for ($i=1; $i<count($lines);$i++){
list($key,$val) = explode("=", $lines[$i]);
$keyarray[urldecode($key)] = urldecode($val);
}


// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment
$firstname = $keyarray['first_name'];
$lastname = $keyarray['last_name'];
$itemname = $keyarray['item_name'];
$amount = $keyarray['mc_gross'];
$invoice = $keyarray['invoice'];
if ($Type == 'app') {
	$query = "SELECT * from purchases where UserID='$UserID' and PurchaseID='$invoice'";
	$buyDB->query($query);
	$Found = $buyDB->numRows();
	if ($Found == 0) {
		$Message = 'Sorry your purchase information was not found in the database, or you have already activated your software. If you purchased the application and have not recieved your confirmation email, please send us an email here: <a href="contact.php">CONTACT</a><br/><br/>If you have already purchased the application and need to Download the application package again, goto your account settings <a href="accountsettings.php">HERE</a>';
		$buyDB->close();
		$Done = 0;
	} else {
		$query = "UPDATE purchases set Completed=1, TransactionID='$tx_token' where PurchaseID='$invoice'";
		$buyDB->query($query);
		
		$licenseclear = 0;
		$License = randomPrefix(15); 
		while ($licenseclear == 0) { 
			$query = "SELECT * from licenses where LicenseID = '$License'";
			$buyDB->query($query);
			$Found = $buyDB->numRows();
			if ($Found == 0) {
				$licenseclear = 1;
			}
		}
		
		if ($licenseclear == 1) {
			$query = "INSERT into licenses (UserID, LicenseID) values ('$UserID', '$License')";
			$buyDB->query($query);
			$Message = 'Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. <br/><br/>you may now install your application and enjoy on (1) domain. If you want to install the application on other domains, just purchase an extra license for $1. <br/> <br/>If you have any problems with the application, please contact us <a href="contact.php">HERE</a> and we\'ll help get it installed and working. If for any reason we cannot get the application running with your hosting solution, we will refund your purchase.<br/><br/><b>To Download your software, please click this link</b>: <a href="download_pro_package.php">DOWNLOAD PANEL FLOW PRO 1.5</a><div class="spacer"></div>';
			$Username = $_SESSION['username'];
			$Email = $_SESSION['email'];
			SendApplicationEmail($Username, $Email, $License);
			SendAdminApplicationEmail($Username, $Email, $License);
			$Done = 1;
		}
	}
	$query = "SELECT Completed from purchases where UserID='$UserID' and PurchaseID='$invoice'";
	$OrderCompleted = $buyDB->queryUniqueValue($query);
	if ($OrderCompleted == 1) {
	$Message = 'Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. <br/><br/>you may now install your application and enjoy on (1) domain. If you want to install the application on other domains, just purchase an extra license for $1. <br/> <br/>If you have any problems with the application, please contact us <a href="contact.php">HERE</a> and we\'ll help get it installed and working. If for any reason we cannot get the application running with your hosting solution, we will refund your purchase.<br/><br/><b>To Download your software, please click this link</b>: <a href="download_pro_package.php">DOWNLOAD PANEL FLOW PRO 1.5</a><div class="spacer"></div>';
	}
} else if ($Type == 'license'){
	$query = "SELECT Quanity from purchases where UserID='$UserID' and PurchaseID='$invoice'";

	$buyDB->query($query);
	$Found = $buyDB->numRows();
	if ($Found == 0) { 
		$Message = 'Sorry your purchase information was not found in the database. If you purchased the License and your new license is not working, please send us an email here: <a href="contact.php">CONTACT</a><br/>If you have already purchased the application and need to redownload the software, click here : <a href="redownload.php">DOWNLOAD AGAIN</a>';
		$Done = 0;
	} else {
		$Quanity = $buyDB->queryUniqueValue($query);
		$query = "SELECT DomainsPurchased from licenses where UserID='$UserID'";
		
		$Licenses = $buyDB->queryUniqueValue($query);
		$Licenses = $Licenses + $Quanity;
		$query = "UPDATE licenses set DomainsPurchased='$Licenses' where UserID='$UserID'";
		$buyDB->query($query);
		$Message = 'Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. <br/><br/>You may now install your Panel Flow Application on '.$Licenses.' Domain(s)';
		$query = "UPDATE purchases set Completed=1, TransactionID='$tx_token' where PurchaseID='$invoice'";
		$buyDB->query($query);
		$Username = $_SESSION['username'];
		$Email = $_SESSION['email'];
		SendLicenseEmail($Username, $Email, $Licenses);
		SendAdminLicenseEmail($Username, $Email, $Licenses);
		$Done = 1;
	}
}else if ($Type == 'hosted'){
	$query = "SELECT Quanity from purchases where UserID='$UserID' and PurchaseID='$invoice'";
	$buyDB->query($query);
	$Found = $buyDB->numRows();
	if ($Found == 0) { 
		$Message = 'Sorry your purchase information was not found in the database. If you you purchased Comic Hosting and it\'s not working, please contact us <a href="contact.php">EMAIL</a>.';
		$Done = 0;
	} else {
		$Quanity = $buyDB->queryUniqueValue($query);
		$query = "UPDATE users set HostedAccount='$Quanity' where encryptid='$UserID'";
		$buyDB->query($query);	
		$Message = 'Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. <br/><br/>You can now start creating comics. Just go to your profile and click the \'Manage Comics Button\'';
		$query = "UPDATE purchases set Completed=1,TransactionID='$tx_token' where PurchaseID='$invoice'";
		$buyDB->query($query);
		$Username = $_SESSION['username'];
		$Email = $_SESSION['email'];
		SendHostedEmail($Username, $Email, $Quanity);
		SendAdminHostedEmail($Username, $Email, $Quanity);
		$Done = 1;
	}
} else if ($Type == 'domain'){
	$query = "SELECT Domain from purchases where UserID='$UserID' and PurchaseID='$invoice'";
	$buyDB->query($query);
	$Found = $buyDB->numRows();
	if ($Found == 0) { 
		$Message = 'Sorry your purchase information was not found in the database. If you you purchased Domain Hosting and it\'s not working, please contact us <a href="contact.php">EMAIL</a>.';
		$Done = 0;
	} else {
		$Domain = $buyDB->queryUniqueValue($query);
		$Discount = randomPrefix(15); 
		$query = "UPDATE purchases set Completed=1,TransactionID='$tx_token' where PurchaseID='$invoice'";
		$buyDB->query($query);
		$query = "INSERT into discounts (UserID, Code, Amount, Type) values ('$UserID', '$Discount','$5.00', 'application')";
		$buyDB->query($query);
		$Message = 'Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. <br/><br/>An Email has been sent to you with a link to purchase a discounted Panel Flow Package. After you complete the license transaction you will be able to download the software (5) times. More available upon request. You will also have free access to several modules and templates.<br/><br/>After your domain has been set up on the servers (usually within a few hours), you will recieve an email to access your server information, login details and instructions on how to point your domain\'s nameservers to our servers. If your domain is not set up within 24 hours, or you have not recieved the email, please contact us.';
		$query = "UPDATE purchases set Completed=1 where UserID='$UserID' and Type='domain'";
		$buyDB->query($query);
		$Username = $_SESSION['username'];
		$Email = $_SESSION['email'];
		SendDomainEmail($Username, $Email, $Domain, $Discount);
		SendAdminDomainEmail($Username, $Email, $Domain);
		$Done = 1;
	}
	$query = "SELECT Completed from purchases where UserID='$UserID' and PurchaseID='$invoice'";
	$OrderCompleted = $buyDB->queryUniqueValue($query);
	if ($OrderCompleted == 1) {
	$Message = 'Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. <br/><br/>An Email has been sent to you with a link to purchase a discounted Panel Flow Package. After you complete the license transaction you will be able to download the software (5) times. More available upon request. You will also have free access to several modules and templates.<br/><br/>After your domain has been set up on the servers (usually within a few hours), you will recieve an email to access your server information, login details and instructions on how to point your domain\'s nameservers to our servers. If your domain is not set up within 24 hours, or you have not recieved the email, please contact us.';
	}
	
} else if ($Type == 'hostedapp') {
	$query = "SELECT * from purchases where UserID='$UserID' and PurchaseID='$invoice'";
	$buyDB->query($query);
	$Found = $buyDB->numRows();
	if ($Found == 0) {
		$Message = 'Sorry your purchase information was not found in the database, or you have already activated your software. If you purchased the application and have not recieved your confirmation email, please send us an email here: <a href="contact.php">CONTACT</a><br/><br/>If you have already purchased the application and need to Download the application package again, by clicking the link in your profile, under account settings.';
		$buyDB->close();
		$Done = 0;
	} else {
		$query = "UPDATE purchases set Completed=1,TransactionID='$tx_token' where PurchaseID='$invoice'";
		$buyDB->query($query);
		$query = "DELETE from discounts where UserID='$UserID' and type='application'";
		$buyDB->query($query);
		$licenseclear = 0;
		$License = randomPrefix(15); 
		while ($licenseclear == 0) { 
			$query = "SELECT * from licenses where LicenseID = '$License'";
			$buyDB->query($query);
			$Found = $buyDB->numRows();
			if ($Found == 0) {
				$licenseclear = 1;
			}
		}
		if ($licenseclear == 1) {
			$query = "INSERT into licenses (UserID, LicenseID) values ('$UserID', '$License')";
			$buyDB->query($query);
			$Message = 'Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. <br/><br/>you may now install your application and enjoy on (1) domain. If you want to install the application on other domains, just purchase an extra license for $1. <br/> <br/>If you have any problems with the application, please contact us <a href="contact.php">HERE</a> and we\'ll help get it installed and working. If for any reason we cannot get the application running with your hosting solution, we will refund your purchase.<br/><br/><b>To Download your software, please click this link</b>: <a href="download_pro_package.php">DOWNLOAD PANEL FLOW PRO 1.5</a><div class="spacer"></div>';
			$Username = $_SESSION['username'];
			$Email = $_SESSION['email'];
			SendApplicationEmail($Username, $Email, $License);
			SendAdminApplicationEmail($Username, $Email, $License);
			$Done = 1;
		}
	}
	$query = "SELECT Completed from purchases where UserID='$UserID' and PurchaseID='$invoice'";
	$OrderCompleted = $buyDB->queryUniqueValue($query);
	if ($OrderCompleted == 1) {
	$Message = 'Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. <br/><br/>you may now install your application and enjoy on (1) domain. If you want to install the application on other domains, just purchase an extra license for $1. <br/> <br/>If you have any problems with the application, please contact us <a href="contact.php">HERE</a> and we\'ll help get it installed and working. If for any reason we cannot get the application running with your hosting solution, we will refund your purchase.<br/><br/><b>To Download your software, please click this link</b>: <a href="download_pro_package.php">DOWNLOAD PANEL FLOW PRO 1.5</a><div class="spacer"></div>';
	}
}


$buyDB->close();

}
else if (strcmp ($lines[0], "FAIL") == 0) {
	$Message = 'Your transaction was not completed. Please try again.';
}

}

fclose ($fp);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>THANKS FOR YOUR PURCHASE</title>
</head>

<body>
<?php include 'includes/header_content.php';?>
<div class='contentwrapper' align="left">
<div style="height:400px; font-size:14px; padding-top:10px; padding-left:25px; padding-right:30px;">
<? echo $Message;?>
 </div> </div>
  <?php include 'includes/footer_v2.php';?>
</body>
</html>
