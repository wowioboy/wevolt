<?php 
include '../includes/db.class.php';
$DB = new DB();

// CHARACTERS
 $query = "SELECT * from projects where ProjectType='writing'";
$DB->query($query);

while ($Comic = $DB->FetchNextObject()) {
	$ProjectID = $Comic->comiccrypt;
	$Title = mysql_real_escape_string($Comic->title);
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	//$Thumb = 'comics/'.$Comic->HostedUrl.'/'.$Comic->Thumb;
	$DB2 = new DB();
	$query = "UPDATE projects set ProjectID='$ProjectID' where comiccrypt='$ProjectID'"; 
			$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}



$DB->close();
$DB2->close();
?>


 