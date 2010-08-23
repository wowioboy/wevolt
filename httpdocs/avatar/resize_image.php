<?php 

$styles = '<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />';

$scripts = '	<script src="lib/prototype.js" type="text/javascript"></script>
	<script src="lib/slider.js" type="text/javascript"></script>
	<script src="lib/init_resize.js" type="text/javascript"></script>';

include 'header.php';

if(isset($_POST['imageFileName'])) { 

	// DEFINE VARIABLES
	$imageWidth			 = $_POST['imageWidth'];
	$imageHeight		 = $_POST['imageHeight'];
	$imageFileName		 = $_POST['imageFileName'];
	$cropX				 = $_POST['cropX'];
	$cropY				 = $_POST['cropY'];
	$cropWidth			 = $_POST['cropWidth'];
	$cropHeight			 = $_POST['cropHeight'];
	
	if($cropWidth == 0) { $cropWidth = $imageWidth; }
	if($cropHeight == 0) { $cropHeight = $imageHeight; }

	$sourceFile			 = "working/uploads/". $imageFileName;
	$destinationFile = "working/cropped/" . $imageFileName;

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

?>
<table width="400"><tr><td>

	<div class="info">
		<h1>Step 2 - Resize</h1>
		<p>You can now scale your image to a size you prefer.	 This is the final step.</p>
	</div>

	<div id="resize_save">
		<form action="last_step.php" method="post" class="frmResize">
			<fieldset>
				<legend>Save Resize</legend>
				<input type="hidden" class="hidden" name="imageWidth" id="imageWidth" value="<?php echo $imageWidth ?>" />
				<input type="hidden" class="hidden" name="imageHeight" id="imageHeight" value="<?php echo $imageHeight ?>" />
				<input type="hidden" class="hidden" name="imageFileName" id="imageFileName" value="<?php echo $imageFileName ?>" />
				<input type="hidden" class="hidden" name="cropX" id="cropX" value="<?php echo $cropX ?>" />
				<input type="hidden" class="hidden" name="cropY" id="cropY" value="<?php echo $cropY ?>" />
				<input type="hidden" class="hidden" name="cropWidth" id="cropWidth" value="<?php echo $cropWidth ?>" />
				<input type="hidden" class="hidden" name="cropHeight" id="cropHeight" value="<?php echo $cropHeight ?>" />
				<input type="hidden" class="hidden" name="resizeWidth" id="resizeWidth" value="<?php echo $cropWidth ?>" />
				<div align="center">
				<div id='resizeTrack'>
		<div id='resizeHandle'></div>
	</div>

	<!-- The Image to Resize -->
	<div id="resizeImage">
		<?php echo "	<img src=\"" . $destinationFile . "\" id=\"theImage\" alt=\"Image to Resize\" />"; ?>
	</div></div>
				<div id="submit">
					<input type="submit" value="Save" name="save" id="save" />
				</div>			
			</fieldset>
		</form>			 
	</div> <!-- /resize_save -->

	<!-- Resize Track and Handle -->
	 <!-- resizeImage -->
</td></tr></table>
<?php } else { ?> 

	<div class="info">
		<h1>Error</h1>
		<p>There was an error.</p> 
	</div>

<?php } include 'footer.php' ?>