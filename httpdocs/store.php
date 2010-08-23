<?php include 'includes/init.php';?>
<? 
$PageTitle = 'Store';
?>
<? if ($_GET['a'] == 'success') {
		$Message='<div class="pageheader">Thanks for your order!</div><div style="padding:15px; height:200px;">Your Payment has been recieved and will be processed shortly. Once your order is complete you will recieve an email with your confirmation.</div>';

} else if ($_GET['a'] == 'cancel') {
		$Message='<div class="pageheader" style="height:200px;padding-top:15px;" align="center">Your order has been cancelled</div>';

} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
 
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?> - <?php echo $PageTitle; ?></title>

</head>

<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 

     <div class='contentwrapper'>
<div class="contentdiv">
<? echo $Message;?>

</div>
  </div>
 </div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>
</body>
</html>

