<?
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
$applicationString .= "<OPTION VALUE='".$line->Url."'>".$line->Title."</OPTION>";
	}
$applicationString .= "</select>";

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
?>
<div class="spacer"></div>

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
	<input type='submit' name='btnsubmit' value='CREATE' id='submitstyle' style="text-align:left;"/><div class="spacer"></div>
	</div></td>
    <td class='adminContent' valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="283" valign="top" class="contentbox">TITLE: <br />
<input type="text" style="width:200px;"  name="txtTitle" /></td>
	<td width="280" valign="top"  class="contentbox" >SELECT THE LINK TYPE:
<select style="width:175px;" onchange="window.location = this.options[this.selectedIndex].value; "><option value='0'>SELECT LINK TYPE</option>
<option value="admin.php?a=menu&action=new&type=application" <? if ($_GET['type'] == 'application') {echo 'selected'; }?>>Application</option><option value="admin.php?a=menu&action=new&type=content" <? if ($_GET['type']  == 'content') {echo 'selected'; }?>>Content / News</option>
<option value="admin.php?a=menu&action=new&type=static" <? if ($_GET['type'] == 'static') {echo 'selected'; }?>>Static Content</option>
<option value="admin.php?a=menu&action=new&type=external" <? if ($_GET['type'] == 'external') {echo 'selected'; }?>>External Url</option></select>	</td>
	<td rowspan="3" valign="top" class="contentbox">Published:<br />
<input type="radio" name="txtPublished" value="1" checked />Yes  <input type="radio" name="txtPublished" value="0" />No<div class='spacer'></div>SubMenu Item:<br />
<input type="radio" name="txtSubmenu" value="1"/>Yes  <input type="radio" name="txtSubmenu" value="0" checked >No</td>
	</tr>
    <tr>
    <td width="283" valign="top"  class="contentbox"></td>
	<td width="280" valign="top"  class="contentbox" >&nbsp;</td>
	</tr>
    <tr>
    <td width="283" valign="top"  class="contentbox">
     <? if ($_GET['type'] == 'content') { ?>
		LINK TO SECTION:<br />
	<? echo $sectionString ."<div class='spacer'></div>"; } ?>
      <? if ($_GET['type'] == 'content') { ?>
		LINK TO CATEGORY:<br />
	<? echo $categoryString; } ?>
	<? if ($_GET['type'] == 'external') { ?>URL TARGET: <br />
<select name='txtWindow' style="width:200px;">
<OPTION VALUE="blank">New Window</OPTION>
<OPTION VALUE="parent">Same Window</OPTION>
</select><? } ?></td>
    <td width="280" valign="top" class="contentbox" >
	<? if ($_GET['type'] == 'application') { ?>
		INSTALLED APPLICATIONS: <br />
	<? echo $applicationString; } ?>
	
	<? if ($_GET['type'] == 'static') { ?>
		AVAILABLE CONTENT:<br />
	<? echo $contentString; } ?>
    
    <? if ($_GET['type'] == 'content') { ?>
		LINK TO CONTENT:<br />
	<? echo $newsString; } ?>
	
	<? if ($_GET['type'] == 'external') { ?>
		EXTERNAL URL (including http://): <br />
		<input type="text" name="txtUrl" style="width:200px;"  />
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
<input type="hidden" name="txtType" value="<? echo $_GET['type'];?>" />
</form>



<div class="spacer"></div>