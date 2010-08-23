<?php 
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';




function format_drawer_title($string) {
				$string = urldecode($string);
				$string = str_replace("%20"," ",$string);
				$string = str_replace("%27","'",$string);
				$string = ucwords(substr(strtolower($string),0,28));
				return $string;
}

$Refer = $_GET['refer'];
if ($Refer == '')
	$Refer = $_POST['refer'];
if ($Refer == '')
	$Refer = $_GET['returnlink'];
if ($Refer == '')
	$Refer = $_POST['txtReturn'];
$ItemID = $_GET['id'];
if ($ItemID == '')
	$ItemID = $_POST['txtItem'];
$Title = $_GET['title'];
	
if ($Title == '')
	$Title = $_POST['txtTitle'];
		
$Link = $_GET['link'];
if ($Link == '')
	$Link = $_POST['txtLink'];

$ParentID = $_POST['txtParent'];
	
if ($_SESSION['userid'] == '') {
	$Auth = false;

} else {
	$Auth = true;
	$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
	if ($_POST['step'] == '') {
				
				$DrawerCount = 1;
				$DrawerSelect = '<select name="txtDrawer">';
				
				while ($DrawerCount <5) {
					$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and DrawerID='$DrawerCount'";
					$DrawerArray = $DB->queryUniqueObject($query);
		
					if (($DrawerArray->IsWindow == 0) || ($DrawerArray->IsWindow == ''))
						$DrawerSelect .= '<option value="'.$DrawerCount.'">Drawer '.$DrawerCount.'</option>';	
						
					$DrawerCount++;
					
				}
				$DrawerSelect .= '</select>';
				$Step = 'parent';

	} else if ($_POST['step'] == 'parent') {
	
				$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and DrawerID='".$_POST['txtDrawer']."' and ParentID=0 and DrawerType='label' and IsWindow=0";
				$DB->query($query);
				
				$ParentSelect = '<select name="txtParent"><option value="0">NO PARENT</option>';
				while ($line = $DB->FetchNextObject()) {
					$ParentSelect .= '<option value="'.$line->ID.'">'.format_drawer_title($line->Title).'</option>';	
				}
				$ParentSelect .= '</select>';
				$Step = 'title';
				
	} else if ($_POST['step'] == 'title') {
	
				$Step = 'finish';
	
	} else if ($_POST['step'] == 'finish') {
	
				$query ="SELECT Position from drawers WHERE Position=(SELECT MAX(Position) FROM drawers where UserID='".$_SESSION['userid']."' and DrawerID='".$_POST['txtDrawer']."' and ParentID='".$_POST['txtParent']."')";
				$NewPosition = $DB->queryUniqueValue($query);
				$NewPosition++;
//				print $query;
				$query ="INSERT into drawers (Title, DrawerType, DrawerID, ParentID, Link, UserID, Position) values ('".mysql_real_escape_string($_POST['txtTitle'])."', 'link', '".$_POST['txtDrawer']."', '".$_POST['txtParent']."', '".mysql_real_escape_string($_POST['txtLink'])."', '".$_SESSION['userid']."', '$NewPosition')";
				$DB->query($query);
				$Step = 'close';
	
	}
$DB->close();
}

?>
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

<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center">
<div style="height:10px;"></div>
<table width="608" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="592" align="center">
                                        <img src="http://www.wevolt.com/images/drawers_add_header.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                        <div class="spacer"></div><div style="height:10px;"></div>
<table cellpadding="0" cellspacing="0" border="0" width="510">
<tr>
<td align="center" class="messageinfo_white">
<table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">

<form method="post" action="#">
<? 
if ($Auth) {
		
			if ($_POST['step'] == '') {?>
					<div style="height:10px;"></div>
					 Please Select which drawer you would <br />
like this item to be placed.<div style="height:10px;"></div>

					<?	echo $DrawerSelect;?><div style="height:10px;"></div>

					 <input type="image" src="http://www.wevolt.com/images/wizard_next_btn.png" style="border:none;background:none;">
                     <div style="height:10px;"></div>
					
		<? } else if ($_POST['step'] == 'parent') {?>
					<div style="height:10px;"></div>
					Select which parent this link should be placed under. <br />
Or select NO PARENT<div style="height:10px;"></div>

					<?	echo $ParentSelect;?><div style="height:10px;"></div>

		 <input type="image" src="http://www.wevolt.com/images/wizard_next_btn.png" style="border:none;background:none;">
         <div style="height:10px;"></div>
		<? } else if ($_POST['step'] == 'title') {?>
					<div style="height:10px;"></div>
				   You can enter a custom title or keep the current title<div style="height:10px;"></div>
		
					<input type="text" value="<? echo format_drawer_title($Title);?>" name="txtTitle" style="width:300px;"><div style="height:10px;"></div>

					 <input type="image" src="http://www.wevolt.com/images/wizard_save_btn.png" style="background:none;border:none;">
                     <div style="height:10px;"></div>
		
		<? }?>


<? } else { ?>
<div style="height:5px;"></div>
	You need to be logged in to customize your drawers
<div style="height:5px;"></div>
<? } ?>

<input type="hidden" name="step" value="<? echo $Step;?>">
<? 
if ($_POST['step'] != '') {?>
<input type="hidden" name="txtDrawer" value="<? echo $_POST['txtDrawer'];?>">
<? }?>
<? 
if ($_POST['step'] != 'parent') {?>
<input type="hidden" name="txtParent" value="<? echo $_POST['txtParent'];?>">
<? }?>
<? 
if ($_POST['step'] != 'title') {?>
<input type="hidden" name="txtTitle" value="<? echo $Title;?>">
<? }?>

<? if ($Step == 'close') {?>
<script type="text/javascript">
closeWindow();
</script>
<? } ?>

<input type="hidden" name="txtLink" value="<? echo $Link;?>">
<input type="hidden" name="txtItem" value="<? echo $ItemID;?>">
<input type="hidden" name="txtReturn" value="<? echo $Refer;?>">
</form>
</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td>
</tr>
</table>
</div>
