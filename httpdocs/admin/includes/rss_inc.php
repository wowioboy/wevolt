<? 
$menuString = "";
$db = new DB();
$query = "select * from rss order by Title ASC";
$db->query($query);
$menuString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>RSS TITLE</td><td class='tableheader'>APPLICATION</td><td class='tableheader'>PUBLISHED</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
$menuString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtRss' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>".$line->Application."</td><td class='listcell'>".$line->Published."</td></tr>";
	}
$menuString .= "</table>";
?>
<form method='post' action='admin.php?a=rss'>
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
    RSS FEEDS</div>
    <div><input type='submit' name='btnsubmit' value='EDIT RSS FEED' id='submitstyle' style="text-align:left;"></div><div class='spacer'></div></td>
    <td class='adminContent' valign="top"><? echo $menuString ?></td>
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
