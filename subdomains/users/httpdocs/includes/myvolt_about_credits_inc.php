                

<table cellpadding="0" cellspacing="0"><tr>
<td>

<table cellpadding="0" cellspacing="5" border="0">
                            	<tr>
                                <td align="left" colspan="2" width="260"> <img src="http://www.wevolt.com/images/credits_details.png" vspace="5"/>
                                </td>
                                <td width="80">&nbsp;&nbsp;<img src="http://www.wevolt.com/images/privacy_title.png" vspace="5"/>
                                </td>
                                </tr>
                                <tr>
                                	<td class="profileInfoHeader" width="80">Edutcation:
                                    </td>
                                    <td class="profileInfobox" width="180"><textarea name="txtEducation" style="width:100%; height:61px;" onChange="show_save();"><? echo $Education;?></textarea>
                                    </td>
                                    <td class="profilePrivacy" width="80">
                                    <select name="txtEducationPrivacy" onChange="show_save();">
                                    <option  value='private' <? if ($EducationPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($EducationPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($EducationPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($EducationPrivacy == 'public')||($EducationPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                	<td class="profileInfoHeader">Work History:
                                    </td>
                                    <td class="profileInfobox"><textarea name="txtWorkHistory" style="width:100%; height:61px;" onChange="show_save();"><? echo nl2br($WorkHistory);?></textarea>
                                    </td>
                                    <td class="profilePrivacy">
                                     <select name="txtWorkHistory" onChange="show_save();">
                                    <option  value='private' <? if ($WorkHistoryPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($WorkHistoryPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($BirthdayPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($WorkHistoryPrivacy == 'public')||($WorkHistoryPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    
                                    </td>
                                </tr>

                                <tr>
                                	<td class="profileInfoHeader">Creative / Professional Credits:
                                    </td>
                                    <td class="profileInfobox"><textarea name="txtCredits" style="width:100%; height:300px;" onChange="show_save();"><? echo $Credits;?></textarea>
                                    		
                                    </td>
                                    <td class="profilePrivacy">
                                      <select name="txtCreditsPrivacy" onChange="show_save();">
                                    <option  value='private' <? if ($CreditsPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($CreditsPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($CreditsPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($CreditsPrivacy == 'public')||($CreditsPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    
                                    </td>
                                </tr>  
                            </table>
</td>
<td valign="top" style="padding-left:5px;padding-right:5px;">
<table border='0' cellspacing='0' cellpadding='0' width='<? echo $_SESSION['contentwidth']-530;?>'>
          <tr>
                <td id="whiteBox_TL"></td>
                <td id="whiteBox_T" width="<? echo $_SESSION['contentwidth']-546;?>"></td>
                <td id="whiteBox_TR"></td>
          </tr>
            <tr>
            
                <td class="whiteBox_C" colspan="3">
               
                    <div class="light_blue_text_sm" align="left" style="padding:5px; height:150px;">
                       
                              When people click on your ABOUT page, their relationship to you determines what they see.<div class="spacer"></div>


PRIVATE: Only you see this.<div class="spacer"></div>


FRIENDS: Only your friends can see this.<div class="spacer"></div>


FANS: Friends and fans can see this. <div class="spacer"></div>


PUBLIC: Anyone can see this.                
                       
                    
                    </div>
                </td>
      
            </tr>
            <tr>
                <td id="whiteBox_BL"></td>
                <td id="whiteBox_B"></td>
                <td id="whiteBox_BR"></td>
            </tr>
  </table>
</td>
</tr>
</table>