<?php 
function Comment($Section, $ComicID, $PageID, $UserID, $Comment,$db_database,$db_host, $db_user, $db_pass){

 
global $CommentUsername,$InitDB;
if ($CommentUsername == '')
	$CommentUsername = $_SESSION['username'];
	
$CommentDate = date('D M j');
$Comment = mysql_real_escape_string($Comment);

$query = "SELECT CreatorEmail, CreatorID, url from comics where comiccrypt='$ComicID'";
$CreatorArray = $InitDB->queryUniqueObject($query);
$Email = $CreatorArray->CreatorEmail;
$UID = $CreatorArray->CreatorID;
$Url = $CreatorArray->url;

$query = "SELECT AllowPublicComents from comic_settings where ComicID='$ComicID'";
$AllowPublicComents  = $InitDB->queryUniqueValue($query); 

$query = "SELECT CommentNotify from panel_panel.users where email='$Email'";
$CommentNotify  = $InitDB->queryUniqueValue($query);

if (($AllowPublicComents == 0) && ($UserID == 'none'))
	$PostComment = 0;
else
	$PostComment = 1;
	
if ($PostComment == 1) {	
		if ($Section == 'Extras') {
		$query = "INSERT into extracomments (comicid, pageid, userid, comment, commentdate, Username) values ('$ComicID', '$PageID','$UserID','$Comment','$CommentDate','$CommentUsername')";
		} else {
		$query = "INSERT into pagecomments (comicid, pageid, userid, comment, commentdate, Username) values ('$ComicID', '$PageID','$UserID','$Comment','$CommentDate','$CommentUsername')";
		}
		$InitDB->execute($query);
		
		
		
		$query = "SELECT * from comic_pages where EncryptPageID='$PageID' and ComicID='$ComicID'";
		$PageArray = $InitDB->queryUniqueObject($query);
		$PagePosition = $PageArray->Position;
		
		$PageLink = '<a href="http://'.$_SERVER['SERVER_NAME'].'/'.$Url.'/page/'.$PagePosition.'/">http://'.$_SERVER['SERVER_NAME'].'/'.$Url.'/page/'.$PagePosition.'/</a>';
		$to = $Email;
		$subject = 'A New Comment has been posted to your comic';
		$body .= "------NEW COMMENT ----\nComment Date: ".$CommentDate."\nPage: ".$PageLink."\n\n".$CommentUsername." said: ".$Comment;
		
		if (($CommentNotify == 'both') || ($CommentNotify == 'email'))
			mail($to, $subject, $body, "From: NO-REPLY@panelflow.com");
		
		$body = mysql_real_escape_string($body);
		$DateNow = date('m-d-Y');
		
		$query = "INSERT into panel_panel.messages (userid, sendername, senderid, subject, message, date) values ('$UID','PanelFlow','0','New Comment posted to your comic','$body','$DateNow')";
		
		if (($CommentNotify == 'both') || ($CommentNotify == 'pfbox'))
			$InitDB->execute($query);
}


} 

function BlogComment($PageID, $ComicID, $UserID, $Comment){
global $CommentUsername,$DB;
$CommentDate = date('D M j');
$Comment = mysql_real_escape_string($Comment);
$query = "INSERT into blogcomments (ComicID, PostID, UserID, comment, commentdate, Username) values ('$ComicID', '$PageID','$UserID','$Comment','$CommentDate','$CommentUsername')";
$DB->execute($query);

}


function CommentProfile($CommentUser, $CommentUserID, $CreatorID, $comment, $time, $IP){
$Site = $_SERVER['SERVER_NAME'];
$querystring ='http://www.panelflow.com/processing/pfusers.php?action=profilecomment&commentuser='. urlencode($CommentUser).'&cuserid='.urlencode($CommentUserID).'&creatorid='.urlencode($CreatorID).'&comment='.urlencode($comment).'&commentdate='.urlencode($time).'&site='.urlencode($Site);
$commentresult = file_get_contents ($querystring);

$insertComment = '0';

}

function getProfileComments ($CreatorID){
$querystring ='http://www.panelflow.com/processing/pfusers.php?action=get&item=profilecomments&creatorid='.urlencode($CreatorID);

$commentsresult = file_get_contents ($querystring);

echo $commentsresult;

}


function getPageComments ($PageID, $ComicID,$UserID){
global $db,$PFDIRECTORY;
	$query = "select bc.*, u.username, u.avatar
	from blogcomments as bc 
	LEFT join users as u on u.encryptid=bc.UserID
	where bc.PostID='$PageID' and bc.comicid='$ComicID'  ORDER BY bc.creationdate ASC";
	
  $db->query($query);
  $nRows = $db->numRows();
  $bgcolor = '#FFFFFF';
$rowcounter = 0; 
 $CommentString = '';
 if ($nRows>0) {
   while ($comment = $db->fetchNextObject()) { 
   if ($Section =='Blog') {
  		$UserID = $comment->UserID;
		$CommentID = $comment->ID;
	} else { 
	$UserID = $comment->userid;
	$CommentID = $comment->id;
	}
	if ($UserID != 'none') {

  $CommentString .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
   <td width='50' rowspan='2' valign='top' class='projectboxcontent'><a href='http://users.wevolt.com/".trim($comment->username)."/'><img src='".$comment->avatar."' width='50' height='50' border='1'></a></td>
    <td height='10' valign='top'style='padding-left:5px;' class='projectboxcontent'><div style='font-size:10px;'>on <i>".$comment->commentdate."</i></div><div style='font-size:10px;'><a href='http://users.wevolt.com/".trim($comment->username)."/'><b>".$comment->username."</b></a> said:</div></td>
  </tr>
  <tr>
    <td valign='top' style='padding:5px;' class='projectboxcontent'>".stripslashes($comment->comment)."</td>
  </tr><tr><td valign='top'>
  
	</td></tr>
</table><div class='spacer'></div>";
}else {

 $CommentString .= "<div class='spacer'></div><table width='100%' border='0' cellspacing='0' cellpadding='0'>".
  "<tr>".
    "<td height='10' valign='top'style='padding-left:5px;' class='projectboxcontent'><a href=\"#\" onclick=\"delete_comment('".$CommentID."');return false;\" /><img src='http://www.wevolt.com/images/delete_btn_blue.jpg' border='0'></a><div style='font-size:10px;'>on <i>".$comment->commentdate."</i></div><div style='font-size:10px;'><b>".stripslashes($comment->Username)."</b> said:</div></td>".
 "</tr>".
  "<tr>".
    "<td valign='top' style='padding:5px;' class='projectboxcontent'>".stripslashes($comment->comment)."</td>".
  "</tr>".
"</table><div class='spacer'></div>";

}

		if ($rowcounter == 0) {
			$bgcolor = '#CCCCCC';
			$rowcounter = 1;
		} else {
			$bgcolor = '#FFFFFF';
			$rowcounter = 0;
		}
  
  	}
	} else {
	$CommentString = "No Comments yet. Be the first to Comment!";
	
	}

return  $CommentString;

}

function getBlogCommentsAdmin ($PageID, $ComicID, $UserID){
global $db,$PFDIRECTORY,$BlogOwner;
	$query = "select bc.*, u.username, u.avatar
	from blogcomments as bc 
	LEFT join users as u on u.encryptid=bc.UserID
	where bc.PostID='$PageID' and bc.comicid='$ComicID'  ORDER BY bc.creationdate ASC";
	
  $db->query($query);
  $nRows = $db->numRows();
  $bgcolor = '#FFFFFF';
$rowcounter = 0; 
 $CommentString = '';
 if ($nRows>0) {
   while ($comment = $db->fetchNextObject()) { 
   if ($Section =='Blog') {
  		$UserID = $comment->UserID;
		$CommentID = $comment->ID;
	} else { 
	$UserID = $comment->userid;
	$CommentID = $comment->id;
	}
	if ($UserID != 'none') {

  $CommentString .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
   <td width='50' rowspan='2' valign='top' class='projectboxcontent'><a href=\"#\" onclick=\"delete_comment('".$CommentID."');return false;\" /><img src='http://www.wevolt.com/images/delete_btn_blue.jpg' border='0'></a><br /><a href='http://users.wevolt.com/".trim($comment->username)."/'><img src='".$comment->avatar."' width='50' height='50' border='1'></a></td>
    <td height='10' valign='top'style='padding-left:5px;' class='projectboxcontent'><div style='font-size:10px;'>on <i>".$comment->commentdate."</i></div><div style='font-size:10px;'><a href='http://users.wevolt.com/".trim($comment->username)."/'><b>".$comment->username."</b></a> said:</div></td>
  </tr>
  <tr>
    <td valign='top' style='padding:5px;' class='projectboxcontent'>".stripslashes($comment->comment)."</td>
  </tr><tr><td valign='top'>
  
	</td></tr>
</table><div class='spacer'></div>";
}else {

 $CommentString .= "<div class='spacer'></div><table width='100%' border='0' cellspacing='0' cellpadding='0'>".
  "<tr>".
    "<td height='10' valign='top'style='padding-left:5px;' class='projectboxcontent'><a href=\"#\" onclick=\"delete_comment('".$CommentID."');return false;\" /><img src='http://www.wevolt.com/images/delete_btn_blue.jpg' border='0'></a><div style='font-size:10px;'>on <i>".$comment->commentdate."</i></div><div style='font-size:10px;'><b>".stripslashes($comment->Username)."</b> said:</div></td>".
 "</tr>".
  "<tr>".
    "<td valign='top' style='padding:5px;' class='projectboxcontent'>".stripslashes($comment->comment)."</td>".
  "</tr>".
"</table><div class='spacer'></div>";

}

		if ($rowcounter == 0) {
			$bgcolor = '#CCCCCC';
			$rowcounter = 1;
		} else {
			$bgcolor = '#FFFFFF';
			$rowcounter = 0;
		}
  
  	}
	} else {
	$CommentString = "No Comments yet. Be the first to Comment!";
	
	}
	 $CommentString .="<form method='POST' action='http://users.wevolt.com/".$BlogOwner."/?t=blog&post=".$PageID."' name='deleteform' id='deleteform'>
	<input type='hidden' name='deletecomment' id='deletecomment' value='1'>
	<input type='hidden' name='commentid' id='commentid' value=''>
	<input type='hidden' name='id' id='id' value='".$PageID."'>
	</form>";

return  $CommentString;

}




function deleteComment($Section, $ComicID, $PageID, $CommentID, $db_database,$db_host, $db_user, $db_pass) {
global $InitDB;
if ($Section == 'Extras') {
$query = "DELETE from extracomments WHERE id ='$CommentID' and comicid='$ComicID' and pageid='$PageID'";
} else if ($Section == 'Blog') {
$query = "DELETE from blogcomments WHERE ID='$CommentID' and ComicID='$ComicID' and PostID='$PageID'";
} else {
$query = "DELETE from pagecomments WHERE id ='$CommentID' and comicid='$ComicID' and pageid='$PageID'";
}
//print $query;
$InitDB->execute($query);
 
}
?>