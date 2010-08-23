<? 
include 'includes/init.php';
include 'includes/dbconfig.php';
include 'includes/message_functions.php';

$ID = trim($_SESSION['userid']);
if ($ID == "") {
header("Location:/index.php");
}

mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');

if ($_POST['deletemsg'] == 1){
DeleteMessage(trim($_POST['msgid']));
} 

$mailString = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td width='30%' align='left'><img src='/images/from_image.png'></td><td width='40%' align='left'><img src='/images/subject_image.png'></td><td width='20%' align='left'><img src='/images/sent_image.png'></td><td></td><td></td></tr>"; 
    
	 $query = "select * from messages where userid ='$ID' ORDER by msgdate DESC";
	 //print $query;
  	 $result = mysql_query($query);
  	 $nRows = mysql_num_rows($result);
	 	for ($i=0; $i< $nRows; $i++){
   		$mail = mysql_fetch_array($result);
		if ($mail['isread'] == 0)
			$ClassName = 'maillink';
		else
			$ClassName = 'maillink_read';
		$mailString .= "<tr><td with='30%' class='".$ClassName."' valign='top'><a href='/profile/".$mail['sendername']."/'>".$mail['sendername']."</a></td><td width='40%' class='".$ClassName."' valign='top'><a href='/readmessage.php?id=".$mail['ID']."'>".$mail['subject']."</a></td><td width='20%'  class='".$ClassName."' valign='top'>".$mail['date']."</td><td width='5%' valign='top'>"; 
		if ($mail['isread'] == 0) {
			$mailString .= "<img src='images/new_mail.png'>";
		} else {
			if (($mail['forward'] == 1) && ($mail['reply'] == 1)) {
				$mailString .= "<img src='images/both_mail.gif'>";
			} else if ($mail['forward'] == 1) {
				$mailString .= "<img src='images/forward_mail.gif'>";
			}  else if ($mail['reply'] == 1) {
				$mailString .= "<img src='images/reply_mail.gif'>";
			} else {
				$mailString .= "<img src='images/open_mail.png'>";
			} 
		}
		$mailString .= "</td><td width='3%'><form method='post' action='mailbox.php' ><input type='hidden' value='1' id='deletemsg' name='deletemsg' /><input type='hidden' name='msgid' value='".$mail['ID']."' /><input name='image' type='image' style='border:none;' src='images/x_btn.gif'/></form></td></tr><tr><td colspan='5' class='medspacer'></td>";
		
		}
		
		$mailString .= "</table>";
		
		 if ($nRows == 0) {
		 $mailString = "THERE ARE NO MESSAGES IN YOUR INBOX";
		 }
 ?>
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
</style>


  
<center>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td>
  
<center><a href="/newmessage.php"><img src="/images/new_message_btn.png" border="0" /></a>	</center><div class="lgspacer"></div>
<div style="background-color:#FFFFFF; border:#91adc8 2px solid; padding:10px;">	
	<?php 
	echo $mailString; 
	?>	
    </div>
</td>

  </tr>
</table>

</center>
