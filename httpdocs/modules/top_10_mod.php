<?php
if ($mVersion ==2) {
		
	$iwidth=86;
	$iheight=86;	
	} else {
		$iwidth=55;
		$iheight=82;	
		
		
	}
	$string = '';
if ($mVersion!=2) 
$string = '<table><tr>';
if ($ModContent == 'forums') {
	$query = "SELECT b.ProjectID, p.thumb, p.title, p.SafeFolder, u.username, u.avatar
			  FROM `pf_forum_messages` AS pm
			  JOIN pf_forum_topics AS t ON pm.TopicID = t.ID
			  JOIN pf_forum_boards AS b ON b.ID = t.BoardID
			  JOIN users AS u ON pm.UserID = u.encryptid
			  LEFT JOIN projects AS p ON b.ProjectID = p.ProjectID
			  GROUP BY b.ProjectID
			  LIMIT 10";
	$results = @$InitDB->fetchAll($query);
	foreach ($results as $i => $comic) {
		if ($comic['ProjectID'] != ''){
			$TargetType = 'r3forum';
			$TargetName= $comic['SafeFolder'];
			$ProjectThumb = 'http://www.wevolt.com'.$comic['thumb'];
			$Title =  stripslashes($comic['title']);
		}else{
			$TargetType = 'w3forum';
			$TargetName= trim($comic['username']);
			$ProjectThumb = $comic['avatar'];
			$Title = $TargetName;
		}
		if (!is_array(@getimagesize($ProjectThumb))) {
			$ProjectThumb ="/images/no_thumb_project.jpg";	
		}
		if ($mVersion!=2) 
		$string .= '<td align="center" valign="top" width="50" height="50"><div class="small_text">'.$i.'</div><a href="http://www.wevolt.com/'.$TargetType.'/'.$TargetName.'/"><img src="'.$ProjectThumb.'" width="'.$iwidth.'" height="'.$iheight.'" border="0"></a><div class="small_blue_title">'.$Title.'</div></td>';
		else 
		$string .= '<a href="http://www.wevolt.com/'.$TargetType.'/'.$TargetName.'/"><img src="'.$ProjectThumb.'" width="'.$iwidth.'" height="'.$iheight.'" border="0" tooltip="'.$Title.'"></a>';
	}
} else {
	
	switch ($ModContent) {
		case 'comics':
			$where = " and c.pages > 0 and c.projecttype = 'comic' ";
			break;
		case 'writing':
			$where = " and c.pages > 0 and c.projecttype = 'writing' ";
			break;
		case 'blogs':
			$where = " and c.projecttype = 'blog' ";
	}
	if ($_SESSION['overage'] == 'N' || $_SESSION['overage'] == '') {
		$where .= " and c.rating != 'a' ";
	}
	$query = "select * from projects as c
			  join rankings as r on c.ProjectID=r.ComicID
			  where c.installed = 1 and c.Published = 1 and IsPublic=1 and c.Hosted = 1". $where." 
			  ORDER BY r.ID ASC limit 10";
			
	$results = @$InitDB->fetchAll($query);
	foreach ($results as $i => $row) {
		$ProjectThumb = $row['thumb'];
//		$ProjectThumb = 'http://www.wevolt.com'.$comic['thumb'];
//		if (!is_array(@getimagesize($ProjectThumb))) {
//			$ProjectThumb = "/images/no_thumb_project.jpg";	
//		}
if ($mVersion!=2) 
		$string .= '<td align="center" valign="top" width="100"><div class="small_text">'.($i+1).'</div><a href="http://www.wevolt.com/'.$row['SafeFolder'].'/"><img src="http://www.wevolt.com'.$ProjectThumb.'" width="'.$iwidth.'" height="'.$iheight.'" border="0"></a><div class="small_blue_title">'.$row['title'].'</div></td>';
		else 
		$string .= '<a href="http://www.wevolt.com/'.$row['SafeFolder'].'/"><img src="'.$ProjectThumb.'" width="'.$iwidth.'" height="'.$iheight.'" border="0" tooltip="<h2>'.$row['title'].'</h2>'.$row['synopsis'].'"></a>';
	}
}
if ($mVersion!=2) 
$string .= '</tr></table>';
echo $string;