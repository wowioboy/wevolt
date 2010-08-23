<?php 
function randomPrefix($length)
{
$random= "";

srand((double)microtime()*1000000);

$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
$data .= "0FGH45OP89";

for($i = 0; $i < $length; $i++)
{
$random .= substr($data, (rand()%(strlen($data))), 1);
}

return $random;
}
include 'includes/init.php';
$Code = $_GET['id'];
if (!isset($_SESSION['userid'])) {
	header("location:login.php?ref=hosting_discount.php?id=".$Code);
}
$UserID = $_SESSION['userid'];
include 'includes/db.class.php';
$buyDB = new DB();
//SELECT THE CODE, SEE IF IT'S VALID THEN DISPLAY THE BUTTON.
$query = "SELECT * from discounts where Code='$Code' and UserID='$UserID'";
$buyDB->query($query);
$Valid = $buyDB->numRows();
if ($Valid == 1) {
	$PurchaseID = randomPrefix(15); 
	$query = "UPDATE purchases set PurchaseID='$PurchaseID' where UserID='$UserID' and Type='application' and Completed=0";
	$buyDB->query($query);
	} else {
$Error = 'Sorry your discount code is not correct. Please click the link that was emailed to you when you signed up for domain hosting with Panel Flow.';
}
$buyDB->close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - PANEL FLOW PRO 1.5 - MULTI COMIC - DISCOUNT OFFER</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

<div class='contentwrapper'>
<div class="contenttext" style="height:300px; "align="left">
 <? if ($Valid == 1) {?>
 <div class="featuresheader">PANEL FLOW PRO 1.5 - MULTI COMIC - DISCOUNT OFFER</div>
  <div class="featurelist"> <ul> 
          <li class="bullet" style="padding-bottom:3px;">Create your own Webcomics hub, and manage unlimted comics from one central administration interface.
          <li class="bullet" style="padding-bottom:3px;">Start syndication your comic all across the web with a built in flash widget to mirrir your latest update, then links the reader back to your site to read more.
          <li class="bullet" style="padding-bottom:3px;">Easily switch styles and looks for your comics through a built in templating system. 
          <li class="bullet" style="padding-bottom:3px;">Assign Assistants and Creators to comics and let them manage their assigned comics.
           <li class="bullet" style="padding-bottom:3px;">Que pages to go live on a specific date and quickly move pages around. 
            <li class="bullet" style="padding-bottom:3px;">Upload extra content for your readers like Character Profiles, Wallpapers, Avatars and more.
            <li class="bullet" style="padding-bottom:3px;">Allow anyone with a Panel Flow account to log into your site to leave page comments.
            <li class="bullet" style="padding-bottom:3px;">Access to pagetracking tools to see how many people are reading your comic everyday.
            <li class="bullet" style="padding-bottom:3px;">Upload new modules to further enhance your comic and add features.
          </ul>
          </li>
</div>
<div class="spacer"></div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="invoice" value="<? echo $PurchaseID;?>" />
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="1227519">
<div align="center">
<input type="image" src="images/discount_pf.gif" style="border:none;" border="0" name="submit" alt="">
</div>
</form>
  <div align="center"></div>
	<?php } else { ?>
	<div align="center" style="height:300px;padding-top:50px;">
	<? echo $Error;?>
	</div>
	
	<?php }?>
  </div>
  </div>
  <?php include 'includes/footer_v2.php';?>
</body>
</html>

