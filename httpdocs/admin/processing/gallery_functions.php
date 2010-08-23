<?

if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'LIST CONTENT')) {
header("Location:admin.php?a=gallery&sub=item");
}
//GALLERY CATEGORIES
if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$query = "DELETE from pf_gallery_categories where id='$CatID'";
	$db->query($query);
}


if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'SAVE')  && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$Title = $_POST['txtTitle'];
	$query = "UPDATE pf_gallery_categories set title = '$Title' where id='$CatID'";
	$db->query($query);
}



if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'CREATE') && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$query = "INSERT into pf_gallery_categories (Title) values ('$Title')";
	$db->query($query);
}

//GALLERY CREATION 

if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'CREATE')) {
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

if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'SAVE GALLERY')) {
	$db = new DB();
	$Title = mysql_real_escape_string($_POST['txtTitle']);
	$Description = mysql_real_escape_string($_POST['txtDescription']);
	$ThumbSize = $_POST['txtThumbSize'];
	$ThumbnailPlacement = $_POST['txtThumbnailPlacement'];
	$GalleryType = $_POST['txtType'];
	$Template = $_POST['txtTemplate'];
	$Width = $_POST['txtWidth'];
	$Height = $_POST['txtHeight'];
	$NumberOfRows = $_POST['txtRows'];
	$Column = $_POST['txtColumn'];
	$TopControl = $_POST['txtTopControl'];
	$BottomControl = $_POST['txtBottomControl'];
	$Comments = $_POST['txtComments'];
	$Categories = $_POST['txtCategory'];
	$ThumbBrowserDirection = $_POST['txtThumbBrowserDirection'];
	
	if ($Width < 550) {
		$Width = 550;
	}

	if ($Height < 300) {
		$Height = 300;
	}
		if ($Template == 'java') {
			if ($Column == 1) {
				$ThumbSize = 100;
			} else if ($Column == 2) {
				$ThumbSize = 50;
			}
		}
	
	$query = "UPDATE pf_gallery_galleries set title = '$Title' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set Description = '$Description' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set Thumbsize = '$ThumbSize' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set ThumbnailPlacement = '$ThumbnailPlacement' where id='$GalleryID'";
	$query = "UPDATE pf_gallery_galleries set type = '$GalleryType' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set template = '$Template' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set width = '$Width' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set height = '$Height' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set comments = '$Comments' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set categories = '$Categories' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set TopControl = '$TopControl' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set BottomControl = '$BottomControl' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set NumberOfRows = '$NumberOfRows' where id='$GalleryID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_galleries set ThumbBrowserDirection = '$ThumbBrowserDirection' where id='$GalleryID'";
	$db->query($query);
	
	
}

if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] != 'item')) {
	$db = new DB();
	$query = "DELETE from pf_gallery_galleries where id='$GalleryID'";
	$db->query($query);
}

//GALLERY ITEMS
if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'SAVE')  && ($_POST['sub'] == 'item')) {
	$db = new DB();
	$Category = $_POST['txtCategory'];
	$query = "UPDATE pf_gallery_content set category = '$Category' where id='$ItemID'";
	$db->query($query);
	if (isset($_POST['txtGalleryInsert'])) {
		$GalleryInsert = explode(",",$_POST['txtGalleryInsert']);
		$GallerySize = sizeof($GalleryInsert);
		while ($i < $GallerySize) {
			$GalleryID = $GalleryInsert[$i];
			$i++;
			$query = "SELECT * from pf_gallery_content where id='$ItemID'";
			
			$db->query($query);
			while ($line = $db->fetchNextObject()) { 
				$Title = $line->Title;
				$Description = $line->Description;
				$Filename = $line->Filename;
				$GalleryType = $line->Type;
				$ThumbSm = $line->ThumbSm;
				$ThumbLg = $line->ThumbLg;
				$Thumb50 = $line->Thumb50;
				$Thumb100 = $line->Thumb10;
				$Thumb200 = $line->Thumb20;
				$Thumb400 = $line->Thumb40;
				$ThumbCustom = $line->ThumbCustom;
				$Category = $line->Category;
				$GalleryImage = $line->GalleryImage;
			}
	$query = "INSERT into pf_gallery_content (GalleryID, Title, Description, Filename, Type, ThumbSm, ThumbLg, Thumb50, Thumb100, Thumb200, Thumb400, ThumbCustom, Category, GalleryImage) values ('$GalleryID', '$Title', '$Description', '$Filename', '$GalleryType', '$Thumbsm', '$Thumblg', '$Thumb50', '$Thumb100', '$Thumb200', '$Thumb400', '$ThumbCustom','$Category','$GalleryImage')";
$db->query($query);

			
		}
	}
}

if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] == 'item')) {
	$db = new DB();
	$query = "DELETE from pf_gallery_content where id='$ItemID'";
	$db->query($query);
	$query = "SELECT items from pf_gallery_galleries where id='$GalleryID'";
	$Items = $db->queryUniqueValue($query);
	if ($Items > 0 ) {
		$Items--;
	}
	$query = "UPDATE pf_gallery_galleries set items='$Items' where id='$GalleryID'";
	$db->query($query);
	
	
}


if (($_GET['a'] == 'gallery') && ($_POST['btnsubmit'] == 'SAVE ITEM')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Description = mysql_escape_string($_POST['txtDescription']);
	$Category = $_POST['txtCategory'];
	$IsGalleryThumb = $_POST['txtGalleryThumb'];
	$InModule = $_POST['txtInModule'];
	$ModuleAddedDate = time();
	$query = "UPDATE pf_gallery_content set title = '$Title' where id='$ItemID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_content set Description = '$Description' where id='$ItemID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_content set Category = '$Category' where id='$ItemID'";
	$db->query($query);
	$query = "UPDATE pf_gallery_content set InModule = '$InModule' where id='$ItemID'";
	$db->query($query);
	
	if ($IsGalleryThumb == 1) {
		$query = "UPDATE pf_gallery_galleries set gallerythumb='$ItemID' where id='$GalleryID'";
		$db->query($query);
	}
	if ($InModule == 1) {
		$query = "UPDATE pf_gallery_content set ModuleAddedDate = '$ModuleAddedDate' where id='$ItemID'";
		$db->query($query);
	}
	
	if (isset($_POST['txtGalleryInsert'])) {
		$GalleryInsert = explode(",",$_POST['txtGalleryInsert']);
		$GallerySize = sizeof($GalleryInsert);
		//print "GALLERY SIZE = " . $GallerySize;
		$i=0;
		while ($i < $GallerySize) {
			$GalleryID = $GalleryInsert[$i];
		//	print "GALLERY INSERT = " . $_POST['txtGalleryInsert'];
			$i++;
			$query = "SELECT * from pf_gallery_content where id='$ItemID'";
			$db->query($query);
			//print $query;
			while ($line = $db->fetchNextObject()) { 
				$Title = $line->Title;
				$Description = $line->Description;
				$Filename = $line->Filename;
				$GalleryType = $line->Type;
				$ThumbSm = $line->ThumbSm;
				$ThumbLg = $line->ThumbLg;
				$Thumb50 = $line->Thumb50;
				$Thumb100 = $line->Thumb100;
				$Thumb200 = $line->Thumb200;
				$Thumb400 = $line->Thumb400;
				$Thumb400 = $line->Thumb600;
				$ThumbCustom = $line->ThumbCustom;
				$Category = $line->Category;
				$GalleryImage = $line->GalleryImage;
			}
			if ($Thumb50 == "") {
				$Thumb50 = 'none';
			}
			if ($Thumb100 == "") {
				$Thumb100 = 'none';
			}
			if ($Thumb200 == "") {
				$Thumb200 = 'none';
			}
			if ($Thumb400 == "") {
				$Thumb400 = 'none';
			}
			if ($Thumb600 == "") {
				$Thumb600 = 'none';
			}
			if ($ThumbCustom == "") {
				$ThumbCustom = 'none';
			}
			$query = "SELECT items from pf_gallery_galleries where id='$GalleryID'";
		$Items = $db->queryUniqueValue($query);
		$Items++;
	$query = "UPDATE pf_gallery_galleries set items='$Items' where id='$GalleryID'";
	$db->query($query);
	$query = "INSERT into pf_gallery_content (GalleryID, Title, Description, Filename, Type, ThumbSm, ThumbLg, Thumb50, Thumb100, Thumb200, Thumb400, Thumb600, ThumbCustom, Category, GalleryImage) values ('$GalleryID', '$Title', '$Description', '$Filename', '$GalleryType', '$ThumbSm', '$ThumbLg', '$Thumb50', '$Thumb100', '$Thumb200', '$Thumb400', '$Thumb600', '$ThumbCustom','$Category','$GalleryImage')";
$db->query($query);

			
		}
	}
}
 ?>