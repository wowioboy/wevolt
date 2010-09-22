<?php 
if ($_GET['p'] == 'contact')
	header("Location:/contact.php");
	
include 'includes/init.php';
 if ($_SESSION['IsPro'] == 1) 
           $_SESSION['noads'] = 1;

$PageTitle = 'WEvolt | about';
$TrackPage = 1;

require_once('includes/pagetop_inc.php');
$Site->drawModuleCSS();

?>

<div align="left">
<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <? $Site->drawControlPanel('100%');?>
            </div>
        <? }?>
 <?  if ((($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1) || ($_SESSION['IsSuperFan'] == 1)) && ($_SESSION['sidebar'] == 'closed')) {?>
 <div id="pronav">
                <? $Site->drawProNav('100%');?>
 </div>
 <? }?>  
 
 	<table cellpadding="0" cellspacing="0" border="0" width="100%">

	<tr><? if ($_SESSION['IsPro'] == 1) {
				$_SESSION['noads'] = 1;
			} else {
				$_SESSION['noads'] = 0;
			} 
		?> 
        <? if ($_SESSION['sidebar'] == 'open') {?>
		<td valign="top" id="sidebar">
			<?  include 'includes/sidebar_inc.php';?>
		</td> 
        <? }?>
        <td  valign="top" align="center" rowspan="2">
        		
		 <? 
		 

		 if ($_SESSION['noads'] == 0) {?>

				  <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
     <? }?>
                 
<div style="padding:10px;" ><img src="http://www.wevolt.com/images/wevolt_about.png" />
        <div class="spacer"></div> <div class="spacer"></div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/tutorial/?tid=1&step=1"><img src="http://www.wevolt.com/images/quick_tour.png" border="0" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/register.php"><img src="http://www.wevolt.com/images/sc_sign_up.png" border="0" /></a><div class="spacer"></div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/origin.php"><img src="http://www.wevolt.com/images/origin_story_btn.png" border="0" /></a></div> 
         
		</td>
        
	</tr>
   <tr>
    <td id="sidebar_footer"></td>
  </tr>
</table>

</div>

<?php include 'includes/pagefooter_inc.php';

?>



