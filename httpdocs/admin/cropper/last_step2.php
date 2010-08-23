<?php 

$scripts = '	<script src="lib/prototype.js" type="text/javascript"></script>
	<script src="lib/show_rotated.js" type="text/javascript"></script>';

$styles = '<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />';

include 'finalheader.php';

if(isset($_POST['imageFileName'])) { 

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
    $resizeWidth		 = '200';
	$sourceFile			 = "working/cropped/". $imageFileName;
	$destinationFile = "working/finished/" . $imageFileName;
	$avatardestination = "users/".trim($_SESSION['username'])."/avatars/" . $imageFileName;

	if(file_exists($destinationFile)) { chmod($destinationFile, 0777); unlink($destinationFile); }	// delete if existing

	// CHECK TO SEE IF WE NEED TO CROP
	if($imageWidth != $resizeWidth) {
		$convertString = "convert $sourceFile -resize $resizeWidth $destinationFile";
		exec($convertString);
		chmod($destinationFile, 0777);
		chmod($sourceFile, 0777);
		chmod($destinationFile, 0777);

	} else { // RESIZE WAS SKIPPED
		copy($sourceFile,$destinationFile);
		chmod($destinationFile, 0777);
	}

	$fileName = explode(".",$imageFileName);
	$fileName = $fileName[0];
	
		include 'infoXML_temp.php';
		$file_to_write = 'infoXML.xml';
			$content ="<comic><information>";
			$content .="<comicid>".$comicid."</comicid>";
			$content .="<title>".$comictitle."</title>";
			$content .="<url>".$comicurl."</url>";
			$content .="<creator>".$creator."</creator>";
			$content .="<writer>".$writer."</writer>";
			$content .="<artist>".$artist."</artist>";
			$content .="<moviecolor>0xFFFFFF</moviecolor>";
			$content .="<barcolor>0x000000</barcolor>";
			$content .="<textcolor>0xFFFFFF</textcolor>";
			$content .="<buttoncolor>0xFDA96D</buttoncolor>";
			$content .="<arrowcolor>0x000000</arrowcolor>";
			$content .="<synopsis>".$synopsis."</synopsis>";
			$content .="</comic></information>";
			$fp = fopen($file_to_write, 'w');
			fwrite($fp, $content);
			fclose($fp);
			rename($file_to_write, '../infoXML.xml');
			//copy($default_dir, $backup1);
			chmod('../infoXML.xml', 0755);
					
			$file_to_write = 'pageXML.xml';
			$content ="<comic><page>";
			$content .="<id>0</id>";
			$content .="<title>Welcome to the Panel Flow system</title>";
			$content .="<comment>Log into the Admin interface and begin adding pages and customizing your comic. You can easily edit the index.php to change the layout of the information. Just make sure you keep the PHP include files within each section or your system will break. However if you want to not display anything, you can simply comment it out by putting two forward slahes in front of the statement. If you have any questions, check out the FAQ at www.panelflow.com</comment>";
			$content .="<image>/images/pf_temp.jpg</image>";
			$content .="<imgheight>800x537</imgheight>";
			$content .="<active>1</active>";
			$content .="<datelive>04-28-2008</datelive>";
			$content .="<thumb>/images/pf_temp.jpg</thumb>";
			$content .="</page></comic>";
			$fp = fopen($file_to_write, 'w');
			fwrite($fp, $content);
			fclose($fp);
			rename($file_to_write, '../pageXML.xml');
			//copy($default_dir, $backup1);
			chmod('../pageXML.xml', 0755);
			
						echo '<div class="errormsg"><div class="spacer"</div><h1 style="color:yello">CONGRATUALTIONS!</h1><div class="spacer"></div>INSTALLATION COMPLETE. YOU CAN NOW LOG INTO YOUR SITE AND ACCESS THE ADMIN SECTION TO START YOUR COMIC. <a href="../index.php"> CLICK HERE </a>TO START UPLOADING PAGES! <br> <br><b>WE RECOMMEND DELETING THE INSTALL DIRECTORY SO YOUR SETTINGS CANNOT BE OVERWRITTEN. </div>';
						
		   copy('images/pf_temp.jpg','../images/pf_temp.jpg');
		   copy($destinationFile,'../images/comiccover.jpg');
		   $comicthumb = '../images/comicthumb.jpg';
		   $convertString = "convert $destinationFile -resize 100 $comicthumb";
		   exec($convertString);

?>

	
<div id="completedImage" align="center">
	<?php
	echo '<img src="' . $destinationFile . '" id="theImage" alt="Final Image" border="2"/><br />';
	?>
</div> <!-- completedImage -->


<?php } else { ?> 

	<div class="info">
		<h1>Error</h1>
		<p>There was an error.</p> 
	</div>

<?php } include 'includes/footer.php' ?>