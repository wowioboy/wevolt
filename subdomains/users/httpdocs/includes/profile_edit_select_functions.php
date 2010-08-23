<? 
 $query = "select * from users_profile where UserID='$ID' order by InfoType, ID";
     $InitDB->query($query);
	 $LastType = '';
	 while ($profile = $InitDB->FetchNextObject()){
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
	  	  $Birthdate = explode('-',$user->birthdate);
	 else
	 	  $Birthdate = explode('-',$Birthday);
	 $BirthdayDay =$Birthdate[1];
	 $BirthdayMonth =$Birthdate[0];
	 $BirthdayYear =$Birthdate[2];
	 
	 if ($Music == '')
	 	$Music = stripslashes($user->music);
		
	 if ($Location == '')
 		 $Location = stripslashes($user->location);
		 
 	 if ($Books == '')
		 $Books = stripslashes($user->books);
		 
 	 if ($Hobbies == '')
		 $Hobbies = stripslashes($user->hobbies);
		 
 	 if ($Website == '') 	 
	 	 $Website= $user->website;
	 if ($About == '')
	    $About = stripslashes($user->about);
	 if ($Influences == '')
	   $Influences = $user->influences;
	 if ($TwitterName == '')
		 $TwitterName  = $user->Twittername; 
	if ($Credits == '') 
	 	$Credits = stripslashes($user->credits);
	 	   
	 $Status = $user->Status;
	 $TwitterCount = $user->TwitterCount;
	
	 if (substr($Website,0,3) == 'www') {
	 	$Website = 'http://'.$Website;
	 }
		
	 $IsCreator = $user->iscreator;
	 
	 
	 $Link1 = $user->link1;
	 if (substr($Link1,0,3) == 'www') {
	 	$Link1 = 'http://'.$Link1;
	 }
	 $Link2 = $user->link2;
	  if (substr($Link2,0,3) == 'www') {
	 	$Link2 = 'http://'.$Link2;
	 }
	 $Link3 = $user->link3;
	  if (substr($Link3,0,3) == 'www') {
	 	$Link3 = 'http://'.$Link3;
	 }
	 $Link4 = $user->link4;
	  if (substr($Link4,0,3) == 'www') {
	 	$Link4 = 'http://'.$Link4;
	 }
 	 if ($Sex == '')
	 	$Sex = $user->gender;
		
	 $AllowComments = $user->allowcomments;
	 $HostedAccount = $user->HostedAccount;
?>