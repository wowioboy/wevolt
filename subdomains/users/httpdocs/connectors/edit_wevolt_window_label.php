<?php 

include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';?>

<?

$CellID = $_GET['window'];
if ($CellID == '')
	$CellID = $_POST['txtCell'];
$CellSelect = $CellID.'Title';

if (($Name == '') && ($ProjectType == '')){
	$Name = $_SESSION['username'];
}

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

$CloseWindow = 0;
if (($_SESSION['userid'] == '') || ($UserID != $_SESSION['userid']))
	$CloseWindow = 1;

$FeedID = $FeedArray->EncryptID;
$FeedTemplate = $FeedArray->HtmlLayout;
$TemplateID = $FeedArray->TemplateID;	
$TotalLength = strlen($FeedTemplate);


$query = "SELECT $CellSelect from feed_settings where FeedID='$FeedID'";
$WindowLabel = $DB->queryUniqueValue($query);

if ($_POST['save'] =='1') { 
		$Title = mysql_real_escape_string($_POST['txtName']);
		$query = "UPDATE feed_settings set $CellSelect='$Title' where FeedID='$FeedID'";
		$DB->execute($query);
		$CloseWindow = 1;
}
$DB->close();

?>
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
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

<? if ($CloseWindow == 1) {?>
<script>
	closeWindow();
</script>
<? }?>   
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
                     
                               <table width="300" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="284" align="center">
                            
                    					<input type="text" style="width:240px;" name="txtName" value="<? echo $WindowLabel; ?>">
										</td><td class="wizardboxcontent"></td>

                                        </tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
                                        <td id="wizardBox_BR"></td>
                                        </tr></tbody>
                                </table> <div class="spacer"></div>
                       
             
 <input type="image" src="http://www.wevolt.com/images/wizard_save_btn.png" style="background:none;border:none;"/>&nbsp;&nbsp;
<img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="closeWindow();" class="navbuttons"/>
<div class="spacer"></div>
<input type="hidden" name="save" value="1" />
 </form> 

                        </div>