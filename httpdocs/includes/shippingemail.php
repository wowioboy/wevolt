<?
include_once("includes/db.class.php");

$sendit = false;
$db = new DB();
$Server = substr($_SERVER['SERVER_NAME'],4,strlen($_SERVER['SERVER_NAME'])-1);
$db->query("select * from tbl_order AS o join tbl_order_item AS oi ON oi.od_id = o.od_id join pf_store_items AS s ON s.id=oi.pd_id where oi.id=" . $_POST['id']);

while ($line = $db->fetchNextObject()) 
{
	$orderId = $line->od_id;
	$email .= '<html><body>';
	$email .= 'Dear ' . $line->od_shipping_first_name . ' ' . $line->od_shipping_last_name . '<br /><br />'; 
}
$email .= 'Thank you for shopping with '.$Server.'. Your item has now been shipped.<br /><br />';  
$email .= '<hr /><br />';
$email .= 'Shippment Tracking Code is ' . $_POST['txtTrackingCode'] . '<br/>';
$email .= 'Shipped via ' . $_POST['txtShippingMethod'] . '<br/><br/>';
$email .= 'Your Order ID: ' . $_POST['id'] . "<br /><br />\r\n";  
$email .= '<table width="350px" border="0" cellpadding="0" cellspacing="0">';  
$email .= '<tr class="content">'; 
$email .= '<td>Product</td>';
$email .= '<td>Status</td>';
$email .= '</tr>';
$email .= '<tr><td colspan="2"><hr /></td></tr>';
	
	$db->query("select * from tbl_order_item AS oi join pf_store_items AS s ON s.id=oi.pd_id where od_id=$orderId");

while ($line = $db->fetchNextObject()) 
{

	$email .= '<tr class="content">'; 
	$email .= '<td>' . $line->ShortTitle . '</td>';
	$emailstat = '';
	if ($line->Complete == 0){
		$email .= '<td>Waiting for customer to complete.</td>';
		$emailstat = 'is waiting for customer to complete';
	} else if ($line->Complete == 3){ 
		$email .= '<td>';
		
		if ($line->ShippingOption == 1) {
			$email .= 'Download Link Sent';
		}else {
		$email .= 'Shipped';
		}
		
		
		$email .= '</td>';
		$emailstat = 'has been shipped';
		$sendit = true;
	} else {
		$email .= '<td>Being processed.</td>';
		$emailstat = 'is begin processed';
	}
	$email .= "</tr>\r\n";
	//print 'MY SHIPPING = ' . $line->ShippingOption;
	if (($line->ShippingOption == 1) && ($ShippingSet != 1)) {
		$sendit = false;
		$ShippingSet = 0;
	} else {
		$sendit = true;
		$ShippingSet = 1;
	}
	
}

$email .= '</table>';
$db->query("select * from tbl_order AS o join tbl_order_item AS oi ON oi.od_id = o.od_id where oi.id=" . $_POST['id']);

while ($line = $db->fetchNextObject()) 
{
	$email .= '<hr /><br />';
	$email .= 'PRICE<br />';
	$email .= 'Shipping Price: ' . $line->od_shipping_cost . "<br />\r\n";
	$email .= 'Total: ' . $line->od_total_cost . "<br />\r\n";
	$email .= '<br /><br />';
	$email .= '<hr /><br />';
	$email .= 'DELIVERY DETAILS<br />';
	if ($ShippingSet == 1) {
	$email .= $line->od_shipping_first_name . ' ' . $line->od_shipping_last_name . "<br />\r\n";
	$email .= $line->od_shipping_address1 . "<br />\r\n";
	$email .= $line->od_shipping_address2 . "<br />\r\n";
	$email .= $line->od_shipping_city . "<br />\r\n";
	$email .= $line->od_shipping_state . "<br />\r\n";
	$email .= $line->od_shipping_postal_code . "<br />\r\n";
	} else {
	$email .= "DIGITAL DELIVERY - DOWNLOAD LINK SENT<br />\r\n";
	}
	$email .= '<hr /><br /><br />';  
	$email .= 'http://'.$Server;		
	$email .= '</body></html>';
	$emailaddress = $line->od_shipping_email;
}
$db->close();

$Name = "Order Confirmation"; //senders name 
$emailaddr = "OrderConfirmation@".$Server; //senders e-mail adress 
$recipient = $emailaddress; //recipient 
$mail_body = $email; //mail body 
$subject = "Your Order on ".$Server .' '. $emailstat; //subject 
$headers .= "From: ". $Name . " <" . $emailaddr . ">\r\n"; //optional headerfields 
$headers .= "Reply-To: <$emailaddr>\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

if ($sendit)
{
	mail($recipient, $subject, $mail_body, $headers); //mail command :)
}
?>