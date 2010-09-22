<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class search {
	
		public function myTruncate($string, $limit, $break=".", $pad="...") { 

				if(strlen($string) <= $limit) return $string; 

				if(false !== ($breakpoint = strpos($string, $break, $limit))) { if($breakpoint < strlen($string) - 1) { $string = substr($string, 0, $breakpoint) . $pad; } }
				
				 return $string; 

		}
		
		public function getSearch($Content, $Genre, $Keywords,$Sort, $Filter) {
		
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			include_once($_SERVER['DOCUMENT_ROOT'].'/classes/jobs_pages.php');
			//include_once($_SERVER['DOCUMENT_ROOT']."/classes/search_pagination.php");  // include main class filw which creates pages
			$pagination    =    new pagination();  
			
			$QueryString = '';
			$TabQuery = '';
			$RunQuery = 0;
			
			if (($Keywords != '') && ($Keywords != 'enter keywords')) {
				$TabQuery .= '&keywords='.$Keywords;
				$RunQuery = 1;
			}
			
			if ($Sort != '') {
					$TabQuery .='&sort='.$Sort;
					$RunQuery = 1;
			}
			
			if ($Filter != '') {
					$TabQuery .='&filters='.$Filter;
					$RunQuery = 1;
			}
			
			if ($Content != '') {
					$QueryString .='&content='.$Content;
					$RunQuery = 1;
			}
	

			if ($Genre != '') {
					$TabQuery .='&genre='.$Genre;
					$RunQuery = 1;
			}
			$QueryString .= $TabQuery;
			$ContentSearch = '';
			$GenreSearch = '';
			$TagSearch= '';

			$SearchContentArray = explode(',',$Content);
			if ($SearchContentArray == null)
				$SeatchContentArray = array();
				
			$SearchGenreArray = explode(',',$Genre);
			if ($SearchGenreArray == null)
				$SearchGenreArray = array();
				
			$SearchTagsArray = explode(',',$Keywords);
			if ($SearchTagsArray == null)
				$SearchTagsArray = array();
				
			foreach ($SearchContentArray as $content) {
				if ($ContentSearch != '')
					$ContentSearch .= ',';
			
				$ContentSearch .= "'".$content."'";
			 
			}
			
			$TotalGenres = 0;
			foreach ($SearchGenreArray as $genre) {
				if ($genre != '') {
					if ($GenreSearch != '')
						$GenreSearch .= ',';
					$GenreSearch .= "'".$genre."'";
					$TotalGenres++;
				}
			}
			
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
			else if ($Sort == 'rank')
				$Listing = 'Ranking';
	
			$Results = 0;
			$NumItemsPerPage = $UserResultsNumber;
			$NumItemsPerPage = $_GET['c'];
			if ($NumItemsPerPage == '')
				$NumItemsPerPage = 24;
			
			$where = '';
 
			$ResultArray = array();
			
		
						
			$SELECT = "SELECT  u.username, u.avatar as UserThumb";
		
			$SELECT .= ", p.Title as ProjectTitle, p.genre as Genre, p.PagesUpdated, p.Ranking,
			(select p2.Title from projects as p2 where p.ProjectID=p2.ProjectID and p2.ProjectType='comic' and p.ProjectID != '') as RealTitle, 
			(select count(*) from follows as f where f.follow_id=p.ProjectID and f.type='project') as TotalFans,
			p.genre as genre, p.thumb as ProjectThumb, p.ProjectID as ProjectID, p.SafeFolder, p.ProjectType, p.SelectType, p.userid as ProjectUser, p.installed, p.Published";
		
			$SELECT .= " from projects as p";	  
		
		
			$JOIN .= " JOIN users as u on p.userid=u.encryptid";
			
			$where = " where p.ProjectType IN (".$ContentSearch.")";
		
			if (($TotalGenres > 0) && ($TotalKeywords>0)) {
				$where .= " and ((";
			} else if (($TotalGenres > 0) && ($TotalKeywords==0)) {
				$where .= " and (";
				
			} else if ($TotalKeywords>0) {
				$where .= " and (";
				
			}	
			if ($Keywords != '') {
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
			
			if (($TotalGenres > 0) && ($TotalKeywords>0)) 
				$where .= " or (";
		
			$Gcount=0;
			if ($TotalGenres >0) {
				foreach ($SearchGenreArray as $genre) {								
						$where .="p.genre LIKE '%".trim($genre)."%'";
						$Gcount++;
						if ($Gcount < $TotalGenres)
							$where .=" or ";
													
				}
				$where .= ")";
			}
			if (($TotalGenres > 0) && ($TotalKeywords>0)) 
			$where .= ")";
		
				$where .= " and p.installed = 1 and p.Published=1 and p.Hosted=1";
		
			
				
			if ($Sort == 'alpha') 
				$ORDERBY .= " ORDER BY p.title ASC";
			if ($Sort == 'new')
				$ORDERBY .= " ORDER BY p.createdate DESC";
			if ($Sort == 'updated')				
				$ORDERBY .= " ORDER BY p.PagesUpdated DESC";
			if ($Sort == 'rank'){	
				$where .= " and p.ShowRanking=1 ";
				$ORDERBY .= " ORDER BY p.Ranking ASC";
			}
			
			
		
			$SearchString =  "<table><tr>";
			$counter = 0;
			//$LIMIT = ' LIMIT 160'; 
			$query = $SELECT . $JOIN . $where . $ORDERBY.$LIMIT;
			//print $query;
			$pagination->createPaging($query,$NumItemsPerPage);
			echo '<div class="cms_links" align="right">'.$pagination->displayPaging().'</div>';
			$AlreadyAdded = array();
			while($line=mysql_fetch_object($pagination->resultpage)) {
					$Results = 1;
		
			$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			
			if ($line->ProjectThumb != ''){
				if (substr($line->ProjectThumb,0,4) != 'http') 
					$ProjectThumb = 'http://www.wevolt.com'.$line->ProjectThumb;
				else 
					$ProjectThumb =$line->ProjectThumb;
					
				$url=@getimagesize($ProjectThumb);
				if(!is_array($url))
					$ProjectThumb ="/images/no_thumb_project.jpg";
						
					
				if ($line->ProjectType == 'forum') {
					if ($line->SelectType == 'project') 
						$ProjectURL = 'http://www.wevolt.com/r3forum/'.$line->SafeFolder.'/';
					else 
						$ProjectURL = 'http://www.wevolt.com/w3forum/'.$line->username.'/';
				} else if ($line->ProjectType == 'comic'){
					$ProjectURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/';
				} else if ($line->ProjectType == 'writing'){
					$ProjectURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/';
				} else if ($line->ProjectType == 'blog') {
					if ($line->SelectType == 'project') 
						$ProjectURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/blog/';
					else 
						$ProjectURL = 'http://users.wevolt.com/'.$line->username.'/?t=blog';
				} 
					
					
			} else if ($line->UserThumb != ''){
				$ProjectThumb  = $line->UserThumb;
				if ($line->ProjectType == 'forum') {
						$ProjectURL = 'http://www.wevolt.com/w3forum/'.$line->username.'/blog/';
				} else if ($line->ProjectType == 'blog') {
						$ProjectURL = 'http://users.wevolt.com/'.$line->username.'/?t=blog';
				}
				
			} 
			
			if ($line->SelectType == 'project') 
				$ProjectTitle = $line->ProjectTitle;
			else
				$ProjectTitle = $line->username;
			$NoAdd = 0;
		
			$GenreArray = explode(',',$line->genre);
			$Genres = $GenreArray[0];
			if (trim($GenreArray[1]) != '')
				$Genres .= ', '.$GenreArray[1];
				$HeaderTitle = stripslashes($ProjectTitle);
				if ((($line->ProjectType == 'forum') || ($line->ProjectType == 'blog')) && ($line->SelectType == 'project')) {
					$ProjectTitle = '';
					$HeaderTitle = stripslashes($line->RealTitle);
				} else if ((($line->ProjectType == 'forum') || ($line->ProjectType == 'blog')) && ($line->SelectType == 'user')) {
					$ProjectTitle = '';
					$HeaderTitle = stripslashes($line->username);
				}
				
		
			$url=@getimagesize($ProjectThumb);
				if(!is_array($url))
					$ProjectThumb ="/images/no_thumb_project.jpg";	
						
			if ($NoAdd == 0) {
				$GenreArray = explode(',',$line->Genre);
				$GCount = 0;
				$GenreList  = '';
				if ($GenreArray != null) {
					while ($GCount <2) {
						if ($GenreArray[$GCount] != '') {
						if ($GenreList != '')
							$GenreList .= ','; 
							
								$GenreList .= trim($GenreArray[$GCount]);
					}
						$GCount++;
					}
					
				}
				
			
							$SearchString .= "<td valign='top' style='padding:5px;' onmouseover=\"parent.hide_layer('popupmenu',event);\"><div><table border='0' cellspacing='0' cellpadding='0' width='200'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='#' onclick='parent.window.location=\"".$ProjectURL."\";return false;'><img src='".$ProjectThumb."' border='0' alt='LINK' width='50' height='50'></a></td><td valign='top' onclick=\"parent.mini_menu('".addslashes($HeaderTitle)."','".$ProjectURL."','".$line->ProjectID."','search','',this, event);return false;\" class='navbuttons'><div class='sender_name'>".$HeaderTitle."</div><div class='messageinfo' style='font-size:10px;'>".$GenreList."<br/>Rank: ".$line->Ranking;
							if ($line->TotalFans != 0) 
								$SearchString .="<br/>Fans: ".$line->TotalFans;
						$SearchString .="</div></td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table></div></td>";
				 $counter++;
					if ($counter == 3){
						$SearchString .= "</tr><tr>";
						$counter = 0;
					}
			}		
				
	 }
 
 	if ($counter < 3) {
					while($counter < 3) {
						$SearchString .= "<td></td>";
						$counter++;
					}
				
	}
 $SearchString .= "</tr></table>";
 
			$db->close();
			
			return $SearchString;
			
		}
				
		
		  
	

	}




?>