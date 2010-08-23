<? 
include 'init.php'
;
$GalleryID = $_GET['id'];
//$GalleryID = '12';
$db=new DB();

$query = "SELECT ID from pf_gallery_content where galleryid='$GalleryID' order by CreationDate ASC";
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
?>