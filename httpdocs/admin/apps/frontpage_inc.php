<?
$catcheckdb = new DB();
//FRONTPAGE
if ((!isset($_GET['p'])) && (!isset($_GET['a']))) {
	if (($BlogFront == 0) && ($FrontGalleryVisible == 0) && ($StaticPageFront == 0)) {
		if ($ContentModule == 1) {
			if ($FrontContentCategories[0] == '') {
				$query = "select * from content where Published =1 order by CreationDate limit $NumArticles" ;
				$db->query($query);

				while ($line = $db->fetchNextObject()) { 
					$Filename = $line->Filename;
					$PostTitle = $line->Title;
					$CreationDate = $line->CreationDate;
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
			} else {
				$i=0;
				while ($i < $FrontCatCount) {
					$GetContentCategory = $FrontContentCategories[$i]; 
					$query = "select * from content where Category='$GetContentCategory' and Published =1 order by CreationDate"; 				
					$db->query($query);
					while ($line = $db->fetchNextObject()) { 
						$Filename = $line->Filename;
						$PostTitle = $line->Title;
						$Author = $line->Author;
						$PostID = $line->ID;
						$CreationDate = $line->CreationDate;
						$ContentSection = $line->Section;
						$query = "SELECT Title from categories where ID ='$GetContentCategory'";
						$CategoryTitle = $catcheckdb->queryUniqueValue($query);
						$query = "SELECT Title from sections where ID ='$ContentSection'";
						$SectionTitle = $catcheckdb->queryUniqueValue($query);
						$PageDay = substr($CreationDate, 8, 2); 
						$PageMonth = substr($CreationDate, 5, 2); 
						$PageYear = substr($CreationDate, 0, 4);
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
					$i++;
				}
		
			}
		}
	} else if ($BlogFront == 1){
			if ($FrontBlogCategories[0] == '') {
				$query = "SELECT * from pf_blog_posts order by CreationDate DESC limit $NumFrontBlogPosts";
					$db->query($query);
					while ($line = $db->fetchNextObject()) { 
						$PostTitle = $line->Title;
						$PageTitle = $PostTitle;
						$PostID = $line->ID;
						$Filename = $line->Filename;
						$Author = 		$line->Author;
						$PublishDate = 	$line->PublishDate;
						$PublishDate = 	$BlogArray->PublishDate;
						$Author = $line->Author;
						$Category->Category;
						$PageDay = substr($PublishDate, 3, 2); 
						$PageMonth = substr($PublishDate, 0, 2); 
						$PageYear = substr($PublishDate, 6, 4);
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
					$HtmlContent .= '<div class="posttitle"><a href=\'index.php?a=blog&p='.$PostID.'\'>'.$PostTitle.'</a></div>';
					$HtmlContent .= '<div class="blogdate">'.$DisplayMonth.'&nbsp;'.$DisplayDay.$DaySuffix.', '.$PageYear.' by '.$Author.', Posted in <a href="index.php?a=blog&cat='.$Category.'">'.$Category.'</a> | <a href="index.php?a=blog&p='.$BlogPost->ID.'&view=comments">'.$TotalComments.'<span class="menubullet">>></span></a></div>';
					$HtmlContent .= '<div class="blogpost">'.$BlogContent.'</div>';
					$HtmlContent .= '<div class="spacer"></div>';
					$HtmlContent .= '<div align="center"><div class="blogspacer"></div></div>';
					$HtmlContent .= '<div class="spacer"></div>';
			
					}
			} else {
				$i=0;
				while ($i <= $FrontBlogCatCount) {
					$GetBlogCategory = $FrontBlogCategories[$i]; 
					
				$query = "select * from pf_blog_posts where Category='$GetBlogCategory' order by CreationDate DESC";
					$BlogArray = $db->queryUniqueObject($query);
					$PostTitle = $BlogArray->Title;
					$Filename = $BlogArray->Filename;
					$PostID = $line->ID;
					$Author = 		$BlogArray->Author;
					$PublishDate = 	$BlogArray->PublishDate;
					$Category = $BlogArray->Category;
					$PageDay = substr($PublishDate, 3, 2); 
						$PageMonth = substr($PublishDate, 0, 2); 
						$PageYear = substr($PublishDate, 6, 4);
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
					$HtmlContent .= '<div class="posttitle"><a href=\'index.php?a=blog&p='.$PostID.'\'>'.$PostTitle.'</a></div>';
					$HtmlContent .= '<div class="blogdate">'.$DisplayMonth.'&nbsp;'.$DisplayDay.$DaySuffix.', '.$PageYear.' by '.$Author.', Posted in <a href="index.php?a=blog&cat='.$Category.'">'.$Category.'</a> | <a href="index.php?a=blog&p='.$BlogPost->ID.'&view=comments">'.$TotalComments.'<span class="menubullet">>></span></a></div>';
					$HtmlContent .= '<div class="blogpost">'.$BlogContent.'</div>';
					$HtmlContent .= '<div class="spacer"></div>';
					$HtmlContent .= '<div align="center"><div class="blogspacer"></div></div>';
					$HtmlContent .= '<div class="spacer"></div>';
					$i++;
				}
		
			}
	} else if ($FrontGalleryVisible == 1){
				$GalleryID = $FrontGallery;
				$ItemID =  $_GET['item'];
				$gallerydb = new DB();
				$query = "SELECT * from pf_gallery_galleries where id='$GalleryID'";
				$gallerydb->query($query);
				while ($line = $gallerydb->fetchNextObject()) { 
						$GalleryTitle = $line->Title;
						$PageTitle = $GalleryTitle;
						$GalleryDescription = $line->Description;
						$GalleryThumb = $line->GalleryThumb;
						$Items = 		$line->Items;
						$Description = 	$line->Description;
						$Template = 	$line->Template;
						$ThumbSize = 	$line->ThumbSize;
						$NumberOfRows = $line->NumberOfRows;
						$ThumbnailPlacement = $line->ThumbnailPlacement;
						$TopControl = $line->TopControl;
						$BottomControl = $line->BottomControl;
				}
			$query = "SELECT * from pf_gallery_content where galleryid='$GalleryID' order by CreationDate ASC";
				$gallerydb->query($query);
				$TotalContent = $gallerydb->numRows();
				$i=0;
				$IdArray = '';
				$ImageArray = '';
				while ($line = $gallerydb->fetchNextObject()) { 
					if ($i==0) {
						$IdArray = $line->ID;
						$ImageArray = $line->ThumbLg;
					} else {
						$IdArray .= ",".$line->ID;
						$ImageArray .= ",".$line->ThumbLg;
					}
					$CurrentIndex = $i;
					list($Width,$Height)=getimagesize($line->GalleryImage);
					$PageImage = $line->GalleryImage;
					$Description = $line->Description;
					$ContentTitle = $line->Title;
					$i++;

				}
			
	}else if ($StaticPageFront == 1){
			$query = "select * from pages where id='$StaticPage' limit 1";
			$db->query($query);
			while ($line = $db->fetchNextObject()) { 
				$Filename = $line->Filename;
				$PageTitle = $line->Title;
			}
			$HtmlContent = file_get_contents('content/page/'.$Filename);
	}
} 

?>