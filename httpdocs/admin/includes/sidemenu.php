<? 

$menuString = "";
$db = new DB();
$query = "select * from menu where published=1 ORDER BY Position ASC";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
if ($line->SubMenu == 1) {
$menuString .= "<a href='".$line->Url."' class='submenulink'";
} else {
$menuString .= "<a href='".$line->Url."' class='menulink'";
}

if ($line->Window == 'blank') {
$menuString .= "target='".$line->Window."'";
}
$menuString .=">";

if ($line->Image == '') {
$menuString .=$line->Title."</a><span class='menubullet'>>></span><br/>";
} else {
$menuString .= "<img src='".$line->Image."' border='0' /></a><br/>";
}
	}
echo $menuString;
?>