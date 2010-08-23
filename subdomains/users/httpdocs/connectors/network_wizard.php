<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
$DB = new DB();
$ReturnLink = $_GET['ref'];
$RePost = 0;
$UserID = $_SESSION['userid'];
$FriendName = $_GET['user'];
if ($FriendName == '')
	$FriendName = $_POST['FriendName'];
$query = "SELECT encryptid,email from users where username='".trim($FriendName)."'";
$FriendArray = $DB->queryUniqueObject($query);
//print $query.'<br/>';
$FriendID = $FriendArray->encryptid;
$FriendEmail = $FriendArray->email;
$CloseWindow = 0;
$SelectedUpdates = $_POST['txtSelectedUpdates'];

if ($SelectedUpdates == '')
	$SelectedUpdates = explode(',',$_POST['txtUpdates']);

	if (is_array($SelectedUpdates))
	{
  	$TempUpdates = '';
 	 foreach ($SelectedUpdates as $value) {
   	  if ($TempUpdates != '')
   	   $TempUpdates .= ',';
   	 $TempUpdates .= $value;
 	 }
 	 $UpdateString = $TempUpdates;
	}
if ($SelectedUpdates == null)
	$SelectedUpdates = array();
		
$query ="SELECT * from friends where UserID='$UserID' and FriendID = '$FriendID'";
$CurrentNetwork = $DB->queryUniqueObject($query);


$query =  "SELECT DISTINCT cs. * , c. *
FROM projects AS c
JOIN comic_settings AS cs ON cs.ComicID = c.ProjectID
WHERE (
c.CreatorID = '$UserID'
OR c.userid = '$UserID')
AND c.installed =1
ORDER BY c.title DESC";
$DB->query($query);
$counter = 0;
$numberComics = $DB->numRows();
$UserContent = "<div style='width:100%;'>";
while ($line = $DB->FetchNextObject()) {

	$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			
			///if ($line->Hosted == 1) {
					//$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//$comicURL = $line->url.'/';
				//} else if (($line->Hosted == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/';
				//} else {
					//$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//$comicURL = $line->url;
				//}


$UserContent .='<a href="javascript:void(0)" onClick="set_content(\''.addslashes(str_replace('"',"'",$line->title)).'\',\''.$line->ProjectID.'\',\''.$comicURL.'\',\''.$fileUrl.'\',\'comic\',\''.addslashes(str_replace('"',"'",$line->synopsis)).'\',\''.addslashes(str_replace('"',"'",$line->Tags)).'\');\"><img src=\''.$fileUrl.'\' border="2" alt="LINK" style="border:1px solid #000000;" width="50" hspace="3" vspace="3"></a>'; 
			 $counter++;
			 
			
	
	 }
	  $UserContent .= "</div>";
	 if ($numberComics == 0) {
	 		$UserContent = '<div class="favs" style="text-align:center;padding-top:25px;height:200px;">There are currently no active comics for this user</div>';
	 }


$query = "SELECT NotifyList from notify_settings_users where UserID='$UserID' and FriendID='%FriendID'" ;
$NotifyList = $DB->queryUniqueValue($query);

$query = "SELECT count(*) from pf_calendar where UserID='$UserID' and ContentID='$FriendID' and EntryType='reminder'";
$HasReminder = $DB->queryUniqueValue($query);

if ($UpdateString == '')
	$UpdateString = $NotifyList;

if ($_GET['step'] == 'finish') {
	    $RequestType = $_POST['txtFriendType'];
		$Reminder = $_POST['txtReminder'];
		$Title = mysql_real_escape_string($_REQUEST['txtTagline']);
		$Description = mysql_real_escape_string($_REQUEST['txtDescription']);
		$Location = mysql_real_escape_string($_REQUEST['txtLocation']);
		$Tags = mysql_real_escape_string($_REQUEST['txtTags']);
		$MoreInfo = mysql_real_escape_string($_REQUEST['txtInfo']);
		$Privacy = $_REQUEST['txtPrivacy'];
		$UserID = $_SESSION['userid'];
		$CreatedDate = date('Y-m-d h:i:s');
		$Thumb = $_REQUEST['txtThumb'];
		$ItemID = $_REQUEST['txtItem'];
   		$Address = mysql_real_escape_string($_REQUEST['txtAddress']);
		$Address2 = mysql_real_escape_string($_REQUEST['txtAddress2']);
		$ContactName = mysql_real_escape_string($_REQUEST['txtContactName']);
		$ContactPhone = mysql_real_escape_string($_REQUEST['txtContactPhone']);
		$ContactEmail = mysql_real_escape_string($_REQUEST['txtContactEmail']);
		$UseWemail = mysql_real_escape_string($_REQUEST['txtUseWemail']);
		$City = mysql_real_escape_string($_REQUEST['txtCity']);
		$State = mysql_real_escape_string($_REQUEST['txtState']);
		$Zip = mysql_real_escape_string($_REQUEST['txtZip']);
		$State = mysql_real_escape_string($_REQUEST['txtState']);			
		$StartDate = $_REQUEST['start_date'] . ' 00:00:00';
   	    $EndDate = $_REQUEST['end_date'] . ' 00:00:00';
//		if ($_POST['NoEnd'] == 1) {
//			$EndDate = '';
//
//		}
		if ($Thumb == '')
			$Thumb = $_SESSION['avatar'];
		$Link = $_REQUEST['txtLink'];
		$EventType = $_REQUEST['type'];
		$ContentID = $_REQUEST['ContentID'];
		$ContentType = 'user';
		if ($Privacy == '')
			$Privacy = 'private';
			
		$frequency = $_REQUEST['frequency'];
		$interval = $_REQUEST['interval'];
		$custom = $_REQUEST['custom'];
		$week_number = $_REQUEST['week_number'];
		$week_day = $_REQUEST['week_day'];
			if (is_array($_REQUEST['week_day']))
				$week_day = @implode(',',$_REQUEST['week_day']);
		$query ="SELECT * from friends where UserID='$UserID' and FriendID = '$FriendID'";
		$RequestArray = $DB->queryUniqueObject($query);
		
		
		
		$query ="SELECT * from friends where UserID='$FriendID' and FriendID = '$UserID'";
		$FriendStatusArray = $DB->queryUniqueObject($query);
		//print $query.'<br/>';
		if ($RequestArray->ID == '') {
				if ($RequestType == 'fan')
					$Approved = 1;
				else 
					$Approved = 0;
				if ($RequestType == 'fan') {
					$query ="SELECT count(*) from follows where follow_id='$FriendID' and user_id='".$_SESSION['userid']."'";
					$Found = $DB->queryUniqueValue($query);
					if ($Found == 0) {
					$query = "INSERT into follows (user_id, follow_id, type) values ('".$_SESSION['userid']."','".$FriendID."','user')"; 
					$DB->execute($query);
					}
					
					
				} else {
				$query ="INSERT into friends (UserID, FriendID, Accepted,FriendType) values ('$UserID', '$FriendID', $Approved, '$RequestType')";
				$DB->execute($query);
				//print $query.'<br/>';
				$query ="INSERT into friends (UserID, FriendID, Accepted,FriendType) values ('$FriendID', '$UserID', 0, 'system')";
				$DB->execute($query);
				}
			//print $query.'<br/>';
		}
		
		if (($RequestType =='friend')&&($RequestArray->FriendType != 'friend')) {
				   $RequestID = md5(md5($UserID).md5($FriendID));
				  $query = "UPDATE friends set FriendType='$RequestType', Accepted='0', RID='$RequestID', RequestDate='$CreatedDate' where UserID='$UserID' and FriendID='$FriendID'";
				  $DB->execute($query);
					//print $query.'<br/>';
				  //$query = "UPDATE friends set FriendType='$RequestType', Accepted='0' where UserID='$FriendID' and FriendID='$UserID'";
				 // $DB->execute($query);
				 // print $query.'<br/>';
				 
				
					  //SEND WEmail
				  $Subject = 'You have a Friend Request';
				  $Message = $_SESSION['username'] .' wants to add you as a friend on WEvolt. If you want to accept their request, please click this link <a href="javascript:void(0)" onclick="window.location.href=\'http://users.wevolt.com/accept_request.php?fid='.$RequestID.'\';">VIEW REQUEST</a><br/>By accepting their request they will have access to view information your fans and the public can\'t.';
				  $query = "INSERT into messages (userid, sendername, senderid, subject, message, date) values ('$FriendID','".$_SESSION['username']."','".$_SESSION['userid']."','$Subject','".mysql_real_escape_string($Message)."','$CreateDate')";
				  $DB->execute($query);
				 // print $query.'<br/>';
				  //SEND EMAIL
				  $header = "From: noreply@wevolt.com  <noreply@wevolt.com >\n";
				  $header .= "Reply-To: noreply@wevolt.com <noreply@wevolt.com>\n";
	              $header .= "X-Mailer: PHP/" . phpversion() . "\n";
	              $header .= "X-Priority: 1";
				  $to = $FriendEmail;
				  $subject = $Subject .' on WEvolt';
				  $body = "Hi, ".$FriendName.", ".$_SESSION['username']." wants to add you as a friend on WEvolt.\r\nIf you know this person and want to accept their request, click HERE: http://users.wevolt.com/accept_request.php?fid=".$RequestID."\r\nBy accepting their request they will have access to view information your fans and the public cannot.";
   				  mail($to, $subject, $body, $header);
				
		} else if (($RequestType =='fan')&&($RequestArray->FriendType == 'friend')) {
					$query ="SELECT count(*) from follows where follow_id='$FriendID' and user_id='".$_SESSION['userid']."'";
					$Found = $DB->queryUniqueValue($query);
					if ($Found == 0) {
					$query = "INSERT into follows (user_id, follow_id, type) values ('".$_SESSION['userid']."','".$FriendID."','user')"; 
					$DB->execute($query);
					}
					//$query = "UPDATE friends set FriendType='$RequestType', Accepted='0', PreviousType='friend', RequestDate='$CreateDate',AcceptedDate='$CreateDate' where UserID='$UserID' and FriendID='$FriendID'";
					//$DB->execute($query);
				//	print $query.'<br/>';
					if ($FriendStatusArray->FriendType != 'fan') {
						$query = "UPDATE friends set FriendType='system', PreviousType='".$FriendStatusArray->FriendType."', Accepted='0' where UserID='$FriendID' and FriendID='$UserID'";
			+			$DB->execute($query);
					}
		//print $query.'<br/>';
		} 		
			
		if (($Reminder == '1') && ($HasReminder == 0)) {
			
			$query = "SELECT count(*) from calendar where user_id='$UserID' and content_id='$FriendID' and `type`='reminder'";
			$Found = $DB->queryUniqueValue($query);
			if ($Found == 0) {
				
				
				$query = "INSERT into calendar (title, `start`, `end`, user_id, content_id, content_type, `type`, privacy_setting, url,created_date, thumb, frequency, `interval`, custom, week_day, week_number,no_end) 
			                        values ('$Title','$StartDate','$EndDate','$UserID','$FriendID', 'user','reminder','private', 'http://users.wevolt.com/".trim($FriendName)."/','$CreatedDate','$Thumb','$frequency', '$interval', '$custom', '$week_day', '$week_number','".$_POST['NoEnd']."')";
			$DB->execute($query);

				//print 
				$output .= $query.'<br/>';
				$query = "SELECT id from calendar where created_date='$CreatedDate' and user_id='$UserID'";
				$CalID = $DB->queryUniqueValue($query);
				$Encryptid = substr(md5($CalID), 0, 15).dechex($CalID);
						$IdClear = 0;
						$Inc = 5;
						while ($IdClear == 0) {
								$query = "SELECT count(*) from calendar where encrypt_id='$Encryptid'";
								$Found = $DB->queryUniqueValue($query);
								$output .= $query.'<br/>';
								if ($Found == 1) {
									$Encryptid = substr(md5(($CalID+$Inc)), 0, 15).dechex($CalID+$Inc);
								} else {
									$query = "UPDATE calendar SET encrypt_id='$Encryptid' WHERE id='$CalID'";
									$DB->execute($query);
									$output .= $query.'<br/>';
									$IdClear = 1;
								}
								$Inc++;
						}
			} else {
				$query = "UPDATE calendar set title='$Title', description='$Tagline',frequency='$frequency', `interval`='$interval',custom='$custom', week_day='$week_day', week_number='$week_number', `start`='$EntryStart',`end`='$EntryEnd' where user_id='$UserID' and content_id='$FriendID' and `type`='reminder'";
				$DB->execute($query);
				//print $query.'<br/>';
			}

		}
		$query = "SELECT count(*) from notify_settings_users where UserID='$UserID' and FriendID='$FriendID'" ;
		$Found = $DB->queryUniqueValue($query);
		//print $query.'<br/>';
		if ($Found == 0) {
			$query = "INSERT into notify_settings_users (UserID, FriendID, NotifyList) values ('$UserID', '$FriendID', '$UpdateString')";
			$DB->execute($query);
			//print $query.'<br/>';
				
		} else {
			$query = "UPDATE notify_settings_users set NotifyList='$UpdateString' where UserID='$UserID' and FriendID='$FriendID'";
			$DB->execute($query);
			//print $query.'<br/>';
		}
		
		if ($UpdateString != '') {
			$query ="SELECT count(*) from follows where follow_id='$FriendID' and user_id='".$_SESSION['userid']."'";
			$IsFan = $DB->queryUniqueValue($query);
			if ($IsFan == 0) {
					$query = "INSERT into follows (user_id, follow_id, type) values ('".$_SESSION['userid']."','$FriendID','user')"; 
					$DB->execute($query);
			}
		}
		
		$CloseWindow = 1;
		

}
	
$DB->close();

function convert_datetime($str) 
{

list($date, $time) = explode(' ', $str);
list($year, $month, $day) = explode('-', $date);
list($hour, $minute, $second) = explode(':', $time);

$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

return $timestamp;
}
  function DateSelector($inName, $useDate='') 
    { 
    	$string = '<input name="'.$inName.'" class="datepicker" type="text" value="'.$useDate.'"/>';
 return $string;
} 

 function DayDropdown($inName, $useDate='') 
    { 
 return $string;
} 

?>
<link href="http://www.wevolt.com/css/cupertino/jquery-ui-1.8.1.custom.css" rel="stylesheet" />
<script src="http://www.wevolt.com/js/jquery-1.4.2.min.js"></script>
<script src="http://www.wevolt.com/js/jquery-ui-1.8.1.custom.min.js"></script>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
  <script>

$(document).ready(function() {
	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd'
	});
});
</script>
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">


<script language="JavaScript" type="text/javascript" src="http://www.wevolt.com/ajax/ajax_init.js"></script>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
function submit_form(step, type) {

	var formaction = 'network_wizard.php?step='+step+'&type='+type;
	document.networkform.action = formaction; 
	document.networkform.submit();

}

function select_revolts(value) {
	if (value == '') {
		document.getElementById("revolts").style.display = 'none';
	} else {
		document.getElementById("revolts").style.display = '';
		
	}

}

function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
  function toggleEnd(value) 
{

	if (value == 'on') {
		document.getElementById("NoEnd").value = 1;
		document.getElementById("endtr").style.display = 'none';
	
		document.getElementById("endset").style.display = 'none';
		document.getElementById("noendset").style.display = '';
		
	
	} else {
		document.getElementById("NoEnd").value = '';
		document.getElementById("endtr").style.display = '';
		document.getElementById("endset").style.display = '';
		document.getElementById("noendset").style.display = 'none';
	}
    
 }
 
 function setDefault(theText) 
{
     if (theText.value == "")
 {
         theText.value = theText.defaultValue;
     }
 }
 function freq_select(value) {

if (value == 'weekly') {
	document.getElementById('dayofweek').style.display='';
	document.getElementById('dayofmonth').style.display='none';
	document.getElementById('monthheader1').style.display='none';
	document.getElementById('weeknumber').style.display='none';
	document.getElementById('monthheader2').style.display='none';
} else if (value == 'monthly') {
	document.getElementById('dayofweek').style.display='';
	document.getElementById('dayofmonth').style.display='';
	document.getElementById('weeknumber').style.display='';
	document.getElementById('monthheader1').style.display='';
	document.getElementById('monthheader2').style.display='';

} else {
	document.getElementById('dayofweek').style.display='none';
	document.getElementById('dayofmonth').style.display='none';
	document.getElementById('weeknumber').style.display='none';
	document.getElementById('monthheader1').style.display='none';
	document.getElementById('monthheader2').style.display='none';

}
}
function confrim_action(action,type) {
	if (type == 'friend') {
		if (action == 'none') {
			alert('You have already sent a friend request to this person');
		} else if (action == 'not_friend') {
			var answer = confirm ("This will send a request for this person to accept. Are you sure?");
			
			if (answer)
				submit_form('2','friend');
				
		} else if (action == 'change_info'){
			submit_form('2','friend');
		}
	} else if (type == 'fan') {
		
		if (action == 'none') {
			var answer = confirm ("You have sent this person a friend request, do you want to still FAN them?");
			if (answer)
				submit_form('2','fan');
		} else if (action == 'not_friend') {
			submit_form('2','fan');
		} else if (action == 'change_info') {
		    var answer1 = confirm ("You are currently a friend of this user, by changing this connection to FAN you will lose your friend status and will need to request their friendship again if you want to be friends again. Are you sure you want to do this?");
			if (answer1)
				submit_form('2','fan');
		}
	}

}

function confirm_fan(action) {

	

}


</script>

<body>
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
parent.$.modal().close();
</script>

<? }?>  
<form method="post" id="networkform" name="networkform">
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center">
<div style="height:10px;"></div>
<table width="608" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="592" align="center">
                                        <img src="http://www.wevolt.com/images/network_wizard_header_new.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
<? if (($_GET['step'] == '') ||  ($_GET['step'] == '1')) { ?><div class="spacer"></div>
<table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
<div class="messageinfo_white">
<? if (($CurrentNetwork->FriendType == 'friend') && ($CurrentNetwork->Accepted == 1))
		$FriendAction = 'change_info';
	else if (($CurrentNetwork->FriendType == 'friend') && ($CurrentNetwork->Accepted == 0))
		$FriendAction = 'none';
	else 
		$FriendAction = 'not_friend';	
		
		?>
How do you know them? 
<div style="height:10px;"></div>
</div>
<div class="white_box" style="width:194px;">
<div class="blue_button" onClick="confrim_action('<? echo $FriendAction;?>','friend');">FRIEND</div>
<div class="spacer"></div><span style="font-size:12px;">
You were personally given their contact
details and/or have a direct personal
relationship with them.</span>
</div>
<div class="spacer"></div>
<div class="white_box" style="width:194px;">
<div class="blue_button" onClick="confrim_action('<? echo $FriendAction;?>','fan');">FAN</div>
<div class="spacer"></div><span style="font-size:12px;">
You love who they are and what they do.
You probably don't have  a personal
relationship, but that doesn't mean you
don't suport them.</span>
</div>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        <div class="spacer"></div>
<img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onClick="parent.$.modal().close();" class="navbuttons"/>

<? } else if ($_GET['step'] == '2') {?>

<div class="spacer"></div>
<table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
<div class="messageinfo_white">

What sort of updates do you want from them? <br />Select ALL or NONE.
<div class="spacer"></div>
<table><tr><td>
<input type="checkbox" name="txtSelectedUpdates[]" value="excite" <? if ((in_array('excite',$SelectedUpdates)) || ($SelectedUpdates == '')) echo 'checked';?> style="background:none; border:none;"/></td><td class="messageinfo_white">EXCITES<br /></td></tr>

<tr><td style="padding:3px;"><input type="checkbox" name="txtSelectedUpdates[]" value="wevolt" <? if ((in_array('wevolt',$SelectedUpdates)) || ($SelectedUpdates== '')) echo 'checked';?>/ style="background:none; border:none;"></td><td class="messageinfo_white">WEvolt (Window updates)</td></tr>
<tr><td style="padding:3px;"><input type="checkbox" name="txtSelectedUpdates[]" value="revolt" <? if ((in_array('revolt',$SelectedUpdates))  || ($SelectedUpdates == ''))echo 'checked';?> style="background:none; border:none;"/></td><td class="messageinfo_white">REvolt (Project updates)</td></tr>
<tr><td style="padding:3px;"><input type="checkbox" name="txtSelectedUpdates[]" value="forum" <? if ((in_array('forum',$SelectedUpdates)) || ($SelectedUpdates == '')) echo 'checked';?>/></td><td class="messageinfo_white">Forum</td></tr>
<tr><td style="padding:3px;"><input type="checkbox" name="txtSelectedUpdates[]" value="profile" <? if ((in_array('profile',$SelectedUpdates))  || ($SelectedUpdates == '')) echo 'checked';?> style="background:none; border:none;"/></td><td class="messageinfo_white">Profile (Information change) <br /></td></tr></table>

</div>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                          <div class="spacer"></div>
<img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onClick="parent.$.modal().close();" class="navbuttons"/>&nbsp;&nbsp; 
<img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','<? echo $_GET['type'];?>');" class="navbuttons"/>&nbsp;&nbsp; <? if ($HasReminder == 0) {?>
<img src="http://www.wevolt.com/images/wizard_next_btn.png" onClick="submit_form('3','<? echo $_GET['type'];?>');" class="navbuttons"/>&nbsp;&nbsp;<? }?><img src="http://www.wevolt.com/images/wizard_save_btn.png" onClick="submit_form('finish','<? echo $_GET['type'];?>');" class="navbuttons" />

<? } else if ($_GET['step'] == '3') {?>
<div class="spacer"></div>
<table width="600" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="584" align="center">
<div class="messageinfo_warning">
<strong>OPTIONAL STEP:</strong>
</div>
<div class="messageinfo_white">
You can set up a reminder for yourself to check back with them from time to time. <br>
This step is optional, if finished, just click SAVE below.<div class="spacer"></div>

<input type="radio" name="txtReminder" value="1" <? if ($_POST['txtReminder'] == 1) echo 'checked';?> onClick="document.getElementById('eventsched').style.display='';" style="background:none; border:none;"/>Yes, set up a reminder&nbsp;&nbsp;
<input type="radio" name="txtReminder" value="0" <? if (($_POST['txtReminder'] == 0) ||($_POST['txtReminder'] == '')) echo 'checked';?> onClick="document.getElementById('eventsched').style.display='none';" style="background:none; border:none;"/>No reminder.<div class="spacer"></div>

<div id="eventsched" style="display:none;">


<table width="97%" cellpadding="0" cellspacing="0">

<tr>
<td  align="left" class="messageinfo_white" width="75">Comment:</td><td>
<input id="txtTagline" name="txtTagline" style="width:250px;" value="<? echo $_POST['txtTagline'];?>" type="text"></td>
</tr>
<tr><td colspan="2">
<div class="spacer"></div>
<table>
<tr><td class="messageinfo_white">Start:</td><td><? echo DateSelector('start_date',$Start) ?></td>
<td  class="messageinfo_white"><span class="messageinfo_white"  <? if ($_REQUEST['NoEnd'] == '1'){?> style="display:none;"<? }?>>&nbsp;&nbsp;<span id="endset"><a href="javascript:void(0)" onClick="toggleEnd('on');">-Set No End Date-</a></span><span id="noendset" <? if ($_REQUEST['NoEnd'] != '1'){?> style="display:none;"<? }?>><a href="#" onClick="toggleEnd('off');">-Set End Date-</a><br/><em>This event will repeat until cancelled.</em></span></span></td><td><div id='endtr' <?  if ($_REQUEST['NoEnd'] == '1'){?> style="display:none;"<? }?> class="messageinfo_white">End:&nbsp;<? echo DateSelector('end_date', $End);?></div></td>
</tr>

<tr><td class="messageinfo_white" valign="top"><div style="height:3px;"></div>Frequency
<div style="height:5px;"></div></td><td colspan="3" valign="top">
<table><tr><td valign="top">
<select name="frequency" onChange="$('.month,.day,.week').hide();$('.' + this.value).show();">
<option value="" <?php echo ($_REQUEST['frequency'] == '') ? 'selected' : ''; ?> />One Time</option>
<option value="day" <?php echo ($_REQUEST['frequency'] == 'day') ? 'selected' : ''; ?> /> Daily</option>
<option value="week" <?php echo ($_REQUEST['frequency'] == 'week') ? 'selected' : ''; ?> />Weekly</option>
<option value="month" <?php echo ($_REQUEST['frequency'] == 'month') ? 'selected' : ''; ?> />Monthly</option>
</select></td><td>
<span class="day week month" style=" <?php if ($_REQUEST['frequency'] == ''){?>display:none;<? }?> font-size:12px; color:#ffffff;">Interval: <input type="text" name="interval" value="<?php echo ($_REQUEST['interval']) ? $_REQUEST['interval'] : 1; ?>" style="width:25px;" maxlength="1"/></span>&nbsp;&nbsp;<span class="month week" style="<?php if (($_REQUEST['frequency'] != 'month')&&($_REQUEST['frequency'] != 'week') ){?>display:none;<? }?> font-size:12px; color:#ffffff;" >Custom: <input type="checkbox" name="custom" value="1" onChange="$('.extra').toggle();" <?php echo ($_REQUEST['custom']) ? 'checked' : ''; ?> /></span>

<div class="extra" <?php echo ($_REQUEST['custom']) ? '' : 'style="display:none;"'; ?>>
<table class="month" style="color:#fff;font-size:12px;<?php if (($_REQUEST['frequency'] != 'month') && ($_REQUEST['custom'] == 0)) {?>display:none;<? }?>">
  <tr>
    <td>
Week Number: 
    </td>
    <td>
<select name="week_number">
<option value='1' <?php echo ($_REQUEST['week_number'] == '1') ? 'selected' : ''; ?>>1st</option>
<option value='2' <?php echo ($_REQUEST['week_number'] == '2') ? 'selected' : ''; ?>>2nd</option>
<option value='3' <?php echo ($_REQUEST['week_number'] == '3') ? 'selected' : ''; ?>>3rd</option>
<option value='4' <?php echo ($_REQUEST['week_number'] == '4') ? 'selected' : ''; ?>>4th</option>
<option value='5' <?php echo ($_REQUEST['week_number'] == '5') ? 'selected' : ''; ?>>last</option>
</select>
    
    </td>
  </tr>
</table>
<table class="week month" style="color:#fff;font-size:12px;<?php if ($_REQUEST['custom'] == 0) {?>display:none;<? }?>">
  <tr>
    <td>Mo</td>
    <td>Tu</td>
    <td>We</td>
    <td>Th</td>
    <td>Fr</td>
    <td>Sa</td>
    <td>Su</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="week_day[]" value="1" <? if (in_array("1",$SelectedDays)) echo 'checked';?>/></td>
    <td><input type="checkbox" name="week_day[]" value="2" <? if (in_array("2",$SelectedDays)) echo 'checked';?>/></td>
    <td><input type="checkbox" name="week_day[]" value="3" <? if (in_array("3",$SelectedDays)) echo 'checked';?>/></td>
    <td><input type="checkbox" name="week_day[]" value="4" <? if (in_array("4",$SelectedDays)) echo 'checked';?>/></td>
    <td><input type="checkbox" name="week_day[]" value="5" <? if (in_array("5",$SelectedDays)) echo 'checked';?>/></td>
    <td><input type="checkbox" name="week_day[]" value="6" <? if (in_array("6",$SelectedDays)) echo 'checked';?>/></td>
    <td><input type="checkbox" name="week_day[]" value="7" <? if (in_array("7",$SelectedDays)) echo 'checked';?>/></td>
  </tr>
</table>
</div></td></tr></table></td></tr>

</table>
</td>

</tr>
</table>
 </div>
</div>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                       
                          <div class="spacer"></div>
<img src="http://www.wevolt.com/images/cms/cms_grey_cancel_box.png" onClick="parent.$.modal().close();" class="navbuttons"/>&nbsp;&nbsp; 
<img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('2','<? echo $_GET['type'];?>');" class="navbuttons"/>&nbsp;&nbsp;<img src="http://www.wevolt.com/images/cms/cms_grey_save_box.png" onClick="submit_form('finish','<? echo $_GET['type'];?>');" class="navbuttons" />
<? }?>
</div>

<input type="hidden" name="txtFriendType" value="<? echo $_GET['type'];?>"/>
<? if ($_GET['step'] != '2') {?>
<input type="hidden" name="txtUpdates" value="<? echo $UpdateString;?>"/>

<? } else if ($_GET['step'] != '3') {?>
      <input type="hidden" name="start_time" value="<? if ($_REQUEST['start_time'] != '') echo $_REQUEST['start_time']; else if ($EventArray->start != '') echo date('h:i:s', strtotime($EventArray->start));?>">
     <input type="hidden" name="start_date" value="<? if ($_REQUEST['start_date'] != '') echo $_REQUEST['start_date']; else if ($EventArray->start != '') echo date('Y-m-d', strtotime($EventArray->start));?>">
      <input type="hidden" name="end_time" value="<? if ($_REQUEST['end_time'] != '') echo $_REQUEST['end_time']; else if ($EventArray->end != '') echo  date('h:i:s', strtotime($EventArray->end));?>">
      <input type="hidden" name="end_date" value="<? if ($_REQUEST['end_date'] != '') echo $_REQUEST['end_date']; else if ($EventArray->end != '') echo date('Y-m-d', strtotime($EventArray->end));?>">
      
       <input type="hidden" name="frequency" value="<?php if ($_REQUEST['frequency'] != '') echo $_REQUEST['frequency']; else if ($EventArray->frequency != '') echo $EventArray->frequency;?>" />
       <input type="hidden" name="interval" value="<?php if ($_REQUEST['interval'] != '') echo $_REQUEST['interval']; else if ($EventArray->event_interval != '') echo $EventArray->event_interval;?>" />
       <input type="hidden" name="custom" value="<?php if ($_REQUEST['custom'] != '') echo $_REQUEST['custom']; else if ($EventArray->custom != '') echo $EventArray->custom;?>" />
       <input type="hidden" name="week_number" value="<?php if ($_REQUEST['week_number'] != '') echo $_REQUEST['week_number']; else if ($EventArray->week_number != '') echo $EventArray->week_number;?>" />
       <input type="hidden" name="week_day" value="<?php if ($_REQUEST['week_day'] != '') echo @implode(',', $_REQUEST['week_day']); else if ($EventArray->week_day != '') echo $EventArray->week_day;?>" />
      
      <input id="txtTagline" name="txtTagline" value="<? echo $_POST['txtTagline'];?>" type="hidden">
      <input id="txtReminder" name="txtReminder"  value="<? echo $_POST['txtReminder'];?>" type="hidden">

<? }?>
<input type="hidden" name="HasReminder" id="HasReminder" value="<? echo $HasReminder;?>">
<input type="hidden" name="FriendName" id="FriendName" value="<? echo $FriendName;?>">
<input type="hidden" name="NoEnd" id="NoEnd" value="<? if ($_POST['NoEnd'] != '') echo $_POST['NoEnd'];?>">
</form>
</body>
</html>