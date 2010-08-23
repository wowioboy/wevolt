<? 

$menuString = "";
$db = new DB();
$query = "select * from menu where published=1 ORDER BY ID ASC";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
$menuString .= "<a href='".$line->Url."' class='menulink'";
if ($line->Window == 'blank') {
$menuString .= "target='".$line->Window."'";
}
$menuString .=">".$line->Title."</a><span class='menubullet'>>></span>&nbsp;&nbsp;";
	}
echo $menuString;
?>