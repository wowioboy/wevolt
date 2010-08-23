<?
if ($MenuID == "") {
$MenuID = $_GET['id'];
}
$db = new DB();
$query = "select * from menu where id='$MenuID'";
print $query ;
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
	$Window -> $line->Window;
	$Application = $line->Application;
	$Content = $line->Content;
	$Published = $line->Published;
	$Url = $line->Url;
	if ($_GET['type'] == "") {
		$LinkType = $line->LinkType;
	} else {
	$LinkType = $_GET['type'];
	}
}

print "MY APPLICATION = " . $Application;
print "MY LINKTYPE = " . $LinkType;
$contentString = "";
$db = new DB();
$query = "select * from pages where published=1 ORDER BY ID ASC ";
$db->query($query);
$contentString = "<select name='txtStatic' style='width:200px;'><OPTION VALUE='0'>Select Content</OPTION>";

while ($line = $db->fetchNextObject()) { 
$contentString .= "<OPTION VALUE='".$line->Title."'>".$line->Title."</OPTION>";
	}
$contentString .= "</select>";

$applicationString = "";
$db = new DB();
$query = "select * from applications ORDER BY ID ASC ";
$db->query($query);
$applicationString = "<select name='txtApp' style='width:200px;'><OPTION VALUE='0'>Select Application</OPTION>";

while ($line = $db->fetchNextObject()) { 
$applicationString .= "<OPTION VALUE='".$line->Url."'";
if ($Application == $line->Url) {
$applicationString .= 'selected';
}

$applicationString .= "'>".$line->Title."</OPTION>";
	}
$applicationString .= "</select>";
?>
<div class="spacer"></div>
<form method='post' action='admin.php?a=menu'>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="283" valign="top" bgcolor="#000000" class="contentbox">TITLE: <br />
<input type="text" style="width:200px;"  name="txtTitle" value="<? echo $Title;?>"/></td>
	<td width="280" valign="top" bgcolor="#000000" class="contentbox" >SELECT THE LINK TYPE:
<select style="width:175px;" onchange="window.location = this.options[this.selectedIndex].value; "><option value='0'>SELECT LINK TYPE</option>
<option value="admin.php?a=menu&id=<? echo $MenuID;?>&action=change&type=application" <? if ($LinkType == 'application') {echo 'selected'; }?>>Application</option>
<option value="admin.php?a=menu&id=<? echo $MenuID;?>&action=change&type=static" <? if ($LinkType == 'static') {echo 'selected'; }?>>Static Content</option>
<option value="admin.php?a=menu&id=<? echo $MenuID;?>&action=change&type=external" <? if ($LinkType == 'external') {echo 'selected'; }?>>External Url</option></select>
	</td>
	<td width="274" valign="top" bgcolor="#000000" class="contentbox">Published:<br />
<input type="radio" name="txtPublished" value="1" <? if ($Published == 1) {echo 'checked'; }?> />Yes  <input type="radio" name="txtPublished" value="0" <? if ($Published == 0) {echo 'checked'; }?> />No</td>
	<td width="168" valign="top" bgcolor="#a2b7b3" class="contentbox"><div align="center">
	  <input type='submit' name='btnsubmit' value='SAVE'>
	  </div></td>
   </tr>
    <tr>
    <td width="283" valign="top" bgcolor="#000000" class="contentbox"></td>
	<td width="280" valign="top" bgcolor="#000000" class="contentbox" >&nbsp;</td>
	<td width="274" valign="top" bgcolor="#000000" class="contentbox">&nbsp;</td>
	<td width="168" valign="top" bgcolor="#a2b7b3">&nbsp;</td>
   </tr>
    <tr>
    <td width="283" valign="top" bgcolor="#000000" class="contentbox">
	<? if ($LinkType == 'external') { ?>URL TARGET: <br />
<select name='txtWindow' style="width:200px;">
<OPTION VALUE="blank" <? if ($Window == 'blank') { echo 'selected';} ?>>New Window</OPTION>
<OPTION VALUE="parent" <? if ($Window == 'parent') { echo 'selected';} ?>>Same Window</OPTION>
</select><? } ?></td>
    <td width="280" valign="top" bgcolor="#000000" class="contentbox" >
	<? if ($LinkType == 'application') { ?>
		INSTALLED APPLICATIONS: <br />
	<? echo $applicationString; } ?>
	
	<? if ($LinkType == 'static') { ?>
		AVAILABLE CONTENT:<br />
	<? echo $contentString; } ?>
	
	<? if ($LinkType == 'external') { ?>
		EXTERNAL URL (including http://): <br />
		<input type="text" name="txtUrl" style="width:200px;"  value="<? echo $Url;?>"/>
	<? } ?>
	</td>
	<td width="274" valign="top" bgcolor="#000000" class="contentbox"></td>
	<td width="168" valign="top" bgcolor="#a2b7b3">&nbsp;</td>
   </tr>
</table>
<input type="hidden" name="txtType" value="<? echo $LinkType;?>" />
<input type="hidden" name="txtMenu" value="<? echo $MenuID;?>" />
</form>
<div class="spacer"></div>