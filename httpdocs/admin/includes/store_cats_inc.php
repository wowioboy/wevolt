<? 
$menuString = "";
$db = new DB();
$query = "select * from pf_store_categories ORDER BY ID ASC";
$db->query($query);
$menuString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>CATEGORY TITLE</td><td class='tableheader'>THUMB</td></tr><tr><td colspan='3'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
$menuString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtCat' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td>";
$ItemID = $line->CategoryThumb;
$db2 = new DB();
$query = "select ThumbSm from pf_store_items where id='$ItemID'";

$CatThumb = $db2->queryUniqueValue($query);
if ($CatThumb == '') {
$CatThumb ='images/temp_cat_thumb_sm.gif';
}
$menuString .= "<td class='listcell'><img src='".$CatThumb."' border='1'></td></tr>";
	}
	 
$menuString .= "</table>";
?>
<form method='post' action='admin.php?a=store&sub=cat'>
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
      CATEGORIES</div>
    <div><input type='submit' name='btnsubmit' value='NEW' id='submitstyle' style="text-align:left;" ><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"></div></td>
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
<input type="hidden" name='sub' value='cat'/>
</form>
