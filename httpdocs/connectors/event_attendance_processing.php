<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php');
$CalID = $_GET['id'];
$Status = $_GET['status'];
$query = "SELECT Status from pf_events_invitations where UserID='".$_SESSION['userid']."' and CalID='$CalID'";
$CurrentStatus = $InitDB->queryUniqueValue($query);
$query = "UPDATE  pf_events_invitations set Status='$Status' where UserID='".$_SESSION['userid']."' and CalID='$CalID'";
$InitDB->execute($query);

$query = "SELECT u.username, u.email,u.encryptid 
		  from calendar as c
          join users as u on u.encryptid=c.user_id 
		  where c.id ='$CalID'"; 
$UserArray = $InitDB->queryUniqueObject($query);
$Email = $UserArray->email;
$user = $UserArray->encryptid;
$Username = $UserArray->username;
$header = "From: NO-REPLY@wevolt.com  <NO-REPLY@wevolt.com >\n";
$header .= "Reply-To: NO-REPLY@wevolt.com <NO-REPLY@wevolt.com>\n";
$header .= "X-Mailer: PHP/" . phpversion() . "\n";
$header .= "X-Priority: 1";
	
//SEND USER EMAIL
$PageLink = 'http://www.wevolt.com/view_event.php?id='.$CalID.'&action=view';
$to = $Email;
if ($CurrentStatus == 'invited') {
	$subject = $_SESSION['username'].' has responded to your event invitation';
	$wesubject = $_SESSION['username'].' has responded to your event invitation';
	$body .= $_SESSION['username']." has responded to your event invitation\n\nClick here to view the event: ".$PageLink; 
	$WemailBody = $_SESSION['username']." has responded to your event invitation\n\nClick here to view the event:\n\n<a href=\"#\" onclick=\"parent.window.location.href='".$PageLink."';\">".$PageLink."</a>"; 
} else {
		$subject = $_SESSION['username'].' has changed their attendance status to your event ';
	$wesubject = $_SESSION['username'].' has changed their attendance status to your event';
	$body .= $_SESSION['username']." has changed their attendance status to your event\n\nClick here to view the event: ".$PageLink; 
	$WemailBody = $_SESSION['username']." has changed their attendance status to your event\n\nClick here to view the event:\n\n<a href=\"#\" onclick=\"parent.window.location.href='".$PageLink."';\">".$PageLink."</a>"; 


}
mail($to, $subject, $body, $header);
$body = mysql_real_escape_string($WemailBody);
$DateNow = date('m-d-Y');
$query = "INSERT into panel_panel.messages 
		(userid, sendername, senderid, subject, message, date) 
			values 
		('$user','".$_SESSION['username']."','".$_SESSION['userid']."','$wesubject','".mysql_real_escape_string($WemailBody)."','$DateNow')";
$InitDB->execute($query);	
?>
