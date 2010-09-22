<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
function format_drawer_title($string) {
				$string = urldecode($string);
				$string = str_replace("%20"," ",$string);
				$string = str_replace("%27","'",$string);
				$string = ucwords(substr(strtolower($string),0,28));
				return $string;
}
$DrawerID = $_GET['id'];
if ($DrawerID == '')
	$DrawerID = $_POST['txtDrawer'];
$ItemID = $_GET['item'];
if ($ItemID == '')
	$ItemID = $_POST['txtItem'];
$Title = $_GET['title'];
	
if ($Title == '')
	$Title = $_POST['txtTitle'];
		
$Link = $_GET['link'];
if ($Link == '')
	$Link = $_POST['txtLink'];

$ParentID = $_POST['txtParent'];

$ReturnLink = $_GET['returnlink'];
if ($ReturnLink == '')
	$ReturnLink = $_POST['txtReturn'];
	
if ($_SESSION['userid'] == '') {
	$Auth = false; 
} else {
	$Auth = true;
	
	$DB = new DB();
	if ($_POST['action'] == 'delete') {
				$query ="DELETE from drawers where DrawerID='$DrawerID' and ID='$ItemID'";
			$DB->execute($query);
			
			?>
                <script type="text/javascript">
                closeWindow();
				</script>
                
                <? 
	
	} else if ($_POST['step'] == '') {
				$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and ParentID='0' and DrawerID='".$DrawerID."' order by Position";
				$DB->query($query);
				$ItemSelect = '<select onChange="select_drawer_item(this.options[this.selectedIndex].value);"><option value="">--SELECT ITEM TO EDIT--</option><option value="0">--ADD NEW ITEM--</option><option value="-1">--ADD NEW LABEL--</option><option value="">----------------</option>';
				$DB->query($query);
				$DrawerCount = 1;
				while ($line = $DB->FetchNextObject()) {
		
			   			if ($line->DrawerType == 'label') {
							$ParentID = $line->ID;
							$ItemSelect .= '<option value="'.$line->ID.'">Label : '.format_drawer_title($line->Title).'</option>';	
							$DrawerCount++;
							$DB2 = new DB();
							$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and ParentID='$ParentID' order by Position";
							$DB2->query($query);
	
							while ($line2 = $DB2->FetchNextObject()) {
								if ($line2->DrawerType == 'label') {
									   $SubParentID = $line2->ID;
									  // print 'Subparent<br/>';
									  $DB3 = new DB();
									   $query = "SELECT * from drawers where UserID='".$_SESSION['userid']."' and ParentID='$SubParentID' order by Position"; 				
									   $DB3->query($query);
								
										$ItemSelect .= '<option value="'.$line2->ID.'">---->Sub Label : '.format_drawer_title($line2->Title).'</option>';	
									   	while ($line3 = $DB3->FetchNextObject()) {
												$ItemSelect .= '<option value="'.$line3->ID.'">--------->'.format_drawer_title($line3->Title).'</option>';	
										}
										$DB3->close();
								} else {
								 
										$ItemSelect .= '<option value="'.$line2->ID.'">---->'.format_drawer_title($line2->Title).'</option>';	
								  
								 }
							}
			   				$DB2->close();
				   } else {
					
						$ItemSelect .= '<option value="'.$line->ID.'">'.format_drawer_title($line->Title).'</option>';	
				   
				   }
		}
		     
		$ItemSelect .= '</select>';
		$Step = 'info';
				
	} else if ($_POST['step'] == 'parent') {
	
				$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and DrawerID='".$_POST['txtDrawer']."' and ParentID=0 and DrawerType='label' and IsWindow=0";
				$DB->query($query);
				
				$ParentSelect = '<select name="txtParent"><option value="0">NO PARENT</option>';
				while ($line = $DB->FetchNextObject()) {
					$ParentSelect .= '<option value="'.$line->ID.'">'.format_drawer_title($line->Title).'</option>';	
				}
				$ParentSelect .= '</select>';
				$Step = 'info';
				
	} else if ($_POST['step'] == 'info') {
	
				$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and DrawerID='".$DrawerID."' and ID='".$ItemID."'";
				$DrawerItem = $DB->queryUniqueObject($query);
				$Step = 'save';
	
	} else if ($_POST['step'] == 'save') {
	
				if ($_POST['action'] == 'add') {
					$query ="SELECT Position from drawers WHERE Position=(SELECT MAX(Position) FROM drawers where UserID='".$_SESSION['userid']."' and DrawerID='".$_POST['txtDrawer']."' and ParentID='".$_POST['txtParent']."')";
					$NewPosition = $DB->queryUniqueValue($query);
					$NewPosition++;
//					print $query;
					$query ="INSERT into drawers (Title, DrawerType, DrawerID, ParentID, Link, UserID, Position) values ('".mysql_real_escape_string($_POST['txtTitle'])."', 'link', '".$_POST['txtDrawer']."', '".$_POST['txtParent']."', '".mysql_real_escape_string($_POST['txtLink'])."', '".$_SESSION['userid']."', '$NewPosition')";
					$DB->query($query);
//					print $query;
				
				} else if ($_POST['action'] == 'label') {
						$query ="SELECT Position from drawers WHERE Position=(SELECT MAX(Position) FROM drawers where UserID='".$_SESSION['userid']."' and DrawerID='".$_POST['txtDrawer']."' and ParentID='".$_POST['txtParent']."')";
						$NewPosition = $DB->queryUniqueValue($query);
						$NewPosition++;
//						print $query;
						$query ="INSERT into drawers (Title, DrawerType, DrawerID, ParentID, UserID, Position) values ('".mysql_real_escape_string($_POST['txtTitle'])."', 'label', '".$_POST['txtDrawer']."', '".$_POST['txtParent']."', '".$_SESSION['userid']."', '$NewPosition')";
						$DB->query($query);
//						print $query;
				
				
				} else if ($_POST['action'] == 'edit') {				
				$query ="UPDATE  drawers set Title='".mysql_real_escape_string($_POST['txtTitle'])."', Link='".mysql_real_escape_string($_POST['txtLink'])."',ParentID='".$_POST['txtParent']."', Position='".$_POST['txtPosition']."' where DrawerID='$DrawerID' and ID='$ItemID'";
				$DB->execute($query);
				}
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
<script type="text/javascript">

function select_drawer_item(itemid) {
		if (itemid == '') {
			document.getElementById("txtItem").value='';
			document.getElementById("NextButton").style.display = 'none';
			document.getElementById("DeleteButton").style.display = 'none';
			document.getElementById("action").value = '';
		} else if (itemid==0){
				document.getElementById("action").value = 'add';
				document.getElementById("NextButton").style.display = '';
				document.getElementById("step").value = 'parent';
		} else if (itemid==-1){
				document.getElementById("action").value = 'label';
				document.getElementById("NextButton").style.display = '';
				document.getElementById("step").value = 'info';
		}else {
			document.getElementById("txtItem").value=itemid;
			document.getElementById("NextButton").style.display = '';
			document.getElementById("DeleteButton").style.display = '';
			document.getElementById("action").value = 'edit';
		}
}
function delete_item() {
			document.getElementById("action").value = 'delete';
			document.drawerform.submit();
}
function finish() {
			document.drawerform.submit();
}

function goback() {
			var current = '<? echo $_POST['step'];?>';
			if (current == 'info')
				document.getElementById("step").value = '';
			document.getElementById("action").value = '';
			document.drawerform.submit();
}
</script>

<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<div class="wizard_wrapper" align="center" style="height:416px; width:624px;">

                                        <img src="http://www.wevolt.com/images/headers/drawers_header.png" vspace="5"/>
 
<div align="center">

<div style="height:10px;"></div>
<table cellpadding="0" cellspacing="0" border="0" width="510">
<tr>
<td align="center" class="messageinfo_white">
<table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
                                        
                                       

<form method="post" action="#" id="drawerform" name="drawerform">
<? 
if ($Auth) {
		
			if ($_POST['step'] == '') {?>
					<div class="messageinfo_yellow"><b>EDITING DRAWER #<? echo $DrawerID;?></b><div style="height:10px;"></div></div>
					 Please select which drawer item <br />
you want to edit.<div style="height:10px;"></div>

					<?	echo $ItemSelect;?><div style="height:10px;"></div>
					
					</div>
		<? } else if ($_POST['step'] == 'parent') {?>
					
					Select which parent this link should be placed under. Or select NO PARENT<div style="height:5px;"></div>

					<?	echo $ParentSelect;?>
<div style="height:10px;"></div>
		
		  <? } else if ($_POST['step'] == 'info') {?>
					<div class="messageinfo_yellow"><b>EDITING DRAWER #<? echo $DrawerID;?></b><div style="height:10px;"></div>
                    </div>
					Edit the item settings below<div style="height:10px;"></div>

					
					
				
				 <div style="height:5px;"></div>
					<table width="75%"><tr><td width="200" align="right" class="messageinfo_white"><strong>Title</strong></td><td style="padding:3px;"><input type="text" value="<? echo format_drawer_title($DrawerItem->Title);?>" name="txtTitle" style="width:300px;"></td></tr><? if ($_POST['action'] != 'label') {?><tr><td colspan="2"></td></tr><tr><td width="200" align="right" class="messageinfo_white"><strong>Links</strong></td><td style="padding:3px;"><input type="text" name="txtLink" value="<? echo $DrawerItem->Link;?>"  style="width:300px;"></td></tr><? } ?></table>
                    <input type="hidden" name="txtParent" value="<? if ($_POST['action'] == 'edit') echo  $DrawerItem->ParentID; else if ($_POST['action'] == 'add') echo $_POST['txtParent']; else if ($_POST['action'] == 'label') echo '0';?>">
                     <input type="hidden" name="txtPosition" value="<? echo  $DrawerItem->Position;?>">
<div style="height:10px;"></div><div style="height:10px;"></div>
		<? }
 } else { ?>
<div style="height:5px;"></div>
	You need to be logged in to customize your drawers
<div style="height:5px;"></div>
<? } ?>

<input type="hidden" name="step" id="step" value="<? echo $Step;?>">
<? 
if ($_POST['step'] != '') {?>
<input type="hidden" name="txtDrawer" value="<? echo $_POST['txtDrawer'];?>">
<? }?>
<? 
if (($_POST['step'] != 'parent') && ($_POST['step'] != 'info')) {?>
<input type="hidden" name="txtParent" value="<? echo $_POST['txtParent'];?>">
<? }?>
<? 
if ($_POST['step'] != 'info') {?>
<input type="hidden" name="txtPosition" value="<? echo $_POST['txtPosition'];?>">
<input type="hidden" name="txtTitle" value="<? echo $Title;?>">
<input type="hidden" name="txtLink" value="<? echo $Link;?>">
<? }?>

<? if ($Step == 'close') {?>
<script type="text/javascript">
closeWindow();
</script>
<? } ?>
 <span id="BackButton" <? if ($_POST['step'] == ''){?>style="display:none;"<? }?>>
					<img src="http://www.wevolt.com/images/wizard_back_btn.png" onclick="goback();" class="navbuttons">
                    </span>
                  <span id="DeleteButton" style="display:none;">
                    <img src="http://www.wevolt.com/images/wizard_delete_btn.png" onclick="delete_item();" class="navbuttons">
                    </span>
<span id="NextButton"  <? if ($_POST['step'] != 'parent'){?>style="display:none;"<? }?>>
  <img src="http://www.wevolt.com/images/wizard_next_btn.png" onclick="finish();" class="navbuttons">
				</span>
                   
                    <span id="FinishButton" style=" <? if (($_POST['step'] != 'info') || ($_POST['step'] == '')){?>display:none;<? }?>">
					<img src="http://www.wevolt.com/images/wizard_save_btn.png" onclick="finish();" class="navbuttons">
                    </span>

<input type="hidden" name="txtItem" value="<? echo $ItemID;?>" id="txtItem">
<input type="hidden" name="txtReturn" value="<? echo $ReturnLink;?>">
<input type="hidden" name="action" value="<? echo $_POST['action'];?>" id="action">
<input type="hidden" name="txtDrawer" value="<? echo $DrawerID;?>" id="txtDrawer">
</form>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td>
</tr>
</table>
</div>
</div>
