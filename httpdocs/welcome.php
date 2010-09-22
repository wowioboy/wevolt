<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php'); 
 if ($_SESSION['IsPro'] == 1) 
    $_SESSION['noads'] = 1;
$query = "SELECT ReadBetaWelcome from users_settings where UserID='".$_SESSION['userid']."'";
$HasRead = $InitDB->queryUniqueValue($query);
if (($HasRead == '') or ($HasRead == 0)){
$query = "UPDATE users_settings set ReadBetaWelcome='1' where UserID='".$_SESSION['userid']."'";
$InitDB->execute($query);
}
$PageTitle .= 'welcome to WEvolt!';
$TrackPage = 1;

require_once('includes/pagetop_inc.php');
$Site->drawModuleCSS();

?>

<div align="center">
<table cellpadding="0" cellspacing="0" border="0" width="<? echo $TemplateWrapperWidth;?>">
  <tr>
    <td valign="top" align="center">
    <div class="content_bg">
		<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <?php $Site->drawControlPanel(); ?>
            </div>
        <? }?>
        <? if ($_SESSION['noads'] != 1) {?>
            <div id="ad_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;" align="center">
                <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
            </div>
        <?  }?>
       
       
        <div id="header_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;">
           <? $Site->drawHeaderWide();?>
        </div>
    </div>
    
     <div class="shadow_bg">
        	 <? $Site->drawSiteNavWide();?>
    </div>
    
   <div style="width:<? echo $SiteTemplateWidth;?>px;">
 <div style="width:728px;" align="center">
        <div class="spacer"></div>
      <img src="http://www.wevolt.com/images/tuts/wevolt_welcome_header.png" /><div class="spacer"></div><div class="spacer"></div>
      <? if (($_SESSION['showelcome'] == 1) && ($HasRead == 1)) {?><div class="spacer"></div><div class="messageinfo_white" style="font-size:10px;">
      psst...you can turn this page off in your <a href="http://users.wevolt.com/myvolt/<? echo $_SESSION['username'];?>/?t=settings">SETTINGS</a></div><div class="spacer"></div><? }?>
      
      <div class="spacer"></div>
 		<? if (($_GET['page'] == '') || ($_GET['page'] == '1')) {?>
        <img src="http://www.wevolt.com/images/tuts/wevolt_welcome_1.png" /><br />
       <? } else if ($_GET['page'] == '2') {?>
         <img src="http://www.wevolt.com/images/tuts/wevolt_welcome_2.png" /><br />
       <? } else if ($_GET['page'] == '3') {?>
         <img src="http://www.wevolt.com/images/tuts/wevolt_welcome_3.png" /><br />
       <? } else if ($_GET['page'] == '4') {?>
         <img src="http://www.wevolt.com/images/tuts/wevolt_welcome_4.png" /><br />
       <? } else if ($_GET['page'] == '5') {?>
         <img src="http://www.wevolt.com/images/tuts/wevolt_welcome_5.png" border="0" usemap="#Map" />
<map name="Map" id="Map"><area shape="rect" coords="190,416,355,472" href="http://www.wevolt.com/upgrade.php" /></map><br />
		
		<? } else if ($_GET['page'] == '6') {?>
<? if ($_SESSION['userid'] != '') {
				$SupriseCode = 'welcome_100';
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
                  <img src="http://www.wevolt.com/images/tuts/wevolt_welcome_6.png" border="0" usemap="#Map" />

              <? } else if ($ShowCheater) {?>
                 <img src="http://www.wevolt.com/images/tuts/wevolt_welcome_6_no_xp.png" border="0" usemap="#Map"/><br />
              
              <? }?>

			
           <? } else {?>
       			 <img src="http://www.wevolt.com/images/tuts/wevolt_welcome_6_not_logged.png" border="0" usemap="#Map" /><br />
       		 <? }?>
             <map name="Map" id="Map">
<area shape="rect" coords="13,181,282,272" href="http://users.wevolt.com/myvolt/<? echo $_SESSION['username'];?>/" />
<area shape="rect" coords="327,184,583,263" href="http://www.wevolt.com/search/" />
<area shape="rect" coords="10,282,285,366" href="http://users.wevolt.com/<? echo $_SESSION['username'];?>/" />
<area shape="rect" coords="11,378,287,445" href="http://www.wevolt.com/cms/admin/" /><area shape="rect" coords="336,273,585,364" href="http://www.wevolt.com/" /><area shape="rect" coords="336,371,580,450" href="http://www.wevolt.com/forum/" /></map>
        <? }?>
       
        <div style="padding:10px;">
        <div class="spacer"></div>
<div class="spacer"></div>
	   <table width="75%"><tr><td width="25%" align="right">
	   <? if (($_GET['page'] != '1') && ($_GET['page'] != '')){?><a href="http://www.wevolt.com/welcome.php?page=<? if ($_GET['page'] == '2') echo '1'; else if ($_GET['page'] == '3') echo '2'; else if ($_GET['page']=='4') echo '3';else if ($_GET['page']=='5') echo '4';else if ($_GET['page']=='6') echo '5';?>"><img src="http://www.wevolt.com/images/tut_prev.png" border="0"/></a><? }?>
	   </td><td width="50%" align="center">
	    <? if (($_GET['page'] == '1') || ($_GET['page'] == '')){?>
        <img src="http://www.wevolt.com/images/tuts/page_1of6.png" />
		<? } else if ($_GET['page']== '2'){?>
        <img src="http://www.wevolt.com/images/tuts/page_2of6.png" />
        <? } else if ($_GET['page']== '3'){?>
        <img src="http://www.wevolt.com/images/tuts/page_3of6.png" vspace="40" />
        <? } else if ($_GET['page']== '4'){?>
        <img src="http://www.wevolt.com/images/tuts/page_4of6.png" vspace="40" />
        <? } else if ($_GET['page']== '5'){?>
        <img src="http://www.wevolt.com/images/tuts/page_5of6.png" />
         <? } else if ($_GET['page']== '6'){?>
         <img src="http://www.wevolt.com/images/tuts/page_6of6.png" />
		<? }?>
	   </td>
       <td width="25%" align="left">
	   <? if ($_GET['page'] != '6'){?><a href="http://www.wevolt.com/welcome.php?page=<? if (($_GET['page'] == '1') || ($_GET['page'] == '')) echo '2'; else if ($_GET['page'] == '2') echo '3'; else if ($_GET['page']=='3') echo '4';else if ($_GET['page']=='4') echo '5';else if ($_GET['page']=='5') echo '6';?>"><img src="http://www.wevolt.com/images/tut_next.png" border="0"/></a><? }?>
       </td></tr></table>
        <div class="spacer"></div>
</div> </div> 
 </div>

	</td>
  </tr>
 
</table>
</div>
  
<?php require_once('includes/pagefooter_inc.php'); ?>


