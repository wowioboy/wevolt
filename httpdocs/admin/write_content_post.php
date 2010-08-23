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
 if ($sForm == 'pf_post') {
  $Content = $postedValue;
  }
  
 if ($sForm == 'txtTitle') {
  $Title = $postedValue;
  }
  if ($sForm == 'txtPublished') {
  	$Published = $postedValue;
  }
  if ($sForm == 'txtCategory') {
  	$Category = $postedValue;
  }
  if ($sForm == 'txtType') {
  	$Type = $postedValue;
  }
  if ($sForm == 'txtSection') {
  	$Section = $postedValue;
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
  
   if ($sForm == 'txtShowtitle') {
  	$ShowTitle = $postedValue;
  }
}
if ($Edit == "") {
	$Filename = strtotime("now").".html";  
	$fp = fopen("content/posts/".$Filename,'w');
	$write = fwrite($fp,$Content);
	chmod("content/posts/".$Filename,0777);
	$db = new DB();
	//$Author = $_SESSION['username'];
	$Author = "Matte Black";
	$query = "INSERT into content (Title, Filename, Author, Section, Category, Published, ShowTitle) values ('$Title','$Filename','$Author','$Section','$Category','$Published','$ShowTitle')";
	$db->query($query);
	header("location:admin.php?a=press");
	} else if ($Edit == 1) {
		$fp = fopen("content/posts/".$Filename,'w');
		$write = fwrite($fp,$Content);
		chmod("content/posts/".$Filename,0777);
		$db = new DB();
		$query = "UPDATE content set title='$Title' where id='$PostID'";
		//print $query;
		$db->query($query);
		$query = "UPDATE  content set published='$Published' where id='$PostID'";
		$db->query($query);
		$query = "UPDATE  content set category='$Category' where id='$PostID'";
		$db->query($query);
		$query = "UPDATE  content set section='$Section' where id='$PostID'";
		$db->query($query);
		header("location:admin.php?a=press");
}
?>