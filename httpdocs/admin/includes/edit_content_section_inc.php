<? 
 $db = new DB();
$query = "select * from sections where id='$SectionID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
	$Description = $line->Description;
}
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
    <input type='submit' name='btnsubmit' value='CANCEL' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="top" class="listcell">CATEGORY TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/>	</td>
	<td width="40%" valign="top" class="listcell">SECTION DESCRIPTION: <br />
      <textarea class='inputstyle' name="txtDescription" style="width:95%;"><? echo $Description; ?></textarea> </td>
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
<input type="hidden" name="sub" value="section" />
<input type="hidden" name="txtSection" value="<? echo $SectionID; ?>" />
</form>