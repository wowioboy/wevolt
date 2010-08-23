<? 
$projectString = "";
$db = new DB();
$query = "select * from pf_projects";
$db->query($query);
$projectString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>PROJECT TITLE</td><td class='tableheader'>PROJECT LEADER</td><td class='tableheader'>NUMBER TASKS</td><td class='tableheader'>DEADLINE</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
$projectString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtProject' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>";
$LeaderID = $line->ProjectLeader;
$Leader = new DB();
$query = "select username from pf_projects_users where ID=$LeaderID";
$LeaderName = $Leader->queryUniqueValue($query);

$projectString .= $LeaderName."</td>";
$Tasks = new DB();
$ProjectID = $line->ID;
$query = "select * from pf_projects_tasks where ProjectID=$ProjectID";
$Tasks->query($query);
$NumTasks = $Tasks->numRows();

$projectString .="<td class='listcell'>".$NumTasks."</td><td class='listcell'>".$line->Deadline."</td></tr>";
	}
$ProjectCount = $db->numRows();
$projectString .= "</table>";
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
    PROJECTS</div>
     <div>	PROJECTS<br />
<input type='submit' name='btnsubmit' value='NEW PROJECT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='VIEW PROJECT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT PROJECT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE PROJECT' id='submitstyle' style="text-align:left;"><div class="spacer"></div><? if ($ProjectCount > 0) { ?><div align='left'>TASKS<br />
	<input type='submit' name='btnsubmit' value='NEW TASK' id='submitstyle' style="text-align:left;"/><div style="height:1px;"></div>
	<input type='submit' name='btnsubmit' value='VIEW ACTIVE TASKS' id='submitstyle' style="text-align:left;"/><div class="spacer"></div>
	<? } ?>PROJECT MEDIA<br /><input type='submit' name='btnsubmit' value='UPLOAD FILE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='VIEW FILES' id='submitstyle' style="text-align:left;"><div class="spacer"></div>GROUPS<br /> <input type='submit' name='btnsubmit' value='NEW GROUP' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT GROUPS' id='submitstyle' style="text-align:left;"><div class="spacer"></div>USERS<br /> <input type='submit' name='btnsubmit' value='NEW USER' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT USERS' id='submitstyle' style="text-align:left;"></div></td>
    <td class='adminContent' valign="top"><? echo $projectString ?></td>
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
