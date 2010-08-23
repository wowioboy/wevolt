<? 

function add_board($BoardTitle, $BoardDescription, $ForumOwner, $ProjectID, $ForumType, $CatID, $Moderators, $Permissions,$PrivacySetting,$Tags, $SelectedGroups='',$IsPro=0) {
	global $DB;
	$NOW = date('Y-m-d h:m:s');
	
		if (is_array($SelectedGroups)) 
				$GroupList =@implode(",",$SelectedGroups);
		$query ="SELECT Position from pf_forum_boards WHERE Position=(SELECT MAX(Position) FROM pf_forum_boards where ProjectID='$ProjectID' and UserID='$ForumOwner' and CatID='$CatID')";
		$NewPosition = $DB->queryUniqueValue($query);
		$NewPosition++;
		$query = "INSERT into pf_forum_boards (Title, Description, ProjectID, UserID, CatID, Moderators, PrivacySetting, SelectedGroups, Position, CreatedDate, Tags, IsPro) values (
				'".mysql_real_escape_string($BoardTitle)."',
				'".mysql_real_escape_string($BoardDescription)."',
				'$ProjectID',
				'$ForumOwner',
				'$CatID',
				'$Moderators',
				'$PrivacySetting',
				'$GroupList',
				'$NewPosition','$NOW',
				 '".mysql_real_escape_string($Tags)."','$IsPro')";
		$DB->execute($query);
		$query ="SELECT ID from pf_forum_boards WHERE UserID='$ForumOwner' and CreatedDate='$NOW'";
		$NewID = $DB->queryUniqueValue($query);
		$Encryptid = substr(md5($NewID), 0, 8).dechex($NewID);
		$query = "UPDATE pf_forum_boards SET EncryptID='$Encryptid' WHERE ID='$NewID'";
		$DB->execute($query);
	//	print $query;
		if ($Permissions == null) $Permissions = array();
		foreach ($Permissions as $User) {
			
			$query = "INSERT into pf_forum_boards_permissions (BoardID, UserID, Permission) values ('$Encryptid', '".$User['UserID']."', '".$User['Access']."')"; 
			$DB->execute($query);
			
		}
		InsertProjectContent('new', $ProjectID, $NewID, 'forum board', $ForumOwner,$Tags);
		
}

function save_board($BoardID, $BoardTitle, $BoardDescription, $ForumOwner, $ProjectID, $ForumType, $CatID, $Moderators, $Permissions,$PrivacySetting, $Position,$Tags, $SelectedGroups='',$IsPro=0) {
	global $DB;
		
		if (is_array($SelectedGroups)) 
			$GroupList =@implode(",",$SelectedGroups);
			
		//UPDATE CATEGORY POSITION
		$query = "SELECT Position from pf_forum_boards where EncryptID='$BoardID'";
		$CurrentPosition = $DB->queryUniqueValue($query); 
	
		$query = "SELECT * from pf_forum_boards where UserID='$ForumOwner' and ProjectID='$ProjectID' and CatID='$CatID' order by position";
		$DB->query($query);
		$TotalLinks = $DB->numRows();
		$query = "SELECT Position from pf_forum_boards WHERE Position=(SELECT MAX(Position) FROM pf_forum_boards  where UserID='$ForumOwner' and ProjectID='$ProjectID' and CatID='$CatID')";
		$MaxPosition = $DB->queryUniqueValue($query);
		$NewItemPosition = $Position;
		
		if ($NewItemPosition != $CurrentPosition) {
			$CurrentOrder = array();
			if ($NewItemPosition < $CurrentPosition) {
				$query = "SELECT EncryptID, Position from pf_forum_boards  where UserID='$ForumOwner' and ProjectID='$ProjectID' and CatID='$CatID' and Position BETWEEN '$NewItemPosition' and '$CurrentPosition' order by Position";
			} else {
					$query = "SELECT EncryptID, Position from pf_forum_boards where UserID='$ForumOwner' and ProjectID='$ProjectID' and CatID='$CatID' and Position BETWEEN '$CurrentPosition' and '$NewItemPosition' order by Position";
			}
			$DB->query($query);

			while ($line = $DB->fetchNextObject()) { 
				 	$CurrentOrder[] = $line->ID;
			}

			if ($NewItemPosition < $CurrentPosition) {
				if ($CurrentPosition != 1) {
					$UpdatePosition = $CurrentPosition;
					for ( $counter =(sizeof($CurrentOrder)-1); $counter > 0; $counter--) {
		   		 		$SelectItemID = $CurrentOrder[$counter-1];
		   				$query = "UPDATE pf_forum_boards set Position='$UpdatePosition' where ID ='$SelectItemID'";
						$UpdatePosition--;
						$DB->execute($query);
					
					}
				$query = "UPDATE pf_forum_boards set Position='$NewItemPosition' where EncryptID='$BoardID'";
				$DB->execute($query);
				}
	
			} else if ($NewItemPosition > $CurrentPosition) {
					$UpdatePosition = $CurrentPosition;
					if ($CurrentPosition != $TotalLinks) {
						for ($counter =0; $counter < (sizeof($CurrentOrder)-1); $counter++) {
		   	 				$SelectItemID = $CurrentOrder[$counter+1];
		   					$query = "UPDATE pf_forum_boards set Position='$UpdatePosition' where ID ='$SelectItemID'";
							$UpdatePosition++; 
							$DB->query($query);
						}
					$query = "UPDATE pf_forum_boards set Position='$NewItemPosition' where EncryptID='$BoardID'";
					$DB->execute($query);
					}
			}
		}
		$query = "UPDATE pf_forum_boards set 
				 Title='".mysql_real_escape_string($BoardTitle)."',
				 Description='".mysql_real_escape_string($BoardDescription)."',
				 CatID='$CatID',
				 Moderators='$Moderators',
				 SelectedGroups='$GroupList', 
				 PrivacySetting='$PrivacySetting',
				 IsPro='$IsPro',
				 Tags='".mysql_real_escape_string($Tags)."',
				 Position='$Position' where EncryptID='$BoardID' and UserID='$ForumOwner'";
		$DB->execute($query);
		
		
		
		if ($Permissions == null) $Permissions = array();
		
		foreach ($Permissions as $User) {
			
			$query = "INSERT into pf_forum_boards_permissions (BoardID, UserID, Permission) values ('$Encryptid', '".$User['UserID']."', '".$User['Access']."')"; 
			$DB->execute($query);
			
		}
	
}

function delete_board($BoardID, $CatID, $ForumOwner, $ProjectID, $ForumType) {
	global $DB;
		if ($_SESSION['userid'] == $ForumOwner) {
				$query = "DELETE from pf_forum_boards 
						 where EncryptID='$BoardID' and UserID='$ForumOwner' and ProjectID='$ProjectID'";
				$DB->execute($query);
				//print $query.'<br/>';
				$CurrentOrder = array();
				
				$query = "SELECT ID, Position from pf_forum_boards where UserID='$ForumOwner' and ProjectID='$ProjectID' and CatID='$CatID' order by Position";
				$DB->query($query);	
				//print $query.'<br/>';
				$pCount = 1;
				while ($line = $DB->fetchNextObject()) { 
					$CurrentOrder[] = $line->ID;
				}
				for ($counter =0; $counter < (sizeof($CurrentOrder)-1); $counter++) {
						$SelectItemID = $CurrentOrder[$counter+1];
						$query = "UPDATE pf_forum_boards set Position='$pCount' where ID ='$SelectItemID'";
						$pCount++; 
						$DB->execute($query);
						//print $query.'<br/>';
				}
		
		}
		
		//FIX POSITION
			
}

function save_category($CatID, $CatTitle, $CatDescription,$ForumOwner, $ProjectID, $ForumType, $Position) {
	global $DB;
		
		//UPDATE CATEGORY POSITION
		$query = "SELECT Position from pf_forum_categories where EncryptID='$CatID'";
		$CurrentPosition = $DB->queryUniqueValue($query); 
	
		$query = "SELECT * from pf_forum_categories where UserID='$ForumOwner' order by position";
		$DB->query($query);
		
		$TotalLinks = $DB->numRows();
		$query = "SELECT Position from pf_forum_categories WHERE Position=(SELECT MAX(Position) FROM pf_forum_categories  where UserID='$ForumOwner')";
		
		$MaxPosition = $DB->queryUniqueValue($query);
		$NewItemPosition = $Position;
		
		if ($NewItemPosition != $CurrentPosition) {
			$CurrentOrder = array();
			if ($NewItemPosition < $CurrentPosition) {
				$query = "SELECT ID, Position from pf_forum_categories where UserID='$ForumOwner' and Position BETWEEN '$NewItemPosition' and '$CurrentPosition' order by Position";
			} else {
					$query = "SELECT ID, Position from pf_forum_categories where UserID='$ForumOwner'  and Position BETWEEN '$CurrentPosition' and '$NewItemPosition' order by Position";
			}
		
			$DB->query($query);

			while ($line = $DB->fetchNextObject()) { 
				 	$CurrentOrder[] = $line->ID;
			}
print_r($CurrentOrder);
			if ($NewItemPosition < $CurrentPosition) {
				if ($CurrentPosition != 1) {
					$UpdatePosition = $CurrentPosition;
					for ( $counter =(sizeof($CurrentOrder)-1); $counter > 0; $counter--) {
		   		 		$SelectItemID = $CurrentOrder[$counter-1];
		   				$query = "UPDATE pf_forum_categories set Position='$UpdatePosition' where ID ='$SelectItemID'";
						
						$UpdatePosition--;
						$DB->execute($query);
					
					}
				$query = "UPDATE pf_forum_categories set Position='$NewItemPosition' where EncryptID='$CatID'";
				
				$DB->execute($query);
				}
	
			} else if ($NewItemPosition > $CurrentPosition) {
					$UpdatePosition = $CurrentPosition;
					if ($CurrentPosition != $TotalLinks) {
						for ($counter =0; $counter < (sizeof($CurrentOrder)-1); $counter++) {
		   	 				$SelectItemID = $CurrentOrder[$counter+1];
		   					$query = "UPDATE pf_forum_categories set Position='$UpdatePosition' where ID ='$SelectItemID'";
							
							$UpdatePosition++; 
							$DB->query($query);
						}
					$query = "UPDATE pf_forum_categories set Position='$NewItemPosition' where EncryptID='$CatID'";
					
					$DB->execute($query);
					}
			}
		}
		$query = "UPDATE pf_forum_categories set 
				 Title='".mysql_real_escape_string($CatTitle)."',
				 Description='".mysql_real_escape_string($CatDescription)."'
				 where EncryptID='$CatID' and UserID='$ForumOwner'";
				
		$DB->execute($query);
		
				
}
function delete_category($CatID,$ForumOwner, $ProjectID, $ForumType, $Position) {
	global $DB;
		
		$query = "DELETE from pf_forum_categories 
				 where EncryptID='$CatID' and UserID='$ForumOwner'";
		$DB->execute($query);
		print $query.'<br/>';
		$CurrentOrder = array();

		$query = "SELECT ID, Position from pf_forum_categories where UserID='$ForumOwner' order by Position";
		$DB->query($query);	
		print $query.'<br/>';
		$pCount = 1;
		while ($line = $DB->fetchNextObject()) { 
			$CurrentOrder[] = $line->ID;
		}
		for ($counter =0; $counter < (sizeof($CurrentOrder)-1); $counter++) {
		   	 	$SelectItemID = $CurrentOrder[$counter+1];
				$query = "UPDATE pf_forum_categories set Position='$pCount' where ID ='$SelectItemID'";
				$pCount++; 
				$DB->execute($query);
				print $query.'<br/>';
		}
		
	
		
		//FIX POSITION
			
}
function add_category($CatTitle, $CatDescription,$ForumOwner, $ProjectID, $ForumType) {
	global $DB;
	
		$NOW = date('Y-m-d h:m:s');
	
	
		$query ="SELECT Position from pf_forum_categories WHERE Position=(SELECT MAX(Position) FROM pf_forum_categories where ProjectID='$ProjectID' and UserID='$ForumOwner')";
		$NewPosition = $DB->queryUniqueValue($query);
		$NewPosition++;
		$query = "INSERT into pf_forum_categories (Title, Description, ProjectID, UserID, Position, CreatedDate) values (
				'".mysql_real_escape_string($CatTitle)."',
				'".mysql_real_escape_string($CatDescription)."',
				'$ProjectID',
				'$ForumOwner',
				'$NewPosition','$NOW')";
		$DB->execute($query);
		$query ="SELECT ID from pf_forum_categories WHERE UserID='$ForumOwner' and CreatedDate='$NOW'";
		$NewID = $DB->queryUniqueValue($query);
		$Encryptid = substr(md5($NewID), 0, 8).dechex($NewID);
		$query = "UPDATE pf_forum_categories SET EncryptID='$Encryptid' WHERE ID='$NewID'";
		$DB->execute($query);
			
}
?>