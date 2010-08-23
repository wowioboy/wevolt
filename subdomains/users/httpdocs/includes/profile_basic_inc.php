<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td class="profileInfoHeader">Sex:
                                    </td>
                                    <td class="profileInfobox"><select name="txtSex" style="width:230px;" onChange="show_save();">
                                    		<option value="M" <? if (($Sex == 'm') || ($Sex == 'M'))  echo 'selected';?>>Male</option>
                                        	<option value="F" <? if (($Sex == 'f') || ($Sex == 'F'))  echo 'selected';?>>Female</option>
                                        </select>
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtSexPrivacy" value='private' <? if ($SexPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtSexPrivacy" value='friends' <? if ($SexPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtSexPrivacy" value='fans' <? if ($SexPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtSexPrivacy" value='public' <? if ($SexPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Birthday:
                                    </td>
                                    <td class="profileInfobox"><table><tr><td><SELECT NAME='txtBdayMonth' class='inputstyle' onChange="show_save();"><?
          for ( $i=1; $i<13; $i++ ) {
            echo "<OPTION VALUE='".$i."'";
			if ($BirthdayMonth ==$i) {
				echo "selected";
			}
			echo ">".date("F", mktime(1,1,1,$i,1,1) )."</OPTION>";
          }
          ?></SELECT></td><td style="padding-left:5px;"><select name='txtBdayDay'  class='inputstyle' onChange="show_save();"><?
            for ($i=1; $i<32; $i++) {
              echo "<OPTION VALUE='".$i."'";
			  if ($BirthdayDay == $i) {
				echo "selected";
				}
			 echo ">".$i."</OPTION>";
            }
          ?></select></td><td style="padding-left:5px;"><select name='txtBdayYear'  class='inputstyle' onChange="show_save();"><?
		  	
            for ($i=date("Y")+1; $i>=(date("Y")-40); $i--) {
		
			echo "<OPTION VALUE='".$i."'";
              if ($BirthdayYear == $i) {
				echo "selected";
				}
			 	echo ">".$i."</OPTION>";
            }
          ?></select></td></tr></table>
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtBirthdayPrivacy" value='private' <? if ($BirthdayPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtBirthdayPrivacy" value='friends' <? if ($BirthdayPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtBirthdayPrivacy" value='fans' <? if ($BirthdayPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtBirthdayPrivacy" value='public' <? if ($BirthdayPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Hometown:
                                    </td>
                                    <td class="profileInfobox"><input type="text" name="txtHometown" style="width:230px;" value="<? echo $HometownLocation;?>" onChange="show_save();">
                                    		
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownLocationPrivacy" value='private' <? if ($HometownLocationPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownLocationPrivacy" value='friends' <? if ($HometownLocationPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownLocationPrivacy" value='fans' <? if ($HometownLocationPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtHometownLocationPrivacy" value='public' <? if ($HometownLocationPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Current Location:
                                    </td>
                                    <td class="profileInfobox"><input type="text" name="txtLocation" style="width:230px;" value="<? echo $Location;?>" onChange="show_save();">
                                    		
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtLocationPrivacy" value='private' <? if ($LocationPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtLocationPrivacy" value='friends' <? if ($LocationPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtLocationPrivacy" value='fans' <? if ($LocationPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtLocationPrivacy" value='public' <? if ($LocationPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                    <tr>
                                	<td class="profileInfoHeader">Profile Blurb:
                                    </td>
                                    <td class="profileInfobox"><textarea name="txtProfileBlurb" style="width:230px; height:61px;" onChange="show_save();"><? echo $ProfileBlurb;?></textarea>
                                    		
                                    </td>
                                    <td class="profilePrivacy">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtProfileBlurbPrivacy" value='private' <? if ($ProfileBlurbPrivacy == 'private') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtProfileBlurbPrivacy" value='friends' <? if ($ProfileBlurbPrivacy == 'friends') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtProfileBlurbPrivacy" value='fans' <? if ($ProfileBlurbPrivacy == 'fans') echo 'checked';?> onChange="show_save();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="txtProfileBlurbPrivacy" value='public' <? if ($ProfileBlurbPrivacy == 'public') echo 'checked';?> onChange="show_save();">
                                    </td>
                                </tr>
                                
                                <tr><td colspan="3" height="5" style="background-color:#FFFFFF;"></td></tr>
                                    <tr>
                                	<td class="profileInfoHeader">Self Tags:
                                    </td>
                                    <td class="profileInfobox"><textarea name="txtSelfTags" style="width:230px; height:300px;" onChange="show_save();"><? echo $SelfTags;?></textarea>
                                    		
                                    </td>
                                    <td class="profilePrivacy">
                                    </td>
                                </tr>
                            </table>