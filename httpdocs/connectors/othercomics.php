<?php 
include '../includes/db.class.php';
$UserID = $_GET['userid'];
$db = new DB();
$query = "SELECT * from users as c where encryptid = '$UserID'";
$UserArray = $db->queryUniqueObject($query);

$Email = $UserArray->email;

$query = "SELECT * from comics as c
          join comic_settings as cs on c.comiccrypt=cs.ComicID 
		  
		  where (c.CreatorID = '$UserID' or cs.CreatorOne='$Email'  or cs.CreatorTwo='$Email' or cs.CreatorThree='$Email') and c.installed=1 and c.Published=1";
$db->query($query);
$ComicString = '';
$count = 0;
while ($comic = $db->FetchNextObject()) {
	if ($comic->Hosted == 1) 
		$ComiUrl = $comic->url.'/';
	else 	
		$ComiUrl = $comic->url.'/';
		
	if ($count == 0) {
		$ComicString .= 'http://www.panelflow.com'.$comic->thumb.'||'.$ComiUrl;
	} else {
		$ComicString .= ',http://www.panelflow.com'.$comic->thumb.'||'.$ComiUrl;
	}
	$count++;
}
$db->close();
echo $ComicString;

?>