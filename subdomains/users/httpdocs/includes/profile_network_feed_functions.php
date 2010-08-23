<? 
 switch ($_POST['network_sort']) {
			case 'Created':
				$sort = 'Created desc';
				break;
			case 'CreatedDate':
				$sort = 'CreatedDate desc';
				break; 
			case 'username':
			default:
				$sort = 'username asc';
		}
		$userDB =  new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
		$FriendList = array();
		$query = "select u.encryptid, u.username, u.avatar  
				  from friends f 
				  left join users u 
				  on u.encryptid = f.FriendID 
				  left join updates up 
				  on up.UserID = u.encryptid
				  where f.UserID='$ID' and Accepted = 1 and FriendType = 'friend' and IsW3viewer != 1 group by username order by $sort";
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
			//print $query;
		$friendString = "<div class=\"workarea\" id=\"friends_container\">
		  <ul id=\"friends\" class=\"draglist\">";
		$counter = 0;
		$FCount = 0;
		$InitDB->query($query);
		while ($friend = $InitDB->fetchNextObject()) {
			if ($friend->username != '') {
			$FriendList[] = $friend->encryptid;
			$friendString .= "<li class=\"friends\" id=\"friends_".$friend->encryptid."\"><table border='0' cellspacing='0' cellpadding='0' width='180'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='http://users.wevolt.com/".trim($friend->username)."/'><img src='".$friend->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top' class='sender_name'>".$friend->username."</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div></li>";
			$DropStringInit .= 'new YAHOO.example.DDList("friends_'.$friend->encryptid.'");';
			$FCount++;
			}
		 }
		 if ($FCount == 0)
		 	$friendString .='<div style="height:25px;"></div><center>You don\'t have any friends yet.<br/>Go find some!</center>';
		
		$friendString .='  </ul></div>';
		$query = "select u.encryptid, u.username, u.avatar 
				  from follows f 
				  join users u 
				  on u.encryptid = f.user_id 
				  where f.follow_id='$ID'  and f.type='user' order by $sort";
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
		$fanString = "<div class=\"workarea\">
		
		  <ul id=\"fans\" class=\"draglist\">";
		$counter = 0;
		$FCount = 0;
		$FriendArray = $InitDB->query($query);
		while ($friend = $InitDB->fetchNextObject()) { 
		if ($friend->username != '') {
			$fanString .= "<li class=\"fans\" id=\"fans_".$friend->encryptid."\"><table border='0' cellspacing='0' cellpadding='0' width='173'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='http://users.wevolt.com/".trim($friend->username)."/'><img src='".$friend->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top' class='sender_name'>".$friend->username."</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div></li>";
				  $DropStringInit .= 'new YAHOO.example.DDList("fans_'.$friend->encryptid.'");';
				 $FCount++;
		}
		}
		if ($FCount == 0)
		 	$fanString .='<div style="height:25px;"></div><center>No Fans yet.<br/>Go promote yourself!</center>';
		$fanString .='  </ul></div>';
		
		$query = "select u.encryptid, u.username, u.avatar 
				  from follows f 
				  join users u 
				  on u.encryptid = f.follow_id
				  where f.user_id='$ID' and f.type='user' order by $sort";
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
		$celebString = "<div class=\"workarea\">
		
		  <ul id=\"celebs\" class=\"draglist\">";
		$counter = 0;
		$FCount = 0;
		$FriendArray = $InitDB->query($query);
		while ($friend = $InitDB->fetchNextObject()) { 
			$celebString .= "<li class=\"celebs\" id=\"celebs_".$friend->encryptid."\"><table border='0' cellspacing='0' cellpadding='0' width='173'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='http://users.wevolt.com/".trim($friend->username)."/'><img src='".$friend->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top' class='sender_name'>".$friend->username."</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div></li>";
			$DropStringInit .= 'new YAHOO.example.DDList("celebs_'.$friend->encryptid.'");';
			$FCount++;
		 }
		 if ($FCount == 0)
		 	$celebString .='<div style="height:25px;"></div><center>You are not following anyone yet.<br/>Go find some cool people!</center>';
		
		$celebString .='  </ul></div>';
		
		$query = "select u.encryptid, u.username, u.avatar 
				  from friends f 
				  left join users u 
				  on u.encryptid = f.FriendID 
				  left join updates up 
				  on up.UserID = u.encryptid
				  where f.UserID='$ID' and Accepted = 1 and FriendType = 'friend' and IsW3viewer = 1 group by username order by $sort";
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
		$w3viewString = "<div class=\"workarea\">
		
		  <ul id=\"w3vers\" class=\"draglist\">";
		$counter = 0;
		$FCount = 0;
		$FriendArray = $InitDB->query($query);
		while ($friend = $InitDB->fetchNextObject()) { 
			$FriendList[] = $friend->encryptid;
			$w3viewString .= "<li class=\"w3vers\" id=\"w3vers_".$friend->encryptid."\"><table border='0' cellspacing='0' cellpadding='0' width='173'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='http://users.wevolt.com/".trim($friend->username)."/'><img src='".$friend->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top' class='sender_name'>".$friend->username."</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div></li>";
		    $DropStringInit .= 'new YAHOO.example.DDList("w3vers_'.$friend->encryptid.'");';
	    	$FCount++;
		 }
		if ($FCount == 0)
		 	$w3viewString .='<div style="height:25px;"></div><center>You haven\'t set up any cool friends.<br/>Go promote your cool friends!</center>';
		$w3viewString .='  </ul></div>';
		
		$query = "select f.ID, u.encryptid, u.username, u.avatar 
				  from friends f 
				  left join users u 
				  on u.encryptid = f.UserID 
				  left join updates up 
				  on up.UserID = u.encryptid
				  where f.FriendID='$ID' and Accepted = 0 and FriendType = 'friend' group by u.username order by $sort";
				//  print $query;
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
		$RequestString = "<div class=\"workarea\" id=\"request_container\">
		  <ul id=\"requests\" >";
		$counter = 0;
		$FCount = 0;
		$InitDB->query($query);
		while ($friend = $InitDB->fetchNextObject()) {
			$FriendList[] = $friend->encryptid;
			$RequestString .= "<li class=\"friends\"><table border='0' cellspacing='0' cellpadding='0' width='180'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='http://users.wevolt.com/".trim($friend->username)."/'><img src='".$friend->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top' class='sender_name'>".$friend->username."</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table>
			<form method=\"post\">
				<input type=\"hidden\" name=\"requestid\" value=\"{$friend->ID}\" />
				<input type=\"hidden\" name=\"network_sort\" value=\"{$_POST['network_sort']}\" />
				<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">
				  <tr>
				    <td align=\"left\"><input type=\"submit\" name=\"request_action\" value=\"accept\" /></td>
				    <td align=\"right\"><input type=\"submit\" name=\"request_action\" value=\"ignore\" /></td>
				  </tr>
				</table>
			</form>
			<div class='smspacer'></div></li>";
			$FCount++;
		 }
		 if ($FCount == 0)
		 	$RequestString .='<div style="height:25px;"></div><center>You don\'t have any requests right now.</center>';
		
		$RequestString .='  </ul></div>';
		
	if ($_GET['t'] == 'feed') {	 
	
		$QueryFriendList = '"' . implode('","', $FriendList) . '"';
		foreach($FriendList as $key => $value) {
			$temp[] = "'".$value."'";
		}
		$QueryFriendList = @implode(",",$temp);
		if( $QueryFriendList != '') { 
		
		$query = "SELECT up.UserID, up.ActionType, up.UpdateType, up.ActionSection, up.Link, up.ActionID, up.CreatedDate, u.username,u.avatar,p.ProjectID, p.SafeFolder,p.thumb as ComicThumb, tu.username as TargetUsername, tu.avatar as TargetAvatar, m.EncryptID as WindowID, m.Title as ListTitle, s.Blurb as Status, s.ContentID as StatusContent, s.Link as StatusLink, s.Comment as StatusComment,
						(SELECT count(*) FROM updates as up2 where up2.ActionSection=up.ActionSection and up2.ActionID=up.ActionID and up2.UserID=up.UserID and up2.UpdateDate=up.UpdateDate) as TotalUpdates
						FROM updates as up
						join users as u on up.UserID=u.encryptid
						LEFT join projects as p on up.ActionID=p.ProjectID
						LEFT join users as tu on up.ActionID=tu.encryptid
						LEFT join feed_modules as m on up.ActionID=m.EncryptID
						LEFT join excites as s on up.ActionID=s.EncryptID
						 WHERE (up.UserID IN ($QueryFriendList) or up.UserID='$ID') GROUP BY up.CreatedDate,up.ActionID, up.ActionSection ORDER BY up.CreatedDate DESC limit 10";
		
		
		$updateString = "<div id=\"updateList\">";
			/*
		$query = "select *, up.createddate as date, count(1) as count
			from users_updates uu 
			left join updates up 
			on uu.update_id = if(uu.type = 'project', up.actionID, up.userid) 
			left join users u 
			on up.userid = u.encryptid
			left join projects p 
			on up.actionid = p.ProjectID
			where uu.user_id = '{$_SESSION['userid']}'
			group by u.username, up.actiontype
			order by up.createddate desc 
			limit 20";
			*/
		$InitDB->query($query); 
		$PreviousSection = '';
		$PreviousID = '';
		while ($UpdateArray = $InitDB->fetchNextObject()) { 
			
				$UpdateStatement ='';
				$NoTitle = 0;
				
				if (($UpdateArray->ActionSection != $PreviousSection) || ($PreviousID !=$UpdateArray->ActionID )) {
					$DupCount = 0;
					$NoShow = 0;
					$PreviousSection = $UpdateArray->ActionSection;
					$PreviousID = $UpdateArray->ActionID;
				}
			
				
				$DupCount++;
				
				if ($DupCount != 1)
					$NoShow = 1;

				if ($NoShow ==0) {
					if ($UpdateArray->ActionType == 'updated') {
								switch ($UpdateArray->ActionSection) {
										case 'profile info':
											$UpdateStatement = 'updated information on their ';
											$UpdateStatement .= '<a href="http://users.wevolt.com/'.$UpdateArray->username.'/?t=profile">profile</a>';
											$FeedTitle = $UpdateArray->username;
											$FeedThumb = $UpdateArray->avatar;
											$FeedLink = 'http://users.wevolt.com/'.trim($UpdateArray->username).'/';
												break;
										case 'excite':
											$UpdateStatement .= '<div class="sender_name">'.$UpdateArray->Status.'</div>';
											$UpdateStatement .= '<br/>'.$UpdateArray->StatusComment;
											if ($UpdateArray->StatusLink != '')
												$UpdateStatement .= '<br/>&nbsp;&nbsp;[<a href="'.$UpdateArray->StatusLink.'">LINK</a>]';
												$FeedTitle = $UpdateArray->username;
												$FeedThumb = $UpdateArray->avatar;
												$FeedLink = 'http://users.wevolt.com/'.trim($UpdateArray->username).'/?t=excites';
												$NoTitle = 1;
											break;
								}
					
					} else if ($UpdateArray->ActionType == 'replied to') {
						//	print_r($UpdateArray);
								switch ($UpdateArray->ActionSection) {
													case 'forum topic':
											$UpdateStatement = 'replied to the forum topic ';
											$LinkArray = explode('topic=',$UpdateArray->Link);
											$TopicID = $LinkArray[1];
										//	print_r($LinkArray);
											$query = "SELECT Subject from pf_forum_topics where ID='$TopicID'";
											$TopicName = $InitDB->queryUniqueValue($query);
										//	print $query.'<br/>';
											$UpdateStatement .= '<a href="'.$UpdateArray->Link.'">'.$TopicName.'</a>';
											$FeedTitle = $UpdateArray->username;
											$FeedThumb = $UpdateArray->avatar;
											$FeedLink = 'http://users.wevolt.com/'.trim($UpdateArray->username).'/';
												break;
										case 'status':
											$UpdateStatement .= $UpdateArray->Status;
							
											if ($UpdateArray->StatusLink != '')
												$UpdateStatement .= '<br/>&nbsp;&nbsp;[<a href="'.$UpdateArray->StatusLink.'">LINK</a>]';
											
												$FeedThumb = $UpdateArray->avatar;
												$FeedLink = 'http://users.wevolt.com/'.trim($UpdateArray->username).'/';
											break;	
								}
					
					} else {
								switch ($UpdateArray->ActionSection) {
								case 'comic pages':
										
										//$query ='SELECT ThumbMd, Position, Title from comic_pages where 
										//$InitDB->query($query); 
										$UpdateStatement .= 'new pages have been posted ';
										$UpdateStatement .= '<br/>[<a href="'.$UpdateArray->Link.'">READ HERE</a>]';
										$UpdateStatement = str_replace('panelflow','wevolt', $UpdateStatement);
										$FeedTitle = str_replace('_',' ', $UpdateArray->SafeFolder);
										$FeedThumb = 'http://www.wevolt.com'.$UpdateArray->ComicThumb;
										$FeedLink =str_replace('panelflow','wevolt', $UpdateArray->Link);							
										break;
								
									case 'characters':
										
										//$query ='SELECT ThumbMd, Position, Title from comic_pages where 
										//$InitDB->query($query); 
										$UpdateStatement .= 'new character bios have been posted ';
										$UpdateStatement .= '<br/>[<a href="'.$UpdateArray->Link.'">VIEW</a>]';
										$UpdateStatement = str_replace('panelflow','wevolt', $UpdateStatement);
										$FeedTitle = str_replace('_',' ', $UpdateArray->SafeFolder);
										$FeedThumb = 'http://www.wevolt.com'.$UpdateArray->ComicThumb;
										$FeedLink =str_replace('panelflow','wevolt', $UpdateArray->Link);							
										break;
										
								case 'blog':
										$UpdateStatement = $UpdateArray->ActionType .' ';
										if ($UpdateArray->UpdateType == 'user') {
											$UpdateStatement .= 'an update to their blog';
											$UpdateStatement .= '<br/><a href="http://users.wevolt.com/'.$UpdateArray->username.'/blog/">'.str_replace('_',' ', $UpdateArray->SafeFolder).'</a>';
											$FeedTitle = $UpdateArray->username;
											$FeedThumb = $UpdateArray->avatar;
											$FeedLink = 'http://users.wevolt.com/'.trim($UpdateArray->username).'/';
										} else {
											$UpdateStatement .= 'an update to the ';
											$UpdateStatement .= '<a href="http://users.wevolt.com/'.$UpdateArray->SafeFolder.'/blog/">blog</a>';
											$FeedTitle = str_replace('_',' ', $UpdateArray->SafeFolder);
											$FeedThumb = 'http://www.wevolt.com'.$UpdateArray->ComicThumb;
											$FeedLink = 'http://www.wevolt.com/'.$UpdateArray->SafeFolder.'/';
										}
										
										break;
								
								case 'window':
									$UpdateStatement = $UpdateArray->ActionType .' ';
									if ($UpdateArray->ActionType == 'created'){
										$UpdateStatement .= 'a new window called ';
										$UpdateStatement .= '<br/><a href="http://users.wevolt.com/'.$UpdateArray->username.'/">'.str_replace('_',' ', $UpdateArray->ListTitle).'</a>';
									} else if ($UpdateArray->ActionType == 'added'){ 
										$UpdateStatement .= 'an item to their window ';
										$UpdateStatement .= '<br/><a href="http://users.wevolt.com/'.$UpdateArray->username.'/">'.str_replace('_',' ', $UpdateArray->ListTitle).'</a>';
									}
									$FeedTitle = $UpdateArray->username;
									$FeedThumb = $UpdateArray->avatar;
									$FeedLink = 'http://users.wevolt.com/'.trim($UpdateArray->username).'/';
									break;
									
								case 'forum topic':
									$UpdateStatement = $UpdateArray->ActionType .' ';
									$UpdateType = $UpdateArray->UpdateType;
									if ($UpdateArray->ActionType == 'started'){
										$UpdateStatement .= 'a new forum ';
										$UpdateStatement .= '<a href="'.$UpdateArray->Link.'">topic</a>';
									}
									if ($UpdateArray->UpdateType == 'user') {
										$FeedTitle = $UpdateArray->username;
										$FeedThumb = $UpdateArray->avatar;
										$FeedLink = 'http://users.wevolt.com/'.trim($UpdateArray->username).'/';
									} else {
										$FeedTitle = str_replace('_',' ', $UpdateArray->SafeFolder);
										$FeedThumb = 'http://www.wevolt.com'.$UpdateArray->ComicThumb;
										$FeedLink = 'http://www.wevolt.com/'.$UpdateArray->SafeFolder.'/';
									}
									break;
										
								case 'forum board':
									$UpdateStatement = $UpdateArray->ActionType .' ';
									$UpdateType = $UpdateArray->UpdateType;
									if ($UpdateArray->ActionType == 'created'){
										$UpdateStatement .= 'a new forum ';
										$UpdateStatement .= '<a href="'.$UpdateArray->Link.'">board</a>';
									}
									
									if ($UpdateArray->UpdateType == 'user') {
										$FeedTitle = $UpdateArray->username;
										$FeedThumb = $UpdateArray->avatar;
										$FeedLink = 'http://users.wevolt.com/'.trim($UpdateArray->username).'/';
									} else {
										$FeedTitle = str_replace('_',' ', $UpdateArray->SafeFolder);
										$FeedThumb = 'http://www.wevolt.com'.$UpdateArray->ComicThumb;
										$FeedLink = 'http://www.wevolt.com/'.$UpdateArray->SafeFolder.'/';
									}
									break;
									 
							}
					}
					
					if ($FeedTitle != '') {
						$updateString .= "<table border='0' cellspacing='0' cellpadding='0' width='500'><tr><td id=\"updateBox_TL\"></td>
										  <td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr>
										  <tr><td class=\"updateboxcontent\"></td>
										  <td valign='top' class=\"updateboxcontent\">
										  <div class='updated_date' align='right'>".date('m-d-Y',strtotime($UpdateArray->CreatedDate))."</div>
										   <table width='100%'><tr><td width='55' valign='top'><a href='".$FeedLink."'>
										   <img src='/includes/round_images_inc.php?source=".$FeedThumb."&radius=20&colour=e9eef4' alt='LINK' border='0' width='50' height='50'></a></td>
										   <td valign='top'>"; 
						if ($NoTitle == 0) 
							$updateString .= "<div class='sender_name'>".$FeedTitle."</div>";
						$updateString .= "<div class='messageinfo'>".$UpdateStatement;
						
						if ($UpdateArray->TotalUpdates > 1)
						$updateString .= "<br/>Total Updates: ".$UpdateArray->TotalUpdates;
					
						$updateString .= "</div>";
						
						$updateString .= "</td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr>
										  <td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table>
										  <div class='spacer'></div>";
					}
				}
				flush();
					
			}
		}
		$updateString .= "</div>";
	}
	$userDB->close();	
?>