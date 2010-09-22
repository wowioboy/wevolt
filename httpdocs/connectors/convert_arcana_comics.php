 <? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 function COPY_RECURSIVE_DIRS($dirsource, $dirdest) 
{ // recursive function to copy 
  // all subdirectories and contents: 
  if(is_dir($dirsource))$dir_handle=opendir($dirsource); 
     @mkdir($dirdest, 0777); 
  while($file=readdir($dir_handle)) 
  { 
    if($file!="." && $file!="..") 
    { 
      if(!is_dir($dirsource."/".$file)) 
	  	copy ($dirsource."/".$file, $dirdest."/".$file); 
      else 
	  		COPY_RECURSIVE_DIRS($dirsource."/".$file, $dirdest."/".$file); 
	  chmod ($dirdest,0777);
    } 
  } 
  closedir($dir_handle); 
  return true; 
}
 $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $db2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $db3 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $query = "SELECT * from projects where Hosted=0 and WorldID='z' and ProjectID!='6c9882bbfa'";
 $db->query($query);
 
 while ($Comic = $db->fetchNextObject()) { 
   			print 'COMIC = ' . $Comic->title.'<br/>';
			$CreatorID = $Comic->userid;
			$ComicID = $Comic->comiccrypt;
			$ComicTitle = $Comic->title;
			$SafeFolder = $Comic->SafeFolder;
			$ContentFolder = 'comics/'.$Comic->HostedUrl;
			
			$query = "SELECT cp.*
           from comic_pages_ac as cp where cp.ComicID='$ComicID' order by cp.Position";
		   $db2->query($query);
		   $TotalPages = $db2->numRows();
 			print 'TOTAL PAGES = ' . $TotalPages.'<br/>';
			
		   $query = "SELECT * from users where encryptid='".$Comic->CreatorID."'";
		   $UserArray = $db3->queryUniqueObject($query);
		   
		   $query = "INSERT into creators (avatar, realname, location, ComicID, Email) values ('".$UserArray->avatar."', '".$UserArray->realname."','".$UserArray->location."','$ComicID','".$UserArray->email."')";
				$db3->query($query);
				print $query.'<br/><br/>';
				
				
			
			$Count = 0;
			  while ($page = $db2->fetchNextObject()) { 
			  $Count++;
			
				  print 'PAGE = ' . $page->Position.'<br/>';
					
					$Filename = $page->Filename;
					$ProImage = $ContentFolder.'/images/pages/'.$Filename;
					
					$PageArray = explode('images/',$page->ThumbSm);
					$ThumbSm = $ContentFolder.'/images/'.$PageArray[1];
					unset($PageArray);
					
					$PageArray = explode('images/',$page->ThumbMd);
					$ThumbMd = $ContentFolder.'/images/'.$PageArray[1];
					unset($PageArray);
					
					$PageArray = explode('images/',$page->ThumbLg);
					$ThumbLg = $ContentFolder.'/images/'.$PageArray[1];
					unset($PageArray);
					
					$PageTitle = $page->Title;
					$Comment =$page->Comment;
					$DateLive = $page->DateLive;
					$UploadBy = $page->UploadedBy;
					$PagePublished = date('Y-m-d') . ' 00:00:00';
					$Position = $page->Position;
					
					  if ($Count == 1) {
				   			$query = "INSERT into Episodes (ProjectID, Title, EpisodeNum, Description, ThumbSm, ThumbMd, ThumbLg) values ('".$Comic->comiccrypt."','".$page->Title."','1','".$Comic->Comment."','$ThumbSm','$ThumbLg','$ThumbLg')";
				    		 $db3->execute($query);
							 print $query.'<br/>';
			  			}
					
					$query = "INSERT into comic_pages (".
										  "Title,".
										  "Comment,".
										  "Image,".
										  "Filename,".
										  "ProImage,".
										  "ImageDimensions,".
										  "Datelive,".
										  "ThumbSm,".
										  "ThumbMd,".
										  "ThumbLg,".
										  "Chapter,".
										  "Position,".
										  "UploadedBy,".
										  "PageType,".
										  "PublishDate,".
										  "EpisodeNum,".
										  "SeriesNum,".
										  "ComicID,".
										  "EpPosition".
										") values (".
											"'$PageTitle',".
											"'$Comment',".
											"'$Filename',".
											"'$Filename',".
											"'$ProImage',".
											"'".$page->ImageDimensions."',".
											"'".$page->Datelive."',".
											"'$ThumbSm',".
											"'$ThumbLg',".
											"'$ThumbLg',".
											"'".$page->Chapter."',".
											"'".$page->Position."',".
											"'".$page->UploadedBy."',".
											"'pages',".
											"'$PagePublished',".
											"'1',".
											"'1',".
											"'".$Comic->comiccrypt."',".
											"'".$page->Position."'".
										")";
										 print $query.'<br/>';
					$db3->query($query);
					
					$query = "SELECT id from comic_pages where PublishDate='$PagePublished' and Image='$Filename'";
					$NewID = $db3->queryUniqueValue($query);
					$output .= $query.'<br/>';
					 print $query.'<br/>';	
					$Encryptid = substr(md5($NewID), 0, 15).dechex($NewID);
					$IdClear = 0;
					$Inc = 5;
					while ($IdClear == 0) {
							$query = "SELECT count(*) from comic_pages where EncryptPageID='$Encryptid'";
							$Found = $db3->queryUniqueValue($query);
							$output .= $query.'<br/>';
							if ($Found == 1) {
								$Encryptid = substr(md5(($NewID+$Inc)), 0, 15).dechex($NewID+$Inc);
							} else {
								$query = "UPDATE comic_pages SET EncryptPageID='$Encryptid' WHERE ID='$NewID'";
								$db3->execute($query);
								 print $query.'<br/>';
								$output .= $query.'<br/>';
								$IdClear = 1;
								//$EncCalID = $Encryptid;
							}
							$Inc++;
					}

					
					/*
					 $query = "SELECT * from pagecomments_ac where comicid='".$Comic->comiccrypt."' and pageid='".$page->EncryptPageID."'";
					 $db3->query($query);
					 print $query.'<br/>';
					 $TotalComments = $db3->numRows();
					 print 'TOTAL TotalComments = ' . $TotalComments.'<br/>';
					 while ($comment = $db3->fetchNextObject()) { 
					 	
							
					 }
				*/
	
			 }
			
			print '<br/>';
			$query ="SELECT ID from project_skins WHERE ID=(SELECT MAX(ID) FROM project_skins)";
				$MaxID = $db2->queryUniqueValue($query);
				if ($MaxID > 9) {
				if ($MaxID > 99) {
					if ($MaxID > 999) {
						if ($MaxID > 9999) {
							if ($MaxID > 99999) {
								if ($MaxID > 999999) {
									echo 'Not Able To Add Skin Too Many IDS';
								} else {
									$NewSkinCode = 'PFPSK-'.($MaxID+1);
								}
							} else {
								$NewSkinCode = 'PFPSK-0'.($MaxID+1);
							}
						} else {
							$NewSkinCode = 'PFPSK-00'.($MaxID+1);
						}
					} else {
						$NewSkinCode = 'PFPSK-000'.($MaxID+1);
						//print 'NewSkinCode' .$NewSkinCode;
					}
				} else {
					$NewSkinCode = 'PFPSK-0000'.($MaxID+1);
					//print 'NewSkinCode' .$NewSkinCode;
				}
			} else {
			
				$NewSkinCode = 'PFPSK-00000'.($MaxID+1);
				//print 'NewSkinCode' .$NewSkinCode;
			}
				
				$query = "UPDATE comic_settings set Template='TPL-001', Skin='$NewSkinCode', CurrentTheme='1' where ProjectID='$ComicID'";
				$db2->query($query);
		
				$query = 'SHOW COLUMNS FROM template_skins;';
				$results = mysql_query($query);
		
		// Generate the duplication query with those fields except the key
				$query = 'INSERT INTO project_skins(SELECT ';
		
				while ($row = mysql_fetch_array($results)) {
					if ($row[0] == 'ID') {
						$query .= 'NULL, ';
					} else if ($row[0] == 'Title') {
						$query .= 'NULL, ';
					} else if ($row[0] == 'SkinCode') {
						$query .= 'NULL, ';
					}else if ($row[0] == 'UserID') {
						$query .= 'NULL, ';
					} else {
						$query .= $row[0] . ', ';
					} // END IF
				} // END WHILE
		
				$query = substr($query, 0, strlen($query) - 2);
				$query .= ' FROM template_skins WHERE SkinCode = "PFSK-00001")';
				
				mysql_query($query);
				//print $query.'<br/><br/>';
				$new_id = mysql_insert_id();
				$query = "UPDATE project_skins set Title='".mysql_real_escape_string($ComicTitle)."', SkinCode='$NewSkinCode', UserID='$CreatorID' WHERE ID='$new_id'";
				$db2->execute($query);
				print $query.'<br/><br/>';
				$dirsource = "templates/skins/PFSK-00001";
				$dirdest = "templates/skins/".$NewSkinCode;
				COPY_RECURSIVE_DIRS($dirsource, $dirdest);		
				$query = "DELETE from pf_modules where ComicID='$ComicID'";
$db2->query($query);
				print $query.'<br/>';
				
				$query = "INSERT INTO pf_modules (Title, ModuleCode, ComicID, Position, Placement, IsPublished,Homepage) VALUES ('Comic Credits', 'comiccredits', '$ComicID', 1, 'left',0, 1),('Other Comics', 'pagecom', '$ComicID', 2, 'left', 0,1),('Comic Synopsis', 'comicsynopsis', '$ComicID', 1, 'right', 0,1),('Links', 'linksbox', '$ComicID', 2, 'right', 0,1),('Mobile Content', 'mobile', '$ComicID', 3, 'right',0, 1),('Status Box', 'status', '$ComicID', 4, 'right', 0,1),('Products', 'products', '$ComicID', 5, 'right', 0,1),('Characters', 'characters', '$ComicID', 6, 'right', 0,1),('Twitter', 'twitter', '$ComicID', 7, 'right',0,1),('Menu One', 'menuone', '$ComicID', 8, 'right', 0,1),('Menu Two', 'menutwo', '$ComicID', 9, 'right', 0,1),('Downloads', 'downloads', '$ComicID', 3, 'left', 0,1),('Author Comment', 'authcomm', '$ComicID', 4, 'left', 0,1),('Blog', 'blog', '$ComicID', 5, 'left', 0, 1)";
$db2->query($query);

$query = "DELETE from content_section where ProjectID='$ComicID' and UserID='$CreatorID'";
$db2->query($query);
print $query.'<br/><br/>';

					$query = "INSERT into content_section  (Title, ProjectID, UserID, IsCustom, Template, CreatedDate, TemplateSection) values ('Episodes', '$ComicID', '$CreatorID', 0, 'tabbed', '$PagePublished','episodes'),('Links', '$ComicID', '$CreatorID', 0, 'list', '$PagePublished','links'),('Reader', '$ComicID', '$CreatorID', 0, 'list', '$PagePublished','reader'),('Credits', '$ComicID', '$CreatorID', 0, 'tabbed', '$PagePublished','credits'),('Home', '$ComicID','$CreatorID', 0, 'reader', '$PagePublished','home'),('Archives', '$ComicID', '$CreatorID', 0, 'thumb_list', '$PagePublished','archives')";
					$db2->query($query);
					print $query.'<br/><br/>';

   }

 ?>