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
</div>