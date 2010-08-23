<? 
$UserID = $_SESSION['id'];
$db = new DB();
$query = "SELECT * from pf_projects order by ID ASC";
$db->query($query);
$i=0;
$IDArray = '';
$NameArray = '';
while ($line = $db->fetchNextObject()) { 
		if ($i==0) {
			$IDArray = $line->ID;
			$NameArray = $line->Title;
		} else {
			$IDArray .= ",".$line->ID;
			$NameArray .= ",".$line->Title;
		}
		$i++;
}
?>
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
      UPLOAD FILE</div>
      <div class='inputspacer'></div>
</td>
    <td class='adminContent' valign="top"><div align="center">
<div align="center">
<div id="fileuploader">
You need to have Flash installed to use this uploader.
</div>
<script type="text/javascript"> 
    var so = new SWFObject('flash/upload_files.swf','upload','700','350','9');
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
        so.addVariable('idarray','<? echo $IDArray; ?>');
		so.addVariable('namearray','<? echo $NameArray; ?>');
		so.addVariable('userid','<? echo $UserID; ?>');
        so.write('fileuploader'); 
</script>
</div></td>
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