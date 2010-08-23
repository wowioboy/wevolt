<?php
// this page only process a POST from paypal website
// so make sure that the one requesting this page comes
// from paypal. we can do this by checking the remote address
// the IP must begin with 66.135.197.
if (strpos($_SERVER['REMOTE_ADDR'], '66.135.197.') === false) {
	exit;
}

require_once './paypal.inc.php';

// repost the variables we get to paypal site
// for validation purpose
$result = fsockPost($paypal['url'], $_POST); 

//check the ipn result received back from paypal
if (eregi("VERIFIED", $result)) { 
	
		require_once './config.php';
            
        // check that the invoice has not been previously processed
        $sql = "SELECT od_status
                FROM tbl_order
                WHERE od_id = {$_POST['invoice']}";

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
                        WHERE oi.od_id = {$_POST['invoice']} AND oi.pd_id = p.pd_id
                        GROUP by oi.od_id";
                $result = dbQuery($sql);
                $row    = dbFetchAssoc($result);		
                
                $subTotal = $row['subtotal'];
                $total    = $subTotal + $shopConfig['shippingCost'];
                            
                if ($_POST['payment_gross'] != $total) {
                    exit;
                } else {
                   
					$invoice = $_POST['invoice'];
					$memo    = $_POST['memo'];
					$ftransactionid    = $_POST['txn_id'];
					if (!get_magic_quotes_gpc()) {
						$memo = addslashes($memo);
					}
					
                    // ok, so this order looks perfectly okay
                    // now we can update the order status to 'Paid'
                    // update the memo too
                    $sql = "UPDATE tbl_order
                            SET od_status = 'Paid', od_memo = '$memo', od_last_update = NOW(),
							od_payment_type='Paypal', od_total_paid='$total', od_transaction_id='$ftransactionid'
							WHERE od_id = $invoice";
                    $result = dbQuery($sql);
					
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

                }
            }
        }

} else { 
	exit;
} 


?>

