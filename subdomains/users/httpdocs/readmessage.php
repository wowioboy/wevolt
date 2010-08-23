<? 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
include $_SERVER['DOCUMENT_ROOT'].'/includes/message_functions.php';


$MailID = $_GET['id'];
$UserID = trim($_SESSION['userid']);

if ($_POST['deletemsg'] == 1){
DeleteMessage(trim($_POST['msgid']));
?>
<script type="text/javascript">
parent.window.document.location='/myvolt/<? echo $_SESSION['username'];?>/?t=mailbox';

</script>

<?
} 
$DB = new DB();
$query = "UPDATE messages set isread=1 where id=$MailID";
$DB->execute($query);

$query = "select * from messages where ID='$MailID'";
$DB->query($query);
$mail = array();
while ($line = $DB->fetchNextObject()) {
		$mail['ID'] = $line->ID;
		$mail['sendername'] = $line->sendername;
		$mail['message'] = $line->message;
		$mail['subject'] = $line->subject;	
		$SenderID = $line->senderid;	
		$mail['userid'] = $line->userid;	
}

$query = "select avatar from users where encryptid='$SenderID'";
$Avatar = $DB->queryUniqueValue($query);
$Auth = 1;	
if ($mail['userid'] != $_SESSION['userid']) 
	$Auth = 0;
$DB->close();

if ($Auth==0) {?>

<script type="text/javascript">
parent.window.document.location='/myvolt/<? echo $_SESSION['username'];?>/?t=mailbox';

</script>

<? }?>

 <style type="text/css">
body {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:12px;
}
 .sender_name {
 	font-size:12px;
	color:#235c90;
	font-weight:bold;
 }
 .messageinfo {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:12px;
 }
 
 .smspacer {
 	height:5px;
	
 }
 .lgspacer {
  height:15px;
 }
 .spacer {
 	height:10px;
 }
 #updateBox_T {
background-color:#e9eef4;
height:8px;
}

.updateboxcontent {
	color:#000000;
	background-color:#e9eef4;
}

#updateBox_B {
background-color:#e9eef4;
height:8px;
 
}


#updateBox_TL{
	width:8px;
	height:8px; 
	background-image:url(http://www.wevolt.com/images/update_wrapper_TL.png);
	background-repeat:no-repeat;
}

#updateBox_TR{
	width:8px;
	height:8px; 
	background-image:url(http://www.wevolt.com/images/update_wrapper_TR.png);
	background-repeat:no-repeat;
}

#updateBox_BR{
	width:8px;
	height:8px; 
	background-image:url(http://www.wevolt.com/images/update_wrapper_BR.png);
	background-repeat:no-repeat;
}
#updateBox_BL{
	width:8px;
	height:8px; 
	background-image:url(http://www.wevolt.com/images/update_wrapper_BL.png);
	background-repeat:no-repeat;
}
 </style>
<div class="contentwrapper">

    <center>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:5px;"><form method="post" action="#" ><input type="hidden" value="1" id="deletemsg" name="deletemsg" /><input type="hidden" name="msgid" value="<? echo $mail['ID']; ?>" /><input name="image" type="image" style="border:none;" src="http://www.wevolt.com/images/mail_delete.png" value="DELETE"/></form></td>
    <td style="padding:5px;"><form method="post" action="/newmessage.php" ><input type="hidden" value="1" id="replymsg" name="replymsg" /><input type="hidden" name="msgid" value="<? echo $mail['ID']; ?>" /><input name="image" type="image" style="border:none;" src="http://www.wevolt.com/images/mail_reply.png" value="REPLY"/></form></td>
    <td style="padding:5px;"><form method="post" action="/newmessage.php" ><input type="hidden" value="1" id="forwardmsg" name="forwardmsg" /><input type="hidden" name="msgid" value="<? echo $mail['ID']; ?>" /><input name="image" type="image" style="border:none;" src="http://www.wevolt.com/images/mail_forward.png" value="FORWARD"/></form></td>
      </tr>
</table>   
</center>
<div class="lgspacer"></div>

<table width="550" border="0" cellspacing="0" cellpadding="0">
    
  <tr>
    <td align="center" valign="top"><? if ($SenderID != 0) {?><a href="http://users.wevolt.com/<? echo trim($mail['sendername']);?>/"><? }?><img src='<? echo $Avatar; ?>' vspace='3' hspace="5" border="0" width="50"><? if ($SenderID != 0) {?></a><? }?><br /></td>
    <td width="530" valign="top">
    <div class="sender_name"><? echo $mail['sendername']; ?></div>
     <div class="spacer"></div>
      <div class="messageinfo">
      
<? echo $mail['subject'] ?>

<table border='0' cellspacing='0' cellpadding='0' width='500'><tr><td id="updateBox_TL"></td><td id="updateBox_T"></td><td id="updateBox_TR"></td></tr><tr><td class="updateboxcontent"></td><td valign='top' class="updateboxcontent">
<div class="messageinfo">
<? echo nl2br(stripslashes($mail['message'])); ?>
</div>
</td><td class="updateboxcontent"></td></tr><tr><td id="updateBox_BL"></td><td id="updateBox_B"></td><td id="updateBox_BR"></td></tr></table>

</div>
</td>

  </tr>

</table>
	</div>




