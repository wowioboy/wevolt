<?php include 'includes/init.php';
$PageTitle = 'User Account Registration';
$Message == '';
function isValidDate ($date) {
	$DateArray = explode("-",$date);
	
	if (sizeof($DateArray) != 3) {
		$Valid = 0;
	} else if (strlen($DateArray[0]) != 2){
		$Valid = 0;
	}else if (strlen($DateArray[1]) != 2){
		$Valid = 0;
	}else if (strlen($DateArray[2]) != 4){
		$Valid = 0;
	} else {
		$Valid = 1;
	}
return $Valid;
}

function isValidEmail ($email) {
	$EmailArrayFront = explode("@",$email);
	$EmailArrayBack = explode(".",$email);
	if (sizeof($EmailArrayFront) != 2) {
		$Valid = 0;
	} else if (sizeof($EmailArrayBack) != 2) {
		$Valid = 0;
	}else if (strlen($EmailArrayBack[1]) != 3){
		$Valid = 0;
	}else {
		$Valid = 1;
	}
return $Valid;
}

$Error == '';

if ($_POST['txtRegister'] == 1) {

if ((!isset($_POST['email'])) || (!isset($_POST['username']))  || (!isset($_POST['realname']))  || (!isset($_POST['username'])) || (!isset($_POST['txtOver'])) || (!isset($_POST['txtGender']))){ 
	$Error = 'One or more fields are missing';
} else if ($_POST['password'] != $_POST['confirmpass']){  
	$Error = 'Your passwords do not match.';
} else if (isValidEmail($_POST['email']) == 0){
		$Error = 'Your Email does not appear to be valid, please enter a valid address: name@provider.com';
} else if ($_POST['txtOver'] == 1){  
	if (!isset($_POST['txtdate'])) {
		$Error = 'You need to enter a birthdate to verify your are over 13.';
	} else if (isValidDate($_POST['txtdate']) == 0){
		$Error = 'You need to enter a birthdate in the correct format ex MM-DD-YYYY.';
	}
	
}
	



if ($Error == '') {	  
	$TempUsername = $_POST['username'];
	$Usernamereplace = trim(preg_replace('/\s+/', '', $TempUsername));
	$result = file_get_contents ('http://www.panelflow.com/processing/pfusers.php?action=register&email='.urlencode($_POST['email']).'&pass='.$_POST['password']."&username=".urlencode($Usernamereplace)."&overage=".$_POST['overage']."&birthdate=".urlencode($_POST['birthdate'])."&notify=".$_POST['notify']."&gender=".$_POST['gender']."&realname=".urlencode($_POST['realname'])."&ref=".urlencode(trim($_POST['ref'])));

	if (trim($result) == 'Clear'){
		$RegisterDB = new DB();
		$email = $_POST['email'];
		$query = "select encryptid, username, avatar from users where email='$email'";
		$user = $RegisterDB->queryUniqueObject($query);
		$Avatar = $user->avatar;
		$Username = trim($user->username);
		if(!is_dir("../users/". $Username)) { 
			mkdir("../users/".$Username); chmod("../users/".$Username, 0777); 
		}

		if(!is_dir("../users/".$Username."/avatars")) { 
			mkdir("../users/".$Username."/avatars"); chmod("../users/".$Username."/avatars", 0777); 
		}
		$RegisterDB->close();
 
     $Message = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="left" width="120">Your current Avatar: <br/><img src="'.$Avatar.'" border="2" ></td>
    <td valign="middle"><div class="content" align="left">Welcome,<b> '.$Username.'</b><br> Thank you for registering on our site, after you have verified your account you can leave comments on all Panel Flow Webcomics sites and create your own comics. <div class="spacer"></div><br>Two emails have just been sent to <b>'.$email.'</b> with all your PANEL FLOW information and the account verification link. Please keep it for your records.</div></td>
  </tr>
</table>';
	 
} else if  (trim($result) == 'Email Exists') { 

$Error = 'Sorry that email already exists in our database';

} else if  (trim($result) == 'User Exists') { 

$Error = 'Sorry that Username already exists. Try another.';

}

}
}
?>
<? include 'includes/header.php';?>
<div id="topbar">

<table id="topmenu" cellpadding="0px" cellspacing="0px;">
		<tr>
			<td id="startbutton"></td>
			<td class="buttonfield"><a href="index.php">
			<img alt="Home" src="images/Home.png" /></a></td>
           	<td id="buttonend"></td>
		</tr>
	</table>
          
	<div id="title">
		<img src="images/pf_logo_sm.jpg" /></div>
</div>
<div id="content">
  <? if ($Message == '') {?>
	<div class="graytitle">
		REGISTER</div> 
	<ul class="textbox">
		<li class="writehere">Please fill all fields out below to register for a Panel Flow User account.</li>
			</ul>
          <? } else {?>
          <div class="graytitle">
		REGISTRATION COMPLETE!</div> 
          <? }?>  
            <ul class="textbox">

     <div style="padding:5px;" align="center">
    <? if ($Message == '') {include 'includes/register_form.inc.php';} else { echo $Message;}?>
     </div>
            </ul>
	<div class="graytitle">
		Menu </div>
	<ul class="menu">
    <li><a href="comics.php"><img alt="" src="images/comic.png" /><span class="menuname">Browse Comics</span><span class="arrow"></span></a></li>
			<li><a href="creators.php"><img alt="" src="images/creator.png" /><span class="menuname">Creators</span><span class="arrow"></span></a></li>
        <? if (loggedin == 1) { ?>
		<li><a href="/profile/<? echo $Username;?>/"><img alt="" src="thumbs/help.png" /><span class="menuname">My Profile</span><span class="arrow"></span></a></li>
        <? }?>
        </ul>
	
</div>
<? include 'includes/footer.php';?>
