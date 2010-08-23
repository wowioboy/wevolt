<?php 

$scripts = '	<script src="lib/prototype.js" type="text/javascript"></script>
	<script src="lib/show_rotated.js" type="text/javascript"></script>';

$styles = '<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />';

include 'header.php';

if(isset($_POST['imageFileName'])) { 

	// DEFINE VARIABLES
	$imageWidth			 = $_POST['imageWidth'];
	$imageFileName	 = $_POST['imageFileName'];
	$resizeWidth		 = '100';
	$sourceFile			 = "working/cropped/". $imageFileName;
	$destinationFile = "working/finished/" . $imageFileName;
	$avatardestination = "../users/".$_SESSION['username']."/avatars/" . $imageFileName;

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
	copy($destinationFile, $avatardestination);
	$Avatar = "http://www.panelflow.com/users/".$_SESSION['username']."/avatars/".$imageFileName;
	$ID = $_SESSION['userid'];
	include "../includes/dbconfig.php";
	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
    mysql_select_db ($userdb) or die ('Could not select database.');
    $query = "UPDATE $usertable SET avatar='$Avatar' WHERE userid='$ID'";
    $result = mysql_query($query);

	?>

<div align="center">
	<div class="info">
		<h1>All Done</h1>
		<p>Here is your new image</p>
		<div id="completedImage">
	<?php
	echo '<img src="' . $destinationFile . '" id="theImage" alt="Final Image" border="2"/><br />';
	?>
</div>
	</div>


</div> <!-- completedImage -->

<?php } else { ?> 

	<div class="info">
		<h1>Error</h1>
		<p>There was an error.</p> 
	</div>

<?php } include 'footer.php' ?>