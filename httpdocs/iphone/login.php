<?php include 'includes/init.php';
$PageTitle = 'User Login';
$Pass = $_POST['userpass'];
$Ref = $_GET['ref'];
if (isset($_POST['email'])) { 
$logresult = file_get_contents ('http://www.panelflow.com/processing/pfusers.php?action=logincrypt&email='.$_POST['email'].'&pass='.md5($Pass));
     if ((trim($logresult) != 'Not Logged') && (trim($logresult) != 'Not Verified'))
     {
	// print "MY LOG RESULT = ". $logresult."<br/>";
	 $_SESSION['userid'] = trim($logresult);
     $Useremail = $_POST['email']; 
	 $_SESSION['email'] = $Useremail;
	 $_SESSION['encrypted_email'] =  md5($Useremail);
	 	 
$getUser = file_get_contents ('http://www.panelflow.com/processing/pfusers.php?action=get&item=username&id='.trim($_SESSION['userid']));

$_SESSION['username'] = trim($getUser);
$getUser = file_get_contents ('http://www.panelflow.com/processing/pfusers.php?action=get&item=avatar&id='.trim($_SESSION['userid']));
 	   $_SESSION['avatar'] = $getUser;
	   if (isset($_GET['ref'])) {
	  	 header("Location:".$Ref);   	
	   } else {
	   	header("Location:/iphone/profile/".$_SESSION['username']."/");   	
	   }

     } else if (trim($logresult) == 'Not Verified'){     //$myUsername = 'John';
	 
	   $login_error = "Your account is not yet Verified. Please click the link sent to the email you registered with. If you did not recieve your email, please goto : http://www.panelflow.com/resend.php";
		
     } else if ($logresult == 'Not Logged'){     //$myUsername = 'John';
	 
	   $login_error = "Could Not Log into Account. Please check your fields and try again.";
	 	  
     } else {
	 $login_error = "There was an error logging into your account. Please check your fields and try again.";
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
	<div class="graytitle">
		LOGIN</div> 
	<ul class="textbox">
		<li class="writehere">Use your email address you registered with to login.</li>
			</ul>
     <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td>
    <?php include 'includes/login_form.inc.php';?>
	</td></tr></table>       
            
	<div class="graytitle">
		Menu </div>
	<ul class="menu">
    <li><a href="comics.php"><img alt="" src="images/comic.png" /><span class="menuname">Browse Comics</span><span class="arrow"></span></a></li>
			<li><a href="creators.php"><img alt="" src="images/creator.png" /><span class="menuname">Creators</span><span class="arrow"></span></a></li>
        <? if (loggedin == 1) { ?>
		<li><a href="/profile/<? echo $Username;?>/"><img alt="" src="thumbs/help.png" /><span class="menuname">My Profile</span><span class="arrow"></span></a></li>
        <? }?>
          <? if (loggedin != 1) { ?>
           <li><a href="register.php"><span class="menuname">Free Registration</span><span class="arrow"></span></a></li>
        <? }?>
	</ul>
	
</div>
<? include 'includes/footer.php';?>
