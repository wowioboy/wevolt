<? 
$ComicName = $_GET['comicname'];
$ComicDir = substr($ComicName,0,1);
include_once("comics/".$ComicDir."/".$ComicName."/archives.php");
?>
