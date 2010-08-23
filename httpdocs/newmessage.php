<? 
include 'includes/init.php';
include 'includes/dbconfig.php';
include 'includes/message_functions.php';
include 'includes/Sajax2.php';

//print "MY txtReply = " . $_POST['txtReply'];
// Open conection to the database
function check_user_exist($username) {
include 'includes/dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
	$username = mysql_escape_string($username);
	// Make a list of words to postfix on username for suggest
	$suggest = array('007', '1', 'theman', 'rocks');
	//$suggest = array();
	$sql = "SELECT `username` FROM `users` WHERE `username` = '$username'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0) {
		// Username not available
		$avail[0] = 'no';
		$i = 2;
		// Loop through suggested ones checking them
		foreach($suggest AS $postfix) {
			$sql = "SELECT `username` FROM `users` WHERE `username` = '".$username.$postfix."'";
			$result = mysql_query($sql);
			if(mysql_num_rows($result) < 1) {
				$avail[$i] = $username.$postfix;
				$i ++;
			}
		}
		$avail[1] = $i - 1;
		return $avail;
	}
	// Username is available
	return array('yes');
}

sajax_init(); // Intialize Sajax
//$sajax_debug_mode = 1; //Uncomment to put Sajax in debug mode
sajax_export("check_user_exist"); // Register the function
sajax_handle_client_request(); // Serve client instances


$ErrorMsg = "";
$MsgID = $_POST['msgid'];
$Username = $_POST['username'];

$Subject = $_POST['txtSubject'];
$Message = $_POST['txtMessage'];
$UserID = trim($_SESSION['userid']);
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
if (isset($_GET['user'])) {
$Username = $_GET['user'];
$Result = mysql_query ("SELECT encryptid FROM  $usertable where username='$ID'");
$user = mysql_fetch_array($Result);
$ID  = $user['encryptid'];
}
if ($_POST['replymsg'] == 1){
	$Result = mysql_query ("SELECT * FROM messages where ID='$MsgID' LIMIT 1");
	$message = mysql_fetch_array($Result);
	$Subject = "re: " .$message['subject'];
	$Message = "\n\n-----------------------------\n".$message['sendername'] ." said: \n" .stripslashes($message['message'])."\n------------------------";
	$Username = $message['sendername'];
}

if ($_POST['forwardmsg'] == 1){
	$Result = mysql_query ("SELECT * FROM messages where ID='$MsgID' LIMIT 1");
	$message = mysql_fetch_array($Result);
	$Subject = "re: " .$message['subject'];
	$Message = "\n\n-----------------------------\n".$message['sendername'] ." said: \n" .stripslashes($message['message'])."\n------------------------";
	$Username = $message['sendername'];
}

if ($_POST['sendmsg'] == 1){
    if ($_POST['txtTo'] != "") {
	    if ($_POST['txtMessage'] != "") {
		$Result = mysql_query ("SELECT username, encryptid FROM $usertable");
		$nRows = mysql_num_rows($Result);
		for ($i=0; $i< $nRows; $i++){
			$row = mysql_fetch_array($Result);
				if ($row['username'] == $_POST['txtTo']) {
		 			$RegResult = 'User Exists';
					$Message = mysql_real_escape_string($_POST['txtMessage']);
	    			SendMessage($row['encryptid'], $_SESSION['username'], $_SESSION['userid'], $_POST['txtSubject'], $Message);
					   if ($_POST['txtReply'] == 1) {
					   		$Time = date('D M j');
							$query = "UPDATE messages set reply=1 where id=$MsgID";
							$Result = mysql_query ($query);
							$query = "UPDATE messages set replydate='$Time' where id=$MsgID";
							$Result = mysql_query ($query);
   						} 
						if ($_POST['txtForward'] == 1) {
					   		$Time = date('D M j');
							$query = "UPDATE messages set forward=1 where id=$MsgID";
							$Result = mysql_query ($query);
							$query = "UPDATE messages set forwarddate='$Time' where id=$MsgID";
							$Result = mysql_query ($query);
   						} 
						header("Location:/mailbox.php");
				} else {
					$ErrorMsg = 'That User was not found in our system. Please make sure you have the username EXACTLY as the user has it spelled.';
				}
		} // End For
		}else {
		 	$ErrorMsg = "You did not enter a message!";
		}
 	} else {
		$ErrorMsg = "You did not fill in a recipient of the message!";
	}
} 

if ($UserID == "") {
	header("Location:/index.php");
}
?>

<script type="text/javascript">
	<?php
	sajax_show_javascript();
	?>
	function check_handle(result) {
		if(result[0] == 'yes') {
			document.getElementById('not_available').style.display = 'none';
			document.getElementById('available').style.display = 'block';
		}
		else {
			document.getElementById('available').style.display = 'none';
			document.getElementById('not_available').style.display = 'block';
		}
	}

	function check_user_exist() {
		var txtTo = document.getElementById('txtTo').value;
		x_check_user_exist(txtTo, check_handle);
	}

	function switch_username(txtTo) {
		document.getElementById('txtTo').value = txtTo;
	}
	
	</script>

	<style type="text/css">
        @import url( test.css );
	#not_available {
		display: none;
		color: green;
	}
	#available {
		display: none;
		color: red;
	}
	</style>





     <div class='contentwrapper'>
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr><td style="padding-left:25px;">
  	<form method="post" action="/newmessage.php" >			
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="21%" ><input type="hidden" value="1" id="sendmsg" name="sendmsg" /><input type="hidden" value="<? echo $_POST['replymsg'];?>" id="txtReply" name="txtReply" /><input type="hidden" value="<? echo $_POST['forwardmsg'];?>" id="txtForward" name="txtForward" /><input type="hidden" value="<? echo $MsgID;?>" id="msgid" name="msgid" /><input name="image" type="image" style="border:none;" src="/images/send_msg.gif"/></td>
    <td width="68%" ><a href="/mailbox.php"><img src="/images/cancel_btn.gif" style="border:none;"/></a></td>
    <td width="5%" ></td>
    <td width="6%"></td>
    </tr>
</table>   </td>
  </tr>
     <tr>
    <td colspan="2" class="lgspacer">    </td>
  </tr>
   <? if ($ErrorMsg != "") { ?>
    <tr>
    <td colspan="2" ><? echo $ErrorMsg; ?></td>
  </tr>
    <tr>
    <td colspan="2" class="lgspacer">    </td>
  </tr>
  <? } ?>
  <tr>
    <td class="inputheader"><strong>TO</strong> : </td>
    <td width="414" class="inputheader">
	<input type="text" name="txtTo" id="txtTo" size="20" value="<? echo $Username; ?>">
	<input type="button" name="check" value="Check Username"
		onclick="check_user_exist(); return false;">

	<div id="available">
		User not Found. Please try again.
	</div>

	<div id="not_available">
		That user has been found.
	</div>
	
	<br />
Enter Username of Panel Flow User</td>
  </tr>
   <tr>
    <td colspan="2" class="lgspacer"></td>
  </tr>
 
  <tr>
    <td><strong>SUBJECT</strong>: </td>
    <td><input type="text" name="txtSubject" value="<? echo $Subject; ?>" style="width:300px;"/></td>
  </tr>
   <tr>
    <td colspan="2" class="lgspacer"></td>
  </tr>
  <tr>
    <td width="66" valign="top"><strong>MESSAGE</strong>: </td>
    <td  valign="top" ><textarea name="txtMessage" style="width:500px; height:150px;"><? echo $Message; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" class="lgspacer"></td>
  </tr>
</table>
</form>
	
  
</td>

  </tr>
</table>
  </div>
 

