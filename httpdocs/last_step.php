<?php 

 if(!isset($_SESSION)) {

    session_start();

  }

$scripts = '<script src="lib/prototype.js" type="text/javascript"></script>';



$styles = '<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />';



if(isset($_POST['imageFileName'])) { 



	$imageWidth			 = $_POST['imageWidth'];

	$imageHeight		 = $_POST['imageHeight'];

	$imageFileName		 = $_POST['imageFileName'];

	$cropX				 = $_POST['cropX'];

	$cropY				 = $_POST['cropY'];

	$cropWidth			 = $_POST['cropWidth'];

	$cropHeight			 = $_POST['cropHeight'];
	?>
    <!-- 
    Crop X = <? echo $cropX;?>
    Crop Y = <? echo $cropY;?>
    
    -->
    <?
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

    $resizeWidth		 = '100';

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

	copy($destinationFile, $avatardestination);

	$Avatar = "http://www.panelflow.com/users/".trim($_SESSION['username'])."/avatars/".$imageFileName;

	

	$ID = trim($_SESSION['userid']);

	include "includes/dbconfig.php";

	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');

    mysql_select_db ($userdb) or die ('Could not select database.');

    $query = "UPDATE $usertable SET avatar='$Avatar' WHERE encryptid='$ID'";

    $result = mysql_query($query);
	$UserEmail = $_SESSION['email'];
	
	 $query = "UPDATE panel_forum.smfmembers SET avatar='$Avatar' WHERE emailAddress='$UserEmail'";

    $result = mysql_query($query);

	
	header('Location: /profile/'.trim($_SESSION['username']).'/');



 } else {







?> 



	<div class="info">

		<h1>Error</h1>

		<p>There was an error.</p> 

	</div>



<?php 

 include 'footer.php';

} ?>