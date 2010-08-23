<?php
if ($_POST['hidCCNumber'] == '9876')
{
	
	$auth_net_login_id			= "5YSy76ej2U";
	$auth_net_tran_key			= "4R8T5nMfjYa8486L";
	$auth_net_url				= "https://test.authorize.net/gateway/transact.dll";
}
else
{
	$auth_net_login_id			= "6Y4e39Ge3A";
	$auth_net_tran_key			= "6jgG3DzbE43y349h";
	$auth_net_url				= "https://secure.authorize.net/gateway/transact.dll";
}
#  Uncomment the line ABOVE for test accounts or BELOW for live merchant accounts
#  $auth_net_url				= "https://secure.authorize.net/gateway/transact.dll";

if ($_POST['hidCCNumber'] == '9876')
{
        
	$authnet_values				= array
	(
		"x_login"				=> $auth_net_login_id,
		"x_version"				=> "3.1",
		"x_delim_char"			=> "|",
		"x_delim_data"			=> "TRUE",
		"x_type"				=> "AUTH_CAPTURE",
		"x_method"				=> "CC",
		"x_tran_key"			=> $auth_net_tran_key,
		"x_relay_response"		=> "FALSE",
		"x_card_num"			=> "4242424242424242",
		"x_exp_date"			=> "1209",
		"x_description"			=> "National Emergency Medical ID Merchandise",
		"x_amount"				=> $orderAmount,
		"x_first_name"			=> isset($_POST['hidPaymentFirstName']) ? $_POST['hidPaymentFirstName']: "",
		"x_last_name"			=> isset($_POST['hidPaymentLastName']) ? $_POST['hidPaymentLastName']: "",
		"x_address"				=> isset($_POST['hidPaymentAddress1']) ? $_POST['hidPaymentAddress1']: "",
		"x_city"				=> isset($_POST['hidPaymentCity']) ? $_POST['hidPaymentCity']: "",
		"x_state"				=> isset($_POST['hidPaymentState']) ? $_POST['hidPaymentState']: "",
		"x_zip"					=> isset($_POST['hidPaymentPostalCode']) ? $_POST['hidPaymentPostalCode']: "",
		"InvoiceNumber"			=> $orderId,
	);
}
else
{
	$authnet_values				= array
	(
		"x_login"				=> $auth_net_login_id,
		"x_version"				=> "3.1",
		"x_delim_char"			=> "|",
		"x_delim_data"			=> "TRUE",
		"x_type"				=> "AUTH_CAPTURE",
		"x_method"				=> "CC",
		"x_tran_key"			=> $auth_net_tran_key,
		"x_relay_response"		=> "FALSE",
		"x_card_num"			=> isset($_POST['hidCCNumber']) ? $_POST['hidCCNumber']: "",
		"x_exp_date"			=> $_POST['hidCCMonth'] . $_POST['hidCCYear'],
		"x_description"			=> "National Emergency Medical ID Merchandise",
		"x_amount"				=> $orderAmount,
		"x_first_name"			=> isset($_POST['hidPaymentFirstName']) ? $_POST['hidPaymentFirstName']: "",
		"x_last_name"			=> isset($_POST['hidPaymentLastName']) ? $_POST['hidPaymentLastName']: "",
		"x_address"				=> isset($_POST['hidPaymentAddress1']) ? $_POST['hidPaymentAddress1']: "",
		"x_city"				=> isset($_POST['hidPaymentCity']) ? $_POST['hidPaymentCity']: "",
		"x_state"				=> isset($_POST['hidPaymentState']) ? $_POST['hidPaymentState']: "",
		"x_zip"					=> isset($_POST['hidPaymentPostalCode']) ? $_POST['hidPaymentPostalCode']: "",
		"InvoiceNumber"			=> $orderId,
	);
}
$fields = "";
foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";


//<b>01: Post the transaction (see the code for specific information):";


if ($_POST['hidCCNumber'] == '9876')
{
	$ch = curl_init("https://test.authorize.net/gateway/transact.dll"); 
}
else
{
	###  Uncomment the line ABOVE for test accounts or BELOW for live merchant accounts
	$ch = curl_init("https://secure.authorize.net/gateway/transact.dll"); 
}
curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
### curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
$resp = curl_exec($ch); //execute post and get results
curl_close ($ch);


// 03: Parse post results (simple approach)
$text = $resp;
$tok = strtok($text,"|");
while(!($tok === FALSE)){
    $tok = strtok("|");
}
//04: Parse the results string into individual, meaningful segments:
$arrResp = split('[|]', $text);
			
for($j=0; $j < sizeof($arrResp); $j++){

	$pstr_trimmed = $arrResp[$j];
	switch($j+1){
		case 1:

			$fval="";
			if($pstr_trimmed=="1"){
				$fval="Approved";
			}elseif($pstr_trimmed=="2"){
				$fval="Declined";
			}elseif($pstr_trimmed=="3"){
				$fval="Error";
			}
			break;
		case 2:
			$fvalsub = $pstr_trimmed;
			break;

		case 3:
			//echo "Response Reason Code: ";

			$freasoncode = $pstr_trimmed;
			break;

		case 4:
			$freasontext = $pstr_trimmed;
			break;

		case 5:
			/*echo "Approval Code: ";

			echo "</td>";
			echo "<td class=\"v\">";

			echo $pstr_trimmed;
			echo "<br>";*/
			$fapprovedcode = $pstr_trimmed;
			break;

		case 6:
			/*echo "AVS Result Code: ";

			echo "</td>";
			echo "<td class=\"v\">";

			echo $pstr_trimmed;
			echo "<br>";*/
			$favsresultcode = $pstr_trimmed;
			
			break;

		case 7:
			/*echo "Transaction ID: ";

			echo "</td>";
			echo "<td class=\"v\">";

			echo $pstr_trimmed;
			echo "<br>";*/
			$ftransactionid = $pstr_trimmed;
			break;

		case 8:
			/*echo "Invoice Number (x_invoice_num): ";

			echo "</td>";
			echo "<td class=\"v\">";

			echo $pstr_trimmed;
			echo "<br>";*/
			break;

	}

}
//check the ipn result received back from authenticate
if ($fval=="Approved") { 
	
	require_once './config.php';
            
        // check that the invoice has not been previously processed
        $sql = "SELECT od_status
                FROM tbl_order
                WHERE od_id = $orderId";
		$result = dbQuery($sql);

        // if no invoice with such number is found, exit
        if (dbNumRows($result) == 0) {
            exit;
        } else {
        
            $row = dbFetchAssoc($result);
            
            // process this order only if the status is still 'New'
            if ($row['od_status'] !== 'New') {
                exit;
            } else {

                // check that the buyer sent the right amount of money
                $sql = "SELECT SUM(pd_price * od_qty) AS subtotal
                        FROM tbl_order_item oi, tbl_product p
                        WHERE oi.od_id = $orderId AND oi.pd_id = p.pd_id
                        GROUP by oi.od_id";
                $result = dbQuery($sql);
                $row    = dbFetchAssoc($result);		
                
                $subTotal = $row['subtotal'];
                $total    = $subTotal + $shopConfig['shippingCost'];
                            
                //if ($_POST['payment_gross'] != $total) {
                //    exit;
                //} else {
                   
					$invoice = $_POST['invoice'];
					$memo    = $_POST['memo'];
					if (!get_magic_quotes_gpc()) {
						$memo = addslashes($memo);
					}
					
                    // ok, so this order looks perfectly okay
                    // now we can update the order status to 'Paid'
                    // update the memo too
                    $sql = "UPDATE tbl_order
                            SET od_status = 'Paid', od_memo = '$memo', od_last_update = NOW(),
								od_payment_type='Authenticate.net', od_payment_approved_code='$fapprovedcode',
								od_transaction_id='$ftransactionid', od_avs_resultcode='$favsresultcode',
								od_total_paid='$total'
                            WHERE od_id = $orderId";
                    $result = dbQuery($sql);
                //}
            }
        }
		
	$url = 'http://www.nationalemergencyid.com/checkout_success.php';
	
	$Name = "National Emergency ID Confirmation"; //senders name 
	$emailaddr = "OrderConfirmation@NATIONALEMERGENCYID.COM"; //senders e-mail adress 
	$recipient = $_POST['hidShippingEmail']; //recipient 
	$mail_body = $email; //mail body 
	$subject = "Your Order on National Emergency ID"; //subject 
	$headers .= "From: ". $Name . " <" . $emailaddr . ">\r\n"; //optional headerfields 
	$headers .= "Reply-To: <$emailaddr>\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	mail($recipient, $subject, $mail_body, $headers); //mail command :)
	mail($emailaddr, $subject, $mail_body, $headers); //mail command :)
} else { 
	if ($freasoncode == '')
	{
		$freasoncode = '1111';
		$freasontext = 'Credit card could not be processed.';
	}
	$url = '/checkout.php?step=1';
} 
?>
<center>
    <p>&nbsp;</p>
    <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="333333">Processing 
        Transaction . . . </font></p>
</center>
<form action="<?php echo $url; ?>" method="post" name="frmAuthenticate" id="frmAuthenticate">
	<input name="hidShippingFirstName" type="hidden" id="hidShippingFirstName" value="<?php echo $_POST['hidShippingFirstName']; ?>">
	<input name="hidShippingLastName" type="hidden" id="hidShippingLastName" value="<?php echo $_POST['hidShippingLastName']; ?>">
	<input name="hidShippingAddress1" type="hidden" id="hidShippingAddress1" value="<?php echo $_POST['hidShippingAddress1']; ?>">
	<input name="hidShippingAddress2" type="hidden" id="hidShippingAddress2" value="<?php echo $_POST['hidShippingAddress2']; ?>">
	<input name="hidShippingCity" type="hidden" id="hidShippingCity" value="<?php echo $_POST['hidShippingCity']; ?>">
	<input name="hidShippingState" type="hidden" id="hidShippingState" value="<?php echo $_POST['hidShippingState']; ?>">
	<input name="hidShippingPostalCode" type="hidden" id="hidShippingPostalCode" value="<?php echo $_POST['hidShippingPostalCode']; ?>">
	<input name="hidShippingEmail" type="hidden" id="hidShippingEmail" value="<?php echo $_POST['hidShippingEmail']; ?>">
	<input name="hidShippingPhone" type="hidden" id="hidShippingPhone" value="<?php echo $_POST['hidShippingPhone']; ?>">
	
	<input name="hidPaymentFirstName" type="hidden" id="hidPaymentFirstName" value="<?php echo $_POST['hidPaymentFirstName']; ?>">
	<input name="hidPaymentLastName" type="hidden" id="hidPaymentLastName" value="<?php echo $_POST['hidPaymentLastName']; ?>">
	<input name="hidPaymentAddress1" type="hidden" id="hidPaymentAddress1" value="<?php echo $_POST['hidPaymentAddress1']; ?>">
	<input name="hidPaymentAddress2" type="hidden" id="hidPaymentAddress2" value="<?php echo $_POST['hidPaymentAddress2']; ?>">
	<input name="hidPaymentCity" type="hidden" id="hidPaymentCity" value="<?php echo $_POST['hidPaymentCity']; ?>">
	<input name="hidPaymentState" type="hidden" id="hidPaymentState" value="<?php echo $_POST['hidPaymentState']; ?>">
	<input name="hidPaymentPostalCode" type="hidden" id="hidPaymentPostalCode" value="<?php echo $_POST['hidPaymentPostalCode']; ?>">
	<input name="hidPaymentPhone" type="hidden" id="hidPaymentPhone" value="<?php echo $_POST['hidPaymentPhone']; ?>">

	<input name="hidPaymentMethod" type="hidden" id="hidPaymentMethod" value="<?php echo $_POST['optPayment']; ?>" />
    <input name="hidSame" type="hidden" id="hidSame" value="<?php echo $_POST['hidSame']; ?>" />
	<input name="hidMessage" type="hidden" id="hidMessage" value="<?php echo $freasoncode . ' - ' . $freasontext; ?>" />
	<input type="hidden" name="invoice" id="invoice" value="<?php echo $orderId; ?>">

</form>
<script language="JavaScript" type="text/javascript">
window.onload=function() {
	window.document.frmAuthenticate.submit();
}
</script>
