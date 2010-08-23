<?
$i=0;
$k=0;
$projectString = "";
$db = new DB();
$groupdb = new DB();
$userdb = new DB();
$query = "select * from pf_projects_tasks where ID='$TaskID'";
$TaskSettings = $db->queryUniqueObject($query);
$Title = $TaskSettings->Title;
$Description = $TaskSettings->Description;
$TaskSettings->Title;
$Deadline = explode('-',$TaskSettings->Deadline);
$Year = $Deadline[0];
$Month = $Deadline[1];
$Day = $Deadline[2];
$Priority = $TaskSettings->Priority;
$FilesArray = explode(',',$TaskSettings->Files);
$FilesCount = sizeof($FilesArray);
$TaskUsersArray = explode('-',$TaskSettings->Users);
$TaskUsersCount = sizeof($TaskUsersArray);
$ProjectID = $TaskSettings->ProjectID;
$NotifyLeader = $TaskSettings->NotifyLeader;
$NotifyUsers = $TaskSettings->NotifyUsers;
$RemindUsers = $TaskSettings->RemindUsers;



$userString = "";
$userString = "<select style='width:175px;' name='txtTaskUsers[]' id='txtTaskUsers' multiple='yes' size='5'>";

// GET THE GROUPS AVAILABLE TO THE PROJECT AND PUT THOSE INTO AN ARRAY
$query = "select * from pf_projects where ID='$ProjectID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$ProjectGroups = explode(',',$line->Groups);
	$ProjectGroupCount = sizeof($ProjectGroups);
	//print "MY PROJECT GROUP SIZE =" . $ProjectGroupCount."<br/>";
}

while ($i < $ProjectGroupCount) {
		$GroupID = $ProjectGroups[$i];
		$query = "select users from pf_projects_groups where ID='$GroupID' and ReadPermission=1 and UpdateTasks=1";
		//print $query."<br/>";
		$GroupUsers = $groupdb->queryUniqueValue($query);
		//print "MY group Users = " .$GroupUsers."<br/>";
		$GroupUsersArray = explode(',',$GroupUsers);
		$GroupUsercount = sizeof($GroupUsersArray);
		//print "MY USER COUNT =" . $GroupUsercount."<br/>"; 
		$k=0;
		while ($k < $GroupUsercount) {
			$UserID = $GroupUsersArray[$k];
			//print "MY USERID = " . $UserID."<br/>";
			if ($GroupUsercount == 1) {
				$UserID = $GroupUsers;
			}
			
			$query = "select * from pf_projects_users where ID=$UserID";
			//print $query."<br/>";
			$UserInfo = $userdb->queryUniqueObject($query);
			$j=0;
			$Addedsize = sizeof($AddedUsers);
			//print "MY ADDED SIZE = " .$Addedsize."<br/>";
			$TestID = $UserInfo->UserId;
			$TestName = $UserInfo->Username;
			if ($Addedsize == 0) {
				$userString .= "<OPTION VALUE='".$UserInfo->UserId."'";
				//print $TestName.'WAS ADDED'.' <br/><br/>';
				$x=0;
					while ($x < $TaskUsersCount) {
					//print "TASK USER ID = " . $TaskUsersArray[$x]."<br/>";
					//print "TestID = " .$TestID."<br/>";
						if (intval($TaskUsersArray[$x]) == $TestID) {
							$userString .= " selected ";
					//	print "SHOULD BE ADDING SELECTED";
							$x =$TaskUsersCount;
						}
						$x++;
					}
				$userString .= ">".$UserInfo->Username."</OPTION>";
			} else {
			 // print "STARTLING USER LOOP CHECK -----------------------<br/>";
				while ($j < $Addedsize) {
				//print "MY TEST ID = " .$TestID."<br/>";
				//print "MY TEST ADDED USERS ID = " .$AddedUsers[$j]."<br/>";
					if ($TestID == $AddedUsers[$j]) {
						$j = $Addedsize;
						$DontAdd = 1;
						//print "USER ALREADY ADDED"." <br/><br/>";
					} else {
						$DontAdd = 0;
					}
					$j++;
				}
				
				if ($DontAdd == 0) {
					//print $TestName.'WAS ADDED <br/><br/>';
					$userString .= "<OPTION VALUE='".$UserInfo->ID."'";
						
						$x=0;
						while ($x < $TaskUsersCount) {
							if (intval($TaskUsersArray[$x]) == $TestID) {
								$userString .= " selected ";
								//print "SHOULD BE ADDING SELECTED";
								$x =$TaskUsersCount;
							}
						$x++;
						}
					$userString .= ">".$UserInfo->Username."</OPTION>";
				}
				
			}
			$k++;
			$AddedUsers[] = $TestID;
		}
		
		
		$i++;
	}
$userString .= "</select>";


//FOR EACH GROUP, PULL THE USERS IN THAT GROUP AND BUILD THE USER LIST FOR THE TASK
		
		

$query = "select * from pf_projects order by ID ASC";
$db->query($query);
$projectString = "<select style='width:175px;' name='txtProject'>";
while ($line = $db->fetchNextObject()) { 
	$projectString .= "<OPTION VALUE='".$line->ID."'";
	if ($ProjectID == $line->ID) {
		$projectString .= "selected";
	}

	$projectString .= ">".$line->Title."</OPTION>";
}
$projectString .= "</select>";


$groupString = "";
$query = "select * from pf_projects_groups order by ID ASC";
$db->query($query);
$groupString = "<select style='width:175px;' name='txtProjectGroups[]' size='3' multiple='yes'>";
while ($line = $db->fetchNextObject()) { 
	$groupString .= "<OPTION VALUE='".$line->ID."'";
	if ($Section == $line->ID) {
		$groupString .= "selected";
	}

	$groupString .= ">".$line->Title."</OPTION>";
}
$groupString .= "</select>";

$fileString = "";
$query = "select * from pf_projects_files where ProjectID =$ProjectID order by ID ASC";
$db->query($query);
$fileString = "<select style='width:175px;' name='txtFiles[]' size='3' multiple='yes'>";
while ($line = $db->fetchNextObject()) { 

	$fileString .= "<OPTION VALUE='".$line->ID."'";
	$z=0;
		while ($z < $FilesCount) {
	//	print "MY FILES COUNT = " . $FilesCount."<br/>";
			$FileID = $FilesArray[$z];
			if ($FileID == $line->ID) {
				$fileString .= "selected";
			}
			$z++;
		}

$fileString .= ">".$line->Title."</OPTION>";
}
$fileString .= "</select>";


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
      EDIT TASK</div>
<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CANCEL' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="416" height="73" valign="top"  class="contentbox">TASK TITLE: <br />
  <input type="text" class='inputstyle' name="txtTitle" value='<? echo $Title;?>'/>	<div class="spacer"></div>TASK DESCRIPTION:<br />
      <textarea class='inputstyle' style='width:100%; height:150px;' name="txtDescription"><? echo $Description;?></textarea></td>
    <td width="396" valign="top"  class="contentbox">
<div class="spacer"></div>Project Leader Notification<br />
<select name='txtNotifyLeader'><option value='1' <? if ($NotifyLeader == 1) echo 'selected';?> >Do Not Notify</option><option value='2' <? if ($NotifyLeader == 2) echo 'selected';?> >Notify on Update</option><option value='3' <? if ($NotifyLeader == 3) echo 'selected';?> >Notify on Assignment</option><option value='4' <? if ($NotifyLeader == 4) echo 'selected';?> >Notify on Completion</option></select><br />
<div class="spacer"></div>User Notification<br />
<select name='txtNotifyUser'><option value='1' <? if ($NotifyUsers == 1) echo 'selected';?> >Do Not Notify</option><option value='2' <? if ($NotifyUsers == 2) echo 'selected';?> >Notify on Update</option><option value='3' <? if ($NotifyUsers == 3) echo 'selected';?> >Notify on Assignment</option></select>
<br />
Remind Users<br />
<select name='txtRemindUser'><option value='1' <? if ($RemindUsers == 1) echo 'selected';?> >Do Not Remind</option><option value='2' <? if ($RemindUsers == 2) echo 'selected';?> >Everyday</option><option value='3' <? if ($RemindUsers == 3) echo 'selected';?> >1 Time a week</option><option value='4' <? if ($RemindUsers == 4) echo 'selected';?> >2 Times a week</option><option value='5' <? if ($RemindUsers == 5) echo 'selected';?> >Once a Month</option><option value='6' <? if ($RemindUsers == 6) echo 'selected';?> >One Week Before Deadline</option><option value='7' <? if ($RemindUsers == 7) echo 'selected';?> >Day Before Deadline</option></select></td>
      </tr>
    <tr>
    <td valign="top" class="contentbox">TASK DEADLINE <br /><SELECT NAME='txtMonth' class='inputstyle'>
          <?
          for ( $i=1; $i<13; $i++ ) {
            echo "<OPTION VALUE='".$i."'";
			if ($Month ==$i) {
				echo "selected";
			}
			echo ">".date("F", mktime(1,1,1,$i,1,1) )."</OPTION>";
          }
          ?>
        </SELECT>&nbsp;<select name='txtDay' class='inputstyle'>
      <?
            for ($i=1; $i<32; $i++) {
              echo "<OPTION VALUE='".$i."'";
			  if ($Day == $i) {
				echo "selected";
				}
			 echo ">".$i."</OPTION>";
            }
          ?>
    </select>&nbsp;<select name='txtYear' class='inputstyle'>
      <?
            for ($i=date("Y")+1; $i>=(date("Y")-20); $i--) {
			echo "<OPTION VALUE='".$i."'";
              if ($Year == $i) {
				echo "selected";
				}
			 	echo ">".$i."</OPTION>";
            }
          ?>
    </select><div class="spacer"></div>
Assign Task to Users<br />
<? echo $userString; ?></td>
	<td valign="top"  class="contentbox">TASK PRIORITY (1 = low, 5 = high)<br />
<select name='txtPriority'>
<option value='1' <? if ($Priority==1) {echo 'selected';}?>>1</option>
<option value='2' <? if ($Priority==2) {echo 'selected';}?>>2</option>
<option value='3' <? if ($Priority==3) {echo 'selected';}?>>3</option>
<option value='4' <? if ($Priority==4) {echo 'selected';}?>>4</option>
<option value='5' <? if ($Priority==5) {echo 'selected';}?>>5</option>
</select>
<div class="spacer"></div>
ASSIGN PROJECT FILES<br />
<? echo $fileString; ?> </td>
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
<input type="hidden" name="txtTask" value="<? echo $TaskID;?>" />
<input type="hidden" name="sub" value="task" />
</form>