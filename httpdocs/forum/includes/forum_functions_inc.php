<? 
function BuildForumBoards($TargetName, $ForumType, $ForumOwner,$IsFriend,$IsFan,$AdminUser, $UserArray, $ProjectArray) {
global $DB, $DB2,$ForumLinkTarget, $pagination, $querystring,$NumItemsPerPage;
if ($ForumType == 'user') {
	$ForumSelect = "b.UserID='".$UserArray->encryptid."'";
	$ForumLinkTarget = 'index.php';
 
} else if ($ForumType == 'project') {
	$ForumSelect = "b.ProjectID='".$ProjectArray->ProjectID."'";
	$ForumLinkTarget = 'index.php';
}

if (($_SESSION['IsPro'] == 1) ||($_SESSION['ProInvite'] == 1))
	$where = ' and (b.IsPro=1 or b.IsPro=0) ';
else
	$where = ' and b.IsPro=0 ';

$query = "SELECT b.*, c.Title as CatTitle, c.EncryptID as CatCrypt, c.Description as CatDescription 
		  		from pf_forum_boards as b 
		  		left join pf_forum_categories as c on c.ID=b.CatID 
		  		where ".$ForumSelect.$where." order by b.CatID, b.Position";
				
	$DB->query($query);
	
	$NumBoards = $DB->numRows();
	if ($ForumType == 'user') 
		$BoardThumb = $UserArray->avatar;
	else 
		$BoardThumb = 'http://www.wevolt.com'.$ProjectArray->thumb;
	$LastCat = 0;
	$BoardCount = 0;
	echo '<div class="forum_container">';

			
		while ($forumboard = $DB->FetchNextObject()) {
			
			$BoardID = $forumboard->ID;
			$Auth = 0;
			if (($forumboard->PrivacySetting == 'friends') && ($IsFriend)){
					$Auth = 1;
			} else if (($forumboard->PrivacySetting == 'fans') && ($IsFriend) || ($IsFan) ){
					$Auth = 1;
			} else if ($forumboard->PrivacySetting == 'selective'){
					$query = "SELECT * from pf_forum_board_permissions where BoardID='$BoardID' and UserID = '$SessionUser' limit 1";
					$DB2->query($query);
					$Found = $DB2->numRows();
					if ($Found == 1) {
						while ($permission = $DB2->FetchNextObject()) {
								$Auth = 1;
								$AccessLevel = $permission->Permission;
						}
					}

			} else  if ($forumboard->PrivacySetting == 'public'){
				$Auth = 1;
			
			} else if ($forumboard->PrivacySetting =='groups') {
					$SelectedGroups = @explode(',',$forumboard->SelectedGroups);
					if ($SelectedGroups == null)
					 $SelectedGroups = array();
					foreach($SelectedGroups as $group) {
							$query = "SELECT GroupUsers from user_groups where ID='$group'";
							$GroupUsers = $DB2->queryUniqueValue($query);
							$GroupUserArray = @explode(',',$GroupUsers);
							if ($GroupUserArray == null)
								$GroupUserArray = array();
							if (in_array($_SESSION['userid'],$GroupUserArray)) {
								$Auth = 1;	
								break;
							}
					}			
			}else if (($forumboard->PrivacySetting == 'public') || ($forumboard->PrivacySetting == '')) {
					$Auth = 1;
				}
			if ($AdminUser) {
				$Auth = 1;
				$AccessLevel = 'admin';
			}
			
			if ($Auth == 1) {
				$BoardCount++;
				$query = "SELECT count(*) from pf_forum_topics where BoardID='$BoardID'";
				$TotalTopics = $DB2->queryUniqueValue($query);
	
				
				$query = "SELECT count(*) from pf_forum_messages as m
						  join pf_forum_topics as t on m.TopicID=t.ID 
						  where t.BoardID='".$forumboard->ID."'";
				$TotalPosts = $DB2->queryUniqueValue($query);
				
				
				if (($TotalPosts == 0) && ($TotalTopics > 0))
					$TotalPosts = $TotalTopics;
					
				$query = "SELECT t.LastUser, u.username,u.avatar, m.CreatedDate as LastPost, m.TopicID
						  from pf_forum_messages as m
						  join users as u on m.UserID=u.encryptid
						  join pf_forum_topics as t on m.TopicID=t.ID 
						  where t.BoardID='".$forumboard->ID."' order by m.CreatedDate DESC";
				$LastPostArray = $DB2->queryUniqueObject($query);
				$LastPoster = $LastPostArray->username;
				$LastPosterAvatar = $LastPostArray->avatar;
				
				
				
				if ($LastPoster == '') {
					$query = "SELECT t.LastUser, u.username,u.avatar, t.CreatedDate as LastPost, t.ID as TopicID
						  from pf_forum_topics as t
						  join users as u on t.UserID=u.encryptid
						  where t.BoardID='".$forumboard->ID."' order by t.CreatedDate  DESC";
					$LastPostArray = $DB2->queryUniqueObject($query);
					$LastPoster = $LastPostArray->username;
					$LastPosterAvatar = $LastPostArray->avatar;
				
				}
			//	print_r($LastPostArray);
			//	echo 'Created Date = ' . $LastPostArray->LastPost.'<br/>';
				
			//	echo 'Last Login = ' . $_SESSION['lastlogin'];
				$query = "SELECT ID from pf_forum_read_log where UserID='".$_SESSION['userid']."' and TopicID='".$LastPostArray->TopicID."' Limit 1";
				$DB2->query($query);
				$AlreadyRead = $DB2->numRows();
			
				if ((($topic->LastReply > $_SESSION['lastlogin']) || ($topic->CreatedDate > $_SESSION['lastlogin'])) && ($AlreadyRead == 0))
					$HasNew = true;
				else
					$HasNew = false;
				
				
				
			
				if ($LastCat != $forumboard->CatID) { 
					echo "<div class='catheader'>".stripslashes($forumboard->CatTitle)."</div>";
					$LastCat = $forumboard->CatID;
				}
					echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>
						   <tr>
						   <td id=\"updateBox_TL\"></td>
						   <td id=\"updateBox_T\"></td>
						   <td id=\"updateBox_TR\"></td>
						   </tr><tr>
						   <td class=\"updateboxcontent\"></td>
						   <td valign='top' class=\"updateboxcontent\">
								<table width='100%'>
									<tr>
										<td width='55'>
										<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=read&board=".$forumboard->ID."'>
										<img src='".$BoardThumb."' alt='LINK' width='50' height='50' style='border:1px solid #000000;'></a>
										</td>
										<td valign='top'>
										<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=read&board=".$forumboard->ID."'>
										<div class='sender_name'>".$forumboard->Title;
										
										if ($HasNew) 
											echo "&nbsp;&nbsp;&nbsp;*NEW";
										echo "</div>
										</a>
										<div class='messageinfo'>".$forumboard->Description."</div>
										</td>
										<td width='50' class='messageinfo'><center>".$TotalTopics."<br/>topics</center></td>
										<td  width='50' class='messageinfo'><center>".$TotalPosts."<br/>posts</center></td>
										
										<td width='150' class='updated_date' align='right'>";
			
										if ($LastPoster != '') 
											echo "
													Last Post<br/>".date('m-d-Y',strtotime($LastPostArray->LastPost))."<br/><a href='http://users.wevolt.com/".trim($LastPoster)."/'>
										<img src='".$LastPosterAvatar."' alt='LINK'  width='25' height='25' style='border:1px solid #000000;'></a>";
				
								echo "</td>
									</tr>
								</table>
							</td>
							<td class=\"updateboxcontent\"></td>
							</tr><tr>
							<td id=\"updateBox_BL\"></td>
							<td id=\"updateBox_B\"></td>
							<td id=\"updateBox_BR\"></td>
							</tr></table>
							<div class='spacer'></div>";
		}
	}
	if ($BoardCount == 0) 
		echo "<div style='height:20px;padding:20px;' align='center'>Sorry all the boards on this forum are for <strong>friends</strong> and <strong>fans</strong> only.</div>";
	echo '</div>';


}

function BuildForumBoards_admin($TargetName, $ForumType, $ForumOwner,$IsFriend,$IsFan,$AdminUser, $UserArray, $ProjectArray) {
global $DB, $DB2,$ForumLinkTarget;

if ($ForumType == 'user') {
	$ForumSelect = "b.UserID='".$UserArray->encryptid."'";
	$ForumLinkTarget = 'index.php';

} else if ($ForumType == 'project') {
	$ForumSelect = "b.ProjectID='".$ProjectArray->ProjectID."'";
	$ForumLinkTarget = 'index.php';
}

$query = "SELECT b.*, c.Title as CatTitle, c.Description as CatDescription, c.EncryptID as CatCrypt
		  		from pf_forum_boards as b 
		  		left join pf_forum_categories as c on c.ID=b.CatID 
		  		where ".$ForumSelect." order by b.CatID, b.Position";
				
	$DB->query($query);
	$NumBoards = $DB->numRows();
	if ($ForumType == 'user') 
		$BoardThumb = $UserArray->avatar;
	else 
		$BoardThumb = $UserArray->Thumb;
	$LastCat = 0;

	echo '<div class="forum_container">';
	while ($forumboard = $DB->FetchNextObject()) {
			$BoardID = $forumboard->ID;
			$Auth = 0;
			if (($forumboard->PrivacySetting == 'friends') && ($IsFriend)){
					$Auth = 1;
			} else if (($forumboard->PrivacySetting == 'fans') && ($IsFriend) || ($IsFan) ){
					$Auth = 1;
			} else if ($forumboard->PrivacySetting == 'selective'){
					$query = "SELECT * from pf_forum_board_permissions where BoardID='$BoardID' and UserID = '$SessionUser' limit 1";
					$DB2->query($query);
					$Found = $DB2->numRows();
					if ($Found == 1) {
						while ($permission = $DB2->FetchNextObject()) {
								$Auth = 1;
								$AccessLevel = $permission->Permission;
						}
					}

			}else if ($forumboard->PrivacySetting =='groups') {
					$SelectedGroups = @explode(',',$forumboard->SelectedGroups);
					if ($SelectedGroups == null)
					 $SelectedGroups = array();
					foreach($SelectedGroups as $group) {
							$query = "SELECT GroupUsers from user_groups where ID='$group'";
							$GroupUsers = $DB2->queryUniqueValue($query);
							$GroupUserArray = @explode(',',$GroupUsers);
							if ($GroupUserArray == null)
								$GroupUserArray = array();
							if (in_array($_SESSION['userid'],$GroupUserArray)) {
								$Auth = 1;	
								break;
							}
					}			
			}else if (($forumboard->PrivacySetting == 'public') || ($forumboard->PrivacySetting == '')) {
					$Auth = 1;
				}
			if ($AdminUser) {
				$Auth = 1;
				$AccessLevel = 'admin';
			}
			
			if ($Auth == 1) {
				$query = "SELECT count(*) from pf_forum_topics where BoardID='$BoardID'";
				$TotalTopics = $DB2->queryUniqueValue($query);
	
				
				$query = "SELECT count(*) from pf_forum_messages as m
						  join pf_forum_topics as t on m.TopicID=t.ID 
						  where t.BoardID='".$forumboard->ID."'";
				$TotalPosts = $DB2->queryUniqueValue($query);
				
				if (($TotalPosts == 0) && ($TotalTopics > 0))
					$TotalPosts = $TotalTopics;
					
				$query = "SELECT t.LastUser, u.username,u.avatar, m.CreatedDate as LastPost
						  from pf_forum_messages as m
						  join users as u on m.UserID=u.encryptid
						  join pf_forum_topics as t on m.TopicID=t.ID 
						  where t.BoardID='".$forumboard->ID."' order by m.CreatedDate";
				$LastPostArray = $DB2->queryUniqueObject($query);
				$LastPoster = $LastPostArray->username;
				$LastPosterAvatar = $LastPostArray->avatar;
				
				if ($LastPoster == '') {
					$query = "SELECT t.LastUser, u.username,u.avatar, t.CreatedDate as LastPost
						  from pf_forum_topics as t
						  join users as u on t.UserID=u.encryptid
						  where t.BoardID='".$forumboard->ID."' order by t.CreatedDate";
					$LastPostArray = $DB2->queryUniqueObject($query);
					$LastPoster = $LastPostArray->username;
					$LastPosterAvatar = $LastPostArray->avatar;
				
				}
				
				
			
				if ($LastCat != $forumboard->CatID) { 
					echo "<div class='catheader'>".stripslashes($forumboard->CatTitle)." [<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=edit_category&id=".$forumboard->CatCrypt."'>edit</a>]</div>";
					$LastCat = $forumboard->CatID;
				}
					echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>
						   <tr>
						   <td id=\"updateBox_TL\"></td>
						   <td id=\"updateBox_T\"></td>
						   <td id=\"updateBox_TR\"></td>
						   </tr><tr>
						   <td class=\"updateboxcontent\"></td>
						   <td valign='top' class=\"updateboxcontent\">
								<table width='100%'>
									<tr>
										<td width='55'>
										<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=edit_board&id=".$forumboard->EncryptID."'>
										<img src='".$BoardThumb."' alt='LINK' width='50' height='50' style='border:1px solid #000000;'></a>
										</td>
										<td valign='top'>
										<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=edit_board&id=".$forumboard->EncryptID."'>
										<div class='sender_name'>".$forumboard->Title." [click to edit]</div>
										</a>";
							
										if ($forumboard->Moderators != '') {
											//$ModArray = explode(',',$forumboard->Moderators);
											echo '<div class="messageinfo"><b>Moderators:</b><em> '.$forumboard->Moderators.'</em></div>';
											//$mCount = 0;
											//foreach($ModArray as $User) {
													
												//	$query = "SELECT username from users where encryptid='$User'";
													//$Uname = $DB2->queryUniqueValue($query);
													
												//	if ($mCount != 0)
													//	echo ', ';
												
													//echo $Uname;
											//}
										}
										
										
										echo "<div class='messageinfo'>".$forumboard->Description."</div>
										</td>
										<td width='50' class='messageinfo'><center>".$TotalTopics."<br/>topics</center></td>
										<td  width='50' class='messageinfo'><center>".$TotalPosts."<br/>posts</center></td>
										
										<td width='150' class='updated_date' align='right'>[<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=delete_board&id=".$forumboard->EncryptID."'>DELETE</a>]&nbsp;[<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=new_topic&board=".$forumboard->EncryptID."'>NEW TOPIC</a>]";
			
										
				
								echo "</td>
									</tr>
								</table>
							</td>
							<td class=\"updateboxcontent\"></td>
							</tr><tr>
							<td id=\"updateBox_BL\"></td>
							<td id=\"updateBox_B\"></td>
							<td id=\"updateBox_BR\"></td>
							</tr></table>
							<div class='spacer'></div>";
		}
	}
	echo '</div>';
	
	if ($NumBoards == 0) 
		echo '<div class="spacer"></div><div class="messageinfo_black">There are currently no Boards created for this forum. <a href="index.php?'.$ForumType.'='.$TargetName.'&a=admin&task=new_board">CREATE</a> a new one!</div><div class="spacer"></div>';


}

function BuildForumCategories_admin($TargetName, $ForumType, $ForumOwner,$IsFriend,$IsFan,$AdminUser, $UserArray, $ProjectArray) {
global $DB, $DB2,$ForumLinkTarget;

if ($ForumType == 'user') {
	$ForumSelect = "c.UserID='".$UserArray->encryptid."'";
	$ForumLinkTarget = 'index.php';

} else if ($ForumType == 'project') {
	$ForumSelect = "c.ProjectID='".$ProjectArray->ProjectID."'";
	$ForumLinkTarget = 'index.php';
}


$query = "SELECT c.*, (select count(*) from pf_forum_boards as b2 where b2.UserID='".$UserArray->encryptid."' and ProjectID='".$ProjectArray->ProjectID."' and b2.CatID=c.ID) as TotalBoards,
(select count(*) from pf_forum_topics as t
				 join pf_forum_messages as m on m.TopicID=t.ID
				 join pf_forum_boards as b3 on t.BoardID=b3.ID
				 where b3.UserID='".$UserArray->encryptid."' and b3.ProjectID='".$ProjectArray->ProjectID."' and b3.CatID=c.ID) as TotalPosts
		  		from pf_forum_categories as c  
		  		where ".$ForumSelect." order by c.Position";
	//	print $query;		
	$DB->query($query);
	$LastCat = 0;

	echo '<div class="forum_container">';
	while ($forumboard = $DB->FetchNextObject()) {
				
					echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>
						   <tr>
						   <td id=\"updateBox_TL\"></td>
						   <td id=\"updateBox_T\"></td>
						   <td id=\"updateBox_TR\"></td>
						   </tr><tr>
						   <td class=\"updateboxcontent\"></td>
						   <td valign='top' class=\"updateboxcontent\">
								<table width='100%'>
									<tr>
										<td width=\"100\">
										<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=edit_category&id=".$forumboard->EncryptID."'>[edit]</a>&nbsp;&nbsp;";
										
										if ($forumboard->ProjectCat == 1) 
											echo 'REvolt';
										else if ($forumboard->WindowCat == 1)
											echo 'WEvolt';
										else if ($forumboard->EventCat == 1)
											echo 'Events';
										else
											echo "<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=delete_category&id=".$forumboard->EncryptID."'>[delete]</a>";
									
											
									
									echo "</td>
										<td valign='top' align=\"left\">
										
										<div class='sender_name' align=\"left\">".$forumboard->Title."</div>";
							
																	
										
										echo "<div class='messageinfo' align=\"left\">".$forumboard->Description."</div>
										</td>
										<td width='50' class='messageinfo'><center>".$forumboard->TotalBoards."<br/>boards</center></td>
										<td  width='50' class='messageinfo'><center>".$TotalPosts."</center></td>
									</tr>
								</table>
							</td>
							<td class=\"updateboxcontent\"></td>
							</tr><tr>
							<td id=\"updateBox_BL\"></td>
							<td id=\"updateBox_B\"></td>
							<td id=\"updateBox_BR\"></td>
							</tr></table>
							<div class='spacer'></div>";
		}
	echo '</div>';
}
 

function BuildBoardTopics($TargetName, $ForumType, $ForumOwner,$IsFriend,$IsFan,$AdminUser, $UserArray, $ProjectArray,$BoardID) {
global $DB, $DB2,$pagination, $querystring,$NumItemsPerPage,$SiteAdmins;

if ($ForumType == 'user') {
	$ForumSelect = "b.UserID='".$UserArray->encryptid."'";
	$ForumLinkTarget = 'http://users.wevolt.com/'.trim($TargetName).'/forum/';

} else if ($ForumType == 'project') {
	$ForumSelect = "b.ProjectID='".$ProjectArray->ProjectID."'";
	$ForumLinkTarget = 'http://www.wevolt.com/'.trim($TargetName).'/forum/';
}

$query = "SELECT Moderators from pf_forum_boards where ID='$BoardID'"; 
 $Moderators = $DB->queryUniqueValue($query);
$ModeratorList = explode(',',$Moderators);
				if (in_array($_SESSION['username'], $ModeratorList))
					$IsModerator = true;
				else 
					$IsModerator = false;
					
$query = "SELECT b.Title as BoardTitle, b.EncryptID as BoardEnc, b.PrivacySetting as BoardPrivacy, b.OpenTopics, u.avatar, u.username, t.*, c.Title as CatTitle, (SELECT count(*) FROM pf_forum_messages as m WHERE m.TopicID = t.ID) AS TotalReplies
		  		from pf_forum_topics as t
				join pf_forum_boards as b on b.ID='$BoardID'
				left join users as u on t.LastUser=u.encryptid
				left join pf_forum_categories as c on c.ID=b.CatID 
		  		where t.BoardID='$BoardID' order by t.IsSticky DESC, t.LastReply DESC";
			
	//$DB->query($query);
	//if ($_SESSION['username'] == 'wevolt')
	//	echo $query;
	//echo $query.'<br/>';
	$pagination->createPaging($query,$NumItemsPerPage,$querystring);
	//$NumTopics = $DB->numRows();
	if ($ForumType == 'user') 
		$BoardThumb = $UserArray->avatar;
	else 
		$BoardThumb = 'http://www.wevolt.com'.$ProjectArray->thumb;
	
		
				
	echo '<div class="topic_container">';
		echo '<div class="pagination">'. $pagination->displayPaging().'</div>';

					echo '<div>';
				if (($IsModerator) || ($AdminUser) || (($topic->OpenTopics == 1 ) && ((($IsFriend)&&($topic->BoardPrivacy == 'friends')) || (($IsFan)&&($topic->BoardPrivacy == 'fans')) || (($topic->BoardPrivacy == 'public') && ($_SESSION['userid'] != '')))))
					echo '<div align="right"><a href="/forum/index.php?'.$ForumType.'='.$TargetName.'&a=new_topic&board='.$BoardID.'"><img src="http://www.wevolt.com/images/forums/new_topic.png" border="0" vspace="5"></a></div>';
	
					echo '</div>';
		
		
	$Cnt = 0;
	while($topic=mysql_fetch_object($pagination->resultpage)) {
					
				$query = "SELECT count(*) from pf_forum_messages as m
						  join pf_forum_topics as t on m.TopicID=t.ID 
						  where t.BoardID='".$forumboard->ID."'";
				$TotalPosts = $DB2->queryUniqueValue($query);
				
			     
				$query = "SELECT count(*) from pf_forum_read_log where UserID='".$_SESSION['userid']."' and TopicID='".$topic->ID."'";
				$AlreadyRead = $DB2->queryUniqueValue($query);
				
				if ((($topic->LastReply > $_SESSION['lastlogin']) || ($topic->CreatedDate > $_SESSION['lastlogin'])) && ($AlreadyRead == 0))
					$HasNew = true;
				else
					$HasNew = false;
				
				//print 'Last Reply = ' . $topic->LastReply;
				
				if (($TotalPosts == 0) && ($TotalTopics > 0))
					$TotalPosts = $TotalTopics;
			
				//$query = "SELECT username from users where encryptid='".$topic->LastUser."'";
				$LastPoster = $topic->username;
				
				
				$query = "SELECT count(*) from likes where ContentID='".$topic->ID."' and ContentType='forum_topic'";
				$NumLikes = $DB2->queryUniqueValue($query);
				
				$query = "SELECT count(*) from likes where ContentID='".$topic->ID."' and ContentType='forum_topic' and UserID='".$_SESSION['userid']."'";
				$LikedContent = $DB2->queryUniqueValue($query);
				
				
				
				//  && ((($topic->BoardPrivacy == 'public') && ($_SESSION['userid'] != '')) || (($IsFriend)&&($topic->BoardPrivacy == 'friends')) || (($IsFan)&&($topic->BoardPrivacy == 'fans'))) )				
				
				$Cnt++;		
				$Auth = 0;
				if (($IsModerator) || ($IsAdmin)) {
					$Auth = 1;
				} else if (($topic->PrivacySetting == 'friends') && ($IsFriend)){
						$Auth = 1;
				} else if (($topic->PrivacySetting == 'fans') && ($IsFriend) || ($IsFan) ){
						$Auth = 1;
				} else if ($topic->PrivacySetting == 'selective'){
						$query = "SELECT * from pf_forum_board_permissions where BoardID='$BoardID' and UserID = '$SessionUser' limit 1";
						$DB2->query($query);
						$Found = $DB2->numRows();
						if ($Found == 1) {
							while ($permission = $DB2->FetchNextObject()) {
									$Auth = 1;
									$AccessLevel = $permission->Permission;
							}
						}
	
				} else if ($topic->PrivacySetting =='groups') {
						$SelectedGroups = @explode(',',$topic->SelectedGroups);
						if ($SelectedGroups == null)
						 $SelectedGroups = array();
						foreach($SelectedGroups as $group) {
								$query = "SELECT GroupUsers from user_groups where ID='$group'";
								$GroupUsers = $DB2->queryUniqueValue($query);
								$GroupUserArray = @explode(',',$GroupUsers);
								if ($GroupUserArray == null)
									$GroupUserArray = array();
								if (in_array($_SESSION['userid'],$GroupUserArray)) {
									$Auth = 1;	
									break;
								}
						}			
				} else if (($topic->PrivacySetting == 'public') || ($topic->PrivacySetting == '')) {
					$Auth = 1;
				}
				if ($AdminUser) {
					$Auth = 1;
					$AccessLevel = 'admin';
				}
				
				if ($Auth == 1) {
				
					echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>
						   <tr>
						   <td id=\"updateBox_TL\"></td>
						   <td id=\"updateBox_T\"></td>
						   <td id=\"updateBox_TR\"></td>
						   </tr><tr>
						   <td class=\"updateboxcontent\"></td>
						   <td valign='top' class=\"updateboxcontent\">
								<table width='100%'>
									<tr>
										<td width='55'>
										<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=read&topic=".$topic->ID."&board=".$topic->BoardID."'>
										<img src='".$BoardThumb."' alt='LINK' style='border:1px solid #000000;' width='25' height='25'></a>
										</td>
										<td width='45%'>
										<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=read&topic=".$topic->ID."&board=".$topic->BoardID."'>
										<div class='sender_name'>";
										if ($topic->IsSticky == 1)
											echo '*STICKY*&nbsp;&nbsp;&nbsp;';
										echo $topic->Subject;
											if ($HasNew) 
											echo "&nbsp;&nbsp;&nbsp;*NEW";
										echo "</div>
										</a>
										</td>
										<td width='50' class='messageinfo'><center>".$topic->TotalReplies."<br/>repl";
										if ($topic->TotalReplies == 1) 
										echo 'y';
										else
										echo 'ies';
										echo "</center></td>
										<td  width='50' class='messageinfo'><center>".$topic->Views."<br/>views</center></td>
										
										<td width='150' align='right'>";
			
										if ($LastPoster != '') 
											echo "<div class='updated_date' align='right'>
													Last Post ".date('m-d-Y',strtotime($topic->LastReply))."<br/
													>by ".$LastPoster."
													</div>";
				
								echo "</td>";
								echo "<td align='right' width='150'><span id='like_forum_topic".$topic->ID."'>";
								if ($NumLikes > 0) {
								
								echo $NumLikes .' like';
								if ($NumLikes != 1)
									echo 's';
								echo '&nbsp;&nbsp;';	
									}
						
								if (($LikedContent <1) && ($_SESSION['userid'] != ''))
									echo '<a href="#" onclick="like_content(\''.$topic->ID.'\',\'forum_topic\',\'like_forum_topic'.$topic->ID.'\',\'/forum/index.php?'.$ForumType.'='.$TargetName.'&a=read&topic='.$topic->ID.'\',\''.$topic->ProjectID.'\');return false;"><img src="/images/reader_like_btn.png" border="0" tooltip="Like this topic, boost it\'s rating!" tooltip_position="bottom"/></a>';
								echo '</span>';
							
								if (!$Volted)	
								
									echo '<a href="#" onClick="parent.volt_wizard(\''.$topic->EncryptID.'\',\''.$ForumType.'\',\'forum topic\');return false;"><img src="/images/reader_volt_btn.png" border="0" tooltip="Excite or Volt this topic" tooltip_position="bottom"/></a>';
								
											
									echo "</tr>
								</table>
							</td>
							<td class=\"updateboxcontent\"></td>
							</tr><tr>
							<td id=\"updateBox_BL\"></td>
							<td id=\"updateBox_B\"></td>
							<td id=\"updateBox_BR\"></td>
							</tr></table>
							<div class='spacer'></div>";
		}
}
		echo '<div class="pagination">'. $pagination->displayPaging().'</div>';
		
	echo '</div>';


}

function BuildMessage($TargetName, $ForumType,$Username, $Avatar,$PosterID,$TotalTopics, $TotalReplies,$CreatedDate,$Subject,$Message,$ForumSig, $IsModerator,$IsAdmin,$BoardArray,$MessageID)
{

global $SiteAdmins, $DB2;
$query = "SELECT level from users where encryptid='$PosterID'";
$Level = $DB2->queryUniqueValue($query);
if ($PosterID=='64223ccf3b0')
	$Level = 'epic';
echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>
						   <tr>
						   <td id=\"updateBox_TL\"></td>
						   <td id=\"updateBox_T\"></td>
						   <td id=\"updateBox_TR\"></td>
						   </tr><tr>
						   <td class=\"updateboxcontent\"></td>
						   <td valign='top' class=\"updateboxcontent\">
								<table width='100%'>
									<tr>
										<td  align='center' valign='top' class='info_text' style='background-color:#e5e5e5;' width='120'>
										<a href='http://users.wevolt.com/".trim($Username)."/'>
										<img src='".$Avatar."' alt='LINK' style='border:1px solid #000000;' border:1px height='100' hspace='3' vspace='3'></a><br/><div class='sender_name'>".trim($Username)."</div><div class='spacer'></div><div class='messageinfo'>";
										if (($IsModerator) && (!$IsAdmin))
											echo 'Moderator<br />';
										
										if ($IsAdmin)
											echo 'Administrator<br />';
										
									
										echo "Started Topics: ".$TotalTopics."<br/>Total Replies: ".$TotalReplies.'<br/>';
										echo 'WEvolt Level: '.$Level;
										echo "</div></td>
										<td valign='top' style='padding-left:10px;'>";
													
										if ($_SESSION['username'] != ''){
											echo "<div class='info_text' align='right'>";
											if (($PosterID==$_SESSION['userid']) || (in_array($_SESSION['userid'],$SiteAdmins))){
			echo "<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=edit_topic&board=".$BoardArray['BoardID']."&page=".$_GET['page']."&topic=".$BoardArray['TopicID'];
			if ($MessageID != '') 
				echo "&msg=".$MessageID;
			echo "'><img src='http://www.wevolt.com/images/forums/edit_post.png' border='0' vspace='5'></a>";
											}
											if (($BoardArray['TopicLocked'] != 1) && ($MessageID != ''))
												echo "<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=reply&board=".$BoardArray['BoardID']."&page=".$_GET['page']."&topic=".$BoardArray['TopicID']."&rmid=".$MessageID."'><img src='http://www.wevolt.com/images/forums/reply_post.png' border='0' vspace='5'></a>";
											else if ($BoardArray['TopicLocked'] != 1)
												echo "<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=reply&board=".$BoardArray['BoardID']."&page=".$_GET['page']."&topic=".$BoardArray['TopicID']."&rtid=".$BoardArray['TopicID']."'><img src='http://www.wevolt.com/images/forums/reply_post.png' border='0' vspace='5'></a>";
											
										
										echo "</div>";
										}
										$Description = str_replace('<p>&nbsp;</p>', '',stripslashes($Message));
										$Description = str_replace('<br>','',$Description);
										
										echo"
										<div class='info_text' align='right'>".date('m-d-Y',strtotime($CreatedDate))."</div>
										<div class='sender_name'>".stripslashes($Subject)."</div>
										<div class='spacer'></div>
										<hr/>
										<div class='spacer'></div>
										<div class='messageinfo'>".$Description."</div>
										<div class='spacer'></div>
										<hr/>
										<div class='spacer'></div>
										<div class='info_text'>";
										
										if (($ForumSig == '') && (trim($_SESSION['username']) == trim($Username)))
											echo '<a href="javascript:void(0)" onclick="edit_signature();">Create a unique Signature Now!</a>';
										else 
											echo $ForumSig;
											
										if (($ForumSig != '') && (trim($_SESSION['username']) == trim($Username)))
											echo '<div><a href="javascript:void(0)" onclick="edit_signature();">Edit Signature</a></div>';
										
										echo "</div>
										</a>
										</td>
									</tr>
								</table>
							</td>
							<td class=\"updateboxcontent\"></td>
							</tr><tr>
							<td id=\"updateBox_BL\"></td>
							<td id=\"updateBox_B\"></td>
							<td id=\"updateBox_BR\"></td>
							</tr></table>
							<div class='spacer'></div>";
}


function BuildTopicMessages($TargetName, $ForumType, $ForumOwner,$IsFriend,$IsFan, $AdminUser, $UserArray, $ProjectArray,$TopicID) {
global $DB, $DB2,$pagination, $querystring,$NumItemsPerPage, $SiteAdmins;

if ($ForumType == 'user') {
	$ForumSelect = "b.UserID='".$UserArray->encryptid."'";
	$ForumLinkTarget = 'http://users.wevolt.com/'.trim($TargetName).'/forum/';

} else if ($ForumType == 'project') {
	$ForumSelect = "b.ProjectID='".$ProjectArray->ProjectID."'";
	$ForumLinkTarget = 'http://www.wevolt.com/'.trim($TargetName).'/forum/';
}

$query = "SELECT t.*, u.username, u.avatar, u.ForumSig, b.Moderators,b.ID as BoardID, b.PrivacySetting as BoardPrivacy, (SELECT count(*) from pf_forum_topics as t2 where t2.PosterID=t.PosterID) as TotalTopics, 
(SELECT count(*) from pf_forum_messages as m where t.PosterID=m.PosterID) as TotalReplies
		  from pf_forum_topics as t
		  join users as u on t.PosterID=u.encryptid 
		  join pf_forum_boards as b on t.BoardID=b.ID
 		  where t.ID='$TopicID' ";
$TopicArray = $DB->queryUniqueObject($query);


if ($TopicArray->PosterID == $ForumOwner)
	$IsAdmin = true;
else
	$IsAdmin = false;
	
$Moderators = explode(',',$TopicArray->Moderators);
if (in_array($TopicArray->username, $Moderators))
	$IsModerator = true;
else 
	$IsModerator = false;
	
$Auth = 0;
				if (($TopicArray) || ($IsAdmin)) {
					$Auth = 1;
				} else if (($TopicArray->PrivacySetting == 'friends') && ($IsFriend)){
						$Auth = 1;
				} else if (($TopicArray->PrivacySetting == 'fans') && ($IsFriend) || ($IsFan) ){
						$Auth = 1;
				} else if ($TopicArray->PrivacySetting == 'selective'){
						$query = "SELECT * from pf_forum_board_permissions where BoardID='$BoardID' and UserID = '$SessionUser' limit 1";
						$DB2->query($query);
						$Found = $DB2->numRows();
						if ($Found == 1) {
							while ($permission = $DB2->FetchNextObject()) {
									$Auth = 1;
									$AccessLevel = $permission->Permission;
							}
						}
	
				} else if ($TopicArray->PrivacySetting =='groups') {
						$SelectedGroups = @explode(',',$TopicArray->SelectedGroups);
						if ($SelectedGroups == null)
						 $SelectedGroups = array();
						foreach($SelectedGroups as $group) {
								$query = "SELECT GroupUsers from user_groups where ID='$group'";
								$GroupUsers = $DB2->queryUniqueValue($query);
								$GroupUserArray = @explode(',',$GroupUsers);
								if ($GroupUserArray == null)
									$GroupUserArray = array();
								if (in_array($_SESSION['userid'],$GroupUserArray)) {
									$Auth = 1;	
									break;
								}
						}			
				} else if (($topic->PrivacySetting == 'public') || ($topic->PrivacySetting == '')) {
					$Auth = 1;
				}
				if ($Auth == 1) {	
					$TopicViews = $TopicArray->Views;
					$TopicViews++;
					
					$query = "UPDATE  pf_forum_topics set Views='$TopicViews' where ID='$TopicID'";
					$DB->execute($query);
					
					$query = "SELECT count(*) from likes where ContentID='".$TopicArray->ID."' and ContentType='forum_topic'";
					$NumLikes = $DB->queryUniqueValue($query);
									
					$query = "SELECT count(*) from likes where ContentID='".$TopicArray->ID."' and ContentType='forum_topic' and UserID='".$_SESSION['userid']."'";
					$LikedContent = $DB->queryUniqueValue($query);
									
					
					$NOW = date('Y-m-d h:i:s');
					$query = "SELECT ID from pf_forum_read_log where UserID='".$_SESSION['userid']."' and TopicID='".$TopicArray->ID."'";
					$DB->query($query);
					$AlreadyRead = $DB->numRows();
					//print 'Already Read = ' . $AlreadyRead.'<br/>';
					//echo $query.'<br/>';
					if ($AlreadyRead == 0) {
						$query = "INSERT into pf_forum_read_log (TopicID, UserID, CreatedDate) values ('$TopicID','".$_SESSION['userid']."','$NOW')";
						$DB->execute($query);
					}
					//echo $query.'<br/>';
					$query = "SELECT m.*, u.username, u.avatar, u.ForumSig,
							  (SELECT count(*) from pf_forum_topics as t2 where t2.PosterID=m.PosterID) as TotalTopics, 
							  (SELECT count(*) from pf_forum_messages as m2 where m.PosterID=m2.PosterID) as TotalReplies
							  from pf_forum_messages as m 
							  join users as u on m.PosterID = u.encryptid where m.TopicID='$TopicID' order by m.CreatedDate ASC";	
							$pagination->createPaging($query,$NumItemsPerPage,$querystring);
							 $TotalPages = $pagination->pages;
					$LastPageSet = 0;
					
					
					if (($_GET['page'] == '') && ($TotalPages > 1)) {
						
					$query = "SELECT m.*, u.username, u.avatar, u.ForumSig,
							  (SELECT count(*) from pf_forum_topics as t2 where t2.PosterID=m.PosterID) as TotalTopics, 
							  (SELECT count(*) from pf_forum_messages as m2 where m.PosterID=m2.PosterID) as TotalReplies
							  from pf_forum_messages as m 
							  join users as u on m.PosterID = u.encryptid where m.TopicID='$TopicID' order by m.CreatedDate ASC";	
							$pagination->createPaging($query,$NumItemsPerPage,$querystring,$TotalPages);
							$LastPageSet = 1;
					}
						
								
						if ($ForumType == 'user') 
							$BoardThumb = $UserArray->avatar;
						else 
							$BoardThumb = 'http://www.wevolt.com'.$ProjectArray->Thumb;
						
					
						$BoardArray = array('BoardID'=>$TopicArray->BoardID, 'BoardPermissions'=>$TopicArray->BoardPrivacy,'TopicLocked'=>$TopicArray->IsLocked,'TopicPermissions'=>$TopicArray->PrivacySetting,'TopicID'=>$_GET['topic']);
							
							if ($MessageID == '')
								$RMID = $BoardArray['TopicID'];
							else
								$RMID = $MessageID;
							
							if ($_SESSION['username'] != '') {
								echo "<div class='info_text' align='right'><table width=\"100%\"><tr><td width=\"77%\" align=\"right\">";
								
								if ($NumLikes > 0) {		
								echo $NumLikes .' like';
								if ($NumLikes != 1)
									echo 's';
								echo '&nbsp;&nbsp;';	
							}
											
							if (($LikedContent <1) && ($_SESSION['userid'] != ''))
								echo '<a href="#" onclick="like_content(\''.$TopicArray->ID.'\',\'forum_topic\',\'like_forum_topic'.$TopicArray->ID.'\',\'/forum/index.php?'.$ForumType.'='.$TargetName.'&a=read&topic='.$TopicArray->ID.'\',\''.$topic->ProjectID.'\');return false;"><img src="/images/reader_like_btn.png" border="0" tooltip="Like this topic, boost it\'s rating!" tooltip_position="bottom"/></a>';
							
								echo '</span><div style=\"height:5px;\"></div>';
												
							if (!$Volted)	
								echo '<td width=\"25\"><a href="#" onClick="parent.volt_wizard(\''.$TopicArray->EncryptID.'\',\''.$ForumType.'\',\'forum topic\');return false;" tooltip="Excite or Volt this topic" tooltip_position="bottom"><img src="/images/reader_volt_btn.png" border="0"/></a></td>';
								
								
								
								echo "</td><td align=\"right\" width=\"200\">";
								if (($TopicArray->PosterID==$_SESSION['userid']) || (in_array($_SESSION['userid'],$SiteAdmins)))
								echo "<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=edit_topic&topic=".$BoardArray['TopicID']."&board=".$BoardArray['BoardID']."'><img src='http://www.wevolt.com/images/forums/edit_post.png' border='0' vspace='5'></a>";
								
								if ($BoardArray['TopicLocked'] != 1)
								echo "<a href='/forum/index.php?".$ForumType."=".$TargetName."&a=reply&topic=".$BoardArray['TopicID']."&board=".$BoardArray['BoardID']."'><img src='http://www.wevolt.com/images/forums/new_post.png' border='0' vspace='5'></a>";
								
								echo "</td></tr></table>";
							
							
															
							
						
							echo "</div>";
															}
						echo '<div class="message_container">';	
						echo '<div class="pagination">'. $pagination->displayPaging().'</div>';		
									
								if ((($_GET['page'] == '') && (($TotalPages == 1)||($TotalPages == 0)))|| ($_GET['page'] == 1)) 				
								BuildMessage($TargetName, $ForumType,$TopicArray->username, $TopicArray->avatar,$TopicArray->PosterID,$TopicArray->TotalTopics, $TopicArray->TotalReplies,$TopicArray->CreatedDate,$TopicArray->Subject,$TopicArray->Message,$TopicArray->ForumSig, $IsModerator, $IsAdmin,$BoardArray,$MessageID);	
								
						while($message=mysql_fetch_object($pagination->resultpage)) {
								$MessageID = $message->ID;
								
								if ($message->PosterID == $ForumOwner)
									$IsAdmin = true;
								else
									$IsAdmin = false;
								$query = "SELECT count(*) from pf_forum_messages where PosterID='".$message->PosterID."'";
								$TotalReplies = $DB2->queryUniqueValue($query);
					
								$Moderators = explode(',',$TopicArray->Moderators);
								if (in_array($message->username, $Moderators))
									$IsModerator = true;
								else 
									$IsModerator = false;
							//	print_r($message);
								BuildMessage($TargetName, $ForumType, $message->username, $message->avatar,$message->PosterID,$message->TotalTopics,$TotalReplies,$message->CreatedDate,$message->Subject,$message->Message,$message->ForumSig, $IsModerator, $IsAdmin,$BoardArray,$MessageID);	
								// BuildMessage(,$Username, $Avatar,$TotalPosts,$CreatedDate,$Subject,$Message,$ForumSig, $IsModerator,$IsAdmin,,$MessageID)	
							}
							echo '<div class="pagination">'. $pagination->displayPaging().'</div>';
				} else {
						echo 'You do not have access to this topic.';	
					
				}
	echo '</div>';


}



function BuildBreadCrumb($TargetName,$ForumType,  $CatID,$BoardID, $TopicID, $Action,$Home,$AdminUser) {
		global $DB, $DB2;
		
		$query = "SELECT Title from pf_forum_categories where ID='$CatID'";
		$CatTitle = $DB->queryUniqueValue($query);
		
		$query = "SELECT Title from pf_forum_boards where ID='$BoardID'";
		$BoardTitle = $DB->queryUniqueValue($query);
		
		$query = "SELECT Subject from pf_forum_topics where ID='$TopicID'";
		$TopicTitle = $DB->queryUniqueValue($query);		
				
		echo '<table width="100%"><tr><td id="breadcrumb">';
	//	echo  'TARGET NAME = ' . $TargetName.' ';
		if ($Home)
			echo 'Home';
		else 
			echo '<a href="/forum/index.php?'.$ForumType.'='.$TargetName.'">'.$TargetName.'</a>';
			
		if ($CategoryTitle != '')
			echo  ' -> <a href="/forum/index.php?'.$ForumType.'='.$TargetName.'&c='.$CatID.'">'.$CategoryTitle.'</a>';
		
		if ($BoardTitle != '')
			echo  ' -> <a href="/forum/index.php?'.$ForumType.'='.$TargetName.'&a=read&board='.$BoardID.'">'.$BoardTitle.'</a>';
			
		if ($TopicTitle != '')
			echo  ' -> <a href="/forum/index.php?'.$ForumType.'='.$TargetName.'&a=read&topic='.$TopicID.'">'.$TopicTitle.'</a>';
			
		if ($Action == 'reply')
				echo  ' -> reply';
		
		if ($Action == 'post')
				echo  ' -> new post';
		if ($Action == 'new_topic')
				echo  ' -> new topic';
	echo '</td><td align="right" width="100">';
	if (($AdminUser) && ($_GET['a'] != 'admin'))
		echo '<a href="/forum/index.php?'.$ForumType.'='.$TargetName.'&a=admin"><img src="http://www.wevolt.com/images/forums/forum_admin.png" vspace="5" border="0"></a>';
		
	echo '</td></tr></table><div class="spacer"></div>';	
}

function PostTopic($BoardID, $Subject, $Message, $Sticky, $Locked, $PosterID, $UserArray, $ProjectArray,$PrivacySetting,$Tags, $Notify, $SelectedGroups='') {
				global $DB, $DB2;
				$NOW = date('Y-m-d h:i:s');
				if (is_array($SelectedGroups)) 
					$GroupList =@implode(",",$SelectedGroups);
				
				$query = "SELECT ID from pf_forum_boards where EncryptID='$BoardID'";
				$BID = $DB->queryUniqueValue($query);
				
				if ($BID == 0) {
					$query = "SELECT ID from pf_forum_boards where ID='$BoardID'";
					$BID = $DB->queryUniqueValue($query);
				}
				
				$BoardID = $BID;
				
				$query = "INSERT into pf_forum_topics (Subject, ProjectID, BoardID, UserID, PosterID, IsSticky, PrivacySetting, Tags, SelectedGroups, NotifyOnReply, Message, IsLocked, CreatedDate) 
							values (
							'".mysql_real_escape_string($Subject)."',
							'".mysql_real_escape_string($ProjectArray->ProjectID)."',
							'".mysql_real_escape_string($BoardID)."',
							'".mysql_real_escape_string($UserArray->encryptid)."',
							'".mysql_real_escape_string($PosterID)."',
							$Sticky,
							'$PrivacySetting',
							'".mysql_real_escape_string($Tags)."',
							'".$GroupList."',
							$Notify,
							'".mysql_real_escape_string($Message)."',
							$Locked,'$NOW')";
							
							$DB->execute($query);
				$query ="SELECT ID from pf_forum_topics WHERE UserID='".$UserArray->encryptid."' and PosterID='$PosterID' and CreatedDate='$NOW'";
				$NewID = $DB->queryUniqueValue($query);
				//echo $query.'<br/>';
				//print 'NEW ID = ' . $NewID;
				$Encryptid = substr(md5($NewID), 0, 15).dechex($NewID);
				
				$IdClear = 0; 
				$Inc = 5;
				while ($IdClear == 0) {
						$query = "SELECT count(*) from pf_forum_topics where EncryptID='$Encryptid'";
						$Found = $DB->queryUniqueValue($query);
						$output .= $query.'<br/>';
						if ($Found == 1) {
							$Encryptid = substr(md5(($NewID+$Inc)), 0, 15).dechex($NewID+$Inc);
						} else {
							$query = "UPDATE pf_forum_topics SET EncryptID='$Encryptid' WHERE ID='$NewID'";
							$DB->execute($query);
							$output .= $query.'<br/>';
							$IdClear = 1;
						}
						$Inc++;
				}

				InsertProjectContent('new', $ProjectID, $Encryptid, 'forum topic', $PosterID,$Tags);

}

function PostReply($TopicID, $Subject, $Message, $PosterID, $UserArray, $ProjectArray, $Tags, $Notify) {
				global $DB, $DB2;
				$NOW = date('Y-m-d h:i:s');
				
				$query = "SELECT NotifyOnReply, u.email, t.Subject,t.BoardID, t.PosterID
				          from pf_forum_topics as t 
						  join users as u on t.PosterID=u.encryptid 
						  where t.ID='$TopicID'";
				$PosterArray = $DB->queryUniqueObject($query);

				if ($PosterArray->NotifyOnReply == 1) {
					$PosterEmail = $PosterArray->email;
					$TopicSubject = $PosterArray->Subject;
					$Username = $_GET['user'];
					$Project = $_GET['project'];
					if ($Username != '') {
						$ForumType = 'user';
						if ($Username == 'w3volt')	
							$Username = 'wevolt';
						$TargetName = trim($Username);
					} else if ($Project != '') {
						$ForumType = 'project';
						$TargetName = trim($Project);
					}
					
					$header = "From: NO-REPLY@wevolt.com  <NO-REPLY@wevolt.com >\n";
					$header .= "Reply-To: NO-REPLY@wevolt.com <NO-REPLY@wevolt.com>\n";
					$header .= "X-Mailer: PHP/" . phpversion() . "\n";
					$header .= "X-Priority: 1";

				//SEND USER EMAIL
					$PageLink = 'http://www.wevolt.com/forum/index.php?'.$ForumType.'='.$TargetName.'&a=read&board='.$PosterArray->BoardID.'&topic='.$TopicID;
					$to = $PosterArray->email;
					$subject = $_SESSION['username'].' has posted a reply to your forum topic: '. $PosterArray->Subject.'';
					$body .= "You have a new post from ".$_SESSION['username']." on your forum topic:". $PosterArray->Subject."\n\nClick here to read: <a href='".$PageLink."'>".$PageLink."</a>"; 
					$WemailBody = "You have a new post from ".$_SESSION['username']." on your forum topic:". $PosterArray->Subject."\n\nClick here to read: <a href='#' onclick=\"parent.window.location.href='".$PageLink."';\">".$PageLink."</a>"; 
					 mail($to, $subject, $body, $header);
					
					$body = mysql_real_escape_string($WemailBody);
					$DateNow = date('m-d-Y');
					$query = "INSERT into panel_panel.messages 
									(userid, sendername, senderid, subject, message, date) 
									values 
									('$PosterArray->PosterID','".$_SESSION['username']."','".$_SESSION['userid']."','You have a reply on a forum topic','".mysql_real_escape_string($WemailBody)."','$DateNow')";
					$DB->execute($query);					
				}
								
				$query = "INSERT into pf_forum_messages (TopicID,Subject, ProjectID,UserID, PosterID, Tags, NotifyOnReply, Message, CreatedDate) 
							values (
							'".mysql_real_escape_string($TopicID)."',
							'".mysql_real_escape_string($Subject)."',
							'".mysql_real_escape_string($ProjectArray->ProjectID)."',
							'".mysql_real_escape_string($UserArray->encryptid)."',
							'".mysql_real_escape_string($PosterID)."',
							'".mysql_real_escape_string($Tags)."',
							$Notify,
							'".mysql_real_escape_string($Message)."',
							'$NOW')";
							
							$DB->execute($query);
				$query ="SELECT ID from pf_forum_messages WHERE TopicID='$TopicID' and PosterID='$PosterID' and CreatedDate='$NOW'";
				$NewID = $DB->queryUniqueValue($query);
				//print $query.'<br/>';
			//	print 'NEW ID = ' . $NewID.'<br/>';
				$Encryptid = substr(md5($NewID), 0, 15).dechex($NewID);
				
				$IdClear = 0;
				$Inc = 5;
				while ($IdClear == 0) {
						$query = "SELECT count(*) from pf_forum_messages where EncryptID='$Encryptid'";
						$Found = $DB->queryUniqueValue($query);
						$output .= $query.'<br/>';
						if ($Found == 1) {
							$Encryptid = substr(md5(($NewID+$Inc)), 0, 15).dechex($NewID+$Inc);
						} else {
							$query = "UPDATE pf_forum_messages SET EncryptID='$Encryptid' WHERE ID='$NewID'";
							$DB->execute($query);
							$output .= $query.'<br/>';
							$IdClear = 1;
						}
						$Inc++;
				}

				InsertProjectContent('replied', $ProjectID, $Encryptid, 'forum post', $PosterID, $Tags);
				
				$query = "SELECT * from pf_forum_topics where ID='$TopicID'"; 
				$TopicArray = $DB->queryUniqueObject($query);
				$NumberReplies = $TopicArray->NumberReplies;
				$NumberReplies++;
				
				$query = "UPDATE pf_forum_topics set NumberReplies='$NumberReplies', LastReply='$NOW', LastUser='".$_SESSION['userid']."' where ID='$TopicID'"; 
				$DB->execute($query);
			
				//NEED TO ADD ALERT ON REPLY

}

function ModifyPost($TopicID, $MessageID, $Subject, $Message, $PosterID, $UserArray, $ProjectArray, $Tags, $Notify, $IsSticky, $IsLocked, $Privacy) {
				global $DB, $DB2;
				$NOW = date('Y-m-d h:i:s');
						
				if ($MessageID == '') {
					$query = "SELECT count(*) from pf_forum_topics where PosterID='".$_SESSION['userid']."' and ID='$TopicID'";
					$Auth = $DB->queryUniqueValue($query);
					if ($Auth != 0) {
					$query = "UPDATE pf_forum_topics set 
							Subject='".mysql_real_escape_string($Subject)."',
							ProjectID='".$ProjectArray->ProjectID."',
							Tags='".mysql_real_escape_string($Tags)."', 
							NotifyOnReply='$Notfiy', 
							Message='".mysql_real_escape_string($Message)."', 
							IsLocked='$IsLocked', 
							IsSticky='$IsSticky',
							PrivacySetting='$Privacy',
							LastEdit='$NOW' 
							where ID='$TopicID'";
							$DB->execute($query);
					}
					
				} else {
					$query = "SELECT count(*) from pf_forum_messages where PosterID='".$_SESSION['userid']."' and ID='$MessageID'";
					$Auth = $DB->queryUniqueValue($query);
					if ($Auth != 0) {
						$query = "UPDATE pf_forum_messages set 
							Subject='".mysql_real_escape_string($Subject)."',
							ProjectID='".$ProjectArray->ProjectID."',
							Tags='".mysql_real_escape_string($Tags)."', 
							NotifyOnReply='$Notfiy', 
							Message='".mysql_real_escape_string($Message)."', 
							LastEdit='$NOW' 
							where ID='$MessageID'";
							$DB->execute($query);
					}
				}

}
?>