<?php 
header("location:/The_WEvolt_Blog/");
/*
include 'includes/init.php';
$PageTitle .= 'blog';
$TrackPage = 1;
$PostID = $_GET['id'];
if ($PostID == "") {
	$PostID = $_POST['id'];
}
if ($PostID == "undefined") {
	$PostID = "";
}
$BlogUserID = '64223ccf3b0';
$SideBarWidth = 300;

$CurrentDate = date('Y-m-d').' 00:00:00';

$query = "select count(*) from pfw_blog_posts where PublishDate='$CurrentDate' and UserID = '$BlogUserID' and ProjectID='abd81528278' ";
$TodayBlog = $InitDB->queryUniqueValue($query);


$query = "select PublishDate from pfw_blog_posts where PublishDate<='$CurrentDate' and UserID = '$BlogUserID' and ProjectID='abd81528278' order by PublishDate DESC";
$LatestBlog = date('m.d.y',strtotime($InitDB->queryUniqueValue($query)));


if ($TodayBlog > 0) {
	
$query = "select bp.*, bc.Title as CategoryTitle 
		  from pfw_blog_posts as bp
		  join pfw_blog_categories as bc on bp.Category=bc.EncryptID
		  where bp.PublishDate='$CurrentDate' and bp.UserID = '$BlogUserID'  and bp.ProjectID='abd81528278'";
$TodayBlogArray = $InitDB->queryUniqueObject($query);

}



$query = "select distinct bp.*,bc.Title as CategoryTitle from pfw_blog_posts as bp
		join pfw_blog_categories as bc on bp.Category=bc.EncryptID where bp.UserID = '$BlogUserID' and bp.ProjectID='abd81528278' and ";
		
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
$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
while ($setting = $InitDB->fetchNextObject()) { 
	
	$blog_array[$bcounter]->Title = $setting->Title;
	$blog_array[$bcounter]->Filename = $setting->Filename;
    $blog_array[$bcounter]->Author = $setting->Author;
	$blog_array[$bcounter]->Category = $setting->CategoryTitle;
	$blog_array[$bcounter]->EncryptID = $setting->EncryptID;
	$blog_array[$bcounter]->PublishDate = date('m-d-Y',strtotime($setting->PublishDate));	
	$query = "SELECT count(*) from blogcomments where PostID='".$setting->EncryptID."' and UserID='$BlogUserID'";
	$CommentCount = $db->queryUniqueValue($query);
	$blog_array[$bcounter]->CommentCount = $CommentCount;
	$bcounter++;
}
$db->close();


$query = "select * from pfw_blog_categories where UserID='$BlogUserID' and ProjectID='abd81528278' order by Title";
		$InitDB->query($query);
		$CatString ='<div class="sender_name">Blog Categories</div>';
		
		$CatString .='<div class="messageinfo">';
		while ($setting = $InitDB->fetchNextObject()) { 
			$CatString .='<a href="http://www.wevolt.com/blog.php?category='.urlencode($setting->Title).'">'.stripslashes($setting->Title).'</a><br/>';
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
					$CommentTag = '('.$CommentCounts.') Comments &nbsp;[<a href="http://www.wevolt.com/blog.php?id='.$blog_array[$StringCounter]->EncryptID.'/">READ</a>]';
				else 
					$CommentTag = '('.$CommentCounts.') Comment &nbsp;[<a href="http://www.wevolt.com/blog.php?id='.$blog_array[$StringCounter]->EncryptID.'/">READ</a>]';
					
				$BlogContent =file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/'.$blog_array[$StringCounter]->Filename);
				
				
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
					if (($_SESSION['usertype']> 0) || ($_SESSION['email'] == 'matt@outlandentertainment.com')){
						$BlogReaderString .='COMMENTS<br/>'. getPageCommentsAdmin ($Section, $_GET['post'], $ComicID,$db_database,$db_host, $db_user, $db_pass,$PFDIRECTORY,$TEMPLATE);
					} else {
						$BlogReaderString .= 'COMMENTS<br/>'. getPageComments ($Section, $_GET['post'], $ComicID,$db_database,$db_host, $db_user, $db_pass);
					}
					
				}
				
			
				$StringCounter++;
		} 

$BlogReaderString .='<div style="display:none;">'.$CommentBoxString.'</div>';

include 'includes/header_template_new.php';
$Site->drawModuleCSS();
?>
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
          <div class="spacer"></div>
          <table>
            <tr>
              <td>
              <center>
					 <? $Site->drawStandardModuleTop('WEVOLT BLOG<div style="height:3px;"></div>', $_SESSION['contentwidth'], '', 12,'');?>
                    <table width="100%"><tr><td valign="top" width="80%" style="padding-right:10px;"><? echo $BlogReaderString;?></td><td valign="top" style="padding-left:10px; border-left:#0066FF 1px solid;"><? echo $SidebarString;?></td></tr></table>  
                     <? $Site->drawStandardModuleFooter();?>   
  
    		</center>
            
 	</td>
	
</tr>
</table>
</div>
<?php include 'includes/footer_template_new.php';?>

*/?>


