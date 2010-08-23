<? 
$taskString = "";
$db = new DB();
$query = "select * from pf_projects_tasks";
$db->query($query);
$taskString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>TASK TITLE</td><td class='tableheader'>PROJECT</td><td class='tableheader'>DEADLINE</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
$taskString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtTask' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>";
$ProjectID = $line->ProjectID;
$Project = new DB();
$query = "select title from pf_projects where ID=$ProjectID";
$ProjectName = $Project->queryUniqueValue($query);

$taskString .= $ProjectName."</td><td class='listcell'>".$line->Deadline."</td></tr>";
	}
$taskCount = $db->numRows();
$taskString .= "</table>";
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
    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>PROJECT TASKS</div>
     <div>	
<input type='submit' name='btnsubmit' value='EDIT TASK' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE TASK' id='submitstyle' style="text-align:left;"></div></td>
    <td class='adminContent' valign="top"><? echo $taskString; ?></td>
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
