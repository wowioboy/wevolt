<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	
                                <? if ($Education != '') {?>
                                <tr>
                                	<td class="profileInfoHeader">College:
                                    </td>
                                    <td class="profileInfobox"><? echo $Education;?>
                                    </td>
                                  
                                </tr>
                                <? }?>
                                 <? if ($WorkHistory != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Work History:
                                    </td>
                                    <td class="profileInfobox"><? echo nl2br($WorkHistory);?>
                                    </td>
                                   
                                </tr>
                                <? }?>
                                <? if ($Credits != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Creative / Professional Credits:
                                    </td>
                                    <td class="profileInfobox"><? echo $Credits;?>
                                </tr>
                                <? }?>
                                
                            </table>