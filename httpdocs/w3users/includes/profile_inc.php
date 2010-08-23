<script type="text/javascript">
	function showtab(value)
	{
			if (value == 'basic') {
				document.getElementById("basic_div").style.display = '';
				document.getElementById("credits_div").className ='none';
				document.getElementById("personal_div").style.display = 'none';
				document.getElementById("contact_div").className ='none';
			} else if (value == 'personal') {
				document.getElementById("basic_div").style.display = 'none';
				document.getElementById("credits_div").className ='none';
				document.getElementById("personal_div").style.display = '';
				document.getElementById("contact_div").className ='none';
			}  else if (value == 'credits') {
				document.getElementById("basic_div").style.display = 'none';
				document.getElementById("credits_div").className ='';
				document.getElementById("personal_div").style.display = 'none';
				document.getElementById("contact_div").className ='none';
			}  else if (value == 'contact') {
				document.getElementById("basic_div").style.display = 'none';
				document.getElementById("credits_div").className ='none';
				document.getElementById("personal_div").style.display = 'none';
				document.getElementById("contact_div").className ='';
			} 
	}
</script>
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
                        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td class="profileInfoHeader">Sex:
                                    </td>
                                    <td class="profileInfobox"><select name="txtSex" style="width:230px;">
                                    		<option value="M">Male</option>
                                        	<option value="F">Female</option>
                                        </select>
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtSexPrivacy" value='private' <? if ($BirthdayPrivacy == 'private') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtSexPrivacy" value='friends' <? if ($BirthdayPrivacy == 'friends') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtSexPrivacy" value='fans' <? if ($BirthdayPrivacy == 'fans') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtSexPrivacy" value='public' <? if ($BirthdayPrivacy == 'public') echo 'checked';?>>
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Birthday:
                                    </td>
                                    <td class="profileInfobox"><table><tr><td><SELECT NAME='txtBdayMonth' class='inputstyle'><?
          for ( $i=1; $i<13; $i++ ) {
            echo "<OPTION VALUE='".$i."'";
			if ($Month ==$i) {
				echo "selected";
			}
			echo ">".date("F", mktime(1,1,1,$i,1,1) )."</OPTION>";
          }
          ?></SELECT></td><td style="padding-left:5px;"><select name='txtBdayDay'  class='inputstyle'><?
            for ($i=1; $i<32; $i++) {
              echo "<OPTION VALUE='".$i."'";
			  if ($Day == $i) {
				echo "selected";
				}
			 echo ">".$i."</OPTION>";
            }
          ?></select></td><td style="padding-left:5px;"><select name='txtBdayYear'  class='inputstyle'><?
            for ($i=date("Y")+1; $i>=(date("Y")-20); $i--) {
			echo "<OPTION VALUE='".$i."'";
              if ($Year == $i) {
				echo "selected";
				}
			 	echo ">".$i."</OPTION>";
            }
          ?></select></td></tr></table>
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtBirthdayPrivacy" value='private' <? if ($BirthdayPrivacy == 'private') echo 'checked';?> >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtBirthdayPrivacy" value='friends' <? if ($BirthdayPrivacy == 'friends') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtBirthdayPrivacy" value='fans' <? if ($BirthdayPrivacy == 'fans') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtBirthdayPrivacy" value='public' <? if ($BirthdayPrivacy == 'public') echo 'checked';?>>
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Sex:
                                    </td>
                                    <td class="profileInfobox"><input type="text" name="txtHometown" style="width:230px;" value="<? echo $Hometown;?>">
                                    		
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownPrivacy" value='private' <? if ($BirthdayPrivacy == 'private') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownPrivacy" value='friends' <? if ($BirthdayPrivacy == 'friends') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownPrivacy" value='fans' <? if ($BirthdayPrivacy == 'fans') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownPrivacy" value='public' <? if ($BirthdayPrivacy == 'public') echo 'checked';?>>
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                    <tr>
                                	<td class="profileInfoHeader">Self Tags:
                                    </td>
                                    <td class="profileInfobox"><textarea name="txtSelfTags" style="width:230px; height:400px;"><? echo $txtSelfTags;?></textarea>
                                    		
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownPrivacy" value='private' <? if ($BirthdayPrivacy == 'private') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownPrivacy" value='friends' <? if ($BirthdayPrivacy == 'friends') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownPrivacy" value='fans' <? if ($BirthdayPrivacy == 'fans') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownPrivacy" value='public' <? if ($BirthdayPrivacy == 'public') echo 'checked';?>>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id='personal_div' style="display:none;">
                        
                        </div>
                        <div id='credits_div' style="display:none;">
                        
                        </div>
                        <div id='contact_div' style="display:none;">
                        
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

