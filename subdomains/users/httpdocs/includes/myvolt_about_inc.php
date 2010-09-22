<script type="text/javascript">
	function show_tab(value)
	{
			if (value == 'basic') {
				document.getElementById("basic_div").style.display = '';
				document.getElementById("credits_div").style.display = 'none';
				document.getElementById("personal_div").style.display = 'none';
				document.getElementById("contact_div").style.display = 'none';
			} else if (value == 'personal') {
				document.getElementById("basic_div").style.display = 'none';
				document.getElementById("credits_div").style.display = 'none';
				document.getElementById("personal_div").style.display = '';
				document.getElementById("contact_div").style.display = 'none';
			}  else if (value == 'credits') {
				document.getElementById("basic_div").style.display = 'none';
				document.getElementById("credits_div").style.display = '';
				document.getElementById("personal_div").style.display = 'none';
				document.getElementById("contact_div").style.display = 'none';
			}  else if (value == 'contact') {
				document.getElementById("basic_div").style.display = 'none';
				document.getElementById("credits_div").style.display = 'none';
				document.getElementById("personal_div").style.display = 'none';
				document.getElementById("contact_div").style.display = '';
			} 
	}
	function show_save() {
		document.getElementById('save_alert').style.display = '';
	
	}
	function save_info() {
		document.profileform.submit();
	
	}
</script> 

<div align="center">

<table width="100%">
<tr>
<td valign="top" width="100">

                <img src="http://www.wevolt.com/images/personal_profile.png" />
                <div class="spacer"></div>
    <div class="<? if (($_GET['s'] == '') || ($_GET['s'] == 'details')) {?>fade_select_on<? } else {?>fade_select_off<? }?>" onclick="window.location.href='/<? echo $FeedOfTitle;?>/?tab=profile&s=details';">Details</div>
    <div class="<? if ($_GET['s'] == 'interests') {?>fade_select_on<? } else {?>fade_select_off<? }?>" onclick="window.location.href='/<? echo $FeedOfTitle;?>/?tab=profile&s=interests';">Interests</div>
    <div class="<? if ($_GET['s'] == 'stats') {?>fade_select_on<? } else {?>fade_select_off<? }?>" onclick="window.location.href='/<? echo $FeedOfTitle;?>/?tab=profile&s=stats';">Site Stats</div>
    <div class="<? if ($_GET['s'] == 'resume') {?>fade_select_on<? } else {?>fade_select_off<? }?>" onclick="window.location.href='/<? echo $FeedOfTitle;?>/?tab=profile&s=resume';">Resume</div>
    <div class="<? if ($_GET['s'] == 'portfolio') {?>fade_select_on<? } else {?>fade_select_off<? }?>" onclick="window.location.href='/<? echo $FeedOfTitle;?>/?tab=profile&s=portfolio';">Portfolio</div>
            
		<? if ($_SESSION['username'] == $FeedOfTitle) {?>
        <div class="spacer"></div>  <div class="spacer"></div>
        <a href="javascript:void(0)" onclick="window.location='/myvolt/<? echo trim($_SESSION['username']);?>/?t=profile&a=fbsync';"><img src="http://www.wevolt.com/images/sync_facebook_2.png" border="0"/></a><div class="spacer"></div>  <div class="spacer"></div>
         <? if ($_GET['s'] == 'portfolio') {?>
         <img src="http://www.wevolt.com/images/cms/cms_grey_add_box.jpg" /><br />

         
         <? }?>
		<? }?><div class="spacer"></div><div class="spacer"></div>
        
       
        <img src="http://www.wevolt.com/images/weview_profile.png" />
                <div class="spacer"></div>
    <div class="<? if ($_GET['s'] == 'weview') {?>fade_select_on<? } else {?>fade_select_off<? }?>" onclick="window.location.href='/<? echo $FeedOfTitle;?>/?tab=profile&s=weview&c=comics';">Comics</div>
  
</td>

<td>
        <table border='0' cellspacing='0' cellpadding='0' width='<? echo ($_SESSION['contentwidth']-125);?>'>
      		<tr>
               <td valign="top" style="padding-left:10px;">
                
                <? if ($_GET['s'] == 'resume') {?>
                	
                  <? include 'myvolt_about_resume_inc.php';?>

                <? } else if ($_GET['s'] == 'portfolio') {?>
                	
                  <? include 'myvolt_about_portfolio_inc.php';?>

                <? } else {?>
                <table border='0' cellspacing='0' cellpadding='0' width='<? echo ($_SESSION['contentwidth']-135);?>'>
          			<tr>
                        <td width="9" id="updateBox_TL"></td>
                        <td width="<? echo( $_SESSION['contentwidth']-146);?>" id="updateBox_T"></td>
                        <td width="21" id="updateBox_TR"></td>
                    </tr>
                    <tr>
            			<td valign='top' class="updateboxcontent" colspan="3">
                               
                                    <div class="messageinfo">
                                       
                                        <div id='basic_div' style="<?  if (($_GET['s']!='')&&($_GET['s']!='details')) echo 'display:none;';?>">
                                            <? include 'myvolt_about_basic_inc.php';?>
                                         </div>
                                         <div id="interests_div" style="<?  if ($_GET['s']!='interests') echo 'display:none;';?>">
                                            <? include 'myvolt_about_interests_inc.php';?>
                                         </div>
                                    </div>
                                </td>
                      
                            </tr>
                            <tr>
                                <td id="updateBox_BL"></td>
                                <td id="updateBox_B"></td>
                                <td id="updateBox_BR"></td>
                            </tr>
                  </table>
 			 <? }?>
  
          </td>
          </tr>
       </table>
  <div class="spacer"></div>
   <?  if (($_GET['s']=='') || ($_GET['s']=='details')) {?>
   <table border='0' cellspacing='0' cellpadding='0' width='<? echo ($_SESSION['contentwidth']-120);?>'>
      		<tr>
            
               
                <td valign="top" style="padding-left:10px;">
                
                <table border='0' cellspacing='0' cellpadding='0' width='<? echo ($_SESSION['contentwidth']-135);?>'>
      			            <tr>
                        <td width="9" id="updateBox_TL"></td>
                        <td width="<? echo( $_SESSION['contentwidth']-146);?>" id="updateBox_T"></td>
                        <td width="21" id="updateBox_TR"></td>
                  </tr>
                    <tr>
                    
                        <td valign='top' class="updateboxcontent" colspan="3">
                                  
                                <div class="messageinfo" id="contact_div">
                                <?  include 'myvolt_about_contact_inc.php';?>
                            </div>
                       
                        </td>
              
                    </tr>
                    <tr>
                        <td id="updateBox_BL"></td>
                        <td id="updateBox_B"></td>
                        <td id="updateBox_BR"></td>
                    </tr>
 		 		</table>
                

  
 				 </td>
  
  </tr>
  </table>
  <? } //contact Wrapper If?>
</td>
 
</tr>
</table> 
</div>




