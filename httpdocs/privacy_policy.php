<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php'); 
$PageTitle .= 'Privacy Policy';
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
            
 PRIVACY POLICY<br />



<strong>Personal Information We May Collect</strong>



<p>This Website may collect personally-identifiable information and non-personally identifiable information about you.</p><br />



Personally-identifiable information you provide to us may include the following: your name and home address, your home phone number, your email address, your financial information, such as credit card numbers, your household income, your education and work experience, and other details of your personal life, such as your hobbies.<p><br />



Non-personally identifiable information may include the type of browser you are using, your IP address, and your Internet service provider.<p><br />



This Website may also use cookies, which typically allow you to navigate between different web pages without losing the information you supplied at the start of any session. You may be able to accept or decline cookies depending on the capabilities and configuration of your browser. Most browsers automatically accept cookies and can be configured to decline cookies if you so desire. However, if you decline cookies, it may affect your ability to experience certain features of this Website. W3VOLT cannot and does not assume responsibility for any technical limitations or malfunction of your browser or for use of cookies by third parties that provide hosting or other services for this Website.<p><br />



This Website typically uses such non-personally identifiable information to accumulate aggregate data on the Website, for tracking purposes or to provide you with additional products or services.<br />
<br />

<strong>Use of Personal Information</strong>


<p>This Website may use your personal information to complete transactions you request or to send you communications about your account, your submissions, or about new features on this Website. We may also use your personal information to send you promotional materials, including special offers and promotions.<br />
<br />

<p><strong>Access to Personal Information</strong><br />


<p>We may share your personal information with our affiliates or other companies in our corporate family. We may provide your personal information to other companies whom we may utilize in processing our online transactions or other services. We may be required by law to disclose your personal information, such as in response to a court order or subpoena or at a law enforcement agency's request, and we reserve the right to do so. We may share your personal information as part of a purchase or sale pursuant to appropriate confidentiality provisions, such as if W3VOLT merges with another company or sells a business division.<br />
<br />

<p><strong>Opt-Out Choices</strong><br />


<p>You may always choose to opt out of receiving promotional materials. If you wish to opt out of receiving such correspondence, please follow the opt-out instructions included in the applicable correspondence.
Updating or Correcting Your Personal Information<br />
<br />


<p>If you wish to review, update or correct any of your personal information in this Website's possession, please contact us using the contact information provided below.<br />
<br />

<strong>Security Measures</strong>

<p>Not all information provided while using this Website is necessarily secure against electronic interception or tampering. While this Website does incorporate secure software and encryption to protect certain sensitive information you may provide, as with any Internet transmission, there is always some element of risk in sending personal information. For that reason, W3VOLT cannot guarantee that all personal or other sensitive information will remain confidential, and we must disclaim any liability for the inadvertent or unknowing disclosure or use of such information.<br />
<br />

<p><strong>Child Online Privacy</strong>

<p>This Website is not generally intended for anyone under the age of 18. We do not knowingly collect personal information from children under the age of 13. If you are 13 or under, please do not submit your personal information on this Website.<br />
<br />

<p><strong>Links to Other Sites</strong><br />


<p>This Website may contain links to other sites. We are not responsible for the privacy policies or practices, content, or any other aspect of these other sites, and you link to them at your own risk.<br />


<strong>Internal Links</strong><br />

If you use this site, you are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer, and you agree to accept responsibility for all activities that occur under your account or password. Certain titles and content displayed by publishers on this website are available only to those of at least the age of 18. If you are under 18, you may use WEvolt.com only with involvement and/or approval of a parent or guardian. WEvolt reserves the right to refuse service, terminate accounts, remove or edit content, or cancel orders in their sole discretion.<br />
<br />

<p><strong>Changes to this Privacy Policy</strong>


<p>We may change this Website's policies concerning the use of your personal information and other privacy policies from time to time. We will post any such changes on this Website. For that reason, we encourage you to periodically review this privacy policy to keep yourself informed of any changes.<br />
<br />

<strong>How to Contact Us</strong>


<p>We encourage you to share any comments or concerns you may have about this privacy policy or other aspects of this Website at the address given below. However, please note that by accessing this Website or submitting your personal information, you acknowledge and agree to be bound by this privacy statement, as amended or revised from time to time, in addition to all other terms of use posted at this Website.<br />
<br />


<p>For questions about this privacy policy or to contact us:<br />


WOWIO, Inc.<br />

3545 Motor Ave. 3rd Floor<br />

Los Angeles, CA 90034 <br />

info@wevolt.com<br />

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




