<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td class="profileInfoHeader">College:
                                    </td>
                                    <td class="profileInfobox"><textarea name="txtEducation" style="width:230px; height:61px;" onChange="show_save();"><? echo $Education;?></textarea>
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtEducationPrivacy" value='private' <? if ($EducationPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtEducationPrivacy" value='friends' <? if ($EducationPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtEducationPrivacy" value='fans' <? if ($EducationPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtEducationPrivacy" value='public' <? if ($EducationPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Work History:
                                    </td>
                                    <td class="profileInfobox"><textarea name="txtWorkHistory" style="width:230px; height:61px;" onChange="show_save();"><? echo nl2br($WorkHistory);?></textarea>
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtWorkHistoryPrivacy" value='private' <? if ($WorkHistoryPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtWorkHistoryPrivacy" value='friends' <? if ($WorkHistoryPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtWorkHistoryPrivacy" value='fans' <? if ($WorkHistoryPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtWorkHistoryPrivacy" value='public' <? if ($WorkHistoryPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Creative / Professional Credits:
                                    </td>
                                    <td class="profileInfobox"><textarea name="txtCredits" style="width:230px; height:300px;" onChange="show_save();"><? echo $Credits;?></textarea>
                                    		
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtCreditsPrivacy" value='private' <? if ($CreditsPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtCreditsPrivacy" value='friends' <? if ($CreditsPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtCreditsPrivacy" value='fans' <? if ($CreditsPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtCreditsPrivacy" value='public' <? if ($CreditsPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                
                            </table>