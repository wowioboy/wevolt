<?
$gallString = "";
$galleryDB = new DB();
$query = "select * from pf_gallery_galleries where items>0";
$galleryDB->query($query);
$Count = 0;
$gallString = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
while ($line = $galleryDB->fetchNextObject()) { 
	if ($Count == 3) {
			$gallString .= "</tr><tr>";
			$Count = 0;
		}
		$gallString .= "<td width='100' valign='top'><a href='index.php?a=gallery&id=".$line->ID."'>";
		$gallerythumb = new DB();
		$GalleryID = $line->ID;
		$ContentID = $line->GalleryThumb;
		if ($ContentID == 0) {
			$query = "select ThumbLg from pf_gallery_content where galleryid='$GalleryID'";
		} else {
			$query = "select ThumbLg from pf_gallery_content where id='$ContentID'";
		}
		$ThumbLg = $gallerythumb->queryUniqueValue($query);
		$gallString .= "<img src='".$ThumbLg."' class='gallerythumb'></a></td><td width='214' valign='top' style='padding:5px;'><div class='gallerytitle'>".$line->Title."</div><div class='gallerydescription'>".$line->Description."</div><div class='galleryitems'>Numer of Items: ".$line->Items."</div></td>";
$Count++;
}

$gallString .= "</tr></table>";
echo $gallString;
?>


