<?php 
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php';
include  $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';

$ReturnLink = $_GET['ref'];
$RePost = 0;
$UserID = $_SESSION['userid'];
	
$ProjectID = $_GET['project'];
if ($ProjectID == '' )
	$ProjectID = $_POST['project'];

$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$CloseWindow = 0;

$DB->close();

?>

<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function change_reader(style,page) {
	attach_file('http://www.wevolt.com/connectors/change_reader.php?ref='+escape('<? echo $ReturnLink;?>')+'&page='+page+'&series=<? echo $_GET['series'];?>&episode=<? echo $_GET['episode'];?>&style='+style); 
}


</script>
</style>

 <style type="text/css">
 body,html {
	margin:0px;
	padding:0px; 
	 
 }
 
 </style>

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

<center>
<table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
<table>
<? if ($_SESSION['viewing_project_type'] != 'writing') {?><tr>
<td align="left" width="25"><input type="radio" value="flash" name="ReaderStyle" id="ReaderStyle" <? if ($_SESSION['readerstyle'] == 'flash') echo 'checked';?> onclick="change_reader('flash','<? echo $_GET['page'];?>');"/></td><td class="messageinfo_white" align="left" style="padding-left:5px;"><strong>FLASH</strong></td>
</tr>
<tr><td colspan="2"  class="messageinfo_white">A dynamic reading experience that pre-loads<br />
pages in the background while you read.<br />

Does not work on iPhone or iPad.</td>
</tr>
<? }?>
<tr>
<td width="25"><input type="radio" value="html" name="ReaderStyle" id="ReaderStyle" <? if ($_SESSION['readerstyle'] != 'flash') echo 'checked';?> onclick="change_reader('html','<? echo $_GET['page'];?>');"/></td><td class="messageinfo_white" align="left" style="padding-left:5px;"><strong>HTML</strong></td>
</tr>
<tr><td colspan="2" class="messageinfo_white">Classic, clean and easy online reading experience.<br />

Works on iPhone and iPad.</td>
</tr>
</table>
</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
</center>

</div>

</body>
</html>