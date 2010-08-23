<? 
$refString = '';
if ($_GET['p'] != '')
	$refString = '?p='.$_GET['p'];
if ($_GET['cat'] != ''){
	if ($refString =='')
		$refString = '?';
	else 
		$refString .= '&';
	$refString .='cat='.$_GET['cat'];	
}
if ($_GET['search'] != ''){
	if ($refString =='')
		$refString = '?';
	else 
		$refString .= '&';
	$refString .='search='.$_GET['search'];	
}?>
<table>
<tr>
<td>
<div align="left">viewing job: <b><? echo $JobArray->title;?></b></div><div class="spacer"></div>
<table width="<? echo ($_SESSION['contentwidth']-50);?>" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
				  <td id="blue_cmsBox_TL"></td>
				  <td id="blue_cmsBox_T"></td>
				  <td id="blue_cmsBox_TR"></td></tr>
				  <tr><td class="blue_cmsBox_L" background="http://www.wevolt.com/images/cms/blue_cms_box_L.png" width="8"></td>
				  <td class="blue_cmsboxcontent" valign="top" width="<? echo ($_SESSION['contentwidth']-66);?>" align="left">
                
                 <table width="100%" cellspacing="10"><tr>
                 <td valign="top" class="blue_cmsboxcontent" width="80%"><b>Description</b>: <? echo nl2br($JobArray->description);?>
                 <div class="spacer"></div>
                
                 <div class="spacer"></div>
                 <b>Deadline</b>: <? if ($JobArray->deadline == '0000-00-00 00:00:00') echo 'open deadline'; else echo $JobArray->deadline;?>
                 <div class="spacer"></div>
                 Available Positions
                 <div class="spacer"></div>
                 <? foreach ($PositionArray as $Position) {
					 
					 ?>
					 <table width="<? echo ($_SESSION['contentwidth']-200);?>" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
												<td id="grey_cmsBox_TL"></td>
												<td id="grey_cmsBox_T"></td>
												<td id="grey_cmsBox_TR"></td></tr>
												<tr><td class="grey_cmsBox_L" background="http://www.wevolt.com/images/cms/grey_cms_box_L.png" width="8"></td>
												<td class="grey_cmsboxcontent" valign="top" width="<? echo ($_SESSION['contentwidth']-266);?>" align="left">
 <table cellspacing="10" width="100%"><tr><td>
					   <b><? echo $Position['Title'];?></b></td>
                        <td>
                       Description: <? echo $Position['Description'];?>&nbsp;&nbsp;<? echo $Position['RateType'];?>
                       </td> 
                       <td>
                       Rate: <? echo $Position['Rate'];?>&nbsp;&nbsp;<? echo $Position['RateType'];?>
                       </td> 
                       <td id="position_apply_<? echo $Position['PositionID'];?>"><? if ($Position['AlreadyApplied'] == 0) {?><img src="http://www.wevolt.com/images/apply_job.png" border="0" onclick="apply_position('<? echo $Position['PositionID'];?>','position_apply_<? echo $Position['PositionID'];?>');" class="navbuttons"/><? } else {?>You have<br/>applied<? }?></td><td><img src="http://www.wevolt.com/images/suggest_job.png" border="0" onclick="suggest_position('<? echo $Position['PositionID'];?>');" class="navbuttons"/></td>
                       </tr>
                       </table>
                       
					                                        </td><td class="grey_cmsBox_R" background="http://www.wevolt.com/images/cms/grey_cms_box_R.png" width="8"></td>
		
								</tr><tr><td id="grey_cmsBox_BL"></td><td id="grey_cmsBox_B"></td>
								<td id="grey_cmsBox_BR"></td>
								</tr></tbody></table>
					<div class="spacer"></div> 
				 <? }?>
               
                 
                 
                 </td>
                 
                 <td valign="top"><a href="/jobs.php<? echo $refString ;?>">
                 <img src="http://www.wevolt.com/images/back_listing.png" border="0"/></a>
                 <div class="spacer"></div>
                <a href="javascript:void(0)" onClick="volt_wizard('<? echo $JobArray->encrypt_id;?>','user','job_post');return false;"> <img src="http://www.wevolt.com/images/volt_job.png" border="0" class="navbuttons"/></a>
                 <div class="spacer"></div>
                
                 <div class="spacer"></div>
                 <img src="http://www.wevolt.com/images/share_job.png" border="0"/>
                 <div class="spacer"></div>
				 
				 <? if ($JobArray->ProjectThumb != '') {?>For Project:<br/><a href="http://www.wevolt.com/<? echo $JobArray->SafeFolder;?>/"><img src="http://www.wevolt.com<? echo $JobArray->ProjectThumb;?>" border="2" style="border:2px #000000 solid;"></a><? }?>
                 
                 </td></tr></table>
                 
                  
                  </td><td class="blue_cmsBox_R" background="http://www.wevolt.com/images/cms/blue_cms_box_R.png" width="8"></td>
				   </tr><tr><td id="blue_cmsBox_BL"></td><td id="blue_cmsBox_B"></td>
				   <td id="blue_cmsBox_BR"></td>
				   </tr></tbody></table> 
</td> 
<td>

</td>
</tr>
</table>