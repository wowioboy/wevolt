<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$ComicID = $_POST['c'];
$ItemID = $_POST['p'];
$License = $_POST['l'];
$ConnectKey = $_POST['k'];
$UserID = $_POST['u'];
$Section = $_POST['s'];
$PageType = $_POST['t'];
$Today = date('Ymd');
$Type = $_POST['t'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "SELECT * from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
$result = mysql_query($query);
//print 'EXPORT PRODUCTS CONNECT QUERY : ' . $query.'<br/><br/><br/>';
$Connected = mysql_num_rows($result);
$user = mysql_fetch_array($result);
if ($Connected == 1) {
 	$query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
 	$result = mysql_query($query);
	//print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 	$query = "SELECT * from comics where comiccrypt ='$ComicID' and (userid='$UserID' or CreatorID='$UserID')";
	 $result = mysql_query($query);
// print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
	 $Authorized = mysql_num_rows($result);
	 $comic = mysql_fetch_array($result);
	 $ComicFolder = $comic['HostedUrl'];
	 $AppInstallation = $comic['AppInstallation'];
	 if ($Authorized == 0) {
		$query = "SELECT * from comic_settings where ComicID ='$ComicID'";
 		$result = mysql_query($query);
	//print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 		$comicsettings = mysql_fetch_array($result);
		$UserEmail = $user['email'];
		if (($UserEmail == $comicsettings['Assistant1']) || ($UserEmail == $comicsettings['Assistant2']) || ($UserEmail == $comicsettings['Assistant3'])) {
			$Authorized = 1;
		$query = "SELECT * from comics where comiccrypt ='$ComicID'";
 		 $result = mysql_query($query);
// print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 		$comic = mysql_fetch_array($result);
    	$ComicFolder = $comic['HostedUrl'];
    	$AppInstallation = $comic['AppInstallation'];
		}
 	}
 	
	if ($Authorized == 1) {
	 	$query = "SELECT * from Applications where ID='$AppInstallation' and LicenseID='$License'";
 	 	$result = mysql_query($query);
	// print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 	 	$Authorized = mysql_num_rows($result);
 	}
 	
 	if ($Authorized == 0) {
		echo 'Not Authorized';
 	} else {
  		$query = "SELECT * from pf_store_items as pi
				  join pf_store_images as si on si.ItemID=pi.EncryptID
				  where pi.EncryptID ='$ItemID' and si.IsMain=1";
 		$result = mysql_query($query);
	//	print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 		$page = mysql_fetch_array($result);
		$myValues = array (
		'title' => trim($page['ShortTitle']),
		'price' => trim($page['Price']),
		'description' => trim($page['Description']),
		'image' => trim($page['GalleryImage']),
		'thumbsm' => trim($page['ThumbSm']),
		'thumbmd' => trim($page['ThumbMd']),
		'thumblg' => trim($page['ThumbLg']),
		'tags' => trim($page['Tags']),
		'producttype' => trim($page['ProductType']),
		'CreateDate' =>  trim($page['CreateDate']),
		'position' => trim($page['Position']));
		echo serialize ($myValues);
	}
} else {
 echo 'Connection Failed!';
}


?>


