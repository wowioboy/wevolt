<? 
include_once("init.php"); 
if ( isset( $_POST ) )
   $postArray = &$_POST ;			// 4.1.0 or later, use $_POST
else
   $postArray = &$HTTP_POST_VARS ;	// prior to 4.1.0, use HTTP_POST_VARS

foreach ( $postArray as $sForm => $value )
{
	if ( get_magic_quotes_gpc() )
		$postedValue = htmlspecialchars( stripslashes( $value ) ) ;
	else
		$postedValue = htmlspecialchars( $value ) ;
 
 if ($sForm == 'pf_post') {
  $Content = $postedValue;
  }
  
 if ($sForm == 'txtTitle') {
  $Title = $postedValue;
  }
 
 }
 
$filename = strtotime("now").".php";  
$fp = fopen("content/".$filename,'w');
$write = fwrite($fp,$Content);
chmod("content/".$filename,777);

$db = new DB();
$query = "INSERT into pages (Title, Filename, Published) values ('$Title','$filename',1)";
$db->query($query);
header("location:admin.php?a=pages");
}
?>