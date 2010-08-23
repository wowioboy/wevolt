<? 
$db = new DB();
$query = "select * from categories where id='$CatID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
	$Section = $line->Section;
}

$secString = "";
$db = new DB();
$query = "select * from sections order by ID ASC";
$db->query($query);
$secString = "<select style='width:100%;' name='txtSection'>";
while ($line = $db->fetchNextObject()) { 

$secString .= "<OPTION VALUE='".$line->ID."'";
if ($Section == $line->ID) {
$secString .= "selected";
}

$secString .= ">".$line->Title."</OPTION>";
	}
$secString .= "</select>";


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
    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>
      EDIT CAT</div>
<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CANCEL' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="61%" valign="top" class="listcell">CATEGORY TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/>	</td>
	<td width="39%" valign="top" class="listcell">PARENT SECTION:<br />
<? echo $secString; ?> </td>
	   </tr>
   </table></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="sub" value="cat" />
<input type="hidden" name="txtCat" value="<? echo $CatID;?>" />
</form>