<? 
// SELECT SETTINGS FROM MODULE TABLE
$db = new DB();
$query = "select * from pf_store_modules where id=1";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->SiteTitle;
	$NumberOfStoreRows = $line->NumberOfRows;
	$NumberOfStoreCols = $line->NumberOfCols;
	$ThumbSize = $line->Thumbsize;
	$TotalThumbs = $NumberOfStoreRows * $NumberOfStoreCols;

}


$query = "SELECT * from pf_store_items where InModule=1 order by Title Limit $TotalThumbs";
$db->query($query);
$TotalItems = $db->numRows();
$featuredItemString = "";	
$FeaturedCols = 0;
$featuredItemString = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
while ($line = $db->fetchNextObject()) { 
	if ($FeaturedCols == $NumberOfStoreCols) {
			$featuredItemString .= "</tr><tr>";
			$FeaturedCols=0;
		}
		$featuredItemString .= "<td><a href='store.php?item=".$line->ID."' border='1' ><img src='".$line->ThumbSm."' border='0'></td>";
	$FeaturedCols++;
}

$featuredItemString .=  "</tr></table>";
echo $featuredItemString;
?>