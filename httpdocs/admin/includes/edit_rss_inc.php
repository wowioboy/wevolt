<? 
$rssDB = new DB();
$query = "select * from rss where id='$RSSID'";
$rssDB->query($query);
while ($line = $rssDB->fetchNextObject()) { 
	$Title = $line->Title;
	$Application = $line->Application;
	$PostLimit = $line->PostLimit;
	$Published = $line->Published;
	$Category = $line->Category;
	$Description= $line->Description;

}

$catString = ""; 

if ($Application == 'blog') { 
	$query = "select * from pf_blog_categories order by Title ASC";
} else if ($Application == 'gallery'){
	$query = "select * from pf_gallery_categories order by Title ASC";
}
	$rssDB->query($query);
	$catString = "<select name='txtCategory' class='inputstyle'><option value='0'"; 
if ($Category == 0) {
		$catString .= 'selected';
}
	
$catString .= ">Select One --</option>";
while ($line = $rssDB->fetchNextObject()) { 
	$catString .= "<OPTION VALUE='".$line->ID."'";
	if ($Category == $line->Category) {
		$catString .= "selected";
	}
	$catString .= ">".$line->Title."</OPTION>";
}
$catString .= "</select>";

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
    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>
      EDIT RSS FEED</div>
<input type='submit' name='btnsubmit' value='SAVE RSS FEED' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

    </td>
    <td class='adminContent' valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
 	
  <tr>
    <td  height="73" valign="top" class="contentbox">
<? if ($Application == 'blog') { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="274" valign="top" style="padding:5px;">	RSS TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/>
<div class='spacer'></div>
RSS DESCRIPTION
<div class="spacer"></div>
<textarea name='txtDescription' style="width:95%"><? echo $Description;?></textarea>
</td>
    <td width="341" valign="top" style="padding:5px;">CHOOSE CATEGORY FOR FEED<br />
[if none selected, will pull all]
<br />
<? echo $catString;?></td>
    <td width="169" valign="top" class="contentbox" style="padding:5px;">FEED PUBLISHED:<br />
<input type="radio" name="txtPublish" value="1"  <? if ($Published == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtPublish" value="0" <? if ($Published == 0) { echo 'checked';}?> />NO<div class='spacer'></div>
# OF POSTS:<br />
<input type="text" name="txtPostLimit" value="<?  echo $PostLimit;?>" /></td>
</tr></table>
<? } ?>	
    <td  height="73" valign="top" class="contentbox">
<? if ($Application == 'gallery') { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="274" valign="top" style="padding:5px;">	RSS TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/>
<div class='spacer'></div>
RSS DESCRIPTION
<div class="spacer"></div>
<textarea name='txtDescription' style="width:95%"><? echo $Description;?></textarea>
</td>
    <td width="341" valign="top" style="padding:5px;">CHOOSE CATEGORY FOR FEED<br />
[if none selected, will pull all]
<br />
<? echo $catString;?></td>
    <td width="169" valign="top" class="contentbox" style="padding:5px;">FEED PUBLISHED:<br />
<input type="radio" name="txtPublish" value="1"  <? if ($Published == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtPublish" value="0" <? if ($Published == 0) { echo 'checked';}?> />NO<div class='spacer'></div>
# OF IMAGES:<br />
<input type="text" name="txtPostLimit" value="<?  echo $PostLimit;?>" /></td>
</tr></table>
<? } ?>	
</td>
	
	
  </tr>
    <tr>
    <td valign="top" class="contentbox"></td>
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
<input type="hidden" name="txtRSS" value="<? echo $RSSID; ?>" />
<input type="hidden" name="txtApp" value="<? echo $Application; ?>" />
</form>