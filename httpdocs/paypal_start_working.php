<? 
function randomPrefix($length) {
$random= "";

srand((double)microtime()*1000000);

$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
$data .= "0FGH45OP89";

for($i = 0; $i < $length; $i++) {
$random .= substr($data, (rand()%(strlen($data))), 1);

}
return $random;
}


// Include the paypal library
if ($_GET['t'] == 'sub') {
	include_once ('gateway/Paypal_subscribe.php');
} else {
	include_once ('gateway/Paypal.php');
}
include_once ('includes/init.php');
include_once('cart/cart-functions.php');
include_once('cart/common.php');
include_once 'cart/checkout-functions.php';
$DB = new DB();
$date = date('Y-m-d h:m:s');
$PurchaseID = randomPrefix(15); 
$query = 'SELECT * from pf_store';
$StoreArray = $DB->queryUniqueObject($query);
// Create an instance of the paypal library
$myPaypal = new Paypal();
$UserID = $_SESSION['userid'];
if ($_GET['t'] == 'sub') {		
	$SubID = $_GET['subid'];
	$Type = $_GET['type'];
	$query = "SELECT * from pf_subscription_types where ID='$SubID'";
	$SubscriptionArray = $DB->queryUniqueObject($query);
	
	$query = "SELECT * from pf_subscriptions where UserID='$UserID'";
	$SubArray = $DB->queryUniqueObject($query);
	$SubStatus = $SubArray->Status;
	
	
		$PurchaseID = randomPrefix(15); 
		$query = "INSERT into tbl_order (od_date, od_type, od_transaction_id, od_status, od_total_cost, od_total_paid) values ('$date','subscription','$PurchaseID','new','".$SubscriptionArray->Price."','".$SubscriptionArray->Price."')";
		$DB->execute($query);
		$query = "SELECT od_id from tbl_order where od_transaction_id='$PurchaseID'";
		$OrderID = $DB->queryUniqueValue($query);
		$query = "INSERT into tbl_order_item (od_id, sub_id,Complete) values ('$OrderID', '$SubID',1)";
		$DB->execute($query);	
		$query = "INSERT into user_orders (orderid, userid) values ('$OrderID', '$UserID')";
		$DB->execute($query);	
		
		if (($SubStatus != '') && ($SubStatus != 'Active')) {
			$query = " UPDATE pf_subscriptions set Status='pending',OrderID='$OrderID' where UserID='$UserID'";
			$DB->execute($query);
		} else {
			$query = "INSERT into pf_subscriptions (UserID, Status,OrderID, TypeID, SubscriptionType) values ('$UserID','pending','$OrderID','$SubID', '$Type')";
			$DB->execute($query);
		}
	
//print $query;
	$TrialPeriod = $SubscriptionArray->TrialPeriod;
	$ItemName = $SubscriptionArray->Name;
	$Code = $SubscriptionArray->ProductCode;
	$Price = $SubscriptionArray->Price;
	$Frequency = $SubscriptionArray->Frequency;
	$SubTerm = $SubscriptionArray->SubTerm;
	$myPaypal->addField('item_number', $Code);
	$myPaypal->addField('item_name', $ItemName);
	if ($TrialPeriod != '') {
		$myPaypal->addField('a1', '0');
		$myPaypal->addField('p1', $TrialPeriod);
		$myPaypal->addField('t1', 'D');
		$myPaypal->addField('a3', $Price);
		$myPaypal->addField('p3', $Frequency);
		$myPaypal->addField('t3', $SubTerm);
		$myPaypal->addField('src', '1');
		$myPaypal->addField('sra', '1');
	} else {
		$myPaypal->addField('a3', $Price);
		$myPaypal->addField('p3', $Frequency);
		$myPaypal->addField('t3', $SubTerm);
	}
	$myPaypal->addField('currency_code', 'USD');
} else {
	$orderId= $_SESSION['orderId'];
	$query = "UPDATE tbl_order set od_transaction_id ='$PurchaseID' where od_id='$orderId'";
	$DB->execute($query);
//print $query;
	$query = "SELECT * from tbl_order_item where od_id='$orderId'";
	$DB->query($query);
//print $query;
	$Count = 1;
	while ($orderitem = $DB->fetchNextObject()) { 
		$ProductID = $orderitem->pd_id;
		$query = "SELECT * from pf_store_items where ID='$ProductID'";
		$ProductArray = $DB->queryUniqueObject($query);
//print $query;
		$Quanity = $orderitem->od_qty;
		$ItemName = $ProductArray->ShortTitle;
		$ShippingRate = $ProductArray->ShippingRate;
		$Code = $ProductArray->ProductCode;
		$Price = $ProductArray->Price;
		$Quanity1 = $ProductArray->Quanity1;
		$QuanityPrice = $ProductArray->QuanityPrice1;
		$myPaypal->addField('item_name_'.$Count, $ItemName);
		$myPaypal->addField('shipping_'.$Count, $ShippingRate);
		$myPaypal->addField('amount_'.$Count, $Price);
		$myPaypal->addField('item_number_'.$Count, $Code);
		$myPaypal->addField('quantity_'.$Count, $Quanity);
		$Count++;
	}
}

$DB->close();
// Specify your paypal email
$myPaypal->addField('business', $StoreArray->PayPalEmail);
// Specify the currency
$myPaypal->addField('currency_code', 'USD');

// Specify the url where paypal will send the user on success/failure
$SERVER = $_SERVER['SERVER_NAME'];
$myPaypal->addField('return', 'http://'.$SERVER.'/store.php?a=success');
$myPaypal->addField('cancel_return', 'http://'.$SERVER.'/store.php?a=cancel');

// Specify the url where paypal will send the IPN
$myPaypal->addField('notify_url', 'http://'.$SERVER.'/gateway/paypal_ipn.php');
// Specify the product information
// Specify any custom value
$myPaypal->addField('custom', $PurchaseID);
// Enable test mode if needed
//$myPaypal->enableTestMode();
// Let's start the train!
unset($_SESSION['orderId']);

$PageTitle = ' | Order Process Beginning - Please Wait';
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
<? $myPaypal->submitPayment();?>
</div>
  <?php include 'includes/footer_v2.php';?>
</body>
</html>


