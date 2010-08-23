<?
$CurrentDay = date('d');
$CurrentMonth = date('m');
$CurrentYear = date('Y');
$userString = "";
$db = new DB();
$query = "select * from pf_projects_users order by ID ASC";
$db->query($query);
$userString = "<select class='inputstyle'  name='txtProjectLeader'>";
while ($line = $db->fetchNextObject()) { 

$userString .= "<OPTION VALUE='".$line->ID."'";
if ($Section == $line->ID) {
$userString .= "selected";
}

$userString .= ">".$line->Username."</OPTION>";
	}
$userString .= "</select>";

$groupString = "";
$query = "select * from pf_projects_groups order by ID ASC";
$db->query($query);
$groupString = "<select class='inputstyle'  name='txtProjectGroups[]' id='txtProjectGroups' size='10' multiple='yes'>";
while ($line = $db->fetchNextObject()) { 

$groupString .= "<OPTION VALUE='".$line->ID."'";
if ($Section == $line->ID) {
$groupString .= "selected";
}

$groupString .= ">".$line->Title."</OPTION>";
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
      NEW PROJECT</div>
<input type='submit' name='btnsubmit' value='CREATE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

    </td>
    <td class='adminContent' valign="top">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="416" height="73" valign="top" class="contentbox"><div class="spacer"></div>PROJECT TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" />	<div class='spacer'></div>PROJECT DESCRIPTION:<br />
      <textarea class='inputstyle'  style='width:100%' name="txtDescription"></textarea></td>
	<td valign="top" class="contentbox"><div class="spacer"></div>Project Leader Notification<br />
<select name='txtNotifyLeader'><option value='1' <? if ($NotifyLeader == 1) echo 'selected';?> >Do Not Notify</option><option value='2' <? if ($NotifyLeader == 2) echo 'selected';?> >Notify on Update</option><option value='3' <? if ($NotifyLeader == 3) echo 'selected';?> >Notify on Assignment</option><option value='4' <? if ($NotifyLeader == 4) echo 'selected';?> >Notify on Completion</option></select><br />
Project Leader Report Reminders<select name='txtRemindLeader'><option value='1' <? if ($RemindLeader == 1) echo 'selected';?> >Do Not Remind</option><option value='2' <? if ($RemindLeader == 2) echo 'selected';?> >3 Weeks Before Deadline</option><option value='3' <? if ($RemindLeader == 3) echo 'selected';?> >2 Weeks Before Deadline</option><option value='4' <? if ($RemindLeader == 4) echo 'selected';?> >1 Week Before Deadline</option><option value='5' <? if ($RemindLeader == 5) echo 'selected';?> >Day Before Deadline</option><option value='6' <? if ($RemindLeader == 6) echo 'selected';?> >On Deadline</option></select></td>
  </tr>
    <tr>
    <td valign="top" class="contentbox">PROJECT DEADLINE <br /><SELECT NAME='txtMonth' class='inputstyle' >
          <?
          for ( $i=1; $i<13; $i++ ) {
            echo "<OPTION VALUE='".$i."'";
			if ($CurrentMonth ==$i) {
				echo "selected";
			}
			echo ">".date("F", mktime(1,1,1,$i,1,1) )."</OPTION>";
          }
          ?>
        </SELECT>&nbsp;<select name='txtDay' class='inputstyle' >
      <?
            for ($i=1; $i<32; $i++) {
              echo "<OPTION VALUE='".$i."'";
			  if ($CurrentDay == $i) {
				echo "selected";
				}
			 echo ">".$i."</OPTION>";
            }
          ?>
    </select>&nbsp;<select name='txtYear' class='inputstyle' >
      <?
            for ($i=date("Y")+1; $i>=(date("Y")-20); $i--) {
			echo "<OPTION VALUE='".$i."'";
              if ($CurrentYear == $i) {
				echo "selected";
				}
			 	echo ">".$i."</OPTION>";
            }
          ?>
    </select><div class="spacer"></div>
PROJECT LEADER<br />
<? echo $userString; ?></td>
	<td valign="top" class="contentbox">PROJECT GROUPS<br />
<? echo $groupString; ?><div class='spacer'></div></td>
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

</form>