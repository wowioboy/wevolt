<?
function SendFavoriteEmail($Title, $Url, $Email) {
//Send Account Email
	$to = $Email;
	$subject = "The Comic ". $Title. " has been updated!";
	$body = "This email is to let you know that one of your favorited comics on Panel Flow has been updated.\n\nREAD IT NOW: ".$Url." \n\nTo turn off this notification, go to your Favorites on your profile and click 'Don't Notify'. \n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: NO-REPLY@panelflow.com")) {
		
 	} else {
  
 	}

}


function SendApplicationEmail($Username, $Email, $License) {
//Send Account Email
	$to = $Email;
	$output = '------';
	$subject = "Your Panel Flow License Key";
	$output .= $subject;
	
	$body = "Hi, ".$Username."\n\nThanks for your subscription to Panel Flow Pro. Below is your License Key that you will need to use when installing the application. Do not give your code out to anyone \n\nPanel Flow License Key: ".$License." \n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
   $output .= $body;
    if (mail($to, $subject, $body, "From: info@panelflow.com")) {
	$output .= 'EMAIL SENT';
 } else {
  	$output = 'EMAIL NOT SENT '; 
 }
return $output;
}

function SendAdminApplicationEmail($Username, $Email, $License) {
//Send Account Email
$EmailAdmin ='info@panelflow.com';
	$to = $EmailAdmin;
	$subject = "A User has purchased Panel Flow.";
	$body = "Hi, ".$Username."\n\nat email: ". $Email." has purchased and downloaded an application.";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: info@panelflow.com")) {
	
 } else {
  
 }

}

function SendLicenseEmail($Username, $Email, $License) {
//Send Account Email
	$to = $Email;
	$subject = "Your Panel Flow License Purchase";
	$body = "Hi, ".$Username."\n\nYour License upgrade is complete, you can now run Panel Flow on ".$License." Domains. \n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: info@panelflow.com")) {
	
 } else {
  
 }

}

function SendAdminLicenseEmail($Username, $Email, $License) {
//Send Account Email
$EmailAdmin ='info@panelflow.com';
	$to = $EmailAdmin;
	$subject = "A User upgraded their License.";
	$body = "Hi, ".$Username." at email: ". $Email." has purchased Domain licenses and can run the application on ".$License." domains";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: info@panelflow.com")) {
	
 } else {
  
 }

}


function SendAdminHostedEmail($Username, $Email, $Quanity) {
//Send Account Email
$EmailAdmin ='info@panelflow.com';
	$to = $EmailAdmin;
	$subject = "A User has purchased Comics Hosting.";
	$body = "Hi, ".$Username."\n\nat email: ". $Email." has purchased comics hosting - ";
	if ($Quanity == 1) {
	$body .='With Ads';
	} else if ($Quanity == 2){
	$body .='Without Ads';
	}
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: info@panelflow.com")) {
	
 } else {
  
 }

}

function SendHostedEmail($Username, $Email, $Quanity) {
//Send Account Email
	$to = $Email;
	$subject = "Your Panel Flow Hosted Comics Account";
	$body = "Hi, ".$Username."\n\nThanks for your purchase of a Hosted Comics Account. You now has access to the Panel Flow software and you can start creating comics now. Just log into your profile on Needcomics.com or Panelflow.com to start.\n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: info@panelflow.com")) {
	
 } else {
  
 }

}


function SendAdminDomainEmail($Username, $Email, $Domain) {
//Send Account Email
$EmailAdmin ='info@panelflow.com';
	$to = $EmailAdmin;
	$subject = "A User has purchased Domain Hosting.";
	$body = "Hi, ".$Username."\n\nat email: ". $Email." has purchased domain hosting - for the domain : ".$Domain;
		$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: info@panelflow.com")) {
	
 } else {
  
 }

}

function SendDomainEmail($Username, $Email,$Domain, $Discount) {
//Send Account Email
	$to = $Email;
	$subject = "Your Panel Flow Hosting Account";
	$body = "Hi, ".$Username."\n\nThanks for your purchase of a Hosting account with Panel Flow for the domain : ".$Domain.". Your hosting account will be activated on our servers within a few hours. After it is active you will recieve an email with instructions on how to point your domain namerservers to our server, and how to access the domain control panel. You will be able to set up email, ftp and subdomains as well. \n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: info@panelflow.com")) {
	
 } else {
  
 }

}

?>