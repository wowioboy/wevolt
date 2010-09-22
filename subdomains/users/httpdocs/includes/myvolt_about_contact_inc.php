                         
         
<table cellpadding="0" cellspacing="0"><tr>
<td valign="top">
<table cellpadding="0" cellspacing="5" border="0">
                            	<tr>
                                <td align="left"  <? if ($IsOwner) {?>colspan="2"<? } ?> width="300"> <img src="http://www.wevolt.com/images/contact_details.png" vspace="5"/>
                                </td>
                                <? if ($IsOwner) {?>
                                <td width="80">&nbsp;&nbsp;<img src="http://www.wevolt.com/images/privacy_title.png" vspace="5"/>
                                </td>
                                <? }?>
                                </tr>
                              
							  <? if (($ScreenNames != '') || ($IsOwner)) {
							  $iPrivacy = 'ScreenNames';?>
                                <tr>
                                	<td class="profileInfoHeader" width="80">IM<br />
Accounts:
                                    </td>
                                    <td class="profileInfobox" width="180"><? if ($IsOwner) {?><textarea name="txtScreenNames" style="width:98%; height:30px;" onChange="show_save();"><? echo $ScreenNames;?></textarea><? } else {echo $ScreenNames;}?>
                                    </td>
                                      <? if ($IsOwner) {?>
                                   <td class="profilePrivacy" width="80">
                                      <select name="txt<? echo $iPrivacy;?>Privacy" onChange="show_save();">
                                    <option  value='private' <? if ($iPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($iPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($iPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($iPrivacy == 'public')||($iPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    
                                    </td>
                                    <? }?>
                                </tr>
                                <? }?>
                                    
     							 <? if (($Phone != '') || ($IsOwner)) {
                                  $iPrivacy = 'Phone';?>
                                <tr>
                                	<td class="profileInfoHeader" width="80">Phone:
                                    </td>
                                    <td class="profileInfobox" width="180"><? if ($IsOwner) {?><input type="text" name="txtPhone" style="width:100%;" value="<? echo $Phone;?>" onChange="show_save();"><? } else {echo $Phone;}?>
                                    </td>
                                      <? if ($IsOwner) {?>
                                   <td class="profilePrivacy" width="80">
                                      <select name="txt<? echo $iPrivacy;?>Privacy" onChange="show_save();">
                                    <option  value='private' <? if ($iPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($iPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($iPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($iPrivacy == 'public')||($iPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    
                                    </td>
                                    <? }?>
                                </tr>
                                <? }?>
                              
                               <? if (($Website != '') || ($IsOwner)) {
                                  $iPrivacy = 'Website';?>
                                <tr>
                                	<td class="profileInfoHeader" width="80">Website:
                                    </td>
                                    <td class="profileInfobox" width="180"><? if ($IsOwner) {?><input type="text" name="txtWebsite" style="width:100%;" value="<? echo $Website;?>" onChange="show_save();"><? } else {echo $Website;}?>
                                    </td>
                                      <? if ($IsOwner) {?>
                                   <td class="profilePrivacy" width="80">
                                      <select name="txt<? echo $iPrivacy;?>Privacy" onChange="show_save();">
                                    <option  value='private' <? if ($iPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($iPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($iPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($iPrivacy == 'public')||($iPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    
                                    </td>
                                    <? }?>
                                </tr>
                                <? }?>
                              
                                 <? if (($TwitterName != '') || ($IsOwner)) {
                                  $iPrivacy = 'Website';?>
                                <tr>
                                	<td class="profileInfoHeader" width="80">Twitter:
                                    </td>
                                    <td class="profileInfobox" width="180"><? if ($IsOwner) {?><input type="text" name="txtTwitterName" style="width:100%;" value="<? echo $TwitterName;?>" onChange="show_save();"><? } else {echo $TwitterName;}?>
                                    </td>
                                      <? if ($IsOwner) {?>
                                   <td class="profilePrivacy" width="80">
                                      <select name="txt<? echo $iPrivacy;?>Privacy" onChange="show_save();">
                                    <option  value='private' <? if ($iPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($iPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($iPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($iPrivacy == 'public')||($iPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    
                                    </td>
                                    <? }?>
                                </tr>
                                <? }?>
                               
                                <? if (($FaceUrl != '') || ($IsOwner)) {
                                  $iPrivacy = 'FaceUrl';?>
                                <tr>
                                	<td class="profileInfoHeader" width="80">Facebook:
                                    </td>
                                    <td class="profileInfobox" width="180"><? if ($IsOwner) {?><input type="text" name="txtFaceUrl" style="width:100%;" value="<? echo $FaceUrl;?>" onChange="show_save();"><? } else {echo $FaceUrl;}?>
                                    </td>
                                      <? if ($IsOwner) {?>
                                   <td class="profilePrivacy" width="80">
                                      <select name="txt<? echo $iPrivacy;?>Privacy" onChange="show_save();">
                                    <option  value='private' <? if ($iPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($iPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($iPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($iPrivacy == 'public')||($iPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    
                                    </td>
                                    <? }?>
                                </tr>
                                <? }?>
                              
                               
                            </table>
</td>
<td  style="padding-left:5px;padding-right:5px;">
<table border='0' cellspacing='0' cellpadding='0' width='<? echo $_SESSION['contentwidth']-570;?>'>
          <tr>
                <td id="whiteBox_TL"></td>
                <td id="whiteBox_T" width="<? echo $_SESSION['contentwidth']-586;?>"></td>
                <td id="whiteBox_TR"></td>
          </tr>
            <tr>
            
                <td class="whiteBox_C" colspan="3">
               
                    <div class="light_blue_text_sm" align="left" style="padding:5px; height:150px;">
                       
                             All of these will default to private, but it could be useful to have some of these visable to certain groups of people.<div class="spacer"></div>


For example, it might be useful to let your friends know what your cell phone number is, and if you're looking for work, making your website public would help you out a lot.<br />

                    
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
