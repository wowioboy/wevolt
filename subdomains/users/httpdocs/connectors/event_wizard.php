<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
include $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';


function statedropdown() {
$ARRAY_STATES		    = array();
$ARRAY_STATES["AL"]	= "AL";
$ARRAY_STATES["AK"]	= "AK";
$ARRAY_STATES["AZ"]	= "AZ";
$ARRAY_STATES["AR"]	= "AR";
$ARRAY_STATES["CA"]	= "CA";
$ARRAY_STATES["CO"]	= "CO";
$ARRAY_STATES["CT"]	= "CT";
$ARRAY_STATES["DE"]	= "DE";
$ARRAY_STATES["DC"]	= "DC";
$ARRAY_STATES["FL"]	= "FL";
$ARRAY_STATES["GA"]	= "GA";
$ARRAY_STATES["HI"]	= "HI";
$ARRAY_STATES["ID"]	= "ID";
$ARRAY_STATES["IL"]	= "IL";
$ARRAY_STATES["IN"]	= "IN";
$ARRAY_STATES["IA"]	= "IA";
$ARRAY_STATES["KS"]	= "KS";
$ARRAY_STATES["KY"]	= "KY";
$ARRAY_STATES["LA"]	= "LA";
$ARRAY_STATES["ME"]	= "ME";
$ARRAY_STATES["MD"]	= "MD";
$ARRAY_STATES["MA"]	= "MA";
$ARRAY_STATES["MI"]	= "MI";
$ARRAY_STATES["MN"]	= "MN";
$ARRAY_STATES["MS"]	= "MS";
$ARRAY_STATES["MO"]	= "MO";
$ARRAY_STATES["MT"]	= "MT";
$ARRAY_STATES["NE"]	= "NE";
$ARRAY_STATES["NV"]	= "NV";
$ARRAY_STATES["NH"]	= "NH";
$ARRAY_STATES["NJ"]	= "NJ";
$ARRAY_STATES["NM"]	= "NM";
$ARRAY_STATES["NY"]	= "NY";
$ARRAY_STATES["NC"]	= "NC";
$ARRAY_STATES["ND"]	= "ND";
$ARRAY_STATES["OH"]	= "OH";
$ARRAY_STATES["OK"]	= "OK";
$ARRAY_STATES["OR"]	= "OR";
$ARRAY_STATES["PA"]	= "PA";
$ARRAY_STATES["RI"]	= "RI";
$ARRAY_STATES["SC"]	= "SC";
$ARRAY_STATES["SD"]	= "SD";
$ARRAY_STATES["TN"]	= "TN";
$ARRAY_STATES["TX"]	= "TX";
$ARRAY_STATES["UT"]	= "UT";
$ARRAY_STATES["VT"]	= "VT";
$ARRAY_STATES["VA"]	= "VA";
$ARRAY_STATES["WA"]	= "WA";
$ARRAY_STATES["WV"]	= "WV";
$ARRAY_STATES["WI"]	= "WI";
$ARRAY_STATES["WY"]	= "WY";
$StateString .= '<OPTION VALUE="">--</option>';
foreach ($ARRAY_STATES as $value) {
    $StateString .= '<OPTION VALUE="'.$value.'">'.$value;
}

return $StateString;

}


function convert_datetime($str) 
{

list($date, $time) = explode(' ', $str);
list($year, $month, $day) = explode('-', $date);
list($hour, $minute, $second) = explode(':', $time);

$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

return $timestamp;
}
function hourmin($id ,$pval = "")
{
	$times = array('00:00:00' => '12:00 am',
					'00:15:00' => '12:15 am',
				   '00:30:00' => '12:30 am',
				   '00:45:00' => '12:45 am',
				   '01:00:00' => '1:00 am',
				   '01:15:00' => '1:15 am',
				   '01:30:00' => '1:30 am',
				   '01:45:00' => '1:45 am',
					'02:00:00' => '2:00 am',
					'02:15:00' => '2:15 am',
					'02:30:00' => '2:30 am',
					'02:45:00' => '2:45 am',
				    '03:00:00' => '3:00 am',
					'03:30:00' => '3:30 am',
					'04:00:00' => '4:00 am',
					'04:30:00' => '4:30 am',
					'05:00:00' => '5:00 am',
					'05:30:00' => '5:30 am',
					'06:00:00' => '6:00 am',
					'06:30:00' => '6:30 am',
					'07:00:00' => '7:00 am',
	'07:30:00' => '7:30 am',
	'08:00:00' => '8:00 am',
	'08:30:00' => '8:30 am',
	'09:00:00' => '9:00 am',
	'09:30:00' => '9:30 am',
	'10:00:00' => '10:00 am',
	'10:30:00' => '10:30 am',
	'11:00:00' => '11:00 am',
	'11:30:00' => '11:30 am',
	'12:00:00' => '12:00 pm',
	'12:30:00' => '12:30 pm',
	'13:00:00' => '1:00 pm',
	'13:30:00' => '1:30 pm',
	'14:00:00' => '2:00 pm',
	'14:30:00' => '2:30 pm',
	'15:00:00' => '3:00 pm',
	'15:30:00' => '3:30 pm',
	'16:00:00' => '4:00 pm',
	'16:30:00' => '4:30 pm',
	'17:00:00' => '5:00 pm',
	'17:30:00' => '5:30 pm',
	'18:00:00' => '6:00 pm',
	'18:30:00' => '6:30 pm',
	'19:00:00' => '7:00 pm',
	'19:30:00' => '7:30 pm',
	'20:00:00' => '8:00 pm',
	'20:30:00' => '8:30 pm',
	'21:00:00' => '9:00 pm',
	'21:30:00' => '9:30 pm',
	'22:00:00' => '10:00 pm',
	'22:30:00' => '10:30 pm',
	'23:00:00' => '11:00 pm',
	'23:30:00' => '11:30 pm');
	$out = '<select name="'.$id.'">';
	$out .="<option value=\"\"";
	if ($pval == '')
			$out.= " selected ";
		$out .= ">-set-</option>"; 
	foreach ($times as $actual => $display) {
		$out .= "<option value=\"$actual\"";
		if ($pval == $actual)
			$out.= " selected ";
		$out .= ">$display</option>";
	}
	$out .= '</select>';
	return $out;
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



$Action = $_REQUEST['action'];
if ($Action == '')
	$Action = $_REQUEST['a'];
	

$EventID = $_REQUEST['id'];
if ($EventID == '')
	$EventID = $_REQUEST['e'];
if ($EventID == '')
	$EventID = $_REQUEST['txtItem'];
	
$RePost = 0;
$DB = new DB();
$query = "select * from users where encryptid='$UserID'"; 
$UserArray = $DB->queryUniqueObject($query);

if (($_REQUEST['a'] == 'edit') || ($_REQUEST['task'] == 'edit') && ($_REQUEST['step'] == '')) {
	$query = "SELECT c.*,p.promo_code,p.xp
	          from calendar as c
			  left join promotion_codes as p on p.cal_id=c.id
			  where c.encrypt_id='$EventID' and c.user_id='".$_SESSION['userid']."'";
	$EventArray = $DB->queryUniqueObject($query);
	$CalID = $EventArray->id;
	$SelectedGroups = @explode($EventArray->selected_groups);
	$UserID = $EventArray->user_id;
}
if (($UserID == '') && ($_REQUEST['task'] == 'edit'))
	$UserID = $_POST['u'];
if ($SelectedGroups == null)
	$SelectedGroups = $_POST['txtGroups'];
	
$query = "SELECT count(*) from calendar where type='promotion' and end>'".date('Y-m-d 00:00:00')."'";
$TotalPromos = $DB->queryUniqueValue($query);

if (is_array($SelectedGroups)) {
	$GroupList =@implode(",",$SelectedGroups);
} else if ($_REQUEST['step'] != '') {
	
	$GroupList = $_REQUEST['txtGroups'];
	$SelectedGroups = @explode(',',$GroupList);		
}
if ($SelectedGroups == null)
	$SelectedGroups = array();
$query = "select  * from user_groups where UserID='$UserID'"; 
$DB->query($query);

$GroupSelect = '<select name="txtGroups[]" size="3" multiple style="height:35px;">';
while($line = $DB->fetchNextObject()) {
	$GroupSelect .= '<option value="'.$line->ID.'"';
	if (in_array($line->ID,$SelectedGroups))
		$GroupSelect .= ' selected '; 
	$GroupSelect .='>'.$line->Title.'<option>';	
}
$GroupSelect .= '</select>';

$CloseWindow = 0 ;

if (($_SESSION['userid'] == '') || ((($_REQUEST['a'] == 'edit') || ($_REQUEST['task'] == 'edit')) && ($UserID != $_SESSION['userid'])))
	$Auth = 0;
else 
	$Auth = 1;

if ($_GET['step'] == 1)
	$SelectedDays = @explode(',',$_POST['week_day']);

//if (($_REQUEST['save'] =='1') && ($_REQUEST['step'] == 'add_exit')) { 
if (($_REQUEST['step'] == 'add_exit') || ($_REQUEST['step'] == 'save')){ 
	if (!$task = $_REQUEST['task']) {
		$task = 'new';
	}
	if (($_REQUEST['a'] == 'edit') || ($_REQUEST['task'] == 'edit'))
		$task='edit';
		
		//print_r($_POST);
		//print 'GROUP LIST = ' . $GroupList;
		$CalID = $_REQUEST['txtCal'];
		$Title = mysql_real_escape_string($_REQUEST['txtTitle']);
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
		$StartDate = $_REQUEST['start_date'] . ' '.  $_REQUEST['start_time'];
   	    $EndDate = $_REQUEST['end_date'] . ' ' . $_REQUEST['end_time']; 
		if ($EventType == 'promotion') {
				$d2=mktime($EndDate);
				$d1=mktime($StartDate);
				$DaysTotal = floor(($d2-$d1)/86400);
				if ($DaysTotal > 31) {
					$EndDate = date("Y-m-d 00:00:00",strtotime("+1 months"));	
				}
		}
		
		
		if ($Thumb == '')
			$Thumb = $_SESSION['avatar'];
			
		$Link = $_REQUEST['txtLink'];
		$EventType = $_REQUEST['type'];
		$ContentID = $_REQUEST['ContentID'];
		$ContentType = $_REQUEST['ContentType'];
		if ($Privacy == '')
			$Privacy = 'private';
			
		$frequency = $_REQUEST['frequency'];
		$interval = $_REQUEST['interval'];
		$custom = $_REQUEST['custom'];
		$week_number = $_REQUEST['week_number'];
		$week_day = $_REQUEST['week_day'];
		$ShowList = $_POST['show_list'];
		if ($_POST['invite'] != 1) 
			$ShowList = 0;
		
		if (is_array($_REQUEST['week_day']))
			@implode(',',$_REQUEST['week_day']);
		
		if (($task == 'new')||($task == 'add')) {
		
			$query = "INSERT into calendar (title, description, `start`, `end`, user_id, content_id, content_type, `type`, privacy_setting, url, location, contact_name, contact_phone,contact_email, address, address2, city, state, zip, tags, created_date, more_info, use_wemail, thumb, frequency, `interval`, custom, week_day, week_number,selected_groups,show_start_time,show_end_time,show_list,no_end) 
			                        values ('$Title','$Description','$StartDate','$EndDate','$UserID','$ContentID', '$ContentType','$EventType','$Privacy', '$Link', '$Location','$ContactName', '$ContactPhone', '$ContactEmail','$Address','$Address2', '$City', '$State', '$Zip', '$Tags','$CreatedDate','$MoreInfo','$UseWemail','$Thumb','$frequency', '$interval', '$custom', '$week_day', '$week_number','$GroupList','".$_POST['start_set']."','".$_POST['end_set']."','".$ShowList."','".$_POST['NoEnd']."')";
			$DB->execute($query);
    		$output .= $query.'<br/>';	
			$query = "SELECT id from calendar where created_date='$CreatedDate' and user_id='$UserID'";
			$CalID = $DB->queryUniqueValue($query);
			$output .= $query.'<br/>';	
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
						$EncCalID = $Encryptid;
					}
					$Inc++;
			}

				if ((($EventType == 'event') || ($EventType == 'promotion')) &&($Privacy != 'private')) {
					$query ="SELECT ID from pf_forum_categories WHERE UserID='".$_SESSION['userid']."' and EventCat=1";
					$CatExists = $DB->queryUniqueValue($query);
			$output .= $query.'<br/>';	
					if ($CatExists == '') {
						$query ="SELECT Position from pf_forum_categories WHERE Position=(SELECT MAX(Position) FROM pf_forum_categories where UserID='".$_SESSION['userid']."')";
						$NewPosition = $DB->queryUniqueValue($query);
						$NewPosition++;
						$output .= $query.'<br/>';	
						$query = "INSERT into pf_forum_categories (UserID, Title, Description, Position, CreatedDate, EventCat) values ('".$_SESSION['userid']."', 'Events','The Forum for ".trim($_SESSION['username'])."s Events and Promotions','$NewPosition','$CreatedDate',1)";
						$DB->execute($query);
						$output .= $query.'<br/>';	
						$query ="SELECT ID from pf_forum_categories WHERE CreatedDate='$CreatedDate' and UserID='".$_SESSION['userid']."'";
						$CatID = $DB->queryUniqueValue($query);
						$output .= $query.'<br/>';	
						$Encryptid = substr(md5($CatID), 0, 15).dechex($CatID);
						$IdClear = 0;
						$Inc = 5;
						while ($IdClear == 0) {
							$query = "SELECT count(*) from pf_forum_categories where EncryptID='$Encryptid'";
							$Found = $DB->queryUniqueValue($query);
							$output .= $query.'<br/>';
							if ($Found == 1) {
								$Encryptid = substr(md5(($CatID+$Inc)), 0, 15).dechex($CatID+$Inc);
							} else {
								$query = "UPDATE pf_forum_categories SET EncryptID='$Encryptid' WHERE ID='$CatID'";
								$DB->execute($query);
								$output .= $query.'<br/>';
								$IdClear = 1;
							}
							$Inc++;
						}
						$output .= $query.'<br/>';	
					} else {
						$CatID = $CatExists;
					
					}
			
					$query = "INSERT into pf_forum_boards (UserID, CatID, Title, Description, Position, CreatedDate, PrivacySetting,EventBoard,EventID) values ('".$_SESSION['userid']."', $CatID,'Event - $Title','General Discussion board for ".$_SESSION['username']."s event',1,'$CreatedDate','private',1,'$ModuleID')";
					$DB->execute($query);
					$output .= $query.'<br/>';	
					
					$query ="SELECT ID from pf_forum_boards WHERE CreatedDate='$CreatedDate' and UserID='".$_SESSION['userid']."'";
					$NewID = $DB->queryUniqueValue($query);
					
					$Encryptid = substr(md5($NewID), 0, 15).dechex($NewID);
					$IdClear = 0;
					$Inc = 5;
					while ($IdClear == 0) {
						$query = "SELECT count(*) from pf_forum_boards where EncryptID='$Encryptid'";
						$Found = $DB->queryUniqueValue($query);
						$output .= $query.'<br/>';
						if ($Found == 1) {
							$Encryptid = substr(md5(($NewID+$Inc)), 0, 15).dechex($NewID+$Inc);
						} else {
							$query = "UPDATE pf_forum_boards SET EncryptID='$Encryptid' WHERE ID='$NewID'";
							$DB->execute($query);
							$output .= $query.'<br/>';
							$IdClear = 1;
						}
						$Inc++;
					}
					$output .= $query.'<br/>';	

			}
			
			if ((($EventType == 'event') || ($EventType == 'promotion')) &&($Privacy != 'private'))
				$ouput .= insertUpdate($EventType, 'created', $EncCalID, 'user', $UserID,'http://www.wevolt.com/view_event.php?action=view&id='.$CalID,'',$_REQUEST['txtTitle']);
			
			
			if ($EventType == 'promotion') {
				
				if ($_POST['txtPromoCode'] != '') {
				
					if (strlen($_POST['txtPromoCode']) > 5){
							
						if  (ereg("[^A-Za-z0-9]",$_POST['txtPromoCode'])) {
								$Erorr = 'Bad Characters';
						} else {
						$query ="INSERT into promotion_codes (user_id, promo_code, cal_id, project_id, xp) values ('".$_SESSION['userid']."', '".mysql_real_escape_string($_POST['txtPromoCode'])."','$CalID', '$ContentID', '500')";	
					$DB->execute($query);
					$output .= $query.'<br/>';	
						}
					}
				}
			}
					
		} else if ($task == 'edit') {
			
			$query = "UPDATE calendar set 
							title='$Title', 
							description='$Description', 
							`start`='$StartDate', 
							`end`='$EndDate', 
							content_id='$ContentID', 
							content_type='$ContentType', 
							privacy_setting='$Privacy', 
							url='$Link', 
							location='$Location', 
							contact_name='$ContactName', 
							contact_phone='$ContactPhone',
							contact_email='$ContactEmail', 
							address='$Address', 
							address2='$Address2', 
							city='$City', 
							state='$State', 
							zip='$Zip', 
							tags='$Tags', 
							updated_date='$CreatedDate',
							thumb='$Thumb',
							more_info='$MoreInfo', 
							use_wemail='$UseWemail',
							frequency='$frequency',
							`interval`='$interval',
							custom='$custom',
							week_number='$week_number',
							week_day='$week_day',
							no_end='".$_POST['NoEnd']."',
							selected_groups='$GroupList' ,
							show_start_time='".$_POST['start_set']."',
							show_end_time='".$_POST['end_set']."',
							show_list='".$_POST['publish_list']."'
							where encrypt_id='$ItemID' and user_id='".$_SESSION['userid']."'";
			
			$DB->execute($query);
//			print $query.'<br/>';	
			
		
		}
		if ($_POST['invite'] == 1) {
					
			$Invites = @explode(',',$_POST['currentinvites']);
			$Uninvites =@explode(',',$_POST['currentuninvites']);
			 
			if ($Invites == null)
				$Invites = array();
			
			if ($Uninvites == null)
				$Uninvites = array();
			
			if ($_REQUEST['invite_self'] == 1) {
					$query = "SELECT count(*) from pf_events_invitations where UserID='".$_SESSION['userid']."' and CalID='$CalID'";
					$Found = $DB->queryUniqueValue($query);
					if ($Found == 0) {
						$query = "INSERT into pf_events_invitations 
									(UserID, Status,CalID, CreatedDate) values 
									('".$_SESSION['userid']."','attending','$CalID','$CreatedDate')"; 
						//print $query.'<br/>';
						$DB->execute($query);
					} else {
						$query = "UPDATE pf_events_invitations set Status='attending', CreatedDate='$CreatedDate', where CalID='$CalID' and UserID='".$_SESSION['userid']."'";
						$DB->execute($query);
					//	print $query.'<br/>';
					}
			}
			foreach ($Uninvites as $user) {
						
					$query = "SELECT encryptid from users where username='$user'";
					$ID = $DB->queryUniqueValue($query);
					$query = "DELETE from pf_events_invitations where UserID='$ID' and CalID='$CalID'";
					$DB->execute($query);
					print $query;
			}
				
			foreach ($Invites as $user) {
					if ($user != '') {
					$query = "SELECT count(*) from pf_events_invitations where UserID='$user' and CalID='$CalID'";
					$Found = $DB->queryUniqueValue($query);
					//print $query.'<br/>';
					if ($Found == 0) {
						$query = "INSERT into pf_events_invitations 
									(UserID, Status,CalID, CreatedDate) values 
									('$user','invited','$CalID','$CreatedDate')"; 
						//print $query.'<br/>';
						$DB->execute($query);
					} else {
						$query = "UPDATE pf_events_invitations set Status='invited', CreatedDate='$CreatedDate', where CalID='$CalID' and UserID='$user'";
						$DB->execute($query);
					//	print $query.'<br/>';
					}
					
												
						$query = "SELECT username, email from users where encryptid='$user'";
						$UserArray = $DB->queryUniqueObject($query);
						$Email = $UserArray->email;
						$Username = $UserArray->username;
						
						$header = "From: NO-REPLY@wevolt.com  <NO-REPLY@wevolt.com >\n";
						$header .= "Reply-To: NO-REPLY@wevolt.com <NO-REPLY@wevolt.com>\n";
						$header .= "X-Mailer: PHP/" . phpversion() . "\n";
						$header .= "X-Priority: 1";
	
					//SEND USER EMAIL
						$PageLink = 'http://www.wevolt.com/view_event.php?id='.$CalID.'&action=view';
						$to = $Email;
						$subject = $_SESSION['username'].' has invited you to an event on WEvolt';
						$wesubject = $_SESSION['username'].' has invited you to an event on WEvolt';
						$body .= $_SESSION['username']." has invited you to an event on WEvolt\n\nClick here to view the event: ".$PageLink; 
						$WemailBody = $_SESSION['username']." has invited you to an event on WEvolt\n\nClick here to view the event:\n\n<a href=\"javascript:void(0)\" onclick=\"parent.window.location.href='".$PageLink."';\">".$PageLink."</a>"; 
						 mail($to, $subject, $body, $header);
						$DateNow = date('m-d-Y');
						$query = "INSERT into panel_panel.messages 
										(userid, sendername, senderid, subject, message, date) 
										values 
										('$user','".$_SESSION['username']."','".$_SESSION['userid']."','$wesubject','".mysql_real_escape_string($WemailBody)."','$DateNow')";
						$DB->execute($query);					
						//print $query.'<br/>';
					}
			}
			
				
				
				
			}
		//header("Location:/myvolt/".trim($_SESSION['username'])."/?t=calendar");
	//if ($_SESSION['username'] != 'matteblack')
	$CloseWindow=1;
	//else
	//print $output;	
	
}
$DB->close();
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
function closeWindow() 
{
	var href = parent.window.location.href;
	href = href.split('#');
	href = href[0];
	parent.window.location = href;
}
<?php if (($CloseWindow == 1) || ($Auth == 0)) : ?>
closeWindow();
<?php endif; ?>
$(document).ready(function() {
	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd'
	});
});
</script>
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">


<script language="JavaScript" type="text/javascript" src="http://www.wevolt.com/ajax/ajax_init.js"></script>
<script type="text/javascript">
<? if ($_GET['step'] == '3') {?>
var section = 'users';
<? } else if ($_REQUEST['type'] == 'promotion') {?>
var section = 'promo';
<? } else {?>
var section = 'all';
<? }?>
function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 
 document.getElementById("search_results").innerHTML=xmlHttp.responseText;
 document.getElementById('search_container').style.display='';

 } 
}
function display_data(keywords) {

    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null) {
        alert ("Your browser does not support AJAX!");
        return;
    }
	if (document.modform.txtContent != null)
		 var content =  document.modform.txtContent.value;
	else
		content = 'codes';
		
    if (section == 'users')
	 var url="/connectors/getUserResults.php";
	 else if (section == 'promo')
	 var url="/connectors/getPromoResults.php";
	 else
    var url="/connectors/getSearchResults.php";
    url=url+"?content="+content+"&keywords="+escape(keywords)+"&section="+section;
	
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete") {
            document.getElementById('search_results').innerHTML=xmlhttp.responseText;
			document.getElementById('search_container').style.display='';
        }
    }
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}	
var timer = null;
function checkIt(keywords) {

    if (timer) window.clearTimeout(timer); // If a timer has already been set, clear it
    timer = window.setTimeout(display_data(keywords), 2000); // Set it for 2 seconds
    //Just leave the method and let the timer do the rest...
}

 function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
 
 function setDefault(theText) 
{
     if (theText.value == "")
 {
         theText.value = theText.defaultValue;
     }
 }
 


function rolloveractive(tabid, divid) {
	var divstate = document.getElementById(divid).style.display;
		if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='tabhover';
		} 
}

function rolloverinactive(tabid, divid) {
		if (document.getElementById(divid).style.display != '') {
			document.getElementById(tabid).className ='tabinactive';
		} 
}

function submit_form(step, task, type) {

		var formaction = '/connectors/event_wizard.php?step='+step+'&task='+task+'&type='+type;
	//	alert(formaction);
	document.modform.action = formaction; 
	document.modform.submit();

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

 <? if ($_REQUEST['step'] == 2) {?>
function select_link(value) {

	if (value == 'search') {
		
		document.getElementById("searchupload").style.display = '';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favupload").style.display = 'none';
		document.getElementById("linktargetdiv").style.display = 'none';
		
		if (document.getElementById("searchtab") != null)
			document.getElementById("searchtab").className ='tabactive';
		if (document.getElementById("urltab") != null)
			document.getElementById("urltab").className ='tabinactive';
		if (document.getElementById("mytab") != null)
			document.getElementById("mytab").className ='tabinactive';
		if (document.getElementById("favtab") != null)
			document.getElementById("favtab").className ='tabinactive';
		
		
	} else if (value == 'url') {
		if (document.getElementById("searchupload") != null)
			document.getElementById("searchupload").style.display = 'none';
		if (document.getElementById("urlupload") != null)
			document.getElementById("urlupload").style.display = '';
		if (document.getElementById("linktargetdiv") != null)
			document.getElementById("linktargetdiv").style.display = '';
		if (document.getElementById("myupload") != null)
			document.getElementById("myupload").style.display = 'none';
		if (document.getElementById("favupload") != null)
			document.getElementById("favupload").style.display = 'none';
		
		if (document.getElementById("searchtab") != null)
			document.getElementById("searchtab").className ='tabinactive';
		if (document.getElementById("urltab") != null)
			document.getElementById("urltab").className ='tabactive';
		if (document.getElementById("mytab") != null)
			document.getElementById("mytab").className ='tabinactive';
		if (document.getElementById("favtab") != null)
			document.getElementById("favtab").className ='tabinactive';
		
		
	} else if (value == 'my') {
	
		document.getElementById("searchupload").style.display = 'none';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("myupload").style.display = '';
		document.getElementById("favupload").style.display = 'none';
		document.getElementById("linktargetdiv").style.display = 'none';
		
		if (document.getElementById("searchtab") != null)
			document.getElementById("searchtab").className ='tabinactive';
		if (document.getElementById("urltab") != null)
			document.getElementById("urltab").className ='tabinactive';
		if (document.getElementById("mytab") != null)
			document.getElementById("mytab").className ='tabactive';
		if (document.getElementById("favtab") != null)
			document.getElementById("favtab").className ='tabinactive';
	
		
		
	} else if (value == 'fav') {
		document.getElementById("searchupload").style.display = 'none';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favupload").style.display = '';
		document.getElementById("linktargetdiv").style.display = 'none';
		
		if (document.getElementById("searchtab") != null)
			document.getElementById("searchtab").className ='tabinactive';
		if (document.getElementById("urltab") != null)
			document.getElementById("urltab").className ='tabinactive';
		if (document.getElementById("mytab") != null)
			document.getElementById("mytab").className ='tabinactive';
		if (document.getElementById("favtab") != null)
			document.getElementById("favtab").className ='tabactive';
		
	}




}

function set_content(title, contentid, contentlink, contentthumb,contenttype,description,tags) {
		select_link('url');
		
		if (document.getElementById("contentmenu") != null)
			document.getElementById("contentmenu").style.display = 'none';
		if (document.getElementById("ContentType") != null)	
			document.getElementById("ContentType").value = contenttype;
		if (document.getElementById("ContentID") != null)	
			document.getElementById("ContentID").value = contentid;
		if (document.getElementById("txtInfo") != null)
			document.getElementById("txtInfo").value = description;
		if (document.getElementById("txtTags") != null)	
			document.getElementById("txtTags").value = tags;
		if (document.getElementById("txtLink") != null)
			document.getElementById("txtLink").value = contentlink;
		if (document.getElementById("thumbdisplay") != null)
			document.getElementById("thumbdisplay").style.display = '';
		if (document.getElementById("itemthumb") != null)
			document.getElementById("itemthumb").src = contentthumb;
		if (document.getElementById("txtThumb") != null)
			document.getElementById("txtThumb").value = contentthumb;
		if (document.getElementById("thumbselect") != null)
			document.getElementById("thumbselect").style.display = 'none';
		if (document.getElementById("search_container") != null)	
			document.getElementById("search_container").style.display = 'none';
		if (document.getElementById("search_results") != null)	
			document.getElementById("search_results").innerHTML = '';
		if (document.getElementById("resetformdiv") != null)
			document.getElementById("resetformdiv").style.display = '';
		if (document.getElementById("changeimagediv") != null)
			document.getElementById("changeimagediv").style.display = 'none';
		if (document.getElementById("urltitle") != null)
			document.getElementById("urltitle").style.display = 'none';
		if (document.getElementById("linktargetdiv") != null)
			document.getElementById("linktargetdiv").style.display = 'none';
		if (document.getElementById("searchupload") != null)
			document.getElementById("searchupload").style.display = 'none';
		if (document.getElementById("myupload") != null)
		    document.getElementById("myupload").style.display = 'none';
		if (document.getElementById("favupload") != null)
		    document.getElementById("favupload").style.display = 'none';
		if (document.getElementById("search_container") != null)
			document.getElementById("search_container").style.display = 'none';
		if (document.getElementById("search_results") != null)
			document.getElementById("search_results").innerHTML = '';

}
function reset_form() {
	select_link('url');
		
		if (document.getElementById("ContentType") != null)	
			document.getElementById("ContentType").value = contenttype;
		if (document.getElementById("ContentID") != null)	
			document.getElementById("ContentID").value = contentid;
		if (document.getElementById("txtInfo") != null)
			document.getElementById("txtInfo").value = description;
		if (document.getElementById("txtTags") != null)	
			document.getElementById("txtTags").value = tags;
		if (document.getElementById("txtLink") != null)
			document.getElementById("txtLink").value = contentlink;
		if (document.getElementById("thumbdisplay") != null)
			document.getElementById("thumbdisplay").style.display = 'none';	
		if (document.getElementById("urltitle") != null)		
		if (document.getElementById("contentmenu") != null)
			document.getElementById("contentmenu").style.display = '';
		if (document.getElementById("ContentType") != null)		
			document.getElementById("ContentType").value = '';
		if (document.getElementById("ContentID") != null)	
			document.getElementById("ContentID").value = '';
		if (document.getElementById("txtBlurb") != null)	
			document.getElementById("txtBlurb").value = '';
		if (document.getElementById("txtComment") != null)	
			document.getElementById("txtComment").value = '';
		if (document.getElementById("txtTags") != null)	
			document.getElementById("txtTags").value = '';
		if (document.getElementById("txtLink") != null)	
			document.getElementById("txtLink").value = '';
		if (document.getElementById("urltitle") != null)	
			document.getElementById("urltitle").style.display = '';
		if (document.getElementById("itemthumb") != null)	
			document.getElementById("itemthumb").src = '';
		if (document.getElementById("txtThumb") != null)	
			document.getElementById("txtThumb").value = '';
	
}
 
function change_thumb() {
		if (document.getElementById("thumbdisplay") != null)
			document.getElementById("thumbdisplay").style.display = 'none';	
		if (document.getElementById("itemthumb") != null)	
			document.getElementById("itemthumb").src = '';
		if (document.getElementById("txtThumb") != null)	
			document.getElementById("txtThumb").value = '';
		if (document.getElementById("thumbselect") != null)	
			document.getElementById("thumbselect").style.display = '';


}




/*
function set_content(title,contentid,contenttype,contentthumb) {
		
		//ERROR FROM HERE SOMEWHERE
	
		document.getElementById("ContentType").value = contenttype;
		document.getElementById("ContentID").value = contentid;
	document.getElementById("changelink").style.display = 'none';
		document.getElementById("SelectedTitle").innerHTML = title;
		
			
			document.getElementById("thumbselect").style.display = 'none';
			document.getElementById("thumbdisplay").style.display = '';
			document.getElementById("itemthumb").src = contentthumb;
			document.getElementById("txtThumb").value = contentthumb;
			document.getElementById("search_results").innerHTML = '';
			document.getElementById("search_container").style.display = 'none';
			
		
}

*/
 
<? }?>
<? if ($_GET['step'] == '3') {?>
var itemnum = 1;
function set_user(username, avatar, type,uid) {
	var html;
	var formgood = 0;
	var userok = 1;
	itemnum = itemnum+1;
	
	var newpass = '<a href="javascript:void(0);" onclick="remove_user(\''+uid+'\',\''+type+'\',\'userselected_'+itemnum+'\');"><img src="'+avatar+'" tooltip="'+username+'" vspace="5" hspace="5" style="border:2px #ff0000 solid;" width="50" height="50" id="userselected_'+itemnum+'"></a>';
	
	var currentinvites = document.getElementById("currentinvites").value;
	var currentinvitesArray = currentinvites.split(',');
	var currentsetinvites = document.getElementById("currentsetinvites").value;
		
	var currentsetinvitesArray = currentsetinvites.split(',');
   var arLen=currentsetinvitesArray.length;
				
				for ( var i=0, len=arLen; i<len; ++i ){
					if (uid == currentsetinvitesArray[i]) {
						userok = 0;
						alert('This user already has an invitation');
						break;	
					}
					
				}
				var arLen=currentinvitesArray.length;
				for ( var i=0, len=arLen; i<len; ++i ){
					if (uid == currentinvitesArray[i]) {
						userok = 0;
						alert('This user is already selected to get an invitation');
						break;	
					}
					
				}
				if (userok == 1) {
					
						formgood = 1;
					
						html = document.getElementById("invites_div").innerHTML;
						
						if (currentinvites == '')
							currentinvites = uid;
						else 
							currentinvites +=','+uid;
						document.getElementById("currentinvites").value = currentinvites;
						
						var divtarget = 'invites_div';
					
	
					   if (formgood == 1) {
							html += newpass;
							document.getElementById(divtarget).innerHTML = html;
							document.getElementById("savealert").style.display = 'block';
					   }
				}
		
}
function remove_user(uid, type, element) {
	document.getElementById(element).style.display='none';
	var currentinvites = document.getElementById("currentinvites").value;
	var currentinvitesArray = currentinvites.split(',');
	var currentinvites_temp;
	var arLen=currentinvitesArray.length;
			for ( var i=0, len=arLen; i<len; ++i ){
				if (uid != currentinvitesArray[i]) {
					if (currentinvites_temp == '')
						currentinvites_temp = currentinvitesArray[i];
					else 
						currentinvites_temp +=','+currentinvitesArray[i];
				}
					
			}
			document.getElementById("currentinvites").value = currentinvites_temp;
			document.getElementById("savealert").style.display = 'block';
}
function uninvite_user(uid, element) {
	var answer = confirm("Are you sure you want to uninvite "+uid+"?");
	if (answer) {
		document.getElementById(element).style.display='none';
		var currentuninvites = document.getElementById("currentuninvites").value;

		if (currentuninvites == '')
			currentuninvites = uid;
		else 
			currentuninvites +=','+uid;
		document.getElementById("currentuninvites").value = currentuninvites;
		document.getElementById("savealert").style.display = 'block';
		//alert(document.getElementById("currentuninvites").value);
			
	}
}
<? }?>
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

function toggle_groups(value) {
	
	if (value == 'groups')
		document.getElementById("group_select").style.display = '';
	else
		document.getElementById("group_select").style.display = 'none';
	
}

function toggle_time(id, action) {
		if (action == 'on') {
			document.getElementById('set'+id+'time').style.display = 'none';
			document.getElementById(id+'timeselect').style.display = '';
			document.getElementById(id+'_set').value = '1';
		} else {
			document.getElementById('set'+id+'time').style.display = '';
			document.getElementById(id+'timeselect').style.display = 'none';
			document.getElementById(id+'_set').value = '0';
			
		}
	
}
</script>

                       
                  <div style="background-image:url(http://www.wevolt.com/images/700_bgd.jpg); background-repeat:no-repeat; height:467px; width:700px;" align="center">
<div style="height:10px;"></div>

<table width="608" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="592" align="center">
                                        <img src="http://www.wevolt.com/images/wizard_cal_header.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
      
                           <form name="modform" id="modform" method="post">
                            <? if ((($_REQUEST['step'] == '')|| ($_REQUEST['step'] == 'start')) &&(($_REQUEST['a'] != 'edit')&&($_REQUEST['task'] != 'edit'))){ ?>
                            <div style="height:10px;"></div>
                            <div class="messageinfo_white" align="center">
                           <strong> What would you like to create? </strong>
<div style="height:10px;"></div>

 <table width="680" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="664" align="center">
<table><tr>
<td style="padding:2px;">
<div class="white_box" style="width:160px; height:110px;" align="center">
<div class="blue_button" onClick="submit_form('1','new','event');">EVENT</div>
<div class="spacer"></div><span style="font-size:12px;">
Events are a singular calendar entry. eg: opening day of a movie or a party</span>
</div>
</td>
<td style="padding:2px;">
<div class="white_box" style="width:160px;height:110px;" align="center">
<div class="blue_button" onClick="submit_form('1','new','reminder');">REMINDER</div>
<div class="spacer"></div><span style="font-size:12px;">
Reminders are one-off or ongoing calendar entries. eg: Read Stupid Users or check out Jason's blog.</span>
</div>
</td>
<td style="padding:2px;">

</td>
</tr>
<tr>
<td colspan="3" align="center">
<table><tr>
<td style="padding:2px;"><div class="white_box" style="width:160px;height:110px;" align="center">
<div class="blue_button" onClick="submit_form('1', 'new', 'todo');">TO DO</div>
<div class="spacer"></div><span style="font-size:12px;">
To Do's are personal actions you need to take. eg: Hassle artist for pages or Have script done.</span>
</div>
</td>
<td style="padding:2px;">
<div class="white_box" style="width:160px;height:110px;" align="center">
<div class="blue_button" <? if (($_SESSION['IsPro'] == 1) && ($TotalPromos == 0) || (in_array($_SESSION['userid'],$SiteAdmins))) {?> onClick="submit_form('1', 'new', 'promotion');"<? }?>>PROMOTION</div>
<div class="spacer"></div><span style="font-size:12px;">
<? if ($TotalPromos == 0) {?>
Promotions are one-off events that create EXCITES to mesure anticipation and your marketing<br/>PRO USERS ONLY</span>
<? } else {?>
<div class="messageinfo_warning">
You have a promotion already going, you can buy more or wait until it's over.</div>
<? }?>
</div>
</td>
<? /*
<td style="padding:2px;">
<div class="white_box" style="width:160px;height:110px;" align="center">
<div class="blue_button" onClick="submit_form('2', 'new', 'update');">UPDATE</div>
<div class="spacer"></div><span style="font-size:12px;">
Updates notify you when a specific user or project has updated something.</span>
</div>
</td>*/?>
</tr>
</table>
</td></tr></table>
<div class="spacer"></div>
             </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</div>
                                     
                            <? } else if ((($_REQUEST['step'] == '')|| ($_REQUEST['step'] == 'start')) &&(($_REQUEST['a'] == 'edit')||($_REQUEST['task'] == 'edit')))  {?>
                            
                             <div class="spacer"></div>
                     
                            <table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
                                       <strong> What would you like to edit?</strong>
                                        <div class="spacer"></div>
                                        <div class="messageinfo_white">
                                        <a href="javascript:void(0)" onClick="submit_form('1','edit','<? if ($EventArray->type != '') echo $EventArray->type; else echo $_REQUEST['type'];?>');">Title and Schedule</a> <div class="spacer"></div>
										<a href="javascript:void(0)" onClick="submit_form('2','edit','<? if ($EventArray->type != '') echo $EventArray->type; else echo $_REQUEST['type'];?>');">Details and Content</a> <div class="spacer"></div>
                                       <? if (($EventArray->type == 'event') || ($_REQUEST['type'] == 'event')) {?>
                                        <a href="javascript:void(0)" onClick="submit_form('3','edit','<? if ($EventArray->type != '') echo $EventArray->type; else echo $_REQUEST['type'];?>');">Invite List</a><br />
                                        <? }?>
                                        </div>
                                        
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                            
                            
                            
                            <? } else if ($_REQUEST['step'] == 1)  {?>
                            <div class="spacer"></div>
 <div align="center">

<table width="650" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="634" align="center">




<div id="eventsched" >
<table width="97%" ><tr>
<td class="messageinfo_white" valign="top" width="100">Title:<small>(required)</small></td>
<td><input id="txtTitle" name="txtTitle" style="width:100%;" type="text"  value="<? if ($_REQUEST['txtTitle'] != '') echo $_REQUEST['txtTitle'];?>"></td>
</tr>
<? if (($_REQUEST['type'] == 'todo') || ($_REQUEST['type'] == 'reminder')|| ($_REQUEST['type'] == 'promotion')|| ($_REQUEST['type'] == 'event')) {?> 
<tr>
<td class="messageinfo_white" valign="top" width="100">Description / Tagline</td>
<td><textarea  style="width:100%; height:40px;" name="txtDescription" id="txtDescription" onfocus="doClear(this);"><? if ($_REQUEST['txtDescription'] != '') echo $_REQUEST['txtDescription']; else echo 'Enter A Description';?></textarea></td>
</tr>
<? }?>
<? if ($_REQUEST['type'] == 'event') {?>
<tr>
<td class="messageinfo_white" valign="top">Location:</td>
<td class="messageinfo_white"><input id="txtLocation" name="txtLocation" style="width:100%;" type="text" value="<? if ($_REQUEST['txtLocation'] != '') echo $_REQUEST['txtLocation'];?>"></td>
</tr>
<? }?>
</table>

<table width="97%" cellpadding="0" cellspacing="0">

<?php if ($_REQUEST['type'] =='event') { ?>
<tr><td>
<div style="height:5px;"></div><div class="messageinfo_warning">Detailed Address (optional)</div>
</td></tr>
<tr>
<td valign="top">
<table width="244">
<? if ($_REQUEST['type'] == 'event') {?>
<tr id="addressdiv" >
<td colspan="2">
    <table width="100%">
    <tr><td class="messageinfo_white" width="100">Street Address</td>
    <td class="messageinfo_white"><input id="txtAddress" name="txtAddress" style="width:100%;" value="<? if ($_REQUEST['txtAddress'] != '') echo $_REQUEST['txtAddress'];?>" type="text"></td>
    </tr>
      <tr><td class="messageinfo_white" width="100">Address2</td>
    <td class="messageinfo_white"><input id="txtAddress2" name="txtAddress2" style="width:50%;" value="<? if ($_REQUEST['txtAddress2'] != '') echo $_REQUEST['txtAddress2'];?>" type="text"></td>
    </tr>
    <tr><td class="messageinfo_white">City</td>
    <td class="messageinfo_white"><input id="txtCity" name="txtCity" style="width:100%;" value="<? if ($_REQUEST['txtCity'] != '') echo $_REQUEST['txtCity'];?>" type="text"></td>
    </tr>
    <tr><td class="messageinfo_white">State</td>
    <td class="messageinfo_white">
    <table><tr><td>
    <? $StateString = statedropdown();?>
    <SELECT ID='txtState' NAME='txtState' STYLE='WIDTH:100%;'>
              <? if ($state != '') { echo str_replace($state . '"', $_REQUEST['txtState'] . '" selected', $StateString); } else { echo $StateString;} ?> 
            </SELECT>
     </td>
     <td class="messageinfo_white">Zip</td>
    <td class="messageinfo_white"><input id="txtZip" name="txtZip" style="width:50px;" value="<? if ($_REQUEST['txtZip'] != '') echo $_REQUEST['txtZip'];?>" type="text"></td>
     </tr></table>
            </td>
    </tr>

    </table>

</td>
</tr>
<? }?>
<? if (($_REQUEST['type'] == 'event') || ($_REQUEST['type'] =='promotion')) {?>
<tr>
  <td class="messageinfo_white" width="100">Privacy</td>
<td class="messageinfo_white">
<select name="txtPrivacy" onchange="toggle_groups(this.options[this.selectedIndex].value);">
<option value="public" <? if (($Privacy == 'public') || ($_REQUEST['txtPrivacy'] == 'public')) echo 'selected';?>>Public Event</option>
<option value="friends"  <? if (($Privacy == 'friends')  || ($_REQUEST['txtPrivacy'] == 'friends')) echo 'selected';?>>Friends Only</option>
<option value="fans" <? if (($Privacy == 'fans')  || ($_REQUEST['txtPrivacy'] == 'fans')) echo 'selected';?> >Fans</option>
<option value="private" <? if (($Privacy == 'private')  || ($_REQUEST['txtPrivacy'] == 'private')) echo 'selected';?> >Private</option>
<option value="groups" <? if (($Privacy == 'groups')  || ($_REQUEST['txtPrivacy'] == 'groups')) echo 'selected';?> >By Groups</option>
<option value="invites" <? if (($Privacy == 'invites')  || ($_REQUEST['txtPrivacy'] == 'invites')) echo 'selected';?> >By Invites</option>
</select>

</td>
</tr>
<? } ?> 
<tr id="group_select" style=" <? if (($Privacy != 'groups')  && ($_REQUEST['txtPrivacy'] != 'groups')) {?>display:none;<? }?>">
<td class="messageinfo_white">Groups</td>
<td>
<? echo $GroupSelect;?>
</td>
</tr>
</table>

</td>
<? }

if (!$Start = $_REQUEST['start_date']) {
	$Start = date('Y-m-d');
} else {
	$Start 	= $_REQUEST['start_date'];
	
}
if (!$End = $_REQUEST['end_date']) {
	$End = date('Y-m-d');
} else {
	$End = $_REQUEST['end_date'];
	
}
if (!$StartTime = $_REQUEST['start_time']) {
	$StartTime ='';
} 
if (!$EndTime = $_REQUEST['end_time']) {
	$EndTime =   '';
} 
?>
<td valign="top" class="messageinfo_white">
<? if ($_REQUEST['type'] =='promotion') {?><div style="height:5px;"></div>
Promotions are only good for up to a Month. Pro users get 4 promotions / month, unless you add more to your account. <div style="height:5px;"></div>

<? }?>
<table>
<tr><td class="messageinfo_white">Start:</td><td><? echo DateSelector('start_date',$Start) ?></td>
<? if ($_REQUEST['type'] !='promotion') {?><td  class="messageinfo_white">at</td><td><div id="setstarttime" class="messageinfo_warning" onclick="toggle_time('start','on');" style="cursor:pointer;<? if ($_POST['start_set'] == 1){?>display:none;<? }?>">SET TIME</div><div id="starttimeselect" <? if ($_POST['start_set'] != 1){?>style="display:none;"<? }?>><? echo hourmin("start_time",$StartTime);?></div></td>
<? }?></tr>
<? if ($_REQUEST['type'] !='promotion') {?><tr><td class="messageinfo_white" colspan="3"><div style="height:5px;"></div>
<? if ($_REQUEST['type'] != 'promo'){?><span class="messageinfo_white"  <? if ($_REQUEST['NoEnd'] == '1'){?> style="display:none;"<? }?>>&nbsp;&nbsp;<span id="endset"><a href="javascript:void(0)" onClick="toggleEnd('on');">-Set No End Date-</a></span><span id="noendset" <? if ($_REQUEST['NoEnd'] != '1'){?> style="display:none;"<? }?>><a href="#" onClick="toggleEnd('off');">-Set End Date-</a><br/><em>This event will repeat until cancelled.</em></span></span><? }?>
<div style="height:5px;"></div>
</td></tr><? }?>
<tr id='endtr' <?  if ($_REQUEST['NoEnd'] == '1'){?> style="display:none;"<? }?>><td class="messageinfo_white">End:</td><td><? echo DateSelector('end_date', $End);?></td>
<? if ($_REQUEST['type'] !='promotion') {?><td  class="messageinfo_white">at</td><td><div id="setendtime" onclick="toggle_time('end','on');"  class="messageinfo_warning" style="cursor:pointer;<? if ($_POST['end_set'] == 1){?>display:none;<? }?>">SET TIME</div><div id="endtimeselect" <? if ($_POST['end_set'] != 1){?>style="display:none;"<? }?>><? echo hourmin("end_time",$EndTime);?></div></td><? }?></tr>

<? if ($_REQUEST['type'] =='promotion') {?>
<tr>
  <td class="messageinfo_white" width="100">Privacy</td>
<td class="messageinfo_white">
<select name="txtPrivacy" onchange="toggle_groups(this.options[this.selectedIndex].value);">
<option value="public" <? if (($Privacy == 'public') || ($_REQUEST['txtPrivacy'] == 'public')) echo 'selected';?>>Public Event</option>
<option value="friends"  <? if (($Privacy == 'friends')  || ($_REQUEST['txtPrivacy'] == 'friends')) echo 'selected';?>>Friends Only</option>
<option value="fans" <? if (($Privacy == 'fans')  || ($_REQUEST['txtPrivacy'] == 'fans')) echo 'selected';?> >Fans</option>
<option value="private" <? if (($Privacy == 'private')  || ($_REQUEST['txtPrivacy'] == 'private')) echo 'selected';?> >Private</option>
<option value="groups" <? if (($Privacy == 'groups')  || ($_REQUEST['txtPrivacy'] == 'groups')) echo 'selected';?> >By Groups</option>
</select>

</td> 
</tr>
<? } ?> 

<? if ($_REQUEST['type'] !='promotion') {?>

<tr><td class="messageinfo_white" valign="top"><div style="height:3px;"></div>Frequency
<div style="height:5px;"></div></td><td colspan="3" valign="top">
<table><tr><td valign="top">
<select name="frequency" onchange="$('.month,.day,.week').hide();$('.' + this.value).show();">
<option value="" <?php echo ($_REQUEST['frequency'] == '') ? 'selected' : ''; ?> />One Time</option>
<option value="day" <?php echo ($_REQUEST['frequency'] == 'day') ? 'selected' : ''; ?> /> Daily</option>
<option value="week" <?php echo ($_REQUEST['frequency'] == 'week') ? 'selected' : ''; ?> />Weekly</option>
<option value="month" <?php echo ($_REQUEST['frequency'] == 'month') ? 'selected' : ''; ?> />Monthly</option>
</select></td><td>
<span class="day week month" style=" <?php if ($_REQUEST['frequency'] == ''){?>display:none;<? }?> font-size:12px; color:#ffffff;">Interval: <input type="text" name="interval" value="<?php echo ($_REQUEST['interval']) ? $_REQUEST['interval'] : 1; ?>" style="width:25px;" maxlength="1"/></span>&nbsp;&nbsp;<span class="month week" style="<?php if (($_REQUEST['frequency'] != 'month')&&($_REQUEST['frequency'] != 'week') ){?>display:none;<? }?> font-size:12px; color:#ffffff;" >Custom: <input type="checkbox" name="custom" value="1" onchange="$('.extra').toggle();" <?php echo ($_REQUEST['custom']) ? 'checked' : ''; ?> /></span>

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
<? }?>
</table>


</td>

<? if ($_REQUEST['type'] == 'promotion') {?>
<td class="messageinfo_white" width="200">
Enter a Unique Promo Code<br />
<input type="text" name="txtPromoCode" name="txtPromoCode" value="<? echo $_POST['txtPromoCode'];?>" onkeyup="checkIt(this.value);"/>

<div id="search_container" style="display:none;">
<div id="search_results" style="font-size:10px;"></div>
</div>

</td>
<? }?>
</tr></table>


 </div>

 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
           </div>             
                        
                            <div style="height:5px;"></div>
                            
                            
 <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onClick="closeWindow();" class="navbuttons"/>&nbsp;&nbsp; 
<img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('start','<? echo $_REQUEST['task'];?>','<? echo $_REQUEST['type'];?>');" class="navbuttons"/>&nbsp;&nbsp;


 
                                           
                            <img src="http://www.wevolt.com/images/wizard_next_btn.png" onClick="submit_form('2','<? echo $_REQUEST['task'];?>','<? echo $_REQUEST['type'];?>');" class="navbuttons" /> &nbsp;&nbsp;<? if ($_REQUEST['task'] == 'edit') {?><img src="http://www.wevolt.com/images/wizard_save_exit_btn.png"  onclick="submit_form('add_exit','<? echo $_GET['task'];?>','<? echo $_GET['type'];?>');" class="navbuttons"><? }?> 
                
                                                          
                             <? } else if ($_REQUEST['step'] == 2){
									  include $_SERVER['DOCUMENT_ROOT'].'/includes/event_details_form_inc.php';?>
                                      <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('<? if ($_GET['type'] != 'update') echo '1'; else echo 'start';?>','<? echo $_REQUEST['task'];?>','<? echo $_REQUEST['type'];?>');" class="navbuttons"/>&nbsp;&nbsp;<img src="http://www.wevolt.com/images/wizard_save_exit_btn.png"  onclick="submit_form('add_exit','<? echo $_GET['task'];?>','<? echo $_GET['type'];?>');" class="navbuttons"><? if (($_GET['type'] == 'todo') || ($_GET['type'] == 'event')){
										  
										  if ($_REQUEST['txtPrivacy'] != 'groups'){?><img src="http://www.wevolt.com/images/wizard_invite_btn.png" onClick="submit_form('3','<? echo $_REQUEST['task'];?>','<? echo $_REQUEST['type'];?>');" class="navbuttons"/><? }?>
									  <? }?><?
							   } else if ($_REQUEST['step'] == 3) {
							 		  include $_SERVER['DOCUMENT_ROOT'].'/connectors/event_invite.php';?>
                                   <? if ($_REQUEST['task'] == 'edit') {?><img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('start','<? echo $_REQUEST['task'];?>','<? echo $_REQUEST['type'];?>');" class="navbuttons"/>&nbsp;&nbsp;<? }?> <img src="http://www.wevolt.com/images/wizard_save_exit_btn.png"  onclick="submit_form('add_exit','<? echo $_GET['task'];?>','<? echo $_GET['type'];?>');" class="navbuttons">
                             <? } ?>
         
       <? if ($_REQUEST['step'] != 1) {
		
		   ?>                         
      <input type="hidden" name="txtTitle" value="<? if ($_REQUEST['txtTitle'] != '') echo $_REQUEST['txtTitle']; else if ($EventArray->title != '') echo $EventArray->title;?>">
    
      <input type="hidden" name="txtAddress" value="<? if ($_REQUEST['txtAddress'] != '') echo $_REQUEST['txtAddress']; else if ($EventArray->address != '') echo $EventArray->address;?>">
      <input type="hidden" name="txtAddress2" value="<? if ($_REQUEST['txtAddress2'] != '') echo $_REQUEST['txtAddress2']; else if ($EventArray->address2 != '') echo $EventArray->address2;?>">
      <input type="hidden" name="txtCity" value="<? if ($_REQUEST['txtCity'] != '') echo $_REQUEST['txtCity']; else if ($EventArray->city != '') echo $EventArray->city;?>">
      <input type="hidden" name="txtZip" value="<? if ($_REQUEST['txtZip'] != '') echo $_REQUEST['txtZip']; else if ($EventArray->zip != '') echo $EventArray->zip;?>">
      <input type="hidden" name="txtState" value="<? if ($_REQUEST['txtState'] != '') echo $_REQUEST['txtState']; else if ($EventArray->state != '') echo $EventArray->state;?>">
      <input type="hidden" name="start_time" value="<? if ($_REQUEST['start_time'] != '') echo $_REQUEST['start_time']; else if ($EventArray->start != '') echo date('h:i:s', strtotime($EventArray->start));?>">
     <input type="hidden" name="start_date" value="<? if ($_REQUEST['start_date'] != '') echo $_REQUEST['start_date']; else if ($EventArray->start != '') echo date('Y-m-d', strtotime($EventArray->start));?>">
      <input type="hidden" name="end_time" value="<? if ($_REQUEST['end_time'] != '') echo $_REQUEST['end_time']; else if ($EventArray->end != '') echo  date('h:i:s', strtotime($EventArray->end));?>">
      <input type="hidden" name="end_date" value="<? if ($_REQUEST['end_date'] != '') echo $_REQUEST['end_date']; else if ($EventArray->end != '') echo date('Y-m-d', strtotime($EventArray->end));?>">
      <input type="hidden" name="txtDescription" value="<? if ($_REQUEST['txtDescription'] != '') echo $_REQUEST['txtDescription']; else if ($EventArray->description != '') echo $EventArray->description;?>">
       <input type="hidden" name="txtPrivacy" value="<? if ($_REQUEST['txtPrivacy'] != '') echo $_REQUEST['txtPrivacy']; else if ($EventArray->privacy_setting != '') echo $EventArray->privacy_setting;?>"><input type="hidden" name="txtLocation" value="<? if ($_REQUEST['txtLocation'] != '') echo $_REQUEST['txtLocation']; else if ($EventArray->location != '') echo $EventArray->location;?>">
       <input type="hidden" name="frequency" value="<?php if ($_REQUEST['frequency'] != '') echo $_REQUEST['frequency']; else if ($EventArray->frequency != '') echo $EventArray->frequency;?>" />
       <input type="hidden" name="interval" value="<?php if ($_REQUEST['interval'] != '') echo $_REQUEST['interval']; else if ($EventArray->event_interval != '') echo $EventArray->event_interval;?>" />
       <input type="hidden" name="custom" value="<?php if ($_REQUEST['custom'] != '') echo $_REQUEST['custom']; else if ($EventArray->custom != '') echo $EventArray->custom;?>" />
       <input type="hidden" name="week_number" value="<?php if ($_REQUEST['week_number'] != '') echo $_REQUEST['week_number']; else if ($EventArray->week_number != '') echo $EventArray->week_number;?>" />
       <input type="hidden" name="week_day" value="<?php if ($_REQUEST['week_day'] != '') echo @implode(',', $_REQUEST['week_day']); else if ($EventArray->week_day != '') echo $EventArray->week_day;?>" />
      <input type="hidden" name="txtGroups" value="<?php if ($_REQUEST['txtGroups'] != '') echo @implode(',', $_REQUEST['txtGroups']); else if ($EventArray->selected_groups != '') echo $EventArray->selected_groups;?>">
      <input type="hidden" name="txtPromoCode" name="txtPromoCode" value="<?  if ($_REQUEST['txtPromoCode'] != '') echo $_REQUEST['txtPromoCode']; else if ($EventArray->promo_code != '') echo $EventArray->promo_code;?>" />
      
     
     <? }?>                          
	 <? if ($_REQUEST['step'] != 2) {?>
     	<input type="hidden" name="txtInfo" value="<? if ($_REQUEST['txtInfo'] != '') echo $_REQUEST['txtInfo']; else if ($EventArray->more_info != '') echo $EventArray->more_info;?>">
		<input type="hidden" name="txtTags" value="<? if ($_REQUEST['txtTags'] != '') echo $_REQUEST['txtTags']; else if ($EventArray->tags != '') echo $EventArray->tags;?>">
         <input type="hidden" name="txtThumb" value="<? if ($_REQUEST['txtThumb'] != '') echo $_REQUEST['txtThumb']; else if ($EventArray->thumb != '') echo $EventArray->thumb;?>">
        <input type="hidden" name="txtLink" value="<? if ($_REQUEST['link'] != '') echo $_REQUEST['link']; else if ($_REQUEST['txtLink'] != '')echo $_REQUEST['txtLink'];else if ($EventArray->url != '') echo $EventArray->url;?>">
        <input type="hidden" name="txtContactName" id="txtContactName" value="<? if ($_REQUEST['txtContactName'] != '') echo $_REQUEST['txtContactName']; else if ($EventArray->contact_name != '') echo $EventArray->contact_name;?>">
<input type="hidden" name="txtContactPhone" id="txtContactPhone" value="<? if ($_REQUEST['txtContactPhone'] != '') echo $_REQUEST['txtContactPhone']; else if ($EventArray->contact_phone != '') echo $EventArray->contact_phone;?>">
<input type="hidden"  name="txtContactEmail" id="txtContactEmail" value="<? if ($_REQUEST['txtContactEmail'] != '') echo $_REQUEST['txtContactEmail']; else if ($EventArray->contact_email != '') echo $EventArray->contact_email;?>">
<input type="hidden"  name="txtUseWemail" id="txtContactEmail" value="<? if ($_REQUEST['txtUseWemail'] != '') echo $_REQUEST['txtUseWemail']; else if ($EventArray->use_wemail != '') echo $EventArray->use_wemail;?>">
<input type="hidden" name="txtLinkTarget" value="<? if ($_REQUEST['txtLinkTarget'] != '') echo $_REQUEST['txtLinkTarget']; else if ($EventArray->contact_phone != '') echo $EventArray->contact_phone;?>" >

     <? }?>
                           
 <? if ($_REQUEST['step'] != 3) {?>
     <input type="hidden" name="invite" value="<? if (($_REQUEST['invite'] != '') && ($_POST['currentinvites'] != '')) echo $_REQUEST['invite'];?>">
     
     <input type="hidden" name="show_list" value="<? if ($_REQUEST['show_list'] != '') echo $_REQUEST['show_list']; else if ($EventArray->show_list != '') echo $EventArray->show_list;?>">
<? }?>
<input type="hidden" name="RefTitle" value="<? if ($_REQUEST['title'] != '') echo $_REQUEST['title']; else if ($_REQUEST['RefTitle'] != '')echo $_REQUEST['RefTitle'];?>">
<input type="hidden" name="txtItem" value="<? if ($_REQUEST['txtItem'] != '') echo $_REQUEST['txtItem']; else if ($_REQUEST['e'] != '') echo $_REQUEST['e']; else echo $EventArray->EncryptID;?>">
<input type="hidden" name="ContentID" id="ContentID" value="<? if ($_REQUEST['content'] != '') echo $_REQUEST['content']; else if ($_REQUEST['ContentID'] != '') echo $_REQUEST['ContentID']; else if ($EventArray->content_id != '') echo $EventArray->content_id;?>">
<input type="hidden" name="ContentType" id="ContentType" value="<? if ($_REQUEST['ContentType'] != '')echo $_REQUEST['ContentType']; else if ($EventArray->content_type != '') echo $EventArray->content_type;?>">
 <input type="hidden" id="start_set" name="start_set" value="<?php  if ($_REQUEST['start_set'] != '') echo $_REQUEST['start_set'];  else if ($EventArray->show_start_time != '') echo $EventArray->show_start_time;?>">
       <input type="hidden" id="end_set" name="end_set" value="<?php if ($_REQUEST['end_set'] != '')  echo $_REQUEST['end_set']; else if ($EventArray->show_end_time != '') echo $EventArray->show_end_time;?>">
       <input type="hidden" id="task" name="task" value="<? if ($_REQUEST['task'] != '') echo $_REQUEST['task']; else if ($_REQUEST['a'] != '') echo $_REQUEST['a'];?>" />
 <input type="hidden" name="NoEnd" id="NoEnd" value="<? if (($_REQUEST['NoEnd'] != '') &&($_REQUEST['step'] != 'start')) echo $_REQUEST['NoEnd']; else echo '0';?>">
 <input type="hidden" name="u" value="<? echo $UserID;?>">
  <input type="hidden" name="txtCal" value="<? if ($_REQUEST['txtCal'] != '') echo $_REQUEST['txtCal']; else echo $CalID;?>">
  
  <input type="hidden" name="currentinvites" id="currentinvites" value="<? echo $_REQUEST['currentinvites'];?>" />
<input type="hidden" name="currentsetinvites" id="currentsetinvites" value="<? echo $CurrentInvites;?>" />
  <input type="hidden" name="currentuninvites" id="currentuninvites" value="<? echo $_POST['currentuninvites'];?>" />
</form>

