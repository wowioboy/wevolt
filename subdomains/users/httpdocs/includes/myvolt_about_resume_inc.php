      
       <!--RESUME-->
					<? if (($Resume != '')|| ($IsOwner)) {?>
                    <table border='0' cellspacing='0' cellpadding='0' width='<? echo ($_SESSION['contentwidth']-130);?>'>
                        <tr>
                            <td width="9" id="updateBox_TL"></td>
                            <td width="<? echo( $_SESSION['contentwidth']-146);?>" id="updateBox_T"></td>
                            <td width="21" id="updateBox_TR"></td>
                       </tr>
                       <tr>
                			<td valign='top' class="updateboxcontent" colspan="3">
                            <div style="padding:5px;">
                                 <img src="http://www.wevolt.com/images/resume_header.png" />
                                 <table width="100%"><tr>
                                 <td>
                                 <? if ($IsOwner) {?><div class="spacer"></div>
                                 Upload your professional resume<div class="spacer"></div>
                                 <input type="file" name="txtResume" />
                                 <? }?>
                                 
                                 </td>
                                 <td width="269" align="left">
                                 <img src="http://www.wevolt.com/images/blue_download_box.png" />
                                 </td>
                                   <? if ($IsOwner) {
									   $iPrivacy = 'Resume';
									   ?>
                                   <td>
                                   <div class="spacer"></div>
                                   <img src="http://www.wevolt.com/images/privacy_title.png" /><br />

                                      <select name="txt<? echo $iPrivacy;?>Privacy" onChange="show_save();">
                                    <option  value='private' <? if ($iPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($iPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($iPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($iPrivacy == 'public')||($iPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    </td>
                                    <? }?>
                                 </tr>
                                 </table>
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
                    <div class="spacer"></div>
              <!--Work History-->      
                    <? if (($WorkHistory != '')|| ($IsOwner)) {?>
                        
                    <? 	  $iPrivacy = 'WorkHistory';?>
                              <table border='0' cellspacing='0' cellpadding='0' width='<? echo ($_SESSION['contentwidth']-130);?>'>
                        <tr>
                            <td width="9" id="updateBox_TL"></td>
                            <td width="<? echo( $_SESSION['contentwidth']-146);?>" id="updateBox_T"></td>
                            <td width="21" id="updateBox_TR"></td>
                       </tr>
                       <tr>
                			<td valign='top' class="updateboxcontent" colspan="3">
                                 <div style="padding:5px;">
                                <table>
                                <tr>
                                <td valign="top" style="padding-right:15px;">
                                <img src="http://www.wevolt.com/images/work_history.png" />
                                   <? if ($IsOwner) {?>
                                   <div class="spacer"></div>
                                   <img src="http://www.wevolt.com/images/privacy_title.png" /><br />
<div class="spacer"></div>
                                      <select name="txt<? echo $iPrivacy;?>Privacy" onChange="show_save();">
                                    <option  value='private' <? if ($iPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($iPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($iPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($iPrivacy == 'public')||($iPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    <? }?>
                                </td>
                                <td class="dark_blue_text">
                               <? if ($IsOwner) {?><textarea name="txtWorkHistory" style="width:<? echo( $_SESSION['contentwidth']-250);?>px; height:300px;" onChange="show_save();"><? echo $WorkHistory;?></textarea><? } else {echo nl2br($WorkHistory);}?>
                                </td>
                                    
                      </tr></table></div>
                      
    						</td>
                        </tr>
                        <tr>
                           <td id="updateBox_BL"></td>
                           <td id="updateBox_B"></td>
                           <td id="updateBox_BR"></td>
                        </tr>
                      </table>
                      <? }?>
                      
                        <div class="spacer"></div>
              <!--Work History-->      
                    <? if (($Education != '')|| ($IsOwner)) {?>
                        
                    <? 	  $iPrivacy = 'Education';?>
                              <table border='0' cellspacing='0' cellpadding='0' width='<? echo ($_SESSION['contentwidth']-130);?>'>
                        <tr>
                            <td width="9" id="updateBox_TL"></td>
                            <td width="<? echo( $_SESSION['contentwidth']-146);?>" id="updateBox_T"></td>
                            <td width="21" id="updateBox_TR"></td>
                       </tr>
                       <tr>
                			<td valign='top' class="updateboxcontent" colspan="3">
                                 <div style="padding:5px;">
                                <table>
                                <tr>
                                <td valign="top" style="padding-right:15px;">
                                <img src="http://www.wevolt.com/images/education_header.png" />
                                   <? if ($IsOwner) {?>
                                   <div class="spacer"></div>
                                   <img src="http://www.wevolt.com/images/privacy_title.png" /><br />
<div class="spacer"></div>
                                      <select name="txt<? echo $iPrivacy;?>Privacy" onChange="show_save();">
                                    <option  value='private' <? if ($iPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($iPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($iPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($iPrivacy == 'public')||($iPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    <? }?>
                                </td>
                                <td class="dark_blue_text">
                               <? if ($IsOwner) {?><textarea name="txtEducation" style="width:<? echo( $_SESSION['contentwidth']-250);?>px; height:100px;" onChange="show_save();"><? echo $Education;?></textarea><? } else {echo nl2br($WorkHistory);}?>
                                </td>
                                    
                      </tr></table></div>
                      
    						</td>
                        </tr>
                        <tr>
                           <td id="updateBox_BL"></td>
                           <td id="updateBox_B"></td>
                           <td id="updateBox_BR"></td>
                        </tr>
                      </table>
                      <? }?>
                      