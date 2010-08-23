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

</script>
    <table><tr><td align="left" width="470">
    <? if ($BasiclInfo) {?><a href="#" onclick="show_tab('basic');"><img src="http://www.wevolt.com/images/profile_basic.png" id="profile_basic" onmouseover="roll_over(this, 'http://www.wevolt.com/images/profile_basic_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/profile_basic.png')" class="navbuttons"/></a><? }?><? if ($PersonalInfo) {?><a href="#" onclick="show_tab('personal');"><img src="http://www.wevolt.com/images/profile_personal.png" id="profile_personal" onmouseover="roll_over(this, 'http://www.wevolt.com/images/profile_personal_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/profile_personal.png')" class="navbuttons"/></a><? }?><? if ($ContactInfo) {?><a href="#" onclick="show_tab('contact');"><img src="http://www.wevolt.com/images/profile_contact.png" id="profile_contact" onmouseover="roll_over(this, 'http://www.wevolt.com/images/profile_contact_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/profile_contact.png')" class="navbuttons"/></a><? }?><? if ($CreditsInfo) {?><a href="#" onclick="show_tab('credits');"><img src="http://www.wevolt.com/images/profile_credits.png" id="profile_credits" onmouseover="roll_over(this, 'http://www.wevolt.com/images/profile_credits_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/profile_credits.png')" class="navbuttons"/></a><? }?></td></tr></table>

</div>

<div class="spacer"></div>
<div align="center">
        <table border='0' cellspacing='0' cellpadding='0' width='<? echo $_SESSION['contentwidth'];?>'>
      <tr>
                <td width="9" id="updateBox_TL"></td>
                <td width="<? echo( $_SESSION['contentwidth']-30);?>" id="updateBox_T"></td>
                <td width="21" id="updateBox_TR"></td>
          </tr>
            <tr>
            
                <td valign='top' class="updateboxcontent" colspan="3">
                    <div class="messageinfo">
                       
                        <div id='basic_div' <? if (!$BasiclInfo) {?> style="display:none;"<? }?>>
                        	<? if ($BasiclInfo) include 'profile_basic_wevolt_inc.php';?>
                        </div>
                        <div id='personal_div'  style="display:<? if ((!$BasiclInfo) && ($PersonalInfo)){?>block<? } else {?>none<? }?>;">
                        <?   if ($PersonalInfo) include 'profile_personal_wevolt_inc.php';?>
                                </div>
                        <div id='credits_div' style="display:<? if ((!$BasiclInfo) && (!$PersonalInfo) && ($CreditsInfo)){?>block<? } else {?>none<? }?>;">
                        <?   if ($CreditsInfo) include 'profile_credits_wevolt_inc.php';?>
                       
                        </div>
                        <div id='contact_div' style="display:<? if ((!$BasiclInfo) && (!$PersonalInfo) && (!$CreditsInfo) &&($ContactInfo)){?>block<? } else {?>none<? }?>;">
                        <?   if ($ContactInfo) include 'profile_contact_wevolt_inc.php';?>
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
</div>




