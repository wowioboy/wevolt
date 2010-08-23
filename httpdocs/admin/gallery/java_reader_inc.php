<?
include 'includes/ps_pagination.php';

include 'includes/db_config.php';

$conn = mysql_connect($server,$user,$pass);
mysql_select_db($base,$conn);
$sql = "SELECT * from pf_gallery_content where galleryid='$GalleryID' order by CreationDate ASC";

$pager = new PS_Pagination($conn,$sql,6,$NumberOfRows*6);
//The paginate() function returns a mysql result set 
$rs = $pager->paginate();
$Count = 1;
$imageString = "";	
$imageString = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
while($line = mysql_fetch_assoc($rs)) {
	$imageString .= "<td><a href='".$line['GalleryImage']."' rel='lightbox' border='1' ><img src='".$line['ThumbLg']."'></td>";
	if ($Count == 6) {
		$imageString .= "</tr><tr>";
		$Count = 1;
	} else {
	$Count++;
	}
	
}
  
$imageString .=  "</tr></table>";

?>
<? 
if ($TopControl == 1) {
echo "<div class='pagination'>".$pager->renderFullNav($GalleryID)."</div>";
}

echo $imageString;

if ($BottomControl == 1) {
echo "<div class='pagination'>".$pager->renderFullNav($GalleryID)."</div>";
}
?>