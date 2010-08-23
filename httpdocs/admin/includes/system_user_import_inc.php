<? 
$userString = "";
$userDB = new DB();
$query = "select * from users order by ID";
$userDB->query($query);
$userString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>USERNAME</td><td class='tableheader'>REAL NAME</td><td class='tableheader'>EMAIL</td><td class='tableheader'>USERTYPE</td></tr><tr><td colspan='5'>&nbsp;</td></tr>";
while ($line = $userDB->fetchNextObject()) { 
$userString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtUser' value='".$line->ID."'></td><td class='listcell' width='150'>".$line->Userid."</td><td class='listcell' width='150'>".$line->Name."</td><td class='listcell'>".$line->Email."</td><td class='listcell' width='75'>";

if ($line->UserType == '1') {
$UserType = 'Client';
} else  if ($line->UserType == '2') {
$UserType = 'User';
}else  if ($line->UserType == '3') {
$UserType = 'Editor';
}else  if ($line->UserType == '4') {
$UserType = 'Publisher';
}else  if ($line->UserType == '5') {
$UserType = 'Administrator';
}
$userString .= $UserType."</td></tr>";
	}

$userString .= "</table>";
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
    SELECT USER</div>
    <div><input type='submit' name='btnsubmit' value='IMPORT USER' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
</div></td>
    <td class='adminContent' valign="top"><? echo $userString; ?></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name='userimport' value='1'/> 
</form>
