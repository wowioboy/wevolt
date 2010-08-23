<? 
// SELECT SETTINGS FROM MODULE TABLE
$db = new DB();
$query = "select * from pf_gallery_modules where id=1";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->SiteTitle;
	$NumberOfRows = $line->NumberOfRows;
	$NumberOfCols = $line->NumberOfCols;
	$ThumbSize = $line->Thumbsize;
	$ImageLinkType = $line->ImageLinkType;
	$ThumbSm = $line->ThumbSm;
	$ThumbLg = $line->ThumbLg;
	$TotalThumbs = $NumberOfRows * $NumberOfCols;

}


$query = "SELECT * from pf_gallery_content where InModule=1 order by ModuleAddedDate Limit $TotalThumbs";
$db->query($query);

$TotalItems = $db->numRows();
$Count = 1;
$imageString = "";	
$Cols = 0;
$imageString = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
while ($line = $db->fetchNextObject()) { 
	if ($Cols == $NumberOfCols) {
			$imageString .= "</tr><tr>";
			$Cols=0;
		}
	if ($ImageLinkType == 'java') {
		$imageString .= "<td align='center'><a href='".$line->GalleryImage."' rel='lightbox' border='1' ><img src='".$line->ThumbSm."' border='1' class='g_module_thumb'><div style='height:5px;'></div></td>";
	} else if ($ImageLinkType == 'flash') {
	$imageString .= "<td><a href='index.php?a=gallery&id=".$line->GalleryID."&item=".$line->ID."' border='1' ><img src='".$line->ThumbSm."' border='1' class='g_module_thumb'><div style='height:5px;'></div></td>";
	}
	$Cols++;
}

$imageString .=  "</tr></table>";
echo $imageString;
?>