<? 
include_once ('Paypal.php');
include($_SERVER['DOCUMENT_ROOT'].'/includes/init.php');
include($_SERVER['DOCUMENT_ROOT'].'/includes/email_functions.php');


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
$query = 'SELECT * from pf_store';
$StoreArray = $InitDB->queryUniqueObject($query); 
$StoreTitle = stripslashes($StoreArray->Title);
// Create an instance of the paypal library
$myPaypal = new Paypal();

// Log the IPN results
$myPaypal->ipnLog = TRUE;
$header = "From: store@wevolt.com  <store@wevolt.com >\n";
$header .= "Reply-To: store@wevolt.com <store@wevolt.com>\n";
$header .= "X-Mailer: PHP/" . phpversion() . "\n";
$header .= "X-Priority: 1";
				
			
// Enable test mode if needed
//$myPaypal->enableTestMode();
 $output = 'IPN DATA = ------------';
// Check validity and write down it
if ($myPaypal->validateIpn())
{
    if (($myPaypal->ipnData['payment_status'] == 'Completed') || ($myPaypal->ipnData['txn_type'] != ''))
    {	 
	     $BuyerEmail = $myPaypal->ipnData['payer_email'];
		 $PurchaseID =  $myPaypal->ipnData['transaction_subject'];
		 $SellerEmail =  'info@wevolt.com';//$myPaypal->ipnData['receiver_email'];
		 $TotalPaid =  $myPaypal->ipnData['payment_gross'];
		 $num_cart_items = $myPaypal->ipnData['num_cart_items'];
		 $TransactionType = $myPaypal->ipnData['txn_type'];
		 $Custom = $myPaypal->ipnData['custom'];
		 $PayPalSubID = $myPaypal->ipnData['subscr_id'];
		 $output .= 'SUBSCRIPTION ID = ' . $PayPalSubID.'-------------';
		 $count = 1;
		 
		 if ($TransactionType == 'subscr_signup') {
		 	$query = "SELECT * from tbl_order where od_transaction_id='$Custom'";
			$output .= $query.'------';
			$OrderArray = $InitDB->queryUniqueObject($query);
			$OrderID = $OrderArray->od_id;
			$PurchaseID =  $Custom;
			
			$query = "SELECT * from pf_subscriptions where OrderID ='$OrderID'";
			$SubArray = $InitDB->queryUniqueObject($query);
			$output .= $query.'------';
			$SubType = $SubArray->SubscriptionType;
			$UserID = $SubArray->UserID;
			$Domain =  $SubArray->SubscriptionDomain;
			
			$query = "SELECT * from users where encryptid='$UserID'";
			$UserArray = $InitDB->queryUniqueObject($query);
			$output .= $query.'------';
			$query = "UPDATE pf_subscriptions set Status='active', PayPalSubID='$PayPalSubID', PaymentEmail='$BuyerEmail' where OrderID='$OrderID'";
			$InitDB->execute($query);
			$output .= $query.'------';
			// file_put_contents('query.txt', 'SUCCESS ---- query1 ='.$query1.' query2'.$query2.' query3'.$query3);
			
			if ($SubType == 'hosted') {
				$query = "UPDATE users set HostedAccount='1' where encryptid='$UserID'";
				$InitDB->execute($query);
				$output .= $query.'------';
				$to = $BuyerEmail;
				$subject = "Your WEvolt Pro Subscription is now active!";
				$SellerSubject ="A ".$SubType." subscription has processed";
				$Sellerbody = "A user has paid for a hosted subscription at WEvolt. No further action is needed.";
				$body = "Your Pro WEvolt subscription is now active. \n\nAny questions or concerns, you can send an email to: info@wevolt.com. Also as an extra bonus, you just recieved 2600 WEvolt XP points. Eventually you can use these points to unlock more features on the site as well as trade points for rewards!\n\nThanks for going pro. We hope you enjoy the experience. ";
				
   				mail($to, $subject, $body, $header);
			    mail($SellerEmail, $SellerSubject, $Sellerbody, $header); 
     			 include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
				$XPMaker = new Users();
				$XPMaker->addxp($InitDB, $UserID, 2600);
				$query = "INSERT into suprise_codes_redeem (Code, UserID) values ('register_2600', '$UserID')"; 
				$InitDB->execute($query);	
				$output .= $query.'------';
			} else if ($SubType == 'fan') {
				$query = "UPDATE users set HostedAccount='1' where encryptid='$UserID'";
				$InitDB->execute($query);
				$output .= $query.'------';
				$to = $BuyerEmail;
				$subject = "Your WEvolt Super Fan Subscription is now active!";
				$SellerSubject ="A ".$SubType." subscription has processed";
				$Sellerbody = "A user has paid for a Super Fan subscription at WEvolt. No further action is needed.";
				$body = "Your WEvolt Super Fan subscription is now active. \n\nAny questions or concerns, you can send an email to: info@wevolt.com. Also as an extra bonus, you just recieved 2600 WEvolt XP points. Eventually you can use these points to unlock more features on the site as well as trade points for rewards!\n\nThanks for going pro. We hope you enjoy the experience. ";
				
   				mail($to, $subject, $body, $header);
			    mail($SellerEmail, $SellerSubject, $Sellerbody, $header); 
     			 include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
				$XPMaker = new Users();
				$XPMaker->addxp($InitDB, $UserID, 2600);
				$query = "INSERT into suprise_codes_redeem (Code, UserID) values ('register_2600', '$UserID')"; 
				$InitDB->execute($query);	
				$output .= $query.'------';
			} else if ($SubType == 'domain') {
			
				$licenseclear = 0;
				$License = randomPrefix(15); 
				while ($licenseclear == 0) { 
					$query = "SELECT * from licenses where LicenseID = '$License'";
					$InitDB->query($query);
					$output .= $query.'------';
					$Found = $InitDB->numRows();
					if ($Found == 0) {
						$licenseclear = 1;
					}
				}
		
					$query = "INSERT into licenses (UserID, LicenseID) values ('$UserID', '$License')";
					$InitDB->execute($query);
					$output .= $query.'------';
					$Message = 'Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. <br/>After your domain has been set up on the servers (usually within a few hours), you will recieve an email to access your server information, login details and instructions on how to point your domain\'s nameservers to our servers. If your domain is not set up within 24 hours, or you have not recieved the email, please contact us.';

					$Username = $UserArray->username;
					$UserEmail = $UserArray->email;
					$Discount = 'none';
					$output .= '------' . SendApplicationEmail($Username, $UserEmail, $License);
					SendDomainEmail($Username, $UserEmail, $Domain, $Discount);
					SendAdminDomainEmail($Username, $UserEmail, $Domain);
					$query = "UPDATE users set HostedAccount='3' where encryptid='$UserID'";
				 	$InitDB->execute($query);
					
					 $to = $BuyerEmail;
					 $output .= $query.'------';
				 	$subject = "Your Order Has been Processed";
					$SellerSubject ="You have recieved payment confirmation on an Order";
				$Sellerbody = "You have a new domain hosting subscriber.\n\nTransaction ID = ".$PurchaseID.".";
				$body = "Your order with ".$StoreTitle." has been processed. You will recieve a shipping confirmation shortly, if you purchased an item with Digital Delivery, you will recieve an email with a link to download your purchase. \n\nAny questions or concerns, you can send an email to: ".$SellerEmail.".";
				$Server = substr($_SERVER['SERVER_NAME'],4,strlen($_SERVER['SERVER_NAME'])-1);
   				 mail($to, $subject, $Message, "From: store@".$Server); 
				mail($SellerEmail, $SellerSubject, $Sellerbody, "From: store@".$Server);
			
			}  else if ($SubType == 'application') {
				
				$licenseclear = 0;
				$License = randomPrefix(15); 
				while ($licenseclear == 0) { 
					$query = "SELECT * from licenses where LicenseID = '$License'";
					$InitDB->query($query);
					$output .= $query.'------';
					$Found = $InitDB->numRows();
					if ($Found == 0) {
						$licenseclear = 1;
					}
				}
		

					$query = "INSERT into licenses (UserID, LicenseID) values ('$UserID', '$License')";
					$InitDB->execute($query);
					$output .= $query.'------';
					$Message = "Your transaction has been completed and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com/us to view details of this transaction. \n\nYou may now downlaod and install the CMS Client by clicking the 'Applications' tab in your profile. Here you can download the client, or get updates.  \n\nIf you have any problems with the application, please contact us and we\'ll help get it installed and working. If for any reason we cannot get the application running with your hosting solution, we will refund your purchase.\n\n";
					$Username = $UserArray->username;
					$UserEmail = $UserArray->email;
					$output .= '------' . SendApplicationEmail($Username, $UserEmail, $License);
					SendAdminApplicationEmail($Username, $UserEmail, $License);
				
				 $query = "UPDATE users set HostedAccount='2' where encryptid='$UserID'";
				 $InitDB->execute($query);
				 $to = $BuyerEmail;
				 $output .= $query.'------';
				 $subject = "Your Order Has been Processed";
				$SellerSubject ="You have recieved payment confirmation on an Order";
				$Sellerbody = "An order has been paid for and is ready for shipping. Please log into the Store admin to complete this purchase and ship the item.\n\nTransaction ID = ".$PurchaseID.".";
				$body = "Your order with Panel Flow has been processed. \n\nAny questions or concerns, you can send an email to: ".$SellerEmail.".";
				$Server = substr($_SERVER['SERVER_NAME'],4,strlen($_SERVER['SERVER_NAME'])-1);
   				 mail($to, $subject, $Message, "From: store@".$Server); 
				mail($SellerEmail, $SellerSubject, $Sellerbody, "From: store@".$Server);
			
			}
		 
		 } else  if ($TransactionType == 'subscr_cancel') {
				
			$query = "UPDATE pf_subscriptions set Status='cancelled' where PayPalSubID='$PayPalSubID'";
			$InitDB->execute($query);
			
			$query = "SELECT UserID from pf_subscriptions where PayPalSubID='$PayPalSubID'";
			$UserID = $DB->queryUniqueValue($query);
			$output .= $query.'------';
			
			$query = "UPDATE users set HostedAccount='0' where encryptid='$UserID'";
			$InitDB->execute($query);
				$output .= $query.'------';
			$to = $BuyerEmail;
			$subject = "Your Subscription is now cancelled";
			$SellerSubject ="A subscription has been cancelled.";
			$Sellerbody = 'A user has cancelled their subscription. SubscriptionID='.$PayPalSubID;
			$body = "Your subscription is now cancelled. You will still be able to use the free version of WEVolt but will not have access to any of the pro features.";
				$Server = substr($_SERVER['SERVER_NAME'],4,strlen($_SERVER['SERVER_NAME'])-1);
   				 mail($to, $subject, $body, "From: store@".$Server); 
				 mail($SellerEmail, $SellerSubject, $Sellerbody, "From: store@".$Server);
			
		} else {
		     if ($Custom != '') {
		 		$query = "UPDATE tbl_order set od_status='Paid', od_total_paid='$TotalPaid' where od_transaction_id='$Custom'";
		 		$InitDB->execute($query);
				$output .= $query.'------';
		  		$query = "SELECT * from tbl_order where od_transaction_id='$Custom'";
		   		$OrderArray = $InitDB->queryUniqueObject($query);
				$output .= $query.'------';
		   		$OrderID = $OrderArray->od_id;
		   		$ShippingEmail = $OrderArray->od_shipping_email;
        // file_put_contents('paypal.txt', 'SUCCESS - '.$myPaypal->ipnData['transaction_subject'].'BUYER = ' . $BuyerEmail.' SELLER = ' . $SellerEmail.' query ='.$query);
				if ($ShippingEmail == '') {
					$ShippingEmail = $BuyerEmail;
					$query = "UPDATE tbl_order set od_shipping_email='$BuyerEmail' where od_transaction_id='$Custom'";
		 			$InitDB->execute($query);
					$output .= $query.'------';
				}
				$to = $BuyerEmail;
				$subject = "Your Order Has been Processed";
				$SellerSubject ="You have recieved payment confirmation on an Order";
				$Sellerbody = "An order has been paid for and is ready for shipping. Please log into your Panel Flow account to complete this purchase and ship the item.\n\nIf this product was a digital delivery, there is no further action required by you. Your profit will be deposited into your Payapl account. Transaction ID = ".$Custom.".";
				$body = "Your order has been processed. You will recieve a shipping confirmation shortly, if you purchased an item with Digital Delivery, you will recieve an email with a link to download your purchase. \n\nAny questions or concerns, you can send an email to: ".$SellerEmail.".";
				
				$Adminbody = "A creator's digital product has been purchased. \n\nSeller Email: ".$SellerEmail."\n\nTransaction ID = ".$Custom.".";
				$Server = substr($_SERVER['SERVER_NAME'],4,strlen($_SERVER['SERVER_NAME'])-1);

    			mail($to, $subject, $body, "From: info@panelflow.com"); 
				mail($SellerEmail, $SellerSubject, $Sellerbody, "From: info@panelflow.com");
				
				$query = "SELECT * from tbl_order_item where od_id='$OrderID'";
				$output .= $query.'------';
				$InitDB->query($query);
				while ($orderitem = $InitDB->fetchNextObject()) { 
					$ProductID = $orderitem->pd_id;
					$OrderItemID = $orderitem->id;
					$DB2 = new DB();
					$query = "SELECT * from pf_store_items as pf
					          join users_data as ud on pf.UserID=ud.UserID
							   where pf.EncryptID='$ProductID'";
					$ProductArray = $DB2->queryUniqueObject($query);
					$output .= $query.'------';
					$DigitalDelivery = $ProductArray->ShippingOption;
					$ProductTitle = stripslashes($ProductArray->ShortTitle);
					$output .'PRODUCT TYPE = ' . $ProductArray->ProductType.'------------';
					if (($ProductArray->ProductType == 'ebook') || ($ProductArray->ProductType == 'pdf')) {
					mail('store@outlandentertainment.com', 'Creator Product Purchased', $Adminbody, "From: info@panelflow.com"); 
					
					}
					if ($DigitalDelivery == 1) {
						$DownloadID = randomPrefix(20); 
						$query = "INSERT into pf_store_digital_delivery (OrderID, OrderItemID, ProductID, DownloadID) values ('$OrderID','$OrderItemID','$ProductID', '$DownloadID')";
						$DB2->execute($query);
						$output .= $query.'------';
						$to = $BuyerEmail;
						$subject = "Your Product Download Link ";
						$body = "Thanks for your recent purchase of the item: \n".$ProductTitle."\n\nBelow is a link to download the item. This link is only good for one download, if you require more, please contact us on the website for an extension. \n\nDOWNLOAD LINK: Copy and paste into a browser: https://www.panelflow.com/store/download/?code=".$DownloadID."\n\nThanks!";
						$body .= "\n\n---------------------------\n";
						mail($to, $subject, $body, "From: info@panelflow.com");
						$output .= $body.'------';
					}
					$DB2->close();
				}
	
    	}
		
      }
	} else {
         file_put_contents('paypal.txt', "FAILURE\n\n" . $myPaypal->ipnData);
    }
}
$output .= '-------------------END OF PROCESSING ENTRY ----------------------';
$newfile= $_SERVER['DOCUMENT_ROOT']."/gateway/processing_log_v3.txt";
$file = fopen ($newfile, "w");
fwrite($file, $output);
fclose ($file); 
chmod($newfile,0777);
		
		?>