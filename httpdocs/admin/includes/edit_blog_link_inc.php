<? 
 $db = new DB();
$query = "select * from pf_blog_links where id='$LinkID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
	$LinkDescription = $line->Description;
	$Url = $line->Url;
	$Published = $line->Published;
	
}
?>
<form method='post' action='admin.php?a=blog'>

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
      EDIT LINK</div>
<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CANCEL' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%" valign="top" class="listcell">LINK TITLE: <br />
<input type="text" class='inputstyle'  name="txtTitle" value="<? echo $Title;?>"/>	<div class='spacer'></div>LINK DESCRIPTION:<textarea name='txtDescription' style="width:100%"><? echo $LinkDescription?></textarea></td>
	<td width="47%" valign="top" class="listcell">URL(including http://): <br />
<input type="text" class='inputstyle'  name="txtUrl" value="<? echo $Url;?>"/>	<div class='spacer'></div>PUBLISHED:<br />
<input type="radio" name="txtPublished" value="1"  <? if ($Published == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtPublished" value="0" <? if ($Published == 0) { echo 'checked';}?> />NO</td>
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
<input type="hidden" name="sub" value="link" />
<input type="hidden" name="txtLink" value="<? echo $LinkID; ?>" />
</form>