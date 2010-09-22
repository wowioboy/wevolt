<?php
if ($_GET['name'] == 'facebook') 
	header("location:/facebook/index.php");
	
if (($_GET['name'] == 'mattjacobs') ||($_GET['name'] == 'matthewjacobs') ||($_GET['name'] == 'panelflow')||($_GET['name'] == 'mattj')||($_GET['name'] == 'mjacobs')||($_GET['name'] == 'theunlisted'))
	header("location:/matteblack/");

if (($_GET['name'] == 'jasonb') ||($_GET['name'] == 'jbadower') ||($_GET['name'] == 'grael23'))
	header("location:/jasonbadower/");

include 'includes/init.php';
include 'includes/message_functions.php';
include 'includes/w3volt_functions.php';

$Name = $_GET['name'];
$ProjectType = $_GET['type'];

$MainWindowIDs = array();
//if ($ProjectType == '') {

	$query = "select * from users where username='$Name'"; 
	$ItemArray = $InitDB->queryUniqueObject($query);
	$UserID = $ItemArray->encryptid;
	$Email =   $ItemArray->email;
	$FeedOfTitle = $ItemArray->username;
	//print $query.'<br/>';
	//print $query.'<br/>';
	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID' and f.FeedType='w3'";
	$FeedArray = $InitDB->queryUniqueObject($query);

    $FeedID = $FeedArray->EncryptID;

if (($FeedID == '') && ($_SESSION['username'] == trim($_GET['name']))) {
	$NOW = date('Y-m-d h:i:s');
		$query = "INSERT into feed (Title, UserID, IsPublic, IsActive, CreatedDate, FeedType) values ('WEvolt page', '".$_SESSION['userid']."', 0, 1, '$NOW', 'w3')";
		$InitDB->execute($query);
		$query ="SELECT ID from feed WHERE UserID='".$_SESSION['userid']."' and CreatedDate='$NOW'";
		$NewID = $InitDB->queryUniqueValue($query);
		$Encryptid = substr(md5($NewID), 0, 12).dechex($NewID);
		$query = "UPDATE feed SET EncryptID='$Encryptid' WHERE ID='$NewID' and UserID='".$_SESSION['userid']."'";
		$InitDB->execute($query);
		$query = "INSERT into feed_settings (FeedID, TemplateID, Module1Title, Module2Title, Module3Title, Module4Title) values ('$Encryptid', '1', 'Window 1', 'Window 2','Window 3','Window 4')";
		$InitDB->execute($query);
		$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID' and f.FeedType='w3'";
		$FeedArray = $InitDB->queryUniqueObject($query);

    	$FeedID = $FeedArray->EncryptID;
		
}

if ($FeedID == '') 
	$NotSetup = 1;
else 
	$NotSetup=0;
//} else {
/*
	$query = "select * from projects where SafeTitle='$Name' and ContentType='$ProjectType'";
	$ItemArray = $DB->queryUniqueObject($query);
	$UserID = $UserArray->UserID;
	$ProjectID =  $UserArray->ProjectID;
	$FeedOfTitle = $ItemArray->SafeTitle;

	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.ProjectID='$ProjectID'";
	  
	$FeedArray = $DB->queryUniqueObject($query);
	
	
}*/



$query = "select count(*) from friends where (FriendID='$UserID' and UserID='".$_SESSION['userid']."') and Accepted=1 and FriendType='friend'";
$IsFriend = $InitDB->queryUniqueValue($query);
if ($IsFriend == 0) {
	$query = "select count(*) from friends where (FriendID='$UserID' and UserID='".$_SESSION['userid']."') and Accepted=0 and FriendType='friend'";
	$Requested = $InitDB->queryUniqueValue($query);
	$query = "select count(*) from follows where user_id='".$_SESSION['userid']."' and follow_id='$UserID' and type='user'";
	$IsFan = $InitDB->queryUniqueValue($query);
} else {
	$IsFan = 0;
}
if ($UserID == $_SESSION['userid'])
	$IsOwner = true;
else 
	$IsOwner = false;

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

if ($_GET['post'] != '') {
	//include_once($_SERVER['DOCUMENT_ROOT'].'/includes/comment_functions.php');
	$BlogOwner = $UserID;
	}
if ($_POST['insert'] == '1'){
	$Comment = new comment();
	if(($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] )) || ($_SESSION['userid'] == '')) {
		unset($_SESSION['security_code']);
		setcookie("seccode", "", time()+60*60*24*100, "/");
		if ($_POST['txtFeedback'] == ''){
			$_SESSION['commenterror'] = 'You need to enter a comment';
		} else if (($_SESSION['userid'] == '') && ($_POST['txtName'] == '')){
			$_SESSION['commenterror'] = 'Please enter a name';
		} else {
			if ($_SESSION['userid'] == '')
				$CommentUserID = 'none';
			else 
				$CommentUserID = trim($_SESSION['userid']);
			
			$CommentUsername = addslashes($_POST['txtName']);
		
			
				$Comment->blogComment($Section,$ProjectID, $_POST['targetid'], $CommentUserID, $_POST['txtFeedback'],$CommentUsername);?>
       
                 <script type="text/javascript">
					window.parent.location = 'http://users.wevolt.com/<? echo $_GET['name'];?>/?t=blog&post=<? echo $_GET['post'];?>';
                    </script>
		<?
			
		}
   } else {
		$_SESSION['commenterror'] = 'invalid security code. Try Again.';
   }
}

if ($_GET['t'] == '')
	$SubTitle = 'wevolt page';
else 
	$SubTitle = $_GET['t'];
	
$PageTitle = 'wevolt | '.$FeedOfTitle.' - '.$SubTitle;
$FeedID = $FeedArray->EncryptID;

if ($_GET['t'] == '') {
if ($NotSetup != 1) {
$FeedTemplate = $FeedArray->HtmlLayout;
$TotalLength = strlen($FeedTemplate);
$CurrentPosition = 0;
$WorkingString = $FeedTemplate;
	
$StillGoing = true;
$CellIDArray = array();
	
while ($StillGoing) {
			$StartPosition = strpos($WorkingString, "id=\"");
			$TempString = substr($WorkingString,$StartPosition+4, $TotalLength-1);
			$WalkingPosition = 0; 
			$EndPosition = strpos($TempString, "\">");
			$CellID = substr($TempString,$WalkingPosition, $EndPosition);
			if ($CellID != '')
				$CellIDArray[] = $CellID;
			$CurrentPosition = $EndPosition;
			$WorkingString = substr($TempString,$EndPosition,$TotalLength-1);
			$NewLength = strlen($WorkingString);
			if ($NewLength < 36)
				$StillGoing = false;
			
}


$query = "SELECT * from feed_settings where FeedID='$FeedID'";
$SettingsArray = $InitDB->queryUniqueObject($query);

$TemplateID = $SettingsArray->TemplateID;	
$query = "SELECT * from feed_templates where ID='$TemplateID'";
$TemplateArray = $InitDB->queryUniqueObject($query);

$ModuleTitleArray = array(array(
								'Title'=>$SettingsArray->Module1Title,
								'Width'=>$TemplateArray->Mod1Width,
								'Height'=>$TemplateArray->Mod1Height,
								'Template'=>$TemplateArray->Mod1Template,
								'Tabs'=>$TemplateArray->Mod1Tabs),
							array(
								'Title'=>$SettingsArray->Module2Title,
								'Width'=>$TemplateArray->Mod2Width,
								'Height'=>$TemplateArray->Mod2Height,
								'Template'=>$TemplateArray->Mod2Template,
								'Tabs'=>$TemplateArray->Mod2Tabs),
							array(
								'Title'=>$SettingsArray->Module3Title,
								'Width'=>$TemplateArray->Mod3Width,
								'Height'=>$TemplateArray->Mod3Height,
								'Template'=>$TemplateArray->Mod3Template,
								'Tabs'=>$TemplateArray->Mod3Tabs),
							array(
								'Title'=>$SettingsArray->Module4Title,
								'Width'=>$TemplateArray->Mod4Width,
								'Height'=>$TemplateArray->Mod4Height,
								'Template'=>$TemplateArray->Mod4Template,
								'Tabs'=>$TemplateArray->Mod4Tabs),
							array(
								'Title'=>$SettingsArray->Module5Title,
								'Width'=>$TemplateArray->Mod5Width,
								'Height'=>$TemplateArray->Mod5Height,
								'Template'=>$TemplateArray->Mod5Template,
								'Tabs'=>$TemplateArray->Mod5Tabs),
							array(
								'Title'=>$SettingsArray->Module6Title,
								'Width'=>$TemplateArray->Mod6Width,
								'Height'=>$TemplateArray->Mod6Height,
								'Template'=>$TemplateArray->Mod6Template,
								'Tabs'=>$TemplateArray->Mod6Tabs),
							array(
								'Title'=>$SettingsArray->Module7Title,
								'Width'=>$TemplateArray->Mod7Width,
								'Height'=>$TemplateArray->Mod7Height,
								'Template'=>$TemplateArray->Mod7Template,
								'Tabs'=>$TemplateArray->Mod7Tabs),
							array(
								'Title'=>$SettingsArray->Module8Title,
								'Width'=>$TemplateArray->Mod8Width,
								'Height'=>$TemplateArray->Mod8Height,
								'Template'=>$TemplateArray->Mod8Template,
								'Tabs'=>$TemplateArray->Mod8Tabs)
					);

$ModuleIndex=0;
foreach ($CellIDArray as $Cell) {
		$CellString = '';
		$CellString .= build_cell($line->Title,$line->ModuleTemplate, $line->EncryptID, $FeedID, $UserID, $Cell, $line->SortVariable,$line->ContentVariable, $line->SearchVariable, $line->SearchTags, $line->Variable1, $line->Variable2, $line->Variable3, $line->Custom, $line->NumberVariable, $line->ThumbSize);
				
		$FeedTemplate=str_replace("{".$Cell."}","<div style='padding-left:10px;padding-right:10px;'>".$CellString."</div>",$FeedTemplate);
		$FeedTemplate=str_replace("{".$Cell."Width}",$ModWidth,$FeedTemplate);
				
		$FeedTemplate=str_replace("{".$Cell."Height}",$ModHeight,$FeedTemplate);
		$ModuleIndex++;


}
$query = "select distinct e.Blurb, e.ContentID, e.ContentType, e.CreatedDate, e.Comment, e.Link, u.avatar, u.username, p.thumb
		 				 			 from excites as e
		 				 			 left join users as u on (e.ContentID=u.encryptid and e.ContentType='user')
						 			left join projects as p on (e.ContentID=p.ProjectID)
									where e.UserID='$UserID' order by e.CreatedDate DESC limit 1";
									$InitDB->query($query);
									$ExciteStatus = $InitDB->numRows();
								while ($ExciteArray = $InitDB->FetchNextObject()) {
								if ($ExciteArray->ContentType == 'user') 
										$Thumb = $ExciteArray->avatar;
									else 
										$Thumb = "http://www.wevolt.com".$ExciteArray->thumb;
										
										$ExciteString.="<table width='100%'><tr><td width='50' valign ='top'><img src='".$Thumb."' border='0' alt='LINK' style='border:solid #000000 1px;' width='50' align='left' hspace='5' vspace='5'></td><td  valign='top'><div class='sender_name'><a href='".$ExciteArray->Link."'>".$ExciteArray->Blurb."</a></div><div class='messageinfo'>".$ExciteArray->Comment."</div></td></tr></table>";
										
						
		
								}
	} else {
		$FeedTemplate = '<img  src="http://www.wevolt.com/images/tuts/no_wevolt.png">';
	}							
								
} else if ($_GET['t'] == 'excites') {

$query = "select distinct e.Blurb, e.ContentID, e.ContentType, e.CreatedDate, e.Comment, e.Target, e.Link, u.avatar, u.username, p.thumb as ProjectThumb, e.thumb as ExciteThumb
		 				 			 from excites as e
		 				 			 left join users as u on (e.ContentID=u.encryptid and e.ContentType='user')
						 			left join projects as p on (e.ContentID=p.ProjectID and ProjectID!='')
									where e.UserID='$UserID' order by e.CreatedDate DESC";
									$InitDB->query($query);
									
									while ($ExciteArray = $InitDB->FetchNextObject()) {
									
									if ($ExciteArray->ContentType == 'user') 
										$Thumb = $ExciteArray->avatar;
									else if ($ExciteArray->ContentType != '') 
										$Thumb = "http://www.wevolt.com".$ExciteArray->ProjectThumb;
									else  
										$Thumb = $ExciteArray->ExciteThumb;
										
										$FeedTemplate.="<table border='0' cellspacing='0' cellpadding='0' width='600'><tr>
										<td id=\"updateBox_TL\"></td>
										<td id=\"updateBox_T\"></td>
										<td id=\"updateBox_TR\"></td></tr>
										<tr><td class=\"updateboxcontent\"></td>
										<td valign='top' class=\"updateboxcontent\" width='584'><div class='updated_date' align='right'>".date('m-d-Y',strtotime($ExciteArray->CreatedDate))."</div><table width='100%'><tr><td width='100' valign='top'><img src='".$Thumb."' border='0' alt='LINK' style='border:solid #000000 1px;' width='94' align='left' hspace='5' vspace='5'></td><td  valign='top'><div class='sender_name'><a href='".$ExciteArray->Link."' target=\"".$ExciteArray->Target."\">".$ExciteArray->Blurb."</a></div><div class='messageinfo'>".$ExciteArray->Comment."</div></td></tr></table>";
										
						$FeedTemplate .= "</td><td class=\"updateboxcontent\"></td>
						</tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td>
						<td id=\"updateBox_BR\"></td>
						</tr></table>
						<div class='spacer'></div>";
						
						
										}
} else if ($_GET['t'] == 'projects') {
	$query = "select * from projects where installed = 1 and (CreatorID ='$UserID' or userid='$UserID') and ProjectType !='forum' and ProjectType != 'blog' ORDER BY title ASC";
//GET LIST OF COMICS USER ASSISTS
$counter = 0;
$FeedTemplate = "<table width='600'><tr>";
$InitDB->query($query);
$NumAssistComics = $InitDB->numRows();
    while ($line = $InitDB->fetchNextObject()) {  
	  		$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			$SafeFolder = $line->SafeFolder; 
			$ComicDir = $line->HostedUrl; 
 			$FeedTemplate .= "<td valign='top'><div align='center'><div class='comictitlelist'>".stripslashes($line->title)."</div><a href='http://www.wevolt.com/".$SafeFolder."/'><img src='http://www.wevolt.com/".$line->thumb."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='134' vspace='2' hspace='3'></a><div class='updated'>".$line->ProjectType."<br/>last updated: <br />
<b>".$Updated."</b></div></div></td>"; 
			 $counter++;
 				if ($counter == 5){
 					$FeedTemplate .= "</tr><tr>";
 					$counter = 0;
 				}
    }

	$FeedTemplate .= "</tr></table>";

} else if ($_GET['t'] == 'blog') {?>

<script type="text/javascript">
function submit_comment() {
		
	document.commentform.submit();

} 
</script>
<?

$PostID = $_GET['id'];
if ($PostID == "") {
	$PostID = $_POST['id'];
}
if ($PostID == "undefined") {
	$PostID = "";
}

$BlogUserID = $UserID;
$SideBarWidth = 300;

$CurrentDate = date('Y-m-d').' 00:00:00';

$query = "select count(*) from pfw_blog_posts where PublishDate='$CurrentDate' and UserID = '$BlogUserID'";
$TodayBlog = $InitDB->queryUniqueValue($query);


$query = "select PublishDate from pfw_blog_posts where PublishDate<='$CurrentDate' and UserID = '$BlogUserID'  order by PublishDate DESC";
$LatestBlog = date('m.d.y',strtotime($DB->queryUniqueValue($query)));


if ($TodayBlog > 0) {
	
$query = "select bp.*, bc.Title as CategoryTitle 
		  from pfw_blog_posts as bp
		  join pfw_blog_categories as bc on bp.Category=bc.EncryptID
		  where bp.PublishDate='$CurrentDate' and bp.UserID = '$BlogUserID'";
$TodayBlogArray = $InitDB->queryUniqueObject($query);

}



$query = "select distinct bp.*,bc.Title as CategoryTitle from pfw_blog_posts as bp
		join pfw_blog_categories as bc on bp.Category=bc.EncryptID where bp.UserID = '$BlogUserID' and ";
		
		if (isset($_GET['post']))
			$query .= "bp.EncryptID='".$_GET['post']."' ";
		else if (isset($_GET['category']))
			$query .= "bc.Title='".$_GET['category']."' ";
		else 	
		 $query .= "bp.PublishDate<='$CurrentDate' ";
		 
		$query .= "order by bp.PublishDate DESC";

$bcounter=0;
$blog_array = array();

$InitDB->query($query);

while ($setting = $InitDB->fetchNextObject()) { 
	
	$blog_array[$bcounter]->Title = $setting->Title;
	$blog_array[$bcounter]->Filename = $setting->Filename;
    $blog_array[$bcounter]->Author = $setting->Author;
	$blog_array[$bcounter]->Category = $setting->CategoryTitle;
	$blog_array[$bcounter]->EncryptID = $setting->EncryptID;
	$blog_array[$bcounter]->PublishDate = date('m-d-Y',strtotime($setting->PublishDate));	
	$query = "SELECT count(*) from blogcomments where PostID='".$setting->EncryptID."' and UserID='$BlogUserID'";
	$CommentCount = $DB->queryUniqueValue($query);
	$blog_array[$bcounter]->CommentCount = $CommentCount;
	$bcounter++;
}



$query = "select * from pfw_blog_categories where UserID='$BlogUserID' order by Title";
		$InitDB->query($query);
		$CatString ='<div class="sender_name">Blog Categories</div>';
		
		$CatString .='<div class="messageinfo">';
		while ($setting = $InitDB->fetchNextObject()) { 
			$CatString .='<a href="http://users.wevolt.com/'.trim($ItemArray->username).'?t=blog&category='.urlencode($setting->Title).'">'.stripslashes($setting->Title).'</a><br/>';
		}
		$CatString .='</div>';
$SidebarString =$CatString;

$StringCounter = 0;
		$BlogReaderString = '';
		
		///$BlogReaderString .=$SiteHeaderString;
		

		while($StringCounter <$bcounter) {
				
				$BlogReaderString .='<b>'.stripslashes($blog_array[$StringCounter]->Title).'</b><br/>';
				$CommentCounts = $blog_array[$StringCounter]->CommentCount;
				
				if ($CommentCounts == 0)
						$CommentTag ='';
				else if ($CommentCounts > 1) 
					$CommentTag = '('.$CommentCounts.') Comments &nbsp;[<a href="http://users.wevolt.com/'.trim($ItemArray->username).'?t=blog&post='.$blog_array[$StringCounter]->EncryptID.'/">READ</a>]';
				else 
					$CommentTag = '('.$CommentCounts.') Comment &nbsp;[<a href="http://users.wevolt.com/'.trim($ItemArray->username).'?t=blog&post='.$blog_array[$StringCounter]->EncryptID.'/">READ</a>]';
					
				$BlogContent =file_get_contents('http://www.wevolt.com/'.$blog_array[$StringCounter]->Filename);
				
				
				$content = $BlogContent;
				$content_lowercase = strtolower($content);
				$currpos = 0;
				$endpos = strlen($content);
				$newcontent = '';
				$lastimgtag = 0; 

				do
				{
					$imgStart = strpos($content_lowercase, '<img', $currpos);
					if ($imgStart === false) {

						break;
					} 
						
					else 
					{
						$imgEnd = strpos($content_lowercase, '>', $imgStart);
						$imageTag = substr($content, $imgStart, $imgEnd - $imgStart + 1);
						
						$newimgtag = CreateNewImgTag($imageTag);
						$newcontent .= substr($content, $lastimgtag, $imgStart - $lastimgtag);
						$newcontent .= $newimgtag;
						
						$lastimgtag = $imgEnd + 1;
						$currpos = $lastimgtag;
					}
				} while ($currpos < $endpos);
				
				if ($currpos != $endpos) 
					$newcontent .= substr($content, $currpos, $endpos);
					
				if ($newcontent != '')
					$BlogContent = $newcontent;
					
					
				
				$BlogReaderString .= 'posted: '.$blog_array[$StringCounter]->PublishDate.' by '.$blog_array[$StringCounter]->Author.'<br/>';
				
				
				$BlogReaderString .= '<div style="border-bottom:dashed #'.$ContentBoxTextColor.' 1px; padding-top:5px;padding-bottom:5px;">'.$BlogContent.'</div><div class="spacer"></div>';
				
				if (isset($_GET['post'])) {
					
					
					
					
					
					//if ($_SESSION['userid'] == $UserID){
						//$BlogReaderString .='COMMENTS<br/>'. getBlogCommentsAdmin ($_GET['post'], '',$UserID);
					//} else {
						//$BlogReaderString .= 'COMMENTS<br/>'. getBlogComments($_GET['post'], '',$UserID);
					//}
					
				$CommentBoxString ='<div class="spacer"></div><div id="commentbox">';
 				$CommentBoxString .='<div class="sender_name">Leave a Comment</div>';
   				$CommentBoxString .='<form method="POST" action="http://users.wevolt.com/'.$_GET['name'].'/?t=blog&post='.$_GET['post'].'" name="commentform" id="commentform">';
    			$CommentBoxString .='<textarea rows="6" style="width:98%" name="txtFeedback" onFocus="doClear(this);" id="txtComment">';
	 
					if ($_POST['txtFeedback']=='')
						$CommentBoxString .='enter a comment'; 
					else 
		 				$CommentBoxString .=$_POST['txtFeedback'];
					
	  				 $CommentBoxString .='</textarea><div class="spacer"></div>';
	  
				 	 if (!isset($_SESSION['userid'])) 
	  				 	$CommentBoxString .='NAME:<br/><input type="text" name="txtName" value="'.$_POST['txtName'].'"><div class="spacer"></div>';
	   
	    			 if (isset($_SESSION['userid'])) 
						 $CommentBoxString .='<div align="left">
             <table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="/captcha/CaptchaSecurityImages.php?width=100&height=40&characters=5" border=\'2\'/>'.
		'<label for="security_code"></label>'.
		'<br /></td><td style="padding-left:10px;"><input id="security_code" name="security_code" type="text" class="inputstyle" style="width:100px; background-color:#99FFFF; border:none;" onFocus="doClear(this)" value="enter code"/></td></tr></table></div>';
		 
	$CommentBoxString .='<input type="hidden" name="insert" id="insert" value="1">'.
	'<input type="hidden" name="userid" id="userid" value="'.$_SESSION['userid'].'">
	<input type="hidden" name="id" id="targetid" value="';
	
		$CommentBoxString .= $_GET['post'];
		
	$CommentBoxString .='"><div class="spacer"></div>';
	
	if ($CommentError != '') 
	$CommentBoxString .="<font style='color:red'>".$CommentError."</font><div class='spacer'></div><script language=\"Javascript\">alert('There was an error submitting comment, please check your fields and try again');</script>";


			$CommentBoxString .= '<input type="submit" value="SUBMIT COMMENT" style="cursor:pointer;" >';
	
  $CommentBoxString .='</div>';
					
				}
				
				$StringCounter++;
		} 

$BlogReaderString .='<div>'.$CommentBoxString.'</div>';
 $FeedTemplate='<table width="100%"><tr><td valign="top" width="80%" style="padding-right:10px;">'.$BlogReaderString.'</td><td valign="top" style="padding-left:10px; border-left:#0066FF 1px solid;">'.$SidebarString.'</td></tr></table>';  

} else if ($_GET['t'] == 'profile') {
	 $query = "select * from users_profile where UserID='$UserID'";
	 $where = " and ((PrivacySetting='public')";
	 if ($IsFriend)
	 	$where .= " or (PrivacySetting ='friends') or (PrivacySetting ='fans') ";
	 else if ($IsFan)
	 	$where .= " or (PrivacySetting ='fans') ";
	 else if ($IsOwner) 
	 	$where .= " or (PrivacySetting ='friends') or (PrivacySetting ='fans') or (PrivacySetting ='private') ";
	$where .=")";
	 $query .= $where ." order by InfoType, ID";
     $InitDB->query($query);
	 $LastType = '';
	
	 while ($profile = $InitDB->FetchNextObject()){
	 	//print $profile->InfoType.'<br/>';
		 switch($profile->RecordID) {
		 		case 'profile_blurb':
					  $ProfileBlurb = stripslashes($profile->LongComment);
					  $ProfileBlurbPrivacy = $profile->PrivacySetting;
					   $BasicInfo = true;
					  break;
				case 'sex':
					  $Sex = stripslashes($profile->LongComment);
					  $SexPrivacy = $profile->PrivacySetting;
					   $BasicInfo = true;
					  break;
				case 'about_me':
					  $About = stripslashes($profile->LongComment);
					  $AboutPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'hometown_location':
					  $HometownLocation = stripslashes($profile->LongComment);
					  $HometownLocationPrivacy = $profile->PrivacySetting;
					  $BasicInfo = true;
					  break;
				case 'current_location':
					  $Location = stripslashes($profile->LongComment);
					  $LocationPrivacy = $profile->PrivacySetting;
					   $BasicInfo = true;
					  break;
				case 'activities':
					  $Hobbies = stripslashes($profile->LongComment);
					  $HobbiesPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'music':
					  $Music = stripslashes($profile->LongComment);
					  $MusicPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'movies':
					  $Movies = stripslashes($profile->LongComment);
					  $MoviesPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'books':
					  $Books = stripslashes($profile->LongComment);
					  $BooksPrivacy = $profile->PrivacySetting;
					  break;
				case 'tv':
					  $TVShows = stripslashes($profile->LongComment);
					  $TVShowsPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'interests':
					  $Interests = stripslashes($profile->LongComment);
					  $InterestsPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'website':
					  $Website = stripslashes($profile->LongComment);
					  $WebsitePrivacy = $profile->PrivacySetting;
					   $ContactInfo = true;
					  break;
				case 'profile_url':
					  $FaceUrl = stripslashes($profile->LongComment);
					  $FaceUrlPrivacy = $profile->PrivacySetting;
					  $ContactInfo = true;
					  break;
				case 'education_history':
					  $Education = stripslashes($profile->LongComment);
					  $EducationPrivacy = $profile->PrivacySetting;
					   $CreditsInfo = true;
					  break;
				case 'work_history':
					  $WorkHistory = stripslashes($profile->LongComment);
					  $WorkHistoryPrivacy = $profile->PrivacySetting;
					   $CreditsInfo = true;
					  break;
				case 'twitter_name':
					  $TwitterName = stripslashes($profile->LongComment);
					  $TwitterNamePrivacy = $profile->PrivacySetting;
					   $ContactInfo = true;
					  break;
				case 'influences':
					  $Influences = stripslashes($profile->LongComment);
					  $InfluencesPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'credits':
					  $Credits = stripslashes($profile->LongComment);
					  $CreditsPrivacy = $profile->PrivacySetting;
					  $CreditsInfo = true;
					  break;
				case 'phone':
					  $Phone = stripslashes($profile->LongComment);
					  $PhonePrivacy = $profile->PrivacySetting;
					  $ContactInfo = true;
					  break;
				case 'self_tags':
					  $SelfTags = stripslashes($profile->LongComment);
					  break;
				case 'birthday_date':
					  $Birthday = $profile->LongComment;
					  $BirthdayPrivacy = $profile->PrivacySetting;
					   $BasicInfo = true;
					  break;
				case 'screennames':
					  $ScreenNames = stripslashes($profile->LongComment);
					  $ScreenNamesPrivacy = $profile->PrivacySetting;
					   $ContactInfo = true;
					  break;

		 }
	 }
	 
	  if (($Birthday == '') || (strlen($Birthday) < 5)) 
	  	  $Birthdate = explode('-',$user->birthdate);
	 else
	 	  $Birthdate = explode('-',$Birthday);
	 $BirthdayDay =$Birthdate[1];
	 $BirthdayMonth =$Birthdate[0];
	 $BirthdayYear =$Birthdate[2];
	 
	 if ($Music == '')
	 	$Music = stripslashes($user->music);
		
	 if ($Location == '')
 		 $Location = stripslashes($user->location);
		 
 	 if ($Books == '')
		 $Books = stripslashes($user->books);
		 
 	 if ($Hobbies == '')
		 $Hobbies = stripslashes($user->hobbies);
		 
 	 if ($Website == '') 	 
	 	 $Website= $user->website;
	 if ($About == '')
	    $About = stripslashes($user->about);
	 if ($Influences == '')
	   $Influences = $user->influences;
	 if ($TwitterName == '')
		 $TwitterName  = $user->Twittername; 
	if ($Credits == '') 
	 	$Credits = stripslashes($user->credits);
	 	   
	 $Status = $user->Status;
	 $TwitterCount = $user->TwitterCount;
	
	 if (substr($Website,0,3) == 'www') {
	 	$Website = 'http://'.$Website;
	 }
		
	 $IsCreator = $user->iscreator;
	 
	 
	 $Link1 = $user->link1;
	 if (substr($Link1,0,3) == 'www') {
	 	$Link1 = 'http://'.$Link1;
	 }
	 $Link2 = $user->link2;
	  if (substr($Link2,0,3) == 'www') {
	 	$Link2 = 'http://'.$Link2;
	 }
	 $Link3 = $user->link3;
	  if (substr($Link3,0,3) == 'www') {
	 	$Link3 = 'http://'.$Link3;
	 }
	 $Link4 = $user->link4;
	  if (substr($Link4,0,3) == 'www') {
	 	$Link4 = 'http://'.$Link4;
	 }
 	 if ($Sex == '')
	 	$Sex = $user->gender;
		
	 $AllowComments = $user->allowcomments;
	 $HostedAccount = $user->HostedAccount;
}

/*
//TWITTER MODULE 
<div align="left" style="padding-right:10px;">
    <? if ($Twittername != '') {?>
    <div id="twitter_div" style="width:100%; padding-right:10px;">
<div class="sidebar-title">Twitter Updates</div>
<div id="twitter_update_list"></div>
<div class="menubar"><a href="http://twitter.com/<? echo $Twittername;?>" id="twitter-link" style="display:block;text-align:right;">follow me on Twitter</a></div>
<div class="spacer"></div>
</div>
*/	 

$TrackPage = 1;

if ($IsFriend)
	$FriendStatus = 'Friend';
else if ($IsFan)
	$FriendStatus = 'Following';
else if ($Requested > 0)
	$FriendStatus = 'Requested';
else if (!$IsOwner)
	$FriendStatus = 'Add';
else 
	$FriendStatus = '';
?>

<?php include_once('includes/pagetop_inc.php');

$Tracker = new tracker();
$Remote = $_SERVER['REMOTE_ADDR'];
$IsUser = true;
$Referal = urlencode(substr($_SERVER['HTTP_REFERER'],7,strlen($_SERVER['HTTP_REFERER'])-1));
$Tracker->insertPageView($UserID,$Pagetracking,$Remote,$_SESSION['userid'],$Referal,$_SESSION['returnlink'],$_SESSION['IsPro'],$IsCMS,$IsUser);	

//$Site->drawModuleCSS();?>
<script 
  src="http://www.wevolt.com/scripts/twitterjs.js"
  type="text/javascript">
</script>

<script type="text/javascript">
function twitterCallback2(twitters) {
  		var statusHTML = [];
  		for (var i=0; i<twitters.length; i++){
    		var username = twitters[i].user.screen_name;
			var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, 		function(url) {
		  return '<a href="'+url+'">'+url+'</a>';
		}).replace(/\B@([_a-z0-9]+)/ig, 
		
		function(reply) {
		  return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
		});
		
		statusHTML.push('<div style="padding-right:10px;"><div style="padding-top:5px;padding-bottom:5px;border-bottom:1px solid #000000;"><span style="color:#000000;">'+status+'</span><span class="menubar"> <em><a style="font-size:85%" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id+'">'+relative_time(twitters[i].created_at)+'</a></em></span></div></div>');
	  }
	  document.getElementById('twitter_update_list').innerHTML = statusHTML.join('');
}

function relative_time(time_value) {

		  var values = time_value.split(" ");
		  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
		  var parsed_date = Date.parse(time_value);
		  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
		  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
		  delta = delta + (relative_to.getTimezoneOffset() * 60);
		
		  if (delta < 60) {
				return 'less than a minute ago';
		  } else if(delta < 120) {
				return 'about a minute ago';
		  } else if(delta < (60*60)) {
				return (parseInt(delta / 60)).toString() + ' minutes ago';
		  } else if(delta < (120*60)) {
				return 'about an hour ago';
		  } else if(delta < (24*60*60)) {
				return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
		  } else if(delta < (48*60*60)) {
				return '1 day ago';
		  } else {
				return (parseInt(delta / 86400)).toString() + ' days ago';
		  }	  
}



function mod_tab(value) {
	//alert(value);
   //GRAB CURRENT GROUP ID OF SELECTED DROPDOWN
	var moduletarget= value.split('-');
	var ModuleParent = moduletarget[0];
	
	var SelectedModule = moduletarget[1];
	//document.getElementById(ModuleParent+'_menu').innerHTML = document.getElementById(SelectedModule+'_menu_wrapper').innerHTML;
	
	var ModuleList = document.getElementById(ModuleParent+'_tabs').value;
	var TabArray = ModuleList.split(',');
	
		for(i=0; i<TabArray.length; i++){
			//alert('MODULE ID' + TabArray[i]);
			
			if (TabArray[i] != SelectedModule) {
				document.getElementById(TabArray[i]+'_div').style.display = 'none';
				document.getElementById(TabArray[i]+'_star').style.display = 'none';
				
			} else{
				document.getElementById(SelectedModule+'_div').style.display = '';
				document.getElementById(SelectedModule+'_star').style.display = '';
				
			}
			
		}

}

function show_menu(value) {
	document.getElementById(value).style.display = '';
			
}
function follow(ProjectID,UserID,Type) {
 
	attach_file('http://www.wevolt.com/connectors/follow_content.php?fid='+ProjectID+'&type='+Type); 
	document.getElementById("follow_project_div").innerHTML = '<img src="<? echo $_SESSION['avatar'];?>" width="50" height="50" border="2">';
	
}
</script>

<div align="left">
<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <? $Site->drawControlPanel('100%');?>
            </div>
        <? }?>
 <?  if ((($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1) || ($_SESSION['IsSuperFan'] == 1)) && ($_SESSION['sidebar'] == 'closed')) {?>
 <div id="pronav">
                <? $Site->drawProNav('100%');?>
 </div>
 <? }?>       

	<table cellpadding="0" cellspacing="0" border="0" id="container" width="100%">

	<tr><? if (($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1)) {
				$_SESSION['noads'] = 1;
			$FlashHeight = 1;
	} else {
			$_SESSION['noads'] = 0;
			$FlashHeight = 90;	
	} 
		?> 
        <? if ($_SESSION['sidebar'] == 'open') {?>
		<td valign="top" id="sidebar">
			<?  include 'includes/sidebar_inc.php';?>
		</td> 

        <? }?>
        <td  valign="top" align="<? if ($_SESSION['sidebar'] == 'open') {?>left<? } else {?>center<? }?>"  <? if ($_SESSION['sidebar'] == 'open') {?>rowspan="2"<? }?> valign="top">
        
		 <? 
	 if ($_SESSION['noads'] == 0) {?>
<center>
				  <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
                  </center>
           <? }?>
           
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_wevolt_modules_css.css">
 <div style="padding:10px;" style="width:<? echo $_SESSION['contentwidth'];?>px;" align="center">

				
    <table width="721" cellpadding="0" cellspacing="0">
   
    <tr>
  <? if ($_SESSION['userid'] != '') {?>
   <td style="background:url(http://www.wevolt.com/images/wevolt_dash_bg_left.png); font-size:10px; background-repeat:no-repeat; height:21px; width:80px;background-position:top left; color:#15528e;" align="center"><? if ($_SESSION['userid'] != '') {?><? if ($FriendStatus == 'Add'){?><div class="norm_tab_btn" onMouseOver="tab_btn_hover(this);" onMouseOut="tab_btn_norm(this);" onclick="network_wizard('<? echo $FeedOfTitle;?>','<? echo $_SESSION['userid'];?>','');"><span id="friend_status"><? echo $FriendStatus;?>&nbsp;&nbsp;</span></div><? } else { echo $FriendStatus;}?><? }?></td>
   <? }?>
   <td  style=" <? if ($_SESSION['userid'] != '') {?>background:url(http://www.wevolt.com/images/wevolt_dash_bg.png); background-repeat:repeat-x; height:21px; width:200px;<? } else {?>background:url(http://www.wevolt.com/images/wevolt_dash_bg_left.png); background-repeat:no-repeat;  height:21px; width:280px;<? }?>background-position:top left; color:#15528e; font-weight:bold; text-transform:uppercase; font-size:12px;" align="left">&nbsp;&nbsp;<? echo $FeedOfTitle;?><? if (strtolower(substr($FeedOfTitle,strlen($FeedOfTitle)-1,1)) != 's') echo"'s"; else echo "'";?> WEVOLT<div style="height:4px;"></div></td>
   
   <td style="background:url(http://www.wevolt.com/images/wevolt_dash_bg_right.png); background-repeat:no-repeat; height:21px; width:400px; background-position:top right;" align="right">
   
   &nbsp;&nbsp;
   <? if ($_GET['t'] != '') {?><a href='/<? echo trim($FeedOfTitle);?>/'><img src="http://www.wevolt.com/images/wevolt_btn.png" border="0" id="feed" onmouseover="roll_over(this, 'http://www.wevolt.com/images/wevolt_btn_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/wevolt_btn.png')"></a><? } else {?><img src="http://www.wevolt.com/images/wevolt_btn_over.png" border="0"  /><? }?>
  <? if ($_GET['t'] != 'projects') {?><a href='/<? echo trim($FeedOfTitle);?>/?t=projects'><img src="http://www.wevolt.com/images/revolts_btn.png" border="0" id="revolts" onmouseover="roll_over(this, 'http://www.wevolt.com/images/revolts_btn_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/revolts_btn.png')"></a><? } else {?><img src="http://www.wevolt.com/images/revolts_btn_over.png" border="0"  /><? }?>
   <a href='http://www.wevolt.com/w3forum/<? echo trim($FeedOfTitle);?>/'><img src="http://www.wevolt.com/images/myvolt_forum_btn.png" border="0" id="forum" onmouseover="roll_over(this, 'http://www.wevolt.com/images/myvolt_forum_btn_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/myvolt_forum_btn.png')"></a>
  <? if ($_GET['t'] != 'network') {?><a href='/<? echo trim($FeedOfTitle);?>/?t=network'><img src="http://www.wevolt.com/images/myvolt_network_btn.png" border="0" id="network" onmouseover="roll_over(this, 'http://www.wevolt.com/images/myvolt_network_btn_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/myvolt_network_btn.png')"></a><? } else {?><img src="http://www.wevolt.com/images/myvolt_network_btn_over.png" border="0"  /><? }?>
  <? if ($_GET['t'] != 'profile') {?><a href='/<? echo trim($FeedOfTitle);?>/?t=profile'><img src="http://www.wevolt.com/images/myvolt_profile_btn.png" border="0" id="profile" onmouseover="roll_over(this, 'http://www.wevolt.com/images/myvolt_profile_btn_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/myvolt_profile_btn.png')"></a><? } else {?><img src="http://www.wevolt.com/images/myvolt_profile_btn_over.png" border="0"  /><? }?>
   </td>
    </tr>

    </table>
    
			<div class="spacer"></div>
      
            
                 <?php
				if ($_GET['t'] == 'profile') {
					include 'includes/profile_wevolt_inc.php';
				} elseif ($_REQUEST['t'] == 'network') {
                 if ($IsFriend) {
                 	$Site->drawStandardModuleTop('Fans/Friends', '850');
                 } else {
				 	$Site->drawStandardModuleTop('Fans', '400');
                 }
                 echo '<div align="center">';
					$query = "select u.encryptid, u.username, u.avatar 
				  from follows f 
				  join users u 
				  on u.encryptid = f.user_id 
				  where f.follow_id='$UserID'  and f.type='user' order by u.username";
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
					$counter = 0;
					$FCount = 0;
					$FriendArray = $InitDB->query($query);
					while ($friend = $InitDB->fetchNextObject()) { 
						$fanString .= '<a href="http://users.wevolt.com/'.trim($friend->username).'/"><img src="'.$friend->avatar.'" border="2" alt="'.trim($friend->username).'" style="border-color:#000000;" width="50" height="50" vspace="5" hspace="5" tooltip="'.trim($friend->username).'"></a>';
							 $FCount++;
					}
					if ($FCount == 0) {
					 	$fanString .='<div align="center" id="follow_project_div">0 Fans<div class="spacer"></div><a href="javascript:void(0)" onclick="follow(\''.$UserID.'\',\''.$_SESSION['userid'].'\',\'user\')">BECOME A FAN!</a></div>';
					}
			if ($IsFriend) {
					
				$query = "select u.encryptid, u.username, u.avatar 
				  from friends f 
				  left join users u 
				  on u.encryptid = f.FriendID 
				  left join updates up 
				  on up.UserID = u.encryptid
				  where f.UserID='$UserID' and FriendType = 'friend' and Accepted = '1' and f.FriendID!='$UserID' 
				  group by u.username 
				  order by u.username asc";
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
					$counter = 0;
					$FCount = 0;
					$FriendArray = $InitDB->query($query);
					while ($friend = $InitDB->fetchNextObject()) { 
						$friendString .= '<a href="http://users.wevolt.com/'.trim($friend->username).'/"><img src="'.$friend->avatar.'" border="2" alt="'.trim($friend->username).'" style="border-color:#000000;" width="50" height="50" vspace="5" hspace="5" tooltip="'.trim($friend->username).'"></a>';
							 $FCount++;
					}
					if ($FCount == 0) {
					 	$friendString .='<center>No Friends yet.<br/>Go promote yourself!</center>';
					}
					$fanString = '<div style="display:inline-block;width:400px;vertical-align:top;"><b>FANS</b><br/>' . $fanString . '</div>';
					$friendString = '<div style="display:inline-block;width:400px;"><b>FRIENDS</b><br/>' . $friendString . '</div>';
					echo $fanString;
					echo $friendString;
				} else {
				
					echo $fanString;
				}
				echo '</div>';
			 	 $Site->drawStandardModuleFooter();
				
				} else {
				  echo $FeedTemplate;
				
				}
				  
				 
				  ?>
      </div>
      </td>
        
	</tr>
     <? if ($_SESSION['sidebar'] == 'open') {?>
   <tr>
    <td id="sidebar_footer"></td>
  </tr>
  <? }?>
</table>

</div>

<?php include 'includes/pagefooter_inc.php';

?>


