<? 
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';
$ContentSearch = '';
$GenreSearch = '';
$TagSearch= '';

if (($_GET['content'] == '') && (isset($_GET['t'])))
	$SearchContentArray = array($_GET['t']);
else
	$SearchContentArray = explode(',',$_GET['content']);


$SearchSubContentArray = explode(',',$_GET['sub']);
if ($SearchSubContentArray == null)
	$SearchSubContentArray = array();
$SearchCreatorArray = explode(',',$_GET['creator']);
$SearchGenreArray = explode(',',$_GET['genre']);
$SearchTagsArray = explode(',',$_GET['keywords']);
foreach ($SearchContentArray as $content) {
	if ($ContentSearch != '')
		$ContentSearch .= ',';

 	$ContentSearch .= "'".$content."'";
 
}


foreach ($SearchSubContentArray as $content) {
	if ($SubContentSearch != '')
		$SubContentSearch .= ',';

 	$SubContentSearch .= "'".$content."'";
 
}

foreach ($SearchGenreArray as $genre) {
	if ($GenreSearch != '')
		$GenreSearch .= ',';
 	$GenreSearch .= "'".$genre."'";
}
foreach ($SearchTagsArray as $tag) {
	if ($TagSearch != '')
		$TagSearch .= ',';
 	$TagSearch .= "'".$tag."'";
}
//$Genre = $_GET['genre']; 
$search = $_GET['keywords'];
//$genreString = $Genre;
 
$sort = $_GET['sort']; 
if ($sort == "") {
$sort = 'alpha';
}

if ($sort == 'alpha')
	$Listing = 'Title';
else if ($sort == 'new')
	$Listing = 'Creation Date';
else if ($sort == 'updated')
	$Listing = 'Last Updated';
else if ($sort == 'rank')
	$Listing = 'Ranking';
	
$Results = 0;

 $Section = $_GET['section'];


$where = '';
if ($_GET['keywords'] != '') {

	$SELECT = "SELECT  u.username, u.avatar as UserThumb, u.encryptid as PUserID, u.about as UserAbout ";
    $SELECT .= " from users as u ";	
	
	$where .= "where (u.username LIKE '%".mysql_real_escape_string($_GET['keywords'])."%') or  u.email='".mysql_real_escape_string($_GET['keywords'])."' order by u.username";

	$SearchString =  "";
	$counter = 0;
	//$LIMIT = ' LIMIT 160';
	$query = $SELECT . $JOIN . $where . $ORDERBY.$LIMIT;
	$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
	$DB->query($query);
	//print $query;
	$SearchString .= '<div class="messageinfo_white">';
	while ($line = $DB->fetchNextObject()) {
			$Results = 1;
			$ProjectThumb =$line->UserThumb;
			$ProjectURL = 'http://users.wevolt.com/'.$line->username.'/';
			$Description = addslashes($line->UserAbout);
			$ProjectTags = addslashes($line->Tags);
			$ProjectTitle = $line->username; 
			$ContentID = $line->PUserID;
			$Description = preg_replace("/\r?\n/", "\\n", addslashes($Description)); 
			$SearchString .= '<table><tr><td valign="top" width="50">';
		//	$SearchString .= '<a href="javascript void(0)" onclick="set_user(\''.$line->username.'\');return false;">';
			$SearchString .= '<img src="'.$ProjectThumb.'" width="50" height="50" border="1" style="border:1px solid #000000;" >';
			//$SearchString .= '</a>';
			$SearchString .= '</td><td width="300" style="padding-left:5px; font-size:11px; color:#ffffff;">';
		
				
			$SearchString .= $ProjectTitle.'<br/>';
			
				if ($Section == 'users') {
					$SearchString .= '<a href="javascript:void(0)" onclick="set_user(\''.$line->username.'\',\''.$line->UserThumb.'\',\'invite\',\''.$line->PUserID.'\');return false;"><span style="font-size:11px;">Add to Invite List</span></a>';
			} else {
				
				$SearchString .= '<a href="javascript:void(0)" onclick="set_user(\''.$line->username.'\',\''.$line->UserThumb.'\',\'super\',\''.$line->PUserID.'\');return false;"><span style="font-size:11px;">Send Superfan Pass</span></a><br/><a href="javascript:void(0)" onclick="set_user(\''.$line->username.'\',\''.$line->UserThumb.'\',\'temp\',\''.$line->PUserID.'\');return false;"><span style="font-size:11px;">Send Temp Pass</span></a>';
			}
			$SearchString .= '<a/></td><tr?</table><div style="height:5px;"></div>';

	 }
 if ($Results == 0)
	$SearchString .=  "<div align='center' style='font-weight:bold;'>There were no users found.</div>";
$SearchString .='</div>';
}
$DB->close();
 echo $SearchString;
?>