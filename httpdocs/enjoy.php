<?php 
include 'includes/init.php'; 
$PageTitle = 'wevolt | enjoy';
$TrackPage = 1;

?>
<?php 


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
if (isset($_GET['t']))
	$ContentSearch ="'".$_GET['t']."'";
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
$sort = 'rank';
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

$QueryString = '';
$TabQuery = '';
$RunQuery = 0;

if ((isset($_GET['keywords'])) && ($_GET['keywords'] != 'enter keywords')) {
	$TabQuery .= '&keywords='.$_GET['keywords'];
	$RunQuery = 1;
	}

if ($_GET['sort'] != '') {
		$TabQuery .='&sort='.$_GET['sort'];
		$RunQuery = 1;
}

if ($_GET['filters'] != '') {
		$TabQuery .='&filters='.$_GET['filters'];
		$RunQuery = 1;
}

if ($_GET['content'] != '') {
		$QueryString .='&content='.$_GET['content'];
		$RunQuery = 1;
}
if ($_GET['sub'] != '') {
		$QueryString .='&sub='.$_GET['sub'];
		$RunQuery = 1;
}
if ($_GET['t'] != '') {
		$QueryString .='&t='.$_GET['t'];
		$RunQuery = 1;
}

if ($_GET['tags'] != '') {
		$TabQuery .='&tags='.$_GET['tags'];
		$RunQuery = 1;
}

if ($_GET['genre'] != '') {
		$TabQuery .='&genre='.$_GET['genre'];
		$RunQuery = 1;
}
$QueryString .= $TabQuery;
if ($RunQuery == 1)
	$TrackPage = 0;
?>

<?php include 'includes/header_template_new.php'; ?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">


<div align="left">

<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
<tr>
<? if ($_SESSION['IsPro'] == 1) {
$_SESSION['noads'] = 1;
		?>
		<td valign="top" style="padding:5px; color:#FFFFFF;width:60px;">
			<? include 'includes/site_menu_popup_inc.php';?>
		</td> 
	<? } else {?>
<td width="<? echo $SideMenuWidth;?>" valign="top">
	<? include 'includes/site_menu_inc.php';?>
</td> 
<? }?>

<td  valign="top" align="center"><div style="padding:10px;">

 <iframe src="/get_search.php?a=search&show=1<? echo $QueryString;?>" width="800" height="850" frameborder="0" scrolling="no" allowTransparency="true"></iframe>
</div>
 	</td>
	
</tr>
</table>
</div>
<?php include 'includes/footer_template_new.php';?>