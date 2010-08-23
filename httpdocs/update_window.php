<?php include 'includes/init.php';
include 'includes/content_functions.php';
	
function build_module_template($FeedID, $CellID, $Preview = '0') {
		
	global $DB,$DB2,$ModuleTitleArray,$ModuleIndex,$TypeTarget, $TargetID;
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
	
	<!-- COMMENT FORM MODULE  -->
<table width="'.$MHWidth.'" height="'
.$MHeight.'" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="modtopleft"></td>

	<td id="modtop">';

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
	
	$TabString .= '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr>';
	if ($Preview == 1)
		$TabString .= '<td width="100">'.$ModuleTitleArray[$ModuleIndex]['Title'].'</td><td width="5"></td>';
	
	$TabSpaces .= $ModuleTitleArray[$ModuleIndex]['Tabs'];
	$TabCount = 0;
	//print 'TabSpaces' . $TabSpaces.'<br/>';
	if (($ActiveModules == 0) && ($Preview == 0)) {
			  $TabString .= '<td class="availtabactive" id="'.$CellID.'_1" onclick="select_target_window(\''.$CellID.'_1\');" align="left" width="86">+</td><td width="5"></td>';
			$TabCount++;
	} else {
		$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID = '$CellID' order by Position"; 
		$DB->query($query);
		while ($line = $DB->fetchNextObject()) {
			$ModuleTabIDArray[] = $line->EncryptID;
			$ModuleType = $line->ModuleType;
			$TabString .= '<td width="86" class="' ;
			if (($ModuleType != 'mod_template') && ($ModuleType != 'html') && ($ModuleType != 'excite_box') && ($ModuleType != 'content') && ($_GET['task'] != 'new'))
				$TabString .= 'availtabactive"  onclick="select_target_window(\''.$CellID.'_'.$line->EncryptID.'\');"';
	else 
		$TabString .= 'availtabinactive"';
		
	$TabString .= ' align="left">'.$line->Title.'</td><td width="5"></td>';
			
	
	
			
			$TabCount++;
		}
		
		if (($TabCount < $TabSpaces) && ($_GET['task'] != 'edit')&& ($_GET['task'] != 'add')) 
			 $TabString .= '<td class="availtabactive" id="'.$CellID.'_1" onclick="select_target_window(\''.$CellID.'_1\');" align="left" width="86">+</td><td width="5"></td>';
			
	}
	$TabString .= '</tr></table>';
	
	$ModuleString .= $TabString.'</td><td id="modtopright" valign="top">';
	
	if ($Preview == 1)
		$ModuleString .='<a href="#"><img src="/templates/modules/standard/action_star.png" hspace="3" vspace="3" border="0"></a>';
		
		$ModuleString .='</td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" height="'.$MHeight.'">
	<div style="height:'.$MHeight.'px;overflow:auto;" align="center">';
		
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
			$ModuleString .='<div style="height:15px;"></div>'.$ModuleTitleArray[$ModuleIndex]['Title'];
		
		}
	
	$ModuleString .='</div>
	<div class="spacer"></div>
	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>

<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
</table>
<!-- END MODULE  -->';
		
	return $ModuleString;

}


$Name = $_GET['name'];
$ProjectType = $_GET['type'];
$RePost = 0;

$DB = new DB();
$DB2 = new DB();

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
			  where f.UserID='$UserID'";
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
			  where f.ProjectID='$ProjectID'";
	  
	$FeedArray = $DB->queryUniqueObject($query);
	
}
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
		$Tags = mysql_real_escape_string($_POST['txtWindowTags']);
		$Description = mysql_real_escape_string($_POST['txtWindowDescription']);
		$Layout = $_POST['txtLayout'];
		$Privacy = $_POST['txtPrivacy'];
		$ThumbSize = $_POST['txtThumbSize'];
		$UserID = $_SESSION['userid'];
		$CreateDate = date('Y-m-d h:i:s');
		$TabID = $_POST['txtTab'];
		$ModuleID = $_POST['txtModuleID'];
		$IsMain = $_POST['txtMain'];
		$ModuleType = $_POST['txtModuleType'];
		
		if ($IsMain == '')
			$IsMain = 0;
		
		if ($_GET['task'] == 'new') {
			
			if ($IsMain == 1) {
				$query = "SELECT ID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$CurrentMain = $DB->queryUniqueValue($query);
				if ($CurrentMain != '') {
					$query = "UPDATE feed_modules set IsMain='0' where FeedID='$FeedID' and ID='CurrentMain'";
					$DB->execute($query);
				
				}
			}
			$query ="SELECT Position from feed_modules WHERE Position=(SELECT MAX(Position) FROM feed_modules where CellID='$TargetModule' and FeedID='$FeedID')";
			$NewPosition = $DB->queryUniqueValue($query);
			$NewPosition++;
			
			$query = "INSERT into feed_modules (Title, CellID, ModuleTemplate, ThumbSize, FeedID,Privacy,IsMain,CreateDate, Position,ModuleType, Description, Tags) values ('$Title','$CellID','$Layout','$ThumbSize','$FeedID','$Privacy', '$IsMain','$CreateDate','$NewPosition','$ModuleType','$Description','$Tags')";
			$DB->execute($query);
			
			$query = "SELECT ID from feed_modules where CreateDate='$CreateDate'";
			$ModuleID = $DB->queryUniqueValue($query);
			
			$Encryptid = substr(md5($ModuleID), 0, 12).dechex($ModuleID);
			
			$query = "UPDATE feed_modules set EncryptID='$Encryptid' where ID='$ModuleID'";
			
			$DB->execute($query);
			$ModuleID = $Encryptid;
			$RePost = 1;
			insertUpdate('window', 'created', $ModuleID, 'user', $UserID,'http://users.w3volt.com/'.trim($_SESSION['username']).'/?window='.$ModuleID);
			
			$query ="SELECT ID from pf_forum_categories WHERE UserID='".$_SESSION['userid']."') and Title='Windows'";
			$CatExists = $DB->queryUniqueValue($query);
			
			if ($CatExists == '') {
				$query ="SELECT Position from pf_forum_categories WHERE Position=(SELECT MAX(Position) FROM pf_forum_categories where UserID='".$_SESSION['userid']."')";
				$NewPosition = $DB->queryUniqueValue($query);
				$NewPosition++;
				
				$query = "INSERT into pf_forum_categories (UserID, Title, Description, Position, CreatedDate) values ('".$_SESSION['userid']."', 'Windows','The Forum for ".trim($_SESSION['username'])."'s W3VOLT windows','$NewPosition','$CreateDate')";
				$DB->execute($query);
				
				$query ="SELECT ID from from pf_forum_categories WHERE Title = 'Windows' and CreatedDate='$CreateDate' and UserID='".$_SESSION['userid']."'";
				$CatID = $DB->queryUniqueValue($query);
				
				$Encryptid = substr(md5($CatID), 0, 12).dechex($CatID);
					
				$query = "UPDATE pf_forum_categories set EncryptID='$Encryptid' where ID='$CatID'";
				$DB->execute($query);
			
			} else {
				$CatID = $CatExists;
			
			}
			
			$query = "INSERT into pf_forum_boards (UserID, CatID, Title, Description, Position, CreatedDate, PrivacySetting) values ('".$_SESSION['userid']."', $CatID,'General Discussion','General Discussion board for ".$_SESSION['username']."'s W3VOLT page and Windows',1,'$Date','public')";
			$DB->execute($query);
			
			$query ="SELECT ID from from pf_forum_boards WHERE Title = 'General Discussion' and CreatedDate='$Date' and UserID='".$_SESSION['userid']."'";
			$NewID = $DB->queryUniqueValue($query);
			$Encryptid = substr(md5($NewID), 0, 12).dechex($NewID);
				
			$query = "UPDATE pf_forum_boards set EncryptID='$Encryptid' where ID='$NewID'";
			$DB->execute($query);
		
			//header("Location:feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
		
		} else if ($_GET['task'] == 'edit') {
			if ($IsMain == 1) {
				$query = "SELECT EncryptID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$CurrentMain = $DB->queryUniqueValue($query);
				if ($CurrentMain != $ModuleID) {
					$query = "UPDATE feed_modules set IsMain='0' where FeedID='$FeedID' and ID='CurrentMain'";
					$DB->execute($query);
				
				}
			} 
			$query = "UPDATE feed_modules set Title='$Title', Description='$Description', Tags='$Tags', CellID='$CellID', ModuleTemplate='$Layout', ThumbSize='$ThumbSize', IsMain='$IsMain',Privacy='$Privacy',Position='$TabID' where EncryptID='$ModuleID'";
			$DB->execute($query);
			if ($_GET['step'] =='finish')
				header("Location:feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
		
			else 
				header("Location:view_feed.php?".$TypeTarget."=".$TargetID);
		
		}
	
}
$CloseWindow = 0;
if (($_GET['step'] == 'add_return') || ($_GET['step'] =='add_exit')) { 
		$CellID = $_POST['CellID'];	
		$Title = mysql_real_escape_string($_POST['txtItemTitle']);
		$Tags = mysql_real_escape_string($_POST['txtItemTags']);
		$Description = mysql_real_escape_string($_POST['txtItemDescription']);
		$UserID = $_SESSION['userid'];
		$CreateDate = date('Y-m-d h:i:s');
		$ModuleID = $_POST['txtModuleID'];
		$ContentType = $_POST['ContentType'];
		$ContentID = $_POST['ContentID'];
		$Thumb = $_POST['txtThumb'];
		$Link = $_POST['txtItemLink'];
		
		
		if ($ContentType == 'project') {
			$ContentType = 'project_link';
			$ProjectID = $ContentID;
		} else if ($ContentType == 'user') {
			$ContentType = 'user_link';
		
		} else {
			$ContentType = 'external_link';
		}
		
		$query ="SELECT Position from feed_items WHERE Position=(SELECT MAX(Position) FROM feed_items where ModuleID='$ModuleID' and FeedID='$FeedID')";
			$NewPosition = $DB->queryUniqueValue($query);
			$NewPosition++;
			
		$query = "INSERT into feed_items (ModuleID, Title, FeedID, CreatedDate, Tags,ItemType, Link, Description,UserID, Position, ProjectID,Thumb) values ('$ModuleID','$Title','$FeedID','$CreateDate','$Tags','$ContentType','$Link','$Description','".$_SESSION['userid']."','$Position','$ProjectID','$Thumb')";
			$DB->execute($query);
				//print $query;
			$query = "SELECT ID from feed_items where CreatedDate='$CreateDate'";
			$ItemID = $DB->queryUniqueValue($query);
			//	print $query;
			$Encryptid = substr(md5($ItemID), 0, 12).dechex($ItemID);
			
			$query = "UPDATE feed_items set EncryptID='$Encryptid' where ID='$ItemID'";
				//print $query;
			$DB->execute($query);
			insertUpdate('window', 'added', $Encryptid, 'user', $UserID,'http://users.w3volt.com/'.trim($_SESSION['username']).'/?window='.$ModuleID);

			if ($_GET['step'] =='add_return')
				header("Location:feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
			//$CloseWindow = 1;
		
			else 
				$CloseWindow = 1;

}


if (($_GET['step'] != '') && ($_GET['step'] !='add')) { 
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
					$CellString = build_module_template($FeedID, $Cell,$Preview );		
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
		$query = "SELECT * from feed_modules where EncryptID='".$_POST['TargetWindow']."'";
		$WindowArray = $DB->queryUniqueObject($query);
	}
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Update Excite Status</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://www.w3volt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="http://www.w3volt.com/ajax/ajax_init.js"></script>
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
    var url="http://www.w3volt.com/connectors/getSearchResults.php";
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

		var formaction = 'feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step='+step;
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
		} else { 
			step = 2;
			task = '<? echo $_GET['task'];?>';
		}
		submit_form(step, task,'');

}
var Template = '<? echo $ContentWindowArray->ModuleTemplate?>';
function select_link(value) {

	if (value == 'search') {
		document.getElementById("searchupload").style.display = '';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("searchtab").className ='tabactive';
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
	} else if (value == 'url') {
		document.getElementById("urltab").className ='tabactive';
		document.getElementById("urlupload").style.display = '';
		document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabinactive';
		
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
		
	} else if (value == 'my') {
	
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
	
	document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabactive';
		document.getElementById("myupload").style.display = '';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
	
		
		
	} else if (value == 'fav') {
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("searchtab").className ='tabinactive';
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
		document.getElementById("txtItemTitle").value = title;
		document.getElementById("txtItemDescription").value = description;
		document.getElementById("txtItemTags").value = tags;
		document.getElementById("txtItemLink").value = contentlink;
		document.getElementById("search_container").style.display = 'none';
		document.getElementById("search_results").innerHTML = '';
			
		if ((Template == 'content_thumb_title') || (Template == 'content_thumb')|| (Template == 'content_thumb_title_description')) {
			document.getElementById("thumbselect").style.display = 'none';
			document.getElementById("thumbdisplay").style.display = '';
			document.getElementById("itemthumb").src = contentthumb;
			document.getElementById("txtThumb").value = contentthumb;
		}
}
 
 


</script>
<style type="text/css">
	<!--
#modrightside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/right_side.png);
	background-repeat:repeat-y;
}

#modleftside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/left_side.png);
	background-repeat:repeat-y;
}

#modtop {
	height:38px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_bar.png);
	background-repeat:repeat-x;
}

.boxcontent {
	color:#000000;
	background-color:#FFFFFF;
}

#modbottom {
	height:9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_bar.png);
	background-repeat:repeat-x;
}

#modbottomleft{
	width:9px;
	height:9px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_left.png);
	background-repeat:no-repeat;
}

#modtopleft{
	width:9px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_left.png);
	background-repeat:no-repeat;
}

#modtopright{
	width:31px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_right.png);
	background-repeat:no-repeat;
}

#modbottomright{
	width:31px;
	height:9px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_right.png);
	background-repeat:no-repeat;
}


.tabactive {
height:12px;
background-color:#f58434;
text-align:center;
padding:5px;
cursor:pointer;
font-weight:bold;
font-size:12px;
}
.tabinactive {
height:12px;
background-color:#dc762f;
text-align:center;
padding:5px;
cursor:pointer;
color:#FFFFFF;
font-size:12px;
}
.tabhover{
height:12px;
background-color:#ffab6f;
color:#000000;
text-align:center;
padding:5px;
cursor:pointer;
font-size:12px;
}

-->
</style>
</head><body>

                       
                        <div style="background-image:url(http://www.w3volt.com/images/wizard_bg.jpg); background-repeat:no-repeat; background-position:top left;width:725px; height:628px;" align="left"><img src="http://www.w3volt.com/images/wizard_volt.jpg" /><img src="http://www.w3volt.com/images/wizard_edit.jpg" /><img src="http://www.w3volt.com/images/wizard_info.jpg" />
                                    
                               <div style="height:420px;width:600px;" align="left">
                           <form name="modform" id="modform" method="post">
                            <? if (!isset($_GET['step'])){ ?>
                            <div class="wizardheadlines" style="padding-left:50px; padding-top:50px;">
                                       Welcome to the window design wizard. <br />
<br />
Click on the "info" button in the top right corner at any time for help. 
</div>
<div align="center" style="padding-right:100px; padding-top:25px;">
<img src="http://www.w3volt.com/images/create_new_window.png"  border="0" vspace="5" onClick="submit_form('1','new','');" class="navbuttons"/><br />
<img src="http://www.w3volt.com/images/add_to_window.png"  border="0" vspace="5" onClick="submit_form('1','add','');" class="navbuttons"/><br />
<? if ($_GET['add'] != 1) {?>
<a href="/feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step=1&task=edit"><img src="http://www.w3volt.com/images/edit_exisiting_window.png"  border="0" vspace="5"/></a><br />
<? }?>
</div>
                                     
                            <? } else if ($_GET['step'] == 1) {?>
                            <div class="spacer"></div>
                            <div style="padding-left:20px;">
                            <? if ($_GET['task'] == 'new') {?>
							Click the '+' mark on the window cell you would like this new window to sit. <div class="spacer"></div>
							
							<? } else  if ($_GET['task'] == 'add') {?>
                            Click the window that you would like to add items too. <div style="font-size:10px; font-style:italic;"><br />
<br />
Only tabs that are custom lists and HTML windows can be added to, template windows and dynamic windows are not available to edit items. You would need to edit the settings for those windows to filter content. </div><div class="spacer"></div>
                            
                           <? } else  if ($_GET['task'] == 'edit') {?>
                            Click the window you would like to edit<div class="spacer"></div>
                            
                            <? }?>
                             <?  echo $FeedTemplate;?> 

                                       </div>                                  
                             <? } else if (($_GET['step'] == 2) && ($_GET['task'] == 'new')){ ?>
											Set the privacy level of this window: <br />
<br />

                                            <input type="radio" name="Privacy" value="Private" <? if ($_POST['txtPrivacy'] == 'Private') echo 'checked';?>>Private (Only you can see this module)<br>
                                            <input type="radio" name="Privacy" value="Friends" <? if ($_POST['txtPrivacy'] == 'Friends') echo 'checked';?>>Friends (Only Friends can see this module)<br>
                                            <input type="radio" name="Privacy" value="Fans" <? if ($_POST['txtPrivacy'] == 'Fans') echo 'checked';?>>Fans (Only Fans can see this module)<br>
                                            <input type="radio" name="Privacy" value="Public" <? if (($_POST['txtPrivacy'] == 'Public')||($_POST['txtPrivacy'] == '')) echo 'checked';?>>Public (Everyone can see this module)<br>
                                           
                                            <input type="button" onClick="submit_form('5','<? echo $_GET['task'];?>','');" value="NEXT!">                        
                                            
                                 <? } else if (($_GET['step'] == 2) && ($_GET['task'] == 'add')){ ?>
											Below is the current privacy setting of this window. Change below or skip to keep the same.<br />
<br />

                                            <input type="radio" name="Privacy" value="Private" <? if ($WindowArray->Privacy == 'Private') echo 'checked';?>>Private (Only you can see this module)<br>
                                            <input type="radio" name="Privacy" value="Friends" <? if ($WindowArray->Privacy == 'Friends') echo 'checked';?>>Friends (Only Friends can see this module)<br>
                                            <input type="radio" name="Privacy" value="Fans" <? if ($WindowArray->Privacy == 'Fans') echo 'checked';?>>Fans (Only Fans can see this module)<br>
                                            <input type="radio" name="Privacy" value="Public" <? if ($WindowArray->Privacy == 'Public')echo 'checked';?>>Public (Everyone can see this module)<br>
                                           
                                            <input type="button" onClick="submit_form('5','<? echo $_GET['task'];?>','');" value="NEXT!">                        
                                            
                                <? } else if ($_GET['step'] == 3) { ?>
                                          
            
                                         
                                     
                                <? } else if ($_GET['step'] == 4) { ?>
                                           
            
                                             
                                           
                                         
                                <? } else if ($_GET['step'] == 5) { ?>
                                            
           
                                            
                                             WHAT TYPE OF CONTENT WILL GO IN THIS WINDOW? <br><br>

                                            
                                            <input type="radio" name="txtModuleType" value="list" <? if (($_POST['txtModuleType'] == '') || ($_POST['txtModuleType'] == 'list')) echo 'checked';?>/>CUSTOM LIST<br />
                                            A custom list is a list of stuff that you put into this window. No content will be pulled from the Database or fed from another source.<br><br>


                                            
                                            <input type="radio" name="txtModuleType" value="content" <? if ($_POST['txtModuleType'] == 'content') echo 'checked';?>/> DYNAMIC LIST<br />
                                            A dynamic list is pulled from another source like an RSS feed or content on W3 Volt like a 'Top 10 W3Volt Comics' window is pulled straight from our database without any further interaction with you. <br>
<br>

                                            
                                            <? if ($_POST['ContentID'] != '') {?><input type="radio" name="txtModuleType" value="template" <? if ($_POST['txtModuleType'] == 'content') echo 'checked';?>/> W3 WINDOW<br />
											A W3 Window is a template window that we've built that you just plug and play. These include flash templates or imports from another site like Facebook or Twitter. <br>
<br>
<? }?>
                                            
                                            <input type="radio" name="txtModuleType" value="custom" <? if ($_POST['txtModuleType'] == 'custom') echo 'checked';?>/> CUSTOM HTML<br />This is open for you to do anything you want. Write some text / HTML or whatever. This will open an easy to use WSYWIG editor to create the window. <br>
<br>

                                            
                                             <input type="button" onClick="submit_form('6','<? echo $_GET['task'];?>','');" value="NEXT!">
                                          
                                          
                                <? } else if ($_GET['step'] == 6) { ?>
                                        
                                            <? if ($_POST['txtModuleType'] == 'custom') { ?>
                                                <script type="text/javascript">
                                                    submit_form('9','<? echo $_GET['task'];?>','');
                                                </script>
                                            <? } else  if (($_POST['txtModuleType'] == 'list') || ($_POST['txtModuleType'] == 'content')){?>
                                                    WHAT TYPE OF LAYOUT DO YOU WANT THIS MODULE TO HAVE? <br><br>
<strong>TEXT LAYOUTS:<br></strong>

                                                    Title will just show the title of the item, no link or html.<br>
                            						Title / Link layout will just show the title of the item, if a link is supplied then the link will open in a new window.<br>
                                                    Title / Link / Description layout will show the linkable title of the item and a short description below. <br><br>

                                                
                                                    <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','content_list_link');" value="TITLE">&nbsp;&nbsp;
                                                    <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','content_list_link');" value="TITLE / LINK">&nbsp;&nbsp;
                                                    <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','content_list_desc');" value="TITLE/LINK/DESCRIPTION"><br><br>

                                                 <strong>   Thumbnail Layouts:<br>
</strong>											    Thumbnails layout will show a thumbnail only, if link provided this will be clickable. <br>
                                                    Thumbnails / Title layout will show a thumbnail with a title below. <br>
                                                    Thumbnails / Title / Description layout list each item verically with the Thumb left aligned and the Title / Description next to it. <br>
<br>
 
                                                    <input type="button" onClick="submit_form('7','<? echo $_GET['task'];?>','content_thumb');" value="THUMBNAILS">&nbsp;&nbsp;
                                                    <input type="button" onClick="submit_form('7','<? echo $_GET['task'];?>','content_thumb_title');" value="THUMBNAILS W/ TITLE">&nbsp;&nbsp;
                                                   <input type="button" onClick="submit_form('7','<? echo $_GET['task'];?>','content_thumb_title_desc');" value="THUMBNAILS W/ TITLE and DESCRIPTION"><br>
                                                   
                                            <? }?>
                                            
                                <? } else if ($_GET['step'] == 7) { ?>
                                                               WHAT SIZE THUMBNAILS WOULD YOU LIKE? <br>
                                                 For this Module the reccomended size is <? echo $RecSize;?><br>
                                                <select name="thumbsize">
                                                   <option value="25" <? if (($_POST['txtThumbSize'] == '25') || ($RecSize == '25')) echo 'selected';?>>25</option>
                                                   <option value="50"<? if (($_POST['txtThumbSize'] == '50') || ($RecSize == '50')) echo 'selected';?>>50</option>
                                                   <option value="75"<? if (($_POST['txtThumbSize'] == '75') || ($RecSize == '75')) echo 'selected';?>>75</option>
                                                   <option value="100"<? if (($_POST['txtThumbSize'] == '100') || ($RecSize == '100')) echo 'selected';?>>100</option>
                                                   <option value="200"<? if (($_POST['txtThumbSize'] == '200') || ($RecSize == '200')) echo 'selected';?>>200</option>
                                                 </select>
                                                 <input type="button" onClick="submit_form('8','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="PREVIEW">
                                                <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="NEXT!">
                                            
                                <? } else if ($_GET['step'] == 8) { ?>
                                
                                             <?
                                             echo $FeedTemplate;?>
                                         <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="NEXT!"><br>
                                        <input type="button" onClick="submit_form('7','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="BACK TO SIZE"><br>
                                           
                                <? 	} else if ($_GET['step'] == 9) { ?>
                                          	Enter a title for the window. <br />
<blockquote>This title will appear in the tab and is limited to 20 characters. However you can also add a description to this tab that will appear when the user hovers over the tab.</blockquote>
Window Name<br />

                                               	 <input type="text" size="10" name="Name" value="<? echo $_POST['Name'];?>"> <br /><br />

 Window Description<br /><textarea name="Description"  style="width:300px;height:50px;"><? echo $_POST['Description'];?></textarea><br />
<br />

Window Tags<br /><textarea name="Tags"  style="width:300px;height:50px;"><? echo $_POST['Tags'];?></textarea><br />
<br />

                                 				 <input type="checkbox" name="main" value="1" class="styled" <? if (($_POST['txtMain'] == '1') || ($_POST['main'] == '1')) echo 'checked="checked"';?>/>Make this Window the main tab <br>
                                                 <br />

<input type="button" onClick="submit_form('10','<? echo $_GET['task'];?>','');" value="NEXT!">

                                 		 <? 	} else if ($_GET['step'] == 10) { ?>	
                                    
                                            <div style="height:10px;"></div>
                                             ARE THE FOLLOWING SETTINGS CORRECT?<br><br>
                                 
                                             Feed Tab Name: <? echo $_POST['Name'];?><br/>
                                             <? if ($_POST['Description'] != ''){?>
                                             Description: <? echo $_POST['Description'];?><br/>
                                             
                                             <? }?>
                                              <? if ($_POST['Tags'] != ''){?>
                                             Tags: <? echo $_POST['Tags'];?><br/>
                                             
                                             <? }?>
                                             Target Cell: <? if ($_POST['txtModuleID'] != '') echo $_POST['txtModuleID']; else if ($_POST['CellID'] != '') echo $_POST['CellID'];?><br/>
                                             Layout Style: <? echo ucwords(str_replace("_", " ",$_POST['txtLayout']));?><br/>
                                             Privacy Settings Style: <? echo $_POST['txtPrivacy'];?><br/>
                                             Main Window: <? if ($_POST['main'] == 1) echo 'Yes'; else echo 'No';?><br />
<br />

											 
                                              If so, finish creating your module and start adding items to it.<br>
                                            <? if ($_GET['task'] == 'new') {?>
                                            
                                                 <input type="button" onClick="submit_form('finish','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="CREATE MODULE AND ADD ITEMS"><br/><br>
                                      
                                            <? } else {?>
                                                   <input type="button" onClick="submit_form('finish','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="SAVE MODULE AND ADD ITEMS"><br/>
                                                   <input type="button" onClick="submit_form('quit','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="SAVE MODULE AND EXIT"><br/><br>
                                      
                                             <? }?>
                        
                                              <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="EDIT NAME"><br/>
                                              <input type="button" onClick="submit_form('1','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="EDIT MODULE PLACEMENT"><br/>
                                              <input type="button" onClick="submit_form('2','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="EDIT PRIVACY SETTINGS"><br/>
                                              <input type="hidden" name="save" value="1" />
                                            
                                          
                                <? } else if ($_GET['step'] == 'add') { ?> 
                                            <div style="padding-left:20px;">
                                          
                                       <? include 'includes/feed_entry_form_inc.php';?>
                                       </div>
                                          
                                <? } ?>
                                </div>
                                 
                                 <!--NAV BUTTONS-->
                                 <div>
           						                         <img src="http://www.w3volt.com/images/back_button.jpg" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<? if ($_GET['step'] == 1) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_1.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_1_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 2) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_2.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_2_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 3) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_3.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_3_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 4) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_4.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_4_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 5) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_5.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_5_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 6) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_6.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_6_off.png" />
								<?  }?>

                                </div>
                                <input type="hidden" name="txtName" value="<? if ($_POST['txtName'] != '') echo $_POST['txtName']; else if ($_POST['Name'] != '')echo $_POST['Name'];?>">
                                <input type="hidden" name="txtWindowDescription" value="<? if ($_POST['txtWindowDescription'] != '') echo $_POST['txtWindowDescription']; else if ($_POST['Description'] != '')echo $_POST['Description'];?>">
                                <input type="hidden" name="txtWindowTags" value="<? if ($_POST['txtWindowTags'] != '') echo $_POST['txtWindowTags']; else if ($_POST['Tags'] != '')echo $_POST['Tags'];?>">
<input type="hidden" name="txtModuleID" value="<? if ($_POST['txtModuleID'] != '') echo $_POST['txtModuleID']; else if ($_GET['module'] != '')echo $_GET['module'];?>">
<input type="hidden" name="TargetWindow" id="TargetWindow" value="<? if ($_POST['TargetWindow'] != '') echo $_POST['TargetWindow']; else if ($_GET['window'] != '')echo $_GET['window'];?>">
<input type="hidden" name="CellID" id="CellID" value="<? if ($_POST['CellID'] != '') echo $_POST['CellID']; else if ($_GET['cell'] != '')echo $_GET['cell'];?>">

<input type="hidden" name="txtPrivacy" value="<? if ($_POST['txtPrivacy'] != '') echo $_POST['txtPrivacy']; else if ($_POST['Privacy'] != '')echo $_POST['Privacy'];?>">
<input type="hidden" name="txtModule" value="<? if ($_POST['txtModule'] != '') echo $_POST['txtModule']; else if ($_POST['Module'] != '')echo $_POST['Module'];?>">
<? if (($_GET['step'] != 'add_return') && ($_GET['step'] !='add_exit')) { ?>
<input type="hidden" id ="ContentType" name="ContentType" value="<? if ($_GET['ctype'] != '') echo $_GET['ctype']; else if ($_POST['ContentType'] != '')echo $_POST['ContentType'];?>">
<input type="hidden" name="RefTitle" value="<? if ($_GET['title'] != '') echo $_GET['title']; else if ($_POST['RefTitle'] != '')echo $_POST['RefTitle'];?>">
<input type="hidden" name="ContentID" id="ContentID" value="<? if ($_GET['content'] != '') echo $_GET['content']; else if ($_POST['ContentID'] != '')echo $_POST['ContentID'];?>">
<input type="hidden" name="Link" value="<? if ($_GET['link'] != '') echo $_GET['link']; else if ($_POST['Link'] != '')echo $_POST['Link'];?>">

<input type="hidden" name="txtTab" value="<? if ($_POST['txtTab'] != '') echo $_POST['txtTab']; else if ($_POST['Tab'] != '')echo $_POST['Tab'];?>">
<input type="hidden" name="txtThumbSize" value="<? if ($_POST['txtThumbSize'] != '') echo $_POST['txtThumbSize']; else if ($_POST['thumbsize'] != '')echo $_POST['thumbsize'];?>">
<input type="hidden" name="txtMain" value="<? if ($_POST['txtMain'] != '') echo $_POST['txtMain']; else if ($_POST['main'] != '') echo $_POST['main'];?>">
<input type="hidden" name="txtLayout" id="txtLayout" value="<? echo $_POST['txtLayout'];?>">
<? if ($_GET['step'] != 5) { ?>
<input type="hidden" name="txtModuleType" id="txtModuleType" value="<? echo $_POST['txtModuleType'];?>">
<? }?>
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
parent.close_wizard(); 
</script>

<? }?>                
<map name="Step2">
  <area shape="rect" coords="77,497,211,522" href="#" onClick="submit_form('1','<? echo $_GET['task'];?>','');">
  <? if ($_GET['task'] == 'new') {?>
  	 <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('4','<? echo $_GET['task'];?>','');">
  <? } else {?> 
   <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('3','<? echo $_GET['task'];?>','');">
  <? }?>
 
</map>
<map name="Step3">
  <area shape="rect" coords="77,497,211,522" href="#" onClick="submit_form('2','<? echo $_GET['task'];?>','');">
  <? if ($_GET['task'] == 'new') {?>
  	 <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('4','<? echo $_GET['task'];?>','');">
  <? } else {?> 
   <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('5','<? echo $_GET['task'];?>','');">
  <? }?>
 
</map>
<map name="Step4">
  <area shape="rect" coords="77,497,211,522" href="#" onClick="submit_form('3','<? echo $_GET['task'];?>');">
   <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('5','<? echo $_GET['task'];?>');">
</map>
</body>
</html>