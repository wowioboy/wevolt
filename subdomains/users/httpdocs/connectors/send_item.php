<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
include $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';

?>
<?
function build_module_template($FeedID, $CellID, $Preview = '0') {
		
	global $DB,$ModuleTitleArray,$ModuleIndex,$TypeTarget, $TargetID;
	$Count = 0;
	if ($Preview == 0) {
		$MHeight = ($ModuleTitleArray[$ModuleIndex]['Height']/5);
		$MHWidth = ($ModuleTitleArray[$ModuleIndex]['Width']/1.5);
	
	} else {
		$MHeight = $ModuleTitleArray[$ModuleIndex]['Height'];
		$MHWidth = $ModuleTitleArray[$ModuleIndex]['Width'];
	}

	$TabString = '';
	$ModuleString = '
	<div >
								
	<!-- COMMENT FORM MODULE  -->
<table width="'.$MHWidth.'" height="'
.$MHeight.'" border="0" cellspacing="0" cellpadding="0">
<tr>';
if ($Preview == 1) 
	$ModuleString .= '<td id="modtopleft"></td><td id="modtop">';
else 
	$ModuleString .= '<td id="wizardBox_TL"></td><td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>';

	$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and CellID='$CellID' order by Position";
	$ActiveModules = $DB->queryUniqueValue($query);
	
	//print $query.'<br/>';
//	print 'ACtive Mdules' . $ActiveModules.'<br/>';
	//print '<br/>';
	$query = "SELECT * from feed_settings where FeedID='$FeedID'";
	$SettingsArray = $DB->queryUniqueObject($query);
	//print $query.'<br/>';
	//print '<br/>';
	$DivString = '<div id="'.$CellID.'" style="width:'.$MHWidth.'px;height:'.$MHeight.'px;" class="modulebg">'; 
	

	if (($ModuleTitleArray[$ModuleIndex]['Template'] != 'excite') &&  ($ModuleTitleArray[$ModuleIndex]['Template'] != 'headlines')) {
		
	
	$TabString .= '<select name="txtCellSelect" onChange="select_target_window(this.options[this.selectedIndex].value);" style="width:125px; height:20px; font-size:12px;"><option value="0">--select--</option>';
	//$TabString .= '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr>';
	if ($Preview == 1)
		$TabString .= '<td width="100">'.$ModuleTitleArray[$ModuleIndex]['Title'].'</td><td width="5"></td>';
	
	$TabSpaces .= $ModuleTitleArray[$ModuleIndex]['Tabs'];
	$TabCount = 0;
	//print 'TabSpaces' . $TabSpaces.'<br/>';
	if (($ActiveModules == 0) && ($Preview == 0)) {
			 
			// $TabString .= '<option value="'.$CellID.'_1">--new--</option>';
			 // $TabString .= '<td class="availtabactive" id="'.$CellID.'_1" onclick="select_target_window(\''.$CellID.'_1\');" align="left" width="86">+</td><td width="5"></td>';
			$TabCount++;
	} else {
		$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID = '$CellID' order by Position"; 
		$DB->query($query);
		while ($line = $DB->fetchNextObject()) {
			$ModuleTabIDArray[] = $line->EncryptID;
			$ModuleType = $line->ModuleType;
			//$TabString .= '<td width="86" class="' ;
			if ((($ModuleType != 'mod_template') && ($ModuleType != 'excite_box')  && ($_GET['task'] != 'new')) || ($_GET['task']=='edit'))
				//$TabString .= 'availtabactive"  onclick="select_target_window(\''.$CellID.'_'.$line->EncryptID.'\');"';
			//else 
				//$TabString .= 'availtabinactive"';
				 $TabString .= '<option value="'.$CellID.'_'.$line->EncryptID.'">'.$line->Title.'</option>';
		
	//$TabString .= ' align="left">'.$line->Title.'</td><td width="5"></td>';
			
	
	
			
			$TabCount++;
		}
		
		//if (($_GET['task'] != 'edit')&& ($_GET['task'] != 'add')) 
			 
			 // $TabString .= '<option value="'.$CellID.'_1">--> create new window <--</option>';
			 //$TabString .= '<td class="availtabactive" id="'.$CellID.'_1" onclick="select_target_window(\''.$CellID.'_1\');" align="left" width="86">+</td><td width="5"></td>';
			
	}
	$TabString .= '</select>';
	//$TabString .= '</tr></table>';
		} 
	
	if ($Preview == 1) 
	     $ModuleString .= $TabString.'</td><td id="modtopright" valign="top"><a href="#"><img src="/templates/modules/standard/action_star.png" hspace="3" vspace="3" border="0"></a>';
		if ($Preview == 1)
			$ModuleString .='</td></tr><tr><td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" height="'.$MHeight.'">
	<div style="height:'.$MHeight.'px;overflow:auto;" align="center">';
		else 
		$ModuleString .='<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="'.($MHWidth-16).'"  height="'.$MHeight.'" align="center">';
		
		if ($Preview == 1) {
			$PrevCount = 0;
			if ($ModuleTitleArray[$ModuleIndex]['Width'] > 400)
				$ShowCount = 20;
			else 
				$ShowCount = 10;
			while ($PrevCount < $ShowCount) {
					if ($_POST['thumbsize'] == '')
						$ThumbSize =$_POST['txtThumbSize'];
					else 
						 $ThumbSize =$_POST['thumbsize'];
						 
					$ModuleString .= '<img src="/images/sample_thumb.jpg" width="'.$ThumbSize.'" hspace="3" vspace="3">';
					$PrevCount++;
			}
		} else {
			$ModuleString .='<div style="height:10px;"></div>';
				if ($ModuleTitleArray[$ModuleIndex]['Title'] == '')
					$ModuleString .= 'Untitled';
				else 
					$ModuleString .= $ModuleTitleArray[$ModuleIndex]['Title'];
		}
	if ($Preview == 0)
	$ModuleString .='<div style="height:10px;"></div>'.$TabString;
	$ModuleString .='</div>
	<div class="spacer"></div>
	</td>';
	if ($Preview == 1) 
	$ModuleString .='<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>

<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>';
	else 
	$ModuleString .='<td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>';
$ModuleString .='</tr>
</table>
<!-- END MODULE  -->';
		
	return $ModuleString;

}

function getDimensions($object) 
{
 $widthRe = '/width[ ]*[:|=][ ]*[\'|"]?[ ]*\d+/i';
 $heightRe = '/height[ ]*[:|=][ ]*[\'|"]?[ ]*\d+/i';
 $digitRe = '/\d+/';
 preg_match($widthRe, $object, $width);
 preg_match($digitRe, $width[0], $width);
 preg_match($heightRe, $object, $height);
 preg_match($digitRe, $height[0], $height);
 $width = array_shift($width);
 $height = array_shift($height);
 return array('height' => $height, 'width' => $width);
}

$Name = $_GET['name'];
$ProjectType = $_GET['type'];

if (($Name == '') && ($ProjectType == ''))
	$Name = $_SESSION['username'];

$ItemID = $_GET['id'];
if ($ItemID == '')
	$ItemID = $_POST['txtItem'];
	
$Section = $_POST['txtSection'];
if ($Section == '')
	$Section = $_GET['section'];
$OriginalSection = $_POST['OriginalSection'];
if ($OriginalSection == '')
	$OriginalSection = $_GET['section'];

$DB = new DB();
$query = "SELECT * from feed_items where EncryptID='$ItemID' and UserID='".$_SESSION['userid']."'";
$FeedItemArray = $DB->queryUniqueObject($query);

if (($_SESSION['userid'] == '') || ($FeedItemArray->ID == ''))
	$CloseWindow = 1;
	
if (($_GET['step'] == 'wevolt') || ($_GET['step'] == 'myvolt')|| ($_POST['txtSection'] == 'calendar')){
	if ($_GET['step'] == 'myvolt') {
			$TargetModuleID = 'MyModule';
			$FlagSelector = 'my';
			$Section = 'My';
	} else if ($_GET['step'] == 'wevolt') {
		$TargetModuleID = 'WeModule';
			$FlagSelector = 'w3';
			$Section = 'We';
	} 
	$SectionSelector = $Section;
	$TypeTarget = 'name';
	$TargetID = $Name;
	$query = "select * from users where username='$Name'"; 
	$ItemArray = $DB->queryUniqueObject($query);
	$UserID = $ItemArray->encryptid;
	$Email =   $ItemArray->email;
	$FeedOfTitle = $ItemArray->username;
	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID, fs.TemplateID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID' and f.FeedType='$FlagSelector'";
			  
	$FeedArray = $DB->queryUniqueObject($query);

	
	$FeedID = $FeedArray->EncryptID;	
	$FeedTemplate = $FeedArray->HtmlLayout;
	$TemplateID = $FeedArray->TemplateID;	
	$TotalLength = strlen($FeedTemplate);
	$CloseWindow = 0;
} else if ($_GET['step'] == 'calendar') {
			$Section = 'Cal';

}
$MyModuleID = $FeedItemArray->MyModule;
$WeModuleID = $FeedItemArray->WeModule;
$IsMy = $FeedItemArray->My;
$IsWe = $FeedItemArray->We;
$IsCal = $FeedItemArray->Cal;

if ($Section == 'My')
	$ModuleID = $MyModuleID;
else if ($Section == 'We')
	$ModuleID = $WeModuleID;

$query = "SELECT * from feed_modules where FeedID='$FeedID' and EncryptID='$ModuleID'";
$FeedModuleArray = $DB->queryUniqueObject($query);
$ModuleType = $FeedModuleArray->ModuleType;
$ModuleTemplate = $FeedModuleArray->ModuleTemplate;

if ($_GET['step'] == 'save') { 
			$query = "SELECT EncryptID from feed where UserID='".$_SESSION['userid']."' and FeedType='w3'";
			$WeFeedID = $DB->queryUniqueValue($query);
		//	print $query;
			
			$query = "SELECT EncryptID from feed where UserID='".$_SESSION['userid']."' and FeedType='my'";
			//print $query;
			$MyFeedID = $DB->queryUniqueValue($query);
			$TargetWindow = $_POST['TargetWindow'];
		    if ($Section  == 'My') {
					$TargetModuleID = 'MyModule';
					$FeedTarget='MyFeed';
					$FeedID = $MyFeedID;		
			} else if ($Section == 'We') {
				$TargetModuleID = 'WeModule';
					$FeedTarget='WeFeed';
					$FeedID = $WeFeedID;
					
			}else if ($Section == 'Cal') {
				if ($_POST['OriginalSection'] == 'My') {
					$TargetModuleID = 'MyModule';
					$FeedTarget='MyFeed';
					$FeedID = $MyFeedID;	
				} else if ($_POST['OriginalSection'] == 'We') {
					$TargetModuleID = 'WeModule';
					$FeedTarget='WeFeed';
					$FeedID = $WeFeedID;
				}
				
			}
			if (($Section == 'My') || ($Section == 'We'))
			$query = "UPDATE feed_items set $Section='1', $FeedTarget='$FeedID', $TargetModuleID='$TargetWindow' where EncryptID='$ItemID' and UserID='".$_SESSION['userid']."'";
			else 
			$query = "UPDATE feed_items set $Section='1', $FeedTarget='$FeedID' where EncryptID='$ItemID' and UserID='".$_SESSION['userid']."'";
			$output .= $query .'<br/>';
			$DB->execute($query);
			if ($Section == 'Cal') {
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
						if (is_array($week_day))
						{
						$TempUpdates = '';
						 foreach ($week_day as $value) {
						  if ($TempUpdates != '')
						   $TempUpdates .= ',';
						 $TempUpdates .= $value;
						 }
						 $UpdateString = $TempUpdates;
						}

					if ($Privacy == '')
						$Privacy = 'private';
						
						$query = "SELECT count(*) from calendar where user_id='$UserID' and content_id='$ItemID' and content_type='feed_item'";
						$Found = $DB->queryUniqueValue($query);
						$output .= $query .'<br/>';
						if ($Found == 0) {
							
			$query = "INSERT into calendar (title, description, `start`, `end`, user_id, content_id, content_type, `type`, privacy_setting, url, location, contact_name, contact_phone,contact_email, address, address2, city, state, zip, tags, created_date, more_info, use_wemail, thumb, frequency, `interval`, custom, week_day, week_number) 
			                        values ('$Title','$Description','$StartDate','$EndDate','$UserID','$ItemID', 'feed_item','reminder','$Privacy', '$Link', '$Location','$ContactName', '$ContactPhone', '$ContactEmail','$Address','$Address2', '$City', '$State', '$Zip', '$Tags','$CreatedDate','$MoreInfo','$UseWemail','$Thumb','$frequency', '$interval', '$custom', '$UpdateString', '$week_number')";
			$DB->execute($query);
							$output .= $query .'<br/>';
						} else {
							$query = "UPDATE calendar set title='$Title', description='$Tagline',frequency='$frequency', `interval`='$interval',custom='$custom', week_day='$week_daystring', week_number='$week_number', start='$EntryStart',end='$EntryEnd' where UserID='$UserID' and content_id='$ItemID' and content_type='feed_item'";
							$DB->execute($query);
							$output .= $query .'<br/>';
						}
					
						//print $query.'<br/>';	
						$query = "SELECT id from calendar where created_date='$CreatedDate' and user_id='$UserID'";
						$CalID = $DB->queryUniqueValue($query);
						$output .= $query .'<br/>';
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
						
						$output .= $query .'<br/>';
			}
		//	if ($_SESSION['username'] != 'matteblack')
				$CloseWindow=1;
			//else 
			//	print $output;
					
} else if ($_GET['step'] =='unpublish') {
					 if ($Section  == 'My') {
							$TargetModuleID = 'MyModule';
							$query = "UPDATE feed_items set $Section='0', $TargetModuleID='' where EncryptID='$ItemID' and UserID='".$_SESSION['userid']."'";
							$DB->execute($query);
					} else if ($Section == 'We') {
							$TargetModuleID = 'WeModule';
							$query = "UPDATE feed_items set $Section='0', $TargetModuleID='' where EncryptID='$ItemID' and UserID='".$_SESSION['userid']."'";	
							$DB->execute($query);	
					} else if ($Section == 'Cal') {
							$query = "UPDATE feed_items set $Section='0' where EncryptID='$ItemID' and UserID='".$_SESSION['userid']."'";	
							$DB->execute($query);
							$query = "DELETE from calendar where content_type='feed_item' and content_id='$ItemID' and user_id='".$_SESSION['userid']."'";	
							$DB->execute($query); 
							
					}
					$CloseWindow=1;
}
$DB->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Update Excite Status</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="http://<? echo $_SERVER['SERVER_NAME'];?>/ajax/ajax_init.js"></script>
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
</script>
<script type="text/javascript">

function submit_form(step) {

	var formaction = '/connectors/send_item.php';
	formaction = formaction +'?step='+step;

	document.modform.action = formaction;
	document.modform.submit();

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
function select_target_window(Target) {

		var TargetArray = Target.split('_');
		var CellID = TargetArray[0];
		var step;
		var task;
		var TargetWindow = TargetArray[1];
		document.getElementById("CellID").value = CellID;
		document.getElementById("TargetWindow").value = TargetWindow;
		submit_form('save');

}
function unpublish_item(Target) {
		document.getElementById("txtSection").value = Target;
		submit_form('unpublish');
}
var Template = '<? echo $WindowArray->ModuleTemplate;?>';

</script>

</head><body>
    
   
        
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center">
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
document.location.href="/connectors/send_item.php?step=start&id=<? echo $ItemID;?>&section=<? echo $OriginalSection;?>";
</script>
<? }?>  
<div style="height:15px;"></div>
		<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                        
		<? if ($Section == 'We') {?>
        <img src="http://www.wevolt.com/images/wizard_send_wevolt.png" vspace="8"/>
        <? } else {?>
        <img src="http://www.wevolt.com/images/wizard_send_myvolt.png" vspace="8"/>
        <? }?>
 		</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
   	<div style="height:10px;"></div>
   <div align="center">
   <table><tr>
  				  <? if (($_GET['step'] == '') || ($_GET['step'] == 'start')){?> 
				   <td width="100" align="center" class="messageinfo_white">
  <a href="javascript:void(0)" onclick="parent.edit_item('<? echo $ItemID;?>','<? echo $Section;?>');">[EDIT]</a>
  </td>
  <td>
   <table border='0' cellspacing='0' cellpadding='0' width='200'><tr>
										<td id="updateBox_TL"></td>
										<td id="updateBox_T"></td>
										<td id="updateBox_TR"></td></tr>
										<tr><td class="updateboxcontent"></td>
										<td valign='top' class="updateboxcontent" width='<? echo (200-16);?>'>
                                        <table><tr>
                                	<? if ($FeedItemArray->Thumb != '') {?>
                                    <td>
											<img src='<? echo $FeedItemArray->Thumb;?>' alt='LINK' height="50" align='left' hspace='3' vspace='3' style='border:2px #000000 solid;'></td>
										<? }?>	
                                        <td valign="top">
											<span class="sender_name" style="font:10px;"><? echo $FeedItemArray->Title;?></span>
                                            </td></tr></table>
                              </td><td class="updateboxcontent"></td>
						</tr><tr><td id="updateBox_BL"></td><td id="updateBox_B"></td>
						<td id="updateBox_BR"></td>
						</tr></table></td>
                        <? }?>
                         <? if (($_GET['step'] != '') && ($_GET['step'] != 'start')){?> 
                         <td style="padding-left:10px;">
                        <table width="350" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="334" align="center">
                                        <div style="height:5px;"></div>
                                       
                                        <img src="http://www.wevolt.com/images/wizard_back_btn.png" onclick="submit_form('start');" class="navbuttons">&nbsp;&nbsp;<img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="parent.$.modal().close();" class="navbuttons">&nbsp;&nbsp;<img src="http://www.wevolt.com/images/wizard_save_btn.png" onclick="submit_form('save');" class="navbuttons">
                                    <div style="height:5px;"></div>
                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                                      
                        </td><? }?>  </tr></table>
                        <? if (($_GET['step'] == '') || ($_GET['step'] == 'start')) {?>
                        <div class="spacer"></div>
                        <table width="100%"><tr><td align="center">
                         <table width="420" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="404" align="center">
                                        <table cellpadding="4" width="100%">
                                            <tr>
                                                <td class="messageinfo_white" width="110">
                                                <? if ($FeedItemArray->My == 1){?>
                                                    <a href="javascript:void(0)" onclick="unpublish_item('My');">[REMOVE FROM]</a>
                                                <? } else {?>
                                                     <a href="javascript:void(0)" onclick="submit_form('myvolt'); ">[SEND TO]</a>
                                                <? }?>
                                                </td><td><img src="http://www.wevolt.com/images/myvolt_logo_wizard.png" /></td>
                                            </tr>
                                            <tr>
                                                <td class="messageinfo_white">
                                                <? if ($FeedItemArray->We == 1){?>
                                                    <a href="javascript:void(0)" onclick="unpublish_item('We');">[REMOVE FROM]</a>
                                                <? } else {?>
                                                     <a href="javascript:void(0)" onclick="submit_form('wevolt'); ">[SEND TO]</a>
                                                <? }?>
                                                </td><td><img src="http://www.wevolt.com/images/wevolt_logo_wizard.png" /></td>
                                            </tr>
                                            <tr>
                                                <td class="messageinfo_white">
                                                <? if ($FeedItemArray->Cal == 1){?>
                                                    <a href="javascript:void(0)" onclick="unpublish_item('Cal');">[REMOVE FROM]</a>
                                                <? } else {?>
                                                     <a href="javascript:void(0)" onclick="submit_form('calendar'); ">[SEND TO]</a>
                                                <? }?>
                                                </td><td><img src="http://www.wevolt.com/images/calendar_logo_wizard.png" /></td>
                                            </tr>
                                        </table>
                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        </td></tr></table>
                        <div style="height:5px;"></div>
                  		<? }?>
 						<form name="modform" id="modform" method="post">   
						<? if (($_GET['step'] == 'wevolt') ||  ($_GET['step'] == 'myvolt')) {

						$CurrentPosition = 0;
							$WorkingString = $FeedTemplate;
	$StillGoing = true;
	$CellIDArray = array();
	
	while ($StillGoing) {
			$StartPosition = strpos($WorkingString, "id=\"");
			$TempString = substr($WorkingString,$StartPosition+4, $TotalLength-1);
			$WalkingPosition = 0; 
			$EndPosition = strpos($TempString, "\">");
			$CellID = substr($TempString,$WalkingPosition, $EndPosition);
			$CellIDArray[] = $CellID;
			$CurrentPosition = $EndPosition;
			$WorkingString = substr($TempString,$EndPosition,$TotalLength-1);
			$NewLength = strlen($WorkingString);
			if ($NewLength < 36)
				$StillGoing = false;
			
	}
	
	$query = "SELECT * from feed_settings where FeedID='$FeedID'";
	$SettingsArray = $DB->queryUniqueObject($query);
	$query = "SELECT * from feed_templates where ID='$TemplateID'";
	$TemplateArray = $DB->queryUniqueObject($query);

	$ModuleTitleArray = array(array(
								'Title'=>$SettingsArray->Module1Title,
								'Width'=>$TemplateArray->Mod1Width,
								'Height'=>$TemplateArray->Mod1Height,
								'Template'=>$TemplateArray->Mod1Template,
								'Tabs'=>$TemplateArray->Mod1Tabs),
							array(
								'Title'=>$SettingsArray->Module2Title,
								'Width'=>$TemplateArray->Mod2Width,
								'Height'=>$TemplateArray->Mod2Height,
								'Template'=>$TemplateArray->Mod2Template,
								'Tabs'=>$TemplateArray->Mod2Tabs),
							array(
								'Title'=>$SettingsArray->Module3Title,
								'Width'=>$TemplateArray->Mod3Width,
								'Height'=>$TemplateArray->Mod3Height,
								'Template'=>$TemplateArray->Mod3Template,
								'Tabs'=>$TemplateArray->Mod3Tabs),
							array(
								'Title'=>$SettingsArray->Module4Title,
								'Width'=>$TemplateArray->Mod4Width,
								'Height'=>$TemplateArray->Mod4Height,
								'Template'=>$TemplateArray->Mod4Template,
								'Tabs'=>$TemplateArray->Mod4Tabs),
							array(
								'Title'=>$SettingsArray->Module5Title,
								'Width'=>$TemplateArray->Mod5Width,
								'Height'=>$TemplateArray->Mod5Height,
								'Template'=>$TemplateArray->Mod5Template,
								'Tabs'=>$TemplateArray->Mod5Tabs),
							array(
								'Title'=>$SettingsArray->Module6Title,
								'Width'=>$TemplateArray->Mod6Width,
								'Height'=>$TemplateArray->Mod6Height,
								'Template'=>$TemplateArray->Mod6Template,
								'Tabs'=>$TemplateArray->Mod6Tabs),
							array(
								'Title'=>$SettingsArray->Module7Title,
								'Width'=>$TemplateArray->Mod7Width,
								'Height'=>$TemplateArray->Mod7Height,
								'Template'=>$TemplateArray->Mod7Template,
								'Tabs'=>$TemplateArray->Mod7Tabs),
							array(
								'Title'=>$SettingsArray->Module8Title,
								'Width'=>$TemplateArray->Mod8Width,
								'Height'=>$TemplateArray->Mod8Height,
								'Template'=>$TemplateArray->Mod8Template,
								'Tabs'=>$TemplateArray->Mod8Tabs)
					);
					$ModuleList = '<select name="Module">';
					$TabList = '<select name="Tab">';
					foreach ($CellIDArray as $Cell) { 
			
						
			$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and CellID='$Cell' order by Position";
			$ActiveModules = $DB->queryUniqueValue($query);
			//print 'Actuve = ' .	$ActiveModules.'<br/>';
			//print 'query = ' .	$query.'<br/>';
			$ModuleIndex = substr($Cell,6,strlen($Cell)-1)-1;
			$TabSpaces = $ModuleTitleArray[$ModuleIndex]['Tabs'];
			if ($_POST['txtModule'] == $Cell) {
				$ModuleWidth = $ModuleTitleArray[$ModuleIndex]['Width'];
				$ModuleHeight = $ModuleTitleArray[$ModuleIndex]['Height'];
				
			}
			//print 'TabSpaces = ' .	$TabSpaces.'<br/>';
			$AvailTabs = ($TabSpaces - $ActiveModules);
			
		//	print 'MODULE INDEX '.$ModuleIndex .'<br/>';
		//	print 'CELL NAME '.$Cell .'<br/>';
		//	print 'MODULE WIDTH = ' . $ModuleTitleArray[$ModuleIndex]['Width'].'<br/>';
		//	print 'MODULE HEIGHT = ' . $ModuleTitleArray[$ModuleIndex]['Height'].'<br/>';
			$TabCount = 0;
	
	//print 'TabSpaces' . $TabSpaces.'<br/>';		 	
				$ModuleList .= "<option value='".$Cell."'";
				
				if ($_POST['txtModule'] == $Cell)
					$ModuleList .= "selected";
			
				$ModuleList .= ">".$Cell." - Available Tabs: ".$AvailTabs."</option>";
								//print 'POST[txtModule]='.$_POST['txtModule'].'<br/>';
					
					//if (($_POST['txtModule'] == $Cell)||($_POST['Module'] == $Cell)) {
								
								if ($ActiveModules == 0) {
										while($TabCount < $TabSpaces) {
											$TabList .= "<option value='".$Cell."'";
											if ($_POST['txtModule'] == $Cell)
												$TabList .= "selected";
							
											$TabList .= ">Tab ".($TabCount+1)."</option>";
											$TabCount++;
										}
					
								} else {
										$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID = '$CellID' order by Position"; 
										$DB->query($query);
										while ($line = $DB->fetchNextObject()) {
											$TabCount++;
										}
								
										while($TabCount < $TabSpaces) {
											$TabList .= "<option value='".$Cell."'";
											if ($_POST['txtModule'] == $Cell)
												$TabList .= "selected";
							
											$TabList .= ">Tab ".($TabCount+1)."</option>";
											$TabCount++;
										}
								}
						
				//	}
					
			
		   			
						$Preview = 0;
						$MHeight = ($ModuleTitleArray[$ModuleIndex]['Height']/5);
						$MHWidth = ($ModuleTitleArray[$ModuleIndex]['Width']/1.5);
				
						$CellString = build_module_template($FeedID, $Cell,$Preview);		
						$FeedTemplate=str_replace("{".$Cell."}","<div style='padding-left:5px;padding-right:5px;'>".$CellString."</div>",$FeedTemplate);	
		 
		
							$FeedTemplate=str_replace("{".$Cell."Width}",$MHWidth,$FeedTemplate);
						
							$FeedTemplate=str_replace("{".$Cell."Height}",$MHeight,$FeedTemplate);
				
			

	$ModuleList .= "</select>";
	$TabList .= '</select>';
		
	
					}
					echo $FeedTemplate;

					 	} else if ($_GET['step'] == 'calendar') {

						
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
	foreach ($times as $actual => $display) {
		$out .= "<option value=\"$actual\"";
		if ($pval == $actual)
			$out.= " selected ";
		$out .= ">$display</option>";
	}
	$out .= '</select>';
//	if(empty($hval)) $hval = date("h");
//	if(empty($mval)) $mval = date("i");
//	if(empty($pval)) $pval = date("a");
//
//	$hours = array(12, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11);
//	$out = "<td><select name='$hid' id='$hid'>";
//	foreach($hours as $hour)
//		if(intval($hval) == intval($hour)) $out .= "<option value='$hour' selected>$hour</option>";
//		else $out .= "<option value='$hour'>$hour</option>";
//	$out .= "</select></td>";
//
//	$minutes = array("00","05", 10, 15, 20,25, 30,35,40, 45,50,55);
//	$out .= "<td><select name='$mid' id='$mid'>";
//	foreach($minutes as $minute)
//		if(intval($mval) == intval($minute)) $out .= "<option value='$minute' selected>$minute</option>";
//		else $out .= "<option value='$minute'>$minute</option>";
//	$out .= "</select></td>";
//	
//	$out .= "<td><select name='$pid' id='$pid'>";
//	$out .= "<option value='am'>am</option>";
//	if($pval == "pm") $out .= "<option value='pm' selected>pm</option>";
//	else $out .= "<option value='pm'>pm</option>";
//	$out .= "</select></td>";
//	
	return $out;
}

    function DateSelector($inName, $useDate='') 
    { 
    	$string = '<input name="'.$inName.'" class="datepicker" type="text" value="'.$useDate.'"/>';
        /* create array so we can name months */ 
//        $monthName = array(1=> "January", "February", "March", 
//            "April", "May", "June", "July", "August", 
//            "September", "October", "November", "December"); 
// 
//        /* if date invalid or not supplied, use current time */ 
//      
//	    if($useDate == '') 
//        { 
//            $useDate = time(); 
//        } else {
//		 	$useDate = convert_datetime($useDate);
//		}
// 		
//        /* make month selector */ 
//        $string .= "<td><select name=" . $inName . "_month>\n"; 
//        for($currentMonth = 1; $currentMonth <= 12; $currentMonth++) 
//        { 
//             $string .= "<OPTION VALUE=\""; 
//			 if (strlen($currentMonth) <2)
//			 	$string .= '0'.intval($currentMonth); 
//            else 
//			   $string .= intval($currentMonth); 
//             $string .= "\""; 
//            if(intval(date( "m", $useDate))==$currentMonth) 
//            { 
//                 $string .= " SELECTED"; 
//            } 
//             $string .= ">" . $monthName[$currentMonth] . "\n"; 
//        } 
//         $string .= "</SELECT></td>"; 
// 
//        /* make day selector */ 
//         $string .= "<td><SELECT NAME=" . $inName . "_day>\n"; 
//        for($currentDay=1; $currentDay <= 31; $currentDay++) 
//        { 
//             $string .= "<OPTION VALUE=\"";
//			 
//			  if (strlen($currentDay) <2)
//			 	$string .= '0'.intval($currentDay); 
//            else 
//			   $string .= intval($currentDay); 
//			 
//			 
//			 $string .="\""; 
//            if(intval(date( "d", $useDate))==$currentDay) 
//            { 
//                 $string .= " SELECTED"; 
//            } 
//             $string .= ">$currentDay\n"; 
//        } 
//         $string .= "</SELECT></td>"; 
// 
//        /* make year selector */ 
//         $string .= "<td><SELECT NAME=" . $inName . "_year>\n"; 
//        $startYear = date( "Y", $useDate); 
//        for($currentYear = $startYear; $currentYear <= $startYear+5;$currentYear++) 
//        { 
//             $string .= "<OPTION VALUE=\"$currentYear\""; 
//            if(date( "Y", $useDate)==$currentYear) 
//            { 
//                 $string .= " SELECTED"; 
//            } 
//             $string .= ">$currentYear\n"; 
//        } 
//         $string .= "</SELECT></td>"; 
 return $string;
} 

 function DayDropdown($inName, $useDate='') 
    { 
      
  	//$string = '<input class="datepicker" type="text" />';
   if($useDate == '') 
        { 
           //$useDate = intval(date('d')); 
			$useDate = '0';
        } else {
		 $useDate = intval($useDate); 
	} 		
             /* make day selector */ 
        $string .= "<SELECT NAME=" . $inName . ">\n"; 
		 $string .= "<option value='0'";
		 if ($useDate == '0')
		 	 $string .= "selected";
		$string .= ">--select--</option>";
        for($currentDay=1; $currentDay <= 31; $currentDay++) 
        { 
             $string .= "<OPTION VALUE=\"$currentDay\""; 
          if($useDate==$currentDay) 
           { 
                 $string .= " SELECTED"; 
            } 
             $string .= ">$currentDay\n"; 
        } 
         $string .= "</SELECT>"; 
 
        /* make year selector */ 
       
 return $string;
} 



?>
<script type="text/javascript">
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
 
</script>
<link href="http://www.wevolt.com/css/cupertino/jquery-ui-1.8.1.custom.css" rel="stylesheet" />
<script src="http://www.wevolt.com/js/jquery-1.4.2.min.js"></script>
<script src="http://www.wevolt.com/js/jquery-ui-1.8.1.custom.min.js"></script>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
<script type="text/javascript">
$(document).ready(function() {
	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd'
	});
});
</script>
<div id="eventsched" >
<table width="97%" ><tr>
<td class="messageinfo_white" valign="top" width="100">Title:<small>(required)</small></td>
<td><input id="txtTitle" name="txtTitle" style="width:100%;" type="text"  value="<? if ($_REQUEST['txtTitle'] != '') echo $_REQUEST['txtTitle'];?>"></td>
</tr>
<? if (($_REQUEST['type'] == 'todo') || ($_REQUEST['type'] == 'reminder')|| ($_REQUEST['type'] == 'promo')|| ($_REQUEST['type'] == 'event')) {?> 
<tr>
<td class="messageinfo_white" valign="top" width="100">Description / Tagline</td>
<td><textarea  style="width:100%; height:40px;" name="txtDescription" id="txtDescription"><? if ($_REQUEST['txtDescription'] != '') echo $_REQUEST['txtDescription']; else echo 'Enter A Description';?></textarea></td>
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

<?php if (($_REQUEST['type'] =='promo') || ($_REQUEST['type'] =='event')) { ?>
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
    <? $StateString = statedropdown();?>
    <SELECT ID='txtState' NAME='txtState' STYLE='WIDTH:100%;'>
              <? if ($state != '') { echo str_replace($state . '"', $_REQUEST['txtState'] . '" selected', $StateString); } else { echo $StateString;} ?> 
            </SELECT></td>
    </tr>
    <tr><td class="messageinfo_white">Zip</td>
    <td class="messageinfo_white"><input id="txtZip" name="txtZip" style="width:100px;" value="<? if ($_REQUEST['txtZip'] != '') echo $_REQUEST['txtZip'];?>" type="text"></td>
    </tr>
    </table>

</td>
</tr>
<? }?>
<? if (($_REQUEST['type'] == 'event') || ($_REQUEST['type'] == 'promo')) {?>
<tr>
  <td class="messageinfo_white" width="100">Privacy</td>
<td class="messageinfo_white"><select name="txtPrivacy">
<option value="public" <? if ($Privacy == 'public') echo 'selected';?>>Public Event</option>
<option value="friends"  <? if ($Privacy == 'friends') echo 'selected';?>>Friends Only</option>
<option value="fans" <? if ($Privacy == 'fans') echo 'selected';?> >Fans</option>
<option value="private" <? if ($Privacy == 'private') echo 'selected';?> >Private</option></select>
</td>
</tr>
<? } ?> 
</table>

</td>
<? }

if (!$start = $_REQUEST['start_date']) {
	$Start = date('Y-m-d');
}
if (!$End = $_REQUEST['end_date']) {
	$End = date('Y-m-d');
} 
if (!$StartTime = $_REQUEST['start_time']) {
	$StartTime = date('H:00:00');
} 
if (!$EndTime = $_REQUEST['end_time']) {
	$EndTime =   date('H:30:00');
} 
?>
<td valign="top" class="messageinfo_white">
<table>
<tr><td class="messageinfo_white">Start:</td><td><? echo DateSelector('start_date',$Start) ?></td><td  class="messageinfo_white">at</td><td><? echo hourmin("start_time",$StartTime);?></td></tr>
<tr><td class="messageinfo_white" colspan="3"><div style="height:5px;"></div>
<? if ($_REQUEST['type'] != 'promo'){?><span class="messageinfo_white"  <?  if ($_REQUEST['NoEnd'] == '1'){?> style="display:none;"<? }?>>&nbsp;&nbsp;<span id="endset"><a href="javascript:void(0)" onClick="toggleEnd('on');">-Set No End Date-</a></span><span id="noendset" <?  if ($_REQUEST['NoEnd'] != '1'){?> style="display:none;"<? }?>><a href="javascript:void(0)" onClick="toggleEnd('off');">-Set End Date-</a><br/><em>This event will repeat until cancelled.</em></span></span><? }?>
<div style="height:5px;"></div>
</td></tr>
<tr id='endtr' <?  if ($_REQUEST['NoEnd'] == '1'){?> style="display:none;"<? }?>><td class="messageinfo_white">End:</td><td><? echo DateSelector('end_date', date('Y-m-d'));?></td><td  class="messageinfo_white">at</td><td><? echo hourmin("end_time",$EndTime);?></td></tr>


<tr><td class="messageinfo_white" valign="top"><div style="height:3px;"></div>Frequency
<div style="height:5px;"></div></td><td colspan="3" valign="top">
<table><tr><td valign="top">
<select name="frequency" onchange="$('.month,.day,.week').hide();$('.' + this.value).show();">
<option value="" <?php echo ($_REQUEST['frequency'] == '') ? 'selected' : ''; ?> />One Time</option>
<option value="day" <?php echo ($_REQUEST['frequency'] == 'day') ? 'selected' : ''; ?> /> Daily</option>
<option value="week" <?php echo ($_REQUEST['frequency'] == 'week') ? 'selected' : ''; ?> />Weekly</option>
<option value="month" <?php echo ($_REQUEST['frequency'] == 'month') ? 'selected' : ''; ?> />Monthly</option>
</select></td><td>
<span class="day week month" style="display:none; font-size:12px; color:#ffffff;">Interval: <input type="text" name="interval" value="<?php echo ($_REQUEST['interval']) ? $_REQUEST['interval'] : 1; ?>" style="width:25px;" maxlength="1"/></span>&nbsp;&nbsp;<span class="month week" style="display:none;font-size:12px; color:#ffffff;" >Custom: <input type="checkbox" name="custom" value="1" onchange="$('.extra').toggle();" <?php echo ($_REQUEST['custom']) ? 'checked' : ''; ?> /></span>

<div class="extra" <?php echo ($_REQUEST['custom']) ? '' : 'style="display:none;"'; ?>>
<table class="month" style="color:#fff;font-size:12px;display:none;">
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
<table class="week month" style="color:#fff;font-size:12px;display:none;">
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
    <td><input type="checkbox" name="week_day[]" value="1" /></td>
    <td><input type="checkbox" name="week_day[]" value="2" /></td>
    <td><input type="checkbox" name="week_day[]" value="3" /></td>
    <td><input type="checkbox" name="week_day[]" value="4" /></td>
    <td><input type="checkbox" name="week_day[]" value="5" /></td>
    <td><input type="checkbox" name="week_day[]" value="6" /></td>
    <td><input type="checkbox" name="week_day[]" value="7" /></td>
  </tr>
</table>
</div></td></tr></table></td></tr>
</table>


</td>
</tr></table>
 

 </div>
						<? }?> 

 <input type="hidden" name="NoEnd" id="NoEnd" value="<? if (($_REQUEST['NoEnd'] != '') &&($_REQUEST['step'] != 'start')) echo $_REQUEST['NoEnd'];?>">             
<input type="hidden" name="TargetSection" value="<? echo $_GET['step'];?>">                
<input type="hidden" name="txtItem" value="<? if ($_POST['txtItem'] != '') echo $_POST['txtItem']; else echo $_GET['id'];?>">
<input type="hidden" name="ItemType" value="<? echo $FeedItemArray->ItemType;?>">
<input type="hidden" name="txtSection" id="txtSection" value="<? echo $Section;?>">
<input type="hidden" name="txtLink" id="txtLink" value="<? echo $FeedItemArray->Link;?>">

<input type="hidden" name="txtThumb" id="txtThumb" value="<? echo $FeedItemArray->Thumb;?>">

<input type="hidden" id ="ContentType" name="ContentType" value="<? echo $FeedItemArray->LinkType;?>">
<input type="hidden" name="ContentID" id="ContentID" value="<? echo $FeedItemArray->ContentID;?>">
<input type="hidden" name="send" value="1" />
<input type="hidden" name="CellID" value="" id="CellID"/>
<input type="hidden" name="TargetWindow" value="" id="TargetWindow"/>
<input type="hidden" name="OriginalSection" value="<? echo $OriginalSection;?>" id="OriginalSection"/>
</form>
<? if (($_GET['step'] == '')|| ($_GET['step'] == 'start')){?> <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="parent.$.modal().close();" class="navbuttons"><? } ?>  
                        </div>
           
</body>
</html>