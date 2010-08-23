<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
include $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';?>

<?

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
function build_module_template($FeedID, $CellID, $Preview = '0') {
	include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
	$DB = new DB();
	global $ModuleTitleArray,$ModuleIndex,$TypeTarget, $TargetID;
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
	$TabString .= '<select name="txtCellSelect" onChange="select_target_window(this.options[this.selectedIndex].value);" style="width:125px; height:20px; font-size:12px;"><option value="0">--select--</option>';
	//$TabString .= '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr>';
	if ($Preview == 1)
		$TabString .= '<td width="100">'.$ModuleTitleArray[$ModuleIndex]['Title'].'</td><td width="5"></td>';
	
	$TabSpaces .= $ModuleTitleArray[$ModuleIndex]['Tabs'];
	$TabCount = 0;
	//print 'TabSpaces' . $TabSpaces.'<br/>';
	if (($ActiveModules == 0) && ($Preview == 0)) {
			 
			 $TabString .= '<option value="'.$CellID.'_1">--> create new dropdown <--</option>';
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
		
		if (($_GET['task'] != 'edit')&& ($_GET['task'] != 'add')) 
			 
			  $TabString .= '<option value="'.$CellID.'_1">--> create new dropdown <--</option>';
			 //$TabString .= '<td class="availtabactive" id="'.$CellID.'_1" onclick="select_target_window(\''.$CellID.'_1\');" align="left" width="86">+</td><td width="5"></td>';
			
	}
	$TabString .= '</select>';
	//$TabString .= '</tr></table>';
	
	if ($Preview == 1) 
	     $ModuleString .= $TabString.'</td><td id="modtopright" valign="top"><a href="javascript:void(0)"><img src="/templates/modules/standard/action_star.png" hspace="3" vspace="3" border="0"></a>';
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
	$DB->close();	
	return $ModuleString;

}


$Name = $_GET['name'];
$ProjectType = $_GET['type'];

if (($Name == '') && ($ProjectType == '')){
	$Name = $_SESSION['username'];
}
$RePost = 0;
$CloseWindow = 0;
$DB = new DB();
if ($ProjectType == '') {
	$TypeTarget = 'name';
	$TargetID = $Name;
	$query = "select * from users where username='$Name'"; 
	$ItemArray = $DB->queryUniqueObject($query);
	$UserID = $ItemArray->encryptid;
	$Email =   $ItemArray->email;
	$FeedOfTitle = $ItemArray->username;
	//print $query.'<br/>';
	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID, fs.TemplateID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID' and f.FeedType='w3'";
	$FeedArray = $DB->queryUniqueObject($query);
		//print $query.'<br/>';
} else {
	$TypeTarget = 'type';
	$TargetID = $ProjectType;
	$query = "select * from projects where SafeTitle='$Name' and ContentType='$ProjectType'";
	$ItemArray = $DB->queryUniqueObject($query);
	$UserID = $UserArray->UserID;
	$ProjectID =  $UserArray->ProjectID;
	$FeedOfTitle = $ItemArray->SafeTitle;

	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID, fs.TemplateID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.ProjectID='$ProjectID' and f.FeedType='w3'";
	  
	$FeedArray = $DB->queryUniqueObject($query);
	
}
if (is_array($SelectedGroups)) {
	$GroupList =@implode(",",$SelectedGroups);
} else if ($_REQUEST['step'] != '') {
	
	$GroupList = $_REQUEST['txtGroups'];
	$SelectedGroups = @explode(',',$GroupList);		
}
if ($SelectedGroups == null)
	$SelectedGroups = array();
$query = "select  * from user_groups where UserID='".$_SESSION['userid']."'"; 
$DB->query($query);

$GroupSelect = '<select name="txtGroups[]" size="3" multiple style="height:35px;">';
while($line = $DB->fetchNextObject()) {
	$GroupSelect .= '<option value="'.$line->ID.'"';
	if (in_array($line->ID,$SelectedGroups))
		$GroupSelect .= ' selected '; 
	$GroupSelect .='>'.$line->Title.'<option>';	
}
$GroupSelect .= '</select>';

if ($FeedArray->EncryptID == '')
	$NotSetup = 1;
else 
	$NotSetup = 0;
	
if (($_SESSION['userid'] == '') || ($UserID != $_SESSION['userid']))
	header("location:http://users.wevolt.com/".$_GET['name']."/");

$FeedID = $FeedArray->EncryptID;
$FeedTemplate = $FeedArray->HtmlLayout;
$TemplateID = $FeedArray->TemplateID;	
$TotalLength = strlen($FeedTemplate);


if ($ModuleID == '')
	$ModuleID = $_POST['txtModuleID'];

if ((($_GET['step'] =='finish')||($_GET['step'] =='quit')) && ($_POST['save'] == 1)) { 
	
		$TargetModule = $_POST['txtModule'];
		if ($TargetModule == '')
			$TargetModule = $_POST['TargetWindow'];
		$CellID = $_POST['CellID'];	
		$Title = mysql_real_escape_string($_POST['txtName']);
		$Tags = mysql_real_escape_string($_POST['txtTags']);
		$Description = mysql_real_escape_string($_POST['txtDescription']);
		$Layout = $_POST['txtLayout'];
		$Privacy = $_POST['txtPrivacy'];
		$ThumbSize = $_POST['txtThumbSize'];
		$UserID = $_SESSION['userid'];
		$CreateDate = date('Y-m-d h:i:s');
		$TabID = $_POST['txtTab'];
		$ModuleID = $_POST['txtModuleID'];
		$IsMain = $_POST['txtMain'];
		$ModuleType = $_POST['txtModuleType'];
		$Content = mysql_real_escape_string($_POST['content']);
		$contentSubSelect = $_POST['contentSubSelect'];
		$contentSelect = $_POST['contentSelect'];
		$contentNumSelect = $_POST['contentNumSelect'];
		
		if ($IsMain == '')
			$IsMain = 0;
		
		if ($_GET['task'] == 'new') {
			
			if ($IsMain == 1) {
				$query = "SELECT ID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$CurrentMain = $DB->queryUniqueValue($query);
				if ($CurrentMain != '') {
					$query = "UPDATE feed_modules set IsMain='0' where FeedID='$FeedID' and ID='$CurrentMain'";
					$DB->execute($query);
				
				}
			} else {
				$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$HasMain = $DB->queryUniqueValue($query);
				if ($HasMain == 0)
					$IsMain = 1;
				
			}
			$query ="SELECT Position from feed_modules WHERE Position=(SELECT MAX(Position) FROM feed_modules where CellID='$CellID' and FeedID='$FeedID')";
			$NewPosition = $DB->queryUniqueValue($query);
			$NewPosition++;
			
			//print $query.'<br/>';
			$query = "INSERT into feed_modules (Title, CellID, ModuleTemplate, ThumbSize, FeedID,Privacy,IsMain,CreateDate, Position,ModuleType, Description, Tags, HTMLCode, ContentVariable, SortVariable, NumberVariable,selected_groups) values ('$Title','$CellID','$Layout','$ThumbSize','$FeedID','$Privacy', '$IsMain','$CreateDate','$NewPosition','$ModuleType','$Description','$Tags','$Content','$contentSelect','$contentSubSelect','$contentNumSelect','$GroupList')";
			$DB->execute($query);
			//print $query.'<br/>';
			$query = "SELECT ID from feed_modules where CreateDate='$CreateDate'";
			$ModuleID = $DB->queryUniqueValue($query);
			
			$Encryptid = substr(md5($ModuleID), 0, 15).dechex($ModuleID);
			$IdClear = 0; 
			$Inc = 5;
			while ($IdClear == 0) {
					$query = "SELECT count(*) from feed_modules where EncryptID='$Encryptid'";
					$Found = $DB->queryUniqueValue($query);
					$output .= $query.'<br/>';
					if ($Found == 1) {
						$Encryptid = substr(md5(($ModuleID+$Inc)), 0, 15).dechex($ModuleID+$Inc);
					} else {
						$query = "UPDATE feed_modules SET EncryptID='$Encryptid' WHERE ID='$ModuleID'";
						$DB->execute($query);
						$output .= $query.'<br/>';
						$IdClear = 1;
					}
					$Inc++;
			}

			$ModuleID = $Encryptid;
	
			insertUpdate('window', 'created', $ModuleID, 'user', $UserID,'http://users.wevolt.com/'.trim($_SESSION['username']).'/?window='.$ModuleID,'',$_POST['txtName']);
			
			$query ="SELECT ID from pf_forum_categories WHERE UserID='".$_SESSION['userid']."' and WindowCat=1";
			$CatExists = $DB->queryUniqueValue($query);
			
			if ($CatExists == '') {
				$query ="SELECT Position from pf_forum_categories WHERE Position=(SELECT MAX(Position) FROM pf_forum_categories where UserID='".$_SESSION['userid']."')";
				$NewPosition = $DB->queryUniqueValue($query);
				$NewPosition++;
				
				$query = "INSERT into pf_forum_categories (UserID, Title, Description, Position, CreatedDate, WindowCat) values ('".$_SESSION['userid']."', 'WEvolt page','The Forum for ".trim($_SESSION['username'])."s WEvolt windows','$NewPosition','$CreateDate',1)";
				$DB->execute($query);
				
				$query ="SELECT ID from pf_forum_categories WHERE CreatedDate='$CreateDate' and UserID='".$_SESSION['userid']."'";
				$CatID = $DB->queryUniqueValue($query);
				
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
			
			} else {
				$CatID = $CatExists;
			
			}
			
			$query = "INSERT into pf_forum_boards (UserID, CatID, Title, Description, Position, CreatedDate, PrivacySetting,WindowsBoard,WindowsID) values ('".$_SESSION['userid']."', $CatID,'WEvolt window - $Title','General Discussion board for ".$_SESSION['username']."s window',1,'$CreateDate','private',1,'$ModuleID')";
			$DB->execute($query);
			//print $query.'<br/>';
			
			$query ="SELECT ID from pf_forum_boards WHERE CreatedDate='$CreateDate' and UserID='".$_SESSION['userid']."'";
			$NewID = $DB->queryUniqueValue($query);
			
			$Encryptid = substr(md5($NewID), 0, 15).dechex($NewID);
			//	print $query.'<br/>';
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
			//	print $query.'<br/>';
		//	$BoardID = $NewID;
		/*
			$query = "INSERT into pf_forum_topics (Subject, ProjectID, BoardID, UserID, PosterID, IsSticky, PrivacySetting, Tags, NotifyOnReply, Message, IsLocked, CreatedDate) 
							values (
							'".mysql_real_escape_string($Title)."',
							'".mysql_real_escape_string($ProjectArray->ProjectID)."',
							'".mysql_real_escape_string($BoardID)."',
							'".$_SESSION['userid']."',
							'w3x987631239087632',
							0,
							'$Privacy',
							'".mysql_real_escape_string($Tags)."',
							1,
							'".mysql_real_escape_string($Description)."',
							0,'$CreateDate')";
							
							$DB->execute($query);
				$query ="SELECT ID from pf_forum_topics WHERE UserID='".$_SESSION['userid']."' and PosterID='w3x987631239087632' and CreatedDate='$CreateDate'";
				$NewID = $DB->queryUniqueValue($query);
				$Encryptid = substr(md5($NewID), 0, 8).dechex($NewID);
				$query = "UPDATE pf_forum_topics SET EncryptID='$Encryptid' WHERE ID='$NewID'";
				$DB->execute($query);	
			*/
			if ($_GET['step'] == 'finish')
				header("Location:/connectors/feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
			else if ($_GET['step'] == 'quit')
				$CloseWindow = 1;
				//header("Location:/connectors/feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
			
		//print $query.'<br/>';
		} 
	
}

if (($_GET['step'] == 'add_return') || ($_GET['step'] =='add_exit')) { 
		$CellID = $_POST['CellID'];	
		$Title = mysql_real_escape_string($_POST['txtTitle']);
		$Content = mysql_real_escape_string($_POST['content']);
		$Tags = mysql_real_escape_string($_POST['txtTags']);
		$Description = mysql_real_escape_string($_POST['txtDescription']);
		$UserID = $_SESSION['userid'];
		$CreateDate = date('Y-m-d h:i:s');
		$ModuleID = $_POST['txtModuleID'];
		$ContentType = $_POST['ContentType'];
		$ContentID = $_POST['ContentID'];
		$Thumb = $_POST['txtThumb'];
		$Link = $_POST['txtLink'];
		$LinkTarget = $_POST['txtLinkTarget'];
		$contentSubSelect = $_POST['contentSubSelect'];
		$contentSelect = $_POST['contentSelect'];
		$contentNumSelect = $_POST['contentNumSelect'];
		$EmbedCode = mysql_real_escape_string($_POST['txtEmbed']);
		$EmbedDimensions = getDimensions($_POST['txtEmbed']);
		$EmbedWidth = $EmbedDimensions['width'];
		$EmbedHeight = $EmbedDimensions['height'];
		if ($Link == 'http://')
			$Link = '';
		if ($ContentType == 'project') {
			$ContentType = 'project_link';
			$ProjectID = $ContentID;
		} else if ($ContentType == 'user') {
			$ContentType = 'user_link'; 
		
		} else {
			$ContentType = 'external_link';
		}
		if ($Content != ''){
				$query = "UPDATE feed_modules set HTMLCode='$Content' where EncryptID='$ModuleID' and FeedID='$FeedID'";
				$DB->execute($query);
				$CloseWindow = 1;
					
			//print $query.'<br/>';
		} else if ($contentSelect != '') {
		
		$query = "UPDATE feed_modules set ContentVariable='$contentSelect', SortVariable='$contentSubSelect', NumberVariable='$contentNumSelect' where EncryptID='$ModuleID' and FeedID='$FeedID'";
				$DB->execute($query);
				$CloseWindow = 1;
		
		//print $query.'<br/>';
		
		} else {
					 $query ="SELECT WePosition from feed_items WHERE Position=(SELECT MAX(WePosition) FROM feed_items where ModuleID='$ModuleID' and WeFeed='$FeedID')";
					$NewPosition = $DB->queryUniqueValue($query);
					$NewPosition++;
				//	print $query.'<br/>';
				$query = "INSERT into feed_items (WeModule, WeFeed, Title, FeedID, CreatedDate, Tags,ItemType, Link, Description,UserID, WePosition, ProjectID,Thumb,Embed,EmbedWidth,EmbedHeight,We,Target) values ('$ModuleID','$FeedID','$Title','$FeedID','$CreateDate','$Tags','$ContentType','$Link','$Description','".$_SESSION['userid']."','$NewPosition','$ProjectID','$Thumb','$EmbedCode','$EmbedWidth','$EmbedHeight',1,'$LinkTarget')";
					$DB->execute($query);
					//print $query.'<br/>';	
					if ($_SESSION['userid'] == '85422afb20e')
						print $query.'<br/>';
					$query = "SELECT ID from feed_items where CreatedDate='$CreateDate' and FeedID='$FeedID'";
					$ItemID = $DB->queryUniqueValue($query);
					if ($_SESSION['userid'] == '85422afb20e')
						print $query.'<br/>';
					$Encryptid = substr(md5($ItemID), 0, 15).dechex($ItemID);
					//print $query.'<br/>';
					
					$IdClear = 0; 
					$Inc = 5;
					while ($IdClear == 0) {
							$query = "SELECT count(*) from feed_items where EncryptID='$Encryptid'";
							$Found = $DB->queryUniqueValue($query);
							$output .= $query.'<br/>';
							if ($Found == 1) {
								$Encryptid = substr(md5(($ItemID+$Inc)), 0, 15).dechex($ItemID+$Inc);
							} else {
								$query = "UPDATE feed_items SET EncryptID='$Encryptid' WHERE ID='$ItemID'";
								$DB->execute($query);
								$output .= $query.'<br/>';
								$IdClear = 1;
							}
							$Inc++;
					}
					insertUpdate('window', 'added', $Encryptid, 'user', $UserID,'http://users.wevolt.com/'.trim($_SESSION['username']).'/?window='.$ModuleID,'',$_POST['txtTitle']);
				
				
					
					if ($_GET['step'] =='add_return')
						header("Location:/connectors/feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
					else 
						$CloseWindow = 1;
					}
					
			

}


if (($_GET['step'] != '') && ($_GET['step'] !='add') && ($CloseWindow == 0)) { 
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
								'Tabs'=>$TemplateArray->Mod1Tabs),
							array(
								'Title'=>$SettingsArray->Module2Title,
								'Width'=>$TemplateArray->Mod2Width,
								'Height'=>$TemplateArray->Mod2Height,
								'Tabs'=>$TemplateArray->Mod2Tabs),
							array(
								'Title'=>$SettingsArray->Module3Title,
								'Width'=>$TemplateArray->Mod3Width,
								'Height'=>$TemplateArray->Mod3Height,
								'Tabs'=>$TemplateArray->Mod3Tabs),
							array(
								'Title'=>$SettingsArray->Module4Title,
								'Width'=>$TemplateArray->Mod4Width,
								'Height'=>$TemplateArray->Mod4Height,
								'Tabs'=>$TemplateArray->Mod4Tabs),
							array(
								'Title'=>$SettingsArray->Module5Title,
								'Width'=>$TemplateArray->Mod5Width,
								'Height'=>$TemplateArray->Mod5Height,
								'Tabs'=>$TemplateArray->Mod5Tabs),
							array(
								'Title'=>$SettingsArray->Module6Title,
								'Width'=>$TemplateArray->Mod6Width,
								'Height'=>$TemplateArray->Mod6Height,
								'Tabs'=>$TemplateArray->Mod6Tabs),
							array(
								'Title'=>$SettingsArray->Module7Title,
								'Width'=>$TemplateArray->Mod7Width,
								'Height'=>$TemplateArray->Mod7Height,
								'Tabs'=>$TemplateArray->Mod7Tabs),
							array(
								'Title'=>$SettingsArray->Module8Title,
								'Width'=>$TemplateArray->Mod8Width,
								'Height'=>$TemplateArray->Mod8Height,
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
			if ($_GET['step'] == 1) { 
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
			}
			
			 if (($_GET['step'] == 1) || (($_GET['step'] == 8) && ($_POST['txtModule'] == $Cell))) {
		   			if ($_GET['step'] == 1){
						$Preview = 0;
						$MHeight = ($ModuleTitleArray[$ModuleIndex]['Height']/5);
						$MHWidth = ($ModuleTitleArray[$ModuleIndex]['Width']/1.5);
				}	else {
						$Preview = 1;
						$MHeight = $ModuleTitleArray[$ModuleIndex]['Height'];
						$MHWidth = $ModuleTitleArray[$ModuleIndex]['Width'];
				}
					$CellString = build_module_template($FeedID, $Cell,$Preview);		
					$FeedTemplate=str_replace("{".$Cell."}","<div style='padding-left:5px;padding-right:5px;'>".$CellString."</div>",$FeedTemplate);	
			} else {
					$FeedTemplate=str_replace("{".$Cell."}","",$FeedTemplate);
			}
			
			 if (($_GET['step'] == 1) || ($_POST['txtModule'] == $Cell)) {
			 
		
				$FeedTemplate=str_replace("{".$Cell."Width}",$MHWidth,$FeedTemplate);
				
				$FeedTemplate=str_replace("{".$Cell."Height}",$MHeight,$FeedTemplate);
			}
			
	}
	
	$ModuleList .= "</select>";
	$TabList .= '</select>';
		
	if ($_GET['step'] == '7') {
		if ($ModuleWidth < 100)
				$RecSize = 50;
		else if ($ModuleWidth < 300)
				$RecSize = 50;
		else if (($ModuleWidth > 300) && ($ModuleWidth < 700))
				$RecSize = 100;
		else 
				$RecSize = 100;
	}
} else if ($_GET['step'] == 'add') {
			$ModuleID = $_GET['module'];

}

if ($_GET['step'] == 'add') {
	if ($_POST['TargetWindow'] != 1) {
		$TargetWindow = $_POST['TargetWindow'];
		if ($TargetWindow  == '')
			$TargetWindow = $_GET['module'];
		$query = "SELECT * from feed_modules where EncryptID='".$TargetWindow."'";
		$WindowArray = $DB->queryUniqueObject($query);
		$Thumb =  '';
	
	}
}
$Step = $_GET['step'];
$DB->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Update Excite Status</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="http://www.wevolt.com/ajax/ajax_init.js"></script>
<script src="http://www.wevolt.com/js/jquery-1.4.2.min.js"></script>
<script src="http://www.wevolt.com/scripts/jquery.qtip-1.0.0-rc3.js"></script>
<style type="text/css">
/* <![CDATA[ */
textarea { clear: both; font-family: sans-serif; font-size: 1em; width: 275px;}
/* ]]> */
</style>

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
	
	for (var i=0; i < document.modform.txtContent.length; i++){
  		 if (document.modform.txtContent[i].checked){
     		 var content = document.modform.txtContent[i].value;
     	 }
   }
    var url="http://www.wevolt.com/connectors/getSearchResults.php";
    url=url+"?content="+content+"&keywords="+escape(keywords);
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
function attach_file( p_script_url ) {
      	script = document.createElement( 'script' );
      	script.src = p_script_url; 
      	document.getElementsByTagName( 'head' )[0].appendChild( script );
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

		var formaction = '/connectors/feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step='+step;
		var ModuleID ='<? echo $ModuleID;?>';
		
		if (step == 'add') {
			if (ModuleID == '') 
				ModuleID = task;
				
			formaction = formaction + '&module='+ModuleID;
		} else { 
			formaction = formaction +'&task='+task;
		}
	if (type != '') {
		document.getElementById("txtLayout").value = type;
	}
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
		var task = '<? echo $_GET['task'];?>';
		if (task == 'add') {
			step = 'add';
			task =  TargetWindow;
		} else if (task == 'edit') { 
			parent.edit_wevolt_window(CellID+'-'+TargetWindow);
		} else {
			step = 2;
			task = '<? echo $_GET['task'];?>';
		
		}
		submit_form(step, task,'');

}
var Template = '<? echo $WindowArray->ModuleTemplate;?>';
function select_link(value) {

	if (value == 'search') {
		document.getElementById("searchupload").style.display = '';
		document.getElementById("urlupload").style.display = 'none';
		//document.getElementById("searchtab").className ='tabactive';
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
	} else if (value == 'url') {
		document.getElementById("urltab").className ='tabactive';
		document.getElementById("urlupload").style.display = '';
		//document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabinactive';
		
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
		
	} else if (value == 'my') {
	
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
	
	//document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabactive';
		document.getElementById("myupload").style.display = '';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
	
		
		
	} else if (value == 'fav') {
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
		//document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabactive';
		document.getElementById("favupload").style.display = '';
		
	}




}

function set_content(title, contentid, contentlink, contentthumb,contenttype,description,tags) {
		select_link('url');
		
		//ERROR FROM HERE SOMEWHERE
		document.getElementById("ContentType").value = contenttype;
		document.getElementById("ContentID").value = contentid;
		document.getElementById("txtTitle").value = title;
		document.getElementById("txtDescription").value = description;
		document.getElementById("txtTags").value = tags;
		document.getElementById("txtLink").value = contentlink;
		document.getElementById("search_container").style.display = 'none';
		document.getElementById("search_results").innerHTML = '';

		if ((Template == 'content_thumb_title') || (Template == 'content_thumb')|| (Template == 'content_thumb_title_description') ||(Template == 'content_thumb_title_desc') ) {
	
			document.getElementById("thumbselect").style.display = 'none';
			document.getElementById("thumbdisplay").style.display = '';
			document.getElementById("itemthumb").src = contentthumb;
			document.getElementById("txtThumb").value = contentthumb;
		}
}
 
 
function show_thumb(value) {
	document.getElementById("previewthumb").width = value;	
}


function select_mod_template(value) {
		if (value == 'twitter') {
			document.getElementById("subselectheader").innerHTML = 'Twitter Username';
			document.getElementById("subselectDiv").style.display = '';
			document.getElementById("numselectDiv").style.display = '';
			
			
		
		} else if (value == 'facebook'){
			document.getElementById("subselectheader").innerHTML = 'Facebook Group ID';
			document.getElementById("subselectDiv").style.display = '';
			document.getElementById("numselectDiv").style.display = 'none';
		
		} else {
			document.getElementById("subselectDiv").style.display = 'none';
			document.getElementById("numselectDiv").style.display = 'none';
	
		}
	document.getElementById("contentNumSelect").selectedIndex = 0;
	document.getElementById("txtLayout").value = value;
	document.getElementById("contentSelect").value = '';
}
function toggle_groups(value) {
	
	if (value == 'groups')
		document.getElementById("group_select").style.display = '';
	else
		document.getElementById("group_select").style.display = 'none';
	
}
</script>

</head><body>

        
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center">

<div style="height:15px;"></div>
<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                        <img src="http://www.wevolt.com/images/window_wizard_banner.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
               <div style="height:10px;"></div>

                                    
                               
                               <div align="center">
                           <form name="modform" id="modform" method="post">
                            <? if ($Step == ''){ ?>
                               <table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
                                           <div class="messageinfo_white">
                                        <? if ($NotSetup == 1) {?>


You have not set up your WEvolt page yet. To do so just <a href="#" onclick="parent.window.location.href='http://users.wevolt.com/<? echo $_SESSION['username'];?>/';">CLICK HERE</a> 


<? } else {?>
                         
                              <div class="spacer"></div>
                                       <b>Welcome to the window design wizard.</b>
 								<div class="spacer"></div>

<img src="http://www.wevolt.com/images/create_new_window.png"  border="0" vspace="5" onClick="submit_form('1','new','');" class="navbuttons" tooltip="This will let you create a new dropdown to place into one of your WEvolt windows" tooltip_position="top"/><div class="spacer"></div>
<img src="http://www.wevolt.com/images/add_to_window.png"  border="0" vspace="5" onClick="submit_form('1','add','');" class="navbuttons" tooltip="This will let you add an item to a Dropdown you have already created." tooltip_position="top"/> <div class="spacer"></div>
<? if ($_GET['add'] != 1) {?>
<a href="/connectors/feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step=1&task=edit" ><img src="http://www.wevolt.com/images/edit_exisiting_window.png"  border="0" vspace="5" tooltip="This will let you edit the settings of a Dropdown you've already created" tooltip_position="top"/>
<? }?>

<? }?>
</div>

</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
<div class="spacer"></div><img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="closeWindow();" class="navbuttons"/>
                                     
                            <? } else if ($Step == 1) {?>
                            <div class="spacer"></div>
                            <div >
                            <table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                            <? if ($_GET['task'] == 'new') {?>
                             
                            <div class="messageinfo_white">
							Select NEW from one of the desired window for this new module. <div class="spacer"></div>
							</div>
							<? } else  if ($_GET['task'] == 'add') {?>
                            Click the window that you would like to add items too. <div style="font-size:10px; font-style:italic;"><br />
<br />
Only tabs that are custom lists and HTML windows can be added to, template windows and dynamic windows are not available to edit items. You would need to edit the settings for those windows to filter content. </div><div class="spacer"></div>
                            
                           <? } else  if ($_GET['task'] == 'edit') {?>
                            Click the window you would like to edit<div class="spacer"></div>
                            
                            <? }?>
                             <?  echo $FeedTemplate;?> 
</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                                       </div>                                  
                             <? } else if (($Step== 2)){ ?>
                               <table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
                                        <? if ($_GET['task'] == 'new') {?>
											Set the privacy level of this window: <br />
<br />									<? } else {?>Below is the current privacy setting of this window. Change below or skip to keep the same.<br />

<? }?>
											<table><tr>
                                            <td style="padding:3px;"><input type="radio" name="Privacy" value="private" <? if (($_POST['txtPrivacy'] == 'private') || ($WindowArray->Privacy  == 'private')) echo 'checked';?> onchange="toggle_groups(this.value);"></td>
                                            <td>Private (Only you can see this module)</td>
                                            </tr>
                                            <tr>
                                             <td style="padding:3px;"> <input type="radio" name="Privacy" value="friends" <? if (($_POST['txtPrivacy'] == 'friends') || ($WindowArray->Privacy  == 'friends')) echo 'checked';?> onchange="toggle_groups(this.value);"></td>
                                            <td>Friends (Only Friends can see this module)</td>
                                             </tr>
                                             <tr>
                                             <td style="padding:3px;"><input type="radio" name="Privacy" value="fans" <? if (($_POST['txtPrivacy'] == 'fans') || ($WindowArray->Privacy  == 'fans'))echo 'checked';?> onchange="toggle_groups(this.value);"></td>
                                            <td> Fans (Only Fans can see this module)</td>
                                             </tr>
                                             <tr>
                                             <td style="padding:3px;"><input type="radio" name="Privacy" value="public" <? if (($_POST['txtPrivacy'] == 'public')|| ($WindowArray->Privacy  == 'public')||($_POST['txtPrivacy'] == '')) echo 'checked';?> onchange="toggle_groups(this.value);"></td>
                                            <td>Public (Everyone can see this module)</td>
                                            </tr>
                                             <tr>
                                             <td style="padding:3px;"><input type="radio" name="Privacy" value="groups" <? if (($_POST['txtPrivacy'] == 'groups')|| ($WindowArray->Privacy  == 'groups')) echo 'checked';?> onchange="toggle_groups(this.value);"></td>
                                            <td>Groups (Only people in the groups you've selected can see this module)</td>
                                            
                                         	</tr>
                                            <tr id="group_select" style="  <? if (($_POST['txtPrivacy'] != 'groups')&& ($WindowArray->Privacy  != 'groups')) {?>display:none;<? }?>">
<td class="messageinfo_white">Groups</td>
<td>
<? echo $GroupSelect;?>
</td>
</tr>
                                         	</table>
                                                     
                                            </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                         <div class="spacer"></div>
                                          
                                             <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','<? echo $_GET['task'];?>','');" class="navbuttons">   <img src="http://www.wevolt.com/images/wizard_next_btn.png" onClick="submit_form('5','<? echo $_GET['task'];?>','');" class="navbuttons">              
                                 <? } else if ($Step== 3) { ?>
                                          
            
                                         
                                     
                                <? } else if ($Step == 4) { ?>
                                           
            
                                           
                                         
                                <? } else if ($Step == 5) { ?>
                                              <table width="500" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="484" align="center">
           
                                            
                                             WHAT TYPE OF CONTENT WILL GO IN THIS WINDOW? <br>
											<table width="98%"><tr>
                                             <td width="180"><div class="white_box" align="center"><input type="radio" name="txtModuleType" value="list" <? if (($_POST['txtModuleType'] == '') || ($_POST['txtModuleType'] == 'list')) echo 'checked';?>/>&nbsp;<span class="messageinfo"><strong>MANUALLY</strong></span>
<div class="spacer"></div>
This is stuff that you manuall put into here. No content is pulled or fed from any other source.
</div>   </td><td width="10"></td><td width="180"><div class="white_box" align="center"><input type="radio" name="txtModuleType" value="content" <? if ($_POST['txtModuleType'] == 'content') echo 'checked';?>/>&nbsp;<span class="messageinfo"><strong>AUTOMATIC</strong></span>
<div class="spacer"></div>
This is a list pulled from another source like an RSS feed or an automated WEvolt search.
</div> </td>
                                            </tr>
                                           <tr><td colspan="3"></td></tr>
                                            <tr>
                                            <td width="180"><div class="white_box" align="center"><input type="radio" name="txtModuleType" value="custom" <? if ($_POST['txtModuleType'] == 'custom') echo 'checked';?>/>&nbsp;<span class="messageinfo"><strong>CUSTOM</strong></span>

<div class="spacer"></div>
You can do anything you want here icluding writing text or HTML. This will open a WYSIWIG editor.
</div> </td><td width="10"></td><td width="185">  <? if ($_POST['ContentID'] == '') {?><div class="white_box" align="center"><input type="radio" name="txtModuleType" value="mod_template" <? if ($_POST['txtModuleType'] == 'mod_template') echo 'checked';?>/>&nbsp;<span class="messageinfo"><strong>PLUG & PLAY</strong></span>
<div class="spacer"></div>
These include flash templates or imports from another site like Twitter updates.
</div> <? }?></td>
                                            </tr>
          									</table>
                                                     
                                            </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        <div class="spacer"></div>
                                          <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('2','<? echo $_GET['task'];?>','');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_next_btn.png"  onClick="submit_form('6','<? echo $_GET['task'];?>','');" class="navbuttons">       
                                <? } else if ($Step == 6) { ?>
                         
                                            <? if ($_POST['txtModuleType'] == 'custom') { ?>
                                            <div class="messageinfo_warning">Enter your window content below</div> <div class="spacer"></div>
                                            <script type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
                                                <script type="text/javascript">
                                                  tinyMCE.init({
													mode: "exact",
													elements : "content",
													theme : "advanced",
													skin : "o2k7",
													spellchecker_rpc_url : '/tinymce/jscripts/tiny_mce/plugins/spellchecker/rpc.php',
												
													theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
													theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,blockquote,|,link,unlink,anchor,cleanup,help,code,|,fullscreen",
													theme_advanced_buttons3 : "formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,image,media,|,preview",
													theme_advanced_toolbar_location : "top",
													theme_advanced_toolbar_align : "left",
													theme_advanced_statusbar_location : "bottom",
													theme_advanced_source_editor_width : "500",
													theme_advanced_source_editor_height : "300",

													plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
												
												});
                                                </script>
                                              <textarea name="content" id="content" style="width:525px; height:225px;"><? if ($_POST['content'] != '') echo $_POST['content'];?></textarea>
                                              <div class="spacer"></div>
                                                <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('5','<? echo $_GET['task'];?>','');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_next_btn.png"  onClick="submit_form('9','<? echo $_GET['task'];?>','custom');" class="navbuttons">       
                                            <? } else  if (($_POST['txtModuleType'] == 'list') || ($_POST['txtModuleType'] == 'content')){
	
	if 	($_POST['txtModuleType'] == 'content')	
		$NextStep = 8;
	else 
		$NextStep = 9;								
												
												?>   
                                            
                                            <div class="messageinfo_white" style="font-weight:bold;">WHAT TYPE OF LAYOUT DO YOU WANT THIS MODULE TO HAVE?<div  style="height:5px;"></div></div>
        <table width="600" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="584" align="center">                                          

<table><tr><td colspan="3" class="messageinfo_warning" align="center"><strong>Text Only Layout</strong></td></tr><tr><td width="180">
<div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('<? echo $NextStep;?>','<? echo $_GET['task'];?>','content_list');" align="center">PLAIN TEXT</div>
<div  style="height:5px;"></div>
This shows a simple non-html, non-linking piece of text
</div>
</td><td width="180"><div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('<? echo $NextStep;?>','<? echo $_GET['task'];?>','content_list_link');" align="center">TITLE & LINK</div>
<div  style="height:5px;"></div>
When the text is clicked it will open the link in a new window.
</div></td><td width="180"> <div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('<? echo $NextStep;?>','<? echo $_GET['task'];?>','content_list_desc');" align="center">LINK & DESC</div>
<div  style="height:5px;"></div>
Shows the link and allows a space for a short description, along with the title. 
</div>
</td></tr></table>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                       <div  style="height:5px;"></div>
                         <table width="600" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="584" align="center">
<table><tr><td colspan="3" class="messageinfo_warning" align="center"> <strong>Thumbnail Layouts:</strong><br></td></tr><tr><td width="180"><div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('7','<? echo $_GET['task'];?>','content_thumb');" align="center">IMAGE</div>
<div  style="height:5px;"></div>
This shows just a clickable image for each entry.
</div>

</td><td width="180"><div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('7','<? echo $_GET['task'];?>','content_thumb_title');" align="center">IMAGE & TITLE</div>
<div  style="height:5px;"></div>
This shows a clickable thumb and adds a title below the image. 
</div></td><td width="180"><div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('7','<? echo $_GET['task'];?>','content_thumb_title_desc');" align="center">ALL</div>
<div  style="height:5px;"></div>
Show the thumb, title and a short description.
</div></td></tr></table>

                                               </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                         <div style="height:5px;"></div><img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('5','<? echo $_GET['task'];?>','');" class="navbuttons">       
                            				                                                   
             <? } else if ($_POST['txtModuleType'] == 'mod_template') {?>
             <div class="messageinfo_white"> <strong>Template Selector</strong></div>
                                <div  style="height:10px;"></div>  
                                 <table width="500" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="484" align="center">
                                		<table width="99%">
                                        <tr>
                                        <td valign="top" width="33%">
                                        Select Type of Template
                                       <select name="contentTemplateSelect" onChange="select_mod_template(this.options[this.selectedIndex].value);">
                                       <option value="" <? if ($_POST['txtLayout'] == '') echo 'selected';?>>--select--</option>
                                                                                <option value="twitter" <? if ($_POST['txtLayout'] == 'twitter') echo 'selected';?>>Twitter</option>
                                        <option value="excite_status" <? if ($_POST['txtLayout'] == 'excite_status') echo 'selected';?>>Last 5 Excites</option>
                                        <option value="excite_single" <? if ($_POST['txtLayout'] == 'excite_single') echo 'selected';?>>Latest Excite</option>
                                        </select>
                                        </td>
                                        <td valign="top" width="33%">
                                         <div id="subselectDiv" <? if ($_POST['txtLayout'] == ''){?>style="display:none;"<? }?>><div id="subselectheader"><? if ($_POST['txtLayout'] == 'facebook') 
										 echo 'Facebook Group ID';
							else if ($_POST['txtLayout'] == 'twitter') 
										 echo 'Twitter Username';?>
                                         
                                         </div>
                                        <input type="text" style="width:98%" name="contentSelect" id="contentSelect" value="<? echo $_POST['contentSelect'];?>">
                                        </div>
                                       
                                        </td>
                                        <td valign="top" width="33%">
                                        <div id="numselectDiv" <? if ($_POST['contentNumSelect'] == ''){?>style="display:none;"<? }?>>
                                        Select numer of results
                                         <select name="contentNumSelect" id="contentNumSelect">
                                         <option value="" <? if ($_POST['contentNumSelect'] == '') echo 'selected';?>>--select--</option>
                                         <option value="5" <? if ($_POST['contentNumSelect'] == '5') echo 'selected';?>>5</option>
                                         <option value="10" <? if ($_POST['contentNumSelect'] == '10') echo 'selected';?>>10</option>
                                         <option value="20" <? if ($_POST['contentNumSelect'] == '20') echo 'selected';?>>20</option>
                                         <option value="50" <? if ($_POST['contentNumSelect'] == '50') echo 'selected';?>>50</option>
                                         <option value="75" <? if ($_POST['contentNumSelect'] == '75') echo 'selected';?>>75</option>
                                          <option value="100" <? if ($_POST['contentNumSelect'] == '100') echo 'selected';?>>100</option>
                                         </select>
                                         </div></td>
                                        </tr>
                                        </table>
                                        
                                                          
                                  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>  <div  style="height:10px;"></div>  
                               <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('5','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_next_btn.png"  onClick="submit_form('9','<? echo $_GET['task'];?>','');" class="navbuttons"> 
             
             
             <? }?>
                                             
    <? } else if ($Step == 7) { 
     if ($_POST['txtModuleType'] == 'content')	
		$NextStep = 8;
	else 
		$NextStep = 9;	?>
                                 <table width="320" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="304" align="center">
                                                             <strong>Size</strong><br>
                                                             What width thumbnail would you like? <br />
We reccommend a width of <? echo $RecSize;?> pixels.<br />
<br />
But hey, you know. Do what you want and all that.<br />
 
<table><tr><td valign="top"><select name="txtThumbSize" onChange="show_thumb(this.options[this.selectedIndex].value);" style="width:125px; height:20px; font-size:12px;">
                                                   
           <option value="25" <? if (($_POST['txtThumbSize'] == '25') || ($RecSize == '25')) echo 'selected';?>>25</option>
           <option value="50"<? if (($_POST['txtThumbSize'] == '50') || ($RecSize == '50')) echo 'selected';?>>50</option>
           <option value="75"<? if (($_POST['txtThumbSize'] == '75') || ($RecSize == '75')) echo 'selected';?>>75</option>
           <option value="100"<? if (($_POST['txtThumbSize'] == '100') || ($RecSize == '100')) echo 'selected';?>>100</option>
           <option value="200"<? if (($_POST['txtThumbSize'] == '200') || ($RecSize == '200')) echo 'selected';?>>200</option>
           </select></td>
           <td><img id="previewthumb" src="http://www.wevolt.com/images/preview_thumb.jpg" width="<? echo $RecSize;?>"/></td></tr></table>
                                                
                                           
                                                
                                  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>   <div  style="height:10px;"></div>            
                                  <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('6','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_next_btn.png"  onClick="submit_form('<? echo $NextStep;?>','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" class="navbuttons">                    
                                <? } else if ($Step == 8) { ?>
                               <div class="messageinfo_white"> <strong>Automatic Content Selector</strong></div>
                                <div  style="height:10px;"></div>  
                                 <table width="500" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="484" align="center">
                                		<table width="99%">
                                        <tr>
                                        <td valign="top" width="33%">
                                        Select Type of Content
                                        <select name="contentSelect">
                                        <option value="comic" <? if ($_POST['contentSelect'] == 'comic') echo 'selected';?>>Comics</option>
                                        <option value="forum" <? if ($_POST['contentSelect'] == 'forum') echo 'selected';?>>Forums</option>
                                        <option value="blog" <? if ($_POST['contentSelect'] == 'blog') echo 'selected';?>>Blogs</option>
                                        </select>
                                        </td>
                                        <td valign="top" width="33%">
                                         Select desired filter
                                        <select name="contentSubSelect">
                                        <option value="ranking" <? if ($_POST['contentSubSelect'] == 'ranking') echo 'selected';?>>By Ranking</option>
                                        <option value="PagesUpdated" <? if ($_POST['contentSubSelect'] == 'PagesUpdated') echo 'selected';?>>Last Updated</option>
                                        <option value="createdate" <? if ($_POST['contentSubSelect'] == 'createdate') echo 'selected';?>>Newest Revolts</option>
                                         <option value="featured" <? if ($_POST['contentSubSelect'] == 'featured') echo 'selected';?>>Featured</option>
                                         <option value="excites" <? if ($_POST['contentSubSelect'] == 'excites') echo 'selected';?>>Most Excites</option>
                                         <option value="pages" <? if ($_POST['contentSubSelect'] == 'pages') echo 'selected';?>>Most Pages</option>
                                        </select>
                                        </td>
                                        <td valign="top" width="33%">
                                        Select numer of results
                                         <select name="contentNumSelect">
                                         <option value="5" <? if ($_POST['contentNumSelect'] == '5') echo 'selected';?>>5</option>
                                         <option value="10" <? if ($_POST['contentNumSelect'] == '10') echo 'selected';?>>10</option>
                                         <option value="20" <? if ($_POST['contentNumSelect'] == '20') echo 'selected';?>>20</option>
                                         <option value="50" <? if ($_POST['contentNumSelect'] == '50') echo 'selected';?>>50</option>
                                         <option value="75" <? if ($_POST['contentNumSelect'] == '75') echo 'selected';?>>75</option>
                                          <option value="100" <? if ($_POST['contentNumSelect'] == '100') echo 'selected';?>>100</option>
                                         </select></td>
                                        </tr>
                                        </table>
                                        
                                                          
                                  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>  <div  style="height:10px;"></div>  
                               <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('5','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_next_btn.png"  onClick="submit_form('9','<? echo $_GET['task'];?>','');" class="navbuttons">     
                                <? 	} else if ($Step == 9) { ?>
                                <div class="messageinfo_white" align="center"><strong>Window Info</strong></div>
                                <table><tr><td valign="top"><table width="261" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="245" align="left"><div style="height:10px;"></div>
                                       <strong> 1. Title<br></strong>
 <input type="text" style="width:240px;" name="txtName" value="<? if ($_POST['Name'] != '') echo $_POST['Name']; else if ($_POST['txtName'] != '')echo $_POST['txtName'];?>"><div style="height:10px;"></div>
<strong>2. Description<br></strong>
<textarea name="txtDescription"  style="width:240px;height:50px;"><? if ($_POST['txtDescription'] != '') echo $_POST['txtDescription']; else if ($_POST['txtWindowDescription'] != '')echo $_POST['txtWindowDescription'];?></textarea><div style="height:10px;"></div>
                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                        
                                        </td>
                                        <td width="10"></td>
                                        
                                        <td valign="top">
<table width="261" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="245" align="left"><div style="height:10px;"></div>
                                        <strong>3. Tags<br></strong>
 <textarea name="txtTags"  style="width:240px;height:50px;"><? if ($_POST['txtTags'] != '') echo $_POST['txtTags']; else if ($_POST['txtWindowTags'] != '')echo $_POST['txtWindowTags'];?></textarea><div style="height:10px;"></div>
<div style="height:10px;"></div>
 <input type="checkbox" name="txtMain" value="1" class="styled" <? if (($_POST['txtMain'] == '1') || ($_POST['main'] == '1')) echo 'checked="checked"';?>/>Make this Window the main tab<div style="height:10px;"></div>
                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        </td></tr></table>
<img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('6','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_next_btn.png"  onClick="submit_form('10','<? echo $_GET['task'];?>','');" class="navbuttons">           


                                 		 <? 	} else if ($Step == 10) { ?>	
                                    
                                            <div style="height:10px;"></div>
                                            <div class="messageinfo_white">Are the following settings correct?</div>
                                  <table><tr><td valign="top"><table width="261" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="245" align="left">
                                            <table><tr><td width="200" style="padding:3px;">Window Name: <? echo $_POST['txtName'];?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('9','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');">edit</a>]</td></tr>
                                       <tr><td width="200" style="padding:3px;">Target Location:<? if ($_POST['txtModuleID'] != '') echo $_POST['txtModuleID']; else if ($_POST['CellID'] != '') echo $_POST['CellID'];?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('1','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');">edit</a>]</td></tr>
                                          
                                             </table>
                                              </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                        
                                        </td>
                                        <td width="10"></td>
                                        
                                        <td valign="top">
                                             <table width="261" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="245" align="left">
                                        
                                        <table><tr><td width="200" style="padding:3px;">Privacy Settings: <? echo $_POST['txtPrivacy'];?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('2','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');">edit</a>]</td></tr>
                                       <tr><td width="200" style="padding:3px;">Main Window :<? if ($_POST['txtMain'] == 1) echo 'Yes'; else echo 'No';?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('9','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');">edit</a>]</td></tr>
                                          
                                             </table>
                                             
                                       
                                          </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        </td></tr></table>
                          <table width="261" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="245" align="left">
                                         <table><tr><td width="200" style="padding:3px;">Window Type: <? echo $_POST['txtModuleType'];?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('5','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');">edit</a>]</td></tr>
                                       <tr><td width="200" style="padding:3px;">Layout Style: <? echo ucwords(str_replace("_", " ",$_POST['txtLayout']));?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('6','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');">edit</a>]</td></tr>
                                       <? if ($_POST['txtThumbSize'] != '') {?><tr><td width="200" style="padding:3px;">Thumb Size: <? echo $_POST['txtThumbSize'];?> pixels wide</td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('7','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');">edit</a>]</td></tr><? }?>
                                          
                                             </table>
                                          </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
						 
                                   <div style="height:10px;"></div>          
                                  
                                            <img src="http://www.wevolt.com/images/wizard_save_exit_btn.png" onClick="submit_form('quit','<? echo $_GET['task'];?>','');" class="navbuttons">              <? if (($_GET['txtModuleType'] != 'html') &&($_GET['txtModuleType'] != 'content')&&($_GET['txtModuleType'] != 'mod_template')) {?><img src="http://www.wevolt.com/images/wizard_save_continue_btn.png"  onClick="submit_form('finish','<? echo $_GET['task'];?>','');" class="navbuttons">  <? }?>
                                               
                                      
                                             
                                              <input type="hidden" name="save" value="1" />
                                            
                                          
                                <? } else if ($Step == 'add') { ?> 
                                    
                                          
                                       <? include $_SERVER['DOCUMENT_ROOT'].'/includes/feed_entry_form_inc.php';?>
                                   
                                          
                                <? } ?>
                                
                                </div>
                                 
                                 <!--NAV BUTTONS-->
                                 <? /*
                                 <div>
           						                         <img src="http://www.wevolt.com/images/back_button.jpg" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<? if ($_GET['step'] == 1) {?>
                                    <img src="http://www.wevolt.com/images/wizard_step_1.png" />
								<? } else { ?>
									<img src="http://www.wevolt.com/images/wizard_step_1_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 2) {?>
                                    <img src="http://www.wevolt.com/images/wizard_step_2.png" />
								<? } else { ?>
									<img src="http://www.wevolt.com/images/wizard_step_2_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 3) {?>
                                    <img src="http://www.wevolt.com/images/wizard_step_3.png" />
								<? } else { ?>
									<img src="http://www.wevolt.com/images/wizard_step_3_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 4) {?>
                                    <img src="http://www.wevolt.com/images/wizard_step_4.png" />
								<? } else { ?>
									<img src="http://www.wevolt.com/images/wizard_step_4_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 5) {?>
                                    <img src="http://www.wevolt.com/images/wizard_step_5.png" />
								<? } else { ?>
									<img src="http://www.wevolt.com/images/wizard_step_5_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 6) {?>
                                    <img src="http://www.wevolt.com/images/wizard_step_6.png" />
								<? } else { ?>
									<img src="http://www.wevolt.com/images/wizard_step_6_off.png" />
								<?  }?>

                                </div><? */
		
								?>
                       
<input type="hidden" name="txtModuleID" value="<? if ($_POST['txtModuleID'] != '') echo $_POST['txtModuleID']; else if ($_GET['module'] != '')echo $_GET['module'];?>">
<input type="hidden" name="TargetWindow" id="TargetWindow" value="<? if ($_POST['TargetWindow'] != '') echo $_POST['TargetWindow']; else if ($_GET['window'] != '')echo $_GET['window'];?>">
<input type="hidden" name="CellID" id="CellID" value="<? if ($_POST['CellID'] != '') echo $_POST['CellID']; else if ($_GET['cell'] != '')echo $_GET['cell'];?>">

<input type="hidden" name="txtPrivacy" value="<? if ($_POST['Privacy'] != '') echo $_POST['Privacy']; else if ($_POST['txtPrivacy'] != '')echo $_POST['txtPrivacy'];?>">
<input type="hidden" name="txtModule" value="<? if ($_POST['txtModule'] != '') echo $_POST['txtModule']; else if ($_POST['Module'] != '')echo $_POST['Module'];?>">
<? if ($_GET['step'] != '2') {?>
<input type="hidden" name="txtGroups" value="<?php if ($_REQUEST['txtGroups'] != '') echo @implode(',', $_REQUEST['txtGroups']); else if ($EventArray->selected_groups != '') echo $EventArray->selected_groups;?>">

<? }?>
<? if (($Step != 'add_return') && ($Step !='add_exit')) { ?>

    <input type="hidden" id ="ContentType" name="ContentType" value="<? if ($_GET['ctype'] != '') echo $_GET['ctype']; else if ($_POST['ContentType'] != '')echo $_POST['ContentType'];?>">
    <input type="hidden" name="RefTitle" value="<? if ($_GET['title'] != '') echo $_GET['title']; else if ($_POST['RefTitle'] != '')echo $_POST['RefTitle'];?>">
    <input type="hidden" name="ContentID" id="ContentID" value="<? if ($_GET['content'] != '') echo $_GET['content']; else if ($_POST['ContentID'] != '')echo $_POST['ContentID'];?>">
    <input type="hidden" name="Link" value="<? if ($_GET['link'] != '') echo $_GET['link']; else if ($_POST['Link'] != '')echo $_POST['Link'];?>">
    <input type="hidden" name="txtTab" value="<? if ($_POST['txtTab'] != '') echo $_POST['txtTab']; else if ($_POST['Tab'] != '')echo $_POST['Tab'];?>">
        <? if( ($Step != 9) &&($Step != 'add')) {?>
        <input type="hidden" name="txtMain" value="<? if ($_POST['txtMain'] != '') echo $_POST['txtMain'];?>">
         <input type="hidden" name="txtName" value="<? if ($_POST['txtName'] != '') echo $_POST['txtName']; else if ($_POST['Name'] != '')echo $_POST['Name'];?>">
          <input type="hidden" name="txtDescription" value="<? if ($_POST['txtDescription'] != '') echo $_POST['txtDescription']; ?>">
          <input type="hidden" name="txtTags" value="<? if ($_POST['txtTags'] != '') echo $_POST['txtTags']; ?>">
        <? }?>

    <input type="hidden" name="txtLayout" id="txtLayout" value="<? echo $_POST['txtLayout'];?>">
<? }?>

<? if ($Step != 5) {
 ?>

<input type="hidden" name="txtModuleType" id="txtModuleType" value="<? echo $_POST['txtModuleType'];?>">
<? }?>
<? if (($Step == 6) &&($_POST['txtModuleType'] == 'mod_template')){?>

<? } else if (($Step != 8)  &&($Step != 'add')){?>
<input type="hidden" name="contentNumSelect" id="contentNumSelect" value="<? echo $_POST['contentNumSelect'];?>">
<input type="hidden" name="contentSelect" id="contentSelect" value="<? echo $_POST['contentSelect'];?>">
<input type="hidden" name="contentSubSelect" id="contentSubSelect" value="<? echo $_POST['contentSubSelect'];?>">
<? }?>

<? if ($Step != 7) {?>
<input type="hidden" name="txtThumbSize" value="<? if ($_POST['txtThumbSize'] != '') echo $_POST['txtThumbSize'];?>">
<? }?>
<? if (($Step != 6) &&($Step != 'add'))  { ?>

 <input type="hidden" name="content" value="<? if ($_POST['content'] != '') echo $_POST['content'];?>">

 <? }?>
</form>
                        </div>
   <? if ($RePost == 1) {?>
   <script type="text/javascript">
  	 submit_form('add','<? echo $ModuleID;?>','');
   </script>
   
   
   <? }?>        
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
closeWindow();
</script>

<? }?>  

<script>

$(document).ready(function() {
	$('*[tooltip]').each(function() {
		var position = $(this).attr('tooltip_position');
		switch (position) {
			case 'right':
				tip = 'leftMiddle';
				target = 'rightMiddle';
				break;
			case 'left':
				tip = 'rightMiddle';
				target = 'leftMiddle';
				break;
			case 'top':
				tip = 'bottomMiddle';
				target = 'topMiddle';
				break;
			case 'bottom':
				tip = 'topMiddle';
				target = 'bottomMiddle';
				break;
			case 'topleft':
				tip = 'bottomRight';
				target = 'topLeft';
				break;
			case 'bottomleft':
				tip = 'topRight';
				target = 'bottomLeft';
				break;
			case 'bottomright':
				tip = 'topLeft';
				target = 'bottomRight';
				break;
			case 'topright':
			default:
				tip = 'bottomLeft';
				target = 'topRight';
		}
		$(this).qtip({
			content: $(this).attr('tooltip'),
			style: {
				name: 'blue',
				tip: tip,
				border: {
			width: 1,
	         radius: 2,
	         color: '#3a3a3a'
				}
			},
			position: {
		       corner: {
			   	   target: target,
			   	   tooltip: tip,
			   	   adjust: {
					  screen: true
			   	   }
	  	 	   }
			} 
		});
	});
});
</script>
              
</body>
</html>