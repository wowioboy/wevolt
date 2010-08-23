<? 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
include $_SERVER['DOCUMENT_ROOT'].'/includes/message_functions.php';

$ReloadMail = 0;
$ErrorMsg = "";
$MsgID = $_POST['msgid'];
$Username = $_POST['username'];

$Subject = $_POST['txtSubject'];
$Message = $_POST['txtMessage'];
$UserID = trim($_SESSION['userid']);

if (isset($_GET['user']))
	$Username = $_GET['user'];

if ($_POST['replymsg'] == 1){
	$DB = new DB();
	$query = "SELECT * FROM messages where ID='$MsgID' LIMIT 1";
	$message = $DB->queryUniqueValue($query);
	$Subject = "re: " .$message->subject;
	$Message = "\r\n-----------------------------\r\n".$message->sendername ." said: \r\n" .stripslashes($message->message)."\r\n------------------------";
	$Username = $message->sendername;
	$DB->close();
}

if ($_POST['forwardmsg'] == 1){
	$DB = new DB();
	$query = "SELECT * FROM messages where ID='$MsgID' LIMIT 1";
	$message = $DB->queryUniqueValue($query);
	$Subject = "re: " .$message->subject;
	$Message = "\r\n-----------------------------\r\n".$message->sendername ." said: \r\n" .stripslashes($message->message)."\r\n------------------------";
	$Username = $message->sendername;
	$DB->close();
}

if ($_POST['sendmsg'] == 1){
    if ($_POST['txtTo'] != "") {
	    if ($_POST['txtMessage'] != "") {
				$DB = new DB();
			$query = "SELECT username,encryptid FROM users where username='".trim($_POST['txtTo'])."'";
			$Recipient = $DB->queryUniqueObject($query);
			$Message = mysql_real_escape_string($_POST['txtMessage']);
			SendMessage($Recipient->encryptid, $_SESSION['username'], $_SESSION['userid'], $_POST['txtSubject'], $Message);
			if ($_POST['txtReply'] == 1) {
				$Time = date('D M j');
				$query = "UPDATE messages set reply=1 where id=$MsgID";
				$DB->execute($query);
				$query = "UPDATE messages set replydate='$Time' where id=$MsgID";
				$DB->execute($query);
			} 
			if ($_POST['txtForward'] == 1) {
								$Time = date('D M j');
								$query = "UPDATE messages set forward=1 where id=$MsgID";
								$DB->execute($query);
								$query = "UPDATE messages set forwarddate='$Time' where id=$MsgID";
								$DB->execute($query);
			} 
			$DB->close();
			$ReloadMail = 1;
		}else {
		 	$ErrorMsg = "You did not enter a message!";
		}
 	} else {
		$ErrorMsg = "You did not fill in a recipient of the message!";
	}

}
if ($UserID == "") {
	header("Location:http://www.wevolt.com/");
	
}
?>

<script type="text/javascript">
<? if ($ReloadMail == 1) {?>
	parent.reload_mail();
	
	<? }?>

	function switch_username(txtTo) {
		document.getElementById('txtTo').value = txtTo;
	}
	
	</script>
     <link type="text/css" rel="stylesheet" href="http://www.wevolt.com/css/pf_css_new.css" />
 <style type="text/css">
body {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:12px;
}

	#not_available {
		display: none;
		color: green;
	}
	#available {
		display: none;
		color: red;
	}
 </style>


  	<form method="post" action="#" >			
<input type="hidden" value="1" id="sendmsg" name="sendmsg" /><input type="hidden" value="<? echo $_POST['replymsg'];?>" id="txtReply" name="txtReply" /><input type="hidden" value="<? echo $_POST['forwardmsg'];?>" id="txtForward" name="txtForward" /><input type="hidden" value="<? echo $MsgID;?>" id="msgid" name="msgid" /><input name="image" type="image" style="border:none;" src="http://www.wevolt.com/images/mail_send.png"/>
<a href="javascript:void(0)" onclick="parent.reload_mail();"><img src="http://www.wevolt.com/images/cancel_btn.png" style="border:none;" width="80"/></a>

   <? if ($ErrorMsg != "") { ?>
<div>
 <? echo $ErrorMsg; ?>
  </div>
    <div class="spacer"></div>

  <? } ?>
  <div class="lgspacer"></div>
  <table width="100%">
  <tr>
    <td class="sender_name" valign="top" width="50">TO: </td>
    <td class="messageinfo">Enter Username of WEvolt User<div class="smspacer"></div>
	<input type="text" name="txtTo" id="txtTo" size="30" value="<? echo $Username; ?>">
		
</td>
  </tr>
  
   <tr>
    <td colspan="2" class="spacer"></td>
  </tr>
 
  <tr>
    <td class="sender_name">SUBJECT: </td>
    <td><input type="text" name="txtSubject" value="<? echo $Subject; ?>" style="width:500px;"/></td>
  </tr>
   <tr>
    <td colspan="2" class="spacer"></td>
  </tr>
  <tr>
    <td valign="top"  class="sender_name">MESSAGE: </td>
    <td  valign="top" ><table border='0' cellspacing='0' cellpadding='0' width='500'><tr><td id="updateBox_TL"></td><td id="updateBox_T"></td><td id="updateBox_TR"></td></tr><tr><td class="updateboxcontent"></td><td valign='top' class="updateboxcontent">
<textarea name="txtMessage" style="width:484px; height:112px; border:none;"><? echo $Message; ?></textarea>
</td><td class="updateboxcontent"></td></tr><tr><td id="updateBox_BL"></td><td id="updateBox_B"></td><td id="updateBox_BR"></td></tr></table></td>
  </tr>
</table>
</form>
	

