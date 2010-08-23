<?php 
include 'includes/init.php';
$PageTitle = 'wevolt | studio';
$TrackPage = 1;
include 'includes/header_template_new.php';
$Site->drawModuleCSS();
if ($_SESSION['IsPro'] == 1) 
    $_SESSION['noads'] = 1;

//SUPRISE CODE
//$_SESSION['suprise_code'] ='forget_40';
//$_SESSION['suprise_redirect'] =$_SESSION['refurl'];
//include 'includes/functions.php';

?>
<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <td valign="top" <? if ($_SESSION['IsPro'] == 1) {?>style="padding:5px; color:#FFFFFF;width:60px;"<? } else {?>width="<? echo $SideMenuWidth;?>"<? }?>><? include 'includes/site_menu_inc.php';?></td>
    
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
       <img src="http://www.wevolt.com/images/coming_soon_ask.png" />   
 <? /*<? $Site->drawStandardModuleTop('WEvolt Studio', 750, '', 12,'');?>
  	<br>
<div style="padding:10px;">
<div align="left">
Are you a writer looking for someone to bring your story to life? Are you a penciler or inker looking for a colorist that can do justice to your work? <div class="spacer"></div> If you're looking for any creative services, let WEvolt be your solution! <div class="spacer"></div>We offer all graphic and comic book services from full production to each individual element such as penciling, inking, coloring, lettering in all styles--you name it, we do it.
<div class="spacer"></div>
See below for a few sample pages done by our artists. <br />
<br />
</div>
<center>
<table><tr>
<td><a href="http://studio.wevolt.com/images/sample_photorealistic.jpg" class="pirobox_gall" title="Sample Photorealistic"><img src="http://studio.wevolt.com/images/sample_photorealistic_thumb.jpg" border="2" vspace="5" hspace="5" class="linkthumb" width="150" height="190"></a></td>
<td><a href="http://studio.wevolt.com/images/sureeal.jpg"  class="pirobox_gall" title="Sample Surreal"><img src="http://studio.wevolt.com/images/sureeal_thumb.jpg" border="2" vspace="5" hspace="5" class="linkthumb" width="150" height="190"></a></td>
<td><a href="http://studio.wevolt.com/images/pencils_tp.jpg"   class="pirobox_gall" title="Sample Pencils"><img src="http://studio.wevolt.com/images/pencils_thumb.jpg" border="2" vspace="5" hspace="5" class="linkthumb" width="150" height="190"></a></td>


<td><a href="http://studio.wevolt.com/images/ObritalDrop-Screenshot.jpg"  class="pirobox_gall" title="Sample Digital Painting"><img src="http://studio.wevolt.com/images/ObritalDrop-Screenshot_thumb.jpg" border="2" vspace="5" hspace="5" class="linkthumb" width="150" height="190"></a></td>
</tr><tr>
<td><a href="http://studio.wevolt.com/images/crash.jpg"  class="pirobox_gall" title="Cartoon Humor"><img src="http://studio.wevolt.com/images/crash_thumb.jpg" border="2" vspace="5" hspace="5" class="linkthumb" width="150" height="190"></a></td>
<td><a href="http://studio.wevolt.com/images/comic_book.jpg"  class="pirobox_gall" title="Sample Comic Book"><img src="http://studio.wevolt.com/images/comic_book_thumb.jpg" border="2" vspace="5" hspace="5" class="linkthumb" width="150" height="190"></a></td>
</tr>
</table>
</center>

</div>
       <? $Site->drawStandardModuleFooter(); */?>
   
</div>

      </div></td>
  </tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>
