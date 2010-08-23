<? 
 $db = new DB();
$query = "select * from faq where id='$ItemID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Answer = stripslashes($line->Answer);
	$Question = stripslashes($line->Question);
	$Published = $line->Published;
}
$db->close();
?>
<form method='post' action='admin.php?a=faq'>
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
      NEW ENTRY</div>
<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CANCEL' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="47%" valign="top" class="listcell">QUESTION: <br />
<input type="text" class='inputstyle' name="txtQuestion" value="<? echo stripslashes($Question);?>"/>	<div class='spacer'></div>Published:<br />
<input type="radio" name="txtPublished" value='1' <? if ($Published==1) { echo "checked";} ?>>YES &nbsp;<input type="radio" name="txtPublished"  value='0' <? if ($Published==0) { echo "checked";} ?>>NO &nbsp;</td>
	<td width="53%" valign="top" class="listcell"> ANSWER: <br />
      <textarea class='inputstyle' name="txtAnswer" style="width:95%; height:300px;"><? echo stripslashes($Answer);?></textarea></td>
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
<input type="hidden" name="txtItem" value="<? echo $ItemID; ?>" />
</form>