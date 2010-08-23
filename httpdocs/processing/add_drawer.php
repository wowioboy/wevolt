<?php 

include '../includes/init.php';
$DB = new DB();
$Refer = $_GET['refer'];
$ItemID = $_GET['itemid'];
if ($ItemID == '')
	$ItemID = $_POST['txtItem'];
$Title = $_GET['itemtitle'];	
if ($Title == '')
	$Title = $_POST['txtTitle'];
		
$Link = $_GET['itemlink'];
if ($Title == '')
	$Link = $_POST['txtLink'];


if ($_SESSION['userid'] == '') {
	$Auth = false;

} else {
	$Auth = true;
	if ($_POST['step'] == '') {
	
				$query ="SELECT distinct DrawerID from drawers where UserID='".$_SESSION['userid']."' and ParentID=0 and IsWindow=0";
				$DB->query($query);
				$DrawerSelect = '<select name="txtDrawer">';
				while ($line = $DB->FetchNextObject()) {
					$DrawerSelect .= '<option value="'.$line->DrawerID.'">Drawer '.$line->DrawerID.'</option>';	
				}
				$DrawerSelect .= '</select>';
				$Step = 'parent';
				
	} else if ($_POST['step'] == 'parent') {
	
				$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and DrawerID='".$_POST['txtDrawer']."' and ParentID=0 and IsWindow=0";
				$DB->query($query);
				
				$ParentSelect = '<select name="txtParent"><option value="0">NO PARENT</option>';
				while ($line = $DB->FetchNextObject()) {
					$ParentSelect .= '<option value="'.$line->ID.'">Drawer '.$line->Title.'</option>';	
				}
				$ParentSelect .= '</select>';
				$Step = 'title';
				
	} else if ($_POST['step'] == 'title') {
	
				$Step = 'finish';
	
	} else if ($_POST['step'] == 'finish') {
	
				$query ="SELECT Position from drawers WHERE Position=(SELECT MAX(Position) FROM drawers where UserID='".$_SESSION['userid']."' and DrawerID='$DrawerID' and ParentID='$ParentID')";
				$NewPosition = $DB->queryUniqueValue($query);
				$NewPosition++;
				
				$query ="INSET into drawers (Title, DrawerType, DrawerID, ParentID, Link, UserID, Position) values ('$Title', 'link', '$DrawerID', '$ParentID', '$Link', '$UserID', '$NewPosition')";
				$DB->query($query);
			
				$Step = 'close';
	
	}

}
$DB->close();
?>


<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<form method="post" action="#">
<? 
if ($Auth) {
		
			if ($_POST['step'] == '') {?>
					
					 Please Select which available drawer you would like this item to be placed.
					<?	echo $DrawerSelect;?>
					<input type="submit" value="NEXT: SELECT PARENT">
					
		<? } else if ($Step == 'parent') {?>
					
					Select which current drawer item this link should be placed under. Or select NO PARENT
					<?	echo $ParentSelect;?>
		 <input type="submit" value="NEXT: TITLE">
		<? } else if ($Step == 'title') {?>
					
				   You can enter a custom title or keep the current title<br>
		
					<input type="text" value="<? echo $Title;?>" name="txtTitle" style="300px;">
					 <input type="submit" value="FINISH!">
		
		<? }?>


<? } else { ?>

	You need to be logged in to customize your drawers

<? } ?>

<input type="hidden" name="step" value="<? echo $Step;?>">
<? 
if ($_GET['step'] != '') {?>
<input type="hidden" name="txtDrawer" value="<? echo $_POST['txtDrawer'];?>">
<? }?>
<? 
if ($_GET['step'] != 'parent') {?>
<input type="hidden" name="txtParent" value="<? echo $_POST['txtParent'];?>">
<? }?>
<? 
if ($_GET['step'] != 'title') {?>
<input type="hidden" name="txtTitle" value="<? echo $_POST['txtTitle'];?>">
<? }?>

<? if ($Step == 'close') {?>
<script type="text/javascript">
parent.close_wizard(); 
</script>
<? } ?>
<input type="hidden" name="txtTitle" value="<? echo $Title;?>">
<input type="hidden" name="txtLink" value="<? echo $Link;?>">
<input type="hidden" name="txtItem" value="<? echo $ItemID;?>">
</form>
</td>
</tr>
</table>
