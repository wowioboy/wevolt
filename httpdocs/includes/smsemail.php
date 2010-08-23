<?

//Send Account Email
	$to = '3106135204@tmomail.net';
	$subject = "from sms";
	$body = "testing";
    if (mail($to, $subject, $body, "From: noreply@panelflow.com")) {
	echo "MAIL SENT" ;
	
 } else {
  
 }

?>