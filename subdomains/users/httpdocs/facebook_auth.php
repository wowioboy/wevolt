<? 
include 'includes/global_settings_inc.php';
include 'includes/db.class.php';
include_once 'facebook-platform/php/facebook.php';
global $api_key,$secret;
$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();
if($fb_user) {
	//Query your database to see if the $fb_user exists
 	$DB = new DB(); // you can use whatever database connection and query techniques you normally would use.

 	//you'll have to modify this query for your own database
    $query="select id from users where FaceID=$fb_user";
    
   $UserID=	$DB->queryUniqueValue($query); 

	//if you get a row back then : Log the user into your application by setting a cookie 
	//or by setting a session variable or whatever other means you like or use.
	// then send off to the logged in user page:        
	if($UserID != '' ) {
    	$_SESSION['authorized']='true';  
    	//you can also optionally set their user id (your sites id) in the session as well if you need to  	
    	//After setting session values, forward them off to the Logged in User page.
    	header("Location: http://users.w3volt.com/facelog.php");
	} else {
		//user is logged into FB and has authorized yoursite.com for connect. But
		//we don't have their fb_user id stored on yoursite.com database yet.		
		//so send them to the Connect Account page so they can either link up with an 
		//existing account or create a new one.
		header("Location: http://users.w3volt.com/faceimport.php");
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="http://static.new.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

</head>

<body onload="initFB();">
<form method="post" action="/facebook_auth.php">
Username:<input type="text" name="username"><br/>
Password: <input type="password" name="password"><br/>
<input type="submit'" value="submit">
</form>
<br><br>
Or Login with Facebook: <fb:login-button length="long" background="light" size="medium"></fb:login-button>
<script type="text/javascript">
function fbConnect() {
	FB.init("<? echo $api_key;?>", "/channel/xd_receiver.htm",{"reloadIfSessionStateChanged":true});
}
</script>


</body>
</html>
