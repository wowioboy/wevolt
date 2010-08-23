<? 
include_once("includes/init.php"); 
$PageID = $_POST['txtPage'];
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
  
  if ($sForm == 'txtEdit') {
  	$Edit = $postedValue;
  }
  
  if ($sForm == 'txtFilename') {
  	$Filename = $postedValue;
  }
}

if ($Edit == "") {
	$filename = strtotime("now").".html";  
	$fp = fopen("content/page/".$filename,'w');
	$write = fwrite($fp,$Content);
	chmod("content/page/".$filename,0777);

	$db = new DB();
	$query = "INSERT into pages (Title, Filename, Published) values ('$Title','$filename','$Published')";
	$db->query($query);
	header("location:admin.php?a=pages");
	} else if ($Edit == 1) {
		$fp = fopen("content/page/".$Filename,'w');
		$write = fwrite($fp,$Content);
		chmod("content/page/".$filename,0777);
		$db = new DB();
		$query = "UPDATE pages set title='$Title' where id='$PageID'";
		$db->query($query);
		$query = "UPDATE  pages set published='$Published' where id='$PageID'";
		$db->query($query);
		header("location:admin.php?a=pages");
}
?>