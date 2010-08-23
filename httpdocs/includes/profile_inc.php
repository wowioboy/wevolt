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
    
    <? if ($_GET['a'] != 'fbsync') {?>
    <table width="721"><tr><td align="left" width="100" height="20" style="background-image:url(http://www.wevolt.com/images/myvolt_base_left.png); background-repeat:no-repeat; font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;color:#15528e;">&nbsp;&nbsp;&nbsp;&nbsp;PROFILE<div style="height:1px;"></div></td><td style="background-image:url(http://www.wevolt.com/images/myvolt_base_bg.png); background-repeat:repeat-x;" width="500" align="right"><a href="#" onclick="show_tab('basic');"><img src="http://www.wevolt.com/images/basic_off.png" id="profile_basic" onmouseover="roll_over(this, 'http://www.wevolt.com/images/basic_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/basic_off.png')" class="navbuttons" hspace="4"/></a><a href="#" onclick="show_tab('personal');"><img src="http://www.wevolt.com/images/personal_off.png" id="profile_personal" onmouseover="roll_over(this, 'http://www.wevolt.com/images/personal_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/personal_off.png')" class="navbuttons"  hspace="4"/></a><a href="#" onclick="show_tab('contact');"><img src="http://www.wevolt.com/images/contacts_off.png" id="profile_contact" onmouseover="roll_over(this, 'http://www.wevolt.com/images/contacts_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/contacts_off.png')" class="navbuttons"  hspace="4"/></a><a href="#" onclick="show_tab('credits');"><img src="http://www.wevolt.com/images/credits_off.png" id="profile_credits" onmouseover="roll_over(this, 'http://www.wevolt.com/images/credits_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/credits_off.png')" class="navbuttons"  hspace="4"/></a></td><td style="background-image:url(http://www.wevolt.com/images/myvolt_base_right.png); background-repeat:no-repeat; background-position:right;" width="200" align="left"><div style="height:1px;"></div><a href="#" onclick="window.location='/myvolt/<? echo trim($_SESSION['username']);?>/?t=profile&a=fbsync';"><img src="http://www.wevolt.com/images/facebook_off.png" id="facebook_sync" onmouseover="roll_over(this, 'http://www.wevolt.com/images/facebook_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/facebook_off.png')" class="navbuttons"  hspace="4"/></a><a href="#" onclick="save_info();"><img src="http://www.wevolt.com/images/save_alert_off.png" id="save_alert" onmouseover="roll_over(this, 'http://www.wevolt.com/images/save_alert_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/save_alert_off.png')" class="navbuttons"  hspace="4" style="display:none;"/></a></td></tr></table>

</div>

<div class="spacer"></div>

<div align="center">
<? if ($MyVolt == 1) {?>
<form method="post" action="/myvolt/<? echo trim($_SESSION['username']);?>/?t=profile" id="profileform" name="profileform">


     <table border='0' cellspacing='0' cellpadding='0' width='641'><tr><td width="560"></td><td  class="messageinfo_white" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Private&nbsp;&nbsp;&nbsp;Friends&nbsp;&nbsp;&nbsp;Fans&nbsp;&nbsp;&nbsp;Public</td><td width="50"></td></tr></table>
    	<? }?>
        <table border='0' cellspacing='0' cellpadding='0' width='641'>
      <tr>
                <td width="9" id="updateBox_TL"></td>
                <td width="611" id="updateBox_T"></td>
                <td width="21" id="updateBox_TR"></td>
          </tr>
            <tr>
            
                <td valign='top' class="updateboxcontent" colspan="3">
                    <div class="messageinfo">
                       
                        <div id='basic_div'>
                        	<? include 'profile_basic_inc.php';?>
                        </div>
                        <div id='personal_div' style="display:none;">
                        <? include 'profile_personal_inc.php';?>
                        </div>
                        <div id='credits_div' style="display:none;">
                         <? include 'profile_credits_inc.php';?>
                        </div>
                        <div id='contact_div' style="display:none;">
                         <? include 'profile_contact_inc.php';?>
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
  <? if ($MyVolt == 1) {?>
  <input type="hidden" name="edit" value="1" />
</form>
<? }?>
<div class="spacer"></div>
</div>

<? } else {?>
<iframe src="http://www.wevolt.com/facebook/sync.php" frameborder="0" width="700" height="680" scrolling="no"></iframe>

<? }?>


