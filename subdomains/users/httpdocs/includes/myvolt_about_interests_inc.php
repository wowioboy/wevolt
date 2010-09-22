
<table cellpadding="0" cellspacing="0"><tr>
<td valign="top">

<table cellpadding="0" cellspacing="5" border="0">
                            	<tr>
                                <td align="left"  <? if ($IsOwner) {?>colspan="2"<? } ?> width="300"> <img src="http://www.wevolt.com/images/interests_header.png" vspace="5"/>
                                </td>
                                <? if ($IsOwner) {?>
                                <td width="80">&nbsp;&nbsp;<img src="http://www.wevolt.com/images/privacy_title.png" vspace="5"/>
                                </td>
                                <? }?>
                                </tr>
                              
							  <? if ($About != '') {
							  $iPrivacy = 'About';?>
                                <tr>
                                	<td class="profileInfoHeader" width="80">About &<br />
Bio:
                                    </td>
                                    <td class="profileInfobox" width="220"><? if ($IsOwner) {?><textarea name="txtAbout" style="width:230px; height:61px;" onChange="show_save();"><? echo $About;?></textarea><? } else {echo $About;}?>
                                    </td>
                                      <? if ($IsOwner) {?>
                                   <td class="profilePrivacy">
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
                                
                                  <? if ($Hobbies != '') {
									  $iPrivacy = 'Hobbies';?>
                                <tr>
                                	<td class="profileInfoHeader" width="80">Hobbies&<br />
Activites:
                                    </td>
                                    <td class="profileInfobox" width="180">
                                    <? if ($IsOwner) {?><textarea name="txtHobbies" style="width:230px; height:61px;" onChange="show_save();"><? echo $Hobbies;?></textarea><? } else {echo $Hobbies;}?>                                   </td>
                                      <? if ($IsOwner) {?>
                                   <td class="profilePrivacy">
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
                                 
								 <? if ($Influences != '') {
									  $iPrivacy = 'Influences';?>
                                <tr>
                                	<td class="profileInfoHeader">Creative<br />
Influences
                                    </td>
                                    <td class="profileInfobox">
                                     <? if ($IsOwner) {?><textarea name="txtInfluences" style="width:230px; height:61px;" onChange="show_save();"><? echo $Influences;?></textarea><? } else {echo $Influences;}?>  		
                                    </td>
                                <? if ($IsOwner) {?><td class="profilePrivacy">
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
                                 
                                 <? if ($Interests != '') {
									  $iPrivacy = 'Interests';?> 
                                <tr>
                                	<td class="profileInfoHeader">Interests:
                                    </td>
                                    <td class="profileInfobox">
                                     <? if ($IsOwner) {?><textarea name="txtInterests" style="width:230px; height:61px;" onChange="show_save();"><? echo $Interests;?></textarea><? } else {echo $Interests;}?>  		
                              
                                    		
                                    </td>
                                      <? if ($IsOwner) {?>
                                   <td class="profilePrivacy">
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
                                <? if ($Music != '') {
									  $iPrivacy = 'Music';?>
                                <tr>
                                	<td class="profileInfoHeader">Favorite Music:
                                    </td>
                                    <td class="profileInfobox">
                                     <? if ($IsOwner) {?><textarea name="txtMusic" style="width:230px; height:61px;" onChange="show_save();"><? echo $Music;?></textarea><? } else {echo $Music;}?>                       		
                                    </td>
                                      <? if ($IsOwner) {?>
                                   <td class="profilePrivacy">
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
                              
                                <? if ($TVShows != '') {
									  $iPrivacy = 'TVShows';?>
                                 <tr>
                                	<td class="profileInfoHeader">Favorite TV <br />
Shows:
                                    </td>
                                    <td class="profileInfobox">
                                     <? if ($IsOwner) {?><textarea name="txtTVShows" style="width:230px; height:61px;" onChange="show_save();"><? echo $TVShows;?></textarea><? } else {echo $TVShows;}?>                                    		
                                    </td>
                                      <? if ($IsOwner) {?>
                                    <td class="profilePrivacy">
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
                                
                                 <? if ($Movies != '') {
									  $iPrivacy = 'Movies';?>
                                 <tr>
                                	<td class="profileInfoHeader">Favorite Movies:
                                    </td>
                                    <td class="profileInfobox"><? if ($IsOwner) {?><textarea name="txtMovies" style="width:230px; height:61px;" onChange="show_save();"><? echo $Movies;?></textarea><? } else {echo $Movies;}?>
                                    </td>
                                      <? if ($IsOwner) {?>
                                    <td class="profilePrivacy">
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
                                 
                                 <? if ($Books != '') {
									  $iPrivacy = 'Books';?>
                                 <tr>
                                	<td class="profileInfoHeader">Favorite Books:
                                    </td>
                                    <td class="profileInfobox">
                                    <? if ($IsOwner) {?><textarea name="txtBooks" style="width:230px; height:61px;" onChange="show_save();"><? echo $Books;?></textarea><? } else {echo $Books;}?></td>
                                      <? if ($IsOwner) {?>
                                    <td class="profilePrivacy">
                                      <select name="txt<? echo $iPrivacy;?>Privacy" onChange="show_save();">
                                    <option  value='private' <? if ($iPrivacy == 'private') echo 'selected';?>>Private</option>
                                    <option  value='fans' <? if ($iPrivacy == 'fans') echo 'selected';?>>Fans</option>
                                    <option  value='friends' <? if ($iPrivacy == 'friends') echo 'selected';?>>Friends</option>
                                    <option  value='public' <? if (($iPrivacy == 'public')||($iPrivacy == '')) echo 'selected';?>>Public</option>
                                    </select>
                                    
                                    </td>
                                    <? } ?>
                                </tr> 
                                 <? } ?>
                            </table>
</td>
<? if ($IsOwner) {?>
<td  style="padding-left:5px;padding-right:5px;" valign="top">
<table border='0' cellspacing='0' cellpadding='0' width='<? echo $_SESSION['contentwidth']-570;?>'>
          <tr>
                <td id="whiteBox_TL"></td>
                <td id="whiteBox_T" width="<? echo $_SESSION['contentwidth']-586;?>"></td>
                <td id="whiteBox_TR"></td>
          </tr>
            <tr>
            
                <td valign="top" class="whiteBox_C" colspan="3">
               
                    <div class="light_blue_text_sm" align="left" style="padding:5px; height:150px;">
                       
                            This is everything you want other people to know about you.<div class="spacer"></div>

Determine who knows what by their relationship to you.<div class="spacer"></div>

Your favorites here are imported from Facebook and are separate from what you set up on the WEview system.<div class="spacer"></div>


                    
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
<? }?>
</tr>
</table>
