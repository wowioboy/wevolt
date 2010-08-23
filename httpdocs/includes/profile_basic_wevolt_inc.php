<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            		<? if ($Sex != '') {?>
                                <tr>
                                	<td class="profileInfoHeader">Sex:
                                    </td>
                                    <td class="profileInfobox"><? if (($Sex == 'm') || ($Sex == 'M'))  echo 'Male'; else if (($Sex == 'f') || ($Sex == 'F'))  echo 'Female';?>
                                    </td>
                                   
                                </tr>
                                <? }?>
                                <? if ($BirthdayMonth != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Birthday:
                                    </td>
                                    <td class="profileInfobox"><table><tr><td><? echo $BirthdayMonth.'/'.$BirthdayDay.'/'.$BirthdayYear;?></td></tr></table>
                                    </td>
                                  
                                </tr>
                                  <? }?>
                                  <? if ($HometownLocation != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Hometown:
                                    </td>
                                    <td class="profileInfobox"><? echo $HometownLocation;?>
                                    		
                                    </td>
                                   
                                </tr>
                                 <? }?>
                                  <? if (trim($Location) != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Current Location:
                                    </td>
                                    <td class="profileInfobox"<? echo $Location;?>
                                    		
                                    </td>
                                   
                                </tr>
                                 <? }?>
                                  <? if ($ProfileBlurb != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                    <tr>
                                	<td class="profileInfoHeader">Profile Blurb:
                                    </td>
                                    <td class="profileInfobox"><? echo $ProfileBlurb;?>
                                    		
                                    </td>
                                   
                                </tr>
                                 <? }?>
                                 
                            </table>