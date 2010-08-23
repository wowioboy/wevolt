<?
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$PageTitle = 'wevolt | ';
$TrackPage = 1;

include_once("classes/forum_pagination.php");
$pagination    =    new pagination();  
$NumItemsPerPage = $_GET['count'];

if ($NumItemsPerPage == '')
	$NumItemsPerPage = 16;
include INCLUDES.'/content_functions.php';
include 'includes/forum_functions_inc.php';
$Username = $_GET['user'];
$Project = $_GET['project'];
$SessionUser = $_SESSION['userid'];
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$DB2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
if ($Username != '') {
	$ForumType = 'user';
	if ($Username == 'wevolt')	
		$Username = 'w3volt';
	$query = "SELECT * from users where username='".trim($Username)."'";
	$UserArray = $DB->queryUniqueObject($query);
	$TargetName = trim($Username);
	$ProjectArray = array();
	$ForumThumb = $UserArray->avatar;
	$ForumName = $UserArray->username;
} else if ($Project != '') {
	$ForumType = 'project';
	$query = "SELECT * from projects where SafeFolder='".trim($Project)."' and ProjectType='comic'";
	$ProjectArray = $DB->queryUniqueObject($query);
	$query = "SELECT * from users where encryptid='".$ProjectArray->userid."'";
	$UserArray = $DB->queryUniqueObject($query);
	$TargetName = trim($Project);
	$ProjectID = $ProjectArray->ProjectID;
	$ForumThumb = 'http://www.panelflow.com'.$ProjectArray->thumb;
	$ForumName = $ProjectArray->title;
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
 header("location:/forum/index.php?".$ForumType."=".$TargetName."&a=read&board=".$_POST['txtRBoard']);
	
}

if (($_GET['a'] == 'reply') && ($_POST['submitted'] == 1)) {
  
 PostReply($_POST['txtTopic'],$_POST['txtTitle'] ,$_POST['content'],$_SESSION['userid'], $UserArray, $ProjectArray, $_POST['txtTags'],$_POST['txtNotify']);
  

 header("location:/forum/index.php?".$ForumType."=".$TargetName."&a=read&topic=".$_POST['txtTopic']);
	
}

if (($_GET['a'] == 'modify') && ($_POST['submitted'] == 1)) {
  
  ModifyPost($_POST['txtMessage'],$_POST['txtTitle'] ,$_POST['content'],$_SESSION['userid'], $UserArray, $ProjectArray, $_POST['txtTags'],$_POST['txtNotify']);
  

  header("location:/forum/index.php?".$ForumType."=".$TargetName."&a=read&topic=".$_POST['txtTopic']);
	
}

if ($TargetName == 'w3volt')
	$PageTitle .= 'Main Forum';
else
	$PageTitle .= $TargetName .' Forum';

$TrackPage = 1;
include INCLUDES.'header_template_new.php';
$Site->drawModuleCSS();
?>



<LINK href="http://www.wevolt.com/forum/css/board.css" rel="stylesheet" type="text/css">
<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <? if ($_SESSION['IsPro'] == 1) {
           $_SESSION['noads'] = 1;
		?>
    <td valign="top" style="padding:5px; color:#FFFFFF;width:60px;"><? include 'includes/site_menu_popup_inc.php';?></td>
    <? } else {?>
    <td width="<? echo $SideMenuWidth;?>" valign="top"><? include 'includes/site_menu_inc.php';?></td>
    <? }?>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
         <center>
              
		 <? 
		 $ForumTitle = $ForumName; 
		 if (substr($ForumName,strlen($ForumName)-1,1) == 's') $ForumTitle.= "'"; else $ForumTitle.= "'s";
		 $Site->drawStandardModuleTop($ForumTitle.' Forum<div style="height:3px;"></div>', $_SESSION['contentwidth'], '', 12,'');?>
<? 
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
 window.location = '/forum/index.php?<? echo $ForumType;?>=<? echo $TargetName;?>';
 
 </script>
 <?
 }


?>
 <? $Site->drawStandardModuleFooter();?>   
  
    		</center>
            </div>
            
 	</td>
	
</tr>
</table>
</div>
<?php include INCLUDES.'includes/footer_template_new.php';?>






