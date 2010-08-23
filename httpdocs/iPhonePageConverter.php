<? 
include 'includes/db.class.php'; 
$ComicID = $_GET['comic'];
$db=new DB();
$query="SELECT * from comic_pages as cp
        join comics as c on c.comiccrypt=cp.ComicID
		where c.SafeFolder='$ComicID'";
$db->query($query);
print $query;

while ($page = $db->fetchNextObject()) { 
	$Image = 'comics/'.$page->HostedUrl.'/images/pages/'.$page->Image;
	$IphoneSmall = 'comics/'.$page->HostedUrl.'/iphone/images/pages/320/'.$page->Image;
	$IphoneLarge = 'comics/'.$page->HostedUrl.'/iphone/images/pages/480/'.$page->Image;
	print 
	$convertString = "convert $Image -resize 320 $IphoneSmall";
	exec($convertString);
	chmod($IphoneSmall,0777);
	print 'IPHONE SMALL = ' . $convertString.'<br/>';
	
	$convertString = "convert $Image -resize 480 $IphoneLarge";
	exec($convertString);
	print 'IPHONE Large = ' . $convertString.'<br/>';
	chmod($IphoneLarge,0777);
}

?>