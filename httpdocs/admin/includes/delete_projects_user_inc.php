<? 
 $db = new DB();
$query = "select * from pf_projects_users where id='$UserID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Username = $line->Username;
}

?>
<form method='post' action='admin.php?a=projects'>

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
      DELETE GROUP</div>
<input type='submit' name='btnsubmit' value='YES' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='NO' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top"><div class='warning'>Are you Sure you want to remove this user's access from Projects?</div><br /><div class='spacer'></div>
<div class='listcellmed'><b>USERNAME:</b>&nbsp;<? echo $Username ?></div></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="sub" value="users" />
<input type="hidden" name="txtUser" value="<? echo $UserID; ?>" />
</form>