<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<? if ($ScreenNames != '') {?>
                                <tr>
                                	<td class="profileInfoHeader">IM Screennames:
                                    </td>
                                    <td class="profileInfobox"><? echo $ScreenNames;?>
                                    </td>
                                   
                                </tr>
                                <? }?>
                                <? if ($Phone != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Mobile Phone:
                                    </td>
                                    <td class="profileInfobox"><? echo $Phone;?>
                                    </td>
                                </tr>
                                <? }?>
                                 <? if ($Website != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Website:
                                    </td>
                                    <td class="profileInfobox"><? echo $Website;?>
                                    		
                                    </td>
                                  
                                </tr>
                                <? } ?>
                                  <? if ($TwitterName != '') {?>
                                 <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Twitter Username:
                                    </td>
                                    <td class="profileInfobox"><? echo $TwitterName;?>
                                    		
                                    </td>
                                   
                                </tr>
                                <? }?>
                                 <? if ($FaceUrl != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Facebook URL:
                                    </td>
                                    <td class="profileInfobox"><? echo $FaceUrl;?>
                                    		
                                    </td>
                                   
                                </tr>
                                <? }?>
                                
                            </table>