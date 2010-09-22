                                         <table border='0' cellspacing='0' cellpadding='0' width='280'>
                                            <tr>
                                        <td id="lightblueBox_TL"></td>
                                        <td width="264" id="lightblueBox_T"></td>
                                        <td id="lightblueBox_TR"></td>
                                          </tr>
                                            <tr>
                                            
                                                <td valign='top' class="lightblueBox_C" colspan="3" align="center">
                                                       
                                                       <div style="padding:2px">
                                                      <table width="100%">
                                                        <tr>
                                                            <? if ($ExciteArray->ExciteThumb != ''){?>
                                                            <td>
                                                            <a href="<? echo $ExciteArray->Link;?>" target="_blank"><img src="<? echo $ExciteArray->ExciteThumb;?>" border="1" style="border:1px #000 solid;" width="50" height="50" hspace="5"/></a>
                                                            </td>
                                                            <? }?>
                                                            <td class="grey_links"><a href="<? echo $ExciteArray->Link;?>" target="_blank"><? echo substr($ExciteArray->Comment,0,140);?></a>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                      </div>
                                               
                                                </td>
                                      
                                            </tr>
                                            <tr>
                                                <td id="lightblueBox_BL"></td>
                                                <td id="lightblueBox_B"></td>
                                                <td id="lightblueBox_BR"></td>
                                            </tr>
                                        </table>
