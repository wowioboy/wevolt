<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
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
			 
			 $TabString .= '<option value="'.$CellID.'_1">--new--</option>';
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

if (($Name == '') && ($ProjectType == '')){
	$Name = $_SESSION['username'];
}
$RePost = 0;
$ItemID = $_GET['id'];
if ($ItemID == '')
	$ItemID = $_POST['txtItem'];
	
$Section = $_POST['txtSection'];
if ($Section == '')
$Section = $_GET['section'];
$OriginalSection = $_POST['OriginalSection'];
if ($OriginalSection == '')
	$OriginalSection = $_GET['section'];



$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

$query = "SELECT * from feed_items where EncryptID='$ItemID' and UserID='".$_SESSION['userid']."'";
$FeedItemArray = $DB->queryUniqueObject($query);

if (($_SESSION['userid'] == '') || ($FeedItemArray->ID == ''))
	$CloseWindow = 1;
	
if (($_GET['step'] == 'wevolt') || ($_GET['step'] == 'myvolt')){
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
			$query = "SELECT EncryptID from feed where UserID='".$_SESSION['userid']."' and FeedType='my'";
			$MyFeedID = $DB->queryUniqueValue($query);
			$TargetWindow = $_POST['TargetWindow'];
		    if ($Section  == 'My') {
					$TargetModuleID = 'MyModule';
					$FeedTarget='MyFeed';
					$FeedID = $MyFeedID;		
			} else if ($Section == 'We') {
				$TargetModuleID = 'WeModule';
					$FeedTarget='WeFeed';
					$FeedID = $FeedID = $WeFeedID;
					
			}
					$query = "UPDATE feed_items set $Section='1', $FeedTarget='$FeedID', $TargetModuleID='$TargetWindow' where EncryptID='$ItemID' and UserID='".$_SESSION['userid']."'";
					//print $query;
					$DB->execute($query);
			if ($Section == 'Cal') {
					$Title = mysql_real_escape_string($_POST['txtTagline']);
					$Tagline = mysql_real_escape_string($_POST['txtTagline']);
					$Tags = mysql_real_escape_string($_POST['txtTags']);
					$Description = mysql_real_escape_string($_POST['txtDescription']);
					$Privacy = $_POST['txtPrivacy'];
					$UserID = $_SESSION['userid'];
					$CreateDate = date('Y-m-d h:i:s');
					$Thumb = $_POST['txtThumb'];
					$Address = mysql_real_escape_string($_POST['txtAddress']);
					$City = mysql_real_escape_string($_POST['txtCity']);
					$State = mysql_real_escape_string($_POST['txtState']);
					$Zip = mysql_real_escape_string($_POST['txtZip']);
					$State = mysql_real_escape_string($_POST['txtState']);
					$StartTimeDate = $_POST['start_time_year'].'-'.$_POST['start_time_month'].'-'.$_POST['start_time_day'];
					$EndTimeDate = $_POST['end_time_year'].'-'.$_POST['end_time_month'].'-'.$_POST['end_time_day'];
					$StartTimeTime =  $_POST['start_time_hour'].':'.$_POST['start_time_min'];
					$EventDate = $StartTimeDate;
					$EventTime = $StartTimeTime;
					$Link = $_POST['txtLink'];
					$EventType = $_GET['type'];
					$ContentID = $_POST['ContentID'];
					$ContentType = $_POST['ContentType'];
					$Reminder = $_POST['txtReminder'];
					if (($_POST['start_time_ampm'] == 'pm') && ($_POST['start_time_hour'] != 12))
						$StartTimeTime = $_POST['start_time_hour'] + 12;
					else if (($_POST['start_time_ampm'] == 'am') && ($_POST['start_time_hour'] == 12))
						$StartTimeTime = '00';
					else 
						$StartTimeTime .= $_POST['start_time_hour'];
			
					$StartTimeTime .= ':'.$_POST['start_time_min'];
					
					if (($_POST['end_time_ampm'] == 'pm') && ($_POST['end_time_hour'] != 12))
						$EndTimeTime = $_POST['end_time_hour'] + 12;
					else if (($_POST['end_time_ampm'] == 'am') && ($_POST['end_time_hour'] == 12))
						$EndTimeTime = '00';
					else 
						$EndTimeTime .= $_POST['end_time_hour'];
			
					$EndTimeTime .= ':'.$_POST['end_time_min'];
					
					$EntryStart = $StartTimeDate. ' 00:00:00';
					$EntryEnd = $EndTimeDate. ' 00:00:00';
					if ($_POST['NoEnd'] == 1) 
						$EntryEnd = '0000-00-00 00:00:00';
					
					$Frequency =  $_POST['txtFrequency'];
					if ($Frequency != 'none')  {
						$DayOfWeek =  $_POST['dayofweek'];
						if (($Frequency != 'daily') && ($Frequency != 'weekly'))
							$DayofMonth =  $_POST['dayofmonth'];
						if (($Frequency != 'daily') && ($Frequency != 'weekly'))
							$WeekNumber =  $_POST['weeknumber'];
						$EventType = $_POST['EventType'];
					} else {
						$Frequency ='';
					}
					
					if ($Privacy == '')
						$Privacy = 'private';

						$query = "SELECT count(*) from pf_calendar where UserID='$UserID' and ContentID='$FriendID' and EntryType='reminder'";
						$Found = $DB->queryUniqueValue($query);
						if ($Found == 0) {
							$query = "INSERT into pf_calendar (Title, Comment,EventDate, EventTime, UserID,ContentID,ContentType,EntryType,Frequency, DayofWeek,DayofMonth,WeekNumber, PrivacySetting, EntryStart,EntryEnd,CreatedDate) values ('$Title','$Tagline','$EventDate','$EventTime','$UserID','$FriendID', 'user','reminder','$Frequency','$DayOfWeek','$DayofMonth','$WeekNumber','$Privacy', '$EntryStart','$EntryEnd','$CreateDate')";
							$DB->execute($query);
							//print $query.'<br/>';
						} else {
							$query = "UPDATE pf_calendar set Title='$Title', Comment='$Tagline',EventDate='$EventDate', EventTime='$EventTime',Frequency='$Frequency', DayofWeek='$DayOfWeek',DayofMonth='$DayofMonth',WeekNumber='$WeekNumber', EntryStart='$EntryStart',EntryEnd='$EntryEnd' where UserID='$UserID' and ContentID='$FriendID' and EntryType='reminder'";
							$DB->execute($query);
							//print $query.'<br/>';
						
						}
				
				}

		$CloseWindow=1;
		
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
							$query = "REMOVE from pf_calendar where FeedItemID='$ItemID' and UserID='".$_SESSION['userid']."'";	
							$DB->execute($query);
							
					}
					$CloseWindow=1;
}
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
//submit_form('start');
</script>

<? }



?>  
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
  <a href="#" onclick="parent.edit_item('<? echo $ItemID;?>','<? echo $Section;?>');">[EDIT]</a>
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
                                       
                                        <img src="http://www.wevolt.com/images/wizard_back_btn.png" onclick="submit_form('start');" class="navbuttons">&nbsp;&nbsp;    <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="parent.$.modal().close();" class="navbuttons">
                                    <div style="height:5px;"></div>
                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                                         <div style="height:10px;"></div>
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
                                                    <a href="#" onclick="unpublish_item('My');">[REMOVE FROM]</a>
                                                <? } else {?>
                                                     <a href="#" onclick="submit_form('myvolt'); ">[SEND TO]</a>
                                                <? }?>
                                                </td><td><img src="http://www.wevolt.com/images/myvolt_logo_wizard.png" /></td>
                                            </tr>
                                            <tr>
                                                <td class="messageinfo_white">
                                                <? if ($FeedItemArray->We == 1){?>
                                                    <a href="#" onclick="unpublish_item('We');">[REMOVE FROM]</a>
                                                <? } else {?>
                                                     <a href="#" onclick="submit_form('wevolt'); ">[SEND TO]</a>
                                                <? }?>
                                                </td><td><img src="http://www.wevolt.com/images/wevolt_logo_wizard.png" /></td>
                                            </tr>
                                            <tr>
                                                <td class="messageinfo_white">
                                                <? if ($FeedItemArray->Cal == 1){?>
                                                    <a href="#" onclick="unpublish_item('Cal');">[REMOVE FROM]</a>
                                                <? } else {?>
                                                     <a href="#" onclick="submit_form('calendar'); ">[SEND TO]</a>
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
function hourmin($hid = "hour", $mid = "minute", $pid = "pm", $hval = "", $mval = "", $pval = "")
{
	if(empty($hval)) $hval = date("h");
	if(empty($mval)) $mval = date("i");
	if(empty($pval)) $pval = date("a");

	$hours = array(12, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11);
	$out = "<td><select name='$hid' id='$hid' style='font-size:11px;'>";
	foreach($hours as $hour)
		if(intval($hval) == intval($hour)) $out .= "<option value='$hour' selected>$hour</option>";
		else $out .= "<option value='$hour'>$hour</option>";
	$out .= "</select></td>";

	$minutes = array("00","05", 10, 15, 20,25, 30,35,40, 45,50,55);
	$out .= "<td><select name='$mid' id='$mid' style='font-size:11px;'>";
	foreach($minutes as $minute)
		if(intval($mval) == intval($minute)) $out .= "<option value='$minute' selected>$minute</option>";
		else $out .= "<option value='$minute'>$minute</option>";
	$out .= "</select></td>";
	
	$out .= "<td><select name='$pid' id='$pid' style='font-size:11px;'>";
	$out .= "<option value='am'>am</option>";
	if($pval == "pm") $out .= "<option value='pm' selected>pm</option>";
	else $out .= "<option value='pm'>pm</option>";
	$out .= "</select></td>";
	
	return $out;
}

    function DateSelector($inName, $useDate='') 
    { 
        /* create array so we can name months */ 
        $monthName = array(1=> "January", "February", "March", 
            "April", "May", "June", "July", "August", 
            "September", "October", "November", "December"); 
 
        /* if date invalid or not supplied, use current time */ 
      
	    if($useDate == '') 
        { 
            $useDate = time(); 
        } else {
		 	$useDate = convert_datetime($useDate);
		}
 		
        /* make month selector */ 
        $string .= "<td><select name=" . $inName . "_month style='font-size:11px;'>\n"; 
        for($currentMonth = 1; $currentMonth <= 12; $currentMonth++) 
        { 
             $string .= "<OPTION VALUE=\""; 
			 if (strlen($currentMonth) <2)
			 	$string .= '0'.intval($currentMonth); 
            else 
			   $string .= intval($currentMonth); 
             $string .= "\""; 
            if(intval(date( "m", $useDate))==$currentMonth) 
            { 
                 $string .= " SELECTED"; 
            } 
             $string .= ">" . $monthName[$currentMonth] . "\n"; 
        } 
         $string .= "</SELECT></td>"; 
 
        /* make day selector */ 
         $string .= "<td><SELECT NAME=" . $inName . "_day style='font-size:11px;'>\n"; 
        for($currentDay=1; $currentDay <= 31; $currentDay++) 
        { 
             $string .= "<OPTION VALUE=\"";
			 
			  if (strlen($currentDay) <2)
			 	$string .= '0'.intval($currentDay); 
            else 
			   $string .= intval($currentDay); 
			 
			 
			 $string .="\""; 
            if(intval(date( "d", $useDate))==$currentDay) 
            { 
                 $string .= " SELECTED"; 
            } 
             $string .= ">$currentDay\n"; 
        } 
         $string .= "</SELECT></td>"; 
 
        /* make year selector */ 
         $string .= "<td><SELECT NAME=" . $inName . "_year style='font-size:11px;'>\n"; 
        $startYear = date( "Y", $useDate); 
        for($currentYear = $startYear; $currentYear <= $startYear+5;$currentYear++) 
        { 
             $string .= "<OPTION VALUE=\"$currentYear\""; 
            if(date( "Y", $useDate)==$currentYear) 
            { 
                 $string .= " SELECTED"; 
            } 
             $string .= ">$currentYear\n"; 
        } 
         $string .= "</SELECT></td>"; 
 return $string;
} 

 function DayDropdown($inName, $useDate='') 
    { 
      
	    if($useDate == '') 
        { 
            $useDate = intval(date('d')); 
        } else {
		 $useDate = intval($useDate); 
		}
 		
             /* make day selector */ 
         $string .= "<SELECT NAME=" . $inName . " style='font-size:11px;'>\n"; 
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

</script>
<div id="eventsched" style="padding:5px;">
   <div style="height:10px;"></div>

<table width="97%" cellpadding="0" cellspacing="0">

<tr>
<td  align="left" class="messageinfo_white" width="75">Comment:</td><td>
<input id="txtTagline" name="txtTagline" style="width:250px;" value="<? echo $_POST['txtTagline'];?>" type="text"></td>
</tr>
<tr><td colspan="2">
<div class="spacer"></div>
<table width="100%"><tr><td><td class="messageinfo_white" width="50">Start</td>

<? 

if (($_POST['start_time_month'] != '') && ($_POST['start_time_day'] != '') && ($_POST['start_time_year'] != ''))
	$SelectedDate = $_POST['start_time_year'].'-'.$_POST['start_time_month'].'-'.$_POST['start_time_day'].' 00:00:00';
else 
	$SelectedDate = '';
	
echo DateSelector('start_time',$SelectedDate) ;?>

<td class="messageinfo_white">at</td>

<? 

if ($_POST['start_time_hour'] == '')
	$HourSelect = date('h');
else 
	$HourSelect = $_POST['start_time_hour'];
	
if ($_POST['start_time_min'] == '')
	$MinSelect = date('m');
else 
	$MinSelect = $_POST['start_time_min'];
	
if ($_POST['start_time_ampm'] == '')
	$AMPMSelect ='pm';
else 
	$AMPMSelect = $_POST['start_time_ampm'];
	
echo hourmin("start_time_hour", "start_time_min", "start_time_ampm", $HourSelect, $MinSelect, $AMPMSelect);?>
</tr></table>
</td>

</tr>
<tr><td colspan="2"><span class="messageinfo_white">&nbsp;&nbsp;<span id="endset"><a href="#" onClick="toggleEnd('on');">-Set No End-</a></span><span id="noendset" style="display:none;"><a href="#" onClick="toggleEnd('off');">-Set End-</a> This event will repeat until cancelled.</span></span>
<table width="100%"  id='endtr'><tr><td><td width="50"><span class="messageinfo_white">End</span> </td>
<? 

if (($_POST['end_time_month'] != '') && ($_POST['end_time_day'] != '') && ($_POST['end_time_year'] != ''))
	$SelectedDate = $_POST['end_time_year'].'-'.$_POST['end_time_month'].'-'.$_POST['end_time_day'].' 00:00:00';
else 
	$SelectedDate = '';
	
echo DateSelector('end_time',$SelectedDate) ;?>
<td class="messageinfo_white">at</td>
<? 
if ($_POST['end_time_hour'] == '')
	$HourSelect = date('h');
else 
	$HourSelect = $_POST['end_time_hour'];
	
if ($_POST['end_time_min'] == '')
	$MinSelect = date('m');
else 
	$MinSelect = $_POST['end_time_min'];
	
if ($_POST['end_time_ampm'] == '')
	$AMPMSelect ='pm';
else 
	$AMPMSelect = $_POST['end_time_ampm'];
	
echo hourmin("end_time_hour", "end_time_min", "end_time_ampm", $HourSelect, $MinSelect, $AMPMSelect);?>
</tr></table>
</td>

</tr>
<tr><td class="messageinfo_white"><div style="height:5px;"></div>Frequency

</td>
<td class="messageinfo_white"><div style="height:5px;"></div><input type="radio" name="txtFrequency" value="none" onChange="freq_select('none');" checked style="font-size:11px;"/> One Time&nbsp;&nbsp;<input type="radio" name="txtFrequency" value="daily" onChange="freq_select('daily');"/> Daily&nbsp;&nbsp;<input type="radio" name="txtFrequency" value="weekly" onChange="freq_select('weekly');"/> Weekly&nbsp;&nbsp;<input type="radio" name="txtFrequency" value="monthly" onChange="freq_select('monthly');"/> Monthly</td>
</tr>
</table>
<table><tr><td width="300" align="left">
<div id="monthheader1" style="display:none;" class="messageinfo_warning" align="left">
<div style="height:5px;" align="left"></div>Select Week Number and Day of Week</div>
</td><td id="monthheader2" style="display:none;" class="messageinfo_warning">OR Select Day of Month</td></tr></table>
<table>
<tr><td class="messageinfo_white" id="weeknumber" style="display:none;" width="100" align="left">Week Number: <select name="weeknumber" style="font-size:11px;">
<option value='1' <? if ($_POST['weeknumber'] == '1') echo 'selected';?>>1st Week</option>
<option value='2' <? if ($_POST['weeknumber'] == '2') echo 'selected';?>>2nd Week</option>
<option value='3' <? if ($_POST['weeknumber'] == '3') echo 'selected';?>>3rd Week</option>
<option value='4' <? if ($_POST['weeknumber'] == '4') echo 'selected';?>>4th Week</option>
<option value='5' <? if ($_POST['weeknumber'] == '5') echo 'selected';?>>5th Week</option>
</select>
</td>
<td class="messageinfo_white"  id="dayofweek" style="display:none;"  width="100" align="left">Day of Week: <select name="dayofweek" style="font-size:11px;">
<option value='Mon' <? if ($_POST['dayofweek'] == 'Mon') echo 'selected';?>>Monday</option>
<option value='Tues' <? if ($_POST['dayofweek'] == 'Tues') echo 'selected';?>>Tuesday</option>
<option value='Wed' <? if ($_POST['dayofweek'] == 'Wed') echo 'selected';?>>Wednesday</option>
<option value='Thurs' <? if ($_POST['dayofweek'] == 'Thurs') echo 'selected';?>>Thursday</option>
<option value='Fri' <? if ($_POST['dayofweek'] == 'Fri') echo 'selected';?>>Friday</option>
<option value='Sat' <? if ($_POST['dayofweek'] == 'Sat') echo 'selected';?>>Saturday</option>
<option value='Sun' <? if ($_POST['dayofweek'] == 'Sun') echo 'selected';?>>Sunday</option>
</select></td>
<td width="100"></td>
<td id="dayofmonth" style="display:none;" class="messageinfo_white"  width="150">Day of Month:<? echo DayDropdown('dayofmonth',$_POST['dayofmonth']) ;?>

</td>

</tr>
</table>
 </div>
<? }?>              
<input type="hidden" name="TargetSection" value="<? echo $_GET['step'];?>">                
<input type="hidden" name="txtItem" value="<? echo $ItemID;?>">
<input type="hidden" name="ItemType" value="<? echo $FeedItemArray->ItemType;?>">
<input type="hidden" name="txtSection" id="txtSection" value="<? echo $Section;?>">

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