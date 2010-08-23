<?
include '../includes/global_settings_inc.php';
include '../includes/init.php';
include_once '../facebook-platform/php/facebook.php';
global $api_key,$secret;
$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();
if(!$fb_user) {
	header("Location: http://www.yoursite.com/login.php");
}

if(($_SESSION['userid'] != '') && ($fb_user !='')) {

	$DB = new DB();
	//Note the esc() function below is custom function which is just short for mysql_real_escape_string();
		$query="update users set FaceID='$fb_user' where encryptid='".$_SESSION['userid']."'";
		//$DB->query($query);
		echo $query.'<br/>';
		echo 'Your Account has been linked to your Facebook.';
		$user_details=$fb->api_client->users_getInfo($fb_user, array('last_name','first_name','proxied_email'));  
$firstName=$user_details[0]['first_name']; 
$lastName=$user_details[0]['last_name'];
$email=$user_details[0]['proxied_email'];
print_r($user_details);

} else {
	echo 'Not Logged into Facebook';
}
?>
