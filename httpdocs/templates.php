<?php include 'includes/init.php';?>
<?php include 'includes/dbconfig.php'; ?>
<?php include('includes/ps_pagination.php'); ?>

<?php 
$Genre = $_GET['genre']; 
$search = $_GET['search'];
$genreString = $Genre;
 
$sort = $_GET['sort']; 
if ($sort == "") {
$sort = 3;
}
$Results = 0;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - TEMPLATES LISTING</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td width="28%" valign="top" style="padding-left:10px;"><div class="pageheader">TEMPLATES</div></td><td width="37%" align="right"><? if (isset($_GET['search'])) {?> <a href ='/templates.php'>[view all]</a><? }?></td>
     <td width="35%" align="right" style="padding-right:25px;"><form name="form" action="templates.php" method="get">
  <input type="text" size="18"  name="search" /><input type="submit" value="Search" /></form>
  </td></tr><tr><td colspan="3" style="padding-right:20px; padding-left:5px;"><div style="padding:10px;">All template colors are easily edited through the Panel Flow Admin interface, these templates are simply alternate layouts to the 'Standard' template that comes with Panel Flow.<br /><br />

 More premium templates with mobile and animation addons will be released soon.<br /><br />
<strong>INSTALLATION:</strong> Templates are easy to install, just unzip the contents of the .zip file into the /templates directory on your server. The new templates will then appear in the 'settings' section of the admin interface, as well as when you crete a new comic. </div>
	<div class="comiclist" align="left" style="padding:5px;">
	
	<?php 

$conn = mysql_connect($userhost, $dbuser,$userpass);
mysql_select_db($userdb,$conn);
if (((!isset($Genre)) && (!isset($search))) || ((isset($search)) && ($search == ""))){
if ($sort == 1) {
				$sql = "select * from templates ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "select * from templates ORDER BY createdate ASC";
				
				} else if ($sort == 3) {
				$sql = "select * from templates ORDER BY createdate ASC";
				
				}

} else if (isset($Genre)) {

$search = trim($Genre);
			$search = preg_replace('"', ' ', $search);
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
				$sql = "SELECT * FROM templates " .
						"WHERE genre LIKE '%".$keywords[$i]."%'".
						" and installed = 1 ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and genre LIKE '%".$keywords[$i]."%'".
						" and installed = 1 ORDER BY createdate DESC";
				
				} else if ($sort == 3) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and genre LIKE '%".$keywords[$i]."%'".
						"  ORDER BY updated DESC";
				
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
				$sql = "SELECT * FROM templates " .
						"WHERE Title LIKE '%".$keywords[$i]."%'".
					" OR Description LIKE '%".$keywords[$i]."%'" .
					" OR Category LIKE '%".$keywords[$i]."%'" .
					" ORDER BY Title ASC";
				
				} else if ($sort == 2) {
			$sql = "SELECT * FROM templates " .
						"WHERE Title LIKE '%".$keywords[$i]."%'".
					" OR Description LIKE '%".$keywords[$i]."%'" .
					" OR Category LIKE '%".$keywords[$i]."%'" .
					"  ORDER BY CreateDate DESC";
				
				} else if ($sort == 3) {
			$sql = "SELECT * FROM templates " .
						"WHERE Title LIKE '%".$keywords[$i]."%'".
					" OR Description LIKE '%".$keywords[$i]."%'" .
					" OR Category LIKE '%".$keywords[$i]."%'" .
					" ORDER BY CreateDate DESC";
				
				}
						
				}
			}
			//Create a PS_Pagination object
	foreach($keywords as $value) {
   			//	print "$value ";
			}		
}
$pager = new PS_Pagination($conn,$sql,12,5);
	//The paginate() function returns a mysql result set 
			$rs = $pager->paginate();
			
			$comicString = "<table width='100%'><tr>";
			$counter = 0;
			while($row = mysql_fetch_assoc($rs)) {
			$Results = 1;
			$UpdateDay = substr($row['CreateDate'], 5, 2); 
			$UpdateMonth = substr($row['CreateDate'], 8, 2); 
			$UpdateYear = substr($row['CreateDate'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 			$comicString .= "<td valign='top' width='150'><div align='center'><div class='comictitlelist'>".stripslashes($row['Title'])."</div><a href='/download/templates/".$row['Filename']."' >";
			
				$comicString .="<img src='/".$row['Image']."' border='2' alt='LINK' style='border-color:#000000;' width='200' height='225'>";
			
			$comicString .="</a><div class='smspacer'></div><div class='moreinfo'><a href='/download/templates/".$row['Filename']."' >[download]</a><div class='updated'>created: <b>".$Updated."</b></div></div></td>"; 
			 $counter++;
 				if ($counter == 5){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
 			}
	//Display the full navigation in one go
	$comicString .= "</tr></table>";
	echo $comicString;
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
  <?php include 'includes/footer_v2.php';?>
</body>
</html>

