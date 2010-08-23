<?
$userString = "";
$db = new DB();
$query = "select * from pf_projects_users order by ID ASC";
$db->query($query);
$userString = "<select class='inpustspacer'  name='txtProjectLeader'>";
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
$groupString = "<select class='inpustspacer'  name='txtProjectGroups' size='3' multiple='yes'>";
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
    <td width="416" height="73" valign="top" bgcolor="#000000" class="contentbox"><div class="spacer"></div>PROJECT TITLE: <br />
<input type="text" class='inpustspacer' name="txtTitle" />	</td>
	<td valign="top" bgcolor="#000000" class="contentbox"><div class="spacer"></div>PROJECT DESCRIPTION:<br />
      <textarea class='inpustspacer'  name="txtDescription"></textarea></td>
	</tr>
    <tr>
    <td valign="top" bgcolor="#000000" class="contentbox">PROJECT DEADLINE <br /><SELECT NAME='txtMonth' class='inpustspacer' >
          <?
          for ( $i=1; $i<13; $i++ ) {
            echo "<OPTION VALUE='".$i."'";
			if ($Month ==$i) {
				echo "selected";
			}
			echo ">".date("F", mktime(1,1,1,$i,1,1) )."</OPTION>";
          }
          ?>
        </SELECT>&nbsp;<select name='txtDay' class='inpustspacer' >
      <?
            for ($i=1; $i<32; $i++) {
              echo "<OPTION VALUE='".$i."'";
			  if ($Day == $i) {
				echo "selected";
				}
			 echo ">".$i."</OPTION>";
            }
          ?>
    </select>&nbsp;<select name='txtYear' class='inpustspacer' >
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
PROJET LEADER<br />
<? echo $userString; ?></td>
	<td valign="top" bgcolor="#000000" class="contentbox">PROJET GROUPS<br />
<? echo $groupString; ?></td>
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