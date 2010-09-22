<?php include 'includes/init.php';?>
<?php include 'includes/dbconfig.php'; ?>
<?php include('includes/ps_pagination.php'); ?>

<?php 
$Genre = $_GET['genre']; 
$search = $_GET['search'];
$genreString = $Genre;
 
$sort = $_GET['sort']; 
if ($sort == "") {
$sort = 4;
}

if ($sort == 1)
	$Listing = 'Title';
else if ($sort == 2)
	$Listing = 'Creation Date';
else if ($sort == 3)
	$Listing = 'Last Updated';
else if ($sort == 4)
	$Listing = 'Ranking';
	
$Results = 0;
$PageTitle = ' | Comics Listing';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?> <?php echo $PageTitle; ?></title>

</head>


<?php include 'includes/header_template_new.php';?>
<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 


 <table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="158" valign="top" style="padding-left:15px;">
	<div class="pageheader">COMICS</div>
	<table border="0" cellpadding="0" cellspacing="0" width="150">
<tr>
<td background="/images/genre_header.png" height="15" width="150" style="background-repeat:no-repeat;"></td></tr><td background="/images/genre_bg.jpg" style="background-repeat:repeat-y;" bgcolor="#FFFFFF"> 
<div class="search" style="padding-left:6px;">
<form name="form" action="/comics/" method="get">
  <input type="text" size="18"  name="search" />
  <div align="center">
  <input type="submit" value="Search" />
  </div>
  </form>
</div>
<div class="infoheader"><img src="/images/radiobtn.jpg" />LISTING OPTIONS </div>
<div class="spacer"></div> 
<div class="genres">

<div id="genres">
		<strong>You need to upgrade your Flash Player </strong></div>
<script type="text/javascript">
		// <![CDATA[

		var so = new SWFObject("/flash/genres.swf", "images", "100", "450", "8.0.23", "#FFFFFF", true);
	    so.addVariable('genreString','<?php echo $genreString;?>');
		 so.addVariable('sorttype','<?php echo $sort;?>');
		so.write("genres");

		// ]]>
	</script>
</div>

</td></tr><tr><td background="/images/genre_footer.png" height="15" width="150" style="background-repeat:no-repeat;"></td></tr></table>
   </td>
    <td width="575" valign="top">
	<div class="comiclist" align="left" style="padding:5px;">
    <div style="sectionheader">Listing by <? echo $Listing;?></div>
	
	<?php 

$conn = mysql_connect($userhost, $dbuser,$userpass);
mysql_select_db($userdb,$conn);
if (((!isset($Genre)) && (!isset($search))) || ((isset($search)) && ($search == ""))){
if ($sort == 1) {
				$sql = "select * from comics where installed = 1 and Published = 1 and pages>0 ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "select * from comics where installed = 1 and Published = 1 and pages>0 ORDER BY createdate DESC";
				
				} else if ($sort == 3) {
				$sql = "select * from comics where installed = 1 and Published = 1 and pages>0 ORDER BY PagesUpdated DESC";
				
				} else  if ($sort == 4){
					$sql = "select * from comics as c
						join rankings as r on c.comiccrypt=r.ComicID
				        where c.installed = 1 and c.Published = 1 and c.pages>0 and c.ShowRanking=1 ORDER BY r.ID ASC";
				
				}

} else if (isset($Genre)) {

$search = trim($Genre);
			$search = preg_replace('/\s+/', ' ', $search);

			//seperate multiple keywords into array space delimited
			$keywords = explode(" ", $search);

			//Clean empty arrays so they don't get every row as result
			$keywords = array_diff($keywords, array(""));

			//Set the MySQL query
			if ($search == NULL or $search == '%'){
			} else {
				for ($i=0; $i<count($keywords); $i++) {
				if ($sort == 1) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and genre LIKE '%".$keywords[$i]."%'".
						" and installed = 1 and Published = 1 ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and genre LIKE '%".$keywords[$i]."%'".
						" and installed = 1 and Published = 1 ORDER BY createdate DESC";
				
				} else if ($sort == 3) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and Published = 1 and genre LIKE '%".$keywords[$i]."%'".
						"  ORDER BY updated DESC";
				
				} else  if ($sort == 4){
					$sql = "select * from comics as c
						join rankings as r on c.comiccrypt=r.ComicID
				        where c.installed = 1 and c.Published = 1 and c.ShowRanking=1 and c.genre LIKE '%".$keywords[$i]."%'".
						"ORDER BY r.ID ASC";
				
				}
				}
				}
	//Create a PS_Pagination object
} else if ((isset($search)) && ($search != "")) {
			$search = trim($search);
			$search = preg_replace('/\s+/', ' ', $search);

			//seperate multiple keywords into array space delimited
			$keywords = explode(" ", $search);

			//Clean empty arrays so they don't get every row as result
			$keywords = array_diff($keywords, array(""));

			//Set the MySQL query
			if ($search == NULL or $search == '%'){
			} else {
				for ($i=0; $i<count($keywords); $i++) {
				 
				if ($sort == 1) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and Published = 1 and (title LIKE '%".$keywords[$i]."%'".
					" OR creator LIKE '%".$keywords[$i]."%'" .
					" OR writer LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR colorist LIKE '%".$keywords[$i]."%'" .
					" OR letterist LIKE '%".$keywords[$i]."%'" .
					" OR synopsis LIKE '%".$keywords[$i]."%'" .
					" OR short LIKE '%".$keywords[$i]."%'" .
					" OR url LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR tags LIKE '%".$keywords[$i]."%'" .
					" OR genre LIKE '%".$keywords[$i]."%'" .
					") ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and Published = 1 and (title LIKE '%".$keywords[$i]."%'".
					" OR creator LIKE '%".$keywords[$i]."%'" .
					" OR writer LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR colorist LIKE '%".$keywords[$i]."%'" .
					" OR letterist LIKE '%".$keywords[$i]."%'" .
					" OR synopsis LIKE '%".$keywords[$i]."%'" .
					" OR short LIKE '%".$keywords[$i]."%'" .
					" OR url LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR tags LIKE '%".$keywords[$i]."%'" .
					" OR genre LIKE '%".$keywords[$i]."%'" .
					")  ORDER BY createdate DESC";
				
				} else if ($sort == 3) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and Published = 1 and (title LIKE '%".$keywords[$i]."%'".
					" OR creator LIKE '%".$keywords[$i]."%'" .
					" OR writer LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR colorist LIKE '%".$keywords[$i]."%'" .
					" OR letterist LIKE '%".$keywords[$i]."%'" .
					" OR synopsis LIKE '%".$keywords[$i]."%'" .
					" OR short LIKE '%".$keywords[$i]."%'" .
					" OR url LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR tags LIKE '%".$keywords[$i]."%'" .
					" OR genre LIKE '%".$keywords[$i]."%'" .
					") ORDER BY updated DESC";
				
				}else if ($sort == 4) {
				$sql = "SELECT * FROM comics as c
					join rankings as r on c.comiccrypt=r.ComicID
					WHERE c.installed = 1 and c.Published = 1 and c.ShowRanking=1 and (c.title LIKE '%".$keywords[$i]."%'
					 OR c.creator LIKE '%".$keywords[$i]."%'
					 OR c.writer LIKE '%".$keywords[$i]."%'
					 OR c.artist LIKE '%".$keywords[$i]."%'
					 OR c.colorist LIKE '%".$keywords[$i]."%'
					 OR c.letterist LIKE '%".$keywords[$i]."%'
					 OR c.synopsis LIKE '%".$keywords[$i]."%'
					 OR c.short LIKE '%".$keywords[$i]."%'
					 OR c.url LIKE '%".$keywords[$i]."%'
					 OR c.artist LIKE '%".$keywords[$i]."%'
					 OR c.tags LIKE '%".$keywords[$i]."%'
					 OR c.genre LIKE '%".$keywords[$i]."%'
					 ) ORDER BY r.ID ASC";
				
				}
						
				}
			}
	//Create a PS_Pagination object
	foreach($keywords as $value) {
   				print "$value ";
			}		
}

$pager = new PS_Pagination($conn,$sql,12,5);

	//The paginate() function returns a mysql result set 
			$rs = $pager->paginate();
			
			echo "<table width='100%'><tr>";
			$counter = 0;
			while($row = mysql_fetch_assoc($rs)) {
			$Results = 1;
			$UpdateDay = substr($row['PagesUpdated'], 5, 2); 
			$UpdateMonth = substr($row['PagesUpdated'], 8, 2); 
			$UpdateYear = substr($row['PagesUpdated'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 		
			
			if ($row['Hosted'] == 1) {
					$fileUrl = 'http://www.panelflow.com'.$row['thumb'];
					//print $fileUrl.'<br/>';
		
					$comicURL = $row['url'].'/';
				} else if (($row['Hosted'] == 2) && (substr($row['thumb'],0,4) != 'http'))  {
					$fileUrl = 'http://www.panelflow.com'.$row['thumb'];
					$comicURL = $row['url'];
				} else {
					$fileUrl = $row['thumb'];
					$comicURL = $row['url'];
				}
			
//check if image exists 
			//if($img = @GetImageSize("testimage.gif")) 
			//{ 
			//echo "image exists"; 
			//} 
			//else 
			//{ 
			//echo "image does not exist"; 
			//} 

		if ($fileUrl == '')
			$fileUrl = '/images/tempcover_thumb.jpg';
			
					echo "<td valign='top' width='150'><div align='center'><div class='comictitlelist'>".stripslashes($row['title'])."</div><a href='".$comicURL."' target='blank'>";
		    	$AgetHeaders = @get_headers($fileUrl);
			//	print $AgetHeaders[0];
			if (preg_match("|200|", $AgetHeaders[0])) {
			
				echo "<img src='".$fileUrl."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='134'>";
			} else {
			echo "<img src='/images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			}
			echo "</a><div class='smspacer'></div><div class='moreinfo'><a href='/".$row['SafeFolder']."/'><img src='/images/info.png' border='0'></a><div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$row['pages']."</div></div></td>"; 
			 $counter++;
 				if ($counter == 4){
 					echo "</tr><tr>";
 					$counter = 0;
 				}
 			}
	//Display the full navigation in one go
	echo "</tr></table>";
	//echo $comicString;
if ($Results == 1) {

	echo "<div class='pagination'>".$pager->renderFullNav()."</div>";
	
	}
if ($Results == 0) {
	
	echo "<div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div align='center' style='font-weight:bold;'>There are no comics that fit your search.</div>";
	
	
	}

?> 
	</div></td>
  </tr>
</table>
 
  </div>
  <div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>


</body>
</html>

