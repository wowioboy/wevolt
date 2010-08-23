<? 
// SELECT SETTINGS FROM MODULE TABLE
$db = new DB();

$query = "SELECT * from pf_store_items order by CreationDate Limit 12";
$db->query($query);

$TotalRecentItems = $db->numRows();
$Count = 1;
$StoreRecentString = "";	
$Cols = 0;
$StoreRecentString = "<div class='moduletitle'>Recent Items</div><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
while ($line = $db->fetchNextObject()) { 
	if ($Cols == 3) {
			$StoreRecentString .= "</tr><tr>";
			$Cols=0;
		}
	
	$StoreRecentString .= "<td><a href='store.php?item=".$line->ID."' border='1' ><img src='".$line->ThumbMd."' border='1' class='g_module_thumb'><div style='height:5px;'></div></td>";
	$Cols++;
}

$StoreRecentString .=  "</tr></table>";
echo $StoreRecentString;
?>