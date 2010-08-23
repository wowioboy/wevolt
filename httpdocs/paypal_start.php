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
include 'includes/init.php';
$PageTitle = 'payapl processing';
$TrackPage = 0;
include_once('cart/cart-functions.php');
include_once('cart/common.php');
include_once 'cart/checkout-functions.php';

$date = date('Y-m-d h:i:s');
$PurchaseID = randomPrefix(15); 
$UserID = $_SESSION['userid'];
if (($_GET['type'] == 'selfbook')||($_GET['type'] == 'selfmerch')||($_GET['type'] == 'selfprint')) {
	$query = "SELECT * from users_data where UserID='$UserID'";
	$StoreArray = $InitDB->queryUniqueObject($query);
} else{
	$query = 'SELECT * from pf_store';
	$StoreArray = $InitDB->queryUniqueObject($query);
	
}
// Create an instance of the paypal library
$myPaypal = new Paypal();

if ($_GET['t'] == 'sub') {		
	$SubID = $_GET['subid'];
	$Domain = $_GET['domain'];
	$Type = $_GET['type'];
	$query = "SELECT * from pf_subscription_types where ID='$SubID'";
	$SubscriptionArray = $InitDB->queryUniqueObject($query);
	
	$query = "SELECT * from pf_subscriptions where UserID='$UserID' and SubscriptionType ='$Type'";

	$SubArray = $InitDB->queryUniqueObject($query);
	$SubStatus = $SubArray->Status;
	
	
	
		$PurchaseID = randomPrefix(15); 
		$query = "INSERT into tbl_order (od_date, od_type, od_transaction_id, od_status, od_total_cost, od_total_paid) values ('$date','subscription','$PurchaseID','new','".$SubscriptionArray->Price."','".$SubscriptionArray->Price."')";
		$InitDB->execute($query);
		$query = "SELECT od_id from tbl_order where od_transaction_id='$PurchaseID'";
		$OrderID = $InitDB->queryUniqueValue($query);
		$query = "INSERT into tbl_order_item (od_id, sub_id,Complete) values ('$OrderID', '$SubID',1)";
		$InitDB->execute($query);	
		$query = "INSERT into user_orders (orderid, userid) values ('$OrderID', '$UserID')";
		$InitDB->execute($query);	
		
		if (($SubStatus != '') && ($SubStatus != 'Active')) {
			if ($Type == 'application') {
			$query = " UPDATE pf_subscriptions set Status='pending',OrderID='$OrderID', TypeID='$SubID' where  SubscriptionType='application' and UserID='$UserID'";
			}else if ($Type == 'hosted') {
			$query = " UPDATE pf_subscriptions set Status='pending',OrderID='$OrderID', LastUpdated='$date', TypeID='$SubID' where  SubscriptionType='hosted' and UserID='$UserID'";
			}else if ($Type == 'fan') {
			$query = " UPDATE pf_subscriptions set Status='pending',OrderID='$OrderID', LastUpdated='$date', TypeID='$SubID' where  SubscriptionType='fan' and UserID='$UserID'";
			}
			$InitDB->execute($query);
		} else {
			$query = "INSERT into pf_subscriptions (UserID, Status,OrderID, TypeID, SubscriptionType, SubscriptionDomain) values ('$UserID','pending','$OrderID','$SubID', '$Type','$Domain')";
			$InitDB->execute($query);
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
    $TrialMeasure =  $SubscriptionArray->TrialMeasure;
	
	if ($TrialPeriod != '') {
		$myPaypal->addField('a1', '0');
		$myPaypal->addField('p1', $TrialPeriod);
		$myPaypal->addField('t1', $TrialMeasure);
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
} else if ($_GET['t'] == 'product') {		
	$ProductID = $_GET['id'];
	$Type = $_GET['type'];	
	$query = "SELECT * from pf_store_items where EncryptID='$ProductID' and ProductType='$Type'";
	$ProductArray = $InitDB->queryUniqueObject($query);
		$PurchaseID = randomPrefix(15); 
		$query = "INSERT into tbl_order (od_date, od_type, od_transaction_id, od_status, od_total_cost, od_total_paid) values ('$date','product','$PurchaseID','new','".$ProductArray->Price."','".$ProductArray->Price."')";
		$InitDB->execute($query);
		
		$query = "SELECT od_id from tbl_order where od_transaction_id='$PurchaseID'";
		$OrderID = $DB->queryUniqueValue($query);
		$query = "INSERT into tbl_order_item (od_id, pd_id,Complete) values ('$OrderID', '$ProductID',1)";
		$InitDB->execute($query);	
		//print $query;
		$query = "INSERT into user_orders (orderid, userid) values ('$OrderID', '$UserID')";
		$InitDB->execute($query);	
			
//print $query;
	$ItemName = $ProductArray->ShortTitle;
	$Code = $ProductArray->ProductCode;
	$Price = $ProductArray->Price;
	$Shipping = $ProductArray->ShippingRate;
	$myPaypal->addField('item_number_1', $Code);
	$myPaypal->addField('item_name_1', $ItemName);
    $myPaypal->addField('amount_1', $Price);

	$myPaypal->addField('quantity_1', '1');
	$myPaypal->addField('currency_code', 'USD');
	if (($_GET['type'] == 'selfbook')||($_GET['type'] == 'selfmerch')||($_GET['type'] == 'selfprint')) {
	        $query = "UPDATE tbl_order set 
			          od_shipping_first_name='".mysql_real_escape_string($_POST['txtShippingFirstName'])."',
					  od_shipping_last_name='".mysql_real_escape_string($_POST['txtShippingLastName'])."',
					  od_shipping_address1='".mysql_real_escape_string($_POST['txtShippingAddress1'])."',
					  od_shipping_address2='".mysql_real_escape_string($_POST['txtShippingAddress2'])."',
					  od_shipping_city='".mysql_real_escape_string($_POST['txtShippingCity'])."',
					  od_shipping_state='".mysql_real_escape_string($_POST['txtShippingState'])."',
					  od_shipping_postal_code='".mysql_real_escape_string($_POST['txtShippingPostalCode'])."',
					  od_shipping_phone='".mysql_real_escape_string($_POST['txtShippingPhone'])."',
					  od_shipping_email='".mysql_real_escape_string($_POST['txtShippingEmail'])."' 
					  where od_id='$OrderID'";
			$InitDB->execute($query);			  
			$myPaypal->addField('address1',$_POST['txtShippingAddress1']);
			$myPaypal->addField('address2', $_POST['txtShippingAddress2']);
			$myPaypal->addField('city', $_POST['txtShippingCity']);
			$myPaypal->addField('state',$_POST['txtShippingState']);
			$myPaypal->addField('zip', $_POST['txtShippingPostalCode']);
			$myPaypal->addField('first_name', $_POST['txtShippingFirstName']);
			$myPaypal->addField('last_name', $_POST['txtShippingLastName']);
			$myPaypal->addField('no_shipping', 2);
			$myPaypal->addField('shipping_1', $Shipping);
	} else {
			$myPaypal->addField('no_shipping', 1);
	}
	
} else {
	$orderId= $_SESSION['orderId'];
	$query = "UPDATE tbl_order set od_transaction_id ='$PurchaseID' where od_id='$orderId'";
	$InitDB->execute($query);
//print $query;
	$query = "SELECT * from tbl_order_item where od_id='$orderId'";
	$InitDB->query($query);
//print $query;
	$Count = 1;
	while ($orderitem = $InitDB->fetchNextObject()) { 
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

// Specify your paypal email
$myPaypal->addField('business', $StoreArray->PayPalEmail);
// Specify the currency
$myPaypal->addField('currency_code', 'USD');

// Specify the url where paypal will send the user on success/failure
$SERVER = $_SERVER['SERVER_NAME'];


if (($Type == 'hosted') ||($Type == 'fan')){
	$myPaypal->addField('return', 'http://www.wevolt.com/register.php?a=pro&r=success');
	$myPaypal->addField('cancel_return', 'http://www.wevolt.com/register.php?a=pro&d=cancel');
} else {
	$myPaypal->addField('return', 'http://www.wevolt.com/store.php?r=success');
	$myPaypal->addField('cancel_return', 'http://www.wevolt.com/store.php?r=cancel');
}

// Specify the url where paypal will send the IPN
$myPaypal->addField('notify_url', 'http://www.wevolt.com/gateway/paypal_ipn.php');
// Specify the product information
// Specify any custom value
$myPaypal->addField('custom', $PurchaseID);
// Enable test mode if needed
//$myPaypal->enableTestMode();
// Let's start the train!
unset($_SESSION['orderId']);

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
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>>
        <div style="padding:10px;" class="messageinfo_white" align="center"><div class="spacer"></div><div class="spacer"></div>
<? $myPaypal->submitPayment();?>

 </div></td>
  </tr>
</table>
</div>
<?php include 'includes/footer_template_new.php';?>
