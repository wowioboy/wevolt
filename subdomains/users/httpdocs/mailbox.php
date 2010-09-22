<? 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
include $_SERVER['DOCUMENT_ROOT'].'/includes/message_functions.php';
if ($_POST['deletemsg'] == 1){
DeleteMessage(trim($_POST['msgid']));
} 
$DB = new DB();
$mailString = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
<td width="30%" align="left" colspan="2"><img src="http://www.wevolt.com/images/from_image.png"></td>
<td width="40%" align="left"><img src="http://www.wevolt.com/images/subject_image.png"></td>
<td width="20%" align="left"><img src="http://www.wevolt.com/images/sent_image.png"></td>
<td></td></tr>'; 
    
	 $query = "select distinct m.*, u.avatar,u.encryptid
	 		   from messages as m
			   join users as u on u.encryptid=m.senderid
			   where m.userid ='".$_SESSION['userid']."' ORDER by m.msgdate DESC";

	$DB->query($query);

	$nRows = 0;
  	while($mail = $DB->fetchNextObject()) {
		$nRows++;
		if ($mail->isread == 0)
			$ClassName = 'maillink';
		else
			$ClassName = 'maillink_read';
		if ($mail->avatar == '')
			$Avatar = 'http://www.wevolt.com/images/wevolt_avatar.jpg';
		else 
			$Avatar =$mail->avatar;
		$mailString .= '<tr><td width="30">
		<img src="'.$Avatar.'" width="25" vspace="3"></td>
		<td with="30%" class="'.$ClassName.'" >&nbsp;<a href="javascript:void(0)" onclick="parent.window.location=\'http://users.wevolt.com/'.$mail->sendername.'/\';return false;">'.$mail->sendername.'</a>
		</td>
		<td width="40%" class="'.$ClassName.'" ><a href="javascript:void(0)" onclick="read_message(\''.$mail->ID.'\');">'.$mail->subject.'</a>
		</td>
		<td width="20%"  class="'.$ClassName.'" >'.$mail->msgdate.'</td><td width="50" class="'.$ClassName.'"><a href="javascript:void(0)" onclick="delete_msg(\''.$mail->ID.'");return false;"><img src="http://www.wevolt.com/images/mail_msg_delete.png" class="navbuttons" border="0" hspace="5"/></a>'; 
			
			 if ($mail->reply == 1) 
				$mailString .= '<img src="http://www.wevolt.com/images/mail_msg_replied.png" hspace="5">';
		 
			
		  	if ($mail->forward == 1) 
				$mailString .= '<img src="http://www.wevolt.com/images/mail_msg_forwarded.png" hspace="5">';
			  
		$mailString .= '</td>
		</tr>
		<tr><td colspan="4" class="medspacer"></td></tr>';
		
		}
		
		$mailString .= "</table>";
		
		 if ($nRows == 0) {
		 $mailString = "THERE ARE NO MESSAGES IN YOUR INBOX";
		 }
		 $DB->close();
 ?>
 <script type="text/javascript">
 function read_message(value) {
 document.getElementById('messagebox').innerHTML = '<iframe id=\"readerBox\" name=\"readerBox\" src=\"/readmessage.php?id='+value+'\" scrolling=\"auto\" width=\"625\" height=\"300\" frameborder=\"0\"></iframe>';
document.getElementById('messagebox').style.display = ''; 
 }
 function new_message() {
 
 document.getElementById('inboxString').style.display = 'none'; 
 document.getElementById('messagebox').innerHTML = '<iframe id=\"readerBox\" name=\"readerBox\" src=\"/newmessage.php\" scrolling=\"auto\" width=\"625\" height=\"600\" frameborder=\"0\"></iframe>';
document.getElementById('messagebox').style.display = ''; 
 }
 
 function delete_msg(value) {
 	document.getElementById('msgid').value = value;
 	document.msgdeleteform.submit();   
 }
   function reload_mail()
        {
	    document.location='/mailbox.php';
        }	
 </script>
<style type="text/css">

.maillink {
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
color:#7397bb;
font-weight:bold;
padding-top:3px;
}

.maillink a:link{

font-size:12px;
color:#7397bb;
text-decoration:none;
font-weight:bold;
}

.maillink a:hover {

font-size:12px;
color:#7397bb;
font-weight:bold;
}

.maillink a:visited{

font-size:12px;
color:#7397bb;
text-decoration:none;
font-weight:bold;
}

.maillink_read {
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
color:#7397bb;
padding-top:3px;
}

.maillink_read a:link{

font-size:12px;
color:#7397bb;
text-decoration:none;
}

.maillink_read a:hover {

font-size:12px;
color:#7397bb;
}

.maillink_read a:visited{

font-size:12px;
color:#7397bb;
text-decoration:none;
}
.lgspacer{
height:15px;
}
body,html {
	padding:0px;
	margin:0px;
	background:none;	
	
}
</style>


  
<center>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td>
  
<center><a href="javascript:void(0)" onclick="new_message();"><img src="http://www.wevolt.com/images/new_message_btn.png" border="0" /></a>	</center><div class="lgspacer"></div>
<div style="background-color:#FFFFFF; border:#91adc8 2px solid; padding:10px; height:200px; overflow:scroll;" id="inboxString">	
	<?php 
	echo $mailString; 
	?>	
    </div>
    
    <div id="messagebox" style="background-color:#FFFFFF; border:#91adc8 2px solid; padding:10px; display:none;">
  
    </div>
</td>

  </tr>
</table>

</center>

<form method="post" id="msgdeleteform" name="msgdeleteform" action="#" ><input type="hidden" value="1" id="deletemsg" name="deletemsg"/><input type="hidden" name="msgid" id="msgid" value="" /></form>
