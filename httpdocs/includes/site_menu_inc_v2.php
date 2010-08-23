<div  style="background-image:url(http://www.wevolt.com/images/sidebar_bg.png); background-repeat:repeat-y;width:315px;">
	<? $Site->drawHeaderSide();?>
     <div class="spacer"></div>
     <? if ($_SESSION['noads'] != 1) {?>
    <!--AD TAGS-->
    <iframe src="" allowtransparency="true" width="300" height="250" frameborder="0" scrolling="no" id="left_ads" name="left_ads"></iframe>
<? } ?>
    <div align="right" style="padding-right:20px;">
        <div class="spacer"></div>
        <div align="right" style="padding-right:90px;">
            <img src="http://www.wevolt.com/images/spotlight_side_header.png" />
        </div>
         <div class="spacer"></div>
         <? $Site->drawSpotLight('project','side');?>
         <div class="spacer"></div>
         <div class="spacer"></div>
         <div align="right" style="padding-right:90px;">
            <img src="http://www.wevolt.com/images/reccomends_header.png" />
         </div>
             <div class="spacer"></div>
             <? $Project->getReccomendations($Tags, $Genre, $CreatorSays, $SafeFolder);?>
         </div> 
    </div>
    <div class="spacer"></div>
    <div align="center">
   <span class="blue_links"><a href="http://www.wevolt.com/wevolt.php">ABOUT</a></span>&nbsp;&nbsp;<span class="blue_links"><a href="http://www.wevolt.com/contact.php">CONTACT</a></span>&nbsp;&nbsp;
     <div class="spacer"></div> <table><tr><td>&nbsp;&nbsp;&nbsp;<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.wevolt.com<? if ($IsProject) echo '%2F'.$SafeFolder.'%2F';?>&amp;layout=button_count&amp;show_faces=false&amp;width=50&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:85px; height:21px;" allowTransparency="true"></iframe>
                </td>
                <td><a href="http://www.facebook.com/#!/group.php?gid=131247090248002&ref=ts" target="_blank"><img src="http://www.wevolt.com/images/fb_icon.png" border="0"/></a>
                </td>
                <td><a href="http://www.twitter.com/wevoltonline" target="_blank"><img src="http://www.wevolt.com/images/twitter_icon.png" border="0"/></a></td>
               </tr></table>
               </div>
    <? echo $Site->drawLegal();?>
</div>
<!--
<div><img src="http://www.wevolt.com/images/sidebar_footer.png" /></div>-->