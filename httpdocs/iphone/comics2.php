<?php include '../includes/dbconfig.php'; ?>
<?php include('../includes/ps_pagination.php'); ?>
<?php 
$PageTitle = ' | Comics Listing';
include 'includes/header_iphone.php';?>
<?php 
$Genre = $_GET['genre']; 
$search = $_GET['search'];
$genreString = $Genre;
 
$sort = $_GET['sort']; 
if ($sort == "") {
$sort = 3;
}
$Results = 0;

$conn = mysql_connect($userhost, $dbuser,$userpass);
mysql_select_db($userdb,$conn);
?> 
<div id="page_wrapper">

	
		<div id="content_left">
					<table width="480" border="0" cellpadding="0" cellspacing="0">
		  <tr><td width="124"><img src="images/pf_logo_iphone.jpg" /></td>
		  <td width="197"><form action="/iphone/login.php" method="post"><input type="text" name="email" size="10"  onFocus="doClear(this)" value="email"/><input type="text" name="pass" size="10"  onFocus="doClear(this)" value="password"/><input type="submit" value="login" /></form>
</td></tr><tr><td class="topmenu" colspan="2"><a href="/iphone/register.php">REGISTER</a>&nbsp;&nbsp;<a href="/iphone/contact.php">CONTACT</a>&nbsp;&nbsp;<a href='/iphone/comics.php'>COMICS</a>&nbsp;&nbsp;<a href='/iphone/creators.php'>CREATORS</a>&nbsp;&nbsp;<a href="/iphone/blog.php">BLOG</a></td></tr><tr><td colspan='2' align="center"><form action="/iphone/comics.php" method="post"><input type="text" name="search" style="width:95%;"  onFocus="doClear(this)" value="enter search"/><input type="submit" value="search" /></form></td></tr></table> <div class="spacer"></div><? if (((!isset($Genre)) && (!isset($search))) || ((isset($search)) && ($search == ""))){
if ($sort == 1) {
				$sql = "select comiccrypt, title, url, thumb, pages, PagesUpdated from $comicstable where installed = 1 ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "select comiccrypt, title, url, thumb, pages, PagesUpdated from $comicstable where installed = 1 ORDER BY createdate ASC";
				
				} else if ($sort == 3) {
				$sql = "select comiccrypt, title, url, thumb, pages, PagesUpdated from $comicstable where installed = 1 ORDER BY updated ASC";
								
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
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and title LIKE '%".$keywords[$i]."%'".
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
					" ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and title LIKE '%".$keywords[$i]."%'".
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
					"  ORDER BY createdate DESC";
				 
				} else if ($sort == 3) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and title LIKE '%".$keywords[$i]."%'".
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
					" and installed = 1 ORDER BY updated DESC";
				
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
			
			$comicString = "<table width='100%'><tr>";
			$counter = 0;
			while($row = mysql_fetch_assoc($rs)) {
			$Results = 1;
			$UpdateDay = substr($row['PagesUpdated'], 5, 2); 
			$UpdateMonth = substr($row['PagesUpdated'], 8, 2); 
			$UpdateYear = substr($row['PagesUpdated'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 			$comicString .= "<td valign='top' width='150'><div align='center'><a href='".$row['url']."' target='blank'>";
			
				 $fileUrl = $row['thumb'];
		    	$AgetHeaders = @get_headers($fileUrl);
			if (preg_match("|200|", $AgetHeaders[0])) {
				$comicString .="<img src='".$row['thumb']."' border='2' alt='LINK' style='border-color:#000000;'>";
			} else {
			 $comicString .="<img src='images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			}
			$comicString .="</a><div class='comictitlelist'>".stripslashes($row['title'])."</div><div class='smspacer'></div><div class='moreinfo'><a href='".urlencode($row['title'])."/'><img src='images/info.jpg' border='0'></a><div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$row['pages']."</div></div></td>"; 
			 $counter++;
 				if ($counter == 4){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
 			}
	//Display the full navigation in one go
	$comicString .= "</tr></table>";
	if ($Results == 1) {

	echo "<div class='pagination'>".$pager->renderFullNav()."</div><div class='spacer'></div>";
	
	}
	echo $comicString;

if ($Results == 0) {
	
	$comicString= "<div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div align='center' style='font-weight:bold;'>There are no comics that fit your search.</div>";
	
	
	} if ($Results == 1) {

	echo "<div class='pagination'>".$pager->renderFullNav()."</div>";
	
	}?>	
</div>
		<div id="content_right">
				<table width="480" border="0" cellpadding="0" cellspacing="0">
		  <tr><td width="124"><img src="images/pf_logo_iphone.jpg" /></td>
		  <td width="197"><form action="/login.php" method="post"><input type="text" name="email" size="10"  onFocus="doClear(this)" value="email"/><input type="text" name="pass" size="10"  onFocus="doClear(this)" value="password"/><input type="submit" value="login" /></form>
</td></tr><tr><td class="topmenu" colspan="2"><a href="/register.php">REGISTER</a>&nbsp;&nbsp;<a href="/contact.php">CONTACT</a>&nbsp;&nbsp;<a href='/comics.php'>COMICS</a>&nbsp;&nbsp;<a href='/creators.php'>CREATORS</a>&nbsp;&nbsp;<a href="/blog.php">BLOG</a></td></tr><tr><td colspan='2' align="center"><form action="/iphone/comics.php" method="post"><input type="text" name="search" style="width:95%;"  onFocus="doClear(this)" value="enter search"/><input type="submit" value="search" /></form></td></tr></table> <div class="spacer"></div>
	<? if (((!isset($Genre)) && (!isset($search))) || ((isset($search)) && ($search == ""))){
if ($sort == 1) {
				$sql = "select comiccrypt, title, url, thumb, pages, PagesUpdated from $comicstable where installed = 1 ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "select comiccrypt, title, url, thumb, pages, PagesUpdated from $comicstable where installed = 1 ORDER BY createdate ASC";
				
				} else if ($sort == 3) {
				$sql = "select comiccrypt, title, url, thumb, pages, PagesUpdated from $comicstable where installed = 1 ORDER BY updated ASC";
								
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
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and title LIKE '%".$keywords[$i]."%'".
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
					" ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and title LIKE '%".$keywords[$i]."%'".
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
					"  ORDER BY createdate DESC";
				 
				} else if ($sort == 3) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and title LIKE '%".$keywords[$i]."%'".
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
					" and installed = 1 ORDER BY updated DESC";
				
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
			
			$comicString = "<table width='100%'><tr>";
			$counter = 0;
			while($row = mysql_fetch_assoc($rs)) {
			$Results = 1;
			$UpdateDay = substr($row['PagesUpdated'], 5, 2); 
			$UpdateMonth = substr($row['PagesUpdated'], 8, 2); 
			$UpdateYear = substr($row['PagesUpdated'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 			$comicString .= "<td valign='top' width='150'><div align='center'><a href='".$row['url']."' target='blank'>";
			
				 $fileUrl = $row['thumb'];
		    	$AgetHeaders = @get_headers($fileUrl);
			if (preg_match("|200|", $AgetHeaders[0])) {
				$comicString .="<img src='".$row['thumb']."' border='2' alt='LINK' style='border-color:#000000;'>";
			} else {
			 $comicString .="<img src='images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			}
			$comicString .="</a><div class='comictitlelist'>".stripslashes($row['title'])."</div><div class='smspacer'></div><div class='moreinfo'><a href='".urlencode($row['title'])."/'><img src='images/info.jpg' border='0'></a><div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$row['pages']."</div></div></td>"; 
			 $counter++;
 				if ($counter == 4){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
 			}
	//Display the full navigation in one go
	$comicString .= "</tr></table>";
	if ($Results == 1) {

	echo "<div class='pagination'>".$pager->renderFullNav()."</div><div class='spacer'></div>";
	
	}
	echo $comicString;

if ($Results == 0) {
	
	$comicString= "<div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div align='center' style='font-weight:bold;'>There are no comics that fit your search.</div>";
	
	
	} if ($Results == 1) {

	echo "<div class='pagination'>".$pager->renderFullNav()."</div>";
	
	}?>	
		</div>
		<div id="content_normal">
					<table width="320" border="0" cellpadding="0" cellspacing="0">
		  <tr><td width="124"><img src="images/pf_logo_iphone.jpg" /></td>
		  <td width="197"><form action="/login.php" method="post"><input type="text" name="email" size="10"  onFocus="doClear(this)" value="email"/><input type="text" name="pass" size="10"  onFocus="doClear(this)" value="password"/><input type="submit" value="login" /></form>
</td></tr><tr><td class="topmenu" colspan="2"><a href="/register.php">REGISTER</a>&nbsp;&nbsp;<a href="/contact.php">CONTACT</a>&nbsp;&nbsp;<a href='/comics.php'>COMICS</a>&nbsp;&nbsp;<a href='/creators.php'>CREATORS</a>&nbsp;&nbsp;<a href="/blog.php">BLOG</a></td></tr><tr><td colspan='2' align="center"><form action="/iphone/comics.php" method="post"><input type="text" name="search" style="width:95%;"  onFocus="doClear(this)" value="enter search"/><input type="submit" value="search" /></form></td></tr></table> <div class="spacer"></div>

<? if (((!isset($Genre)) && (!isset($search))) || ((isset($search)) && ($search == ""))){
if ($sort == 1) {
				$sql = "select comiccrypt, title, url, thumb, pages, PagesUpdated from $comicstable where installed = 1 ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "select comiccrypt, title, url, thumb, pages, PagesUpdated from $comicstable where installed = 1 ORDER BY createdate ASC";
				
				} else if ($sort == 3) {
				$sql = "select comiccrypt, title, url, thumb, pages, PagesUpdated from $comicstable where installed = 1 ORDER BY updated ASC";
								
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
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and title LIKE '%".$keywords[$i]."%'".
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
					" ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and title LIKE '%".$keywords[$i]."%'".
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
					"  ORDER BY createdate DESC";
				 
				} else if ($sort == 3) {
				$sql = "SELECT * FROM comics " .
						"WHERE installed = 1 and title LIKE '%".$keywords[$i]."%'".
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
					" and installed = 1 ORDER BY updated DESC";
				
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
			
			$comicString = "<table width='100%'><tr>";
			$counter = 0;
			while($row = mysql_fetch_assoc($rs)) {
			$Results = 1;
			$UpdateDay = substr($row['PagesUpdated'], 5, 2); 
			$UpdateMonth = substr($row['PagesUpdated'], 8, 2); 
			$UpdateYear = substr($row['PagesUpdated'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 			$comicString .= "<td valign='top' width='125'><div align='center'><a href='".$row['url']."' target='blank'>";
			
				 $fileUrl = $row['thumb'];
		    	$AgetHeaders = @get_headers($fileUrl);
			if (preg_match("|200|", $AgetHeaders[0])) {
				$comicString .="<img src='".$row['thumb']."' border='2' alt='LINK' style='border-color:#000000;'>";
			} else {
			 $comicString .="<img src='images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			}
			$comicString .="</a><div class='comictitlelist'>".stripslashes($row['title'])."</div><div class='smspacer'></div><div class='moreinfo'><a href='".urlencode($row['title'])."/'><img src='images/info.jpg' border='0'></a><div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$row['pages']."</div></div></td>";
			 $counter++;
 				if ($counter == 3){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
 			}
	//Display the full navigation in one go
	$comicString .= "</tr></table>";
	if ($Results == 1) {

	echo "<div class='pagination'>".$pager->renderFullNav()."</div><div class='spacer'></div>";
	
	}
	echo $comicString;

if ($Results == 0) {
	
	$comicString= "<div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div align='center' style='font-weight:bold;'>There are no comics that fit your search.</div>";
	
	
	} if ($Results == 1) {

	echo "<div class='pagination'>".$pager->renderFullNav()."</div>";
	
	}?>		
	</div>
<? include 'includes/footer_iphone.php';?>