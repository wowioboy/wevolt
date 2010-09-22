<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php'); 
$PageTitle .= 'SUPRISE - YOU WON A PRIZE!';
$TrackPage = 0;

$ShowCongrats = false;
$ShowCheater = false;
$ShowLogin = false;
if ($_SESSION['suprise_redirect'] == '')
	header("Location:/index.php");
if ($_SESSION['suprise_code'] == '')
	header("Location:/index.php");
if (($_SESSION['suprise_code'] != '') && ($_SESSION['userid'] != '')) {
	$query = "SELECT * from suprise_codes where Code='".$_SESSION['suprise_code']."' and IsActive=1";
	$SupriseArray = $InitDB->queryUniqueObject($query);
	//print_r($SupriseArray);
	if ($SupriseArray->ID == ''){
		$_SESSION['suprise_code'] = '';	
		header("Location:".$_SESSION['suprise_redirect']);
	} else {
		$query = "SELECT count(*) from suprise_codes_redeem where Code='".$_SESSION['suprise_code']."' and UserID='".$_SESSION['userid']."'";
		$Found = $InitDB->queryUniqueValue($query);
		if ($Found == 0) {
			include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
			$XPMaker = new Users();
			$XPMaker->addxp($InitDB, $_SESSION['userid'], $SupriseArray->XP);
			$ShowCongrats = true;
			$query = "INSERT into suprise_codes_redeem (Code, UserID) values ('".$_SESSION['suprise_code']."', '".$_SESSION['userid']."')"; 
			$InitDB->execute($query);	
		} else {
			$ShowCheater = true;
		}
		$XP = $SupriseArray->XP;  
		if ($SupriseArray->NewCode != '') {
			$_SESSION['suprise_code'] = $SupriseArray->NewCode;
			
		}
	}
} else {
	if ($_SESSION['userid'] == '') {
		$ShowLogin = true;
	}

}
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
    
   <div style="padding:10px;">
             <div align="left"> <img src="http://www.wevolt.com/images/wevolt_suprise.png" /></div>
        <div class="messageinfo_white" style="padding-left:40px;" align="left">

     <div class="spacer"></div>
     <? if ($ShowCheater){ ?>
        <div class="spacer"></div>Hey wait a minute...did you already get this suprise? <div class="spacer"></div>

One second, let me check the records....&nbsp;&nbsp;Yep, says right here you already got this one.<div class="spacer"></div>

We all make mistakes...now go find a NEW suprise!<div class="spacer"></div>
<? } else if ($ShowCongrats) {?>
 <div class="spacer"></div>
           <div class="spacer"></div>Nice Work! You found a WEvolt Suprise! <div class="spacer"></div>

You just scored yourself <? echo $XP;?> points of XP.<div class="spacer"></div>

Now go find a NEW suprise!<div class="spacer"></div>
<? echo $SupriseArray->HTMLCode;?>
<? } else if ($ShowLogin) {?>
<div class="spacer"></div>So Close! All you need to do is login with that button in the menu to claim this suprise!<div class="spacer"></div>
<? }?>

</div>
      </div>

	</td>
  </tr>
 
</table>
</div>
  
<?php require_once('includes/pagefooter_inc.php'); ?>


