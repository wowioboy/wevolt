<?
if ($MenuID == "") {
$MenuID = $_GET['id'];
}
$db = new DB();
$query = "select * from menu where id='$MenuID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
	$Window = $line->Window;
	$Application = $line->Application;
	$Content = $line->Content;
	$Published = $line->Published;
	$Category = $line->Category;
	$Section = $line->Section;
	$MenuImage = $line->Image;
	$SubMenu = $line->SubMenu;
	$Url = $line->Url;
	if ($_GET['type'] == "") {
		$LinkType = $line->LinkType;
	} else {
	$LinkType = $_GET['type'];
	}
}

$contentString = "";
$db = new DB();
$query = "select * from pages where published=1 ORDER BY ID ASC ";
$db->query($query);
$contentString = "<select name='txtStatic' style='width:200px;'><OPTION VALUE='0'>Select Page</OPTION>";

while ($line = $db->fetchNextObject()) { 
$contentString .= "<OPTION VALUE='".$line->Title."'>".$line->Title."</OPTION>";
	}
$contentString .= "</select>";


$categoryString = "";
$query = "select * from categories ORDER BY Title ASC ";
$db->query($query);
$categoryString = "<select name='txtCategory' style='width:200px;'><OPTION VALUE='0'>Select Category</OPTION>";

while ($line = $db->fetchNextObject()) { 
$categoryString .= "<OPTION VALUE='".$line->ID."'";
if ($Category == $line->ID) {
$categoryString .= 'selected ';
}
$categoryString .= ">".$line->Title."</OPTION>";
	}
$categoryString .= "</select>";

$sectionString = "";
$query = "select * from sections ORDER BY Title ASC ";
$db->query($query);
$sectionString = "<select name='txtSection' style='width:200px;'><OPTION VALUE='0'>Select Section</OPTION>";

while ($line = $db->fetchNextObject()) { 
$sectionString .= "<OPTION VALUE='".$line->ID."'";


if ($Section == $line->ID) {
$sectionString .= 'selected ';
}
$sectionString .= ">".$line->Title."</OPTION>";
	}
$sectionString .= "</select>";

$newsString = "";

$query = "select * from content where published=1 ORDER BY ID ASC ";
$db->query($query);
$newsString = "<select name='txtContent' style='width:200px;'><OPTION VALUE='0'>Select Content</OPTION>";

while ($line = $db->fetchNextObject()) { 
$newsString .= "<OPTION VALUE='".$line->ID."'>".$line->Title."</OPTION>";
	}
$newsString .= "</select>";

$applicationString = "";

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


<form method='post' action='admin.php?a=menu'>
<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>
    NEW MENU</div>
      <div>	
	<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;"/><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CANCEL' id='submitstyle' style="text-align:left;"><div class="spacer"></div>
	</div></td>
    <td class='adminContent' valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="283" valign="top" class="listcell">TITLE: <br />
<input type="text" style="width:200px;"  name="txtTitle" value="<? echo $Title;?>"/></td>
	<td width="280" valign="top"  class="listcell" >SELECT THE LINK TYPE:
<select style="width:175px;" onchange="window.location = this.options[this.selectedIndex].value; "><option value='0'>SELECT LINK TYPE</option>
<option value="admin.php?a=menu&id=<? echo $MenuID;?>&action=change&type=application" <? if ($LinkType == 'application') {echo 'selected'; }?>>Application</option>
<option value="admin.php?a=menu&id=<? echo $MenuID;?>&action=change&type=content" <? if ($LinkType == 'content') {echo 'selected'; }?>>Content / News</option>
<option value="admin.php?a=menu&id=<? echo $MenuID;?>&action=change&type=static" <? if ($LinkType == 'static') {echo 'selected'; }?>>Static Content</option>
<option value="admin.php?a=menu&id=<? echo $MenuID;?>&action=change&type=external" <? if ($LinkType == 'external') {echo 'selected'; }?>>External Url</option></select></td>
	<td rowspan="3" valign="top" class="listcell">
    
    Published:<br />
<input type="radio" name="txtPublished" value="1" <? if ($Published == 1) {echo 'checked'; }?> />Yes  <input type="radio" name="txtPublished" value="0" <? if ($Published == 0) {echo 'checked'; }?> />No<div class='spacer'></div>

SubMenu Item:<br />
<input type="radio" name="txtSubmenu" value="1" <? if ($SubMenu == 1) {echo 'checked'; }?> />Yes  <input type="radio" name="txtSubmenu" value="0" <? if ($SubMenu == 0) {echo 'checked'; }?> />No

<div class='spacer'></div>

MENU IMAGE<br /><? if ($MenuImage != '') {?> <img src='<? echo $MenuImage; ?>' /><br/><input type='checkbox' name='txtImageRemove' value='1' />Remove Image<? }?><br /><div id='viewupload'>You need Flash and Javascript installed</div>
<script type="text/javascript"> 
    var so = new SWFObject('flash/menu_image.swf','upload','180','100','9');
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
		so.addVariable('menuid','<? echo $MenuID;?>'); 
        so.write('viewupload'); 
</script>

</td>
	</tr>
    <tr>
    <td width="283" valign="top"  class="listcell"></td>
	<td width="280" valign="top"  class="listcell" >&nbsp;</td>
	</tr>
    <tr>
    <td width="283" valign="top"  class="listcell">
     <? if ($LinkType == 'content') { ?>
		LINK TO SECTION:<br />
	<? echo $sectionString ."<div class='spacer'></div>"; } ?>
      <? if ($LinkType == 'content') { ?>
		LINK TO CATEGORY:<br />
	<? echo $categoryString; } ?>
	<? if ($LinkType == 'external') { ?>URL TARGET: <br />
<select name='txtWindow' style="width:200px;">
<OPTION VALUE="blank" <? if ($Window == 'blank') { echo 'selected';} ?>>New Window</OPTION>
<OPTION VALUE="parent" <? if ($Window == 'parent') { echo 'selected';} ?>>Same Window</OPTION>
</select><? } ?></td>
    <td width="280" valign="top" class="listcell" >
	<? if ($LinkType == 'application') { ?>
		INSTALLED APPLICATIONS: <br />
	<? echo $applicationString; } ?>
	
	<? if ($LinkType == 'static') { ?>
		AVAILABLE CONTENT:<br />
	<? echo $contentString; } ?>
    
    <? if ($LinkType == 'content') { ?>
		AVAILABLE CONTENT:<br />
	<? echo $newsString; } ?>
	
	<? if ($LinkType == 'external') { ?>
		EXTERNAL URL (including http://): <br />
		<input type="text" name="txtUrl" style="width:200px;"  value="<? echo $Url;?>"/>
	<? } ?>	</td>
	</tr>
</table>
    
    </td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="txtType" value="<? echo $LinkType;?>" />
<input type="hidden" name="txtMenu" value="<? echo $MenuID;?>" />
</form>



<div class="spacer"></div>