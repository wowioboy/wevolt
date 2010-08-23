<? 
if ($_GET['a'] == 'blog') { 
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
			while ($line = $db->fetchNextObject()) { 
						$Title = $line->Title;
						$PageTitle = $Title;
						$Filename = $line->Filename;
						$Author = 		$line->Author;
						$PublishDate = 	$line->PublishDate;
						$BlogContent = file_get_contents('blog/posts/'.$Filename);
						
						$HtmlContent .= '<div class="posttitle">'.$Title.'</div>';
						$HtmlContent .= '<div class="blogdate">'.$PublishDate.'</div>';
						$HtmlContent .= '<div class="spacer"></div>';
						$HtmlContent .= '<div class="blogpost">'.$BlogContent.'</div>';
						$HtmlContent .= '<div class="spacer"></div>';
			
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