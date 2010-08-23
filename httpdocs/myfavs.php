<?php include 'includes/init.php';?>
<?php include 'includes/comments_inc.php';?>
<?php include 'includes/favorites_inc.php';?>
<?php
//print "MY SESSION ID = " . trim($_SESSION['userid']);
$ID = trim($_SESSION['userid']);

if ($ID == ""){
 header("Location:/index.php");
}

if ($_POST['deletefav'] == 1){
deletefavorite(trim($_POST['comicid']), trim($_POST['favid']), trim($_SESSION['userid']));
} 

if ($_POST['notify'] == 1){
NotifyFavorite($_POST['favid']);
} 

if ($_POST['stopnotify'] == 1){
RemoveNotify($_POST['favid']);
} 

include 'includes/dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - MY FAVORITE COMICS</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<div align="center" style=" padding-left:13px;">
	<table width="502" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="padding-left:15px;">
	<div class="pageheader">FAVORITE COMICS</div>
<div class="lgspacer"></div>
<?php  
if ($ID == $_SESSION['userid']) { 
  $counter =0;
$query = "SELECT * FROM $favtable WHERE userid='$ID'";
$result = mysql_query($query);
$nRows = mysql_num_rows($result);
$Count = 1;
  $comicString = "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";
 for ($i=0; $i< $nRows; $i++){
   		$row = mysql_fetch_array($result);
	    $query = "SELECT comiccrypt, thumb, title, url, short, updated FROM comics WHERE " .
		         "comiccrypt='".$row['comicid']."' LIMIT 1";
			//print $query;
        $comicresult = mysql_query($query);
		$ComicsArray = mysql_fetch_array( $comicresult);
		$Updated = substr($ComicsArray['updated'], 0, 10);
  	 	$comicString .= "<td valign='top' width='100'><b>".$ComicsArray['title']."</b><br />updated: <br/><b>".$Updated."</b><br />
<a href='".$ComicsArray['url']."' target='blank'><img src='".$ComicsArray['thumb']."' border='2' alt='LINK' style='border-color:#000000;'></a><div class='smspacer'></div><div style='padding-left:6px;'><a href='/".$ComicsArray['title']."/'><img src='images/info.jpg' border='0'></a><br />
<a href='".$ComicsArray['url']."' target='blank'><img src='images/read_small.jpg' border='0'></a><br />

   <form method='POST' action='myfavs.php'>
	<input type='hidden' name='deletefav' id='deletefav' value='1'>
	<input type='hidden' name='favid' id='favid' value='".$row['favid']."'>
	<input type='hidden' name='comicid' id='comicid' value='".$row['comicid']."'>
	<input type='image' src='images/delete_lg.jpg' value='DELETE' style='border:none;'/>
	</form><form method='POST' action='myfavs.php'><input type='hidden' name='favid' id='favid' value='".$row['favid']."'>";
	
	if ($row['notify'] == 1) {
		$comicString .= "<input type='hidden' name='stopnotify' id='stopnotify' value='1'><input type='image' src='images/nonotify.jpg' value='notify' style='border:none;' /></form></div></td>";
	} else {
		$comicString .= "<input type='hidden' name='notify' id='notify' value='1'><input type='image' src='images/notify_me.jpg' value='notify' style='border:none;' /></form></div></td>";
	}
	}
	 $counter++;
 			if ($counter == 4){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
	
	 $comicString .= "</tr></table>";
	 echo $comicString; 
	 if ($nRows == 0 ){
	 
	 echo "<div class='favs'>You have not added any favorites yet</div>";
	 
	 }
	 
	 
	 
	 } 
	
?></td>
    </tr>
</table>
	
	</div>
  </div>
  <?php include 'includes/footer_v2.php';?>
  <map name="Map" id="Map"><area shape="rect" coords="143,9,201,21" href="register.php" />
<area shape="rect" coords="223,7,258,23" href="login.php" />
<area shape="rect" coords="283,9,338,21" href="contact.php" />
<area shape="rect" coords="360,8,407,22" href="comics.php" />
<area shape="rect" coords="429,8,462,23" href="faq.php" />
<area shape="rect" coords="487,7,545,21" href="creators.php" />
<area shape="rect" coords="568,6,638,23" href="download.php" />
</map>
</body>
</html>

