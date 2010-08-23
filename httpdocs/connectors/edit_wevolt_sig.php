<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$CloseWindow = 0;
if ($_SESSION['userid'] == '')
	$CloseWindow = 1;
	
$query = "SELECT ForumSig from users where encryptid='".$_SESSION['userid']."'"; 
$ForumSig = $DB->queryUniqueValue($query);
	
	if ($_POST['save'] == 1) {
	
$query = "UPDATE users set ForumSig='".mysql_real_escape_string($_POST['txtSig'])."' where  encryptid='".$_SESSION['userid']."'"; 
$ForumSig = $DB->queryUniqueValue($query);
$CloseWindow = 1;
		?>
        
        
        <? 
	}

?>
<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css"> 
</style>

 <style type="text/css">
 body,html {
	margin:0px;
	padding:0px; 
	 
 }
 </style>
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
			parent.$.modal().close(); 
        </script>

<? } else {?>
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center">

<div style="height:15px;"></div>
<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                        <img src="http://www.wevolt.com/images/wizards/edit_wevolt_signature.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
               <div style="height:10px;"></div>
               <div class="messageinfo_white">
               	Edit your Signature below: <div style="height:10px;"></div>
               </div><form method="post" action="#" name="voltform" id="voltform">
               <table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">

            <textarea name="txtSig" style="width:80%; height:100px;"><? echo $ForumSig;?></textarea>       

 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table><div class="spacer"></div>
                        <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="parent.$.modal().close();" class="navbuttons">&nbsp;&nbsp;<input type="image" src="http://www.wevolt.com/images/wizard_save_btn.png" style="border:0; background:none;" /><input type="hidden" name="save" id="save" value="1">
</form>

                     </div>
<? } ?>