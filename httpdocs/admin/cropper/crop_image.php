<?php 
if(!isset($_SESSION)) {
    session_start();
  } 
include_once '../includes/db.class.php';
function getWidth($image) {
	$cmd = "identify '" . $image . "' 2>/dev/null";
	$results = exec($cmd);
	$results = trim($results);
	$results = explode(" ", $results);
	foreach ($results as $i=> $result) {
		if (preg_match("/^[0-9]*x[0-9]*$/", $result)) {
			$results = explode("x", $result);
			break;
		}
	}
	return $results[0];
}

function getHeight($image) {
	$cmd = "identify '" . $image . "' 2>/dev/null";
	$results = exec($cmd);
	$results = trim($results);
	$results = explode(" ", $results);
	foreach ($results as $i=> $result) {
		if (preg_match("/^[0-9]*x[0-9]*$/", $result)) {
			$results = explode("x", $result);
			break;
		}
	}
	return $results[1];
}

include '../includes/image_resizer.php';
include '../includes/image_functions.php';
require("../includes/class.imageconverter.php");

$db = new DB();
$query = "SELECT Width, Height from pf_gallery_galleries where id='$GalleryID'";

$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$GalleryWidth = $line->Width;
	$GalleryHeight = $line->Height;

}
$Filename = $_POST['txtFilename'];
$GalleryType = $_POST['txtType'];
$GalleryID = $_POST['txtGallery'];
$Title = $_POST['txtTitle'];
$ItemID = $_POST['txtItem'];
$Description = $_POST['txtDescription'];
$GalleryID = $_POST['txtGallery'];
$Width50 = $_POST['txtWidth50'];
$Width100 = $_POST['txtWidth100'];
$Width200 = $_POST['txtWidth200'];
$Width400 = $_POST['txtWidth400'];
$Width600 = $_POST['txtWidth600'];
$Rotate = $_POST['txtRotate'];
$CropYes = $_POST['txtCropImage'];

$img = new ImageConverter("../temp/".$Filename,"jpg");

if ($Rotate != 0) {
	rotateImage("../temp/".$Filename,"../temp/".$Filename,$Rotate); 
	chmod($Filename, 0777);
}

	$uploadedFile = $Filename;
	$croptype = $_POST['croptype'];

$styles = '	 <link type="text/css" rel="stylesheet" href="css/debug.css" media="screen, projection" />
	<link type="text/css" rel="stylesheet" href="css/cropper.css" media="screen, projection" />
	<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />
	<!--[if IE 6]><link type="text/css" rel="stylesheet" href="css/cropper_ie6.css" media="screen, projection" /><![endif]-->
	<!--[if lte IE 5]><link type="text/css" rel="stylesheet" href="css/cropper_ie5.css" media="screen, projection" /><![endif]-->';

$scripts = '	<script src="lib/prototype.js" type="text/javascript"></script> 
	<script src="lib/scriptaculous.js?load=builder,dragdrop" type="text/javascript"></script>
	<script src="lib/cropper.js" type="text/javascript"></script><script src="lib/init_cropper/galleryimage.js" type="text/javascript"></script>';

include 'header.php';

	// SETUP DIRECTORY STRUCTURE WITH GOOD PERMS
	if(!is_dir("../temp")) { mkdir("../temp", 0777); chmod("../temp", 0777); }
	if(!is_dir("../temp/uploads")) { mkdir("../temp/uploads"); chmod("../temp/uploads", 0777); }
	if(!is_dir("../temp/cropped")) { mkdir("../temp/cropped"); chmod("../temp/cropped", 0777); }
	if(!is_dir("../temp/finished")) { mkdir("../temp/finished"); chmod("../temp/finished", 0777); }

	// DEFINE VARIABLES
	$maxWidth = 1280;
	$maxHeight = 1024;
	$minWidth = 550;
	$minHeight = 300;
	$imageFileName = basename($Filename);
	$imageFileName = str_replace(" ","_",$imageFileName);
	$imageFileName = str_replace("'","",$imageFileName);
	
	$target_path = "../temp/uploads/";
	$target_path = $target_path . $imageFileName;
	$imageLocation = $target_path;
	
	// DELETE FILE IF EXISTING
	if(file_exists($imageLocation)) { chmod($imageLocation, 0777); unlink($imageLocation); }

copy("../temp/".$uploadedFile, $imageLocation);
chmod($imageLocation, 0777);

	// CHECK FOR IMAGE UPLOAD
	if(move_uploaded_file("../temp/".$uploadedFile, $imageLocation)) 
		chmod($imageLocation, 0777);

		$dimensions['height'] = getHeight($imageLocation);
		$dimensions['width'] = getWidth($imageLocation);
			
		// RESIZE IF UPLOAD IS TOO BIG
		if(($dimensions['width']>$maxWidth) || ($dimensions['width']>$maxWidth)){
			$cmd = "convert " . $imageLocation . " -resize " . $maxWidth . "x" . $maxHeight . " " . $imageLocation;
			$results = exec($cmd);
			$dimensions['height'] = getHeight($imageLocation);
			$dimensions['width'] = getWidth($imageLocation);
		}
		
		// RESIZE IF UPLOAD IS TOO SMALL
		if(($dimensions['width']<$minWidth) || ($dimensions['width']<$minWidth)){
			$cmd = "convert " . $imageLocation . " -resize " . $minWidth . "x" . $minHeight . " " . $imageLocation;
			$results = exec($cmd);
			$dimensions['height'] = getHeight($imageLocation);
			$dimensions['width'] = getWidth($imageLocation);
		}
	

?>
<div align="center">
 <table width="400"><tr><td>
	<div >
		<h1>Select the area to crop</h1>
		<p>You may click and drag an area within the image to crop.	 </p>
	</div> <!-- /info -->

	<div id="cropContainer" align="center">
			<div id="crop">
			<div id="cropWrap">
				<img src="<?php echo $imageLocation ?>" alt="Image to crop" id="cropImage" />
			</div> <!-- /cropWrap -->
		</div> <!-- /crop -->
		<div id="crop_save">
			<form action="../gallery_upload.php" method="post" class="frmCrop">
			
					<input type="hidden" class="hidden" name="imageWidth" id="imageWidth" value="<?php echo $dimensions['width'] ?>" />
					<input type="hidden" class="hidden" name="imageHeight" id="imageHeight" value="<?php echo $dimensions['height'] ?>" />
					<input type="hidden" class="hidden" name="imageFileName" id="imageFileName" value="<?php echo $imageFileName ?>" />
					<input type="hidden" class="hidden" name="cropX" id="cropX" value="0" />
					<input type="hidden" class="hidden" name="cropY" id="cropY" value="0" />
					<input type="hidden" class="hidden" name="cropWidth" id="cropWidth" value="<?php echo $dimensions['width'] ?>" />
					<input type="hidden" class="hidden" name="cropHeight" id="cropHeight" value="<?php echo $dimensions['height'] ?>" />
					<div id="submit">
						<input type="submit" value="Save" name="save" id="save" />
					</div>

<input type="hidden" class="hidden" name="txtFilename" id="txtFilename" value="<? echo $Filename; ?>" />
<input type="hidden" class="hidden" name="txtType" id="txtType" value="<? echo $GalleryType; ?>" />
<input type="hidden" class="hidden" name="txtGallery" id="txtGallery" value="<? echo $GalleryID; ?>" />
<input type="hidden" class="hidden" name="txtTitle" id="txtTitle" value="<? echo $Title; ?>" />
<input type="hidden" class="hidden" name="txtItem" id="txtItem" value="<? echo $ItemID; ?>" />
<input type="hidden" class="hidden" name="txtDescription" id="txtDescription" value="<? echo $Description; ?>" />
<input type="hidden" class="hidden" name="txtWidth50" id="txtWidth50" value="<? echo $Width50; ?>" />
<input type="hidden" class="hidden" name="txtWidth100" id="txtWidth100" value="<? echo $Width100; ?>" />
<input type="hidden" class="hidden" name="txtWidth200" id="txtWidth200" value="<? echo $Width200; ?>" />
<input type="hidden" class="hidden" name="txtWidth400" id="txtWidth400" value="<? echo $Width400; ?>" />
<input type="hidden" class="hidden" name="txtWidth600" id="txtWidth600" value="<? echo $Width600; ?>" />
<input type="hidden" class="hidden" name="txtCropImage" id="txtCropImage" value="1" />


			</form>
		</div> <!-- /crop_save -->
	</div> <!-- /cropContainer -->
	</td></tr></table>
	</div>

<?php 

include 'footer.php' ?>