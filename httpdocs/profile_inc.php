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
 <table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td id="my_volt_frame_TL"><img src="http://www.w3volt.com/images/my_volt_frame_TL.png" /></td> 

	<td id="my_volt_frame_T" background="http://www.w3volt.com/images/my_volt_frame_T.png" style="background-repeat:repeat-x;"></td>
	<td id="my_volt_frame_TR"><img src="http://www.w3volt.com/images/my_volt_frame_TR.png" /></td>
    </tr>
    <tr>
    <td id="my_volt_frame_L" background="http://www.w3volt.com/images/my_volt_frame_L.png" style="background-repeat:repeat-y;"></td>
	<td class="voltframecontent" valign="top" align="center">
    <div><a href="#" onclick="show_tab('basic');"><img src="http://www.w3volt.com/images/profile_basic.png" id="profile_basic" onmouseover="roll_over(this, 'http://www.w3volt.com/images/profile_basic_over.png')" onmouseout="roll_over(this, 'http://www.w3volt.com/images/profile_basic.png')" class="navbuttons"/></a><a href="#" onclick="show_tab('personal');"><img src="http://www.w3volt.com/images/profile_personal.png" id="profile_personal" onmouseover="roll_over(this, 'http://www.w3volt.com/images/profile_personal_over.png')" onmouseout="roll_over(this, 'http://www.w3volt.com/images/profile_personal.png')" class="navbuttons"/></a><a href="#" onclick="show_tab('contact');"><img src="http://www.w3volt.com/images/profile_contact.png" id="profile_contact" onmouseover="roll_over(this, 'http://www.w3volt.com/images/profile_contact_over.png')" onmouseout="roll_over(this, 'http://www.w3volt.com/images/profile_contact.png')" class="navbuttons"/></a><a href="#" onclick="show_tab('credits');"><img src="http://www.w3volt.com/images/profile_credits.png" id="profile_credits" onmouseover="roll_over(this, 'http://www.w3volt.com/images/profile_credits_over.png')" onmouseout="roll_over(this, 'http://www.w3volt.com/images/profile_credits.png')" class="navbuttons"/></a>
</div>

<form method="post" action="/myvolt/<? echo trim($_SESSION['username']);?>/?t=profile">
	<div class="profileInfoHeader">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Private&nbsp;&nbsp;&nbsp;Friends&nbsp;&nbsp;&nbsp;Fans&nbsp;&nbsp;&nbsp;Public</div>
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
</form>

</td>
   <td id="my_volt_frame_R" background="http://www.w3volt.com/images/my_volt_frame_R.png" style="background-repeat:repeat-y;"></td>
 </tr>
<tr>
	<td id="my_volt_frame_BL"><img src="http://www.w3volt.com/images/my_volt_frame_BL.png" /></td> 

	<td id="my_volt_frame_B" background="http://www.w3volt.com/images/my_volt_frame_B.png" style="background-repeat:repeat-x;"></td>
	<td id="my_volt_frame_BR"><img src="http://www.w3volt.com/images/my_volt_frame_BR.png" /></td>
    </tr>
 
</table>

