<?

function verify_email($email){

    if(!preg_match('/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/',$email)){
        return false;
    } else {
        return $email;
    }
}


function SendUserDetails($Email, $Username, $Password, $Url) {

//Send Account Email
	$to = $Email;
	$subject = "YOUR OUTLAND CMS USER DETAILS";
	$body = "You now have an Outland CMS User Account at http://".$Url."/admin.php\n\nBelow are your login details\n\nUsername: ".$Username."\nPassword: ".$Password;
    if (mail($to, $subject, $body, "From: NO-REPLY@".$Url)) {
		//mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}

function SendProjectsUserDetails($Email, $Username, $Url) {

//Send Account Email
	$to = $Email;
	$subject = "YOUR OUTLAND CMS PROJECTS ACCOUNT DETAILS";
	$body = "You now have an Outland CMS Projects Account at http://".$Url."/projects.php\n\nUse the same login credentials as your standard Outland CMS account, using the following username.\n\nUsername: ".$Username;
    if (mail($to, $subject, $body, "From: NO-REPLY@".$Url)) {
		//mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}


function SendUserTaskAssignmentNotification($Name, $Email, $TaskID) {

//Send Account Email
	$to = $Email;
	$subject = "You have a new Task Assigned to you";
	$body = $Name.", you have a new task assigned to you. Please login to : http://".$_SERVER['SERVER_NAME']."/projects.php to view the task.";
    if (mail($to, $subject, $body, "From: PROJECTS@".$_SERVER['SERVER_NAME'])) {
		//mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}

function SendLeaderTaskAssignmentNotification($Name, $Email, $TaskID) {

//Send Account Email
	$to = $Email;
	$subject = "A New Task Has Been Created for a Project you manage";
	$body = $Name.", you have a new task assigned to a project you manage. Please login to : http://".$_SERVER['SERVER_NAME']."/projects.php to view the task.";
    if (mail($to, $subject, $body, "From: PROJECTS@".$_SERVER['SERVER_NAME'])) {
		//mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}


function SendLeaderProjectAssignmentNotification($Name, $Email, $TaskID) {

//Send Account Email
	$to = $Email;
	$subject = "A New Project has been Assigned to you";
	$body = $Name.", you have been assigned the Project Leader of a new project. Please login to : http://".$_SERVER['SERVER_NAME']."/projects.php to view the project.";
    if (mail($to, $subject, $body, "From: PROJECTS@".$_SERVER['SERVER_NAME'])) {
		//mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}

function SendClientEmail($ItemID, $ItemTitle, $SenderName, $SenderEmail, $Phone, $Message) {

//Send Account Email
	//$to = 'info@linea-inc.com';
	$copy = 'matt@outlandentertainment.com';
	$subject = "WEBSITE ITEM REQUEST - ". $ItemTitle;
	$body = "A customer has requested information on this item : http://linea.outlandwebworks.com/viewitem.php?id=".$ItemID."\n\nTheir information from the contact form is below\n\nCustomer Name: ".$SenderName."\nCustomer Email: ".$SenderEmail;
	if ($Phone != 0) {
		$body .= "\nCustomer Phone: ".$Phone;
	}
	$body .= "\n\nMessage:\n".$Message;
    if (mail($copy, $subject, $body, "From: ".$SenderEmail)) {
		//mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}

function SendLeaderEmail($ItemID, $ItemTitle, $SenderName, $SenderEmail, $Phone, $Message) {

//Send Account Email
	//$to = 'info@linea-inc.com';
	$copy = 'matt@outlandentertainment.com';
	$subject = "WEBSITE ITEM REQUEST - ". $ItemTitle;
	$body = "A customer has requested information on this item : http://linea.outlandwebworks.com/viewitem.php?id=".$ItemID."\n\nTheir information from the contact form is below\n\nCustomer Name: ".$SenderName."\nCustomer Email: ".$SenderEmail;
	if ($Phone != 0) {
		$body .= "\nCustomer Phone: ".$Phone;
	}
	$body .= "\n\nMessage:\n".$Message;
    if (mail($copy, $subject, $body, "From: ".$SenderEmail)) {
		//mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}

function SendContactEmail($SenderName, $SenderEmail, $MsgSubject, $Phone, $Message) {

//Send Account Email
	//$to = 'info@linea-inc.com';
	$copy = 'matt@outlandentertainment.com';
	$subject = $MsgSubject;
	$body = $Message;
	$body .= "\n\nCONTACT INFORMATION\n";
	$body .= "\nName: ".$SenderName."\nEmail: ".$SenderEmail;
	if ($Phone != 0) {
		$body .= "\nCustomer Phone: ".$Phone;
	}
    if (mail($copy, $subject, $body, "From: ".$SenderEmail)) {
		//mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}

function SendInfoEmail($SenderName, $SenderEmail, $Company, $Address,$Address2,$City,$State,$Zip, $Phone,$Altphone,$Inquiry,$Position, $Project_location,$Interests,$Designers,$Suppliers,$Other,$Add_to_mailinglist) {

//Send Account Email
	//$to = 'info@linea-inc.com';
	$copy = 'matt@outlandentertainment.com';
	$subject = 'Requesting Information From the Website';
	$body = 'A Customer has requested information from the website, their information is below:';
	$body .= "\n\nCONTACT INFORMATION\n";
	$body .= "\nName: ".$SenderName."\nEmail: ".$SenderEmail;
	if ($Phone != 0) {
		$body .= "\nCustomer Phone: ".$Phone;
	}
	$body .= "\n\nFORM INFORMATION";
	$body .= "\nCOMPANY: ".$Company;
	$body .= "\nPOSITION: ".$Position;
	$body .= "\nADDRESS: ".$Address;
	$body .= "\nADDRESS 2: ".$Address2;
	$body .= "\nCITY: ".$City;
	$body .= "\nSTATE: ".$State;
	$body .= "\nZIP: ".$Zip;
	$body .= "\nPROJECT LOCATION: ".$Project_location;
	$body .= "\nPHONE: ".$Phone;
	$body .= "\nALT PHONE: ".$Altphone;
	$body .= "\nINTERESTS: ".$Interests;
	$body .= "\nDESIGNERS: ".$Designers;
	$body .= "\nMANUFACTURERS: ".$Suppliers;
	$body .= "\nOTES: ".$Notes;
	$body .= "\nMAILING LIST: ".$Add_to_mailinglist;
    if (mail($copy, $subject, $body, "From: ".$SenderEmail)) {
		//mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}


function SendFriendEmail($SenderEmail, $SenderName, $Friend, $Message)
 {

//Send Account Email
	$to = $Friend;
	$copy = 'matt@outlandentertainment.com';
	$subject = 'Check out this item on Linea - Inc';
	$body = $Message;
	$body .= "\n\nFROM:\n";
	$body .= "\nName: ".$SenderName."\nEmail: ".$SenderEmail;
	if (mail($to, $subject, $body, "From: ".$SenderEmail)) {
		mail($copy, $subject, $body, "From: ".$SenderEmail);
		
		$msg ='sent';
	
  
 	} else {
			$msg ='error';
 	}
return $msg;
}



?>
