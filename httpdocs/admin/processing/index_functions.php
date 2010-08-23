<?

$Pagetracking = 'Home'; 
if ((!isset($_GET['a'])) && (!isset($_GET['p']))) {
$CurrentPage = 'front';
} else {
$CurrentPage = 'app';
}

$Page = urldecode ($_GET['p']);
$Application = $_GET['a'];
$CurrentDay = date('d');
$CurrentMonth = date('m');
$CurrentYear = date('Y');
$db = new DB();
// GALLERY APPLICATION
include 'apps/gallery_display_inc.php';
// FRONTPAGE 
include 'apps/frontpage_inc.php';
// BLOG CONTENT 
include 'apps/blog_display_inc.php';
if (($_GET['a'] == 'blog') && ($_POST['insert'] == 1)) {
   if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
		unset($_SESSION['security_code']);
		if ($_POST['txtName'] == '') {
			$CommentError = 'You need to enter a name';
		} else if ($_POST['txtComment'] == ''){
			$CommentError = 'You need to enter a comment';
		} else {
			PostBlogComment ($_POST['txtName'],$_POST['txtComment'],$_GET['p']);
			header("location:/index.php?a=blog&p=".$_GET['p']);
		}
   } else {
	$CommentError = 'invalid security code. Try Again.';
   }
}

// STATIC PAGES
	if ((isset($_GET['p'])) && (!isset($_GET['a']))) {
		$query = "select * from pages where title='$Page' limit 1";
			$db->query($query);
			while ($line = $db->fetchNextObject()) { 
				$Filename = $line->Filename;
				$PageTitle = $line->Title;
			}
	$HtmlContent = file_get_contents('content/'.$Filename);
	}
	
// CONTENT PAGES
	if ($_GET['a'] == 'content') {
		 if (isset($_GET['p'])) {
		 	$PostID = $_GET['p'];
			
			$query = "select * from content where id='$PostID' limit 1";
			$db->query($query);
			while ($line = $db->fetchNextObject()) { 
				$Filename = $line->Filename;
				$CreationDate = $line->CreationDate;
				$PostTitle  = stripslashes($line->Title);
				$PageTitle = $PostTitle;
				$PageDay = substr($CreationDate, 8, 2); 
				$PageMonth = substr($CreationDate, 5, 2); 
				$PageYear = substr($CreationDate, 0, 4);
				$ContentCategory = $line->Category;
					$ContentSection = $line->Section;
					$Author = $line->Author;
					$PageDay = substr($CreationDate, 8, 2); 
					$PageMonth = substr($CreationDate, 5, 2); 
					$PageYear = substr($CreationDate, 0, 4);
					$query = "SELECT Title from categories where ID ='$ContentCategory'";
					$CategoryTitle = $catcheckdb->queryUniqueValue($query);
					$query = "SELECT Title from sections where ID ='$ContentSection'";
					$SectionTitle = $catcheckdb->queryUniqueValue($query);
					if ($PageMonth == '02'){
						$DisplayMonth = 'February';}
					if ($PageMonth == '03'){
						$DisplayMonth = 'March';}
					if ($PageMonth == '04'){
						$DisplayMonth = 'April';}
					if ($PageMonth == '05'){
						$DisplayMonth = 'May';}
					if ($PageMonth == '06'){
						$DisplayMonth = 'June';}
					if ($PageMonth == '07'){
						$DisplayMonth = 'July';}
					if ($PageMonth == '08'){
						$DisplayMonth = 'August';}
					if ($PageMonth == '09')
						$DisplayMonth = 'September';
					if ($PageMonth == '10'){
						$DisplayMonth = 'October';}
					if ($PageMonth == '11'){
						$DisplayMonth = 'November';}
					if ($PageMonth == '12'){
						$DisplayMonth = 'December';}
					
					if ($PageDay == '01') {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='st';
					} else if ($PageDay == '02') {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='nd';
					} else if ($PageDay == '03') {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='rd';
					} else if (($PageDay == '04') || ($PageDay == '05') || ($PageDay == '06') || ($PageDay == '07') || ($PageDay == '08') || ($PageDay == '09')) {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='th';
					} else if (((intval($PageDay) > 9) && (intval($PageDay) < 21)) || ((intval($PageDay) > 23) && (intval($PageDay) < 31))) {
						$DisplayDay = $PageDay;
						$DaySuffix ='th';
					}else if  (($PageDay == '21') || ($PageDay == '31')){
						$DisplayDay = $PageDay;
						$DaySuffix ='st';
					}else if  ($PageDay == '22') {
						$DisplayDay = $PageDay;
						$DaySuffix ='nd';
					} else if  ($PageDay == '23') {
						$DisplayDay = $PageDay;
						$DaySuffix ='rd';
					}
					$Content = file_get_contents('content/posts/'.$Filename);
					$HtmlContent .= '<div class="posttitle"><a href=\'index.php?a=content&p='.$PostID.'\'>'.$PostTitle.'</a></div>';
					$HtmlContent .= '<div class="blogdate">'.$DisplayMonth.'&nbsp;'.$DisplayDay.$DaySuffix.', '.$PageYear.' by '.$Author.', Posted in <a href="index.php?a=content&cat='.$CategoryTitle.'">'.$CategoryTitle.'</a> |  <a href="index.php?a=content&s='.$SectionTitle.'">'.$SectionTitle.'</a><a href="index.php?a=content&p='.$line->ID.'&view=comments">'.$TotalComments.'<span class="menubullet">>></span></a></div>';
					$HtmlContent .= '<div class="blogpost">'.$Content.'</div>';
					$HtmlContent .= '<div class="spacer"></div>';
					$HtmlContent .= '<div align="center"><div class="blogspacer"></div></div>';
					$HtmlContent .= '<div class="spacer"></div>';
			}
		} else if (isset($_GET['s'])) {
		 	$SectionID = $_GET['s'];
			$query = "select * from content where Section ='$SectionID' order by CreationDate";
			$db->query($query);
			while ($line = $db->fetchNextObject()) { 
				$Filename = $line->Filename;
				$PostTitle = stripslashes($line->Title);
				$PageTitle = $PostTitle;
				$PostID = $line->ID;
				$CreationDate = $line->CreationDate;
				$PageDay = substr($CreationDate, 8, 2); 
				$PageMonth = substr($CreationDate, 5, 2); 
				$PageYear = substr($CreationDate, 0, 4);
			$ContentCategory = $line->Category;
					$ContentSection = $line->Section;
					$Author = $line->Author;
					$PageDay = substr($CreationDate, 8, 2); 
					$PageMonth = substr($CreationDate, 5, 2); 
					$PageYear = substr($CreationDate, 0, 4);
					$query = "SELECT Title from categories where ID ='$ContentCategory'";
					$CategoryTitle = $catcheckdb->queryUniqueValue($query);
					$query = "SELECT Title from sections where ID ='$ContentSection'";
					$SectionTitle = $catcheckdb->queryUniqueValue($query);
					if ($PageMonth == '02'){
						$DisplayMonth = 'February';}
					if ($PageMonth == '03'){
						$DisplayMonth = 'March';}
					if ($PageMonth == '04'){
						$DisplayMonth = 'April';}
					if ($PageMonth == '05'){
						$DisplayMonth = 'May';}
					if ($PageMonth == '06'){
						$DisplayMonth = 'June';}
					if ($PageMonth == '07'){
						$DisplayMonth = 'July';}
					if ($PageMonth == '08'){
						$DisplayMonth = 'August';}
					if ($PageMonth == '09')
						$DisplayMonth = 'September';
					if ($PageMonth == '10'){
						$DisplayMonth = 'October';}
					if ($PageMonth == '11'){
						$DisplayMonth = 'November';}
					if ($PageMonth == '12'){
						$DisplayMonth = 'December';}
					
					if ($PageDay == '01') {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='st';
					} else if ($PageDay == '02') {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='nd';
					} else if ($PageDay == '03') {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='rd';
					} else if (($PageDay == '04') || ($PageDay == '05') || ($PageDay == '06') || ($PageDay == '07') || ($PageDay == '08') || ($PageDay == '09')) {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='th';
					} else if (((intval($PageDay) > 9) && (intval($PageDay) < 21)) || ((intval($PageDay) > 23) && (intval($PageDay) < 31))) {
						$DisplayDay = $PageDay;
						$DaySuffix ='th';
					}else if  (($PageDay == '21') || ($PageDay == '31')){
						$DisplayDay = $PageDay;
						$DaySuffix ='st';
					}else if  ($PageDay == '22') {
						$DisplayDay = $PageDay;
						$DaySuffix ='nd';
					} else if  ($PageDay == '23') {
						$DisplayDay = $PageDay;
						$DaySuffix ='rd';
					}
					$Content = file_get_contents('content/posts/'.$Filename);
					$HtmlContent .= '<div class="posttitle"><a href=\'index.php?a=content&p='.$PostID.'\'>'.$PostTitle.'</a></div>';
					$HtmlContent .= '<div class="blogdate">'.$DisplayMonth.'&nbsp;'.$DisplayDay.$DaySuffix.', '.$PageYear.' by '.$Author.', Posted in <a href="index.php?a=content&cat='.$CategoryTitle.'">'.$CategoryTitle.'</a> |  <a href="index.php?a=content&s='.$SectionTitle.'">'.$SectionTitle.'</a><a href="index.php?a=content&p='.$line->ID.'&view=comments">'.$TotalComments.'<span class="menubullet">>></span></a></div>';
					$HtmlContent .= '<div class="blogpost">'.$Content.'</div>';
					$HtmlContent .= '<div class="spacer"></div>';
					$HtmlContent .= '<div align="center"><div class="blogspacer"></div></div>';
					$HtmlContent .= '<div class="spacer"></div>';
			}
			}else if (isset($_GET['c'])) {
		 	$CategoryID = $_GET['c'];
			$query = "select * from content where Category ='$CategoryID' order by CreationDate";
			$db->query($query);
			while ($line = $db->fetchNextObject()) { 
				$Filename = $line->Filename;
				$PostTitle = stripslashes($line->Title);
				$PageTitle = $PostTitle;
				$CreationDate = $line->CreationDate;
				$PostID = $line->ID;
				$PageDay = substr($CreationDate, 8, 2); 
				$PageMonth = substr($CreationDate, 5, 2); 
				$PageYear = substr($CreationDate, 0, 4);
				$ContentCategory = $line->Category;
					$ContentSection = $line->Section;
					$Author = $line->Author;
					$PageDay = substr($CreationDate, 8, 2); 
					$PageMonth = substr($CreationDate, 5, 2); 
					$PageYear = substr($CreationDate, 0, 4);
					$query = "SELECT Title from categories where ID ='$ContentCategory'";
					$CategoryTitle = $catcheckdb->queryUniqueValue($query);
					$query = "SELECT Title from sections where ID ='$ContentSection'";
					$SectionTitle = $catcheckdb->queryUniqueValue($query);
					if ($PageMonth == '02'){
						$DisplayMonth = 'February';}
					if ($PageMonth == '03'){
						$DisplayMonth = 'March';}
					if ($PageMonth == '04'){
						$DisplayMonth = 'April';}
					if ($PageMonth == '05'){
						$DisplayMonth = 'May';}
					if ($PageMonth == '06'){
						$DisplayMonth = 'June';}
					if ($PageMonth == '07'){
						$DisplayMonth = 'July';}
					if ($PageMonth == '08'){
						$DisplayMonth = 'August';}
					if ($PageMonth == '09')
						$DisplayMonth = 'September';
					if ($PageMonth == '10'){
						$DisplayMonth = 'October';}
					if ($PageMonth == '11'){
						$DisplayMonth = 'November';}
					if ($PageMonth == '12'){
						$DisplayMonth = 'December';}
					
					if ($PageDay == '01') {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='st';
					} else if ($PageDay == '02') {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='nd';
					} else if ($PageDay == '03') {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='rd';
					} else if (($PageDay == '04') || ($PageDay == '05') || ($PageDay == '06') || ($PageDay == '07') || ($PageDay == '08') || ($PageDay == '09')) {
						$DisplayDay = substr($PageDay,1,1);
						$DaySuffix ='th';
					} else if (((intval($PageDay) > 9) && (intval($PageDay) < 21)) || ((intval($PageDay) > 23) && (intval($PageDay) < 31))) {
						$DisplayDay = $PageDay;
						$DaySuffix ='th';
					}else if  (($PageDay == '21') || ($PageDay == '31')){
						$DisplayDay = $PageDay;
						$DaySuffix ='st';
					}else if  ($PageDay == '22') {
						$DisplayDay = $PageDay;
						$DaySuffix ='nd';
					} else if  ($PageDay == '23') {
						$DisplayDay = $PageDay;
						$DaySuffix ='rd';
					}
					$Content = file_get_contents('content/posts/'.$Filename);
					$HtmlContent .= '<div class="posttitle"><a href=\'index.php?a=content&p='.$PostID.'\'>'.$PostTitle.'</a></div>';
					$HtmlContent .= '<div class="blogdate">'.$DisplayMonth.'&nbsp;'.$DisplayDay.$DaySuffix.', '.$PageYear.' by '.$Author.', Posted in <a href="index.php?a=content&cat='.$CategoryTitle.'">'.$CategoryTitle.'</a> |  <a href="index.php?a=content&s='.$SectionTitle.'">'.$SectionTitle.'</a><a href="index.php?a=content&p='.$line->ID.'&view=comments">'.$TotalComments.'<span class="menubullet">>></span></a></div>';
					$HtmlContent .= '<div class="blogpost">'.$Content.'</div>';
					$HtmlContent .= '<div class="spacer"></div>';
					$HtmlContent .= '<div align="center"><div class="blogspacer"></div></div>';
					$HtmlContent .= '<div class="spacer"></div>';
			}
			
		}
	}
    
    ?>