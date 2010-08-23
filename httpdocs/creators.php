<?php include 'includes/init.php';?>
<?php include 'includes/dbconfig.php'; ?>
<?php include('includes/ps_pagination.php'); ?>

<?php $Title = 'Comic Creators';
$Name = $_GET['name']; 

$PageTitle = ' | Creator Listing';
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
<div class='contentwrapper'>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="padding-right:15px;">
	<div class="comiclist" align="left" style="padding:5px;">
	
	<?php 

$conn = mysql_connect($userhost, $dbuser,$userpass);
mysql_select_db($userdb,$conn);
if ($Genre == ""){
$sql = "select DISTINCT u.email, u.username,u.location,u.joindate,u.avatar from comics as c
		join comic_settings as cs
		join users as u 
		where u.email = cs.Assistant1 or u.email=cs.Assistant2 or u.email=cs.Assistant3 or c.CreatorID=u.encryptid
		order by u.username ASC";
} else {
$sql = "select DISTINCT u.email, u.username,u.location,u.joindate,u.avatar from comics as c
		join comic_settings as cs
		join users as u 
		where (u.email = cs.Assistant1 or u.email=cs.Assistant2 or u.email=cs.Assistant3 or c.CreatorID=u.encryptid or c.userid=u.encryptid) and  u.username LIKE '%$Name%'
		order by u.username ASC";
}

	//Create a PS_Pagination object
$pager = new PS_Pagination($conn,$sql,15,5);
	//The paginate() function returns a mysql result set 
$rs = $pager->paginate();
echo "<div class='comicinfo'><font size='+1'>CREATORS</font></div><div class='pagination'>".$pager->renderFullNav()."</div>";
$comicString = "<table width='100%'><tr>";
$counter = 0;
while($row = mysql_fetch_assoc($rs)) {
$UpdateDay = substr($row['joindate'], 5, 2); 
$UpdateMonth = substr($row['joindate'], 8, 2); 
$UpdateYear = substr($row['joindate'], 0, 4);
$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 $comicString .= "<td valign='top' align='center'><div style='width:110px;'><div class='comictitlelist'>".$row['username']."</div><a href=/profile/".$row['username']."/><img src='".$row['avatar']."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='100'></a>";
 
 if ($row['location'] != '') {
 
 $comicString .=" <br/><span class='joined'>from: <b>".$row['location']."</b></span>";
 
 }
 $comicString .="</div></td>";
 $counter++;
 if ($counter == 5){
 $comicString .= "</tr><tr>";
 $counter = 0;
 }
	}
	//Display the full navigation in one go
	$comicString .= "</tr></table>";
	echo $comicString;
	echo "<div class='pagination'>".$pager->renderFullNav()."</div>";

?> 

	</div></td>
  </tr>
</table>
</div>
	</div>

  <div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>

</body>
</html>

