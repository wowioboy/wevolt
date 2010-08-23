<?php include 'includes/init.php';?>
<?php 
if (!isset($_SESSION['userid'])) {
	header("location:login.php?ref=editprofile.php");
}
$ID = $_SESSION['userid'];

include 'includes/dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
 
 $query = "select * from $usertable where encryptid='$ID'";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     $Username = $user['username'];
	 $Avatar = $user['avatar'];
	 $Music = $user['music'];
	 $Music = str_replace(chr(13), '\n', $Music);
	 $Music = str_replace(chr(10), '\n', $Music);
	 $Location = $user['location'];
	 $Books = $user['books'];
	 $Books = str_replace(chr(13), '\n', $Books);
	 $Books = str_replace(chr(10), '\n', $Books);
	 $Hobbies = $user['hobbies'];
	 $Hobbies = str_replace(chr(13), '\n', $Hobbies);
	 $Hobbies = str_replace(chr(10), '\n', $Hobbies);
	 $Realname = $user['realname'];
	 $Website= $user['website'];
	 $About = $user['about'];
	 $About = str_replace(chr(13), '\n', $About);
	 $About = str_replace(chr(10), '\n', $About);
	 $Influences = $user['influences'];
	 $Influences = str_replace(chr(13), '\n', $Influences);
	 $Influences = str_replace(chr(10), '\n', $Influences);
	 $Credits = $user['credits'];
	 $Credits = str_replace(chr(13), '\n', $Credits);
	 $Credits = str_replace(chr(10), '\n', $Credits);
	 $IsCreator = $user['iscreator'];
	 $Link1 = $user['link1'];
	 $Link2 = $user['link2'];
	 $Link3 = $user['link3'];
	 $Link4 = $user['link4'];
	 $AllowComments = $user['allowcomments'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - EDIT PROFILE OF <? echo $Username; ?></title>

</head>

<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 

     <div class='contentwrapper'>
<div class="content" align="center">


<div id="editprofile">
		<strong>You need to upgrade your Flash Player <br /><a href="login.php"> CLICK HERE TO LOGIN </a></strong></div>
<script type="text/javascript">
		// <![CDATA[
		var so = new SWFObject("profileedit_creator.swf", "edit", "470", "400", "8.0.23", "#ffffff", true);
	    so.addVariable('music','<?php echo addslashes($Music);?>');
		so.addVariable('books','<?php echo  addslashes($Books);?>');
		so.addVariable('userlocation','<?php echo  addslashes($Location);?>');
		so.addVariable('hobbies','<?php echo  addslashes($Hobbies);?>');
		so.addVariable('realname','<?php echo  addslashes($Realname);?>');
		so.addVariable('website','<?php echo  addslashes($Website);?>');
		so.addVariable('about','<?php echo  addslashes($About);?>');
		so.addVariable('influences','<?php echo  addslashes($Influences);?>');
		so.addVariable('credits','<?php echo  addslashes($Credits);?>');
		so.addVariable('link1','<?php echo $Link1;?>');
        so.addVariable('link2','<?php echo $Link2;?>');
		so.addVariable('link3','<?php echo $Link3;?>');
		so.addVariable('link4','<?php echo $Link4;?>');
		so.addVariable('commentsallow','<?php echo $AllowComments;?>');
		so.addVariable('username','<?php echo  addslashes(trim($_SESSION['username']));?>');
		so.write("editprofile");
		// ]]>
	</script>

</div>
  </div>
 </div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>
</body>
</html>

