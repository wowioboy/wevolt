<?php
include 'includes/init.php';
$RID = $_GET['fid'];
$UserID = $_SESSION['userid'];
if ($UserID == '')
	$Message = 'Sorry you must first log in to accept this request.';
$DB = new DB();
$TrackPage = 0;
$CreateDate = date('Y-m-d h:i:s');

if(($_GET['fid'] != '') && ($_POST['submit'] != 1)) {
	$query = "SELECT f.*,u.avatar, u.username, u.email 
	          from friends as f
			  join users as u on f.UserID=u.encryptid
			  where f.RID='$RID'";
	  
	$FriendArray = $DB->queryUniqueObject($query);

	if ($FriendArray->ID == '')
		$Message = 'Sorry we could not find that friend request';
} else if (($_POST['fid'] != '') && ($_POST['submit'] == 1)) {

	$query = "SELECT f.*,u.avatar, u.username, u.email 
	          from friends as f
			  join users as u on f.UserID=u.encryptid
			  where f.RID='".$_POST['fid']."'";
	$FriendArray = $DB->queryUniqueObject($query);
	$FriendID = $FriendArray->UserID;
	//print $query;
	if ($_POST['TypeAnswer'] == 'friend'){
		
		$query = "UPDATE friends set Accepted=1, RID='' where RID='".$_POST['fid']."'";
		$DB->execute($query);
		//print $query;
		$query = "UPDATE friends set Accepted=1, FriendType='friend', AcceptedDate='$CreateDate' where UserID='$UserID' and FriendID='$FriendID'";
		$DB->execute($query);
		//print $query;
		$Message = 'You have accepted this request.';
		$header = "From: noreply@wevolt.com  <noreply@wevolt.com >\n";
		$header .= "Reply-To: noreply@wevolt.com <noreply@wevolt.com>\n";
	    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
	    $header .= "X-Priority: 1";
		$to = $FriendArray->email;
		
		$subject = $_SESSION['username'].' has accepted your friend request';
		
		$body = "Hi, ".$FriendArray->username.", ".$_SESSION['username']." has accepted your friend request on WEvolt.";
   		mail($to, $subject, $body, $header);
		$query = "SELECT count(*) from notify_settings_users where UserID='$UserID' and FriendID='$FriendID'" ;
		$Found = $DB->queryUniqueValue($query);
		//print $query.'<br/>';
		if ($Found == 0) {
			$query = "INSERT into notify_settings_users (UserID, FriendID, NotifyList) values ('$UserID', '$FriendID', '$UpdateString')";
			$DB->execute($query);
			//print $query.'<br/>';
				
		} 
		
	} else if ($_POST['TypeAnswer'] == 'fan and follow') {
		
		$query = "INSERT into follows (user_id, follow_id, type) values ('".$_SESSION['userid']."','".$FriendID."','user')"; 
		$DB->execute($query);
		$query = "INSERT into follows (user_id, follow_id, type) values ('".$FriendID."','".$_SESSION['userid']."','user')"; 
		$DB->execute($query);
		
		$Message = 'You are now following '.$FriendArray->username;
	} else if ($_POST['TypeAnswer'] == 'fan') {
		$query = "INSERT into follows (user_id, follow_id, type) values ('".$FriendID."','".$_SESSION['userid']."','user')"; 
		$DB->execute($query);
		$Message = $FriendArray->username. ' is now a fan.';
	} else if ($_POST['TypeAnswer'] == 'ignore'){
		$query = "UPDATE friends set FriendType=PreviousType, RID='' where RID='".$_POST['fid']."'";
		$DB->execute($query);
		$Message = 'You have ignored this request';
	}
	
}


?>

<?php include 'includes/header_template_new.php';?>
<script type="text/javascript">
function submit_form() {

	document.modform.submit();

}

</script>
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
<tr>
<? if ($_SESSION['IsPro'] == 1) {
$_SESSION['noads'] = 1;
		?>
		<td valign="top" style="padding:5px; color:#FFFFFF;width:60px;">
			<? include 'includes/site_menu_popup_inc.php';?>
		</td> 
		
<? } else {?>
<td width="<? echo $SideMenuWidth;?>" valign="top">
	<? include 'includes/site_menu_inc.php';?>
</td> 
<? }?>
        

		<td valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<?  } else {?> style="padding-left:13px;"<? }?>>
        
		<? if ($_SESSION['noads'] != 1) {?> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe>
<? }?><div style="height:100px;"></div>
<? if ($Message == '') {?>

<div class="messageinfo_white">
         	  <form name="modform" id="modform" method="post" action="#">
            
			<strong>FRIEND REQUEST<br></strong>
            <table><tr><td>
            <img src="<? echo $FriendArray ->avatar;?>">
            </td><td class="messageinfo_white"><? echo $FriendArray->username;?> wants to be your friend.</td></tr>
            <tr><td class="messageinfo_white"><div class="spacer"></div>Select an action: </td><td><div class="spacer"></div><select name="TypeAnswer"><option value="friend">Accept Friend Request</option><option value="fan">Suggest they become fan</option><option value="fan and follow">Make Fan and Follow as Fan</option><option value="ignore">Ignore this request</option></select>
            </td></tr>
            <tr><td colspan="2" align="center"><div class="spacer"></div><input type="image" src="http://www.wevolt.com/images/wizard_save_btn.png" style="border:none;background:none;"></td></tr>
            </table>
  <input type="hidden" value="1" name="submit">
<input type="hidden" value="<? echo $_GET['fid'];?>" name="fid">

     
      </form>
     </div>
      <? } else {?><div class="messageinfo_warning"><? echo $Message;?></div><? }?>
</td>
</tr>
</table>

<?php include 'includes/footer_template_new.php';?>



