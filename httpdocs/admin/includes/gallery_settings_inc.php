<? 
$db = new DB();
$query = "select * from settings";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$SiteTitle = $line->SiteTitle;
	$FrontPage = $line->FrontPage;
	$MenuLayout = $line->MenuLayout;
	$Copyright = $line->Copyright;
}
?>

<form method="post" action="admin.php?a=settings" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="41%" valign="top">SITE TITLE:<br>
<input type="text" name="txtSiteTitle" style="width:250px;" value="<? echo $SiteTitle; ?>">
<div class="spacer"></div>
MENU LAYOUT:<br>
<input type="radio" name="txtMenuLayout" value="1" <? if ($MenuLayout==1) { echo "checked";} ?>>Horizontal&nbsp;<input type="radio" name="txtMenuLayout" value="2" <? if ($MenuLayout==2) { echo "checked";} ?>>Vertical</td>
    <td width="34%" valign="top">SITE COPYRIGHT:<br>
<input type="text" name="txtCopyright" style="width:250px;" value="<? echo $Copyright; ?>"><div class="spacer"></div>FRONTPAGE: <br>
<select name="txtFrontPage"><option value="1" <? if ($Frontpage==1) { echo "selected";} ?>>Frontpage</option><option value="2" <? if ($Frontpage==2) { echo "selected";} ?>>Blog</option><option value="3" <? if ($Frontpage==3) { echo "selected";} ?>>News</option></select></td>
    <td width="25%" bgcolor="#a2b7b3"><div align="center">
      <input type='submit' name='btnsubmit' value='SAVE'>
    </div></td>
  </tr>
</table>

</form>