<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td class="profileInfoHeader">IM Screennames:
                                    </td>
                                    <td class="profileInfobox"><textarea name="txtScreenNames" style="width:230px; height:61px;" onChange="show_save();"><? echo $ScreenNames;?></textarea>
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtScreenNamesPrivacy" value='private' <? if ($ScreenNamesPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtScreenNamesPrivacy" value='friends' <? if ($ScreenNamesPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtScreenNamesPrivacy" value='fans' <? if ($ScreenNamesPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtScreenNamesPrivacy" value='public' <? if ($ScreenNamesPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Mobile Phone:
                                    </td>
                                    <td class="profileInfobox"><input type="text" name="txtPhone" style="width:230px;" value="<? echo $Phone;?>" onChange="show_save();">
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtPhonePrivacy" value='private' <? if ($PhonePrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtPhonePrivacy" value='friends' <? if ($PhonePrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtPhonePrivacy" value='fans' <? if ($PhonePrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtPhonePrivacy" value='public' <? if ($PhonePrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Website:
                                    </td>
                                    <td class="profileInfobox"><input type="text" name="txtWebsite" style="width:230px;" value="<? echo $Website;?>" onChange="show_save();">
                                    		
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtWebsitePrivacy" value='private' <? if ($WebsitePrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtWebsitePrivacy" value='friends' <? if ($WebsitePrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtWebsitePrivacy" value='fans' <? if ($WebsitePrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtWebsitePrivacy" value='public' <? if ($WebsitePrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                 <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Twitter Username:
                                    </td>
                                    <td class="profileInfobox"><input type="text" name="txtTwitterName" style="width:230px;" value="<? echo $TwitterName;?>" onChange="show_save();">
                                    		
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtTwitterNamePrivacy" value='private' <? if ($TwitterNamePrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtTwitterNamePrivacy" value='friends' <? if ($TwitterNamePrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtTwitterNamePrivacy" value='fans' <? if ($TwitterNamePrivacy == 'fans') echo 'checked';?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtTwitterNamePrivacy" value='public' <? if ($TwitterNamePrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Facebook URL:
                                    </td>
                                    <td class="profileInfobox"><input type="text" name="txtFaceUrl" style="width:230px;" value="<? echo $FaceUrl;?>" onChange="show_save();">
                                    		
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtFaceUrlPrivacy" value='private' <? if ($FaceUrlPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtFaceUrlPrivacy" value='friends' <? if ($FaceUrlPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtFaceUrlPrivacy" value='fans' <? if ($FaceUrlPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtFaceUrlPrivacy" value='public' <? if ($FaceUrlPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                
                            </table>