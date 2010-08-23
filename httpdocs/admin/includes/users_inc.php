<? 
$userString = "";
$userDB = new DB();
$query = "select * from users order by username";
$userDB->query($query);
$userString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>USERNAME</td><td class='tableheader'>REAL NAME</td><td class='tableheader'>EMAIL</td><td class='tableheader'>USERTYPE</td></tr><tr><td colspan='5'>&nbsp;</td></tr>";
while ($line = $userDB->fetchNextObject()) { 
$userString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtUser' value='".$line->encryptid."'></td><td class='listcell' width='150'>".$line->username."</td><td class='listcell' width='150'>".$line->realname."</td><td class='listcell'>".$line->email."</td><td class='listcell' width='75'>";

if ($line->AdminAccount == '0') {
$UserType = 'User';
} else  if ($line->AdminAccount == '2') {
$UserType = 'Moderator';
}else  if ($line->AdminAccount == '1') {
$UserType = 'Administrator';
}
$userString .= $UserType."</td></tr>";
	}

$userString .= "</table>";
?>
<form method='post' action='admin.php?a=users'>
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
    USERS</div>
    <div><input type='submit' name='btnsubmit' value='NEW USER' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT USER' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE USER' id='submitstyle' style="text-align:left;"></div></td>
    <td class='adminContent' valign="top"><? echo $userString ?></td>
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
