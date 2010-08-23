<? 

$UserFields = array();
    $Now = date('Y-m-d h:i:s');
	
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
	$UserFields[] = array('Name'=>'credits','Privacy'=>$CreditsPrivacy,'Type'=>'contact','RecordValue'=>$Credits);

	$AllowComments = $_POST['commentsallow'];
	
	foreach($UserFields as $entry) {
			$query ="SELECT ID from users_profile where UserID='".$_SESSION['userid']."' and RecordID='".$entry['Name']."'";
	        $IsData = $InitDB->queryUniqueValue($query);
			//print $query.'<br/>';
			if ($IsData == '') {
				$query ="INSERT into users_profile (UserID,RecordID,LongComment, PrivacySetting,LastUpdated,InfoType) values ('".$_SESSION['userid']."','".$entry['Name']."','".$entry['RecordValue']."','".$entry['Privacy']."','$Now','".$entry['Type']."')"; 			
			} else {
				$query = "UPDATE users_profile set LongComment='".$entry['RecordValue']."', PrivacySetting='".$entry['Privacy']."' where RecordID='".$entry['Name']."' and UserID='".$_SESSION['userid']."'";
			}
			$InitDB->execute($query);
		//	print $query.'<br/><br/>';
	}	

?>