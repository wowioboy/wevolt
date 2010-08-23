<? 
include 'includes/image_resizer.php';
include 'includes/image_functions.php';
include 'includes/init.php';
$db = new DB();
$query = "SELECT * from pf_gallery";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$ResizeImage = $line->ResizeImage;
	$ImageSize = $line->ImageSize;
}
$Filename = $_POST['txtFilename'];
$GalleryType = $_POST['txtType'];
$GalleryID = $_POST['txtGallery'];
$Title = $_POST['txtTitle'];
$ItemID = $_POST['txtItem'];
$Description = $_POST['txtDescription'];
$Width50 = $_POST['txtWidth50'];
$Width100 = $_POST['txtWidth100'];
$Width200 = $_POST['txtWidth200'];
$Width400 = $_POST['txtWidth400'];
$Width600 = $_POST['txtWidth600'];
$Rotate = $_POST['txtRotate'];
$CropYes = $_POST['txtCropImage'];
$CropImage = $_POST['txtCropImage'];
$Source_dir = 'temp/';
$query = "SELECT Width, Height from pf_gallery_galleries where id='$GalleryID'";
$db->query($query);

while ($line = $db->fetchNextObject()) { 
	$GalleryWidth = $line->Width;
	$GalleryHeight = $line->Height;

}

if (($_POST['txtWidthCustom'] != "") && ($_POST['txtWidthCustom'] > 20) && ($_POST['txtWidthCustom']< 700)) {
	$CustomWidth = $_POST['txtWidthCustom'];
if(!is_dir("images/gallery/images/thumbs/".$CustomWidth)) mkdir("images/gallery/images/thumbs/".$CustomWidth, 0755); 

}
	print 	$destinationFile; 
	print 	$sourceFile; 
// IF IMAGE CROPPED
if($CropImage == 1) { 
	$imageWidth			 = $_POST['imageWidth'];
	$imageHeight		 = $_POST['imageHeight'];
	$imageFileName		 = $_POST['imageFileName'];
	$cropX				 = $_POST['cropX'];
	$cropY				 = $_POST['cropY'];
	$cropWidth			 = $_POST['cropWidth'];
	$cropHeight			 = $_POST['cropHeight'];
	
	// DEFINE VARIABLES
	if($cropWidth == 0) { $cropWidth = $imageWidth; }
	if($cropHeight == 0) { $cropHeight = $imageHeight; }
	$sourceFile			 = "temp/uploads/". $imageFileName;
	$destinationFile = "temp/cropped/" . $imageFileName;

	if(file_exists($destinationFile)) { chmod($destinationFile, 0777); unlink($destinationFile); }
	// CHECK TO SEE IF WE NEED TO CROP
	if($imageWidth != $cropWidth || $imageHeight != $cropHeight) {
		$convertString = "convert $sourceFile -crop " . $cropWidth . "x" . $cropHeight . "+" . $cropX . "+" . $cropY . " $destinationFile";
		exec($convertString);
		chmod($destinationFile, 0777);
		chmod($sourceFile, 0777);
		chmod($destinationFile, 0777);
	
	} else {
		// CROP WAS SKIPPED -- MOVE TO CROPPED FOLDER ANYWAY	
		copy($sourceFile,$destinationFile);
		chmod($destinationFile, 0777);
	}
    $resizeWidth		 = $GalleryWidth;
	$sourceFile			 = "temp/cropped/". $imageFileName;
	$destinationFile = "temp/finished/" . $imageFileName;
	

	if(file_exists($destinationFile)) { chmod($destinationFile, 0777); unlink($destinationFile); }	// delete if existing

	// CHECK TO SEE IF WE NEED TO CROP
	if($imageWidth != $resizeWidth) {
		$convertString = "convert $sourceFile -resize $resizeWidth $destinationFile";
		exec($convertString);
		@chmod($destinationFile, 0777);
		@chmod($sourceFile, 0777);
		@chmod($destinationFile, 0777);

	} else { // RESIZE WAS SKIPPED
		copy($sourceFile,$destinationFile);
		chmod($destinationFile, 0777);
	}

	$fileName = explode(".",$imageFileName);
	$fileName = $fileName[0];
	$originalimage = $destinationFile;

} else {
$originalimage = $Source_dir.$Filename;
}



if ($GalleryType= 'image' ) {
	list($width,$height)=getimagesize($Source_dir.$Filename);
	
	$ext = substr(strrchr($Filename, "."), 1);
// make the random file name
$randName = md5(rand() * time());
	//$randName = rand(10,99);
	//$NewFileTitle = str_replace(' ', '_', $Title);
	//$NewFileTitle = str_replace('&', 'and', $NewFileTitle);
	$NewFileTitle = $randName ;

// and now we have the unique file name for the upload file
$NewFilePath = $Source_dir . $NewFileTitle. '.' . $ext;
copy($originalimage, $NewFilePath);
$Filename = $NewFileTitle. '.' . $ext;
$OriginalGalleryImageContent = 'images/gallery/images/originals/'. $NewFileTitle. '_original.' . $ext;
$ResizedImage = $NewFilePath;

//IF THE IMAGE IS LARGER THAN SET RESIZE WIDTH - Turn this ON/OFF in Gallery Settings
if ($Rotate != 0) {
	rotateImage($NewFilePath,$NewFilePath,$Rotate); 
	chmod($NewFilePath, 0777);
}

if ($ResizeImage == 1) {
	if ($width > $ImageSize) {
		$convertString = "convert $originalimage -resize ".$ImageSize." $ResizedImage";
		exec($convertString);
		chmod($ResizedImage, 0777);
		list($width,$height)=getimagesize($ResizedImage);
		copy($ResizedImage, $OriginalGalleryImageContent );
	} else {
		copy($NewFilePath, $OriginalGalleryImageContent );
		chmod($OriginalGalleryImageContent,0777);
	} 
} else {
	copy($NewFilePath, $OriginalGalleryImageContent );
	chmod($OriginalGalleryImageContent,0777);
}
$image = new imageResizer($OriginalGalleryImageContent);

//PF SYSTEM THUMBS
	$Thumbsm = "images/gallery/images/thumbs/".$NewFileTitle. '_sm.' . $ext;
	$image->resize(50, 50, 50, 50);
	$image->save($Thumbsm, JPG);
	chmod($Thumbsm,0777);
	$Thumbmd = "images/gallery/images/thumbs/".$NewFileTitle . '_md.' . $ext;
	$image->resize(70, 70, 70, 70);
	$image->save($Thumbmd, JPG);
	chmod($Thumbmd,0777);
	$Thumblg = "images/gallery/images/thumbs/".$NewFileTitle. '_lg.' . $ext;
	$image->resize(100, 100, 100, 100);
	$image->save($Thumblg, JPG);
	chmod($Thumblg,0777);
		$GalleryImage = "images/gallery/images/".$NewFileTitle. $randName. '.'. $ext;
   if ($width > $GalleryWidth) {
		$convertString = "convert $ResizedImage -resize ".$GalleryWidth." $GalleryImage";
		exec($convertString);
	} else {
	copy($ResizedImage, $GalleryImage);
	}
	chmod($GalleryImage,0777); 


//USER THUMBS
if ($Width50 == 1) {
	$Thumb50 = "images/gallery/images/thumbs/50/".$Filename;
	$image->resize(50, 150, 50, 10);
	$image->save($Thumb50, JPG);
	chmod($Thumb50,0777);
}
if ($Width100 == 1) {
	$Thumb100 = "images/gallery/images/thumbs/100/".$Filename;
	$image->resize(100, 250, 100, 10);
	$image->save($Thumb100, JPG);
	chmod($Thumb100,0777);
}
if ($Width200 == 1) {
	$Thumb200 = "images/gallery/images/thumbs/200/".$Filename;
	$image->resize(200, 350, 200, 50);
	$image->save($Thumb200, JPG);
	chmod($Thumb200,0777);
}
if ($Width400 == 1) {
	$Thumb400 = "images/gallery/images/thumbs/400/".$Filename;
	$image->resize(400, 550, 400, 100);
	$image->save($Thumb400, JPG);
	chmod($Thumb400,0777);
}

if ($Width600 == 1) {
	$Thumb600 = "images/gallery/images/thumbs/600/".$Filename;
	$image->resize(600, 750, 600, 100);
	$image->save($Thumb600, JPG);
	chmod($Thumb600,0777);
}

if ($CustomWidth > 10) {
	$ThumbCustom = "images/gallery/images/thumbs/".$CustomWidth."/".$Filename;
	$image->resize($CustomWidth, 650, $CustomWidth, 100);
	$image->save($ThumbCustom, JPG);
	chmod($ThumbCustom,0777);
} else {
$ThumbCustom = 'none';

}
$image = null;
@unlink($originalimage);
@unlink($destinationFile);	
@unlink($sourceFile);	
@unlink($NewFilePath);
}

if ($_POST['txtEdit'] == 1) {
	$query = "UPDATE pf_gallery_content set ThumbSm = '$Thumbsm', ThumbMd = '$Thumbmd', ThumbLg = '$Thumblg',thumb50='$Thumb50' where id='$ItemID'";
	$db->query($query);

	$query = "UPDATE pf_gallery_content set thumb100='$Thumb100' where id='$ItemID'";
	$db->query($query);

	$query = "UPDATE pf_gallery_content set thumb200='$Thumb200' where id='$ItemID'";
	$db->query($query);

	$query = "UPDATE pf_gallery_content set thumb400='$Thumb400' where id='$ItemID'";
	$db->query($query);

	$query = "UPDATE pf_gallery_content set thumb600='$Thumb600' where id='$ItemID'";
	$db->query($query);

	$query = "UPDATE pf_gallery_content set thumbcustom='$ThumbCustom' where id='$ItemID'";
	$db->query($query);

	$query = "UPDATE pf_gallery_content set galleryimage='$GalleryImage', filename='$Filename' where id='$ItemID'";
	$db->query($query);

header("location:admin.php?a=gallery&sub=item");
} else {

$query = "INSERT into pf_gallery_content (GalleryID, Title, Description, Filename, Type, ThumbSm, ThumbMd, ThumbLg, Thumb50, Thumb100, Thumb200, Thumb400, Thumb600, ThumbCustom, GalleryImage) values ('$GalleryID','$Title', '$Description','$Filename','$GalleryType','$Thumbsm','$Thumbmd','$Thumblg','$Thumb50','$Thumb100', '$Thumb200','$Thumb400','$Thumb600','$ThumbCustom','$GalleryImage')";
$db->query($query);

$query = "SELECT items from pf_gallery_galleries where id='$GalleryID'";
$Items = $db->queryUniqueValue($query);
$Items++;
$query = "UPDATE pf_gallery_galleries set items='$Items' where id='$GalleryID'";
$db->query($query);

$query = "SELECT id from pf_gallery_content where filename='$Filename'";
$ItemID = $db->queryUniqueValue($query);
}

header("location:admin.php?a=gallery&task=editupload&id=".$ItemID);
 
?>
