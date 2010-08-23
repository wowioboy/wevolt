<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$TrackPage = 1;
?>
<?php 


$Action = $_REQUEST['action'];
$UserID = $_SESSION['userid'];
$EventID = $_REQUEST['id'];
$Auth = 0;


$query = "select * from users where encryptid='$UserID'"; 
$UserArray = $InitDB->queryUniqueObject($query);

$CloseWindow = 0;

$query = "select c.*,pc.promo_code, pc.xp 
          from calendar as c
		  left join promotion_codes as pc on pc.cal_id=c.id 
			 where c.id=".$_GET['id'];
$EventArray = $InitDB->queryUniqueObject($query);

if ($EventArray->type == 'promotion') {
	$query = "SELECT count(*) from promotion_codes_redeem where promo_code='".$EventArray->promo_code."' and user_id='".$_SESSION['userid']."'";
	$CodeRedeemed = $InitDB->queryUniqueValue($query);	
}

$SelectedAccess = explode(',',$EventArray->selected_access);

if ($SelectedAccess == null)
	$SelectedAccess = array();

$query = "select count(*) from friends where (FriendID='".$EventArray->user_id."' and UserID='".$_SESSION['userid']."') and Accepted=1 and FriendType='friend'";
$IsFriend = $InitDB->queryUniqueValue($query);
if ($IsFriend == 0) {
	$query = "select count(*) from friends where (FriendID='".$EventArray->user_id."' and UserID='".$_SESSION['userid']."') and Accepted=0 and FriendType='friend'";
	$Requested = $InitDB->queryUniqueValue($query);
	$query = "select count(*) from friends where (FriendID='".$EventArray->user_id."' and UserID='".$_SESSION['userid']."') and ((FriendType='fan') or (PreviousType='fan' and Accepted=0 and FriendType='friend'))";
	$IsFan = $InitDB->queryUniqueValue($query);
} else {
	$IsFan = 0;
}
if ($EventArray->user_id == $_SESSION['userid'])
	$IsOwner = true;
else 
	$IsOwner = false;

if (($IsFriend == 0) || ($IsFriend == '')) {
	$IsFriend = false;
} else {
	$IsFriend = true;
}

if (($IsFan == 0) || ($IsFan == '')) {
	$IsFan = false;
} else {
	$IsFan = true;
}
$Privacy = $EventArray->privacy_setting;
$query = "select count(*) from pf_events_invitations where CalID='".$_GET['id']."' and UserID='".$_SESSION['userid']."'";
$UserInvited = $DB->queryUniqueValue($query);
if ($IsOwner) {
	$Auth = 1;	
} else if ($Privacy == 'public'){ 
	$Auth = 1;	
}else if (($Privacy == 'friends') && (($IsFriend) || ($IsOwner))){
	$Auth = 1;
}else if (($Privacy == 'fans') && (($IsFriend) || ($IsOwner)|| ($IsFan))){
	$Auth = 1;	
}else if ($Privacy == 'groups'){
	$SelectedGroups = @explode(',',$EventArray->selected_groups);
	if ($SelectedGroups == null)
		 $SelectedGroups = array();
	foreach($SelectedGroups as $group) {
		$query = "SELECT GroupUsers from user_groups where ID='$group'";
		$GroupUsers = $DB->queryUniqueValue($query);
		$GroupUserArray = @explode(',',$GroupUsers);
		if ($GroupUserArray == null)
		 	$GroupUserArray = array();
		if (in_array($_SESSION['userid'],$GroupUserArray)) {
			$Auth = 1;	
			break;
		}
	}	
}else if (($Privacy == 'invites') && ($UserInvited>0)){
	$Auth = 1;
}

if ($Auth == 1) {		


$Redirect = 0;
if (($_POST['promo_claim'] == 1) &&(trim($_POST['txtPromoCode']) == $EventArray->promo_code)) {
	$PromoCode = $_POST['txtPromoCode'];
	$PromoRedir = $_POST['txtPromoDir'];
	if ($CodeRedeemed == 0) {
		$query = "INSERT into promotion_codes_redeem (user_id, promo_code, created_date) values ('".$_SESSION['userid']."', '$PromoCode',now())";	
		$InitDB->execute($query);
		include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
		$XPMaker = new Users();
		$output = $XPMaker->addxp($InitDB, $_SESSION['userid'], $EventArray->xp);
		$Redirect = 1;
	}
	
	
}		  
	$query = "select count(*) from pf_events_invitations where CalID=".$_GET['id'];
	$TotalInvites = $InitDB->queryUniqueValue($query);
	$query = "select count(*) from likes where ContentType='cal_entry'  and ContentID='".$_GET['id']."'";
	$TotalLikes = $InitDB->queryUniqueValue($query);
	$query = "select count(*) from likes where ContentType='cal_entry'  and UserID='".$_SESSION['userid']."' and ContentID='".$_GET['id']."'";
	$UserLiked = $InitDB->queryUniqueValue($query);
								  
	 if ($TotalInvites > 0) {
		$query = "select Status from pf_events_invitations where CalID=".$_GET['id']." and UserID='".$_SESSION['userid']."'";
		$Status = $InitDB->queryUniqueValue($query);
		$query = "SELECT u.username, u.avatar,u.encryptid, f.Status
				 from pf_events_invitations as f 
				 join users as u on f.UserID=u.encryptid 
				 where f.CalID='".$_GET['id']."' and f.Status !='attending'";
		$InitDB->query($query);
		while ($line = $InitDB->fetchNextObject()) {
				$InviteList .= '<img src="'.$line->avatar.'" tooltip="'.$line->username.': '.$line->Status.'" vspace="5" hspace="5" style="border:1px #000000 solid;" width="25" height="25" id="super_'.$line->encryptid.'" tooltip="'.$line->username.'">';	
		}
		$query = "select Status from pf_events_invitations where CalID=".$_GET['id']." and UserID='".$_SESSION['userid']."'";
		$Status = $InitDB->queryUniqueValue($query);
		$query = "SELECT u.username, u.avatar,u.encryptid, f.Status
				  from pf_events_invitations as f 
				  join users as u on f.UserID=u.encryptid 
				  where f.CalID='".$_GET['id']."' and f.Status='attending'";
		$InitDB->query($query);
		while ($line = $InitDB->fetchNextObject()) {
				$AttendingList .= '<img src="'.$line->avatar.'" tooltip="'.$line->username.'" vspace="5" hspace="5" style="border:1px #000000 solid;" width="25" height="25" id="super_'.$line->encryptid.'">';								
		}
											
	 }
}

 if ($Redirect == 1)
 	header("location:".$PromoRedir);
	
$PageTitle .= ' view event ' .$SubPageHeader;  

include 'includes/header_template_new.php';

$Site->drawUpdateCSS();
if ($_SESSION['IsPro'] == 1) 
           $_SESSION['noads'] = 1;

?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_myvolt_modules_css.css">

<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['noads'] == 1) {?> width="100%"<? }?>>
  <tr>
  
    <td valign="top"  <? if ($_SESSION['noads'] == 1) {?>style="padding:5px; color:#FFFFFF;width:60px;"<? } else {?> width="<? echo $SideMenuWidth;?>"<? }?>><? include   INCLUDES.'site_menu_inc.php';?></td>
     <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
         <center>
   <table width="608" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="592" align="center">
                                        <table width="100%"><tr><td width="125">
                             <? if (($EventArray->type == 'event') || ($EventArray->type == 'promotion')) {?>
                          
                              <table><tr>
                              
                             
                             <? 
							 	if ($_SESSION['userid'] != '')
                            	echo '<td><a href="javascript:void(0)" onClick="parent.new_wizard(\'excite\',\''.$EventArray->id.'\',\'user\',\'cal_entry\');return false;"><img src="http://www.wevolt.com/images/reader_volt_btn.png" border="0" tooltip="Volt or Excite '.$EventArray->title.'" tooltip_position="bottomright"/></a></td>';
					 
							echo  '<td class="messageinfo_white"><span id="like_event_'.$_GET['id'].'">';
							if ($TotalLikes > 0 ) { 
								echo $TotalLikes .' like'; 
							if ($TotalLikes != 1) 
								echo 's';
							}
							echo '</span>';
							
							if (($UserLiked == 0) && ($_SESSION['userid'] != ''))
								echo '&nbsp;<span id="like_cell"><a href="javascript:void(0)" onClick="parent.like_content(\''.$_GET['id'].'\',\'cal_entry\',\'like_event_'.$_GET['id'].'\',\'http://www.wevolt.com/view_event.php?action=view&id='.$_GET['id'].'\',\'\');document.getElementById(\'like_cell\').innerHTML=\'you like this\';return false;"><img src="http://www.wevolt.com/images/reader_like_btn.png" border="0" tooltip="Like this event, boost it\'s rating!" tooltip_position="bottomright"/></a></span></td>';
												
				
							?>
                            
                            </tr></table>
                            <? }?>
                            
                            </td><td>
                                        <? if ($EventArray->type == 'event') {?>
                                        <img src="http://www.wevolt.com/images/wizards/event_title.png" vspace="8"/>
                                        <? } else if ($EventArray->type == 'reminder') {?>
                                         <img src="http://www.wevolt.com/images/wizard_reminder_title.png" vspace="8"/>
                                        
                                        <? }else if ($EventArray->type == 'promotion') {?>
                                         <img src="http://www.wevolt.com/images/wizard_promo_title.png" vspace="8"/>
                                        <? }else if ($EventArray->type == 'todo') {?>
                                         <img src="http://www.wevolt.com/images/wizard_todo_title.png" vspace="8"/>
                                        <? }?></td>
                                        </tr>
                                        </table>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        <div class="spacer"></div>
 <?  if ($Auth == 1) {?>                    

                          <?   if ($_REQUEST['action'] == 'view') { 
						  
						 ?>
                 
 <div align="center">
<table><tr>

<? if ($EventArray->thumb != '') {?>
<td valign="top" align="center">
<? 

list($width, $height) = @getimagesize($EventArray->thumb); 	
if ($width > 200)
	$width=200; 
if ($height > 100)
	$height = 100;?><img src="<? echo $EventArray->thumb;?>" width="<? echo $width;?>" border="2"/></td>
		
		<? 
			$Width = 486;
		} else {
			$Width = 590;
			
		}?>
<td>
<script type="text/javascript">


</script>
<table width="<? echo $Width;?>" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="<? echo ($Width-16);?>" align="left">
<strong>Title:&nbsp;</strong><? echo $EventArray->title;?><br />
    <strong>Date:&nbsp;</strong><? echo  date('l, F d, Y', strtotime($EventArray->start));?><br />
    <? if (($EventArray->show_start_time == 1) || ($EventArray->show_end_time == 1)) {?>

<strong>Time:&nbsp;</strong><? if ($EventArray->show_start_time == 1) echo date('h:ia', strtotime($EventArray->start));?>
<? if ($EventArray->show_end_time == 1) {
	if ($EventArray->show_start_time == 1) 
		echo '-'; 
	echo date('h:ia', strtotime($EventArray->end));?>

<? }?>
<br />
<? }?>
  <? if (($EventArray->location != '') && ($EventArray->location != '0')) {?>
 <strong> Location:&nbsp;</strong><? echo $EventArray->location;?><br /> 
  <? }?> 
   <? if ($EventArray->address != '') {?>
 <strong> Street:&nbsp;</strong><? echo $EventArray->address;?><br /> 
  <? }?>
     <? if ($EventArray->city != '') {?>
 <strong> City:&nbsp;</strong><? echo $EventArray->city;?><br /> 
  <? }?>
   <? if ($EventArray->city != '') {?>
  <strong>Zip:&nbsp;</strong><? echo $EventArray->zip;?><br />
  <? }   
   if ($EventArray->type == 'promotion') {?>
   <div class="spacer"></div>

 <strong> Promo Code: </strong><span class="messageinfo_warning"><? echo $EventArray->promo_code;?></span><br />
 <? if ($CodeRedeemed == 1) {?>
 You have already recieved this promotion
 <? } else {?>
  <form method="post" action="#">Enter Promo Code<br />
  <input type="text" name="txtPromoCode" style="width:200px;"/>
<br />

  <input type="hidden" name="txtPromoDir" value="<? echo $EventArray->url;?>" />
  <input type="hidden" name="promo_claim" value="1" />
  <input type="submit" value="CLAIM" />
  </form>
  <? }?>
  <? } else {?>
  <? if (($EventArray->url != '') && ($EventArray->url != 'http://')){?>
  <div class="messageinfo_white"><a href="<? echo $EventArray->url;?>"><strong>VIST LINK&nbsp;</strong></a></div>
  <? }?>    
  <? }?>
  <? 
	
  if ($EventArray->type == 'reminder') {?>
	  <? if ($EventArray->content_type == 'feed_item') {
		  	$query = "SELECT * from feed_items where UserID='$UserID' and EncryptID='$EventArray->content_id'";
			$ItemArray = $InitDB->queryUniqueObject($query);
			
			 if (($ItemArray->Link != '') && ($ItemArray->Link != 'http://')){?>
              <div class="messageinfo_white"><a href="javascript:void(0)" onclick="parent.document.location.href='<? echo $EventArray->Link;?>';"><strong>VIST LINK&nbsp;</strong></a></div>
 			 	
                
  			<? }?> 
     <? }?>                              
  <? }?> 
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td></tr></table>

<table><tr>
<td valign="top" class="messageinfo_white">
<? if (($TotalInvites > 0) && (($EventArray->show_list == '1') || ($IsOwner))) 
	$Width = 200;
	else  
		$Width = 590;
		?>
<table width="<? echo $Width;?>" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="<? echo ($Width-16);?>" align="left" style="padding:3px;">

<strong>DESCRIPTION</strong><br />
<div style="height:100px; width:<? echo ($Width-25);?>px; background-color:#FFF; color:#000; border:1px #666 solid; padding:3px; overflow:auto">
<? echo $EventArray->description;?>
</div>
<div  style="height:5px;"></div>
<? if ($EventArray->type != 'reminder') {?>
<strong>Privacy Level</strong>: <? echo $EventArray->privacy_setting;?><br />
<? }?>
<? if ($Status != '') {?>
<div  style="height:5px;"></div><div  style="height:5px;"></div>
<strong>Your Attendance</strong>:<br />
<select name="txtAttend" onchange="set_attendance(this.options[this.selectedIndex].value);">
<? if ($Status == 'invited'){?>
<option value="invited" selected>Not Repsonded</option>
<? }?>
<option value="attending" <? if ($Status == 'attending') echo ' selected';?>>Attending</option>
<option value="maybe attending" <? if ($Status == 'maybe attending') echo ' selected';?>>Maybe Attending</option>
<option value="not attending" <? if ($Status == 'not attending') echo ' selected';?>>Not Attending</option>
</select>
<div  style="height:5px;"></div>
<? }?>
</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td>
<? if (($TotalInvites > 0)  && (($EventArray->show_list == '1') ||($IsOwner))) {?><td valign="top">
<table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="<? echo (200-16);?>" align="left" style="padding:3px;">
                                        
<div style="border-bottom:solid 1px #FC0;">INVITE LIST<br /></div>
<div style="height:180px; overflow:auto;">
<? echo $InviteList;?>
</div>
  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td><? }?>
<? if (($TotalInvites > 0)  && (($EventArray->show_list == '1') ||($IsOwner))) {?><td valign="top">
<table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="<? echo (200-16);?>" align="left" style="padding:3px;">
<div style="border-bottom:solid 1px #FC0;">ATTENDING LIST<br /></div>
<div style="height:180px; overflow:auto;">
<? echo $AttendingList;?>
</div>
  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td><? }?>
</tr></table>
<? } else {?>
                          
                          You do not have access to view this event. <br />
The privacy of this event is set to <? echo $EventArray->privacy_setting;?>
                          
                          <? }?>

                            
<? /*                            
 <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onClick="closeWindow();" class="navbuttons"/>&nbsp;&nbsp; 
<img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','<? echo $_REQUEST['task'];?>','');" class="navbuttons"/>&nbsp;&nbsp;
*/?>
<? }   else {?>
                          
                         <div class="messageinfo_warning"><div class="spacer"></div> <div class="spacer"></div><div class="spacer"></div>You do not have access to view this event. The privacy of this event is set to <? echo $EventArray->privacy_setting;?></div>
                          
                          <? }?>
    	</center>
         </div>
            
 	</td>
	
</tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>
</div>

