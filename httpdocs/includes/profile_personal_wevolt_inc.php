<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	  <? if ($About != '') {?>
                                <tr>
                                	<td class="profileInfoHeader">About / Bio:
                                    </td>
                                    <td class="profileInfobox"><? echo $About;?>
                                    </td>
                                   
                                </tr>
                                <? }?>
                                  <? if ($Hobbies != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Hobbies/Activites:
                                    </td>
                                    <td class="profileInfobox"><? echo $Hobbies;?>
                                    </td>
                                   
                                </tr>
                                 <? }?>
                                  <? if ($Influences != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Creative Influences
                                    </td>
                                    <td class="profileInfobox"><? echo $Influences;?>
                                    </td>
                                   
                                </tr>
                                 <? }?>
                                  <? if ($Interests != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Interests:
                                    </td>
                                    <td class="profileInfobox"><? echo $Interests;?>
                                    </td>
                                  
                                </tr>
                                 <? }?>
                                  <? if ($Music != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                <tr>
                                	<td class="profileInfoHeader">Favorite Music:
                                    </td>
                                    <td class="profileInfobox"><? echo $Music;?>
                                    		
                                    </td>
                                   
                                </tr>
                                 <? }?>
                                   <? if ($TVShows != '') {?>
                                <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                    <tr>
                                	<td class="profileInfoHeader">Favorite TV Shows:
                                    </td>
                                    <td class="profileInfobox"><? echo $TVShows;?>
                                    		
                                    </td>
                                  
                                </tr>
                                 <? }?>
                                  <? if ($Movies != '') {?>
                                 <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                    <tr>
                                	<td class="profileInfoHeader">Favorite Movies:
                                    </td>
                                    <td class="profileInfobox"><? echo $Movies;?>
                                    		
                                    </td>
                                  
                                </tr>
                                 <? }?>
                                  <? if ($Books != '') {?>
                                 <tr><td colspan="2" height="5" style="background-color:#FFFFFF;"></td></tr>
                                    <tr>
                                	<td class="profileInfoHeader">Favorite Books:
                                    </td>
                                    <td class="profileInfobox"><? echo $Books;?>
                                    		
                                    </td>
                                  
                                </tr>
                                 <? }?>
                            </table>