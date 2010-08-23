<?
include '../includes/global_settings_inc.php';
include '../includes/init.php';
include_once '../facebook-platform/php/facebook.php';
global $api_key,$secret;
$FaceBookFields = array(
						array('Name'=>'sex','Type'=>'basic','Privacy'=>'private'),
						array('Name'=>'birthday_date','Type'=>'basic','Privacy'=>'private'),
						array('Name'=>'sex','Type'=>'basic','Privacy'=>'private'),
						array('Name'=>'hometown_location','Type'=>'basic','Privacy'=>'private'),
						array('Name'=>'profile_blurb','Type'=>'basic','Privacy'=>'private'),
						array('Name'=>'about_me','Type'=>'personal','Privacy'=>'private'),
						array('Name'=>'activities','Type'=>'personal','Privacy'=>'private'),
						array('Name'=>'interests','Type'=>'personal','Privacy'=>'private'),
						array('Name'=>'music','Type'=>'personal','Privacy'=>'private'),
						array('Name'=>'tv','Type'=>'personal','Privacy'=>'private'),
						array('Name'=>'movies','Type'=>'personal','Privacy'=>'private'),
						array('Name'=>'books','Type'=>'personal','Privacy'=>'private'),
						array('Name'=>'website','Type'=>'contact','Privacy'=>'private'),
						array('Name'=>'current_location','Type'=>'contact','Privacy'=>'private'),
						array('Name'=>'profile_url','Type'=>'contact','Privacy'=>'private'),
						array('Name'=>'education_history','Type'=>'credits','Privacy'=>'private'),
						array('Name'=>'work_history','Type'=>'credits','Privacy'=>'private'));
						
$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();
function multiarray_keys($ar) {
           
    foreach($ar as $k => $v) {
        $keys[] = $k;
        if (is_array($ar[$k]))
            $keys = array_merge($keys, multiarray_keys($ar[$k]));
    }
    return $keys;
}

if(($_SESSION['userid'] != '') && ($fb_user !='')) { 
$TodayDay = date('Y-m-d h:m:s');
	$DB = new DB();
	//Note the esc() function below is custom function which is just short for mysql_real_escape_string();
		$query ="SELECT FaceID from users where encryptid='".$_SESSION['userid']."'";
		$FaceID = $DB->queryUniqueValue($query);
		if (($FaceID == '') || ($FaceID != $fb_user)) {
			$query="update users set FaceID='$fb_user' where encryptid='".$_SESSION['userid']."'";
			$DB->query($query);
		}
		$query ="SELECT count(*) from users_profile where UserID='".$_SESSION['userid']."'";
		$FacebookData = $DB->queryUniqueValue($query);
		$user_details=$fb->api_client->users_getInfo($fb_user, array('last_name','first_name','proxied_email','interests','pic_big','profile_blurb','quotes','status','work_history','tv','movies','music','hs_info','hometown_location','education_history','current_location','books','affiliations','activities','about_me','profile_url','website','birthday_date','sex'));  
		$KeyArray = multiarray_keys($user_details[0]);
		if ($FacebookData == 0) {
			foreach($FaceBookFields as $entry) {
				
				$query ="INSERT into users_profile (UserID,RecordID,PrivacySetting,LastUpdated,InfoType) values ('".$_SESSION['userid']."','".$entry['Name']."','".$entry['Privacy']."','".$entry['Type']."')"; 			
			//$DB->execute($query);
			//print $query.'<br/>';
			}
		
		}
		//print_r($user_details[0]);
		foreach($FaceBookFields as $profilekey) {
				$UpdateValue = '';
				$FValue = $profilekey['Name'];
				print 'Value Key = ' . $FValue.'<br/>';
				if (is_array($user_details[0][$FValue])) {
					$TempKeyArray =  multiarray_keys($user_details[0][$FValue]);
					print_r($TempKeyArray );
					if ($FValue =='hometown_location') {
						$UpdateValue = $user_details[0][$FValue]['city'];
						if ($user_details[0][$FValue]['state'] != '')
							$UpdateValue .= ', '.$user_details[0][$FValue]['state'];
					
					} else if ($FValue =='education_history') {
						foreach($user_details[0][$FValue] as $School) {
							$UpdateValue .= $School['name'];
							if  ($School['year'] != '')
								$UpdateValue .= ' - '.$School['year'];
							if  ($School['concentrations'] != '')
								$UpdateValue .= ' - '.$School['concentrations'];
							if  ($School['degree'] != '')
								$UpdateValue .= ' - '.$School['degree'];
						}
									
					}
									
				} else {
				
					$UpdateValue = mysql_real_escape_string($user_details[0][$FValue]);
				}
				
				$query = "UPDATE users_profile set LongComment='$UpdateValue' where RecordID='$profilekey' and UserID='".$_SESSION['userid']."'";
				//$DB->execute($query);
				print $query.'<br/><br/><br/>';
			
		}
		echo 'Your Account has been linked to your Facebook.';
		
//$firstName=$user_details[0]['first_name']; 
//$lastName=$user_details[0]['last_name'];
//$email=$user_details[0]['proxied_email'];


//print_r($KeyArray);
//print_r(array_keys($user_details[0]));

} else {
	echo 'Not Logged into Facebook';
}
?>
