<? 
$blogString = "";
$db = new DB();
$query = "select * from pf_blog_posts ORDER BY publishdate DESC";
$db->query($query);
$blogString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'>ID</td><td class='tableheader'>POST TITLE</td><td class='tableheader'>CATEGORY</td><td class='tableheader'>PUBLISH DATE</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
$blogString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtPost' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>".$line->Category."</td><td class='listcell'>".$line->PublishDate."</td></tr>";
	}
	
$blogString .= "</table>";
?>
<form method='post' action='admin.php?a=blog'>
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
    BLOG</div>
    <div>BLOG POSTS<br /><input type='submit' name='btnsubmit' value='NEW' id='submitstyle' style="text-align:left;">
<div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class='spacer'></div>
BLOG CATEGORIES<br />
<input type='submit' name='btnsubmit' value='NEW CATEGORY' id='submitstyle' style="text-align:left;">
<div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT CATEGORIES' id='submitstyle' style="text-align:left;"><div class='spacer'></div>
BLOG ROLL<br />
<input type='submit' name='btnsubmit' value='NEW LINK' id='submitstyle' style="text-align:left;">
<div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT LINKS' id='submitstyle' style="text-align:left;"></div></td>
    <td class='adminContent' valign="top"><? echo $blogString ?></td>
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
