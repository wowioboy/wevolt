<? 
$catString = "";
$db = new DB();
$query = "select * from categories ORDER BY ID ASC";
$db->query($query);
$catString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader' style='padding-left:3px;'>ID</td><td class='tableheader'>CATEGORY TITLE</td><td class='tableheader'>SECTION</td></tr><tr><td colspan='3' style='height:2px; background-color:#474747;'></td></tr>";
while ($line = $db->fetchNextObject()) { 
	$catString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtCat' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>";
	$SectionID = $line->Section;
	$db2 = new DB();
	$query = "select title from sections where id='$SectionID'";
	$SectionTitle = $db2->queryUniqueValue($query);
	$catString .= $SectionTitle;

	$catString .= "</td></tr>";
}
	
$catString .= "</table>";
?>
<form method='post' action='admin.php?a=content&sub=cat'>


<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>CATEGORIES</div>
    <div><input type='submit' name='btnsubmit' value='NEW' id='submitstyle' style="text-align:left;" ><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><input type='hidden' name='sub' value='cat'></div></td>
    <td class='adminContent' valign="top"><? echo $catString ?></td>
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
