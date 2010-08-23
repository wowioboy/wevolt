<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$ComicID = $_POST['c'];
$StoryID = $_POST['c'];
$License = $_POST['l'];
$ConnectKey = $_POST['k'];
$UserID = $_POST['u'];
$ContentType = $_POST['t'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');

$query = "SELECT * from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
 $result = mysql_query($query);
 $Connected = mysql_num_rows($result);
 $user = mysql_fetch_array($result);
  // print $query."<br/><br/>";
 if ($Connected == 1) {
 	$query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
 	$result = mysql_query($query);
	 // print $query."<br/><br/>";
	 
	 if ($ContentType == 'story')
	 $query = "SELECT * from stories where StoryID ='$StoryID' and (userid='$UserID' or CreatorID='$UserID')";
	 else
	$query = "SELECT * from comics where comiccrypt ='$ComicID' and (userid='$UserID' or CreatorID='$UserID')";
 	$result = mysql_query($query);
	$Authorized = mysql_num_rows($result);
	$comic = mysql_fetch_array($result);
	//print 'MY AUTHORIZED = ' . $Authorized ;
	$AppInstallation = $comic['AppInstallation'];
	 // print $query."<br/><br/>";
	  if ($ContentType == 'story')
	$query = "SELECT * from story_settings where StoryID ='$ComicID'";
	else
	$query = "SELECT * from comic_settings where ComicID ='$ComicID'";
 	$result = mysql_query($query);
 	$comicsettings = mysql_fetch_array($result);
	//  print $query."<br/><br/>";
	if ($Authorized == 0) {
		$UserEmail = $user['email'];
		if (($UserEmail == $comicsettings['Assistant1']) || ($UserEmail == $comicsettings['Assistant2']) || ($UserEmail == $comicsettings['Assistant3'])) {
			$Authorized = 1;
			 if ($ContentType == 'story')
			 $query = "SELECT * from story_settings where StoryID ='$ComicID'";
			else
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
 		 $Authorized = mysql_num_rows($result);
		  //print $query."<br/><br/>";
	}
 	
	if ($Authorized == 0) {
		echo 'Not Authorized';
	} else {
	 if ($ContentType == 'story')
		$query = "SELECT * from pf_modules where StoryID='$StoryID' and Placement ='left' and Homepage=0 order by Position";
	else
		$query = "SELECT * from pf_modules where ComicID='$ComicID' and Placement ='left' and Homepage=0 order by Position";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
				if ($LeftColumnOrder == '') {
					$LeftColumnOrder = $row['ModuleCode'];
					$LeftColumnOrderPub = $row['IsPublished'];
					$LeftColumnOrderCustom1 = $row['CustomVar1'];
					$LeftColumnOrderHtml = $row['HTMLCode'];
				}else {
					$LeftColumnOrder .= ','.$row['ModuleCode'];
					$LeftColumnOrderPub .= ','.$row['IsPublished'];
					$LeftColumnOrderCustom1 .= ','.$row['CustomVar1'];
					$LeftColumnOrderHtml .= '||||'.$row['HTMLCode'];
				}
		}
		 if ($ContentType == 'story')
		$query = "SELECT * from pf_modules where StoryID='$StoryID' and Placement ='right' and Homepage=0 order by Position";
	else
		$query = "SELECT * from pf_modules where ComicID='$ComicID' and Placement ='right' and Homepage=0 order by Position";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result)) {
			if ($RightColumnOrder == ''){
				$RightColumnOrder =  $row['ModuleCode'];
				$RightColumnOrderPub = $row['IsPublished'];
				$RightColumnOrderCustom1 = $row['CustomVar1'];
				$RightColumnOrderHtml .= $row['HTMLCode'];
			}else {
				$RightColumnOrder .= ','.$row['ModuleCode'];
				$RightColumnOrderPub .= ','.$row['IsPublished'];
				$RightColumnOrderCustom1 .= ','.$row['CustomVar1'];
				$RightColumnOrderHtml .= '||||'.$row['HTMLCode'];
			}
				
		}
	$myValues = array (
	 'rightcolumnorder' => trim($RightColumnOrder),
	 'rightcolumnorderpub' => trim($RightColumnOrderPub),
	  'rightcolumnordercustom1' => trim($RightColumnOrderCustom1),
	 'leftcolumnorderpub' => trim($LeftColumnOrderPub),
	 'leftcolumnordercustom1' => trim($LeftColumnOrderCustom1),
	 'rightcolumnorderhtml' => trim($RightColumnOrderHtml),
	 'leftcolumnorderhtml' => trim($LeftColumnOrderHtml),
	'leftcolumnorder' => trim($LeftColumnOrder));
	echo serialize ($myValues);
	}
	
 } else {
 	echo 'Connection Failed!';
 }

?>


