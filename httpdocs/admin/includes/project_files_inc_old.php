<? 
$fileString = "";
$db = new DB();
$query = "select * from pf_projects_files order by ProjectID ASC";
$db->query($query);
$fileString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader' width='150'>FILE TITLE</td><td class='tableheader' width='50'>TYPE</td><td class='tableheader' width='140'>PROJECT</td><td class='tableheader'>UPLOADED BY</td><td class='tableheader'>UPLOADED DATE</td><td class='tableheader'>LINK</td></tr><tr><td colspan='7'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
if ($line->ReadOnly == 1) {
$fileString .= "<tr><td width='3%' align='left' class='listcell2'><input type='radio' name='txtFile' value='".$line->ID."'></td><td class='listcell2'>".$line->Title."</td><td class='listcell2'>".$line->Type."</td><td class='listcell2'>";
} else {
$fileString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtFile' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>".$line->Type."</td><td class='listcell'>";
}
$ProjectID = $line->ProjectID;
$Project = new DB();
$ext = $line->Type;
$query = "select Title from pf_projects where ID='$ProjectID'";
$ProjectName = $Project->queryUniqueValue($query);
$UserID = $line->UserID;
$query = "select Username from pf_projects_users where UserId='$UserID'";
$UserName = $Project->queryUniqueValue($query);
if ($line->ReadOnly == 1) {
$fileString .=$ProjectName."</td><td class='listcell2'>".$UserName."</td><td class='listcell2'>".substr($line->CreatedDate,0,10)."</td><td class='listcell2'><a href='projects/media/".$line->Filename."' target='_blank'>[DOWNLOAD]</a>";
} else {
$fileString .=$ProjectName."</td><td class='listcell'>".$UserName."</td><td class='listcell'>".substr($line->CreatedDate,0,10)."</td><td class='listcell'><a href='projects/media/".$line->Filename."' target='_blank'>[DOWNLOAD]</a>";
}
if (($ext == 'jpg') || ($ext == 'JPEG') ||($ext == 'JPG') ||($ext == 'jpg') ||($ext == 'GIF') ||($ext == 'gif') ||($ext == 'png') ||($ext == 'PNG') ||($ext == 'bmp')) {
$fileString .="<div style='padding:3px; padding-left:12px;'>preview<div style=height:3px;'></div><a href='".$line->GalleryImage."' rel='lightbox'><img src='".$line->ThumbSm."'  border='1'></a></div>";
} 

$fileString .="</td></tr>";
	}

$fileString .= "</table>";
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
      PROJECT FILES</div>
<input type='submit' name='btnsubmit' value='UPLOAD FILE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT FILE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE FILE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

    </td>
    <td class='adminContent' valign="top">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" class="contentbox"><? echo $fileString ?></td>
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