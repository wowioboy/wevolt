<? 
if ($_GET['task'] != 'new_category') {
$query = "select * from pf_forum_categories where EncryptID='".$_GET['id']."' and UserID='$ForumOwner'";  
$ContentArray = $DB->queryUniqueObject($query);

$query = "SELECT Position from pf_forum_categories where UserID='$ForumOwner'";
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
}
?>
<form method='post' action='#'>
<div class="spacer"></div>
  <div style="padding:10px;">
  
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="">
  <tr>
    <td width="40%" valign="top" ><div class="sender_name">CATEGORY TITLE:</div> 
    <div class="messageinfo">
<input type="text"  style="width:100%;border:#cccccc 1px solid;" name="txtTitle" value="<? echo  stripslashes($ContentArray->Title);?>"/>	<div class="spacer"></div>

<? if ($_GET['task'] != 'new_category') {?>
<div class="sender_name">CATEGORY POSITION:</div> 
<? echo $PositionString;?>
<div class="spacer"></div>

</td>

 <td valign="top" style="padding-left:10px;">
 <? }?>
 <div class="sender_name">CATEGORY DESCRIPTION:</div>
<textarea name="txtDescription"  style="width:100%; border:#cccccc 1px solid; height:100px;"><? echo stripslashes($ContentArray->Description);?></textarea>
<div class="spacer"></div>
</td>
		   </tr>
   </table>
 
  <div class="spacer"></div>
<input type='image' style="border:none;background:none;" src="http://www.wevolt.com/images/forums/cancelsave/save_off.png">&nbsp;&nbsp;
    <img src="http://www.wevolt.com/images/forums/cancelsave/cancel_off.png" onclick="window.location='index.php?<? echo $ForumType;?>=<? echo $TargetName;?>&a=admin&task=list_categories';" class="navbuttons">
    </div><div class="spacer"></div>
<? if ($_GET['task'] != 'new_category') {?>
<input type="hidden" name="txtAction" value="save" />
<input type="hidden" name="txtCurrentPosition" value="<? echo $ContentArray->Position;?>" />
<input type="hidden" name="txtID" value="<? echo $_GET['id']; ?>" />
<? } else {?>
<input type="hidden" name="txtAction" value="new" />
<? }?>
<input type="hidden" name="submitted" value="1" />
</form>