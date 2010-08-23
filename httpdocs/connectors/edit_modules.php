<?php 

include  $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/module_arrays_inc.php');

$ReturnLink = $_GET['returnlink'];
$RePost = 0;
$UserID = $_SESSION['userid'];

$ModuleCode = $_GET['module'];
if ($ModuleCode == '')
	$ModuleCode = $_POST['ModuleCode'];
	
$ProjectID = $_SESSION['sessionproject'];

if ($ProjectID == '' )
	$ProjectID = $_POST['ProjectID'];
	
	
$Placement = $_GET['placement'];
$ModuleType = $_GET['type'];
if ($ModuleType == '' )
	$ModuleType = $_POST['ModuleType'];
if ($ModuleType == 'home') 
	$Homepage = 1;
else 
	$Homepage = 0;	
$CloseWindow = 0;
$UserID = $_SESSION['userid'];
$query = "SELECT userid, CreatorID from projects where ProjectID='$ProjectID'"; 
$ProjectArray = $InitDB->queryUniqueObject($query);
$OwnerID = $ProjectArray->userid;
$CreatorID = $ProjectArray->CreatorID;

if (($UserID == $CreatorID) || ($UserID == $OwnerID))
	$Auth = 1;
else 
	$Auth = 0;
		
if (($_SESSION['userid'] == '') || ($Auth == 0))
	$CloseWindow = 1;

if (($_POST['save'] == 1)&&($Auth == 1)) { 
		
		$CustomVar1 = mysql_real_escape_string($_POST['CustomVar1']);
		$CustomVar2 = mysql_real_escape_string($_POST['CustomVar2']);
		$CustomVar3 = mysql_real_escape_string($_POST['CustomVar3']);
		$HTMLCode = mysql_real_escape_string($_POST['HTMLCode']);
		$query = "UPDATE pf_modules set CustomVar1='$CustomVar1', CustomVar2='$CustomVar2',CustomVar3='$CustomVar3',HTMLCode='$HTMLCode' where ModuleCode='$ModuleCode' and ComicID ='$ProjectID' and Homepage='$Homepage'";	
$InitDB->execute($query);
		$CloseWindow = 1;

	

}
if ($CloseWindow == 0) {
	
		$query =  "SELECT *  from pf_modules where ModuleCode='$ModuleCode' and ComicID ='$ProjectID' and Homepage='$Homepage'";
		$ModuleArray = $InitDB->queryUniqueObject($query);
		$Title = $ModuleArray->Title;
		if ($ModuleArray->ID == '') {
			foreach($AvailableModuleArray as $mod) {
					if ($mod[0] == $ModuleCode) {
						$Title = $mod[1];
						break;
					}
			}
			$query = "INSERT into pf_modules (Title, Position,IsPublished,Placement,ModuleCode,ComicID,Homepage) values ('$Title','10',1,'$Placement','$ModuleCode','$ProjectID','$Homepage')";
			$InitDB->execute($query);
		}

		$Var1 = false;
		$Var2 = false;
		$Var3 = false;
		$Html = false;
		$Var1Message='';
		$Var2Message='';
		$Var2Message='';
		
		if ($ModuleCode == 'twitter') {
			$Var1 = true;
			$Var1Message = 'Enter your a twitter username';
			$Var2 = true;
			$Var2Message = 'Enter number of tweets to show';
			$Var3 = true;
			$Var3Message = 'Show Follow Link';
			$Var3Input .= '<input type="radio" name="CustomVar3" value="1"';
			if (($ModuleArray->CustomVar3 == 1) || ($ModuleArray->CustomVar3 == ''))
				$Var3Input .= 'checked';
			$Var3Input .= '> Yes&nbsp;&nbsp;';
			$Var3Input .= '<input type="radio" name="CustomVar3" value="0"';
			if ($ModuleArray->CustomVar3 == 0)
				$Var3Input .= 'checked';
			$Var3Input .= '> No';
		}
		
		if (substr($ModuleCode,0,6) == 'custom') {
			$Html = true;
			$HTMLMessage = 'Enter plain text or HTML code to create your own module';
		}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<script type="text/javascript">
function submit_form() {
	document.modform.submit();
}
</script>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Edit Module</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
  <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
</head>
<body>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center"> 
<div class="spacer"></div>
<table width="500" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="484" align="center">
                                       

<div class="messageinfo_white">
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
parent.$.modal().close();
</script>
 <? } else {?>
<form name="modform" id="modform" method="post" action="#">
  EDIT MODULE: <? echo $Title;?>
<div style="height:5px;"></div>
<? if ($Var1) {?>
<div class="messageinfo_white"><? echo $Var1Message;?></div>
<input type="text" name="CustomVar1" style="width:280px;"  value="<? echo  stripslashes($ModuleArray->CustomVar1);?>"/>
<? }?>
<div style="height:5px;"></div>
<? if ($Var2) {?>
<div class="messageinfo_white"><? echo $Var2Message;?></div>
<input type="text" name="CustomVar2" style="width:280px;"  value="<? echo stripslashes($ModuleArray->CustomVar2);?>"/>
<? }?>
<div style="height:5px;"></div>
<? if ($Var3) {?>
<div class="messageinfo_white"><? echo $Var3Message;?></div>
<? if ($Var3Input != '') {echo $Var3Input; } else {?>
<input type="text" name="CustomVar3" style="width:280px;" value="<? echo stripslashes($ModuleArray->CustomVar3);?>"/>
<? }?>
<? }?>
<? if ($Html) {?>
<div class="messageinfo_white"><? echo $HTMLMessage;?></div>
<textarea style="width:280px; height:250px;" name="HTMLCode" id="HTMLCode"><? echo stripslashes($ModuleArray->HTMLCode);?></textarea><br>
<? }?>
                      
<input type="hidden" id ="ModuleType" name="ModuleType" value="<? echo $ModuleType;?>">
<input type="hidden" name="ProjectID" id="ProjectID" value="<? echo $ProjectID;?>">
<input type="hidden" name="ModuleCode" id="ModuleCode" value="<? echo $ModuleCode;?>">
<input type="hidden" name="save" value="1" />


</form>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        <div class="spacer"></div>
<div align="center">
<img src="http://www.wevolt.com/images/wizard_save_btn.png" onclick="submit_form();" class="navbuttons" /> <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="parent.$.modal().close();" class="navbuttons"/></div> 
</div> 
<? }?>
</div>

</body>
</html>