<? 
include 'init.php';
$GalleryID = $_GET['id'];
$db=new DB();

$query = "SELECT id from pf_gallery_content where id='$GalleryID'";
$db->query($query);
$TotalContent = $db->numRows();
$i=0;
$IdArray = '';
while ($line = $db->fetchNextObject()) { 
	if ($i==0) {
		$IdArray = $line->ID;
	} else {
		$IdArray .= ",".$line->ID;
	}
	$i++;

}

echo "&contenttotal=".$TotalContent."&idarray=".$IdArray;
