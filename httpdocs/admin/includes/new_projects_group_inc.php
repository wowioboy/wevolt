<?
$userString = "";
$db = new DB();
$query = "select * from pf_projects";
$db->query($query);
$projectString = "<select class='inputstyle' name='txtProjects[]' id='txtProjects' multiple='yes' size='10'>";
while ($line = $db->fetchNextObject()) { 
	$ProjectTitle = $line->Title;
	$projectString .= "<OPTION VALUE='".$line->ID."'";
	if ($ProjectID == $line->ID) {
		$projectString .= "selected";
	}
	$projectString .= ">".$line->Title."</OPTION>";
}
$projectString .= "</select>";


$query = "select * from pf_projects_users";
$db->query($query);
$userString = "<select class='inputstyle' name='txtUsers[]' id='txtUsers' multiple='yes' size='10'>";
while ($line = $db->fetchNextObject()) { 
	$userString .= "<OPTION VALUE='".$line->UserId."'";
	if ($UserID == $line->ID) {
		$userString .= "selected";
	}
$userString .= ">".$line->Username."</OPTION>";
}
$userString .= "</select>";
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
      NEW GROUP</div>
<input type='submit' name='btnsubmit' value='CREATE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

    </td>
    <td class='adminContent' valign="top">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="416" height="73" valign="top" class="contentbox"><div class="spacer"></div>
      GROUP TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title; ?>"/>	<div class="spacer"></div>PERMISSIONS:<br /><table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="121"><input type="checkbox" name="txtRead" value="1" <? if (($Read == 1) || ($Read == '')) echo 'checked'; ?> />
      Read</td>
    <td width="122"><input type="checkbox" name="txtUpload" value="1" <? if (($UploadFiles == 1) || ($UploadFiles == '')) echo 'checked'; ?>/>
      Upload Files</td>
    <td width="137"><input type="checkbox" name="txtDownload" value="1" <? if ($DownloadFiles == 1) echo 'checked'; ?>/>
      Download Files</td>
    <td width="120"><input type="checkbox" name="txtChangeFiles" value="1" <? if ($ChangeFiles == 1) echo 'checked'; ?>/>
      Change Files</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="txtCreateProjects" value="1" <? if ($CreateProjects == 1) echo 'checked'; ?>/>
      Create  Projects</td>
    <td><input type="checkbox" name="txtEditProjects" value="1" <? if ($EditProjects == 1) echo 'checked'; ?>/>
      Edit Projects</td>
    <td colspan="2"><input type="checkbox" name="txtDeleteProjects" value="1" <? if ($DeleteProjects == 1) echo 'checked'; ?>/>
Delete Projects</td>
    </tr>
  <tr>
    <td><input type="checkbox" name="txtCreateTasks" value="1" <? if ($CreateTasks == 1) echo 'checked'; ?>/>
      Create Tasks</td>
    <td><input type="checkbox" name="txtEditTasks" value="1" <? if ($EditTasks == 1) echo 'checked'; ?>/>
      Edit Tasks</td>
    <td><input type="checkbox" name="txtUpdateTasks" value="1" <? if (($UpdateTasks == 1) || ($UpdateTasks == '')) || echo 'checked'; ?>/>
      Update Tasks
      </td>
    <td><input type="checkbox" name="txtDeleteTasks" value="1" <? if ($DeleteTasks == 1) echo 'checked'; ?>/>
Delete Tasks</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="txtAddUsers" value="1" <? if ($AddUsers == 1) echo 'checked'; ?>/>
      Add Users&nbsp;</td>
    <td><input type="checkbox" name="txtEditUsers" value="1" <? if ($EditUsers == 1) echo 'checked'; ?>/>
Edit Users&nbsp;</td>
    <td><input type="checkbox" name="txtDeleteUsers" value="1" <? if ($DeleteUsers == 1) echo 'checked'; ?>/>
Delete Users&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="txtCreateGroups" value="1" <? if ($CreateGroups == 1) echo 'checked'; ?>/>
      Create Groups&nbsp;</td>
    <td><input type="checkbox" name="txtEditGroups" value="1" <? if ($EditGroups == 1) echo 'checked'; ?>/>
Edit Groups</td>
    <td><input type="checkbox" name="txtDeleteGroups" value="1" <? if ($DeleteGroups == 1) echo 'checked'; ?>/>
      Delete Groups </td>
    <td>&nbsp;</td>
  </tr>
</table>
 </td>
	<td valign="top" class="contentbox"><div class="spacer"></div>
	  GROUP DESCRIPTION:<br />
      <textarea class='inputstyle'  style='width:100%' name="txtDescription"></textarea></td>
	</tr>
    <tr>
    <td valign="top" class="contentbox"><div class='spacer'></div>ADD SELECTED USERS TO GROUP (select all that apply)<br />
<? echo $userString; ?><div class="spacer"></div>
<br /></td>
	<td valign="top" class="contentbox">ADD GROUP TO PROJECTS (select all that apply)<br />
<? echo $projectString; ?></td>
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
<input type="hidden" name="sub" value="group" />
</form>