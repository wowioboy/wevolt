<?


//COMICS 
if (($_GET['a'] == 'comics') && ($_POST['btnsubmit'] == 'CREATE')) {
	$db = new DB();
	$ThumbSize = $_POST['txtThumbSize'];
	$ThumbnailPlacement = $_POST['txtThumbnailPlacement'];
	$TopControl = $_POST['txtTopControl'];
	$BottomControl = $_POST['txtBottomControl'];
	$Title = mysql_escape_string($_POST['txtTitle']);
	$GalleryType = $_POST['txtType'];
	$Template = $_POST['txtTemplate'];
    $GalleryDisplay = $_POST['txtGalleryDisplay'];
	$Width = $_POST['txtWidth'];
	$NumberOfRows = $_POST['txtRows'];
	$Column = $_POST['txtColumn'];
	$Description = $_POST['txtDescription'];
	
	if ($Width < 550) {
		$Width = 550;
	}
	$Height = $_POST['txtHeight'];
	if ($Height < 300) {
		$Height = 300;
	}
	$Comments = $_POST['txtComments'];
	$Categories = $_POST['txtCategory'];
	$ThumbBrowserDirection = $_POST['txtThumbBrowserDirection'];
	if ($Template == 'flash') {
	$query = "INSERT into pf_gallery_galleries (Title, Description, Type, Template, Categories, Width, Height, Comments, ThumbnailPlacement, ThumbBrowserDirection, ThumbSize, TopControl, BottomControl) values ('$Title','$Description','$GalleryType','$Template','$Categories','$Width','$Height','$Comments','$ThumbnailPlacement','$ThumbBrowserDirection','$ThumbSize','$TopControl','$BottomControl')";
	$db->query($query);	
	}
	
	if ($Template == 'java') {
	
		if ($Column == 1) {
			$ThumbSize = 100;
		} else if ($Column == 2) {
			$ThumbSize = 50;
		}
	$query = "INSERT into pf_gallery_galleries (Title, Description, Type, Template, Categories, Width, Height, Comments, ThumbSize, TopControl, BottomControl, NumberOfRows) values ('$Title','$Description','$GalleryType','$Template','$Categories','$Width','$Height','$Comments','$ThumbSize','$TopControl','$BottomControl', '$NumberOfRows')";
	$db->query($query);
		
	
	}
}

if (($_GET['a'] == 'comics') && ($_POST['btnsubmit'] == 'SAVE')) {
	$db = new DB();
	$Title = mysql_real_escape_string($_POST['txtTitle']);
	$Synopsis = mysql_real_escape_string($_POST['txtSynopsis']);
	$Short = mysql_real_escape_string($_POST['txtShort']);
	$Tags = mysql_real_escape_string($_POST['txtTags']);
	$Genre = $_POST['txtGenre'];
	$Genres = $_POST['txtGenres'];
	if (is_array($Genres))
	{
  	$TempGenres = '';
 	 foreach ($Genres as $value) {
   	  if ($TempGenres != '')
   	   $TempGenres .= ',';
   	 $TempGenres .= $value;
 	 }
 	 $GenreString = $TempGenres;
	}
	$Featured = $_POST['txtFeatured'];
	$query = "SELECT Featured from comics where comiccrypt='$ItemID'";
	$CurrentFeatured = $db->queryUniqueValue($query);
	//print $query;
	if (($Featured == 1) && ($CurrentFeatured == 0)) {
	
		$query = "INSERT into features (ComicID) values ('$ItemID')"; 
		$db->query($query);
	//	print $query;
		$query = "SELECT distinct ComicID from features order by DateFeatured DESC limit 5"; 
		$db->query($query);
		//print $query;
		$FeaturedXML = '<featured>';
		while ($line = $db->fetchNextObject()) { 
			$comicDB2 = new DB();
			$ComicID = $line->ComicID;
			$query = "SELECT * from comics where comiccrypt='$ComicID'"; 
			$ComicArray = $db->queryUniqueObject($query);
		//	print $query;
			if ($ComicArray->Hosted == 1) {
					$fileUrl = 'http://www.needcomics.com/'.$ComicArray->thumb;
					$comicURL = $ComicArray->url.'/';
				} else if (($ComicArray->Hosted == 2) && (substr($ComicArray->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.panelflow.com'.$ComicArray->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $ComicArray->url;
				} else {
					$fileUrl = $ComicArray->thumb;
					$comicURL =$ComicArray->url;
				}
				
			$FeaturedXML .='<comic>';
			$FeaturedXML .="<title>".$ComicArray->title.'</title>';
			$FeaturedXML .="<image>".$fileUrl.'</image>';
			$FeaturedXML .="<description>".$ComicArray->short.'</description>';
			$FeaturedXML .="<link>".$comicURL.'</link>';
			$FeaturedXML .='</comic>';
		} 
		$FeaturedXML .= '</featured>';
		//print 'XML = ' . $FeaturedXML;
		$fp = fopen("../xml/featured.xml",'w');
		$write = fwrite($fp,$FeaturedXML);
		chmod("../xml/featured.xml",0777);
	} 
	$query = "UPDATE comics set title = '$Title',synopsis = '$Synopsis', short='$Short', Featured='$Featured', tags='$Tags' where comiccrypt='$ItemID'";
	$db->query($query);
	//print $query;
	$db->close();
		
}

if (($_GET['a'] == 'comics') && ($_POST['btnsubmit'] == 'YES')) {
	$db = new DB();
	$query = "DELETE from comics where comiccrypt='$ItemID'";
	$db->query($query);
}

 ?>