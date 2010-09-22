<?php
ini_set('session.cookie_domain', '.wevolt.com');

if(!isset($_SESSION)) { 
    session_start();
} else if ($_COOKIE['userid']) {
	     session_start();
		$_SESSION['userid'] = $_COOKIE['userid'];
	
		$ShowBeta = false;
		$_SESSION['showbeta'] == 'off';
}

if ($_SESSION['username'] == 'matteblack') {
		// Carly 
		//$_SESSION['userid'] = '735b90b443';
		// barry $_SESSION['userid'] = 'fc221309b5';
		//Adam
		//$_SESSION['userid'] = '85422afb20e';
		
		//Riot
		//$_SESSION['userid'] = '37a749d898';  
		
		//Kennon$_SESSION['userid'] = 'b2eb7349132'; 
		
		//Matt Choi $_SESSION['userid'] ='fe8c15fe351'; 
		
		//The Unwanted$_SESSION['userid']='5e1b18c4c6a6d3153e';
		
		//Arcana $_SESSION['userid'] = '3ef8154155';
		
		//IAN$_SESSION['userid'] = '99c5e07b237';
		//KILLERZEES$_SESSION['userid'] = '571e0f7e46c';
		
		//72 Demons$_SESSION['userid'] ='97af4fb322bb4a0';
		

		
}

include $_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php';
include FUNCTIONS.'global.php';
include INCLUDES.'db.class.php';
include CLASSES.'tracker.php';
include CLASSES.'user.php';
include_once(CLASSES . 'WideImage/WideImage.php');

/*
if(($_COOKIE['cookmail'] != '') && ($_COOKIE['cookpass'] != '')){
	$_SESSION['email'] = $_COOKIE['cookmail'];
	//$_SESSION['encrypted_email'] = $_COOKIE['cryptmail'];
	$_SESSION['username'] = $_COOKIE['cookname'];
	$_SESSION['password'] = $_COOKIE['cookpass'];
	print_r($_SESSION);
	$logresult = file_get_contents ('https://www.wevolt.com/processing/pfusers.php?action=logincrypt&email='.$_SESSION['email'].'&pass='.$_SESSION['password']);
	//print 'Log result = ' . $logresult;
	 if ((trim($logresult) == 'Not Logged') || (trim($logresult) == 'Not Verified')){
		 session_unset();
		session_destroy(); 
		if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
			setcookie("cookname", "", time()+60*60*24*100, "/");
			setcookie("cookmail", "", time()+60*60*24*100, "/");
			setcookie("cookpass", "", time()+60*60*24*100, "/");
			setcookie("cryptmail", "", time()+60*60*24*100, "/");
		}
	 	header("/login/");
	} else {
		$_SESSION['userid'] = $logresult;
		
	}
}
*/ 
$User = new user($_SESSION['userid']);

if ($Content != 'comic')
	$SideMenuWidth = 300; 
else 
	$SideMenuWidth = 66;
 
$DEBUG=true;

if ($DEBUG) {
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL ^ E_NOTICE);
}


//ADD SITE ADMINS HERE
$SiteAdmins = array('d67d8ab427','7e7757b1a6','d61e4bbd1c1','9778d5d252','a8c88a00134','44f683a83e','00ac8ed3262');

$PageTitle = 'WEvolt | ';


$InitDB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

if ($IsCMS) {
	include CLASSES.'cms.php';
	
	if ($_GET['id']!= '') {
			$CMS = new cms($_GET['id']);
			$ProjectSet = 1;
	} else if (isset($_POST['txtComic'])) {
			$CMS = new cms($_POST['txtComic']);
			$ProjectSet = 1;
	} else if ($_POST['sessionproject'] != '') {
			$CMS = new cms($_POST['sessionproject']);
			$ProjectSet = 1;
	} else {
			$CMS = new cms();
			$ProjectSet = 0;
	}
	
	$AdminUserArray = $CMS->getAdminInfo();
	$AdminUser = $AdminUserArray['Name'];
	$AdminEmail =  $AdminUserArray['Email']; 
	$AdminUserID =  $AdminUserArray['UserID']; 
	
	if ($ProjectSet == 1) {
		$ComicArray = $CMS->getCmsProjectInfo();
		$ComicTitle = $ComicArray->title;
		$ComicFolder = $ComicArray->HostedUrl;
		$ComicAdmin = $ComicArray->userid;
		$SafeFolder = $ComicArray->SafeFolder;
		$CreatorID = $ComicArray->CreatorID;
		$AdminUserID = $ComicArray->userid;
		$_SESSION['projectadmin'] = $AdminUserID;
		$ComicID = $ComicArray->comiccrypt;
		$ExternalUrl = $ComicArray->url;
		$CreatorEmail = $ComicArray->Email;
		$Assistant1 = $ComicArray->Assistant1;
		$Assistant2 = $ComicArray->Assistant3;
		$Assistant3 = $ComicArray->Assistant2;
		$ProjectType = $ComicArray->ProjectType;
		$OwnerID = $ComicArray->userid;
		$Hosted = $ComicArray->Hosted;
		$ProjectID = $ComicArray->ProjectID;
		$CurrentTemplate = $ComicArray->Template;
		$CurrentTheme = $ComicArray->CurrentTheme;
		$CurrentSkin= $ComicArray->Skin;
		$ProjectDirectory = $ComicArray->ProjectDirectory;
		$ComicDirectory = stripslashes($ComicArray->HostedUrl);
		$ProjectStats = $CMS->getProjectRanking();
		$InstalledSections = $CMS->getInstalledSections();
	
	}
	$CreatorProjects = $CMS->getCreatorProjects();
	if ((sizeof($CreatorProjects) > 0) && ($_SESSION['IsPro'] == 0))
		$CreateComic = false;
	else  
		$CreateComic = true;
	$AssistantProjects =  $CMS->getAssistantProjects();
	
	$AdminAuth = false;
	
	if (in_array($ProjectID,$CreatorProjects))
		$AdminAuth = true;
	
	if (in_array($ProjectID,$AssistantProjects))
		$AdminAuth = true;

	if ((!$AdminAuth) && ($ProjectSet == 1))
		header("location:/cms/admin/");
		
}


if (!$IsProject) {
	$PFDIRECTORY = 'pf_16_core';
} else {

	include_once($_SERVER['DOCUMENT_ROOT'].'/includes/project_functions_oo.php');

}

$_SESSION['pfdirectory'] = 	$PFDIRECTORY;




//$_SESSION['IsPro'] = 0;
?>
