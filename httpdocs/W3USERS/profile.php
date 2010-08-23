<?php 
include 'includes/global_settings_inc.php';


include 'includes/init.php';?>
<? 
include 'includes/dbconfig.php';
include 'includes/message_functions.php';
if ($_SESSION['userid'] == '')
	header("Location:http://users.w3volt.com/".$_GET['name']."/");

if (trim($_SESSION['username']) != $_GET['name'])
	header("Location:http://users.w3volt.com/".$_GET['name']."/");
	
$MyVolt = 1;?>
<?php 

if ($_SESSION['userid'] == 'd67d8ab427') {
//$_SESSION['username'] = 'fishcapades';
  // $_SESSION['avatar'] = 'http://www.panelflow.com/users/rbr/avatars/rbr.jpg';
	   //$_SESSION['email'] = 'laurel.shelleyreuss@gmail.com';
		/// $_SESSION['userid'] = 'a97da6296b';
		// $_SESSION['encrypted_email'] =  md5($_SESSION['email']);
}
if ($_POST['deletefav'] == 1){
deletefavorite(trim($_POST['comicid']), trim($_POST['favid']), trim($_SESSION['userid']));
} 

if ($_POST['notify'] == 1){
NotifyFavorite($_POST['favid']);
} 

if ($_POST['stopnotify'] == 1){
RemoveNotify($_POST['favid']);
} 



function addfriend($UserID, $FriendID, $userhost, $dbuser,$userpass,$userdb)
{
	$friendDB = new DB($userdb,$userhost, $dbuser, $userpass);
	$query ="SELECT * from friends where UserID='$UserID' and FriendID = '$FriendID'";
	
	$friendDB->query($query);
	$Found == $friendDB->numRows();
	if ($Found == 0) {
			$query ="SELECT * from friends where FriendID='$UserID' and FriendID = '$UserID'";
			$friendDB->query($query);
			$Found == $friendDB->numRows();
			if ($Found == 0) {
				  $query ="INSERT into friends (UserID, FriendID, Accepted) values ('$UserID', '$FriendID', 0)";
				  $friendDB->query($query);
				  
				  $query ="SELECT ID from friends where UserID='$UserID' and FriendID = '$FriendID'";
				  $FriendInvitationID = $friendDB->queryUniqueValue($query);
				  $Subject = 'Friend Request';
				  $Message = $_SESSION['username'] .' wants to add you as a friend. If you want to accept their request, please click this link <form action="/myvolt/'.trim($_SESSION['username']).'/acceptfriend.php" method="post"><input type="submit" name="buttonSubmit" value="ACCEPT REQUEST"><input type="submit" name="buttonSubmit" value="DECLINE REQUEST"><input type="hidden" name="requestid" value="'.$FriendInvitationID.'"></form>';
				  SendMessage($FriendID, $_SESSION['username'], $_SESSION['userid'], $Subject, $Message);
				  $friendDB->close();
			}
	}

}

function getWaitingOrders($UserID)
{
	global $userdb,$userhost, $dbuser, $userpass;
	$DB = new DB($userdb,$userhost, $dbuser, $userpass);
	

	$query ="SELECT oi. * , o. * , pi. *
FROM tbl_order_item AS oi
JOIN pf_store_items AS pi ON pi.EncryptID = oi.pd_id
JOIN pf_store_images pii ON pi.EncryptID = pii.ItemID
JOIN tbl_order AS o ON o.od_id = oi.od_id
WHERE pi.UserID = '$UserID'
AND od_status = 'paid' and oi.Complete=1 and pi.ShippingOption=0";
	
	$DB->query($query);
	$Found = $DB->numRows();
	$DB->close();
	return $Found;
	

}

function getNewOrders($UserID)
{
	global $userdb,$userhost, $dbuser, $userpass;
	$DB = new DB($userdb,$userhost, $dbuser, $userpass);
	

	$query ="SELECT oi. * , o. * , pi. *
FROM tbl_order_item AS oi
JOIN pf_store_items AS pi ON pi.EncryptID = oi.pd_id
JOIN pf_store_images pii ON pi.EncryptID = pii.ItemID
JOIN tbl_order AS o ON o.od_id = oi.od_id
WHERE pi.UserID = '$UserID'
AND o.od_status = 'paid' and o.IsRead=0";
	
	$DB->query($query);
	$Found = $DB->numRows();
	$DB->close();
	return $Found;
	

}

function getorders($UserID)
{
	global $userdb,$userhost, $dbuser, $userpass;
	$DB = new DB($userdb,$userhost, $dbuser, $userpass);
	

	$query ="SELECT oi. * , o. * , pi. *
FROM tbl_order_item AS oi
JOIN pf_store_items AS pi ON pi.EncryptID = oi.pd_id
JOIN pf_store_images pii ON pi.EncryptID = pii.ItemID
JOIN tbl_order AS o ON o.od_id = oi.od_id
WHERE pi.UserID = '$UserID'
AND od_status = 'paid'";
	
	$DB->query($query);
	$Found = $DB->numRows();
	$DB->close();
	return $Found;
	

}

mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$UserName = $_GET['name'];

if ($UserName == trim($_SESSION['username'])) {
	$ID = trim($_SESSION['userid']);
} else {
$query = "select encryptid,email from $usertable where username='$UserName'";
$result = mysql_query($query);
$user = mysql_fetch_array($result);
$ID = $user['encryptid'];
$CEmail =  $user['email'];
}




if ($_GET['btnsubmit'] == 'Yes') {
$UserID = $_SESSION['userid'];
$FriendID = $ID;
addfriend($UserID, $FriendID,$userhost, $dbuser,$userpass,$userdb);
	header("location:/myvolt/".$UserName."/");
} else if ($_GET['btnsubmit'] == 'No'){
	header("location:/myvolt/".$UserName."/");
}
$insertComment = $_POST['insert'];

if ($insertComment == '1'){
//print "MY FEEDBACK = " . $_POST['txtFeedback'];
//print "MY SESSION ID = " . trim($_SESSION['userid']);
CommentProfile(trim($_SESSION['username']), trim($_SESSION['userid']), $ID, $_POST['txtFeedback'], date('D M j'), $_SERVER['REMOTE_ADDR']);
} 

$deleteComment = $_POST['deletecomment'];
if ($deleteComment == '1'){
//print "MY FEEDBACK = " . $_POST['txtFeedback'];
//print "MY SESSION ID = " . trim($_SESSION['userid']);
DeleteProfileComment($_POST['commentid']);
} 

if ($_POST['deletefav'] == 1){
deletefavorite(trim($_POST['comicid']), trim($_POST['favid']), trim($_SESSION['userid']));
} 

$newMsg = "";

$query = "select * from messages where userid='$ID' and isread=0";
$Result = mysql_query ($query);
$nRows = mysql_num_rows($Result);
if ($nRows > 0) {
	$newMsg = "<div align='center' style='color:#ff0000;'>(".$nRows.") UNREAD</div>";
}

if ($_POST['editaccount'] == 1){
$Notify = $_POST['notify'];
$Comments = $_POST['profilecomments'];
$FaceID = $_POST['txtFace'];
$Twittername = mysql_real_escape_string($_POST['Twittername']);
$TwitterCount = $_POST['TwitterCount'];
$query = "UPDATE $usertable SET notify='$Notify',allowcomments='$Comments',FaceID='$FaceID', TwitterCount='$TwitterCount', Twittername='$Twittername' WHERE encryptid='$ID'";
$result = mysql_query($query);


}
if ($_POST['savestatus'] == '1'){
$UpdateDB = new DB();
$StatusText = mysql_real_escape_string($_POST['txtStatus']);
$UserID = $_SESSION['userid'];
$query ="UPDATE users set Status='$StatusText' where encryptid='$UserID'";
$UpdateDB->execute($query);
$UpdateDB->close();
} 

 $DB = new DB($userdb,$userhost, $dbuser, $userpass);
if ($_POST['edit'] == 1) {
	$UserFields = array();
    $Now = date('Y-m-d h:m:s');
	
 	//BASIC PROFILE INFO	
	$Sex = $_POST['txtSex'];
	$SexPrivacy = $_POST['txtSexPrivacy'];
	$UserFields[] = array('Name'=>'sex','Privacy'=>$SexPrivacy,'Type'=>'basic','RecordValue'=>$Sex);
		
	$Birthday = $_POST['txtBdayMonth'] .'-'. $_POST['txtBdayDay'] .'-'.$_POST['txtBdayYear'];
	$BirthdayPrivacy = $_POST['txtBirthdayPrivacy'];
	$UserFields[] = array('Name'=>'birthday_date','Privacy'=>$BirthdayPrivacy,'Type'=>'basic','RecordValue'=>$Birthday);
	
	$Hometown = mysql_real_escape_string($_POST['txtHometown']);
	$HometownPrivacy = $_POST['txtHometownLocationPrivacy'];
	$UserFields[] = array('Name'=>'hometown_location','Privacy'=>$HometownPrivacy,'Type'=>'basic','RecordValue'=>$Hometown);
	
	$Location = mysql_real_escape_string($_POST['txtLocation']);
	$LocationPrivacy = $_POST['txtLocationPrivacy'];
	$UserFields[] = array('Name'=>'current_location','Privacy'=>$LocationPrivacy,'Type'=>'basic','RecordValue'=>$Location);
	
	$ProfileBlurb = mysql_real_escape_string($_POST['txtProfileBlurb']);
	$ProfileBlurbPrivacy = $_POST['txtProfileBlurbPrivacy'];
	$UserFields[] = array('Name'=>'profile_blurb','Privacy'=>$ProfileBlurbPrivacy,'Type'=>'basic','RecordValue'=>$ProfileBlurb);
	
	$SelfTags = mysql_real_escape_string($_POST['txtSelfTags']);
	$UserFields[] = array('Name'=>'self_tags','Privacy'=>'private','Type'=>'basic','RecordValue'=>$SelfTags);
	
	//PERSONAL PROFILE INFO
	$About = mysql_real_escape_string($_POST['txtAbout']);
	$AboutPrivacy = $_POST['txtAboutPrivacy'];
	$UserFields[] = array('Name'=>'about_me','Privacy'=>$AboutPrivacy,'Type'=>'personal','RecordValue'=>$About);
	
	$Hobbies = mysql_real_escape_string($_POST['txtHobbies']);
	$HobbiesPrivacy = $_POST['txtHobbiesPrivacy'];
	$UserFields[] = array('Name'=>'activities','Privacy'=>$HobbiesPrivacy,'Type'=>'personal','RecordValue'=>$Hobbies);

	$Interests = mysql_real_escape_string($_POST['txtInterests']);
	$InterestsPrivacy = $_POST['txtInterestsPrivacy'];
	$UserFields[] = array('Name'=>'interests','Privacy'=>$InterestsPrivacy,'Type'=>'personal','RecordValue'=>$Interests);

	$Influences = mysql_real_escape_string($_POST['txtInfluences']);
	$InfluencesPrivacy = $_POST['txtInfluencesPrivacy'];
	$UserFields[] = array('Name'=>'influences','Privacy'=>$InfluencesPrivacy,'Type'=>'personal','RecordValue'=>$Influences);

	$Music = mysql_real_escape_string($_POST['txtMusic']);
	$MusicPrivacy = $_POST['txtMusicPrivacy'];
	$UserFields[] = array('Name'=>'music','Privacy'=>$MusicPrivacy,'Type'=>'personal','RecordValue'=>$Music);
	
	$Books = mysql_real_escape_string($_POST['txtBooks']);
	$BooksPrivacy = $_POST['txtBooksPrivacy'];
	$UserFields[] = array('Name'=>'books','Privacy'=>$BooksPrivacy,'Type'=>'personal','RecordValue'=>$Books);

	$Movies = mysql_real_escape_string($_POST['txtMovies']);
	$MoviesPrivacy = $_POST['txtMoviesPrivacy'];
	$UserFields[] = array('Name'=>'movies','Privacy'=>$MoviesPrivacy,'Type'=>'personal','RecordValue'=>$Movies);

	$TVShows = mysql_real_escape_string($_POST['txtTVShows']);
	$TVShowsPrivacy = $_POST['txtTVShowsPrivacy'];
	$UserFields[] = array('Name'=>'tv','Privacy'=>$TVShowsPrivacy,'Type'=>'personal','RecordValue'=>$TVShows);

	//CONTACT PROFILE INFO
	$ScreenNames = mysql_real_escape_string($_POST['txtScreenNames']);
	$ScreenNamesPrivacy = $_POST['txtScreenNamesPrivacy'];
	$UserFields[] = array('Name'=>'screennames','Privacy'=>$ScreenNamesPrivacy,'Type'=>'contact','RecordValue'=>$ScreenNames);

	$Phone = mysql_real_escape_string($_POST['txtPhone']);
	$PhonePrivacy = $_POST['txtPhonePrivacy'];
	$UserFields[] = array('Name'=>'phone','Privacy'=>$PhonePrivacy,'Type'=>'contact','RecordValue'=>$Phone);
	
	$Website = mysql_real_escape_string($_POST['txtWebsite']);
	$WebsitePrivacy = $_POST['txtWebsitePrivacy'];
	$UserFields[] = array('Name'=>'website','Privacy'=>$WebsitePrivacy,'Type'=>'contact','RecordValue'=>$Website);

	$TwitterName = mysql_real_escape_string($_POST['txtTwitterName']);
	$TwitterNamePrivacy = $_POST['txtTwitterNamePrivacy'];
	$UserFields[] = array('Name'=>'twittername','Privacy'=>$TwitterNamePrivacy,'Type'=>'contact','RecordValue'=>$TwitterName);

	$FaceUrl = mysql_real_escape_string($_POST['txtFaceUrl']);
	$FaceUrlPrivacy = $_POST['txtFaceUrlPrivacy'];
	$UserFields[] = array('Name'=>'profile_url','Privacy'=>$FaceUrlPrivacy,'Type'=>'contact','RecordValue'=>$FaceUrl);
	
	//CREDITS PROFILE INFO
	$EducationHistory = mysql_real_escape_string($_POST['txtEducation']);
	$EducationHistoryPrivacy = $_POST['txtEducationPrivacy'];
	$UserFields[] = array('Name'=>'education_history','Privacy'=>$EducationHistoryPrivacy,'Type'=>'contact','RecordValue'=>$EducationHistory);

	$WorkHistory = mysql_real_escape_string($_POST['txtWorkHistory']);
	$WorkHistoryPrivacy = $_POST['txtWorkHistoryPrivacy'];
	$UserFields[] = array('Name'=>'work_history','Privacy'=>$WorkHistoryPrivacy,'Type'=>'contact','RecordValue'=>$WorkHistory);

	$Credits = mysql_real_escape_string($_POST['txtCredits']);
	$CreditsPrivacy = $_POST['txtCreditsPrivacy'];
	$UserFields[] = array('Name'=>'credits','Privacy'=>$CreditsPrivacy,'Type'=>'contact','RecordValue'=>$CreditsPrivacy);

	$AllowComments = $_POST['commentsallow'];
	
	foreach($UserFields as $entry) {
			$query ="SELECT ID from users_profile where UserID='".$_SESSION['userid']."' and RecordID='".$entry['Name']."'";
	        $IsData = $DB->queryUniqueValue($query);
			//print $query.'<br/>';
			if ($IsData == '') {
				$query ="INSERT into users_profile (UserID,RecordID,LongComment, PrivacySetting,LastUpdated,InfoType) values ('".$_SESSION['userid']."','".$entry['Name']."','".$entry['RecordValue']."','".$entry['Privacy']."','$Now','".$entry['Type']."')"; 			
			} else {
				$query = "UPDATE users_profile set LongComment='".$entry['RecordValue']."', PrivacySetting='".$entry['Privacy']."' where RecordID='".$entry['Name']."' and UserID='".$_SESSION['userid']."'";
			}
			$DB->execute($query);
		//	print $query.'<br/><br/>';
	}	
	
	//$query = "UPDATE $usertable SET music='$Music',location='$Location',books='$Books',hobbies='$Hobbies',realname='$Realname',website='$Website',about='$About',influences='$Influences',credits='$Credits',link1='$Link1', link2='$Link2',link3='$Link3', link4='$Link4',allowcomments='$AllowComments' WHERE encryptid='$ID'";
 	//$result = mysql_query($query);
}
    
	
	 $query = "select * from $usertable where encryptid='$ID'";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     $Username = $user['username'];
	 $Avatar = $user['avatar'];
	
	
	
	 $query = "select * from users_profile where UserID='$ID' order by InfoType, ID";
     $DB->query($query);
	 $LastType = '';
	 while ($profile = $DB->FetchNextObject()){
	 	//print $profile->InfoType.'<br/>';
		 switch($profile->RecordID) {
		 		case 'profile_blurb':
					  $ProfileBlurb = stripslashes($profile->LongComment);
					  $ProfileBlurbPrivacy = $profile->PrivacySetting;
					  break;
				case 'sex':
					  $Sex = stripslashes($profile->LongComment);
					  $SexPrivacy = $profile->PrivacySetting;
					  break;
				case 'about_me':
					  $About = stripslashes($profile->LongComment);
					  $AboutPrivacy = $profile->PrivacySetting;
					  break;
				case 'hometown_location':
					  $HometownLocation = stripslashes($profile->LongComment);
					  $HometownLocationPrivacy = $profile->PrivacySetting;
					  break;
				case 'current_location':
					  $Location = stripslashes($profile->LongComment);
					  $LocationPrivacy = $profile->PrivacySetting;
					  break;
				case 'activities':
					  $Hobbies = stripslashes($profile->LongComment);
					  $HobbiesPrivacy = $profile->PrivacySetting;
					  break;
				case 'music':
					  $Music = stripslashes($profile->LongComment);
					  $MusicPrivacy = $profile->PrivacySetting;
					  break;
				case 'movies':
					  $Movies = stripslashes($profile->LongComment);
					  $MoviesPrivacy = $profile->PrivacySetting;
					  break;
				case 'books':
					  $Books = stripslashes($profile->LongComment);
					  $BooksPrivacy = $profile->PrivacySetting;
					  break;
				case 'tv':
					  $TVShows = stripslashes($profile->LongComment);
					  $TVShowsPrivacy = $profile->PrivacySetting;
					  break;
				case 'interests':
					  $Interests = stripslashes($profile->LongComment);
					  $InterestsPrivacy = $profile->PrivacySetting;
					  break;
				case 'website':
					  $Website = stripslashes($profile->LongComment);
					  $WebsitePrivacy = $profile->PrivacySetting;
					  break;
				case 'profile_url':
					  $FaceUrl = stripslashes($profile->LongComment);
					  $FaceUrlPrivacy = $profile->PrivacySetting;
					  break;
				case 'education_history':
					  $Education = stripslashes($profile->LongComment);
					  $EducationPrivacy = $profile->PrivacySetting;
					  break;
				case 'work_history':
					  $WorkHistory = stripslashes($profile->LongComment);
					  $WorkHistoryPrivacy = $profile->PrivacySetting;
					  break;
				case 'twitter_name':
					  $TwitterName = stripslashes($profile->LongComment);
					  $TwitterNamePrivacy = $profile->PrivacySetting;
					  break;
				case 'influences':
					  $Influences = stripslashes($profile->LongComment);
					  $InfluencesPrivacy = $profile->PrivacySetting;
					  break;
				case 'credits':
					  $Credits = stripslashes($profile->LongComment);
					  $CreditsPrivacy = $profile->PrivacySetting;
					  break;
				case 'phone':
					  $Phone = stripslashes($profile->LongComment);
					  $PhonePrivacy = $profile->PrivacySetting;
					  break;
				case 'self_tags':
					  $SelfTags = stripslashes($profile->LongComment);
					  break;
				case 'birthday_date':
					  $Birthday = $profile->LongComment;
					  $BirthdayPrivacy = $profile->PrivacySetting;
					  break;
				case 'screennames':
					  $ScreenNames = stripslashes($profile->LongComment);
					  $ScreenNamesPrivacy = $profile->PrivacySetting;
					  break;

		 }
	 }
	 
	  if (($Birthday == '') || (strlen($Birthday) < 5)) 
	  	  $Birthdate = explode('-',$user['birthdate']);
	 else
	 	  $Birthdate = explode('-',$Birthday);
	 $BirthdayDay =$Birthdate[1];
	 $BirthdayMonth =$Birthdate[0];
	 $BirthdayYear =$Birthdate[2];
	 
	 if ($Music == '')
	 	$Music = stripslashes($user['music']);
		
	 if ($Location == '')
 		 $Location = stripslashes($user['location']);
		 
 	 if ($Books == '')
		 $Books = stripslashes($user['books']);
		 
 	 if ($Hobbies == '')
		 $Hobbies = stripslashes($user['hobbies']);
		 
 	 if ($Website == '') 	 
	 	 $Website= $user['website'];
	 if ($About == '')
	    $About = stripslashes($user['about']);
	 if ($Influences == '')
	   $Influences = $user['influences'];
	 if ($TwitterName == '')
		 $TwitterName  = $user['Twittername']; 
	if ($Credits == '') 
	 	$Credits = stripslashes($user['credits']);
	 	   
	 $Status = $user['Status'];
	 $TwitterCount = $user['TwitterCount'];
	
	 if (substr($Website,0,3) == 'www') {
	 	$Website = 'http://'.$Website;
	 }
		
	 $IsCreator = $user['iscreator'];
	 
	 
	 $Link1 = $user['link1'];
	 if (substr($Link1,0,3) == 'www') {
	 	$Link1 = 'http://'.$Link1;
	 }
	 $Link2 = $user['link2'];
	  if (substr($Link2,0,3) == 'www') {
	 	$Link2 = 'http://'.$Link2;
	 }
	 $Link3 = $user['link3'];
	  if (substr($Link3,0,3) == 'www') {
	 	$Link3 = 'http://'.$Link3;
	 }
	 $Link4 = $user['link4'];
	  if (substr($Link4,0,3) == 'www') {
	 	$Link4 = 'http://'.$Link4;
	 }
 	 if ($Sex == '')
	 	$Sex = $user['gender'];
		
	 $AllowComments = $user['allowcomments'];
	 $HostedAccount = $user['HostedAccount'];
	 
	/* 
	 //Build Product List
	$SelectDB = new DB();
	$query = "select * from products where UserID='$ID' and Published=1 ORDER BY Title DESC";
  	$result = mysql_query($query);
  	$nRows = mysql_num_rows($result);
	$Products = $nRows;
  	$counter =0;
  	$productString = "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";
  	for ($i=0; $i< $nRows; $i++){
   		$row = mysql_fetch_array($result);
		$productString .= "<td valign='top' id='profilemodcontent'><div align='center'><div class='comictitlelist'>".stripslashes($row['Title'])."</div><a href='/products/".$row['EncryptID']."/'><img src='/".$row['ThumbSm']."' border='2' alt='LINK' style='border-color:#000000;'></a><div class='smspacer'></div><div class='moreinfo'><a href='/products/".$row['EncryptID']."/'><img src='http://www.w3volt.com/images/info.jpg' border='0'></a>";
	
		if ($ID == $_SESSION['userid']) { 
	
		$productString .= "<div class='smspacer'></div><a href='/products/edit/".$row['EncryptID']."/'><img src='http://www.w3volt.com/images/edit.jpg' border='0'></a><div class='smspacer'></div><a href='/products/delete/".$row['EncryptID']."/'><img src='http://www.w3volt.com/images/delete_btn.jpg' border='0'></a>";
		}
		if ($row['ProductType'] == 'pdf') {
			
			$query= "SELECT Pages from products_attributes_pdf where ProductID ='". $row['EncryptID']."'";
			$TotalPages = $SelectDB->queryUniqueValue($query);
			$productString .="<div class='pages'>Pages: ".$TotalPages."</div>";
		}
		$productString .="</div><div class='lgspacer'></div></td>"; 
			 $counter++;
 				if ($counter == 3){
 					$productString .= "</tr><tr>";
 					$counter = 0;
 				}
	}
	 $productString .= "</tr></table>";
	$SelectDB->close();


	 
	 
	 if ($ID != $_SESSION['userid']) {
	 	$friendDB = new DB($userdb,$userhost, $dbuser, $userpass);	
		$FriendID = $ID;
		$UserID = trim($_SESSION['userid']); 
	    $query ="SELECT * from friends where UserID='$UserID' and FriendID = '$FriendID'";
	
			$friendDB->query($query);
			$Found = $friendDB->numRows();
			
if ($Found == 0) {
  $query ="SELECT * from friends where FriendID='$UserID' and UserID = '$FriendID'";

$friendDB->query($query);
$Found = $friendDB->numRows();

if ($Found == 0) {
$Friend = 0;

} else {
$Friend = 1;
}
} else {
$Friend = 1;
}
	 }

*/
$FriendList = array();
$friendDB = new DB($userdb,$userhost, $dbuser, $userpass);
$query = "select FriendID, UserID from friends where (UserID='$ID' or FriendID='$ID') and Accepted=1 and FriendType='friend' and IsW3viewer!=1 ORDER BY ID";
	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 
$friendString = "<div class=\"workarea\" id=\"friends_container\">
  <ul id=\"friends\" class=\"draglist\">";
$counter = 0;
$FCount = 0;
$FriendArray = $friendDB->query($query);
while ($friend = $friendDB->fetchNextObject()) { 
		$userDB = new DB($userdb,$userhost, $dbuser, $userpass); 
		$FriendID = $friend->FriendID;
		if ($FriendID == $ID) 
			$FriendID = $friend->UserID;
			
		$FriendList[] = $FriendID;
			
		$query ="SELECT username, avatar from users where encryptid='$FriendID'";
		$UserArray = $userDB->queryUniqueObject($query);
		 $friendString .= "<li class=\"friends\" id=\"friends_".$FriendID."\"><table border='0' cellspacing='0' cellpadding='0' width='180'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='http://users.w3volt.com/".trim($UserArray->username)."/'><img src='/includes/round_images_inc.php?source=".$UserArray->avatar."&radius=20&colour=e9eef4' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top' class='sender_name'>".$UserArray->username."</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div></li>";
		  $DropStringInit .= 'new YAHOO.w3volt.DDList("friends_'.$FriendID.'");';
		 $FCount++;
 }

	$friendString .='  </ul></div>';

$query = "select UserID from friends where FriendID='$ID' and FriendType='fan' ORDER BY ID";
	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 
$fanString = "<div class=\"workarea\">

  <ul id=\"fans\" class=\"draglist\">";
$counter = 0;
$FCount = 0;
$FriendArray = $friendDB->query($query);
while ($friend = $friendDB->fetchNextObject()) { 
		$userDB = new DB($userdb,$userhost, $dbuser, $userpass); 
		$FriendID = $friend->UserID;
		$query ="SELECT username, avatar from users where encryptid='$FriendID'";
		$UserArray = $userDB->queryUniqueObject($query);
		 $fanString .= "<li class=\"fans\" id=\"fans_".$FriendID."\"><table border='0' cellspacing='0' cellpadding='0' width='173'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='http://users.w3volt.com/".trim($UserArray->username)."/'><img src='/includes/round_images_inc.php?source=".$UserArray->avatar."&radius=20&colour=e9eef4' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top' class='sender_name'>".$UserArray->username."</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div></li>";
		  $DropStringInit .= 'new YAHOO.w3volt.DDList("fans_'.$FriendID.'");';
		 $FCount++;
 }

	$fanString .='  </ul></div>';
	
$query = "select FriendID from friends where UserID='$ID' and FriendType='fan' ORDER BY ID";
	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 
$celebString = "<div class=\"workarea\">

  <ul id=\"celebs\" class=\"draglist\">";
$counter = 0;
$FCount = 0;
$FriendArray = $friendDB->query($query);
while ($friend = $friendDB->fetchNextObject()) { 
		$userDB = new DB($userdb,$userhost, $dbuser, $userpass); 
		$FriendID = $friend->FriendID;
		if ($FriendID == $ID) 
			$FriendID = $friend->UserID;
		$query ="SELECT username, avatar from users where encryptid='$FriendID'";
		$UserArray = $userDB->queryUniqueObject($query);
		 $celebString .= "<li class=\"celebs\" id=\"celebs_".$FriendID."\"><table border='0' cellspacing='0' cellpadding='0' width='173'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='http://users.w3volt.com/".trim($UserArray->username)."/'><img src='/includes/round_images_inc.php?source=".$UserArray->avatar."&radius=20&colour=e9eef4' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top' class='sender_name'>".$UserArray->username."</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div></li>";
		  $DropStringInit .= 'new YAHOO.w3volt.DDList("celebs_'.$FriendID.'");';
		 $FCount++;
 }

	$celebString .='  </ul></div>';

$query = "select FriendID, UserID from friends where (UserID='$ID' or FriendID='$ID') and Accepted=1 and FriendType='friend'  and IsW3viewer=1 ORDER BY ID";
	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 
$w3viewString = "<div class=\"workarea\">

  <ul id=\"w3vers\" class=\"draglist\">";
$counter = 0;
$FCount = 0;
$FriendArray = $friendDB->query($query);
while ($friend = $friendDB->fetchNextObject()) { 
		$userDB = new DB($userdb,$userhost, $dbuser, $userpass); 
		$FriendID = $friend->FriendID;
		if ($FriendID == $ID) 
			$FriendID = $friend->UserID;
			
		$FriendList[] = $FriendID;
		
		$query ="SELECT username, avatar from users where encryptid='$FriendID'";
		$UserArray = $userDB->queryUniqueObject($query);
		 $w3viewString .= "<li class=\"w3vers\" id=\"w3vers_".$FriendID."\"><table border='0' cellspacing='0' cellpadding='0' width='173'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='http://users.w3volt.com/".trim($UserArray->username)."/'><img src='/includes/round_images_inc.php?source=".$UserArray->avatar."&radius=20&colour=e9eef4' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top' class='sender_name'>".$UserArray->username."</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div></li>";
		  $DropStringInit .= 'new YAHOO.w3volt.DDList("w3vers_'.$FriendID.'");';
		 $FCount++;
 }

	$w3viewString .='  </ul></div>';
				
$query ="SELECT * from messages where isread=0 and userid='$ID'";
$friendDB->query($query);
$NumMessages = $friendDB->numRows();

$MailMessage = '('.$NumMessages.') unread mail';

if (($HostedAccount > 1) && ($ID == $_SESSION['userid'])) {
	$query ="SELECT * from pf_subscriptions where UserID='$ID' and Status='active' and SubscriptionType='application'";
	$friendDB->query($query);
	$Applications = $friendDB->numRows();
	if ($Application > 0) {
		$query = "SELECT TimesDownloaded from licenses where UserID='$UserID'";
		$TimesDownloaded = $buyDB->queryUniqueValue($query);
	}
}




	$PageTitle = 'W3VOLT | '.$Username.' - MYVOLT';  
	 
foreach($FriendList as $key => $value){$temp[] = '"'.$value.'"';}

$QueryFriendList = implode(",",$temp);
$query = "SELECT up.UserID, up.ActionType, up.UpdateType, up.ActionSection, up.Link, up.ActionID, up.CreatedDate, u.username,u.avatar,p.comiccrypt, p.SafeFolder,p.thumb as ComicThumb, tu.username as TargetUsername, tu.avatar as TargetAvatar, m.EncryptID as WindowID, m.Title as ListTitle, s.Comment as Status, s.ContentID as StatusContent, s.ContentLink as StatusLink
				FROM updates as up
			    join users as u on up.UserID=u.encryptid
				LEFT join projects as p on up.ActionID=p.comiccrypt
				LEFT join users as tu on up.ActionID=tu.encryptid
				LEFT join feed_modules as m on up.ActionID=m.EncryptID
				LEFT join pf_status as s on up.ActionID=s.ID
				 WHERE (up.UserID IN ($QueryFriendList) or up.UserID='$ID') ORDER BY up.CreatedDate DESC limit 50";
/*
	$query = "select distinct f.ID, f.FriendID, f.UserID as FUserID, f.Accepted, f.FriendType
          from updates as up
		  join friends as f on f.FriendID=up.UserID
		  where f.UserID='$ID' and f.Accepted=1 and f.FriendType='friend' ORDER BY up.CreatedDate";
		  */
	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 

$updateString = "<div id=\"updateList\">";

$friendDB->query($query); 
while ($UpdateArray = $friendDB->fetchNextObject()) { 
$UpdateStatement ='';
		if ($UpdateArray->ActionType == 'updated') {
					switch ($UpdateArray->ActionSection) {
							case 'profile info':
								$UpdateStatement = 'updated information on their ';
								$UpdateStatement .= '<a href="http://users.w3volt.com/'.$UpdateArray->username.'/?t=profile">profile</a>';
								$FeedTitle = $UpdateArray->username;
								$FeedThumb = $UpdateArray->avatar;
								$FeedLink = 'http://users.w3volt.com/'.trim($UpdateArray->username).'/';
									break;
							case 'status':
								$UpdateStatement .= $UpdateArray->Status;
				
								if ($UpdateArray->StatusLink != '')
									$UpdateStatement .= '<br/>&nbsp;&nbsp;[<a href="'.$UpdateArray->StatusLink.'">LINK</a>]';
									$FeedTitle = $UpdateArray->username;
									$FeedThumb = $UpdateArray->avatar;
									$FeedLink = 'http://users.w3volt.com/'.trim($UpdateArray->username).'/';
								break;
								
					}
		
		} else {
				 
				 
				switch ($UpdateArray->ActionSection) {
					case 'comic pages':
							
							//$query ='SELECT ThumbMd, Position, Title from comic_pages where 
							//$friendDB->query($query); 
							$UpdateStatement .= 'new pages have been posted ';
							$UpdateStatement .= '[<a href="'.$UpdateArray->Link.'">READ HERE</a>]';
							$UpdateStatement = str_replace('panelflow','w3volt', $UpdateStatement);
							$FeedTitle = str_replace('_',' ', $UpdateArray->SafeFolder);
							$FeedThumb = 'http://www.panelflow.com'.$UpdateArray->ComicThumb;
							$FeedLink =str_replace('panelflow','w3volt', $UpdateArray->Link);							
							break;
							
					case 'blog':
							$UpdateStatement = $UpdateArray->ActionType .' ';
							if ($UpdateArray->UpdateType == 'user') {
								$UpdateStatement .= 'an update to their blog';
								$UpdateStatement .= '<a href="http://users.w3volt.com/'.$UpdateArray->username.'/blog/">'.str_replace('_',' ', $UpdateArray->SafeFolder).'</a>';
								$FeedTitle = $UpdateArray->username;
								$FeedThumb = $UpdateArray->avatar;
								$FeedLink = 'http://users.w3volt.com/'.trim($UpdateArray->username).'/';
							} else {
								$UpdateStatement .= 'an update to the ';
								$UpdateStatement .= '<a href="http://users.w3volt.com/'.$UpdateArray->SafeFolder.'/blog/">blog</a>';
							$FeedTitle = str_replace('_',' ', $UpdateArray->SafeFolder);
							$FeedThumb = 'http://www.panelflow.com'.$UpdateArray->ComicThumb;
							$FeedLink = 'http://www.w3volt.com/'.$UpdateArray->SafeFolder.'/';
							}
							
							break;
					
					case 'window':
						$UpdateStatement = $UpdateArray->ActionType .' ';
						if ($UpdateArray->ActionType == 'created'){
							$UpdateStatement .= 'a new window called ';
							$UpdateStatement .= '<a href="http://users.w3volt.com/'.$UpdateArray->username.'/">'.str_replace('_',' ', $UpdateArray->ListTitle).'</a>';
						} else if ($UpdateArray->ActionType == 'added'){ 
							$UpdateStatement .= 'an item to their window ';
							$UpdateStatement .= '<a href="http://users.w3volt.com/'.$UpdateArray->username.'/">'.str_replace('_',' ', $UpdateArray->ListTitle).'</a>';
						}
						$FeedTitle = $UpdateArray->username;
						$FeedThumb = $UpdateArray->avatar;
						$FeedLink = 'http://users.w3volt.com/'.trim($UpdateArray->username).'/';
						break;
						 
				}
		}
		if ($FeedTitle != '') 
		$updateString .= "<table border='0' cellspacing='0' cellpadding='0' width='500'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><div class='updated_date' align='right'>".date('m-d-Y',strtotime($UpdateArray->CreatedDate))."</div>
		<table width='100%'><tr><td width='55'><a href='".$FeedLink."'><img src='/includes/round_images_inc.php?source=".$FeedThumb."&radius=20&colour=e9eef4' alt='LINK' border='0' width='50' height='50'></a></td><td valign='top'><div class='sender_name'>".$FeedTitle."</div><div class='messageinfo'>".$UpdateStatement."</div></td></tr></table>
		
		</td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='spacer'></div>";

}
$updateString .= "</div>";
$friendDB->close();
?>

<?php include 'includes/header_template_new.php'; ?>


<script type="text/javascript">
<? /* 
function twitterCallback2(twitters) {
  var statusHTML = [];
  for (var i=0; i<twitters.length; i++){
    var username = twitters[i].user.screen_name;
    var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
      return '<a href="'+url+'">'+url+'</a>';
    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
      return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
    });
    statusHTML.push('<div style="padding-right:10px;"><div style="padding-top:5px;padding-bottom:5px;border-bottom:1px solid #000000;"><span style="color:#000000;">'+status+'</span><span class="menubar"> <em><a style="font-size:85%" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id+'">'+relative_time(twitters[i].created_at)+'</a></em></span></div></div>');
  }
  document.getElementById('twitter_update_list').innerHTML = statusHTML.join('');
}

function relative_time(time_value) {
  var values = time_value.split(" ");
  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
  var parsed_date = Date.parse(time_value);
  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
  delta = delta + (relative_to.getTimezoneOffset() * 60);

  if (delta < 60) {
    return 'less than a minute ago';
  } else if(delta < 120) {
    return 'about a minute ago';
  } else if(delta < (60*60)) {
    return (parseInt(delta / 60)).toString() + ' minutes ago';
  } else if(delta < (120*60)) {
    return 'about an hour ago';
  } else if(delta < (24*60*60)) {
    return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
  } else if(delta < (48*60*60)) {
    return '1 day ago';
  } else {
    return (parseInt(delta / 86400)).toString() + ' days ago';
  }
}
<? 
function attach_file( p_script_url ) {
        script = document.createElement( 'script' );
      script.src = p_script_url; 
      document.getElementsByTagName( 'head' )[0].appendChild( script );
}


function editstatus(action) {
		if (action == 'save') {
			document.getElementById('StatusForm').submit();
			//var statustxt = document.getElementById('txtStatus').value;
			//var notetext = document.getElementById('txtNote').value;
			//attach_file( 'includes/savestatus.php?&text='+escape(statustxt)+'&id=<? //echo $_SESSION['userid'];?>');
			//alert('includes/savestatus.php?&text='+escape(statustxt)+'&id=<? //echo $_SESSION['userid'];?>');
			//document.getElementById('currentstatus').innerHTML = statustxt;
			//document.getElementById('statusedit').style.display= 'none';
			
		} else {
			document.getElementById('statusedit').style.display= 'none';
		}
}
function showstatus() {

	document.getElementById('statusedit').style.display = '';
}


		function revealModal(divID)
	{
		window.onscroll = function () { document.getElementById(divID).style.top = document.body.scrollTop; };
		document.getElementById(divID).style.display = "block";
		document.getElementById(divID).style.top = document.body.scrollTop;
	}
	
	function hideModal(divID)
	{
		document.getElementById(divID).style.display = "none";
	}
	
	function addFriend()
	{
	 	     <? if (isset($_GET['id'])) { 
			 	echo 'document.friendform.action = "/myvolt/'.$Username.'/";'; 
			 } else { 
				echo 'document.friendform.action = "/myvolt/'.$Username.'/";';
			}?>
			document.friendform.submit() 
			hideModal('friendModal');
			
		
	}
	
	function rolloveractive(tabid, divid) {
	var divstate = document.getElementById(divid).style.display;
	//alert('TABID = '+tabid+' and DIVID='+divid);
	//if (divstate == 'none') {
		//alert(divid+ 'state = hidden');
	//} else {
		//alert(divid+ 'state = active');
	//}
			if (document.getElementById(divid).style.display != '') {
			//alert('TABID = '+tabid+' and DIVID='+divid);
				document.getElementById(tabid).className ='profiletabhover';
			} 
	}
	function rolloverinactive(tabid, divid) {
			if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='profiletabinactive';
			} 
	}
	
	function comicstab()
	{
			document.getElementById("comicslist").style.display = '';
			document.getElementById("comicstab").className ='profiletabactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			<? if ($ID == $_SESSION['userid']) { ?>
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			<? }?>
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
	}
	function infotab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = '';
			document.getElementById("infotab").className ='profiletabactive';
			<? if ($ID == $_SESSION['userid']) { ?>
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			<? }?>
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
			
	}
	<? if ($ID == $_SESSION['userid']) { ?>
	function favstab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			document.getElementById("favslist").style.display = '';
			document.getElementById("favstab").className ='profiletabactive';
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			
	}
	
	function appstab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = '';
			document.getElementById("appstab").className ='profiletabactive';
			<? }?>
			
	}
	<? }?>
	<? if ($Products >0) { ?>
	function productstab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			<? if ($ID == $_SESSION['userid']) { ?>
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			<? }?>
			document.getElementById("productslist").style.display = '';
			document.getElementById("productstab").className ='profiletabactive';
		
			
	}
	<? }?>
	*/?>
	</script>
    <style type="text/css">
	<!--
#myvoltrightside {
	width: 30px;
	background-image:url(http://www.w3volt.com//templates/modules/standard/my_volt_R.png);
	background-repeat:repeat-y;
}

#myvoltleftside {
	width: 14px;
	background-image:url(http://www.w3volt.com//templates/modules/standard/my_volt_L.png);
	background-repeat:repeat-y;
}

#myvolttop {
	height:73px;
	background-image:url(http://www.w3volt.com//templates/modules/standard/my_volt_T.png);
	background-repeat:repeat-x;
}

.boxcontent {
	color:#000000;
	background-color:#FFFFFF;
}

#myvoltbottom {
	height:11px;
	background-image:url(http://www.w3volt.com//templates/modules/standard/my_volt_B.png);
	background-repeat:repeat-x;
}

#myvoltbottomleft{
	width:14px;
	height:11px; 
	background-image:url(http://www.w3volt.com//templates/modules/standard/my_volt_BL.png);
	background-repeat:no-repeat;
}

#myvolttopleft{
	width:14px;
	height:73px; 
	background-image:url(http://www.w3volt.com//templates/modules/standard/my_volt_TL.png);
	background-repeat:no-repeat;
}

#myvolttopright{
	width:31px;
	height:73px; 
	background-image:url(http://www.w3volt.com//templates/modules/standard/my_volt_TR.png);
	background-repeat:no-repeat;
}

#myvoltbottomright{
	width:31px;
	height:11px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/my_volt_BR.png);
	background-repeat:no-repeat;
}


.tabactive {
height:12px;
background-color:#f58434;
text-align:center;
padding:5px;
cursor:pointer;
font-weight:bold;
font-size:12px;
}
.tabinactive {
height:12px;
background-color:#dc762f;
text-align:center;
padding:5px;
cursor:pointer;
color:#FFFFFF;
font-size:12px;
}
.tabhover{
height:12px;
background-color:#ffab6f;
color:#000000;
text-align:center;
padding:5px;
cursor:pointer;
font-size:12px;
}
#updateBox_T {
background-color:#e9eef4;
height:8px;
}

.updateboxcontent {
	color:#000000;
	background-color:#e9eef4;
}

#updateBox_B {
background-color:#e9eef4;
height:8px;
 
}


#updateBox_TL{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com//images/update_wrapper_TL.png);
	background-repeat:no-repeat;
}

#updateBox_TR{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com//images/update_wrapper_TR.png);
	background-repeat:no-repeat;
}

#updateBox_BR{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com//images/update_wrapper_BR.png);
	background-repeat:no-repeat;
}
#updateBox_BL{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com//images/update_wrapper_BL.png);
	background-repeat:no-repeat;
}
div.workarea { padding:10px; float:left }

ul.draglist { 
    position: relative;
    width: 200px; 
	height:232px;
    list-style: none;
    margin:0;
    padding:0;
	overflow:scroll;
}

ul.draglist li {

    cursor: move;
    zoom: 1;
}

ul.draglist_alt { 
    position: relative;
    width: 200px;  
    list-style: none;
    margin:0;
    padding:0;
    /*
       The bottom padding provides the cushion that makes the empty 
       list targetable.  Alternatively, we could leave the padding 
       off by default, adding it when we detect that the list is empty.
    */
padding-bottom:20px;
}

ul.draglist_alt li {
    margin: 0px;
    cursor: move; 
}
#modrightside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/right_side.png);
	background-repeat:repeat-y;
}

#modleftside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/left_side.png);
	background-repeat:repeat-y;
}

#modtop {
	height:38px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_bar.png);
	background-repeat:repeat-x;
}

.boxcontent {
	color:#000000;
	background-color:#FFFFFF;
}

#modbottom {
	height:9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_bar.png);
	background-repeat:repeat-x;
}

#modbottomleft{
	width:9px;
	height:9px; 

	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_left.png);
	background-repeat:no-repeat;
}

#modtopleft{
	width:9px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_left.png);
	background-repeat:no-repeat;
}

#modtopright{
	width:31px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_right.png);
	background-repeat:no-repeat;
}

#modbottomright{
	width:31px;
	height:9px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_right.png);
	background-repeat:no-repeat;
}

-->
</style>




<table cellpadding="0" cellspacing="0" border="0">

	<tr>
		<td width="<? echo $SideMenuWidth;?>" valign="top">
			<? include 'includes/site_menu_inc.php';?>
		</td> 
		<td style="padding-left:10px;">
		
		<? include 'includes/banner_ad_inc.php'?><br />

      <table height="600" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="myvolttopleft"></td>

	<td id="myvolttop" valign="bottom">
	
	<table border="0" cellpadding="0" cellspacing="0"><tbody><tr>
	

	
	<td style="padding-bottom:5px;"><img src="/includes/round_images_inc.php?source=<? echo $Avatar;?>&radius=20&colour=5b88b4" width="50"></td><td width="5"></td><td  style="padding-bottom:5px;"><img src="http://www.w3volt.com/images/myvolt_logo.png" /></td>
    <td width="5"></td>
    <td valign="bottom"><? if ($_GET['t'] == 'profile') {?><img src="http://www.w3volt.com/images/profile_button_over.png" /><? } else {?><a href="/myvolt/<? echo trim($_SESSION['username']);?>/?t=profile"><img src="http://www.w3volt.com/images/profile_button.png" id="profile_button" onmouseover="roll_over(this, 'http://www.w3volt.com/images/profile_button_over.png')" onmouseout="roll_over(this, 'http://www.w3volt.com/images/profile_button.png')" class="navbuttons"/></a><? }?>
   <div style="height:4px;"></div><img id="cal_tab" <? if (isset($_GET['t'])){?>src="http://www.w3volt.com/images/calendar_tab_inactive.png" onClick="window.location='/myvolt/<? echo trim($_SESSION['username']);?>/';" onMouseOver="roll_over(this, 'http://www.w3volt.com/images/calendar_tab_active.png')" onMouseOut="roll_over(this, 'http://www.w3volt.com/images/calendar_tab_inactive.png')" <? } else {?>src="http://www.w3volt.com/images/calendar_tab_active.png"<? }?> class="navbuttons" vspace="1" /></td>
<td width="5"></td>
<td align="left" valign="bottom"><a href="/myvolt/<? echo trim($_SESSION['username']);?>/?t=mailbox"><img src="http://www.w3volt.com/images/w3mail_button.png" border="0"/></a><div style="height:4px;"></div><img id="feed_tab" <? if ($_GET['t'] != 'feed'){?>src="http://www.w3volt.com/images/feed_tab_inactive.png" onClick="window.location='/myvolt/<? echo trim($_SESSION['username']);?>/?t=feed';" onMouseOver="roll_over(this, 'http://www.w3volt.com/images/feed_tab_active.png')" onMouseOut="roll_over(this, 'http://www.w3volt.com/images/feed_tab_inactive.png')" <? } else {?>src="http://www.w3volt.com/images/feed_tab_active.png"<? }?> class="navbuttons" /></td>
<td width="5"></td>
<td align="left" valign="bottom"><a href="/myvolt/<? echo trim($_SESSION['username']);?>/?t=forum"><img src="http://www.w3volt.com/images/forum_button.png" border="0"/></a><div style="height:4px;"></div><img id="volts_tab" <? if ($_GET['t'] != 'volts'){?>src="http://www.w3volt.com/images/volts_tab_inactive.png" onClick="window.location='/myvolt/<? echo trim($_SESSION['username']);?>/?t=volts';" onMouseOver="roll_over(this, 'http://www.w3volt.com/images/volts_tab_active.png')" onMouseOut="roll_over(this, 'http://www.w3volt.com/images/volts_tab_inactive.png')" <? } else {?>src="http://www.w3volt.com/images/volts_tab_active.png"<? }?> class="navbuttons" vspace="1" /></td>
<td width="5"></td>
<td  align="left" valign="bottom"><img src="http://www.w3volt.com/images/settings_button.png" /><div style="height:4px;"></div><img id="networks_tab" <? if ($_GET['t'] != 'network'){?>src="http://www.w3volt.com/images/networks_tab_inactive.png" onClick="window.location='/myvolt/<? echo trim($_SESSION['username']);?>/?t=network';" onMouseOver="roll_over(this, 'http://www.w3volt.com/images/networks_tab_active.png')" onMouseOut="roll_over(this, 'http://www.w3volt.com/images/networks_tab_inactive.png')" <? } else {?>src="http://www.w3volt.com/images/networks_tab_active.png"<? }?> class="navbuttons" vspace="1" />
</td>
<td width="5"></td>
</tr></table>

<div style="height:8px;"></div>  
</td>
<td id="myvolttopright" valign="top" align="right"></td>

</tr>
<tr>
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr> 
	<td id="myvoltleftside"></td>
	<td class="boxcontent" height="593" valign="top" align="center">
	<div id="calendar_div" <? if (isset($_GET['t'])) {?>style="display:none;"<? }?>>
    <iframe src="/schedule/index.php" width="100%" height="300" frameborder="0" id="readerframe" name="readerframe" 
  onload="resize_iframe(this);" scrolling="no"></iframe>
    
    </div>
    
    <div id="feed_div" <? if ($_GET['t'] != 'feed') {?>style="display:none;"<? }?> align="center">
   <? echo $updateString;?>	
    
    </div>
    
    <div id="volts_div" <? if ($_GET['t'] != 'volts') {?>style="display:none;"<? }?>>
    <iframe src="/get_volts.php" width="800" height="850" frameborder="0" scrolling="no"></iframe>						 
    
    </div>
    
     <div id="mail_div" <? if ($_GET['t'] != 'mailbox') {?>style="display:none;"<? }?>>
    <iframe src="/mailbox.php" width="675" height="605" frameborder="0" scrolling="no"></iframe>			
    
    </div>
    
     <div id="forum_div" <? if ($_GET['t'] != 'forum') {?>style="display:none;"<? }?>>
    <iframe src="http://www.w3volt.com/forum/index.php?user=<? echo $_GET['name'];?>" width="800" height="850" frameborder="0" scrolling="auto" id="forumframe" name="forumframe"></iframe>						 
    
    </div>
    
      <div id="profile_div" <? if ($_GET['t'] != 'profile') {?>style="display:none;"<? }?> align="center">
  <? include 'includes/profile_inc.php';?>
    
    </div>
  
    
    
    <div id="networks_div" <? if ($_GET['t'] != 'network') {?>style="display:none;"<? }?>>
   <table cellpadding="0" cellspacing="0" border="0"><tr>
   <td valign="top">
   
   
   	<table border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="modtopleft"></td>

	<td id="modtop"><img src="http://www.w3volt.com/templates/modules/standard/friends_header.jpg" /></td><td id="modtopright" valign="top" align="right"><a href="#"><img src="http://www.w3volt.com/templates/modules/standard/volt_sm.png" hspace="3" vspace="3" border="0"></a></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

	<? echo $friendString;?>
	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>

<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
</table>

	</td>
    <td width="10"></td>
   <td> 
   	<table border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td id="modtopleft"></td>

			<td id="modtop"><img src="http://www.w3volt.com/templates/modules/standard/w3viwers_header.jpg" /></td><td id="modtopright" valign="top" align="right"><a href="#"><img src="http://www.w3volt.com/templates/modules/standard/volt_sm.png" hspace="3" vspace="3" border="0"></a></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

	<? echo $w3viewString;?>
	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>

<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
</table>
    
    </td>
   </tr>
   <tr>
   <td height="10" colspan="3">
   </td>
   </tr>
   <tr>
   <td>
      	<table border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td id="modtopleft"></td>

			<td id="modtop"><img src="http://www.w3volt.com/templates/modules/standard/fans_header.jpg" /></td><td id="modtopright" valign="top" align="right"><a href="#"><img src="http://www.w3volt.com/templates/modules/standard/volt_sm.png" hspace="3" vspace="3" border="0"></a></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

	 <? echo $fanString;?>
	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>

<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
</table>

  </td>
   <td width="10"></td>
   <td>
    	<table border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td id="modtopleft"></td>

			<td id="modtop"><img src="http://www.w3volt.com/templates/modules/standard/celebrities_header.jpg" /></td><td id="modtopright" valign="top" align="right"><a href="#"><img src="http://www.w3volt.com/templates/modules/standard/volt_sm.png" hspace="3" vspace="3" border="0"></a></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

	   <? echo $celebString;?>
	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>

<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
</table>
</td>
   </tr></table>

    </div>
	</td>
	<td id="myvoltrightside"></td>

	</tr>
	</table>


	</td>
</tr>

<tr>
	<td id="myvoltbottomleft"></td>
	<td id="myvoltbottom"></td>
	<td id="myvoltbottomright"></td>
</tr>
</table>
	   
	   
	   
</td>
</tr>
</table>

<?php include 'includes/footer_template_new.php';?>

        

<div id="friendModal" style="display:none;">
    <div class="modalBackground">
    </div>
    <div class="modalContainer">
        <div class="modal">
            <div class="modalTop"><b>FRIEND REQUEST</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:hideModal('friendModal')">[X]</a></div>
            <div class="modalBody">
            <div align="center">
            <form name="friendform">
				<p align="center" style="font-size:14px;">Are you <b>sure</b> you want to Add as a friend? <div class='spacer'></div>A request will be sent to them to accept the invitation.</p><br /><br />
					<input type="submit" name="btnsubmit" value="Yes" onClick="javascript:addfriend();"><div class='spacer'></div>
<input type="submit" name="btnsubmit" value="NO" onClick="javascript:hideModal('friendModal');">
<input type="hidden" name="friendid" value="<? echo $ID;?>" />
</form>

				</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<? echo $Twittername;?>.json?callback=twitterCallback2&amp;count=<? echo $TwitterCount;?>"></script>
</body>
</html>

