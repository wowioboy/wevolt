<?
$userString = "";
$db = new DB();
$ProjectDB = new DB();
$query = "select * from pf_projects where ID=$ProjectID";
$db->query($query);
$userString = "<select class='inputstyle' name='txtProjectLeader'>";
while ($line = $db->fetchNextObject()) { 
$Title = $line->Title;
$Description = $line->Description;
$Deadline = explode('-',$line->Deadline);
$Year = $Deadline[0];
$Month = $Deadline[1];
$Day = $Deadline[2];
$Groups = explode(',',$line->Groups);
$GroupCount = sizeof($Groups);
$ProjectLeader = $line->ProjectLeader;
$NotifyLeader = $line->NotifyLeader;
$RemindLeader = $line->RemindLeader;
}


$query = "select * from pf_projects_users order by ID ASC";
$db->query($query);
$userString = "<select class='inputstyle'  name='txtProjectLeader'>";
while ($line = $db->fetchNextObject()) { 

$userString .= "<OPTION VALUE='".$line->ID."'";
if ($ProjectLeader == $line->ID) {
$userString .= "selected";
}

$userString .= ">".$line->Username."</OPTION>";
	}
$userString .= "</select>";

$groupString = "";
$query = "select * from pf_projects_groups order by ID ASC";
$db->query($query);
$groupString = "<select class='inputstyle' style='width:100%;' name='txtProjectGroups[]' id='txtProjectGroups' size='10' multiple='yes'>";
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


$query = "select * from pf_projects_files where ProjectID='$ProjectID' and ReadOnly = 0 order by Title ASC";
$db->query($query);
$fileString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader' width='250'>FILENAME</td><td class='tableheader' width='50'>TYPE</td><td class='tableheader'>UPLOADED BY</td><td class='tableheader'>UPLOADED DATE</td><td class='tableheader'>LINK</td></tr><tr><td colspan='6'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
$fileString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtFile' value='".$line->ID."'></td><td class='listcell' width='250'>".$line->Title."</td><td class='listcell'>".$line->Type."</td><td class='listcell'>";

$UserID = $line->UserID;
$query = "select Username from pf_projects_users where UserId='$UserID'";
$UserName = $ProjectDB->queryUniqueValue($query);
$fileString .=$UserName."</td><td class='listcell'>";
$fileString .= substr($line->CreatedDate,0,10)."</td><td class='listcell'><a href='projects/media/".$line->Filename."' target='_blank'>[DOWNLOAD]</a>";
$fileString .="</td></tr>";
	}
$fileString .= "</table>";


$query = "select * from pf_projects_files where ProjectID='$ProjectID' and ReadOnly = 1 order by Title ASC";
$db->query($query);
$SharedfileString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td class='tableheader' width='300'>FILENAME</td><td class='tableheader' width='50'>TYPE</td><td class='tableheader'>UPLOADED BY</td><td class='tableheader'>LINK</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
$SharedfileString .= "<tr><td class='listcell' >".$line->Title."</td><td class='listcell'>".$line->Type."</td><td class='listcell'>";

$UserID = $line->UserID;
$query = "select Username from pf_projects_users where UserId='$UserID'";
$UserName = $ProjectDB->queryUniqueValue($query);
$SharedfileString .=$UserName."</td><td class='listcell'><a href='projects/media/".$line->Filename."' target='_blank'>[DOWNLOAD]</a>";
$SharedfileString .="</td></tr>";
	}
$SharedfileString .= "</table>";
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
      EDIT PROJECT</div>
<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

    </td>
    <td class='adminContent' valign="top">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="514" height="73" valign="top" class="contentbox"><div class="spacer"></div>PROJECT TITLE: <br /><input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title; ?>"/>	<div class='spacer'></div>PROJECT DESCRIPTION:<br />
      <textarea class='inputstyle'  style='width:100%' name="txtDescription"><? echo $Description; ?></textarea>
<div class="spacer"></div>PROJECT DEADLINE <br /><SELECT NAME='txtMonth' class='inputstyle' >
          <?
          for ( $i=1; $i<13; $i++ ) {
            echo "<OPTION VALUE='".$i."'";
			if ($Month ==$i) {
				echo "selected";
			}
			echo ">".date("F", mktime(1,1,1,$i,1,1) )."</OPTION>";
          }
          ?>
        </SELECT>&nbsp;<select name='txtDay' class='inputstyle' >
      <?
            for ($i=1; $i<32; $i++) {
              echo "<OPTION VALUE='".$i."'";
			  if ($Day == $i) {
				echo "selected";
				}
			 echo ">".$i."</OPTION>";
            }
          ?>
    </select>&nbsp;<select name='txtYear' class='inputstyle' >
      <?
            for ($i=date("Y")+1; $i>=(date("Y")-20); $i--) {
			echo "<OPTION VALUE='".$i."'";
              if ($Year == $i) {
				echo "selected";
				}
			 	echo ">".$i."</OPTION>";
            }
          ?>
    </select><div class='spacer'></div>PROJECT LEADER<br />
<? echo $userString; ?></td>
	<td width="283" valign="top" class="contentbox"><div class="spacer"></div>PROJECT GROUPS<br />
<? echo $groupString; ?><div class='spacer'></div>Project Leader Notification<br />
<select name='txtNotifyLeader'><option value='1' <? if ($NotifyLeader == 1) echo 'selected';?> >Do Not Notify</option><option value='2' <? if ($NotifyLeader == 2) echo 'selected';?> >Notify on Update</option><option value='3' <? if ($NotifyLeader == 3) echo 'selected';?> >Notify on Completion</option></select><br />
Project Leader Report Reminders<select name='txtRemindLeader'><option value='1' <? if ($RemindLeader == 1) echo 'selected';?> >Do Not Remind</option><option value='2' <? if ($RemindLeader == 2) echo 'selected';?> >3 Weeks Before Deadline</option><option value='3' <? if ($RemindLeader == 3) echo 'selected';?> >2 Weeks Before Deadline</option><option value='4' <? if ($RemindLeader == 4) echo 'selected';?> >1 Week Before Deadline</option><option value='5' <? if ($RemindLeader == 5) echo 'selected';?> >Day Before Deadline</option><option value='6' <? if ($RemindLeader == 6) echo 'selected';?> >On Deadline</option></select></td>
	</tr>
  
    <tr>
    <td colspan="2" valign="top" class="contentbox">
    PROJECT INFORMATION FILES<br />
<? echo $SharedfileString; ?>
<div class='spacer'></div>
   UPLOADED PROJECT / TASK FILES<br />
<? echo $fileString; ?></td>
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
<input type="hidden" name="txtProject" value="<? echo $ProjectID; ?>" />
</form>