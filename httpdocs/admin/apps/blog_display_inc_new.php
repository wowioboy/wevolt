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
			$query = "SELECT * from pf_blog_posts order by PublishDate DESC limit $BlogPosts";
			$db->query($query);
			$TotalPages = 0;
			while ($line = $db->fetchNextObject()) { 
						$Title = $line->Title;
						$PageTitle = $Title;
						$Filename = $line->Filename;
						$Author = 		$line->Author;
						$PublishDate = 	$line->PublishDate;
						$idSafe =0;
 						$Date = $line->datelive;
						$SafeID = $line]->ID;
						$PageDay = substr($PublishDate, 3, 2); 
						$PageMonth = substr($PublishDate, 0, 2); 
						$PageYear = substr($PublishDate, 6, 4);
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
			$BlogContent = file_get_contents('blog/posts/'.$Filename);
			$HtmlContent .= '<div class="blogtitle">'.$Title.'</div>';
			$HtmlContent .= '<div class="blogdate">'.$PublishDate.'</div>';
			$HtmlContent .= '<div class="spacer"></div>';
			$HtmlContent .= '<div class="blogpost">'.$BlogContent.'</div>';
			$HtmlContent .= '<div class="spacer"></div>';

		}
	
	}
?>