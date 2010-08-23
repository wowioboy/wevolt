<? 
include_once("includes/init.php"); 
$PostID = $_POST['txtPost'];
if ( isset( $_POST ) )
   $postArray = &$_POST ;			// 4.1.0 or later, use $_POST
else
   $postArray = &$HTTP_POST_VARS ;	// prior to 4.1.0, use HTTP_POST_VARS

foreach ( $postArray as $sForm => $value )
{
	if ( get_magic_quotes_gpc() )
		$postedValue = stripslashes( $value )  ;
	else
		$postedValue = stripslashes( $value ) ; 
 if ($sForm == 'content') {
  $Content = $postedValue;
  }
  
 if ($sForm == 'txtTitle') {
  $Title = mysql_escape_string($postedValue);
  }
  if ($sForm == 'txtPublished') {
  	$Published = $postedValue;
  }
  if ($sForm == 'txtCategory') {
  	$Category = $postedValue;
  }
  if ($sForm == 'txtAuthor') {
  	$Author = $postedValue;
  }
  if ($sForm == 'txtEdit') {
  	$Edit = $postedValue;
  }
   if ($sForm == 'txtMonth') {
  	$Month = $postedValue;
	if (strlen($Month) < 2) {
		$Month = '0'.$Month;
	}
  }

   if ($sForm == 'txtDay') {
  	$Day = $postedValue;
	if (strlen($Day) < 2) {
		$Day = '0'.$Day;
	}
  }
   if ($sForm == 'txtYear') {
  	$Year = $postedValue;
  }
  if ($sForm == 'txtFilename') {
  	$Filename = $postedValue;
  }
}
if ($Edit == "") {
	$Filename = strtotime("now").".html";  
	$fp = fopen("blog/posts/".$Filename,'w');
	$write = fwrite($fp,$Content);
	chmod("blog/posts/".$Filename,0777);
	$db = new DB();
	$PublishDate = $Month ."-". $Day ."-". $Year;
	$Author = $_SESSION['username'];
	//$Author = "Matte Black";
	$query = "INSERT into pf_blog_posts (Title, Filename, Author, Category, PublishDate) values ('$Title','$Filename','$Author','$Category','$PublishDate')";
	$db->query($query);
	header("location:admin.php?a=blog");
	} else if ($Edit == 1) {
		$PublishDate = $Month ."-". $Day ."-". $Year;
		$fp = fopen("blog/posts/".$Filename,'w');
		$write = fwrite($fp,$Content);
		chmod("blog/posts/".$Filename,0777);
		$db = new DB();
		$query = "UPDATE pf_blog_posts set title='$Title' where id='$PostID'";
		//print $query;
		$db->query($query);
		$query = "UPDATE  pf_blog_posts set publishdate='$PublishDate' where id='$PostID'";
		$db->query($query);
		$query = "UPDATE  pf_blog_posts set category='$Category' where id='$PostID'";
		$db->query($query);
		header("location:admin.php?a=blog");
}
?>