<? 

$query = "select n.Headline, n.Content, u.avatar, u.username, n.NewsType
		 from pf_news as n
		 join users as u on n.UserID=u.encryptid
		where u.username='$ModUser' and n.NewsType='$ModCat' order by ID DESC";

$InitDB->query($query);
$Count = 1;
echo '<div id="news_container" style="padding-left:5px;">';
while ($comic = $InitDB->FetchNextObject()) {
		echo '<div id="news_'.$Count.'">';
		echo "";
		echo '<span class="sender_name">'.$comic->Headline.'</span><br/><span class="messageinfo">'.nl2br(stripslashes($comic->Content)).'</span>';
		echo '<div class="spacer"></div>';
		echo '</div>';
	$Count++;
}
echo '</div>';

?>