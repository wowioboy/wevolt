<? 
include 'includes/image_resizer.php';
include 'includes/image_functions.php';
include 'includes/init.php';
$db = new DB();
$query = "SELECT * from pf_store";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$StoreTitle = $line->Title;
	$GalleryWidth = $line->MaxWidth;
	$GalleryHeight = $line->MaxHeight;
	$ResizeImage = $line->ResizeImage;
	$ImageSize = $line->ResizeSize;

}

$Filename = $_POST['txtFilename'];
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
$Change = $_POST['txtChange'];
$Source_dir = 'temp/';

if (($_POST['txtWidthCustom'] != "") && ($_POST['txtWidthCustom'] > 20) && ($_POST['txtWidthCustom']< 700)) {
	$CustomWidth = $_POST['txtWidthCustom'];
if(!is_dir("images/store/images/thumbs/".$CustomWidth)) mkdir("images/store/images/thumbs/".$CustomWidth, 0755); 

}

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
	list($width,$height)=getimagesize($Source_dir.$Filename);
	
	$ext = substr(strrchr($Filename, "."), 1);
// make the random file name
$randName = md5(rand() * time());
	//$randName = rand(10,99);
	//$NewFileTitle = str_replace(' ', '_', $Title);
	//$NewFileTitle = str_replace('&', 'and', $NewFileTitle);
	//$NewFileTitle = str_replace(',', '', $NewFileTitle);
$NewFileTitle = $randName;
// and now we have the unique file name for the upload file
$NewFilePath = $Source_dir . $NewFileTitle. '.' . $ext;
copy($originalimage, $NewFilePath);
$Filename = $NewFileTitle. '.' . $ext;
$OriginalGalleryImageContent = 'images/store/images/originals/'. $NewFileTitle. '_original.' . $ext;
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
	$Thumbsm = "images/store/thumbs/".$NewFileTitle . '_sm.' . $ext;
	$image->resize(50, 50, 50, 50);
	$image->save($Thumbsm, JPG);
	chmod($Thumbsm,0777);
	$Thumbmd = "images/store/thumbs/".$NewFileTitle. '_md.' . $ext;
	$image->resize(70, 70, 70, 70);
	$image->save($Thumbmd, JPG);
	chmod($Thumbsm,0777);
	$Thumblg = "images/store/thumbs/".$NewFileTitle. '_lg.' . $ext;
	$image->resize(100, 100, 100, 100);
	$image->save($Thumblg, JPG);
	chmod($Thumblg,0777);
	
	$GalleryImage = "images/store/images/".$NewFileTitle. '.'. $ext;
	copy($OriginalGalleryImageContent,$GalleryImage);
	chmod($GalleryImage,0777);
	//if ($width > $height) {
		//$image->resize(460, 100,460,600);
	//} else if($width == $height) {
		//$image->resize(460, 460,460,460);
	//} else  {
		//$image->resize(460, 300,460,1000);
	//}
	//$image->save($GalleryImage, JPG);
	//chmod($GalleryImage,0777);


//USER THUMBS
if ($Width50 == 1) {
	$Thumb50 = "images/store/thumbs/50/".$Filename;
	$image->resize(50, 150, 50, 10);
	$image->save($Thumb50, JPG);
	chmod($Thumb50,0777);
}
if ($Width100 == 1) {
	$Thumb100 = "images/store/thumbs/100/".$Filename;
	$image->resize(100, 250, 100, 10);
	$image->save($Thumb100, JPG);
	chmod($Thumb100,0777);
}
if ($Width200 == 1) {
	$Thumb200 = "images/store/thumbs/200/".$Filename;
	$image->resize(200, 350, 200, 50);
	$image->save($Thumb200, JPG);
	chmod($Thumb200,0777);
}
if ($Width400 == 1) {
	$Thumb400 = "images/store/thumbs/400/".$Filename;
	$image->resize(400, 550, 400, 100);
	$image->save($Thumb400, JPG);
	chmod($Thumb400,0777);
}

if ($Width600 == 1) {
	$Thumb600 = "images/store/thumbs/600/".$Filename;
	$image->resize(600, 750, 600, 100);
	$image->save($Thumb600, JPG);
	chmod($Thumb600,0777);
}

if ($CustomWidth > 10) {
	$ThumbCustom = "images/store/thumbs/".$CustomWidth."/".$Filename;
	$image->resize($CustomWidth, 650, $CustomWidth, 100);
	$image->save($ThumbCustom, JPG);
	chmod($ThumbCustom,0777);
} else {
$ThumbCustom = 'none';


$image = null;
@unlink($originalimage);
@unlink($destinationFile);	
@unlink($sourceFile);	
@unlink($NewFilePath);
}

if ($_POST['txtChange'] == 1) {
	$query = "UPDATE pf_store_items set thumb50='$Thumb50',thumb100='$Thumb100',thumb200='$Thumb200',thumb400='$Thumb400',thumb600='$Thumb600', Filename='$Filename', thumbcustom='$ThumbCustom',galleryimage='$GalleryImage',thumbsm='$Thumbsm',thumbmd='$Thumbmd',thumblg='$Thumblg' where id='$ItemID'";
	$db->query($query);
	header("location:admin.php?a=store&id=".$ItemID);
} else {

$query = "INSERT into pf_store_items (Title, Description, Filename, ThumbSm, ThumbMd,ThumbLg, Thumb50, Thumb100, Thumb200, Thumb400, Thumb600, ThumbCustom, GalleryImage) values ('$Title', '$Description','$Filename','$Thumbsm','$Thumbmd','$Thumblg','$Thumb50','$Thumb100', '$Thumb200','$Thumb400','$Thumb600','$ThumbCustom','$GalleryImage')";
$db->query($query);

$query = "SELECT id from pf_store_items where filename='$Filename'";
$ItemID = $db->queryUniqueValue($query);
}

header("location:admin.php?a=store&id=".$ItemID);

?>
