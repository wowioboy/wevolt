<?php 
include 'includes/global_settings_inc.php';
include 'includes/init.php';
require_once('includes/ps_pagination.php');
$genreString = $Genre;
$sort = $_GET['sort']; 

if ($sort == "") {
$sort = 3;
}
$Results = 0;
$PageTitle = 'wevolt | mobile';
$TrackPage = 1;
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

<td  valign="top" align="center"><? if ($_SESSION['noads'] != 1) {?><iframe src="http://www.wevolt.com/includes/top_banner_inc.php" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no"></iframe> <? }?>

    <? ?>
<table width="750" border="0" cellpadding="0" cellspacing="0" height="">
                  <tbody>
                    <tr>
                      <td id="modtopleft"></td>
                      <td id="modtop" width="738" align="left">WEVOLT MOBILE</td>
                          
                      <td id="modtopright" align="right" valign="top"></td>
                    </tr>
                    <tr>
                      <td colspan="3" valign="top" style="padding-left:3px; padding-right:3px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <td id="modleftside"></td>
                              <td class="boxcontent">
                        	  <form name="form" action="/mobile.php" method="get">

	<div class="pageheader">WALLPAPERS </div>
   
	<div align="right"><input type="text" size="30"  name="search" />&nbsp;&nbsp;<input type="submit" value="Search" /></div>
 
  </form>
  
	<div class="comiclist" align="left" style="padding:5px;">
	 <div class="warning">Just click a wallpaper to send it to your phone! You must be a registered user and signed in.</div>
	<?php 

	if (($_SESSION['overage'] == 'N') || ($_SESSION['overage'] == ''))
					$where .= " where c.Rating !='a' ";
$conn = mysql_connect(PANELDBHOST, PANELDBUSER,PANELDBPASS);
mysql_select_db(PANELDB,$conn);
if (((!isset($Genre)) && (!isset($search))) || ((isset($search)) && ($search == ""))){
if ($sort == 1) {
				$sql = "select * from mobile_content as m
						join projects as c on m.ComicID=c.comiccrypt ".
						$where."
						ORDER BY title ASC"; 
				
				} else if ($sort == 2) {
				$sql = "select * from mobile_content as m
						join projects as c on m.ComicID=c.comiccrypt ".
						$where."
						ORDER BY createdate ASC";
				
				} else if ($sort == 3) {
				$sql = "select  * from mobile_content as m
						join projects as c on m.ComicID=c.comiccrypt ".
						$where."
				 ORDER BY downloads ASC";
				
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
				$sql = "SELECT * FROM mobile_content as m" .
				"join projects as c on m.ComicID=c.comiccrypt ".
						"WHERE genre LIKE '%".$keywords[$i]."%'".
						$where."
						ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "SELECT * FROM mobile_content as m" .
				"join projects as c on m.ComicID=c.comiccrypt ".
						"WHERE genre LIKE '%".$keywords[$i]."%'".
						$where." ORDER BY createdate DESC";
				
				} else if ($sort == 3) {
				$sql = "SELECT * FROM mobile_content as m" .
				"join projects as c on m.ComicID=c.comiccrypt ".
						"WHERE genre LIKE '%".$keywords[$i]."%'".
						$where."  ORDER BY downloads DESC";
				
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
				$sql = "SELECT * FROM mobile_content as m" .
						"WHERE title LIKE '%".$keywords[$i]."%'".
						"join comics as c on m.ComicID=c.comiccrypt ".
					" OR tags LIKE '%".$keywords[$i]."%'" .
					" OR genre LIKE '%".$keywords[$i]."%'".
						$where." ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$sql = "SELECT * FROM mobile_content as m" .
						"join comics as c on m.ComicID=c.comiccrypt ".
						"WHERE title LIKE '%".$keywords[$i]."%'".
					" OR tags LIKE '%".$keywords[$i]."%'" .
					" OR genre LIKE '%".$keywords[$i]."%'".
						$where."  ORDER BY createdate DESC";
				
				} else if ($sort == 3) {
				$sql = "SELECT * FROM mobile_content as m" .
						"WHERE title LIKE '%".$keywords[$i]."%'".
						"join comics as c on m.ComicID=c.comiccrypt ".
					" OR tags LIKE '%".$keywords[$i]."%'" .
					" OR genre LIKE '%".$keywords[$i]."%'".
						$where." and installed = 1 ORDER BY downloads DESC";
				
				}
						
				}
			}
	//Create a PS_Pagination object
	foreach($keywords as $value) {
   				print "$value ";
			}		
}
$pager = new PS_Pagination($conn,$sql,30,6);
	//The paginate() function returns a mysql result set 
			$rs = $pager->paginate();
			
			$comicString = "<table width='100%'><tr>";
			$counter = 0;
			while($row = mysql_fetch_assoc($rs)) {
			$Results = 1;
			$UpdateDay = substr($row['CreationDate'], 5, 2); 
			$UpdateMonth = substr($row['CreationDate'], 8, 2); 
			$UpdateYear = substr($row['CreationDate'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 			$comicString .= "<td valign='top' width='150'><div align='center'><a href='/send_to_mobile.php?content=".$row['EncryptID']."'><img src='/comics/".$row['HostedUrl']."/".$row['Thumb']."' border='2' alt='LINK' style='border-color:#000000;'>";
		
			$comicString .="</a><div style='font-size:10px;'>".stripslashes($row['Title'])."</div><div class='smspacer'></div></td>"; 
			 $counter++;
 				if ($counter == 6){
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
	
	echo "<div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div align='center' style='font-weight:bold;'>There are no wallpapers that fit your search.</div>";
	
	
	}

?> 
	</div>
                 		
                             </td>
                              <td id="modrightside"></td>
                            </tr>
                            <tr>
                      <td id="modbottomleft"></td>
                      <td id="modbottom"></td>
                      <td id="modbottomright"></td>
                    </tr>
                          </tbody>
                      </table>


    
 	</td>
	
</tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>







