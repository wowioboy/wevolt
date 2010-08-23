<? 
function GetBlogComments($PostID) {

$db = new DB();
$CommentString = '';
$query = "select * from pf_blog_comments where PostID='$PostID' ORDER BY CommentDate DESC";
$db->query($query);

$bgcolor = '#FFFFFF';
$rowcounter = 0;
$CommentString = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td class='commentsheader'>COMMENTS</td></tr>";
while ($line = $db->fetchNextObject()) { 
$CommentString .= "<tr><td height='10' valign='top' style='padding-left:5px;color:#000000;' bgcolor='".$bgcolor."' align='left'><div>on <i>".substr($line->CommentDate,5,2)."/".substr($line->CommentDate,8,2)."/".substr($line->CommentDate,0,4)." at ".substr($line->CommentDate,11,5)."</i></div><b>".$line->Name."</b> said:</td></tr><tr><td valign='top' align='left' style='padding:5px;color:#000000;' bgcolor='".$bgcolor."'>".stripslashes($line->Comment)."<div class='spacer'></div></td></tr>";
		if ($rowcounter == 0) {
			$bgcolor = '#CCCCCC';
			$rowcounter = 1;
		} else {
			$bgcolor = '#FFFFFF';
			$rowcounter = 0;
		}
}
$CommentString .= "</table>";
return $CommentString;
}

function PostBlogComment($Name, $Comment, $PostID) {

$db = new DB();
 $query = "INSERT into pf_blog_comments (Name, Comment, PostID, CommentDate) values ('$Name', '$Comment','$PostID',Now())";
$db->query($query);

}
	
	?>