<?php 
include '../includes/init.php';
$DB = new DB();
$DB2 = new DB();
$DB3 = new DB();
$Refer = $_GET['refer'];
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

$ReturnLink = $_GET['returnlink'];
if ($ReturnLink == '')
	$ReturnLink = $_POST['txtReturn'];
	
if ($_SESSION['userid'] == '') {
	$Auth = false;

} else {
	$Auth = true;
	if ($_POST['step'] == '') {
				$DrawerCount = 1;
				$DrawerSelect = '<select name="txtDrawer">';
				
				while ($DrawerCount <11) {
					$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and DrawerID='$DrawerCount'";
					$DrawerArray = $DB->queryUniqueObject($query);
		
					if (($DrawerArray->IsWindow == 0) || ($DrawerArray->IsWindow == ''))
						$DrawerSelect .= '<option value="'.$DrawerArray->DrawerID.'">Drawer '.$DrawerCount.'</option>';	
						
					$DrawerCount++;
					
				}
				$DrawerSelect .= '</select>';
				$Step = 'parent';

	} else if ($_POST['step'] == 'parent') {
	
				$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and DrawerID='".$_POST['txtDrawer']."' and ParentID=0 and DrawerType='label' and IsWindow=0";
				$DB->query($query);
				
				$ParentSelect = '<select name="txtParent"><option value="0">NO PARENT</option>';
				while ($line = $DB->FetchNextObject()) {
					$ParentSelect .= '<option value="'.$line->ID.'">'.$line->Title.'</option>';	
				}
				$ParentSelect .= '</select>';
				$Step = 'title';
				
	} else if ($_POST['step'] == 'title') {
	
				$Step = 'finish';
	
	} else if ($_POST['step'] == 'finish') {
	
				$query ="SELECT Position from drawers WHERE Position=(SELECT MAX(Position) FROM drawers where UserID='".$_SESSION['userid']."' and DrawerID='$".$_POST['txtDrawer']."' and ParentID='".$_POST['txtParent']."')";
				$NewPosition = $DB->queryUniqueValue($query);
				$NewPosition++;
				
				$query ="INSERT into drawers (Title, DrawerType, DrawerID, ParentID, Link, UserID, Position) values ('".mysql_real_escape_string($_POST['txtTitle'])."', 'link', '".$_POST['txtDrawer']."', '".$_POST['txtParent']."', '".mysql_real_escape_string($_POST['txtLink'])."', '".$_SESSION['userid']."', '$NewPosition')";
				$DB->query($query);

				$DrawerString = '<div id="drawer_container'.$_POST['txtDrawer'].'" class="yuimenu">
                            <div class="bd">
                                <ul class="first-of-type">
                                <li class="yuimenuitem first-of-type">';
	
				$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and ParentID='0' and DrawerID='".$_POST['txtDrawer']."' order by Position";
		
				$DB->query($query);
				$DrawerCount = 1;
				while ($line = $DB->FetchNextObject()) {
		
			   			if ($line->DrawerType == 'label') {
			   		
							$ParentID = $line->ID;
					
							$DrawerString .= '<a class="yuimenuitemlabel" href="#drawer_'.$_POST['txtDrawer'].'-'.$DrawerCount.'">'.$line->Title.'</a>';
							$DrawerString .= '<div id="#drawer_'.$DrawerID.'-'.$DrawerCount.'" class="yuimenu">
                                            <div class="bd">
                                                <ul>';
							$DrawerCount++;
					
							$query ="SELECT * from drawers where UserID='$UserID' and ParentID='$ParentID' order by Position";
							$DB2->query($query);
					//print $query.'<br/>';
							while ($line2 = $DB2->FetchNextObject()) {
							if ($line2->DrawerType == 'label') {
								   $SubParentID = $line2->ID;
								  // print 'Subparent<br/>';
								   $query = "SELECT * from drawers where UserID='$UserID' and ParentID='$SubParentID' order by Position"; 				$DB3->query($query);
									//print $query.'<br/>';
								   $DrawerString .= '<li><a class="yuimenuitemlabel" href="#drawer_'.$_POST['txtDrawer'].'-'.$DrawerCount.'">'.$line2->Title.'</a>';
								   $DrawerString .= '<div id="#drawer_'.$_POST['txtDrawer'].'-'.$DrawerCount.'" class="yuimenu">
                                            			<div class="bd">
                                                			<ul class="first-of-type">';	
								   $DrawerCount++;		
								   while ($line3 = $DB3->FetchNextObject()) {
											$DrawerString .= '<li class="yuimenuitem"><a class="yuimenuitemlabel" href="'.$line3->Link.'">'.$line3->Title.'</a></li>';
								   }
								    $DrawerString .= '</ul>';
									$DrawerString .= '</div>';
									$DrawerString .= '</div>';	
									$DrawerString .= '</li>';	
								   
							 } else {
							 
							  		$DrawerString .= '<li class="yuimenuitem"><a class="yuimenuitemlabel" href="'.$line2->Link.'">'.$line2->Title.'</a></li>';
							  
							 }
					}
					 $DrawerString .= '</ul>
                                            </div>
                                        </div>      
                                    
                                    </li>';
			   
			   } else {
			   	
					$DrawerString .= '<li class="yuimenuitem"><a class="yuimenuitemlabel" href="'.$line->Link.'">'.$line->Title.'</a></li>';
			   
			   }
		}
		      $DrawerString .= '</ul>            
                            </div>
                        </div>';

				$Step = 'close';
	
	}

}
$DB->close();
$DB2->close();
$DB3->close();
?>


<table cellpadding="0" cellspacing="0" border="0" width="475">
<tr>
<td align="center" style="color:#000000;background-color:#eef3f9;" height="100">
<form method="post" action="#">
<? 
if ($Auth) {
		
			if ($_POST['step'] == '') {?>
					
					 Please Select which available drawer you would like this item to be placed.<div style="height:5px;"></div>

					<?	echo $DrawerSelect;?><div style="height:5px;"></div>

					<input type="submit" value="NEXT: SELECT PARENT">
					
		<? } else if ($_POST['step'] == 'parent') {?>
					
					Select which parent this link should be placed under. Or select NO PARENT<div style="height:5px;"></div>

					<?	echo $ParentSelect;?><div style="height:5px;"></div>

		 <input type="submit" value="NEXT: TITLE">
		<? } else if ($_POST['step'] == 'title') {?>
					
				   You can enter a custom title or keep the current title<div style="height:5px;"></div>
		
					<input type="text" value="<? echo $Title;?>" name="txtTitle" style="width:400px;"><div style="height:5px;"></div>

					 <input type="submit" value="FINISH!">
		
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
parent.close_wizard(); 
parent.window.location ='<? echo $ReturnLink;?>'; 
</script>
<? } ?>

<input type="hidden" name="txtLink" value="<? echo $Link;?>">
<input type="hidden" name="txtItem" value="<? echo $ItemID;?>">
<input type="hidden" name="txtReturn" value="<? echo $ReturnLink;?>">
</form>
</td>
</tr>
</table>
