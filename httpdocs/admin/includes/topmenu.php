<? 

$menuString = "";
$db = new DB();
$query = "select * from menu where published=1 ORDER BY Position ASC";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
$menuString .= "<a href='".$line->Url."' class='menulink'";
if ($line->Window == 'blank') {
$menuString .= "target='".$line->Window."'";
}
if ($line->Image == '') {
$menuString .=">".$line->Title."</a>&nbsp;<span class='menubullet'>>>&nbsp;&nbsp;&nbsp;&nbsp;</span>";
} else {
$menuString .= "><img src='".$line->Image."' border='0' /></a>";
}
	}
echo $menuString;
?>