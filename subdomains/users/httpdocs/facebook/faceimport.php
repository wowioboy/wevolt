<?
include '../includes/global_settings_inc.php';
include '../includes/init.php';
include_once '../facebook-platform/php/facebook.php';
global $api_key,$secret;
$FaceBookFields = array(
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

?>
<div align="center"><div style="height:10px;"></div><b>PLEASE WAIT...YOUR PROFILE IS BEING IMPORTED</b><br /><div style="height:10px;"></div><img src="http://www.w3volt.com/images/progressBarLong.gif" /><br />You will be redirected back to your profile once the import is complete.<br/><div style="height:10px;"></div> <b>Do not leave this page or click you back button.</b>
</div>


<?
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
	//	print $query.'<br/><br/><br/>';
		if (($FaceID == '') || ($FaceID != $fb_user)) {
			$query="update users set FaceID='$fb_user' where encryptid='".$_SESSION['userid']."'";
			$DB->query($query);
		}
		$query ="SELECT count(*) from users_profile where UserID='".$_SESSION['userid']."'";
		$FacebookData = $DB->queryUniqueValue($query);
		//print $query.'<br/><br/><br/>';
		$user_details=$fb->api_client->users_getInfo($fb_user, array('last_name','first_name','proxied_email','interests','pic_big','profile_blurb','quotes','status','work_history','tv','movies','music','hs_info','hometown_location','education_history','current_location','books','affiliations','activities','about_me','profile_url','website','birthday_date','sex'));  
		$KeyArray = multiarray_keys($user_details[0]);

			foreach($FaceBookFields as $entry) {
				
				$query ="SELECT LongComment from users_profile where InfoType='".$entry['Type']."' and UserID='".$_SESSION['userid']."' and RecordID='".$entry['Name']."'"; 			
				$UserData = $DB->queryUniqueValue($query);
				//print $query.'<br/><br/><br/>';
				if ($UserData == ''){
					$query ="INSERT into users_profile (UserID,RecordID,PrivacySetting,LastUpdated,InfoType) values ('".$_SESSION['userid']."','".$entry['Name']."','".$entry['Privacy']."','$TodayDay','".$entry['Type']."')"; 			
					//$DB->execute($query);
					//print $query.'<br/><br/><br/>';
				}
			
			
			//print $query.'<br/>';
			}
		
	
		//print_r($user_details[0]);
		foreach($FaceBookFields as $profilekey) {
				$UpdateValue = '';
				$FValue = $profilekey['Name'];
				
				$query ="SELECT LongComment from users_profile where RecordID='$FValue' and UserID='".$_SESSION['userid']."'";			
				$UserData = $DB->queryUniqueValue($query);
				//print $query.'<br/><br/><br/>';
				//print 'USER DATA = ' . $UserData.'<br/>';
				//print 'Value Key = ' . $FValue.'<br/>';
				if (is_array($user_details[0][$FValue])) {
					$TempKeyArray =  multiarray_keys($user_details[0][$FValue]);
					//print_r($TempKeyArray );
					if ($FValue =='hometown_location') {
						$UpdateValue = $user_details[0][$FValue]['city'];
						if ($user_details[0][$FValue]['state'] != '')
							$UpdateValue .= ', '.$user_details[0][$FValue]['state'];
					
					}else if ($FValue =='current_location') {
						//print_r($user_details[0][$FValue]);
						$UpdateValue = $user_details[0][$FValue]['city'];
						if ($user_details[0][$FValue]['state'] != '')
							$UpdateValue .= ', '.$user_details[0][$FValue]['state'];
						if ($user_details[0][$FValue]['state'] != '')
							$UpdateValue .= ' '.$user_details[0][$FValue]['country'];
					
					} else if ($FValue =='education_history') {
						$SCount = 0;
						foreach($user_details[0][$FValue] as $School) {
							if ($SCount != 0)
								$UpdateValue .= '<br/><br/>';
							$SCount = 1;
							$UpdateValue .= $School['name'];
							if  (($School['year'] != '') && ($School['year'] != '0')) 
								$UpdateValue .= ' - '.$School['year'];
							
							if  ($School['concentrations'] != '') {
								
								if (is_array($School['concentrations'])) {
									$UpdateValue .= '</br>Studied: ';
									$LCount = 0;
									foreach($School['concentrations'] as $Major) {
										if ($LCount == 0)
											$UpdateValue .= $Major;
										else
											$UpdateValue .= ', '. $Major;
										$LCount = 1;
									}
								
								} else {
									$UpdateValue .= '</br>Studied:'.$School['concentrations'];
								}
									
							}
							if  ($School['degree'] != '')
								$UpdateValue .= ' - '.$School['degree'];
						
						} 
					} else if ($FValue =='work_history') {
									$SCount = 0;
									foreach($user_details[0][$FValue] as $Work) {
									//	print_r($Work);
									if ($SCount != 0)
											$UpdateValue .= '<br/><br/>';
										$SCount = 1;
										$UpdateValue .= $Work['company_name'];
										
										if ($Work['location']['city'] != '')
											$UpdateValue .= '<br/>'.$Work['location']['city'];
										if ($Work['location']['state'] != '')
											$UpdateValue .= ', '.$Work['location']['state'];
										if ($Work['location']['country'] != '')
											$UpdateValue .= ' '.$Work['location']['country'];
										if ($Work['position'] != '')
											$UpdateValue .= '<br/>'.$Work['position'];
										if ($Work['description'] != '')
											$UpdateValue .= '<br/>'.$Work['description'];
										if (($Work['start_date'] != '') && ($Work['start_date'] != '0000-00'))
											$UpdateValue .= '<br/>'.$Work['start_date'];
									if (($Work['end_date'] != '') && ($Work['end_date'] != '0000-00'))
											$UpdateValue .= ' - ' .$Work['end_date'];
														
									}
	
						}				
				} else {
				
					$UpdateValue = mysql_real_escape_string($user_details[0][$FValue]);
				}
				
				if ($_GET['a'] == 'import')
					$UserData .= $UpdateValue;
				else 
					$UserData = $UpdateValue;
					
				$query = "UPDATE users_profile set LongComment='$UserData' where RecordID='$FValue' and UserID='".$_SESSION['userid']."'";
				$DB->execute($query);
				//print $query.'<br/><br/><br/>';
			
		}
		//echo 'Your Account has been linked to your Facebook.';
		$Imported = 1;
		
//$firstName=$user_details[0]['first_name']; 
//$lastName=$user_details[0]['last_name'];
//$email=$user_details[0]['proxied_email'];


//print_r($KeyArray);
//print_r(array_keys($user_details[0]));

} else {
	echo 'Not Logged into Facebook';
	$Imported =0;
}

if ($Imported == 1) {?>

<script type="text/javascript">
parent.window.location='http://users.w3volt.com/myvolt/<? echo trim($_SESSION['username']);?>/?t=profile';
</script>
<? }?>

