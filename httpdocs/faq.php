<?php include 'includes/init.php';?>
<?php include 'includes/dbconfig.php'; ?>
<?php include('includes/ps_pagination.php'); 
$faqDB = new DB();
$query = "select * from faq where Published=1 order by Position";
$faqDB->query($query);
$QuestionString = '';
$AnswerString = '';
$questions = '';
$i = 1;
while ($faqentry = $faqDB->fetchNextObject()) {
	$Anchor = 'Question'.$i;
	$QuestionString .= "<a href='#".$Anchor."'>".stripslashes($faqentry->Question)."</a><div class='spacer'></div>";
	$questions .= ', ' .stripslashes($faqentry->Question) ;
	$AnswerString .= "<div class='question'><b>Q: </b>".stripslashes($faqentry->Question)."</div><div name='".$Anchor." class='answer'>A:".stripslashes($faqentry->Answer)."</div><div class='spacer'></div>";
	$i++;
} 

?>

<?php 
$PageTitle = ' | FAQs';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>,<? echo $questions;?>"></meta>
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
    <td colspan="2"><div class="pageheader">FREQUENTLY ASKED QUESTIONS </div><div class="spacer"></div></td>
    </tr>
  <tr>
    <td width="150" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="150">
		<tr>
			<td background="/images/genre_header.png" height="15" width="150" style="background-repeat:no-repeat;" ></td>
        </tr>
        	<td background="/images/genre_bg.jpg" style="background-repeat:repeat-y;" bgcolor="#FFFFFF"> 
        		<div class="infoheader"><img src="/images/radiobtn.jpg" /> QUESTIONS </div>
    			<div class="spacer"></div>
             	<div class="questions" style="padding-right:2px;">
					<? echo $QuestionString;?>
                </div>
			</td>
       </tr>
       <tr>
       		<td background="/images/genre_footer.png" height="15" width="150" style="background-repeat:no-repeat;"></td>
      </tr>
   	  </table> </td>
    <td valign='top'>	<div class="faqwrapper" align="left" style="padding:10px;">
		<? echo $AnswerString;?>
        </div></td>
  </tr>
</table>
   
</div>
    </div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>
</body>
</html>

