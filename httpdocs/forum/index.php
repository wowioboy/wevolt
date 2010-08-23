<?
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$PageTitle = 'wevolt | ';
$TrackPage = 1;
 $DebugIT = 0;

include_once("classes/forum_pagination.php");
$pagination    =    new pagination();  
$NumItemsPerPage = $_GET['count'];

if ($NumItemsPerPage == '')
	$NumItemsPerPage = 10;
include INCLUDES.'content_functions.php';
include 'includes/forum_functions_inc.php';
$Username = $_GET['user'];
$Project = $_GET['project'];
$SessionUser = $_SESSION['userid'];
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$DB2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
if ($Username != '') {
	$ForumType = 'user';
	if ($Username == 'w3volt')	
		$Username = 'wevolt';
	$query = "SELECT * from users where username='".trim($Username)."'";
	$UserArray = $DB->queryUniqueObject($query);
	$TargetName = trim($Username);
	$ProjectArray = array();
	$ForumThumb = $UserArray->avatar;
	$ForumName = $UserArray->username;
	$ProjectForum = false;
} else if ($Project != '') {
	$ForumType = 'project';
	$query = "SELECT * from projects where SafeFolder='".trim($Project)."' and ProjectType='comic'";
	$ProjectArray = $DB->queryUniqueObject($query);
	$query = "SELECT * from users where encryptid='".$ProjectArray->userid."'";
	$UserArray = $DB->queryUniqueObject($query);
	$TargetName = trim($Project);
	$ProjectID = $ProjectArray->ProjectID;
	$ForumThumb = 'http://www.wevolt.com'.$ProjectArray->thumb;
	$ForumName = $ProjectArray->title;
	$User->getInviteStatus($_SESSION['userid'],$ProjectID);
	$SafeFolder = trim($Project);
	$ProjectForum = true;
	
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
	
$query = "select count(*) from friends where ((UserID='$ForumOwner' and FriendID='".$_SESSION['userid']."') or (FriendID='$ForumOwner' and UserID='".$_SESSION['userid']."')) and Accepted=1 and FriendType='friend'";
$IsFriend = $DB->queryUniqueValue($query);
if ($IsFriend == 0) {
	if (!$ProjectForum) {
		$query = "select count(*) from follows where follow_id='$ForumOwner' and user_id='".$_SESSION['userid']."' and type='user'";
	} else {
		$query = "select count(*) from follows where follow_id='$ProjectID' and user_id='".$_SESSION['userid']."' and type='project'";
	}
	
	$IsFan = $DB->queryUniqueValue($query);
} else {
	$IsFan = 0;
}

if (($IsFriend == 0) || ($IsFriend == '')) {
	$IsFriend = false;
} else {
	$IsFriend = true;
}

if (($IsFan == 0) || ($IsFan == '')) {
	$IsFan = false;
} else {
	$IsFan = true;
}

if ($ForumOwner == $SessionUser)
	$AdminUser = true;
else
	$AdminUser = false;

if (($_GET['a'] == 'new_topic') && ($_POST['submitted'] == 1)) {
  PostTopic($_POST['txtBoard'],$_POST['txtTitle'] ,$_POST['content'],$_POST['txtSticky'], $_POST['txtLocked'], $_SESSION['userid'], $UserArray, $ProjectArray, $_POST['txtPrivacy'],$_POST['txtTags'],$_POST['txtNotify'], $_POST['txtGroups']);
  if ($_POST['txtRBoard'] == '')
  	$BID = $_POST['txtBoard'];
	else 
	$BID = $_POST['txtRBoard'];
 header("location:/forum/index.php?".$ForumType."=".$TargetName."&a=read&board=".$BID);
	
}

if (($_GET['a'] == 'reply') && ($_POST['submitted'] == 1)) {
  
 PostReply($_POST['txtTopic'],$_POST['txtTitle'] ,$_POST['content'],$_SESSION['userid'], $UserArray, $ProjectArray, $_POST['txtTags'],$_POST['txtNotify']);
  
  $RedirString = "/forum/index.php?".$ForumType."=".$TargetName."&a=read&topic=".$_POST['txtTopic']."&board=".$_POST['txtBoard'];
  if ($_POST['txtPage'] != '')
  	$RedirString .="&page=".$_POST['txtPage'];
	
	//if (($_SESSION['username'] != 'wevolt') && ($_SESSION['username'] != 'matteblack'))
			 header("location:".$RedirString);
	
}

if (($_POST['txtAction'] == 'modify') && ($_POST['submitted'] == 1)) {
 // PostTopic($_POST['txtBoard'],$_POST['txtTitle'] ,$_POST['content'],$_POST['txtSticky'], $_POST['txtLocked'], $_SESSION['userid'], $UserArray, $ProjectArray, $_POST['txtPrivacy'],$_POST['txtTags'],$_POST['txtNotify']);
  
  ModifyPost($_POST['txtTopic'],$_POST['txtMessage'],$_POST['txtTitle'] ,$_POST['content'],$_SESSION['userid'], $UserArray, $ProjectArray, $_POST['txtTags'],$_POST['txtNotify'],$_POST['txtSticky'], $_POST['txtLocked'],$_POST['txtPrivacy']);
  
 $RedirString = "/forum/index.php?".$ForumType."=".$TargetName."&a=read&topic=".$_POST['txtTopic']."&board=".$_POST['txtBoard'];
  if ($_POST['txtPage'] != '')
  	$RedirString .="&page=".$_POST['txtPage'];
	
 header("location:".$RedirString);
	
}

if (($TargetName == 'w3volt') || ($TargetName == 'wevolt'))
	$PageTitle .= 'Main Forum';
else
	$PageTitle .= $TargetName .' Forum';

$TrackPage = 1;
include INCLUDES.'header_template_new.php';
$Site->drawModuleCSS();
$Site->drawUpdateCSS();
?>

<LINK href="http://www.wevolt.com/forum/css/board.css" rel="stylesheet" type="text/css">
<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
   
   <td valign="top" <? if ($_SESSION['IsPro'] == 1) {?>width="60"<? } else {?>width="<? echo $SideMenuWidth;?>"<? }?>><? include INCLUDES.'site_menu_inc.php';?></td>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
         <center>
              
		 <? 
		 
		// if ((($_SESSION['username'] == 'matteblack') || ($_SESSION['username'] == 'jasonbadower')) && ($DebugIT == 0)) { 
		 $ForumTitle = $ForumName; 
		 
		 if (substr($ForumName,strlen($ForumName)-1,1) == 's') $ForumTitle.= "'"; else $ForumTitle.= "'s";
		if ($_GET['a'] != 'admin')
		 $Site->drawStandardModuleTop($ForumTitle.' Forum<div style="height:3px;"></div>', $_SESSION['contentwidth'], '', 12,'');?>
           <div style="padding:10px;">
<? 
if ((!isset($_GET['a'])) && (!isset($_GET['c']))) 
	$Home = true;
else 
	$Home = false;

BuildBreadCrumb($TargetName,$ForumType, $_GET['c'], $_GET['board'], $_GET['topic'],$_GET['a'],$Home,$AdminUser);
	
if (($_GET['a'] == '') && ($_GET['c'] == '')) {
	 BuildForumBoards($TargetName,$ForumType,$ForumOwner,$IsFriend,$IsFan,$AdminUser,$UserArray,$ProjectArray);
} else if ($_GET['a'] == 'read') {
 	if (($_GET['board'] != '')  && ($_GET['topic'] == '')) {
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
 window.location = '/forum/index.php?<? echo $ForumType;?>=<? echo $TargetName;?>';
 
 </script>
 <?
 }

//} else {?>

<!--<img src="http://www.wevolt.com/images/forum_soon.png" />-->
<? //}
?>
</div>
 <? 
 if ($_GET['a'] != 'admin')$Site->drawStandardModuleFooter();?>   
  
    		</center>
            </div>
            
 	</td>
	
</tr>
</table>
</div>
<?php include INCLUDES.'footer_template_new.php';?>






