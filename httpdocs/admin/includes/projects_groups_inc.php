<? 

$userString = "";
$userDB = new DB();
$query = "select * from pf_projects_groups order by ID";
$userDB->query($query);
$userString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader' width='250'>GROUP NAME</td><td class='tableheader' width='250'>PROJECTS</td><td class='tableheader'># of USERS</td><td class='tableheader'>GROUP PERMISSIONS</td></tr><tr><td colspan='5'>&nbsp;</td></tr>";
while ($line = $userDB->fetchNextObject()) {
$projectDB = new DB();
$GroupID = $line->ID;
$query = "select Groups, Title from pf_projects order by ID";
$projectDB->query($query);
$ProjectString = '';
while ($line2 = $projectDB->fetchNextObject()) {
$TotalProjects = 0;
	$Grouprojects = explode(",", $line2->Groups);
	$NumProjects = sizeof($Grouprojects);
	$counter = 0;
	while ($counter < $NumProjects) {
		if ($GroupID ==  $Grouprojects[$counter]) {
			$TotalProjects++;
			if (strlen($ProjectString) > 0) {
			$ProjectString .= ', ' .$line2->Title;
			} else {
			$ProjectString .= $line2->Title;
			}
			
		}
		$counter++;
	}
}

$GroupUsers = explode(",", $line->Users);
$NumUsers = sizeof($GroupUsers);
$userString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtGroup' value='".$line->ID."'></td><td class='listcell' width='150'>".$line->Title."</td><td class='listcell' width='150'>".$ProjectString."</td><td class='listcell'>".$NumUsers."</td>";

if (($line->ReadPermission == 1) && ($line->WritePermission == 1)){
$Permission = 'Read / Write';
} else if (($line->ReadPermission == 1) && ($line->WritePermission == 0)){
$Permission = 'Read Only';
}

$userString .= "<td class='listcell'>".$Permission."</td></tr>";

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
    PROJECT GROUPS</div>
    <div><input type='submit' name='btnsubmit' value='NEW GROUP' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div><input type='submit' name='btnsubmit' value='EDIT GROUP' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE GROUP' id='submitstyle' style="text-align:left;"></div></td>
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
