<? 

$query = "select e.Blurb, e.Comment, e.Link, u.avatar, u.username,e.CreatedDate
		 from excites as e
		 join users as u on e.UserID=u.encryptid
		where u.username='$ModUser' and e.OnFront=1 order by CreatedDate DESC";

$InitDB->query($query);
$Count = 1;
$PostArray=array();
while ($comic = $InitDB->FetchNextObject()) {
$PostArray[]=array($comic->CreatedDate,$comic->Blurb,$comic->Link,$comic->avatar,'excite');
$Avatar = $comic->avatar;
	//if ($Count == 1)
		//echo "<table width='100%'><tr><td width='80'><img src='/includes/round_images_inc.php?source=".$comic->avatar."&radius=20&colour=ffffff' alt='LINK' border='0' width='75' height='75'></td><td valign='top' style='padding-left:10px;'><div style=\"height:89px;overflow:auto;\">";
		//if ($comic->BlogPost == '') {
	//	echo '<div class="messageinfo"><a href="'..'">'.$comic->Blurb.'</a></div><div class="smspacer"></div><div class="smspacer"></div>';
		//} else {
		//echo '<div class="messageinfo"><a href="http://users.wevolt.com/'.$comic->username.'/?t=blog&post='.$comic->BlogPost.'">'.$comic->Title.'</a></div><div class="smspacer"></div><div class="smspacer"></div>';
		
	//	}
	//$Count++;
}
$Today = date('Y-m-d 00:00:00');
$query = "select b.Title,b.EncryptID as BlogPost, p.thumb, p.SafeFolder, b.PublishDate
		 from pfw_blog_posts as b
		 join projects as p on b.ComicID=p.ProjectID
		where b.ComicID='$ModProject' and b.OnFront=1 and b.PublishDate<='$Today' order by b.PublishDate DESC limit 10";

$InitDB->query($query);

while ($comic = $InitDB->FetchNextObject()) {
$PostArray[]=array($comic->PublishDate,$comic->Title,'http://www.wevolt.com/'.$comic->SafeFolder.'/blog/?post='.$comic->BlogPost,$comic->thumb,'blog');

	//if ($Count == 1)
		//echo "<table width='100%'><tr><td width='80'><img src='/includes/round_images_inc.php?source=".$comic->avatar."&radius=20&colour=ffffff' alt='LINK' border='0' width='75' height='75'></td><td valign='top' style='padding-left:10px;'><div style=\"height:89px;overflow:auto;\">";
		//if ($comic->BlogPost == '') {
	//	echo '<div class="messageinfo"><a href="'..'">'.$comic->Blurb.'</a></div><div class="smspacer"></div><div class="smspacer"></div>';
		//} else {
		//echo '<div class="messageinfo"><a href="http://users.wevolt.com/'.$comic->username.'/?t=blog&post='.$comic->BlogPost.'">'.$comic->Title.'</a></div><div class="smspacer"></div><div class="smspacer"></div>';
		
	//	}
	//$Count++;
}


rsort($PostArray);
$Count = 1;
foreach($PostArray as $item) {
if ($Count == 1)
		echo "<table width='100%'><tr><td width='80'><img src='".$Avatar ."' alt='LINK' border='0' width='75' height='75'></td><td valign='top' style='padding-left:10px;'><div style=\"height:89px;overflow:auto;\">";
		
		echo '<div class="messageinfo"><a href="'.$item[2].'">'.$item[1].'</a></div><div class="smspacer"></div><div class="smspacer"></div>';

	$Count++;


}

if ($Count > 1)
echo '</div></td></tr></table>';


?>