<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php'); 
$PageTitle .= 'Terms of Use';
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
    
     <div class="content_bg" id="content_wrapper">
         <!--Content Begin -->
         <div class="spacer"></div>
         <table cellspacing="0" cellpadding="0" width="<? echo $SiteTemplateWidth;?>">
             <tr>
              <? if ($_SESSION['noads'] != 1) {?>
                <td valign="top" style="padding-left:10px;" width="300">
                
                <!-- LEFT AD BOX -->
                
                <div id="left_ad_div" style="background-color:#FFF;width:300px;" align="center">
                  <? $Site->drawVideoBoxAd();?>
                </div>
                
                 
                </td>
                   <?  }?>      
                <td valign="top" style="padding-left:10px;padding-top:20px;">
            
Last Modified: Jan 01, 2010<br />

<strong>TERMS OF USE</strong><br />

Legal Compliance<br />
<br />


Users of this website ("Website") acknowledge and agree that they must observe all applicable state, local and federal laws and agree not to submit any material that is illegal, offensive or inappropriate in any way. This Website reserves the right in its sole discretion to remove any submitted materials or other communications that it deems not to be in compliance with the foregoing.<br />
<br />

<strong>Links to Outside Sites</strong><br />


This Website assumes no responsibility for the materials provided on any site that is linked to this Website, regardless of whether or not it is an affiliated or third party site. Any entry to a linked site is made at your own risk.<br />
<br />

<strong>Internal Links</strong><br />

If you use this site, you are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer, and you agree to accept responsibility for all activities that occur under your account or password. Certain titles and content displayed by publishers on this website are available only to those of at least the age of 18. If you are under 18, you may use WEvolt.com only with involvement and/or approval of a parent or guardian. WEvolt reserves the right to refuse service, terminate accounts, remove or edit content, or cancel orders in their sole discretion.<br />
<br />


<strong>Disclaimer</strong><br />


THIS WEBSITE AND ALL MATERIALS AND OTHER INFORMATION PROVIDED HEREIN ARE PROVIDED "AS IS" AND WITHOUT WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IF APPLICABLE LAW DOES NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES, THEN THE ABOVE EXCLUSION MAY NOT APPLY.<br />
<br />


THIS WEBSITE DOES NOT ASSUME RESPONSIBILITY OR LIABILITY FOR ANY ERRORS OR OMISSIONS PERTAINING TO THE MATERIALS OR OTHER INFORMATION PROVIDED IN THIS WEBSITE AND EXPRESSLY DISCLAIMS ALL LIABILITY REGARDING ACTIONS TAKEN OR NOT TAKEN BY USERS BASED ON THE MATERIALS AND OTHER INFORMATION PROVIDED IN THIS WEBSITE. THIS WEBSITE DOES NOT ASSUME ANY RESPONSIBILITY FOR COMPUTER VIRUSES OR OTHER HARMFUL COMPONENTS RESULTING FROM THE USE OF THIS WEBSITE OR LINKS FROM THIS WEBSITE.<br />
<br />

<strong>Limitation of Liability</strong><br />


UNDER NO CIRCUMSTANCES SHALL THIS WEBSITE BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTIAL, SPECIAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES THAT MAY RESULT FROM THE USE OF OR INABILITY TO USE THIS WEBSITE OR MATERIALS THEREON, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. UNDER NO CIRCUMSTANCES SHALL OUR TOTAL LIABILITY TO YOU FOR ALL DAMAGES, LOSSES AND CAUSES OF ACTION, WHETHER IN CONTRACT, TORT OR OTHERWISE EXCEED THE SUM OF $100.00 FOR ACCESSING OR PARTICIPATING IN ANY ACTIVITY RELATED TO THIS WEBSITE.<br />
<br />

<strong>General Provisions</strong><br />
<br />


This Website's terms of use are governed by and construed in accordance with California law, without giving effect to any principles of conflicts of law. You expressly consent to submit to the exclusive jurisdiction of the state or federal courts located in the County of Los Angeles, California. The provisions of these terms of use are severable, and if any one or more provision may be determined to be judicially unenforceable, in whole or in part, the remaining provisions shall nevertheless be binding and enforceable.<br />
<br />

<strong>Changes to Terms of Use</strong><br />


We may change these terms of use from time to time. We will post any such changes on this Website. For that reason, we encourage you to periodically review these Terms of Use to keep yourself informed of any changes.<br />
<br />

                </td>
            
            </tr>
         </table>       
    <!--Content End -->
    </div>

	</td>
  </tr>
  <tr>
      <td style="background-image:url(http://www.wevolt.com/images/bottom_frame_no_blue.png); background-repeat:no-repeat;width:1058px;height:12px;">
      </td>
  </tr>
</table>
</div>
  
<?php require_once('includes/pagefooter_inc.php'); ?>


