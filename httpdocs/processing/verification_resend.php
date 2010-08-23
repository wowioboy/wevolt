<?php 
include '../includes/db.class.php';
$DB = new DB();
 $query = "SELECT * from users where verified=0";
$DB->query($query);
while ($Comic = $DB->FetchNextObject()) {
	$Email = $Comic->email;
	$EncryptID = $Comic->encryptid;
	$UserName = $Comic->username;
	$authcode = $Comic->authcode;
	$to = $Email;
	$subject = "RE-SEND: PANEL FLOW Account Verification";
	$body = "Hi, ".$UserName.", it appears you still have not verified your Panel Flow account. please click the following link to complete your account verification.\n\nAfter your account is verified you can leave comments on comics and create your own.\n\nVERIFICATION LINK : http://www.panelflow.com/verifyaccount.php?id=".$EncryptID."&authcode=".trim($authcode)."\n\nIf clicking on the link does not work, copy the link and paste it into your browser. \n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
    mail($to, $subject, $body, "From: NO-REPLY@panelflow.com");
	
	
	print 'EMAILED to ='.$Email.'<br/>';
	print $UserName.'<br/>';
	}
	
	
	/*
	$query ="SELECT count(*) from pf_modules where ModuleCode='menutwo' and ComicID='$ComicID' and Homepage='0'";
	$Found = $DB2->queryUniqueValue($query);
	if ($Found == 0) {
	$query = "INSERT INTO pf_modules (Title, ModuleCode, ComicID, Position, Placement, IsPublished) VALUES ('Menu Two', 'menutwo', '$ComicID', 14, 'left',0)";
		$DB2->execute($query);
		print $query.'<br/>';
	}
	$query ="SELECT count(*) from panel_need.pf_modules where ModuleCode='menuone' and ComicID='$ComicID' and Homepage='0'";
	$Found = $DB2->queryUniqueValue($query);
	if ($Found == 0) {
		$query = "INSERT INTO panel_need.pf_modules (Title, ModuleCode, ComicID, Position, Placement, IsPublished) VALUES ('Menu Two', 'menutwo', '$ComicID', 14, 'left',0)";
		$DB2->execute($query);
		print $query.'<br/>';
	}
*/

//Send Verification Email
	

$DB->close();

?>


