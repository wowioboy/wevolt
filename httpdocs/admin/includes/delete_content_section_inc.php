<? 
 $db = new DB();
$query = "select * from sections where id='$SectionID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
}
$query = "select * from categories where section='$SectionID'";
$db->query($query);
$Catcount = $db->numRows();
//print "MY query = " . $query;
//print "MY COUNT = " . $Catcount;
$query = "select * from content where section='$SectionID'";
$db->query($query);
$Contentcount = $db->numRows();

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
      DELETE SECTION</div>
      <? if ($Catcount == 0) { ?>
        <input type='submit' name='btnsubmit' value='YES' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='NO' id='submitstyle' style="text-align:left;">
<? }?>

    </td>
    <td class='adminContent' valign="top"><div class='warning'>   <? if ($Catcount > 0) { echo "THERE ARE CATEGORIES STILL UNDER THIS SECTION. YOU MUST MOVE OR DELETE THE CATEGORIES BEFORE YOU CAN REMOVE THIS SECTION"; ?><div class='spacer'></div> Click <a href='admin.php?a=content&sub=section'>HERE</a> to go back<? } else  if ($Contentcount > 0) { echo "THERE ARE POSTS STILL UNDER THIS SECTION. YOU MUST MOVE OR DELETE THE POSTS BEFORE YOU CAN REMOVE THIS SECTION"; ?><div class='spacer'></div>  Click <a href='admin.php?a=content&sub=section'>HERE</a> to go back<? } else { echo "Are you Sure you want to Delete this item?" ?></div><br /><div class='spacer'></div>
<div class='listcellmed'><b>TITLE:</b>&nbsp;<? echo $Title ?></div><? } ?></td>
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