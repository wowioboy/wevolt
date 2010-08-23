<? 
if ($_GET['a'] == 'blog') { 
$CurrentDate= date('D M j'); 
$CurrentDay = date('d');
$CurrentMonth = date('m');
$CurrentYear = date('Y');
		$query = "SELECT * from pf_blog";
		$BlogSettings = $db->queryUniqueObject($query);
		$BlogPosts = $BlogSettings->NumberOfPosts;
		$BlogTitle = $BlogSettings->BlogTitle;
		$ShowBlogSidebar = $BlogSettings->ShowSidebar;
		$AllowComments = $BlogSettings->AllowComments;
		$ShowCalendar = $BlogSettings->ShowCalendar;
		$HtmlContent = '<div class="blogtitle">'.$BlogTitle.'</div>';
		if (!isset($_GET['p'])) {
			$query = "SELECT * from pf_blog_posts order by ID DESC limit $BlogPosts";
			$db->query($query);
			$TotalPages = 0;
			while ($line = $db->fetchNextObject()) { 
						$Title = $line->Title;
						$PageTitle = $Title;
						$Filename = $line->Filename;
						$Author = 		$line->Author;
						$PublishDate = 	$line->PublishDate;
						$Category = $line->Category;
						$idSafe =0;
						$commentnumdb = new DB();
 						$Date = $line->datelive;
						$SafeID = $line->ID;
						$PageDay = substr($PublishDate, 3, 2); 
						$PageMonth = substr($PublishDate, 0, 2); 
						$PageYear = substr($PublishDate, 6, 4);
						$query ="SELECT ID from pf_blog_comments where PostID='$SafeID'";
						$commentnumdb->query($query);
						$TotalComments = $commentnumdb->numRows();
						
						if (($TotalComments > 1) ||($TotalComments == 0)) {
							$TotalComments = $TotalComments .' Comments';
						} else {
						$TotalComments = '1 Comment';
						}
						
						if ($PageMonth == '01'){
							$DisplayMonth = 'January';
						}
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
				if ($PageYear<$CurrentYear) {
					//print "SAFE ID = " .$SafeID."<br/>";
					$idSafe = 1; 
					$TotalPages++;
		   		} else if ($PageYear == $CurrentYear) {
							if ($PageMonth<$CurrentMonth) {
							//print "SAFE ID = " .$SafeID."<br/>"; 
								$idSafe = 1; 
							 	$TotalPages++;
						   } else if ($PageMonth == $CurrentMonth) {
								if ($PageDay<=$CurrentDay) {
									//print "SAFE ID = " .$SafeID."<br/>"; 
									$idSafe = 1; 
									$TotalPages++;
			        				} // End If
						   } // End PageMonth
		   		}
				
				if ($idSafe == 1) {
					$BlogContent = file_get_contents('blog/posts/'.$Filename);
					$HtmlContent .= '<div class="posttitle"><a href=\'index.php?a=blog&p='.$SafeID.'\'>'.$Title.'</a></div>';
					$HtmlContent .= '<div class="blogdate">'.$DisplayMonth.'&nbsp;'.$DisplayDay.$DaySuffix.', '.$PageYear.' by '.$Author.', Posted in <a href="index.php?a=blog&cat='.$Category.'">'.$Category.'</a> | <a href="index.php?a=blog&p='.$SafeID.'&view=comments">'.$TotalComments.'<span class="menubullet">>></span></a></div>';
					$HtmlContent .= '<div class="blogpost">'.$BlogContent.'</div>';
					$HtmlContent .= '<div class="spacer"></div>';
					$HtmlContent .= '<div align="center"><div class="blogspacer"></div></div>';
					$HtmlContent .= '<div class="spacer"></div>';
				}
			}
	 	} else {
		
			
				 $PostID = $_GET['p'];
				$query = "SELECT * from pf_blog_posts where id='$PostID'";
				$BlogPost = $db->queryUniqueObject($query);
				$Title = $BlogPost->Title;
				$PageTitle = $Title;
				$Filename = $BlogPost->Filename;
				$Author = 		$BlogPost->Author;
				$PublishDate = 	$BlogPost->PublishDate;
				$Category = $BlogPost->Category;
						$commentnumdb = new DB();
						$PageDay = substr($PublishDate, 3, 2); 
						$PageMonth = substr($PublishDate, 0, 2); 
						$PageYear = substr($PublishDate, 6, 4);
						$query ="SELECT ID from pf_blog_comments where PostID='$PostID'";
						$commentnumdb->query($query);
						$TotalComments = $commentnumdb->numRows();
						
						if (($TotalComments > 1) ||($TotalComments == 0)) {
							$TotalComments = $TotalComments .' Comments';
						} else {
						$TotalComments = '1 Comment';
						}
						
						if ($PageMonth == '01'){
							$DisplayMonth = 'January';
						}
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
				
				
				$BlogContent = file_get_contents('blog/posts/'.$Filename);
				$HtmlContent .= '<div class="posttitle"><a href=\'index.php?a=blog&p='.$PostID.'\'>'.$Title.'</a></div>';
				$HtmlContent .= '<div class="blogdate">'.$DisplayMonth.'&nbsp;'.$DisplayDay.$DaySuffix.', '.$PageYear.' by '.$Author.', Posted in <a href="index.php?a=blog&cat='.$Category.'">'.$Category.'</a> | <a href="index.php?a=blog&p='.$PostID.'&view=comments">'.$TotalComments.'<span class="menubullet">>></span></a></div>';
				if ($_GET['view'] != 'comments'){ 
					$HtmlContent .= '<div class="blogpost">'.$BlogContent.'</div>';
				}
				$HtmlContent .= '<div class="spacer"></div>';
				$HtmlContent .= '<div align="center"><div class="blogspacer"></div></div>';
				$HtmlContent .= '<div class="spacer"></div>';
			
		   	
		if (($AllowBlogComments == 1) && (isset($_GET['p']))) { 
				$HtmlContent .= GetBlogComments($_GET['p']);
			}
		}
	}
?>