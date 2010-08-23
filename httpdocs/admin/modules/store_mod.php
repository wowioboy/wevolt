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
	$TotalThumbs = $NumberOfRows * $NumberOfCols;

}


$query = "SELECT * from pf_store_items where IsFeatured=1 order by Title Limit $TotalThumbs";
$db->query($query);
$TotalItems = $db->numRows();
$featuredItemString = "";	
$FeaturedCols = 0;
$featuredItemString = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
while ($line = $db->fetchNextObject()) { 
	if ($FeaturedCols == $NumberOfCols) {
			$featuredItemString .= "</tr><tr>";
			$FeaturedCols=0;
		}
		$featuredItemString .= "<td><a href=store.php?id='".$line->ID."' border='1' ><img src='".$line->ThumbSm."' border='0'></td>";
	$FeaturedCols++;
}

$featuredItemString .=  "</tr></table>";
echo $featuredItemString;
?>