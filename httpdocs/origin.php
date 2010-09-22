<?php 
include 'includes/init.php';
 if ($_SESSION['IsPro'] == 1) 
    $_SESSION['noads'] = 1;

$PageTitle .= ' | origin story';
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
                 
  <div style="width:728px;" align="center">
        <div class="spacer"></div>
      <img src="http://www.wevolt.com/images/wevolt_origin_story_header.png" /><div class="spacer"></div><div class="spacer"></div>
 		<? if (($_GET['page'] == '') || ($_GET['page'] == '1')) {?>
        <img src="http://www.wevolt.com/images/origin_page_1.png" /><br />
       <? } else if ($_GET['page'] == '2') {?>
        <img src="http://www.wevolt.com/images/origin_page_2.png" /><br />
       <? } else if ($_GET['page'] == '3') {?>
        <img src="http://www.wevolt.com/images/origin_page_3.png" /><br />
        <? } else if ($_GET['page'] == '4') {?>
			<? if ($_SESSION['userid'] != '') {
				$SupriseCode = 'origin_100';
				$query = "SELECT * from suprise_codes where Code='$SupriseCode' and IsActive=1";
				$SupriseArray = $InitDB->queryUniqueObject($query);
				
				$query = "SELECT count(*) from suprise_codes_redeem where Code='$SupriseCode' and UserID='".$_SESSION['userid']."'";
				$Found = $InitDB->queryUniqueValue($query);
				if ($Found == 0) {
					include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
					$XPMaker = new Users();
					$XPMaker->addxp($InitDB, $_SESSION['userid'], $SupriseArray->XP);
					$ShowCongrats = true;
					$query = "INSERT into suprise_codes_redeem (Code, UserID) values ('$SupriseCode', '".$_SESSION['userid']."')"; 
					$InitDB->execute($query);	
				} else {
					$ShowCheater = true;
				}
				
				 if ($ShowCongrats) {?>
                 <img src="http://www.wevolt.com/images/origin_page_4.png" /><br />
              <? } else if ($ShowCheater) {?>
                 <img src="http://www.wevolt.com/images/origin_page_5_no_xp.png" /><br />
              
              <? }?>

			
           <? } else {?>
       			 <img src="http://www.wevolt.com/images/origin_page_4_not_logged.png" /><br />
       		 <? }?>
        <? }?>
       
        <div style="padding:10px;">
        <div class="spacer"></div>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if (($_GET['page'] != '1') && ($_GET['page'] != '')){?><a href="http://www.wevolt.com/origin.php?page=<? if ($_GET['page'] == '2') echo '1'; else if ($_GET['page'] == '3') echo '2'; else if ($_GET['page']=='4') echo '3';?>"><img src="http://www.wevolt.com/images/wizard_back_btn.png" border="0"/></a><? }?><? if ($_GET['page'] != '4'){?><a href="http://www.wevolt.com/origin.php?page=<? if (($_GET['page'] == '1') || ($_GET['page'] == '') ) echo '2'; else if ($_GET['page'] == '2') echo '3'; else if ($_GET['page']=='3') echo '4';?>"><img src="http://www.wevolt.com/images/wizard_next_btn.png" border="0"/></a><? }?>
        <div class="spacer"></div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/tutorial/?tid=1&step=1"><img src="http://www.wevolt.com/images/quick_tour.png" border="0" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/register.php"><img src="http://www.wevolt.com/images/sc_sign_up.png" border="0" /></a></div> </div>
         
		</td>
        
	</tr>
   <tr>
    <td id="sidebar_footer"></td>
  </tr>
</table>

</div>

<?php include 'includes/pagefooter_inc.php';

?>
