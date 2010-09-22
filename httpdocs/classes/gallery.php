<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class gallery {
	
		public function myTruncate($string, $limit, $break=".", $pad="...") { 

				if(strlen($string) <= $limit) return $string; 

				if(false !== ($breakpoint = strpos($string, $break, $limit))) { if($breakpoint < strlen($string) - 1) { $string = substr($string, 0, $breakpoint) . $pad; } }
				
				 return $string; 

		}
		
		public function getGallery($UserID,$Tags,$CatID,$Keywords,$Sort,$GalleryID) {
		
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
	
			$SELECT = "SELECT  u.username, u.avatar as UserThumb";
		
			$SELECT .= ", gi.Title as ItemTitle, gi.thumb as ItemThumb, gi.Image as ItemImage, gi.EncryptID as ItemID";
		
			$SELECT .= " from pf_gallery_content as gi";	  
		
		
			$JOIN .= " JOIN users as u on g.UserID=u.encryptid";
			$JOIN .= " JOIN pf_galleries as g on (g.UserID=u.encryptid and g.IsPortfolio=1)";
			
			$where = " where g.UserID='$UserID'";
		
			if ($CatID != '')
				$where .= " and gi.CategoryID='$CatID'";
				
			
			if ($Keywords != '') {
				$where .= "and (";
				$where .= " p.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
				$where .= " or ";
				$Gcount=0;
				foreach ($SearchTagsArray as $tag) {								
						$where .="p.tags LIKE '%".trim($tag)."%'";
						$Gcount++;
						if ($Gcount < $TotalKeywords)
							$where .=" or ";
													
				}
				$where .= ")";
			
			}

			if ($Sort == 'alpha') 
				$ORDERBY .= " ORDER BY p.title ASC";
			if ($Sort == 'new')
				$ORDERBY .= " ORDER BY p.createdate DESC";
			if ($Sort == 'updated')				
				$ORDERBY .= " ORDER BY p.PagesUpdated DESC";
			if ($Sort == 'rank'){	
				
				$ORDERBY .= " ORDER BY p.Ranking ASC";
			}
			
			echo "<div>";
			$counter = 0;
			//$LIMIT = ' LIMIT 160'; 
			$query = $SELECT . $JOIN . $where . $ORDERBY.$LIMIT;
			//print $query;
			$pagination->createPaging($query,$NumItemsPerPage);
		
			$AlreadyAdded = array();
			while($line=mysql_fetch_object($pagination->resultpage)) {
					$Results = 1;
					echo '<a href="http://www.wevolt.com/'.$line->GalleryImage.'"rel="pirobox[portfolio]"><img src="http://www.wevolt.com/'.$line->ThumbMd.'" border="2" vspace="5" hspace="5"></a>';
			}
			echo '</div>';
			$db->close();
			echo '<div class="cms_links" align="right">'.$pagination->displayPaging().'</div>';
			
			
		}
		
		public function getGalleryItem($UserID,$ItemID) {
		
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query ="SELECT * from pf_gallery_content where EncryptID='$ItemID' and UserID='$UserID'";
			$ItemArray = $db->queryUniqueObject($query);
			return $ItemArray;
		}

	}




?>