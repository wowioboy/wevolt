<? 
$secString = "";
$db = new DB();
$query = "select * from sections ORDER BY ID ASC";
$db->query($query);
$secString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'>ID</td><td class='tableheader'>SECTION TITLE</td><td class='tableheader'>CATEGORIES</td></tr><tr><td colspan='3'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
	$secString .= "<tr><td width='3%' align='left'class='listcell'><input type='radio' name='txtSection' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>";
	$SectionID = $line->ID;
	$db2 = new DB();
	$query = "select * from categories where section='$SectionID'";
	$db2->query($query);
	$CatCount = $db2->numRows();
	$secString .= $CatCount;
	$secString .= "</td></tr>";
}
	
$secString .= "</table>";
?>
<form method='post' action='admin.php?a=content&sub=section'>

<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>
      SECTIONS</div><input type='submit' name='btnsubmit' value='NEW' id='submitstyle' style="text-align:left;" ><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
<? echo $secString ?></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type='hidden' name='sub' value='section'>
</form>