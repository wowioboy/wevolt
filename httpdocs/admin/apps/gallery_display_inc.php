<?
if ($Application == 'gallery') {
	$PageTitle = 'Galleries';
		$GalleryID = $_GET['id'];
		$ItemID =  $_GET['item'];
		$db = new DB();
		if (isset($_GET['id'])) {
		$query = "SELECT * from pf_gallery_galleries where id='$GalleryID'";
				$db->query($query);
				while ($line = $db->fetchNextObject()) { 
						$GalleryTitle = $line->Title;
						$PageTitle = $GalleryTitle;
						$GalleryDescription = $line->Description;
						$GalleryThumb = $line->GalleryThumb;
						$Items = 		$line->Items;
						$Description = 	$line->Description;
						$Template = 	$line->Template;
						$ThumbSize = 	$line->ThumbSize;
						$NumberOfRows = $line->NumberOfRows;
						$ThumbnailPlacement = $line->ThumbnailPlacement;
						$TopControl = $line->TopControl;
						$BottomControl = $line->BottomControl;
				}
			}
	    	if ((isset($_GET['id'])) && (isset($_GET['item']))) {
			// SHOW READER
			$query = "SELECT * from pf_gallery_content where galleryid='$GalleryID' order by CreationDate ASC";

				$db->query($query);
				$TotalContent = $db->numRows();
				$i=0;
				$IdArray = '';
				$ImageArray = '';
				while ($line = $db->fetchNextObject()) { 
					if ($i==0) {
						$IdArray = $line->ID;
						$ImageArray = $line->ThumbLg;
					} else {
						$IdArray .= ",".$line->ID;
						$ImageArray .= ",".$line->ThumbLg;
					}
					if ($ItemID == $line->ID ) {
						$CurrentIndex = $i;
						list($Width,$Height)=getimagesize($line->GalleryImage);
						$PageImage = $line->GalleryImage;
						$PageTitle .= ' - '. $line->Title;
						$ContentTitle = $line->Title;
						$Description = $line->Description;
					}
					$i++;

				}
			} 
			
			if ((isset($_GET['id'])) && (!isset($_GET['item']))) {
			// SHOW READER
			$query = "SELECT * from pf_gallery_content where galleryid='$GalleryID' order by CreationDate ASC";
				$db->query($query);
				$TotalContent = $db->numRows();
				$i=0;
				$IdArray = '';
				$ImageArray = '';
				while ($line = $db->fetchNextObject()) { 
					if ($i==0) {
						$IdArray = $line->ID;
						$ImageArray = $line->ThumbLg;
					} else {
						$IdArray .= ",".$line->ID;
						$ImageArray .= ",".$line->ThumbLg;
					}
					$CurrentIndex = $i;
					list($Width,$Height)=getimagesize($line->GalleryImage);
					$PageImage = $line->GalleryImage;
					$Description = $line->Description;
					$ContentTitle = $line->Title;
					$i++;

				}
			} 
			
			if (($_GET['id']=="") && (isset($_GET['item']))) {
			$query = "SELECT GalleryID from pf_gallery_content where id='$ItemID'";
			$GalleryID = $db->queryUniqueValue($query);
				$query = "SELECT * from pf_gallery_content where galleryid='$GalleryID' order by CreationDate ASC";
				$db->query($query);
				$TotalContent = $db->numRows();
				$i=0;
				$IdArray = '';
				$ImageArray = '';
				while ($line = $db->fetchNextObject()) { 
					if ($i==0) {
						$IdArray = $line->ID;
						$ImageArray = $line->ThumbLg;
					} else {
						$IdArray .= ",".$line->ID;
						$ImageArray .= ",".$line->ThumbLg;
					}
					if ($ItemID == $line->ID ) {
						$CurrentIndex = $i;
						list($Width,$Height)=getimagesize($line->GalleryImage);
						$PageImage = $line->GalleryImage;
						$PageTitle .= ' - '. $line->Title;
						$ContentTitle = $line->Title;
						$Description = $line->Description;
					}
					$i++;

				}
			}
			$query = "SELECT * from pf_gallery_galleries where id='$GalleryID'";
				$db->query($query);
				while ($line = $db->fetchNextObject()) { 
						$GalleryTitle = $line->Title;
						$GalleryThumb = $line->GalleryThumb;
						$Items = 		$line->Items;
						$Description = 	$line->Description;
						$Template = 	$line->Template;
						$ThumbSize = 	$line->ThumbSize;
						$NumberOfRows = $line->NumberOfRows;
						$ThumbnailPlacement = $line->ThumbnailPlacement;
						$ThumbBrowserDirection = $line->ThumbBrowserDirection;
						$TopControl = $line->TopControl;
						$BottomControl = $line->BottomControl;
				}
}?>