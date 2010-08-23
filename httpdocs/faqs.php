<?  
include_once("includes/init.php"); 
$faqDB = new DB();
$query = "select * from faq where Published=1 order by Position";
$faqDB->query($query);
$QuestionString = '<div class="questionlist">';
$AnswerString = '<div class="answerlist">';
$i = 1;
while ($faqentry = $faqDB->fetchNextObject()) {
	$Anchor = 'Question'.$i;
	$QuestionString .= "<a href='#".$Anchor."'><div class='question'>".stripslashes($faqentry->Question)."</a></div><div class='spacer'></div>";
	$AnswerString .= "<a name='".$Anchor."'></a><div class='answer'><b>Question: </b>".stripslashes($faqentry->Question)."<br/>".stripslashes($faqentry->Answer)."</div><div class='spacer'></div>";
	$i++;
} 
$QuestionString .= '</div>';
$AnswerString .= '</div>';
?>
<?php include 'includes/header.php'; ?>
<table width="<? echo $SiteWidth;?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td bgcolor="#FFFFFF">
<div class="contentwrapper" style="background-image:url(images/content_bg.jpg);padding-top:10px; padding-left:10px; padding-right:10px;" >
<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td valign="top" width="300" style="padding-left:5px;"><font style="font-size:14px; font-weight:bold;">QUESTIONS</font><div class="spacer"></div><? echo $QuestionString;?></td><td valign="top" style="padding-left:5px;"><font style="font-size:14px; font-weight:bold;">ANSWERS</font><div class="spacer"></div><? echo $AnswerString;?></td></tr></table><div class="spacer"></div><div class="spacer"></div><div class="spacer"></div>
<div align="center">
<img src="/images/partners.gif" />
</div>
</div>

	</td>
 	</tr>
  	<tr>
    <td id="footer">&nbsp;</td>
  	</tr>
</table>
<?php include 'includes/footer.php'; ?>	