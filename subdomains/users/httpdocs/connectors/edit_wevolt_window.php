<?php 

include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';?>

<?

$Name = $_GET['name'];
$ProjectType = $_GET['type'];
$TargetArray = explode('-',$_GET['window']);
$CellID =  $TargetArray[0];
$ModuleID = $TargetArray[1];
if ($ModuleID == '')
	$ModuleID = $_POST['txtModuleID'];

if ($CellID == '')
	$CellID = $_POST['txtCell'];
	
if (($Name == '') && ($ProjectType == '')){
	$Name = $_SESSION['username'];
}
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
$CloseWindow = 0;
if (($_SESSION['userid'] == '') || ($UserID != $_SESSION['userid']))
	header("location:http://users.wevolt.com/".$_GET['name']."/");

$FeedID = $FeedArray->EncryptID;
$FeedTemplate = $FeedArray->HtmlLayout;
$TemplateID = $FeedArray->TemplateID;	
$TotalLength = strlen($FeedTemplate);

$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID='$CellID' and EncryptID='$ModuleID'";
$WindowArray = $DB->queryUniqueObject($query);


if (($_GET['step'] =='finish')||($_GET['step'] =='quit')||($_GET['step'] =='save')) { 
	
		$TargetModule = $_POST['txtModule'];
		if ($TargetModule == '')
			$TargetModule = $_POST['TargetWindow'];
		$CellID = $_POST['txtCell'];	
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
		$Position = $_POST['txtPosition'];
		
		if ($IsMain == '')
			$IsMain = 0;
			
		if ($IsMain == 1) {
				$query = "SELECT ID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$CurrentMain = $DB->queryUniqueValue($query);
			//print $query.'<br/>';
				if ($CurrentMain != '') {
					$query = "UPDATE feed_modules set IsMain='0' where FeedID='$FeedID' and ID='$CurrentMain'";
					$DB->execute($query);
				//print $query.'<br/>';
				
				}
			}
			$query = "UPDATE feed_modules set Title='$Title', Description='$Description', Tags='$Tags', CellID='$CellID', ModuleTemplate='$Layout', ThumbSize='$ThumbSize', IsMain='$IsMain',Privacy='$Privacy',Position='$Position', HTMLCode='$Content',ContentVariable='$contentSelect', SortVariable='$contentSubSelect', NumberVariable='$contentNumSelect' where EncryptID='$ModuleID'";
			if ($_SESSION['userid'] == '85422afb20e')
				print $query.'<br/>';
			$DB->execute($query);
			//print $query;
			//header("Location:http://users.wevolt.com/".$TargetID."/");
			if ($_SESSION['userid'] != '85422afb20e')
			
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
					//$CellString = build_module_template($FeedID, $Cell,$Preview);		
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
function submit_form(step,type) {

		var formaction = '/connectors/edit_wevolt_window.php?step='+step;
		var ModuleID ='<? echo $ModuleID;?>';
		
		if (step == 'add') {
			if (ModuleID == '') 
				ModuleID = task;
				
			formaction = formaction + '&module='+ModuleID;
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

</script>

</head><body>

<? if ($CloseWindow == 1) {?>
<script>
	closeWindow();
</script>
<? }

?>   
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
                            <? if (($_GET['step'] == '')|| ($_GET['step'] == 1)){ ?>
                               <table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
                            
                    
                              <div class="spacer"></div>
                                       <b>What would you like to edit?</b>
 								<div class="spacer"></div>

						<img src="http://www.wevolt.com/images/window_info_btn.png" onClick="submit_form('9','');" class="navbuttons"/>
<div class="spacer"></div>
<img src="http://www.wevolt.com/images/window_privacy_btn.png" onClick="submit_form('2','');" class="navbuttons"/>
<div class="spacer"></div>
       
 <? if ($WindowArray->ModuleType == 'custom')	{?>
  <img src="http://www.wevolt.com/images/window_content_btn.png" onClick="submit_form('6','');" class="navbuttons"/>


                        <? } else if ($WindowArray->ModuleType == 'mod_template')	{?>
                        <img src="http://www.wevolt.com/images/window_content_btn.png" onClick="submit_form('3','');" class="navbuttons"/>
              
                        <? } else {?>
                        <img src="http://www.wevolt.com/images/window_layout_btn.png" onClick="submit_form('6','');" class="navbuttons"/>
                        <? }?>
<div class="spacer"></div>
 <? if ($WindowArray->ModuleType == 'content')	{?>
<img src="http://www.wevolt.com/images/window_filters_btn.png" onClick="submit_form('8','');" class="navbuttons"/>
  
 <? }?>



</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table> <div class="spacer"></div>
                         <? if ($_GET['step'] != '') {?> 
 <img src="http://www.wevolt.com/images/wizard_save_btn.png" onClick="submit_form('save','');" class="navbuttons"/>&nbsp;&nbsp;
 <? }?><img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="closeWindow();" class="navbuttons"/>
<div class="spacer"></div>

                                     
                            <? } else if (($_GET['step'] == 2)){ ?>
                               <table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
                                        
											Set the privacy level of this window: <br />
<br />									
											<table><tr>
                                            <td style="padding:3px;"><input type="radio" name="txtPrivacy" value="private" <? if ($_POST['txtPrivacy'] == 'private') echo 'checked';?>></td>
                                            <td>Private (Only you can see this module)</td>
                                            </tr>
                                            <tr>
                                             <td style="padding:3px;"> <input type="radio" name="txtPrivacy" value="friends" <? if ($_POST['txtPrivacy'] == 'friends') echo 'checked';?>></td>
                                            <td>Friends (Only Friends can see this module)</td>
                                             </tr>
                                             <tr>
                                             <td style="padding:3px;"><input type="radio" name="txtPrivacy" value="fans" <? if ($_POST['txtPrivacy'] == 'fans')echo 'checked';?>></td>
                                            <td> Fans (Only Fans can see this module)</td>
                                             </tr>
                                             <tr>
                                             <td style="padding:3px;"><input type="radio" name="txtPrivacy" value="public" <? if (($_POST['txtPrivacy'] == 'public')||($_POST['txtPrivacy'] == '')) echo 'checked';?>></td>
                                            <td>Public (Everyone can see this module)</td>
                                         	</tr>
                                         	</table>
                                                     
                                            </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                         <div class="spacer"></div>
                                          
                                             <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','');" class="navbuttons">   <img src="http://www.wevolt.com/images/wizard_save_btn.png" onClick="submit_form('save','');" class="navbuttons">              
                                 <? } else if ($_GET['step'] == 3) { ?>
                                          
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
                                         <div id="subselectDiv" <? if (($_POST['txtLayout'] != 'facebook') &&($_POST['txtLayout'] != 'twitter')){?>style="display:none;"<? }?>><div id="subselectheader"><? if ($_POST['txtLayout'] == 'facebook') 
										 echo 'Facebook Group ID';
							else if ($_POST['txtLayout'] == 'twitter') 
										 echo 'Twitter Username';?>
                                         
                                         </div>
                                        <input type="text" style="width:98%" name="contentSelect" id="contentSelect" value="<? echo $_POST['contentSelect'];?>">
                                        </div>
                                       
                                        </td>
                                        <td valign="top" width="33%">
                                        <div id="numselectDiv" <? if (($_POST['txtLayout'] != 'facebook') &&($_POST['txtLayout'] != 'twitter')){?>style="display:none;"<? }?>>
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
                               <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_next_btn.png"  onClick="submit_form('save','','');" class="navbuttons"> 
             
             
                                         
                                     
                                <? } else if ($_GET['step'] == 4) { ?>
                                           
            
                                           
                                         
                                <? } else if ($_GET['step'] == 5) { ?>
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
</div> </td><td width="10"></td><td width="185">  <? if ($_POST['ContentID'] != '') {?><div class="white_box" align="center"><input type="radio" name="txtModuleType" value="template" <? if ($_POST['txtModuleType'] == 'template') echo 'checked';?>/>&nbsp;<span class="messageinfo"><strong>PLUG & PLAY</strong></span>
<div class="spacer"></div>
These include flash templates or imports from another site like Facbook or Twitter.
</div> <? }?></td>
                                            </tr>
          									</table>
                                                     
                                            </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        <div class="spacer"></div>
                                          <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_save_btn.png"  onClick="submit_form('save','');" class="navbuttons">       
                                <? } else if ($_GET['step'] == 6) { ?>
                                        
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
                                                <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_save_btn.png"  onClick="submit_form('save','custom');" class="navbuttons">       
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
<div class="blue_button" onClick="submit_form('<? echo $NextStep;?>','content_list');" align="center">PLAIN TEXT</div>
<div  style="height:5px;"></div>
This shows a simple non-html, non-linking piece of text
</div>
</td><td width="180"><div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('<? echo $NextStep;?>','content_list_link');" align="center">TITLE & LINK</div>
<div  style="height:5px;"></div>
When the text is clicked it will open the link in a new window.
</div></td><td width="180"> <div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('<? echo $NextStep;?>','content_list_desc');" align="center">LINK & DESC</div>
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
<div class="blue_button" onClick="submit_form('7','content_thumb');" align="center">IMAGE</div>
<div  style="height:5px;"></div>
This shows just a clickable image for each entry.
</div>

</td><td width="180"><div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('7','content_thumb_title');" align="center">IMAGE & TITLE</div>
<div  style="height:5px;"></div>
This shows a clickable thumb and adds a title below the image. 
</div></td><td width="180"><div class="white_box" align="center" style="height:70px;">
<div class="blue_button" onClick="submit_form('7','content_thumb_title_desc');" align="center">ALL</div>
<div  style="height:5px;"></div>
Show the thumb, title and a short description.
</div></td></tr></table>

                                               </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                         <div style="height:5px;"></div><img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','');" class="navbuttons">       
                            				  <input type="hidden" name="txtLayout" id="txtLayout" value="<? if ($_POST['txtLayout'] != '') echo $_POST['txtLayout']; else if ($WindowArray->ModuleTemplate != '')echo $WindowArray->ModuleTemplate;?>">                                                 
                                            <? }?>
                                             
                                <? } else if ($_GET['step'] == 7) { 
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
                                  <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','<? echo $_POST['txtLayout'];?>');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_next_btn.png"  onClick="submit_form('<? echo $NextStep;?>','<? echo $_POST['txtLayout'];?>');" class="navbuttons">                    
                                <? } else if ($_GET['step'] == 8) { ?>
                                
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
                                        <option value="last_updated" <? if ($_POST['contentSubSelect'] == 'last_updated') echo 'selected';?>>Last Updated</option>
                                        <option value="newest" <? if ($_POST['contentSubSelect'] == 'newest') echo 'selected';?>>Newest Revolts</option>
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
                               <img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','<? echo $_POST['txtLayout'];?>');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_save_btn.png"  onClick="submit_form('save','');" class="navbuttons">     
               <? 	} else if ($_GET['step'] == 9) { ?>
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
 <input type="hidden" value="<? echo $_POST['txtPosition'];?>" name="txtPosition" />
                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        </td></tr></table>
<img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','');" class="navbuttons">         <img src="http://www.wevolt.com/images/wizard_save_btn.png"  onClick="submit_form('save','');" class="navbuttons">           


                <? } else if ($_GET['step'] == 11) { ?>	
                                    
                                            <div style="height:10px;"></div>
                                            <div class="messageinfo_white">Are the following settings correct?</div>
                                  <table><tr><td valign="top"><table width="261" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="245" align="left">
                                            <table><tr><td width="200" style="padding:3px;">Window Name: <? echo $_POST['txtName'];?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('9','');">edit</a>]</td></tr>
                                       
                                          
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
                                        
                                        <table><tr><td width="200" style="padding:3px;">Privacy Settings: <? echo $_POST['txtPrivacy'];?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('2','');">edit</a>]</td></tr>
                                       <tr><td width="200" style="padding:3px;">Main Window :<? if ($_POST['txtMain'] == 1) echo 'Yes'; else echo 'No';?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('9','');">edit</a>]</td></tr>
                                          
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
                                         <table><tr><td width="200" style="padding:3px;">Window Type: <? echo $_POST['txtModuleType'];?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('5','');">edit</a>]</td></tr>
                                       <tr><td width="200" style="padding:3px;">Layout Style: <? echo ucwords(str_replace("_", " ",$_POST['txtLayout']));?></td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('6','');">edit</a>]</td></tr>
                                       <? if ($_POST['txtThumbSize'] != '') {?><tr><td width="200" style="padding:3px;">Thumb Size: <? echo $_POST['txtThumbSize'];?> pixels wide</td><td class="pagelinks"  style="padding:3px;">[<a href="#" onClick="submit_form('7','');">edit</a>]</td></tr><? }?>
                                          
                                             </table>
                                          </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                                              <input type="hidden" name="save" value="1" />
                                              <img src="http://www.wevolt.com/images/wizard_save_btn.png"  onClick="submit_form('save','');" class="navbuttons">       

                                <? } ?>
                                </div>

                               

<input type="hidden" name="txtModuleID" value="<? if ($_POST['txtModuleID'] != '') echo $_POST['txtModuleID']; else if ($ModuleID != '')echo $ModuleID;?>">
<input type="hidden" name="txtCell" id="txtCell" value="<? if ($_POST['txtCell'] != '') echo $_POST['txtCell']; else if ($CellID != '')echo $CellID;?>">
<? if ($_GET['step'] != 3) {?>
<input type="hidden" name="txtModuleType" id="txtModuleType" value="<? if ($_POST['txtModuleType'] != '') echo $_POST['txtModuleType']; else if ($WindowArray->ModuleType != '')echo $WindowArray->ModuleType;?>">
<? }?>
<? if ($_GET['step'] != 2) { ?>
<input type="hidden" name="txtPrivacy" value="<? if ($_POST['txtPrivacy'] != '') echo $_POST['txtPrivacy']; else if ($WindowArray->Privacy != '')echo $WindowArray->Privacy;?>">
<? }?>
<? if ($_GET['step'] != 6) { ?>
<input type="hidden" name="txtLayout" id="txtLayout" value="<? if ($_POST['txtLayout'] != '') echo $_POST['txtLayout']; else if ($WindowArray->ModuleTemplate != '')echo $WindowArray->ModuleTemplate;?>">
<input type="hidden" name="content" id="content" value="<? if ($_POST['content'] != '') echo $_POST['content']; else if ($WindowArray->HTMLCode != '')echo $WindowArray->HTMLCode;?>">

<? }?>
<? if ($_GET['step'] != 7) {?>
<input type="hidden" name="txtThumbSize" value="<? if ($_POST['txtThumbSize'] != '') echo $_POST['txtThumbSize']; else if ($WindowArray->ThumbSize != '') echo $WindowArray->ThumbSize;?>">
<? }?>
<? if (($_GET['step'] != 8) &&($_GET['step'] != 3)) { ?>
<input type="hidden" name="contentNumSelect" id="contentNumSelect" value="<? if ($_POST['contentNumSelect'] != '') echo $_POST['contentNumSelect']; else if ($WindowArray->NumberVariable != '') echo $WindowArray->NumberVariable;?>">
<input type="hidden" name="contentSelect" id="contentSelect" value="<? if ($_POST['contentSelect'] != '') echo $_POST['contentSelect']; else if ($WindowArray->ContentVariable != '') echo $WindowArray->ContentVariable;?>">

<input type="hidden" name="contentSubSelect" id="contentSubSelect" value="<? if ($_POST['contentSubSelect'] != '') echo $_POST['contentSubSelect']; else if ($WindowArray->SortVariable != '') echo $WindowArray->SortVariable;?>" />

<? }?>
<? if ($_GET['step'] != 9) {?>
<input type="hidden" name="txtMain" value="<? if ($_POST['txtMain'] != '') echo $_POST['txtMain']; else if ($WindowArray->IsMain != '') echo $WindowArray->IsMain;?>">
 <input type="hidden" name="txtName" value="<? if ($_POST['txtName'] != '') echo $_POST['txtName']; else if ($_POST['Name'] != '')echo $_POST['Name']; else if ($WindowArray->Title != '') echo $WindowArray->Title;?>">
  <input type="hidden" name="txtDescription" value="<? if ($_POST['txtDescription'] != '') echo $_POST['txtDescription'];else if ($WindowArray->Description != '') echo $WindowArray->Description; ?>">
  <input type="hidden" name="txtTags" value="<? if ($_POST['txtTags'] != '') echo $_POST['txtTags']; else if ($WindowArray->Tags != '') echo $WindowArray->Tags; ?>">
  <input type="hidden" name="txtPosition" id="txtPosition" value="<? if ($_POST['txtPosition'] != '') echo $_POST['txtPosition']; else if ($WindowArray->Position != '') echo $WindowArray->Position; ?>">
<? }?>

</form>
                        </div>
      
              
</body>
</html>