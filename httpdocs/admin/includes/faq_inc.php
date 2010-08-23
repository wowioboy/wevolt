<? 

$menuString = "";

$db = new DB();

$query = "select * from faq ORDER BY Position ASC";

$db->query($query);

$menuString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>QUESTION</td><td class='tableheader'>PUBLISHED</td></tr><tr><td colspan='3'>&nbsp;</td></tr>";

while ($line = $db->fetchNextObject()) { 

$menuString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtItem' value='".$line->ID."'></td><td class='listcell'>".stripslashes($line->Question)."</td><td class='listcell'>";

if ($line->Published == 1) { 
	$menuString .= "YES";
} else {
	$menuString .= "NO";
}

$menuString .= "</td></tr>";

	}

	

$menuString .= "</table>";

?>

<form method='post' action='admin.php?a=faq'>
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
    FAQ ENTRIES</div>

    <div><input type='submit' name='btnsubmit' value='NEW' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class='spacer'></div>
 POSITION 
 <div class='inputspacer'></div><input type='submit' name='btnsubmit' value='MOVE UP' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
     <input type='submit' name='btnsubmit' value='MOVE DOWN' id='submitstyle' style="text-align:left;"></div></td>

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

