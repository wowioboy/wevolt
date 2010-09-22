<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class gallery {
	
		public function myTruncate($string, $limit, $break=".", $pad="...") { 

				if(strlen($string) <= $limit) return $string; 

				if(false !== ($breakpoint = strpos($string, $break, $limit))) { if($breakpoint < strlen($string) - 1) { $string = substr($string, 0, $breakpoint) . $pad; } }
				
				 return $string; 

		}
		
		public function getPortfolioID($UserID) {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query ="SELECT EncryptID from pf_galleries where IsPortfolio=1 and UserID='$UserID'";
			$PortfolioID = $db->queryUniqueValue($query);
			if ($PortfolioID == '') {
				$CreatedDate = date('Y-m-d H:i:s');
				$query ="INSERT into pf_galleries 
												(UserID, GalleryType, Title, Description, PrivacySetting, CreatedDate, GalleryTemplate, GalleryReader, IsPortfolio)
													 values 
												('$UserID', 'image', 'Portfolio', 'Portfolio Gallery', 'public', '$CreatedDate', 'portfolio', 'itemview',1)";
												
					$db->execute($query);
					
					$query ="SELECT ID from pf_galleries where UserID='$UserID' and CreatedDate='$CreatedDate'";		
					$NewID = $db->queryUniqueValue($query);
					
					$Encryptid = substr(md5($NewID), 0, 15).dechex($NewID);
					$IdClear = 0;
					$Inc = 5;
					while ($IdClear == 0) {
						$query = "SELECT count(*) from pf_galleries where EncryptID='$Encryptid'";
						$Found = $db->queryUniqueValue($query);
						$output .= $query.'<br/>';
						if ($Found == 1) {
							$Encryptid = substr(md5(($NewID+$Inc)), 0, 15).dechex($NewID+$Inc);
						} else {
							$query = "UPDATE pf_galleries SET EncryptID='$Encryptid' WHERE ID='$NewID'";
							$db->execute($query);
							$output .= $query.'<br/>';
							$IdClear = 1;
						}
						$Inc++;
					}
					 $PortfolioID=$Encryptid;
			}
			$db->close();
			return $PortfolioID;
		}
		
		public function getGallery($UserID,$Tags,$CatID,$Keywords,$Sort,$GalleryID,$Username,$PerLine=3) {
		
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			include_once($_SERVER['DOCUMENT_ROOT'].'/classes/jobs_pages.php');
			//include_once($_SERVER['DOCUMENT_ROOT']."/classes/search_pagination.php");  // include main class filw which creates pages
			$pagination    =    new pagination();  
			
			
			$SearchTagsArray = explode(',',$Keywords);
			if ($SearchTagsArray == null)
				$SearchTagsArray = array();
	
			$TotalKeywords = 0;
			foreach ($SearchTagsArray as $tag) {
				if ($tag != '') {
					if ($TagSearch != '')
						$TagSearch .= ',';
					$TagSearch .= "'".$tag."'";
					$TotalKeywords++;
				}
			}
		
			
			if ($Sort == "") {
				$Sort = 'rank';
			}

			if ($Sort == 'alpha')
				$Listing = 'Title';
			else if ($Sort == 'new')
				$Listing = 'Creation Date';
			else if ($Sort == 'updated')
				$Listing = 'Last Updated';
				
			$Results = 0;
			$NumItemsPerPage = $UserResultsNumber;
			$NumItemsPerPage = $_GET['c'];
			if ($NumItemsPerPage == '')
				$NumItemsPerPage = 9;
			
			$where = '';
 
			$ResultArray = array();
			
			$SELECT = "SELECT  gi.Title as ItemTitle, gi.ThumbLg as ItemThumb, gi.EncryptID as ItemID, gi.InPortfolio, gi.FileType as ContentFrom
						from pf_gallery_content as gi
						where gi.GalleryID='$GalleryID'";
						if ($CatID != '')
							$SELECT .= " and gi.CategoryID='$CatID'";
				
			
			if ($Keywords != '') {
				$SELECT .= "and (";
				$SELECT .= " gi.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
				$SELECT .= " or ";
				$Gcount=0;
				foreach ($SearchTagsArray as $tag) {								
						$SELECT .="gi.tags LIKE '%".trim($tag)."%'";
						$Gcount++;
						if ($Gcount < $TotalKeywords)
							$SELECT .=" or ";
													
				}
				$SELECT .= ")";
				
			
			
			}
			//$SELECT .=" UNION
						//SELECT cp.Title as ItemTitle, cp.ThumbLg as ItemThumb, cp.EncryptPageID as ItemID, cp.InPortfolio, cp.PageType as ContentFrom
						//FROM comic_pages as cp
						//where cp.UploadedBy='$UserID' and cp.InPortfolio=1";


						echo '<div align="center">';
						echo  '<table cellspacing="40"><tr>';
			$counter = 0;
			//$LIMIT = ' LIMIT 160'; 
			$query = $SELECT . $JOIN . $where . $ORDERBY.$LIMIT;
			//print $query;
			$pagination->createPaging($query,$NumItemsPerPage);
		
			$AlreadyAdded = array();
			while($line=mysql_fetch_object($pagination->resultpage)) {
				echo "<td class=\"gallery_item\" align=\"center\">";
					$Results = 1;
					echo '<a href="'.$Username.'/?tab=profile&s=portfolio&item='.$line->ItemID;
					if ($line->ContentFrom == 'pages')
						echo '&from=comic';
					
					echo '"><img src="http://www.wevolt.com/'.$line->ItemThumb.'" width="100" border="2" vspace="5" hspace="5" style="border:#000 solid;"></a>';
			echo '</td>';
			$counter++;
					if ($counter == $PerLine){
						echo "</tr><tr>";
						$counter = 0;
					}
			}
			if ($counter < $PerLine) {
					while($counter < $PerLine) {
						echo "<td></td>";
						$counter++;
					}
				
	}
 			echo  "</tr></table>";
			echo '<div class="spacer"></div>';
			echo '<div class="blue_link" align="center">'.$pagination->displayPaging().'</div>';
			echo '</div>';
			$db->close();
			
			
			
		}
		
		public function getGalleryThumbs($ItemID, $GalleryID) {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				$query = "SELECT * from pf_gallery_content where GalleryID='$GalleryID' order by Position";
				$db->query($query);
				$ThumbArray = array ();
				while ($line = $db->fetchNextObject()) {
					   $ThumbArray[] = array('Thumb'=>$line->ThumbSm,'ID'=>$line->EncryptID,'Position'=>$line->Position);	
					
				}
				return $ThumbArray;
				$db->close();
			
		}
		
		public function getGalleryItem($UserID,$ItemID,$FromSection='gallery') {
		
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
		
			$query ="SELECT * from pf_gallery_content where UserID='$UserID' and EncryptID='$ItemID'";
			$ItemArray = $db->queryUniqueObject($query);
			
			$db->close();
			return $ItemArray;
		}
		
		public function getContentComments($ItemID) {
		
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			
			$query ="SELECT * from pf_comments where content_id='$ItemID' and content_type='gallery'";
			$db->query($query);
			while ($line = $db->fetchNextObject()) {
				
					
				
			}
			$db->close();
			return $ItemArray;
		}

	}




?>