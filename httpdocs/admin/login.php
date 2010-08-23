<?php
include 'includes/init.php';
include 'processing/login_functions.php';
$loginDB = new DB();
$userhost ='localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb='panel_panel';
if (isset($_POST['email'])) { 
$logresult = LoginCrypt($_POST['email'], md5($_POST['userpass']),$userhost, $dbuser, $userpass, $userdb);
     if ((trim($logresult) != 'Not Logged') && (trim($logresult) != 'Not Verified'))
     {
	// print "MY LOG RESULT = ". $logresult."<br/>";
	
	$_SESSION['userid'] = trim($logresult);
	 $UserID =  $_SESSION['userid'];
	 $query ="SELECT * from users where encryptid='$UserID'";
	 $UserArray = $loginDB->queryUniqueObject($query);
     $Useremail =  $UserArray->email; 
	 $_SESSION['email'] = $Useremail;
	 $_SESSION['encrypted_email'] =  md5($Useremail);
	 $_SESSION['username'] =  $UserArray->username;
	 $_SESSION['adminaccount'] = $UserArray->AdminAccount;
	$_SESSION['avatar'] = $UserArray->avatar;
	if ($_SESSION['adminaccount'] == 1) {
		$_SESSION['usertype'] = 5;
		header("Location:/admin/admin.php");   
	} else {
		$_SESSION['usertype'] = 1;
		header("Location:/profile/".$_SESSION['username']."/");   
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
<? $Page = 'login';?>

<?php include 'includes/admin_header.php'; ?>

<div class="contentwrapper" align="center">
<div class="contentwrapper">



<table width="995" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="100%" valign="top" align='center'>

	

	<div id="login">
		<strong><?php include 'includes/login_form.inc.php';?></strong></div>
<script type="text/javascript">
		// <![CDATA[

		var so = new SWFObject("../loginMain.swf", "images", "200", "150", "8.0.23", true);
		so.addVariable('logerror','<?php echo $login_error;?>');
		so.write("login");

		// ]]>
	</script>
	

	</td>

  </tr>

</table>

</div>

</div>			

<?php include 'includes/footer.php'; ?>	