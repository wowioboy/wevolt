<?php 

require 'cropfunctions.php';


	$uploadedFile = $_FILES['image']['tmp_name'];
	$croptype = $_POST['croptype'];

$styles = '	 <link type="text/css" rel="stylesheet" href="css/debug.css" media="screen, projection" />
	<link type="text/css" rel="stylesheet" href="css/cropper.css" media="screen, projection" />
	<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />
	<!--[if IE 6]><link type="text/css" rel="stylesheet" href="css/cropper_ie6.css" media="screen, projection" /><![endif]-->
	<!--[if lte IE 5]><link type="text/css" rel="stylesheet" href="css/cropper_ie5.css" media="screen, projection" /><![endif]-->';

$scripts = '	<script src="lib/prototype.js" type="text/javascript"></script> 
	<script src="lib/scriptaculous.js?load=builder,dragdrop" type="text/javascript"></script>
	<script src="lib/cropper.js" type="text/javascript"></script><script src="lib/init_cropper/min_ratio.js" type="text/javascript"></script>';



include 'avatarheader.php';

	// SETUP DIRECTORY STRUCTURE WITH GOOD PERMS
	if(!is_dir("working")) { mkdir("working", 0777); chmod("working", 0777); }
	if(!is_dir("working/uploads")) { mkdir("working/uploads"); chmod("working/uploads", 0777); }
	if(!is_dir("working/cropped")) { mkdir("working/cropped"); chmod("working/cropped", 0777); }
	if(!is_dir("working/finished")) { mkdir("working/finished"); chmod("working/finished", 0777); }

	// DEFINE VARIABLES
	$maxWidth = 640;
	$maxHeight = 480;
	$minWidth = 100;
	$minHeight = 100;
	$imageFileName = basename($_FILES['image']['name']);
	$imageFileName = str_replace(" ","",$imageFileName);
	$imageFileName = str_replace("'","",$imageFileName);
	$target_path = "working/uploads/";
	$target_path = $target_path . $imageFileName;
	$imageLocation = $target_path;
	$sourceFile			 = "working/uploads/". $imageFileName;
	$destinationFile = "working/cropped/" . $imageFileName;


	// DELETE FILE IF EXISTING
	if(file_exists($imageLocation)) { chmod($imageLocation, 0777); unlink($imageLocation); }

	// CHECK FOR IMAGE UPLOAD
	if(move_uploaded_file($uploadedFile, $imageLocation)) {
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
   <table width="400">
     <tr><td>
       <div class="info">
         <h1>Crop Your Image</h1>
		  <p>You may click and drag an area within the image to crop, click SAVE when finished.</p>
	  </div> <!-- /info -->
       
       <div id="cropContainer" align="center">
         <div id="crop">
           <div id="cropWrap">
             <img src="<?php echo $imageLocation ?>" alt="Image to crop" id="cropImage" />            </div> <!-- /cropWrap -->
          </div> <!-- /crop -->
         <div id="crop_save">
           <form action="last_step.php" method="post" class="frmCrop">
             <fieldset>
               <legend>Continue</legend>
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
			    </fieldset>
			  </form>
		  </div> <!-- /crop_save -->
        </div> <!-- /cropContainer -->
       
      </td></tr>
     </table>
   <?php  } else { 

	if($_FILES['image'] ['error']) {
		switch ($_FILES['image'] ['error']) {
			case 1:
				$error = 'The file is bigger than this PHP installation allows.';
				break;
			case 2:
				$error = 'The file is bigger than 50k.';
				break;
			case 3:
				$error = 'Only part of the file was uploaded.';
				break;
			case 4:
				$error = 'No file was uploaded.';
				break;
		}
	} 
	 
	 include 'avatarheader.php';

?> 
   
 </div>
 <div class="info">
		<h1>Error</h1>
        <? echo  'FILE = ' . $uploadedFile;?>
		<p>There was an error uploading the file.	 <?php echo $error; ?></p>

</div>

<?php } 

include 'footer.php' ?>