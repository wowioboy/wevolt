<? 

$query = "SELECT * from pf_forum_boards where EncryptID='".$_GET['id']."'";
$ContentArray = $DB->queryUniqueObject($query);
$CatID = $ContentArray->CatID;
$CurrentPosition = $ContentArray->Position;

$query = "SELECT Position from pf_forum_boards where CatID='$CatID' and UserID='$ForumOwner'";
$DB->query($query);

$PositionString = "<select name='txtPosition' style='width:100px;'>";

while ($line = $DB->fetchNextObject()) { 
$PositionString .= "<OPTION VALUE='".$line->Position."'";
if ($line->Position == $ContentArray->Position) {
$PositionString .= "selected";
}
$PositionString .= ">".$line->Position."</OPTION>";
	}

$PositionString .= "</select>";


$query = "select * from pf_forum_categories where ";
if ($ForumType == 'project')
	$query .= "ProjectID='$ProjectID'";
else
	$query .= "UserID='$ForumOwner'";

 $query .= " order by ID ASC";
$DB->query($query);
$NumCats = $DB->numRows();
if ($NumCats == 0) {
	$NOW = date('Y-m-d h:m:s');
	$query = "INSERT into pf_forum_categories (Title, Description, UserID, ProjectID,Position, CreatedDate) values ('General', 'Just this and that','$ForumOwner', '$ProjectID',1,'$NOW')";
	$DB->execute($query);
	$query ="SELECT ID from pf_forum_categories WHERE where UserID='$ForumOwner' and CreatedDate='$NOW'";
	$CatID = $DB->queryUniqueValue($query);
}
$catString = "<select name='txtCat' style='width:100%;'>";
if ($NumCats == 0) {
$catString .= "<OPTION VALUE='".$CatID."'> General</option>";
} else {
while ($line = $DB->fetchNextObject()) { 
$catString .= "<OPTION VALUE='".$line->ID."'";
if ($line->ID == $ContentArray->CatID) {
$catString .= "selected";
}
$catString .= ">".$line->Title."</OPTION>";
	}
	
	}
$catString .= "</select>";
$SelectedGroups = explode(',',$ContentArray->SelectedGroups);
if ($SelectedGroups == null)
	$SelectedGroups = array();
$query = "select  * from user_groups where UserID='".$_SESSION['userid']."'"; 
$DB->query($query);

$GroupSelect = '<select name="txtGroups[]" size="3" multiple style="height:35px;">';
while($line = $DB->fetchNextObject()) {
	$GroupSelect .= '<option value="'.$line->ID.'"';
	if (in_array($line->ID,$SelectedGroups))
		$GroupSelect .= ' selected '; 
	$GroupSelect .='>'.$line->Title.'<option>';	
}
$GroupSelect .= '</select>';
?>
<script type="text/javascript">
function toggle_groups(value) {
	
	if (value == 'groups')
		document.getElementById("group_select").style.display = '';
	else
		document.getElementById("group_select").style.display = 'none';
	
}

</script>
<form method='post' action='#'>


<div class="spacer"></div>
  <div style="padding:10px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="">
  <tr>
    <td width="40%" valign="top" ><div class="sender_name">BOARD TITLE:</div> 
    <div class="messageinfo">
<input type="text" style="width:100%;border:#cccccc 1px solid;" name="txtTitle" value="<? echo stripslashes($ContentArray->Title);?>"/>	<div class="spacer"></div><div class="sender_name">PRIVACY SETTING</div>
<select name="txtPrivacy" onchange="toggle_groups(this.options[this.selectedIndex].value);">
<option value="public" <? if (($ContentArray->PrivacySetting =='public')  || ($ContentArray->PrivacySetting == '')) echo 'selected';?>>Public</option>
<option value='fans' <? if ($ContentArray->PrivacySetting =='fans') echo 'selected';?>>Fans</option>
<option value='friends'<? if ($ContentArray->PrivacySetting =='friends') echo 'selected';?>>Friends</option>
<option value='private'<? if ($ContentArray->PrivacySetting =='private') echo 'selected';?>>Private</option>
<option value='groups'<? if ($ContentArray->PrivacySetting =='groups') echo 'selected';?>>Groups</option>
</select>
<div id="group_select" style=" <? if ($ContentArray->PrivacySetting != 'groups') {?>display:none;<? }?>">
Groups
<? echo $GroupSelect;?>
</div>
<div class="spacer"></div>
<input type="radio" name="txtPro" value="1" <? if ($ContentArray->IsPro == 1) echo 'checked';?> />Pro Board&nbsp;&nbsp;<input type="radio" name="txtPro" value="0" <? if ($ContentArray->IsPro == 0) echo 'checked';?> />Non Pro


<!--<input type="radio" name="txtPrivacy" value="assign"  <? //if (($PrivacySetting == 'assign') || ($PrivacySetting == 'assign')) { echo 'checked';}?>/>User by User<br>--><div class="spacer"></div>
<div class="sender_name">BOARD POSITION:</div> 
<? echo $PositionString;?>
<div class="spacer"></div><div class="sender_name">BOARD CATEGORY</div>
<? echo $catString;?>
</td>

 <td valign="top" style="padding-left:10px;"><div class="sender_name">BOARD DESCRIPTION:</div>
<textarea name="txtDescription"  style="width:100%; border:#cccccc 1px solid; height:150px;"><? echo stripslashes($ContentArray->Description);?></textarea><div class="spacer"></div>
<div class="sender_name">MODERATORS: (enter WEvolt username, seperate each with comma)</div>
<textarea name="txtModerators"  style="width:100%; border:#cccccc 1px solid; height:150px;"><? echo stripslashes($ContentArray->Moderators);?></textarea></td>
		   </tr>
   </table>
   
  <div class="spacer"></div>
<input type='image' style="border:none;background:none;" src="http://www.wevolt.com/images/forums/cancelsave/save_off.png">&nbsp;&nbsp;
    <img src="http://www.wevolt.com/images/forums/cancelsave/cancel_off.png" onclick="window.location='index.php?<? echo $ForumType;?>=<? echo $TargetName;?>&a=admin&task=list_boards';" class="navbuttons">

</div><div class="spacer"></div>
<input type="hidden" name="txtAction" value="save" />
<input type="hidden" name="submitted" value="1" />
<input type="hidden" name="txtCurrentPosition" value="<? echo $ContentArray->Position;?>" />
<input type="hidden" name="txtID" value="<? echo $_GET['id']; ?>" />
</form>