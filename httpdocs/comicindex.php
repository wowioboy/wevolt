<?  
if (!file_exists('pfpro_demo/includes/config.php')) {
if (!file_exists('pfpro_demo/install/index.php')) {
     header('Location: /noconfig.php');
	 } else {
	 
	 header('Location: install/index.php');
	 }
   // echo "The file $filename exists";
}	

include 'pfpro_demo/includes/db.class.php'; 
include 'pfpro_demo/includes/config.php';
$db_user = $config['db_user'];
$db_pass = $config['db_pass'];
$db_database = $config['db_database'];
$db_host = $config['db_host'];
$PFDIRECTORY = $config['pathtopf'];
$Pagetracking = 'Comics'; 
//include 'includes/comic_functions.php'; 
//include 'includes/admin_date_inc.php'; 
?>

<?

 function strictify ( $string ) {

       $fixed = htmlspecialchars( $string, ENT_QUOTES );

       $trans_array = array();
       for ($i=127; $i<255; $i++) {
           $trans_array[chr($i)] = "&#" . $i . ";";
       }

       $really_fixed = strtr($fixed, $trans_array);

       return $really_fixed;

   }
   
  $page = $_POST['page'];
  $ComicID = $_GET['id'];
   $comicsDB =  new DB($db_database,$db_host, $db_user, $db_pass);
if (!isset($_GET['id'])) {  
  if (!isset($page))
    $page = 1;
		if (((!isset($Genre)) && (!isset($search))) || ((isset($search)) && ($search == ""))){
			if ($sort == 1) {
				$sql = "select comiccrypt, title, url, thumb, pages, updated from comics where installed = 1 ORDER BY title ASC";
				
			} else if ($sort == 2) {
				$sql = "select comiccrypt, title, url, thumb, pages, updated from comics where installed = 1 ORDER BY createdate ASC";
				
			} else if ($sort == 3) {
				$sql = "select * from comics where installed = 1 ORDER BY updated ASC";
				
			} else {
		$sql = "select * from comics where installed = 1 ORDER BY updated ASC";
			
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
						
			}// end for
	} // end else

} // End Search if

 $cnt = 0;
 $comicString = "<table width='350'><tr>";
    $comicsDB->query($sql);
    while ($line = $comicsDB->fetchNextObject()) {      
      if (($cnt >= (($page-1)*10)) && ($cnt < ($page*10))){
	  		$UpdateDay = substr($line->updated, 5, 2); 
			$UpdateMonth = substr($line->updated, 8, 2); 
			$UpdateYear = substr($line->updated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 			$comicString .= "<td valign='top'><div align='center'><div class='comictitlelist'>".stripslashes($line->title)."</div><a href='".$line->url."'>";
				//$fileUrl = $line->thumb;
		    	//$AgetHeaders = @get_headers($fileUrl);
			//if (preg_match("|200|", $AgetHeaders[0])) {
			$comicString .="<img src='http://".$line->thumb."' border='2' alt='LINK' style='border-color:#000000;'>";
			//} else {
			 //	$comicString .="<img src='images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			//}
			$comicString .="</a><div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$line->pages."</div></div></td>"; 
			 $counter++;
 				if ($counter == 3){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
 	}
	//Display the full navigation in one go
  	 $cnt++;
  }
    $comicsDB->close();
	$comicString .= "</tr></table>";
  if ($cnt >= ($page*10)){
    	$nextpage = true;
	} else{
    	$nextpage = false;
	}
  if ($page > 1)
    $previouspage = true;
  else
    $previouspage = false;

}
$comicsDB->close();
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="JavaScript">
  function nextpage()
  {
    document.getElementById('page').value = <? echo ($page+1); ?>;
    document.form1.submit();
  }
  
  function previouspage()
  {
    document.getElementById('page').value = <? echo ($page-1); ?>;
    document.form1.submit();
  }
</script>
<script type="text/javascript" src="pfpro_demo/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $Synopsis ?>"></meta>
<meta name="keywords" content="<?php echo $Genre;?>, <?php echo $Tags;?>"></meta>
<LINK href="pfpro_demo/css/pf_css.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $ComicTitle; ?> - ADMIN SECTION</title>
</head>
<body background="pfpro_demo/images/admin_bg.jpg" style="background-repeat:repeat-x;">
<div class="wrapper" align="center">

<? 

if (!isset($_GET['id'])) { ?>
<div style="height:100px"></div>
<font  style="font-size:16px;">COMICS</font>
<?
echo $comicString;
} else if (($_SESSION['usertype'] == 1) || ($_SESSION['usertype'] == 2)){?>
<div id="admin">To listen this track, you will need to have Javascript turned on and have <a href="http://www.adobe.com/go/getflashplayer/" target="_blank">Flash Player 8</a> or better installed.</div>
			    <script type="text/javascript"> 
                  var so = new SWFObject('flash/pf_admin_DBpro_v1-5.swf','mpl','1024','728','9'); 
                so.addParam('allowfullscreen','true'); 
                  so.addParam('allowscriptaccess','true'); 
				  so.addVariable('baseurl','<?php echo $ComicFolder;?>');
				  so.addVariable('userid','<?php echo $_SESSION['userid'];?>');
  				  so.addVariable('usertype','<?php echo $_SESSION['usertype'];?>');
				  so.addVariable('comicid','<?php echo $ComicID;?>');
				 so.addVariable('currentday','<?php echo $CurrentDay;?>');
				  so.addVariable('currentmonth','<?php echo $CurrentMonth;?>');
				  so.addVariable('currentyear','<?php echo $CurrentYear;?>');
				  so.addVariable('currentsection','<?php echo $_GET['section'];?>');
				  <? if ($_GET['section'] == 'info') { ?>
				   so.addVariable('ComicXML','<?php echo $ComicXML;?>');
				  	so.addVariable('barcolor','<?php echo $BarColor;?>');
				  	so.addVariable('textcolor','<?php echo $TextColor;?>');
				  	so.addVariable('moviecolor','<?php echo $MovieColor;?>');
				  	so.addVariable('buttoncolor','<?php echo $ButtonColor;?>');
				  	so.addVariable('arrowcolor','<?php echo $ArrowColor;?>');
				  <? } else if ($_GET['section'] == 'creator') { ?>
				  		so.addVariable('CreatorXML','<?php echo $ComicXML;?>');
				 <? } else if ($_GET['section'] == 'pages') { ?>
				  so.addVariable('PageXML','<?php echo $PageXML;?>');
  				 <? } else if ($_GET['section'] == 'characters') { ?>
				 so.addVariable('CharacterXML','<?php echo $ComicXML;?>');
				 <? } else if ($_GET['section'] == 'downloads') { ?>
				 so.addVariable('DownloadsXML','<?php echo $ComicXML;?>');
				  <? } else if ($_GET['section'] == 'links') { ?>
				 so.addVariable('LinksXML','<?php echo $ComicXML;?>');
				  <? } else if ($_GET['section'] == 'settings') { ?>
				 so.addVariable('SettingsXML','<?php echo $ComicXML;?>');
				   <? } else if ($_GET['section'] == 'extras') { ?>
				 so.addVariable('PageXML','<?php echo $PageXML;?>');
				 <? } ?>
                  so.write('admin'); 
                </script>
<? }  else {?>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div> YOU NEED TO LOG IN AS AN ADMINISTRATOR TO ACCESS THE ADMIN PANEL</div>
				<div> <a href="login.php">CLICK HERE</a> </div>
					<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
				<div class="spacer"></div>
<? }?>
	 <div class="spacer"></div>	
	<form name="form1" action="#" method="post">
    <input type="hidden" name="page" id="page" value="" />
    <input type="hidden" name="searchtext" value="<? echo $Search; ?>" />
   	</form>				
</div>
</body>
</html>