<?
$userDB = new DB();
$query = "select * from users where id='$UserID' limit 1";
$userDB->query($query);
while ($line = $userDB->fetchNextObject()) { 
$RealName = $line->Name;
$UserName = $line->Userid;
$Email = $line->Email;
$UserType = $line->UserType;

}
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
      DELETE USER</div>
<input type='submit' name='btnsubmit' value='YES' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='NO' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top"><div class='warning'>Are you Sure you want to Delete this User? <div class='spacer'></div>
     </div>
    <div class='spacer' ></div>
<div class='listcellmed'><b>REAL NAME:</b>&nbsp;<? echo $RealName ?></div><div class='listcellmed'><b>USERNAME:</b>&nbsp;<? echo $UserName; ?></div><div class='listcellmed'><b>EMAIL ADDRESS:</b>&nbsp;<? echo $Email; ?></div></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="txtUser" value="<? echo $UserID;?>" />
</form>