<?
$db = new DB();
$groupString = "";
$query = "select * from pf_projects_groups order by ID ASC";
$db->query($query);
$groupString = "<select class='inputstyle' name='txtProjectGroups[]' id='txtProjectGroups' size='10' multiple='yes'>";
while ($line = $db->fetchNextObject()) { 

$groupString .= "<OPTION VALUE='".$line->ID."'";
$i=0;
		while ($i <= $GroupCount) {
			if ($Groups[$i] == $line->ID) {
				$groupString .= ' selected';
			}
			$i++;
		}

$groupString .= ">".$line->Title."</OPTION>";
	}
$groupString .= "</select>";

$userDB = new DB();
$query = "select * from users where id='$UserID'";
$UserArray = $userDB->queryUniqueObject($query);
$Username = $UserArray->Userid;
$UserType = $UserArray->UserType;
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
    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>
      USER GROUPS</div>
<input type='submit' name='btnsubmit' value='CREATE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

    </td>
    <td class='adminContent' valign="top">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="434" height="73" valign="top" class="contentbox"><div class="spacer"></div>
    SELECT GROUPS FOR THIS USER<br />
    <? echo $groupString; ?><br />
    <div class="spacer"></div></td>
    <td width="366" valign="top" class="contentbox"><div class="spacer"></div>  SELET THE USERTYPE<br />
<select name='txtProjectsUserType' class='inputstyle'>
<OPTION VALUE="1" <? if ($ProjectUserType == '1'){echo 'selected';}?>>CLIENT</OPTION>
<OPTION VALUE="2" <? if ($ProjectUserType == '2'){echo 'selected';}?>>CONTRACTOR</OPTION>
<OPTION VALUE="3" <? if ($ProjectUserType == '4'){echo 'selected';}?>>EDITOR</OPTION>
<OPTION VALUE="4" <? if ($ProjectUserType == '5'){echo 'selected';}?>>MANAGER</OPTION>
<OPTION VALUE="5" <? if ($ProjectUserType == '6'){echo 'selected';}?>>ADMINISTRATOR</OPTION>
</select>  <br /></td>
  </tr>
    <tr>
    <td valign="top" class="contentbox"><br /></td>
	<td valign="top" class="contentbox">&nbsp;</td>
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
<input type="hidden" name="txtUser" value="<? echo $UserID; ?>" />
<input type="hidden" name="sub" value='user' />
<input type="hidden" name="txtUsername" value='<? echo $Username;?>' />
<input type="hidden" name="txtUserType" value='<? echo $UserType;?>' />
</form>