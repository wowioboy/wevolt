<?php 
if ($_GET['p'] == 'contact')
	header("Location:/contact.php");
include 'includes/init.php';
$PageTitle .= 'home';
$TrackPage = 1;
$HomePage = 1;
$Home = true;
include 'includes/header_template_new.php';
$Site->drawModuleCSS();
 if ($_SESSION['IsPro'] == 1) {
           $_SESSION['noads'] = 1;
		} 
?>

<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <td valign="top" <? if ($_SESSION['IsPro'] == 1) {?>width="60"<? } else {?>width="<? echo $SideMenuWidth;?>"<? }?>><? include 'includes/site_menu_inc.php';?></td>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
          <div class="spacer"></div>
          <table>
            <tr>
              <td background="images/wowio_tv_bg.jpg" width="426" height="351">
              <div style="height:15px;"></div>
              <center>
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="400" height="320" id="utv801134"><param name="flashvars" value="autoplay=false&amp;brand=embed&amp;cid=4806539&amp;locale=en_US"/><param name="allowfullscreen" value="true"/><param name="allowscriptaccess" value="always"/><param name="movie" value="http://www.ustream.tv/flash/live/1/4806539"/><embed flashvars="autoplay=false&amp;brand=embed&amp;cid=4806539&amp;locale=en_US" width="400" height="320" allowfullscreen="true" allowscriptaccess="always" id="utv801134" name="utv_n_452956" src="http://www.ustream.tv/flash/live/1/4806539" type="application/x-shockwave-flash" /></object>
			  </center>
              </td>
              <td valign="top" width="10"></td>
              <td  align="center" valign="top">
              <a href="http://www.ustream.tv/wowio" target="_blank"><img src="http://www.wevolt.com/images/wowio_tv_button.jpg" border="0"/></a><div class="spacer"></div>
              <iframe src="" allowtransparency="true" width="300" height="250" frameborder="0" scrolling="no" id="home_300" name="home_300"></iframe></td>
            </tr>
          </table>
          <div class="spacer"></div>
                 
          <table cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td valign="top">
              <? $Site->drawStandardModuleTop('<table><tbody>
                      <tr>
                        <td width="100"><img src="http://www.wevolt.com/images/matt_spotlight.png" />
                            <div class="smspacer"></div></td>
                        <td width="5"></td>
                        <td align="left"><a href="http://users.wevolt.com/matteblack/"><img src="http://www.wevolt.com/images/home_tab_btn.png"  border="0"/></a></td>
                        <td width="5"></td>
                          <td align="left"><a href="http://users.wevolt.com/matteblack/?t=projects"><img src="http://www.wevolt.com/images/projects_tab_btn.png"  border="0"/></a></td>
                        <td width="5"></td>
                          <td align="left"><a href="http://www.wevolt.com/mattjacobs/"><img src="http://www.wevolt.com/images/blog_tab_btn.png"  border="0"/></a></td>
            
                      </tr>
                    </tbody>
                    </table>
                          <div style="height:3px;"></div>', 477, '', 12,'');
						  
								$ModUser = 'matteblack';
								$ModProject = '766ebcd524b';
								include 'modules/excite_feed_mod.php';?>
                 <? $Site->drawStandardModuleFooter();?>
               
                  <div style="height:5px;"></div>
             <? $Site->drawStandardModuleTop('<table><tbody>
                      <tr>
                        <td width="100"><img src="http://www.wevolt.com/images/jasons_spot.png" /> 
                            <div class="smspacer"></div></td>
                        <td width="5"></td>
                        <td align="left"><a href="http://users.wevolt.com/jasonbadower/"><img src="http://www.wevolt.com/images/home_tab_btn.png"  border="0"/></a></td>
                        <td width="5"></td>
                          <td align="left"><a href="http://users.wevolt.com/jasonbadower/?t=projects"><img src="http://www.wevolt.com/images/projects_tab_btn.png"  border="0"/></a></td>
                        <td width="5"></td>
                          <td align="left"><a href="http://www.wevolt.com/jasonbadower/"><img src="http://www.wevolt.com/images/blog_tab_btn.png"  border="0"/></a></td>
            
                      </tr>
                    </tbody>
                    </table>
                            <div style="height:3px;"></div>', 477, '', 12,'');
							
								$ModUser = 'jasonbadower';
								$ModProject = '44c4c17325e';
								include 'modules/excite_feed_mod.php';
								$Site->drawStandardModuleFooter();?>
        
               </td>
                <td width="5"></td>
                <td valign="top">
                <script type="text/javascript">
				function show_news(value) {
			
					if (value == 'news') {
						document.getElementById('news_div').style.display='';
						document.getElementById('updates_div').style.display='none';
					} else if (value == 'updates') {
						document.getElementById('news_div').style.display='none';
						document.getElementById('updates_div').style.display='';
					}
				
				}
				
				</script>
                <? $Site->drawStandardModuleTop('<table><tbody>
                      <tr>
                        <td width="50"><img src="http://www.wevolt.com/images/news_header.png" />
                            <div class="smspacer"></div></td>
                        <td width="5"></td>
                        <td align="left" width="50"></td>
                        <td width="5"></td>
                          <td align="left"><img src="http://www.wevolt.com/images/news_tab_btn.png"  onclick="show_news(\'news\');" class="navbuttons" border="0"/></td>
                        <td width="5"></td>
                          <td align="left"><img src="http://www.wevolt.com/images/updates_tab_btn.png" onclick="show_news(\'updates\');" class="navbuttons" border="0"/></td>
            
                      </tr>
                    </tbody>
                    </table>
                            <div style="height:3px;"></div><div style="height:3px;"></div>', 250, '', 12,'');?>
                                <div style="overflow:auto; height:240px;">
                                <div id="news_div" style="display:none;">
								<? 
								$ModUser = 'w3volt';
								$ModCat = 'news';
								include 'modules/news_feed_mod.php';?>
                              </div>
                               <div id="updates_div" >
                               <? 
								$ModUser = 'w3volt';
								$ModCat = 'updates';
								include 'modules/news_feed_mod.php';?>
                              </div>
                              </div>
							  <? $Site->drawStandardModuleFooter();?>
              </td>
            </tr>
          </table>
          
            <? $Site->drawStandardModuleTop('<div align="left"><table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                      <tr>
                        <td width="100"><img src="http://www.wevolt.com/images/wevolt_top_10.png" />
                            <div class="smspacer"></div></td>
                        <td width="5"></td>
                        <td  id="Comics_tab"  onclick="box_list_tab(\'top_10-Comics\');" align="left" width="60"><img src="http://www.wevolt.com/images/comics_tab_btn.png" class="navbuttons"/></td>
                        <td width="5"></td>
                        <td id="Blogs_tab"  onclick="box_list_tab(\'top_10-Blogs\');" align="left" width="60"><img src="http://www.wevolt.com/images/blogs_tab_btn.png" class="navbuttons"/></td>
                        <td width="5"></td>
                        <td  id="Forums_tab"  onclick="box_list_tab(\'top_10-Forums\');" align="left" width="60"><img src="http://www.wevolt.com/images/forums_tab_btn.png" class="navbuttons"/></td> <td width="5"></td>
                        <td  id="Forums_tab"  onclick="box_list_tab(\'top_10-Writing\');" align="left" width="60"><img src="http://www.wevolt.com/images/writing_tab_btn.png" class="navbuttons"/></td>
						<td></td>
            
                      </tr>
                    </tbody>
                </table></div>', 750, '', 12,'');?>
                               
                        <div style="overflow:hidden; height:120px;">
                            <div id="Comics_div">
                              <? 
							$ModContent = 'comics';
							include 'modules/top_10_mod.php';?>
                            </div>
                          <div id="Blogs_div" style="display:none;">
                              <? 
							$ModContent = 'blogs';
							include 'modules/top_10_mod.php';?>
                            </div>
                          <div id="Forums_div" style="display:none;">
                              <? 
							$ModContent = 'forums';
							include 'modules/top_10_mod.php';?>
                            </div>
                          <div id="Writing_div" style="display:none;">
                              <? 
							$ModContent = 'writing';
							include 'modules/top_10_mod.php';?>
                            </div>
                        </div><? $Site->drawStandardModuleFooter();?>
          <input id="top_10_tabs" value="Comics,Forums,Blogs,Writing" type="hidden" />
        
      </div></td>
  </tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>

