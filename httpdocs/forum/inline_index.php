<? include '../includes/init.php';
include_once("classes/forum_pagination.php");  // include main class filw which creates pages
 $DebugIT = 0;
$pagination    =    new pagination();  
$NumItemsPerPage = $_GET['count'];
if ($NumItemsPerPage == '')
	$NumItemsPerPage = 16;
include '../includes/content_functions.php';
include 'includes/forum_functions_inc.php';
$Username = $_GET['user'];
$Project = $_GET['project'];
$SessionUser = $_SESSION['userid'];
$DB = new DB();
$DB2 = new DB();
if ($Username != '') {
	$ForumType = 'user';
	$query = "SELECT * from users where username='".trim($Username)."'";
	$UserArray = $DB->queryUniqueObject($query);
	$TargetName = trim($Username);
	$ProjectArray = array();
} else if ($Project != '') {
	$ForumType = 'project';
	$query = "SELECT * from projects where SafeFolder='".trim($Project)."'";
	$ProjectArray = $DB->queryUniqueObject($query);
	$query = "SELECT * from users where encryptid='".$ProjectArray->userid."'";
	$UserArray = $DB->queryUniqueObject($query);
	$TargetName = trim($Project);
	$ProjectID = $ProjectArray->ProjectID;
}
//Set Owner of Forum Board
$ForumOwner = $UserArray->encryptid;


$querystring = '';

$querystring .='&'.$ForumType.'='.$TargetName;

if (isset($_GET['rtid']))
	$querystring .='&rtid='.$_GET['rtid'];
	
if (isset($_GET['rmid']))
	$querystring .='&rmid='.$_GET['rmid'];	

if (isset($_GET['task']))
	$querystring .='&task='.$_GET['task'];	
	
if (isset($_GET['a']))
	$querystring .='&a='.$_GET['a'];	
	
if (isset($_GET['id']))
	$querystring .='&id='.$_GET['id'];
	
if (isset($_GET['topic']))
	$querystring .='&topic='.$_GET['topic'];

if (isset($_GET['msg']))
	$querystring .='&msg='.$_GET['msg'];

if (isset($_GET['board']))
	$querystring .='&board='.$_GET['board'];	
	
//BUILD A LIST OF USERS FRIENDS
$FriendList = array();
$query = "select FriendID, UserID from friends where (UserID='$ForumOwner' or FriendID='$ForumOwner') and Accepted=1 and FriendType='friend' and IsW3viewer!=1 ORDER BY ID";
$DB->query($query);
while ($friend = $DB->fetchNextObject()) { 
		$FriendID = $friend->FriendID;
		if ($FriendID == $ForumOwner) 
			$FriendID = $friend->UserID;
			
			$FriendList[] = $FriendID;
}
if ($FriendList == null) $FriendList = array();
//BUILD A LIST OF USERS FRIENDS
$FanList = array();
$query = "select UserID from friends where FriendID='$ForumOwner' and FriendType='fan' ORDER BY ID";
$DB->query($query);
while ($friend = $DB->fetchNextObject()) { 
		$FriendID = $friend->UserID;
		$FanList[] = $FriendID;
}
if ($FanList == null) $FanList = array();

if ($ForumOwner == $SessionUser)
	$AdminUser = true;
else
	$AdminUser = false;

if (in_array($SessionUser,$FriendList))
	$IsFriend = true;
else
	$IsFriend = false;

if (in_array($SessionUser,$FanList))
	$IsFan = true;
else
	$IsFan = false;


if (($_GET['a'] == 'new_topic') && ($_POST['submitted'] == 1)) {
  PostTopic($_POST['txtBoard'],$_POST['txtTitle'] ,$_POST['content'],$_POST['txtSticky'], $_POST['txtLocked'], $_SESSION['userid'], $UserArray, $ProjectArray, $_POST['txtPrivacy'],$_POST['txtTags'],$_POST['txtNotify']);
 header("location:index.php?".$ForumType."=".$TargetName."&a=read&board=".$_POST['txtRBoard']);
	
}

if (($_GET['a'] == 'reply') && ($_POST['submitted'] == 1)) {
  
 PostReply($_POST['txtTopic'],$_POST['txtTitle'] ,$_POST['content'],$_SESSION['userid'], $UserArray, $ProjectArray, $_POST['txtTags'],$_POST['txtNotify']);
  

 header("location:index.php?".$ForumType."=".$TargetName."&a=read&topic=".$_POST['txtTopic']);
	
}

if (($_GET['a'] == 'modify') && ($_POST['submitted'] == 1)) {
  
  ModifyPost($_POST['txtMessage'],$_POST['txtTitle'] ,$_POST['content'],$_SESSION['userid'], $UserArray, $ProjectArray, $_POST['txtTags'],$_POST['txtNotify']);
  

  header("location:index.php?".$ForumType."=".$TargetName."&a=read&topic=".$_POST['txtTopic']);
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORUM</title>
<LINK href="http://www.w3volt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<LINK href="http://www.w3volt.com/forum/css/board.css" rel="stylesheet" type="text/css">
<script type='text/javascript' src='/<? echo $PFDIRECTORY;?>/scripts/1-6-3-prototype.js'></script>
<script type='text/javascript' src='<? echo $PFDIRECTORY;?>/scripts/1-8-2scriptaculous.js'></script>
<link rel="stylesheet" type="text/css" href="/<? echo $PFDIRECTORY;?>/shadowbox/shadowbox.css">
<script type="text/javascript" src="/<? echo $PFDIRECTORY;?>/shadowbox/shadowbox.js"></script>

<style type="text/css">
#updateBox_T {
background-color:#e9eef4;
height:8px;
}

.updateboxcontent {
	color:#000000;
	background-color:#e9eef4;
}

#updateBox_B {
background-color:#e9eef4;
height:8px;
 
}


#updateBox_TL{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com/images/update_wrapper_TL.png);
	background-repeat:no-repeat;
}

#updateBox_TR{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com/images/update_wrapper_TR.png);
	background-repeat:no-repeat;
}

#updateBox_BR{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com/images/update_wrapper_BR.png);
	background-repeat:no-repeat;
}
#updateBox_BL{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com/images/update_wrapper_BL.png);
	background-repeat:no-repeat;
}

</style>
</head>

<body>
<div class="forum_wrapper" style="width:98%">

<? 

if (($_SESSION['username'] == 'matteblack') || ($DebugIT == 1)) { 
if ((!isset($_GET['a'])) && (!isset($_GET['c']))) 
	$Home = true;
else 
	$Home = false;

BuildBreadCrumb($TargetName,$ForumType, $_GET['c'], $_GET['board'], $_GET['topic'],$_GET['a'],$Home,$AdminUser);
	
if (($_GET['a'] == '') && ($_GET['c'] == '')) {
	 BuildForumBoards($TargetName,$ForumType,$ForumOwner,$IsFriend,$IsFan,$AdminUser,$UserArray,$ProjectArray);
} else if ($_GET['a'] == 'read') {
 	if ($_GET['board'] != '') {
			if ($_GET['topic'] == '')
				 BuildBoardTopics($TargetName,$ForumType,$ForumOwner,$IsFriend,$IsFan,$AdminUser,$UserArray,$ProjectArray,$_GET['board']);
			
				
	}  else if ($_GET['topic'] != '') {
			 BuildTopicMessages($TargetName,$ForumType,$ForumOwner,$IsFriend,$IsFan,$AdminUser,$UserArray,$ProjectArray,$_GET['topic']);
	
	}

 } else if ($_GET['a'] == 'new_topic') {
			include 'new_topic_template.php';
			
  } else if ($_GET['a'] == 'edit_topic') {
			include 'edit_topic_template.php';
			
  } else if ($_GET['a'] == 'modify') {
			include 'modify_message_template.php';
			
  } else if ($_GET['a'] == 'reply') {
			include 'reply_topic_template.php';
			
 } else if (($_GET['a'] == 'admin') and ($AdminUser)) {
		
		include 'admin/index.php';
			
 } else { ?>
 <script type="text/javascript">
 window.location = 'index.php?<? echo $ForumType;?>=<? echo $TargetName;?>';
 
 </script>
 <?
 }


?>
 </div>
 <script type="text/javascript">
Shadowbox.init();
</script>

<script type="text/javascript">
 //parent.document.getElementById("forumframe").style.height = '400px' ;

//alert(document.body.scrollHeight);
</script>
<? } else {?>
<img src="http://www.wevolt.com/images/forum_soon.png" />

<? }?>
</body>
</html>
