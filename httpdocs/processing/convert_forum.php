<?php 
include '../includes/db.class.php';
include '../includes/content_functions.php';
$DB = new DB();

// InsertProjectContent('new', $ProjectID, $NewID, 'forum topic', $PosterID,$Tags);
// InsertProjectContent('replied', $ProjectID, $NewID, 'forum post', $PosterID, $Tags);

// InsertProjectContent('new', $ProjectID, $NewID, 'forum board', $ForumOwner,$Tags);
/*
$query = "SELECT * from panel_forum.smfcategories";
$DB->query($query);
while ($Cat = $DB->FetchNextObject()) {
	$CatID = $Cat->ID_CAT;
	$CatName = $Cat->name;
	$Position = $Cat->Position;
	print 'CAT NAME = '.$CatName.'<br/>'; 
	$DB2 = new DB();
	$NOW = date('Y-m-d h:i:s');
	$query = "INSERT into pf_forum_categories (ID, UserID, Title, Position, CreatedDate) values ('$CatID', 'w3x987631239087632', '".mysql_real_escape_string($CatName)."', '$Position', '$NOW')";
	$DB2->execute($query);
	$query ="SELECT ID from pf_forum_categories WHERE Title='".mysql_real_escape_string($CatName)."'and  CreatedDate='$NOW'";
	$ID = $DB2->queryUniqueValue($query);
	$Encryptid = substr(md5($ID), 0, 12).dechex($ID);
	$query = "UPDATE pf_forum_categories SET EncryptID='$Encryptid' WHERE ID='$ID'";
	$DB2->query($query);

} 



$query = "SELECT t.*,m.*, u.encryptid
		  from panel_forum.smftopics as t
		  join panel_forum.smfmessages as m on t.ID_FIRST_MSG=m.ID_MSG
		   join panel_forum.smfboards as b on t.ID_BOARD=b.ID_BOARD
		   join panel_forum.smfcategories as c on b.ID_CAT=c.ID_CAT
		  join panel_forum.smfmembers as smfu on m.ID_MEMBER=smfu.ID_MEMBER
		  join panel_forumsmfmembers_panelusers as smfpu on m.ID_MEMBER=smfpu.ID_MEMBER
		  join users as u on u.userid=smfpu.userid where c.ID_CAT != 2";
$DB->query($query);
while ($Cat = $DB->FetchNextObject()) {
	$CatID = $Cat->ID_CAT;
	$CatName = $Cat->name;
	$Position = $Cat->Position;
	print 'CAT NAME = '.$CatName.'<br/>'; 
	$DB2 = new DB();
	$NOW = date('Y-m-d h:i:s');
	$query = "INSERT into pf_forum_categories (ID, UserID, Title, Position, CreatedDate) values ('$CatID', 'w3x987631239087632', '".mysql_real_escape_string($CatName)."', '$Position', '$NOW')";
	$DB2->execute($query);
	$query ="SELECT ID from pf_forum_categories WHERE Title='".mysql_real_escape_string($CatName)."'and  CreatedDate='$NOW'";
	$ID = $DB2->queryUniqueValue($query);
	$Encryptid = substr(md5($ID), 0, 12).dechex($ID);
	$query = "UPDATE pf_forum_categories SET EncryptID='$Encryptid' WHERE ID='$ID'";
	$DB2->query($query);

} 

$query = "SELECT m.*, u.encryptid as PosterID
		
		  from panel_forum.smfmessages as m 
		    join panel_forum.smftopics as t on t.ID_TOPIC=m.ID_TOPIC
		   join panel_forum.smfboards as b on t.ID_BOARD=b.ID_BOARD
		   join panel_forum.smfcategories as c on b.ID_CAT=c.ID_CAT
		  join panel_forum.smfmembers as smfu on m.ID_MEMBER=smfu.ID_MEMBER
		  join panel_forum.smfmembers_panelusers as smfpu on m.ID_MEMBER=smfpu.ID_MEMBER
		  join panel_panel.users as u on u.userid=smfpu.userid 
		  where c.ID_CAT != 2 and t.ID_FIRST_MSG != m.ID_MSG
		   order by m.ID_TOPIC";
		  
$DB->query($query);
while ($Cat = $DB->FetchNextObject()) {
	$TopicID = $Cat->ID_TOPIC;
	$MSGID = $Cat->ID_MSG;
	$Subject = $Cat->subject;
	$Message = $Cat->body;
	$PostDate = date("Y-m-d h:i:s", $Cat->posterTime);
	$PosterID = $Cat->PosterID;
	if ($PosterID == 'd67d8ab427') 
		$PosterID = 'w3x987631239087632';
	print 'Subject = '.$Subject.'<br/>'; 
	
	$DB2 = new DB();
	//$NOW = date('Y-m-d h:i:s');
	
	$query = "INSERT into pf_forum_messages (ID, UserID, TopicID, PosterID, Subject, Message, CreatedDate) values ('$MSGID', 'w3x987631239087632', '$TopicID', '$PosterID','".mysql_real_escape_string($Subject)."', '".mysql_real_escape_string($Message)."','$PostDate')";
	$DB2->execute($query);
	print $query.'<br/>';

	$query ="SELECT ID from pf_forum_messages WHERE Subject='".mysql_real_escape_string($Subject)."'and  CreatedDate='$PostDate'";
	$ID = $DB2->queryUniqueValue($query);
	print $query.'<br/>';
	$Encryptid = substr(md5($ID), 0, 12).dechex($ID);
	$query = "UPDATE pf_forum_messages SET EncryptID='$Encryptid' WHERE ID='$ID'";
	$DB2->query($query);
	print $query.'<br/>';
	InsertProjectContent('replied', $ProjectID, $ID, 'forum post', $PosterID, $Tags);

} 
*/

$query = "SELECT m.*, u.encryptid as PosterID
		  from panel_forum.smfmessages as m 
		  join panel_forum.smftopics as t on t.ID_TOPIC=m.ID_TOPIC
		   join panel_forum.smfboards as b on t.ID_BOARD=b.ID_BOARD
		   join panel_forum.smfcategories as c on b.ID_CAT=c.ID_CAT
		  join panel_forum.smfmembers as smfu on m.ID_MEMBER=smfu.ID_MEMBER
		  join panel_forum.smfmembers_panelusers as smfpu on m.ID_MEMBER=smfpu.ID_MEMBER
		  join panel_panel.users as u on u.userid=smfpu.userid 
		  where b.ID_BOARD = 8 and t.ID_FIRST_MSG != m.ID_MSG
		  order by m.ID_TOPIC";
		  
$DB->query($query);
while ($Cat = $DB->FetchNextObject()) {
	$TopicID = $Cat->ID_TOPIC;
	$MSGID = $Cat->ID_MSG;
	$Subject = $Cat->subject;
	$Message = $Cat->body;
	$PostDate = date("Y-m-d h:i:s", $Cat->posterTime);
	$PosterID = $Cat->PosterID;
	if ($PosterID == 'd67d8ab427') 
		$PosterID = 'w3x987631239087632';
	print 'Subject = '.$Subject.'<br/>'; 
	
	$DB2 = new DB();
	//$NOW = date('Y-m-d h:i:s');
	
	$query = "INSERT into pf_forum_messages (ID, UserID, TopicID, PosterID, Subject, Message, CreatedDate) values ('$MSGID', '85422afb20e', '$TopicID', '$PosterID','".mysql_real_escape_string($Subject)."', '".mysql_real_escape_string($Message)."','$PostDate')";
	$DB2->execute($query);
	print $query.'<br/>';

	$query ="SELECT ID from pf_forum_messages WHERE Subject='".mysql_real_escape_string($Subject)."'and  CreatedDate='$PostDate'";
	$ID = $DB2->queryUniqueValue($query);
	print $query.'<br/>';
	$Encryptid = substr(md5($ID), 0, 12).dechex($ID);
	$query = "UPDATE pf_forum_messages SET EncryptID='$Encryptid' WHERE ID='$ID'";
	$DB2->query($query);
	print $query.'<br/>';
	InsertProjectContent('replied', $ProjectID, $ID, 'forum post', $PosterID, $Tags);
}

$query = "SELECT t.*,m.*, u.encryptid as PosterID, 
		(SELECT m2.posterTime from panel_forum.smfmessages as m2 where m2.ID_MSG=t.ID_LAST_MSG) as LastReply,
		(SELECT u2.encryptid 
		 from panel_forum.smfmembers_panelusers as smfpu2
		 join panel_panel.users as u2 on smfpu2.userid=u2.userid 
		 where t.ID_MEMBER_UPDATED=smfpu2.ID_MEMBER) as LastUser
		  from panel_forum.smftopics as t
		   join panel_forum.smfmessages as m on t.ID_FIRST_MSG=m.ID_MSG
		   join panel_forum.smfboards as b on t.ID_BOARD=b.ID_BOARD
		   join panel_forum.smfcategories as c on b.ID_CAT=c.ID_CAT
		  join panel_forum.smfmembers as smfu on m.ID_MEMBER=smfu.ID_MEMBER
		  join panel_forum.smfmembers_panelusers as smfpu on m.ID_MEMBER=smfpu.ID_MEMBER
		  join panel_panel.users as u on u.userid=smfpu.userid 
		  where b.ID_BOARD = 8
		  order by m.ID_TOPIC";
		  
$DB->query($query);
while ($Cat = $DB->FetchNextObject()) {
	$TopicID = $Cat->ID_TOPIC;
	$Sticky = $Cat->isSticky;
	$BoardID= $Cat->ID_BOARD;
	$Subject = $Cat->subject;
	$Message = $Cat->body;
	$numberReplies = $Cat->numReplies;
	$Views = $Cat->numViews;
	$Locked = $Cat->locked;
	$PostDate = date("Y-m-d h:i:s", $Cat->posterTime);
	$LastReply = date("Y-m-d h:i:s", $Cat->LastReply);
	$LastUser = date("Y-m-d h:i:s", $Cat->LastUser);
	$PosterID = $Cat->PosterID;
	if ($PosterID == 'd67d8ab427') 
		$PosterID = 'w3x987631239087632';
	print 'Subject = '.$Subject.'<br/>'; 
	
	$DB2 = new DB();
	//$NOW = date('Y-m-d h:i:s');
	
	$query = "INSERT into panel_panel.pf_forum_topics (ID, UserID, BoardID, ProjectID, PosterID, Subject, Message, CreatedDate, IsSticky, IsLocked, LastReply, LastUser,NumberReplies, Views) values ('$TopicID', '85422afb20e', $BoardID,  'ef575e881d8', '$PosterID','".mysql_real_escape_string($Subject)."', '".mysql_real_escape_string($Message)."','$PostDate', $Sticky, $Locked, '$LastReply', '$LastUser',$numberReplies, $Views)";
	$DB2->execute($query);
	print $query.'<br/>';

	$query ="SELECT ID from panel_panel.pf_forum_topics WHERE Subject='".mysql_real_escape_string($Subject)."'and  CreatedDate='$PostDate'";
	$ID = $DB2->queryUniqueValue($query);
	print $query.'<br/>';
	$Encryptid = substr(md5($ID), 0, 12).dechex($ID);
	$query = "UPDATE panel_panel.pf_forum_topics SET EncryptID='$Encryptid' WHERE ID='$ID'";
	$DB2->query($query);
	print $query.'<br/>';
	InsertProjectContent('replied', 'ef575e881d8', $ID, 'forum topic', $PosterID, $Tags);

}

/*
$query = "SELECT b.*
			from panel_forum.smfboards as b
		  where b.ID_BOARD = 9
		  order by b.boardOrder";
		  
$DB->query($query);
while ($Cat = $DB->FetchNextObject()) {
	$BoardID = $Cat->ID_BOARD;
	$Subject = $Cat->name;
	$Message = $Cat->description;
	$Position = $Cat->boardOrder;
	$CatID = $Cat->ID_CAT;
	
	print 'Subject = '.$Subject.'<br/>'; 
	
	$DB2 = new DB();
	$NOW = date('Y-m-d h:i:s');
	
	$query = "INSERT into panel_panel.pf_forum_boards (ID, UserID, ProjectID, Title, Description, CatID, CreatedDate, PrivacySetting, Position) values ('$BoardID', '85422afb20e', 'ef575e881d8', '".mysql_real_escape_string($Subject)."', '".mysql_real_escape_string($Message)."','$CatID', '$NOW', 'public', $Position)";
	$DB2->execute($query);
	print $query.'<br/>';

	$query ="SELECT ID from panel_panel.pf_forum_boards WHERE Title='".mysql_real_escape_string($Subject)."'and  CreatedDate='$NOW'";
	$ID = $DB2->queryUniqueValue($query);
	print $query.'<br/>';
	$Encryptid = substr(md5($ID), 0, 12).dechex($ID);
	$query = "UPDATE panel_panel.pf_forum_boards SET EncryptID='$Encryptid' WHERE ID='$ID'";
	$DB2->query($query);
	print $query.'<br/>';
	InsertProjectContent('new', 'ef575e881d8', $ID, 'forum board', '85422afb20e', $Tags);

}
*/
$DB->close();
$DB2->close();
?>


