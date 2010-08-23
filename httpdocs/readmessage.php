<? 
include 'includes/init.php';
include 'includes/dbconfig.php';
include 'includes/message_functions.php';

$MailID = $_GET['id'];
$UserID = trim($_SESSION['userid']);

if ($_POST['deletemsg'] == 1){
DeleteMessage(trim($_POST['msgid']));
header("Location:/mailbox.php");
} 

include 'includes/dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');

$query = "UPDATE messages set isread=1 where id=$MailID";
//print $query;
$result = mysql_query($query);

$query = "select * from messages where ID='$MailID' LIMIT 1";
$result = mysql_query($query);
$mail = mysql_fetch_array($result);
$SenderID = $mail['senderid'];
$query = "select avatar from users where encryptid='$SenderID' LIMIT 1";
$result = mysql_query($query);
$user = mysql_fetch_array($result);

if ($SenderID != 0)
$Avatar = $user['avatar'];
else 
$Avatar ='http://www.panelflow.com/images/pf_avatar.jpg';

	
if ($mail['userid'] != $_SESSION['userid']) {
	header("Location:/index.php");
}



 ?>
 
<div class="contentwrapper">
	<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr><td>
  
 	<div class="pageheader">READ MESSAGE</div><div class="spacer"></div>
    
    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" align="left">
    
    
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><form method="post" action="mailbox.php" ><input type="hidden" value="1" id="deletemsg" name="deletemsg" /><input type="hidden" name="msgid" value="<? echo $mail['ID']; ?>" /><input name="image" type="image" style="border:none;" src="images/delete_btn.jpg"/></form></td>
    <td ><form method="post" action="newmessage.php" ><input type="hidden" value="1" id="replymsg" name="replymsg" /><input type="hidden" name="msgid" value="<? echo $mail['ID']; ?>" /><input name="image" type="image" style="border:none;" src="images/reply_btn.jpg"/></form></td>
    <td ><form method="post" action="newmessage.php" ><input type="hidden" value="1" id="forwardmsg" name="forwardmsg" /><input type="hidden" name="msgid" value="<? echo $mail['ID']; ?>" /><input name="image" type="image" style="border:none;" src="images/forward_btn.jpg"/></form></td>
    <td valign="top"><a href="mailbox.php"><img src="images/inbox_btn.jpg" style="border:none;"/></a></td>
    </tr>
</table>   

</td>
  </tr>
     <tr>
    <td colspan="2" class="lgspacer">    </td>
  </tr>
  <tr>
    <td class="inputheader" align="center" valign="top"><? if ($SenderID != 0) {?><a href="/profile/<? echo trim($mail['sendername']);?>/"><? }?><img src="<? echo $Avatar; ?>" border='2'  style="border-color:#000000"/><? if ($SenderID != 0) {?></a><? }?><br />     </td>
    <td width="416" valign="top"><strong>FROM: </strong> <? echo $mail['sendername']; ?>
      <div class="smspacer"></div>
<strong>SUBJECT</strong>: <? echo $mail['subject'] ?><div class="smspacer"></div>
   <strong>DATE</strong> : 
<? echo $mail['date'] ?><div class="smspacer"></div><strong>MESSAGE</strong>:<br /><div style="background-color:#e5e5e5;padding:5px;">
<? echo nl2br(stripslashes($mail['message'])); ?></div></td>
  </tr>
   <tr>
    <td></td>
    <td></td>
   </tr>
  <tr>
    <td width="64" rowspan="2" valign="top"> </td>
    <td  valign="top"></td>
  </tr>
  <tr>
    <td  valign="top"></td>
  </tr>
  <tr>
    <td colspan="2" class="lgspacer"></td>
  </tr>
</table>


</td>
</tr>
</table>  
    

</td>

  </tr>
</table>
	</div>




