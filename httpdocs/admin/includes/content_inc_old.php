<? 
$contentString = "";
$db = new DB();
$query = "select * from content ORDER BY CreationDate DESC";
$db->query($query);
$contentString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'>ID</td><td class='tableheader'>POST TITLE</td><td class='tableheader'>SECTION/CATEGORY</td><td class='tableheader'>PUBLISHED</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
$contentString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtPost' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>";
$CatID = $line->Category;
$SectionID = $line->Section;
	$db2 = new DB();
	$query = "select title from sections where id='$SectionID'";
	$SectionTitle = $db2->queryUniqueValue($query);
	$query = "select title from categories where id='$CatID'";
	$CategoryTitle = $db2->queryUniqueValue($query);
	$contentString .= $SectionTitle." / ".$CategoryTitle;

$contentString .= "</td><td class='listcell'>".$line->Published."</td></tr>";
	}
	
$contentString .= "</table>";
?>

<form method='post' action='admin.php?a=content'>
<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>NEWS / CONTENT</div>
    <div>POSTS<br />
<input type='submit' name='btnsubmit' value='NEW' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class="spacer"></div>SECTIONS:<br /><input type='submit' name='btnsubmit' value='NEW SECTION' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT SECTIONS' id='submitstyle' style="text-align:left;"><div class="spacer"></div>CATEGORIES:<br /> <input type='submit' name='btnsubmit' value='NEW CATEGORY' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT CATEGORIES' id='submitstyle' style="text-align:left;"></div></td>
    <td class='adminContent' valign="top"><? echo $contentString ?></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
</form>
