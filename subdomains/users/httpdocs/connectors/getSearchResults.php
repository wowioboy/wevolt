<? include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php'; 

$DB = new DB();


$ContentSearch = '';
$GenreSearch = '';
$TagSearch= '';

if (($_GET['content'] == '') && (isset($_GET['t'])))
	$SearchContentArray = array($_GET['t']);
else
	$SearchContentArray = explode(',',$_GET['content']);


$SearchSubContentArray = explode(',',$_GET['sub']);
if ($SearchSubContentArray == null)
	$SearchSubContentArray = array();
$SearchCreatorArray = explode(',',$_GET['creator']);
$SearchGenreArray = explode(',',$_GET['genre']);
$SearchTagsArray = explode(',',$_GET['keywords']);
foreach ($SearchContentArray as $content) {
	if ($ContentSearch != '')
		$ContentSearch .= ',';

 	$ContentSearch .= "'".$content."'";
 
}


foreach ($SearchSubContentArray as $content) {
	if ($SubContentSearch != '')
		$SubContentSearch .= ',';

 	$SubContentSearch .= "'".$content."'";
 
}

foreach ($SearchGenreArray as $genre) {
	if ($GenreSearch != '')
		$GenreSearch .= ',';
 	$GenreSearch .= "'".$genre."'";
}
foreach ($SearchTagsArray as $tag) {
	if ($TagSearch != '')
		$TagSearch .= ',';
 	$TagSearch .= "'".$tag."'";
}
//$Genre = $_GET['genre']; 
$search = $_GET['keywords'];
//$genreString = $Genre;
 
$sort = $_GET['sort']; 
if ($sort == "") {
$sort = 'alpha';
}

if ($sort == 'alpha')
	$Listing = 'Title';
else if ($sort == 'new')
	$Listing = 'Creation Date';
else if ($sort == 'updated')
	$Listing = 'Last Updated';
else if ($sort == 'rank')
	$Listing = 'Ranking';
	
$Results = 0;




$where = '';


	$SELECT = "SELECT  u.username, u.avatar as UserThumb, u.encryptid as PUserID, u.about as UserAbout";
	
	if ($_GET['content'] != 'user') 
		$SELECT .= ", p.Title as ProjectTitle, (select p2.Title from projects as p2 where p.ProjectID=p2.ProjectID and p2.ProjectType='comic' and p.ProjectID != '') as RealTitle, p.genre as genre, p.thumb as ProjectThumb, p.ProjectID as ProjectID, p.SafeFolder, p.ProjectType, p.SelectType, p.Tags as ProjectTags, p.synopsis, p.userid as ProjectUser, p.installed, p.Published";
	else 
		$SELECT .= ", up.LongComment as Tags";
		
	if (isset($_GET['sub']))
		$SELECT .= ", pc.Title as ContentTitle, pc.Tags as ContentTags, pc.Thumb as ContentThumb, pc.ContentType,  pc.ContentID, pc.ProjectID as OwningProject";
		
	//if (in_array('blogs',$SearchContentArray)) 
	//	$SELECT .= ", b.Title as BlogTitle, b.thumb as BlogThumb";
	
	//if (in_array('forum',$SearchContentArray)) 
		//$SELECT .= ", fb.Title as ForumTitle";
	
	//if (in_array('characters',$SearchSubContentArray)) 
		//$SELECT .= ", ch.Name as CharacterName, ch.thumb as CharThumb";
	
	//if (in_array('downloads',$SearchSubContentArray)) 	
		//$SELECT .= ", dl.Name as DownTitle, dl.thumb as DownThumb";

	if ((($_GET['content'] != '') || (isset($_GET['t']))) && (!isset($_GET['sub']))) {
	if ($_GET['content'] != 'user') 
		$SELECT .= " from projects as p";	  
	else 
		$SELECT .= " from users as u";	
	}else {
		$SELECT .= " from project_content as pc";
	}
	if (isset($_GET['sub'])) {
		$where = " where pc.ContentType IN (".$SubContentSearch.")";
		$JOIN .= "  left JOIN projects as p on (pc.ProjectID=p.ProjectID and pc.ProjectID !='' and p.ProjectID != '' and  p.ProjectType IN (".$ContentSearch.")) ";
		$JOIN .= " JOIN users as u on pc.userid=u.encryptid";
	} else {
	if ($_GET['content'] == 'user') 
		$JOIN .= " left JOIN users_profile as up on up.userid=(u.encryptid and up.RecordID='self_tags')";
	else
		$JOIN .= " JOIN users as u on p.userid=u.encryptid";

	}
	
	//if (in_array('blogs',$SearchContentArray)) 
	      //  $JOIN .= " LEFT JOIN blogs as b on (b.UserID=u.encryptid or p.ProjectID=b.ProjectID)";
			
	// if (in_array('forum',$SearchContentArray)) 
			// $JOIN .= " LEFT JOIN pf_forum_boards as fb on ((fb.UserID=u.encryptid and fb.ProjectID = '') or (p.ProjectID=fb.ProjectID and fb.ProjectID != ''))";
								
	if ((($_GET['content'] != '') || (isset($_GET['t']))) && (!isset($_GET['sub']))) {
		if ($_GET['content'] != 'user')
			$where = " where p.ProjectType IN (".$ContentSearch.")";
	}
		
	
	
		$ContentType = $_GET['content'];

		

	if ($_GET['genre'] != '') {
		if ($where == '')  
			$where = " where ";
		else 
			$where .= ' and';
		$where .= " p.genre LIKE '%".$_GET['genre']."%'";
	}
				
	if ($_GET['keywords'] != '') {
		if ($where == '')  
			$where = " where ";
		else 
			$where .= ' and';
		if ($_GET['content'] != 'user')			
		$where .= " p.tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or p.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
		else 
		$where .= " u.username LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
		//SELECT  u.username, u.avatar as UserThumb,  from users as u JOIN users_profile as up on  where (u.username LIKE '%matte%' or up.LongComment LIKE '%matte%') ORDER BY u.username ASC
		//if (in_array('blogs',$SearchContentArray)) 
			//$where .= " and b.Tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or b.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
	
	  //  if (in_array('forum',$SearchContentArray)) 
		//	$where .=  "and fb.Tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or fb.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
		
		
		

			
		if (isset($_GET['sub']))
			$where .= " and pc.Tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or pc.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";	
	
	}
	
if ((!isset($_GET['sub']))  && ($_GET['content'] != 'user')){
		if ($where == '')  
			$where = " where ";
		else 
			$where .= ' and ';
		
		$where .= " p.installed = 1 and p.Published=1";
	} else if ($_GET['content'] == 'user')	{
		if ($where == '')  
			$where = " where ";
		else 
			$where .= ' and ';
		$where .= " up.RecordID='self_tags' and up.UserID=u.encryptid";
		

	}
	//print_r($SearchContentArray);
	if ((in_array('comic',$SearchContentArray)) && (!isset($_GET['sub'])))
		$where .= " and p.pages>0";
	
	if ($_GET['content'] != 'user'){
	if (!isset($_GET['sub'])) {
		
	if ($_GET['sort'] == 'alpha') 
		$ORDERBY .= " ORDER BY p.title ASC";
	if ($_GET['sort'] == 'new')
		$ORDERBY .= " ORDER BY p.createdate DESC";
	if ($_GET['sort'] == 'updated')				
		$ORDERBY .= " ORDER BY p.PagesUpdated DESC";
	if ($_GET['sort'] == 'rank'){	
		$JOIN .= " LEFT JOIN rankings as r on (p.ProjectID=r.ComicID and p.ProjectID !='')";
		$ORDERBY .= " ORDER BY r.ID ASC";
	}
	} else {
	if ($_GET['sort'] == 'alpha') 
		$ORDERBY .= " ORDER BY pc.Title ASC";
	if ($_GET['sort'] == 'new')
		$ORDERBY .= " ORDER BY pc.CreatedDate DESC";
		
	}
	} else {
		$ORDERBY .= " ORDER BY u.username ASC";
	}
	
	$SearchString =  "";
	$counter = 0;
	//$LIMIT = ' LIMIT 160';
	$query = $SELECT . $JOIN . $where . $ORDERBY.$LIMIT;
	$DB->query($query);
	//print $query;
	$SearchString .= '<div class="messageinfo_white">';
	while ($line = $DB->fetchNextObject()) {
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
					
				if ($line->ProjectType == 'forum') {
					if ($line->SelectType == 'project') 
						$ProjectURL = 'http://www.wevolt.com/r3forum/'.$line->SafeFolder.'/';
					else 
						$ProjectURL = 'http://www.wevolt.com/w3forum/'.$line->username.'/';
						
				} else if ($line->ProjectType == 'comic'){
					$ProjectURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/';
				} else if ($line->ProjectType == 'blog') {
					if ($line->SelectType == 'project') 
						$ProjectURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/blog/';
					else 
						$ProjectURL = 'http://users.wevolt.com/'.$line->username.'/?t=blog';
				}  else if ($_GET['content'] == 'user') {
					$ProjectURL = 'http://users.wevolt.com/'.$line->username.'/';
				}
				$Description = addslashes($line->synopsis);
				$ProjectTags = addslashes($line->ProjectTags);
					
					
			} else if ($line->UserThumb != ''){
							$ProjectThumb  = $line->UserThumb;
				if ($line->ProjectType == 'forum') {
						$ProjectURL = 'http://www.wevolt.com/w3forum/'.$line->username.'/blog/';
				} else if ($line->ProjectType == 'blog') {
						$ProjectURL = 'http://users.wevolt.com/'.$line->username.'/?t=blog';
				} else {
				$ProjectURL = 'http://users.wevolt.com/'.$line->username.'/';
				}
				
				$Description = addslashes($line->UserAbout);
				$ProjectTags = addslashes($line->Tags);
				
			} 
			
			if ($line->SelectType == 'project') 
				$ProjectTitle = $line->ProjectTitle;
			else
				$ProjectTitle = $line->username;
				
			$GenreArray = explode(',',$line->genre);
			$Genres = $GenreArray[0];
			if (trim($GenreArray[1]) != '')
				$Genres .= ', '.$GenreArray[1];
				
			if (isset($_GET['sub'])) {
			
				
				if ((($line->ProjectType == 'forum') || ($line->ProjectType == 'blog')) && ($line->SelectType == 'project')) {
					
					$HeaderTitle = stripslashes($line->ContentTitle);
					$ProjectTitle = stripslashes($line->RealTitle);
					$ProjectThumb = $line->ContentThumb;
					if (($ProjectThumb == '') || ('http://www.wevolt.com'))
						$ProjectThumb = 'http://www.wevolt.com'.$line->ProjectThumb;
	
					
				} else if ((($line->ProjectType == 'forum') || ($line->ProjectType == 'blog')) && ($line->SelectType == 'user')) {
					$HeaderTitle = stripslashes($line->ContentTitle);
					$ProjectTitle = stripslashes($line->username);
					$ProjectThumb = $line->UserThumb;
					
				} else {
						$HeaderTitle = stripslashes($line->ContentTitle);
						$ProjectTitle = stripslashes($line->username);
						$ProjectThumb = $line->UserThumb;
						if (($line->ContentType == 'forum post') ||($line->ContentType == 'forum board') || ($line->ContentType == 'forum topic'))
							$ProjectURL = $ProjectURL = 'http://www.wevolt.com/w3forum/'.$line->username.'/';
						
						if ($line->ContentType == 'blog post')
							$ProjectURL = $ProjectURL = 'http://users.wevolt.com/'.$line->username.'/?t=blog&p='.$line->ContentID;
						
				
				}

				if ($line->ContentType == 'characters')
					$ProjectURL .= 'characters/';
			
			
			} else {
				
				$HeaderTitle = stripslashes($ProjectTitle);
				if ((($line->ProjectType == 'forum') || ($line->ProjectType == 'blog')) && ($line->SelectType == 'project')) {
					$ProjectTitle = '';
					$HeaderTitle = stripslashes($line->RealTitle);
				} else if ((($line->ProjectType == 'forum') || ($line->ProjectType == 'blog')) && ($line->SelectType == 'user')) {
					$ProjectTitle = '';
					$HeaderTitle = stripslashes($line->username);
				}
				
				if ($line->ProjectType == 'forum') {
					$ContentID = $line->ProjectID;
					if ($ContentID == '')
						$ContentID = $line->PUserID;
				} else if ($ContentType == 'user') {
					$ContentID = $line->PUserID;
				} else {
					$ContentID = $line->ProjectID;
				}
			}
					$Description = preg_replace("/\r?\n/", "\\n", $Description); 
				
				//$SearchString .= '<table border="0" cellspacing="0" cellpadding="0" width="250"><tr><td id="updateBox_TL"></td><td id="updateBox_T"></td><td id="updateBox_TR"></td></tr><tr><td class="updateboxcontent"></td><td valign="top" class="updateboxcontent"><table width="100%"><tr><td width="55">';
				
				$SearchString .= '<a href="#" onclick="set_content(\''.addslashes(str_replace('"',"'",$HeaderTitle)).'\', \''.$ContentID.'\', \''.$ProjectURL.'\', \''.$ProjectThumb.'\',\''.$ContentType.'\',\''.str_replace('"',"'",nl2br($Description)).'\',\''.str_replace('"',"'",$ProjectTags).'\');return false;">';
				
				//'<img src="/includes/round_images_inc.php?source='.$ProjectThumb.'&radius=20&colour=e9eef4" border="0" alt="LINK" width="50" height="50"></a></td><td valign="top"><div class="sender_name">'
				
				$SearchString .= $HeaderTitle.'<a/><div style="height:5px;"></div>';
				
				//</div></td></tr></table></td><td class="updateboxcontent"></td></tr><tr><td id="updateBox_BL"></td><td id="updateBox_B"></td><td id="updateBox_BR"></td></tr></table>';
	
				
	 }
 if ($Results == 0)
	$SearchString .=  "<div align='center' style='font-weight:bold;'>There were no items found.</div>";
$SearchString .='</div>';
 echo $SearchString;
?>