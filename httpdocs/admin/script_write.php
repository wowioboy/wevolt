<?php
include_once("includes/init.php"); 
include("../admin/editor/fckeditor.php") ;
$PageID = $_GET['pageid'];
if ($PageID =='')
	$PageID = $_POST['txtPage'];
	
$db = new DB($db_database,$db_host, $db_user, $db_pass);
$query = "select cp.HTMLFile,c.SafeFolder,c.HostedUrl from comic_pages as cp
		  join comics as c on cp.ComicID=c.comiccrypt
 		  where ParentPage='$PageID' and PageType='script'";
$PageArray = $db->queryUniqueObject($query);

$HTMLFile = $PageArray->HTMLFile;
$HostedUrl = $PageArray->HostedUrl;

if ($_POST['txtEdit']==1) { 
$HtmlContent = $_POST['pf_post'];
$OldFile = $_POST['ScriptHTML'];
$HTMLFile = strtotime("now").".html";  
$fp = fopen('../comics/'.$HostedUrl.'/images/pages/'.$HTMLFile,'w');
$write = fwrite($fp,$HtmlContent);
chmod('../comics/'.$HostedUrl.'/images/pages/'.$HTMLFile,0777);
@unlink('../comics/'.$HostedUrl.'/images/pages/'.$OldFile);

?>
<script language="javascript" type="text/javascript">
document.location.href = "/<? echo $PFDIRECTORY;?>/script_write.php?pageid=<? echo $_GET['pageid'];?>";
from_mysql_obj          = parent.document.getElementById( 'txtPeelFourFilename' );
from_mysql_obj.value = '<?php echo $HTMLFile; ?>';
parent.document.getElementById( 'uploadModal' ).style.display = 'none';
</script>

<? }
if ($HTMLFile != '') 
	$HtmlContent = @file_get_contents('../comics/'.$HostedUrl.'/images/pages/'.$HTMLFile);
?>

<form action="#" method="post">
<input type="submit" value ='SAVE CONTENT' style="width:100px; background-color:#FF6600; color:#FFFFFF; font-weight:bold;"/>
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.

$oFCKeditor = new FCKeditor('pf_post') ;
$oFCKeditor->BasePath	= '/admin/editor/';
$oFCKeditor->Height = '325';
$oFCKeditor->Width = '400';
$oFCKeditor->Value		= $HtmlContent;
$oFCKeditor->Create() ;
?>

<input type="hidden" name="txtPage" value="<? echo $PageID; ?>">
<input type="hidden" name="ScriptHTML" value="<? echo $HTMLFile; ?>">
<input type="hidden" name="txtEdit" value="1">
</form>
