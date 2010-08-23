<? 
include 'includes/image_resizer.php';
include 'includes/init.php';
$db = new DB();
$CropYes = $_POST['txtCropImage'];
$Filename = $_POST['txtFilename'];
$GalleryType = $_POST['txtType'];
$ItemID = $_POST['txtItem'];
$Title = $_POST['txtTitle'];
$Description = $_POST['txtDescription'];
$GalleryID = $_POST['txtGallery'];
$Width50 = $_POST['txtWidth50'];
$Width100 = $_POST['txtWidth100'];
$Width200 = $_POST['txtWidth200'];
$Width400 = $_POST['txtWidth400'];
$Width600 = $_POST['txtWidth600'];

if (($_POST['txtWidthCustom'] != "") && ($_POST['txtWidthCustom'] > 20) && ($_POST['txtWidthCustom']< 700)) {
	$CustomWidth = $_POST['txtWidthCustom'];
	
	if(!is_dir("gallery/images/thumbs/".$CustomWidth)) 
		mkdir("gallery/images/thumbs/".$CustomWidth, 0755); 
}

$Source_dir = 'temp/';
list($width,$height)=getimagesize($Source_dir.$Filename);

$originalimage = $Source_dir.$Filename;
$ext = substr(strrchr($Filename, "."), 1);

// make the random file name
$randName = md5(rand() * time());

$FilePath = $Source_dir . $randName . '.' . $ext;
$Filename = $randName . '.' . $ext;
$GalleryImageContent = 'gallery/images/'. $randName . '.' . $ext;
$ResizedImage = $FilePath;

//IF THE IMAGE IS LARGER THAN SET RESIZE WIDTH - Turn this ON/OFF in Gallery Settings
if ($ForceResizeImage == 1) {
	if ($width > $ResizeWidthSetting) {
		$convertString = "convert $originalimage -resize 1024 $ResizedImage";
		exec($convertString);
		chmod($ResizedImage, 0777);
		list($width,$height)=getimagesize($ResizedImage);
		copy($ResizedImage, $GalleryImageContent );
	} else {
		copy($originalimage, $GalleryImageContent );
		chmod($GalleryImageContent,0777);
	} 
} else {
	copy($originalimage, $GalleryImageContent );
	chmod($GalleryImageContent,0777);
}

//RESIZING
$image = new imageResizer($GalleryImageContent);
//PF SYSTEM THUMBS
	$Thumbsm = "gallery/images/thumbs/".$randName . '_sm.' . $ext;
	$image->resize(50, 50, 50, 50);
	$image->save($Thumbsm, JPG);
	chmod($Thumbsm,0777);
	$query = "UPDATE pf_gallery_content set thumbsm='$Thumbsm' where id='$ItemID'";
	$db->query($query);
	$Thumblg = "gallery/images/thumbs/".$randName . '_lg.' . $ext;
	$image->resize(100, 100, 100, 100);
	$image->save($Thumblg, JPG);
	chmod($Thumblg,0777);
	$query = "UPDATE pf_gallery_content set thumblg='$Thumblg' where id='$ItemID'";
	$db->query($query);
	
//USER THUMBS
if ($Width50 == 1) {
	$Thumb50 = "gallery/images/thumbs/50/".$randName . '.' . $ext;
	$image->resize(50, 150, 50, 10);
	$image->save($Thumb50, JPG);
	chmod($Thumb50,0777);

}
if ($Width100 == 1) {
	$Thumb100 = "gallery/images/thumbs/100/".$randName . '.' . $ext;
	$image->resize(100, 250, 100, 10);
	$image->save($Thumb100, JPG);
	chmod($Thumb100,0777);
	
}
if ($Width200 == 1) {
	$Thumb200 = "gallery/images/thumbs/200/".$randName . '.' . $ext;
	$image->resize(200, 350, 200, 50);
	$image->save($Thumb200, JPG);
	chmod($Thumb200,0777);
}
if ($Width400 == 1) {
	$Thumb400 = "gallery/images/thumbs/400/".$randName . '.' . $ext;
	$image->resize(400, 550, 400, 100);
	$image->save($Thumb400, JPG);
	chmod($Thumb400,0777);
}

if ($Width600 == 1) {
	$Thumb600 = "gallery/images/thumbs/600/".$randName . '.' . $ext;
	$image->resize(600, 750, 600, 100);
	$image->save($Thumb600, JPG);
	chmod($Thumb600,0777);
}
if ($CustomWidth > 10) {
	$ThumbCustom = "gallery/images/thumbs/".$CustomWidth."/".$randName . '.' . $ext;
	$image->resize($CustomWidth, 650, $CustomWidth, 100);
	$image->save($ThumbCustom, JPG);
	chmod($ThumbCustom,0777);
} else {
$ThumbCustom = 'none';

}
$image = null;

$query = "UPDATE pf_gallery_content set thumb50='$Thumb50' where id='$ItemID'";
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
header("location:admin.php?a=gallery&task=edit&sub=item&id=".$ItemID);

?>
