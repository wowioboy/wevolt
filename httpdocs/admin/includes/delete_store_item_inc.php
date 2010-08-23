<? 
 if (isset($_GET['id'])) {
	 $ItemID = $_GET['id'];
 } 
$db = new DB();
$query = "SELECT * from pf_store_items where id='$ItemID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
	$Description = $line->Description;
	$ThumbLg = $line->ThumbLg;
}

?>
<form method='post' action='admin.php?a=store'>

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
      DELETE ITEM</div>
<input type='submit' name='btnsubmit' value='YES' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='NO' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top"><div class='warning'>Are you Sure you want to Delete this item?</div><br /><div class='spacer'></div><img src='<? echo $ThumbLg;?>' border=1 /><div class='spacer'></div>
<div class='listcellmed'><b>TITLE:</b>&nbsp;<? echo $Title ?></div><div class='spacer'></div><div class='listcellmed'><b>DESCRIPTION:</b>&nbsp;<? echo $Description; ?></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type='hidden' name='txtItem' value='<? echo $ItemID; ?>' />
<input type='hidden' name='sub' value='item' />
</form>