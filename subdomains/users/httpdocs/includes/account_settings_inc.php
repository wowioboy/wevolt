<form method="post" action="/save_settings.php" style="margin:0px; padding:0px;"><div class="spacer"></div>
<input type="image"  style="border:none;background:none;" src="http://www.wevolt.com/images/wizard_save_btn.png" /><div class="spacer"></div>
<table><tr><td valign="top">
<table width="350" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="334" align="left">
                                        

<div class="messageinfo_warning"><strong>WEvolt Site Settings</strong></div><div class="spacer"></div>
<input type="hidden" name="editaccount" value="1" style="border:none;"/><strong>Notify me of WEvolt updates</strong><br /><input type="radio" value="1" name="notify" style="border:none; background-color:#e5e5e5;" <? if ($USettingsArray->NotifySystemUpdates == 1) echo 'checked';?>/>&nbsp;&nbsp;YES&nbsp;&nbsp;<input type="radio" value="0" name="notify" style="border:none;background-color:#ffffff;" <? if ($USettingsArray->NotifySystemUpdates == 0) echo 'checked';?>/>&nbsp;&nbsp;NO
<div class="medspacer"></div><strong>Show Tooltips</strong><br />

<input type="radio" value="1" name="tooltips" style="border:none;background-color:#e5e5e5;"<? if ($USettingsArray->ToolTips == 1) echo 'checked';?>/>&nbsp;&nbsp;YES&nbsp;&nbsp;<input type="radio" value="0" name="tooltips" style="border:none;background-color:#ffffff;"<? if ($USettingsArray->ToolTips == 0) echo 'checked';?>/>&nbsp;&nbsp;NO
<div class='spacer'></div>

<div class="messageinfo_warning"><strong>Subscriptions / Purchases</strong></div><div class="spacer"></div>

<? if ($purchaseString != '') { ?>
<strong>Your Subscriptions</strong>:<br />
<? echo $purchaseString;}?><div class='spacer'></div>


<div class="messageinfo_warning"><strong>Reader Options</strong></div><div class="spacer"></div>
<strong>Preferred Reader</strong><br />
<input type="radio" name="txtReaderStyle" value="flash"  <? if (($USettingsArray->ReaderStyle == 'flash')||($USettingsArray->ReaderStyle == '')) echo 'checked';?>>&nbsp;&nbsp;Flash Reader&nbsp;&nbsp;<input type="radio" name="txtReaderStyle" value="html" <? if ($USettingsArray->ReaderStyle == 'html') echo 'checked';?>>&nbsp;&nbsp;HTML (standard)<br>
<br>
<strong>Flash Reader Options</strong><br>
<input type="radio" name="txtFlashPages" value="2" <? if (($USettingsArray->FlashPages == '2')||($USettingsArray->FlashPages == '')) echo 'checked';?>>&nbsp;&nbsp;Show two pages at a time&nbsp;&nbsp;<input type="radio" name="txtFlashPages" value="1"  <? if ($USettingsArray->FlashPages == '1') echo 'checked';?>>&nbsp;&nbsp;One Page
<div class="spacer"></div>

<div class="messageinfo_warning"><strong>Login Options</strong></div><div class="spacer"></div>
<strong>Welcome Screen&nbsp;&nbsp;</strong><br />
<input type="radio" name="txtWelcome" value="1"  <? if (($USettingsArray->ShowWelcome == '')||($USettingsArray->ShowWelcome == '1')) echo 'checked';?>>&nbsp;&nbsp;Show Welcome Screen on login<br />
<input type="radio" name="txtWelcome" value="0" <? if ($USettingsArray->ShowWelcome == '0') echo 'checked';?>>&nbsp;&nbsp;Turn off Welcome (takes you to myvolt on login)<br>
<br />
<div class="messageinfo_warning"><strong>My Account</strong></div><div class="spacer"></div>
<strong>Change Password&nbsp;&nbsp;</strong><br />
<iframe src="http://www.wevolt.com/connectors/change_pass.php" style="width:300px;height:150px;" allowtransparency="true" frameborder="0" scrolling="no"></iframe>

</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        </td><td valign="top" width="10"></td><td valign="top">
     <table width="350" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="334" align="left">  
                            <div class="messageinfo_warning"><strong>Avatar</strong></div><div class="spacer"></div><em>Image will be resized to 100x100</em>
                             <iframe src="http://www.wevolt.com/connectors/change_avatar.php" allowtransparency="true" frameborder="0" scrolling="no" height="60px;"></iframe>
                             <div class="spacer"></div>                           
<div class="messageinfo_warning"><strong>Work For Hire Settings</strong></div><div class="spacer"></div>
<strong>Available for contract / Work For Hire</strong><br />

<input type="radio" name="txtWorkForHire" value="0"  <? if (($UDataArray->WorkForHire == '')||($USettingsArray->WorkForHire == '0')) echo 'checked';?>>&nbsp;&nbsp;No I am not available&nbsp;&nbsp;<br />
<input type="radio" name="txtWorkForHire" value="1" <? if ($UDataArray->WorkForHire == '1') echo 'checked';?>>&nbsp;&nbsp;Yes I am available to work<br>
<div class='spacer'></div>
<strong>Main Skill/Talent<br /></strong>
<select name="txtMainService">
<option value="">SELECT YOUR MAIN SERVICE</option>
<option value="all_artist" <? if ($UDataArray->MainService == 'all_artist') echo 'selected';?>>All in One Artist (Pencils/Inks/Colors)</option>
<option value="penciler" <? if ($UDataArray->MainService == 'penciler') echo 'selected';?>>Pencils</option>
<option value="inker" <? if ($UDataArray->MainService == 'inker') echo 'selected';?>>Inker</option>
<option value="colorist" <? if ($UDataArray->MainService == 'colorist') echo 'selected';?>>Colorist</option>
<option value="letterist" <? if ($UDataArray->MainService == 'letterist') echo 'selected';?>>Letterist</option>
<option value="storyboards" <? if ($UDataArray->MainService == 'storyboards') echo 'selected';?>>Storyboards</option>
<option value="digital_painter" <? if ($UDataArray->MainService == 'digital_painter') echo 'selected';?>>Digital Painter</option>
<option value="illustrations" <? if ($UDataArray->MainService == 'illustrations') echo 'selected';?>>Illustrations/Covers</option>
<option value="layouts" <? if ($UDataArray->MainService == 'layouts') echo 'selected';?>>Book Layouts</option>
<option value="writer" <? if ($UDataArray->MainService == 'writer') echo 'selected';?>>Writer</option>
<option value="editor" <? if ($UDataArray->MainService == 'editor') echo 'selected';?>>Editor (books/comics)</option>
<option value="promotions" <? if ($UDataArray->MainService == 'promotions') echo 'selected';?>>Promoter/Marketing</option>
<option value="musician" <? if ($UDataArray->MainService == 'musician') echo 'selected';?>>Musicician</option>
<option value="editor_video" <? if ($UDataArray->MainService == 'editor_video') echo 'selected';?>>Editor (video)</option>
<option value="3danimator" <? if ($UDataArray->MainService == '3danimator') echo 'selected';?>>3d Animator</option>
<option value="cell_animator" <? if ($UDataArray->MainService == 'cell_animator') echo 'selected';?>>Cell Animator</option>
<option value="flash_animator" <? if ($UDataArray->MainService == 'flash_animator') echo 'selected';?>>Flash Animator</option>
<option value="programmer" <? if ($UDataArray->MainService == 'programmer') echo 'selected';?>>Programmer</option>
<option value="designer" <? if ($UDataArray->MainService == 'designer') echo 'selected';?>>Designer</option>
</select>
<div class='spacer'></div>
<strong>Rates Description<br /></strong>Please give as much detail on your wage breakdown here. If you work on a page rate, please put all the types of rates for example (color, B/W, etc)<br />

<textarea name="txtRates" style="width:300px;height:50px;"><? echo nl2br($UDataArray->Rates);?></textarea>
<div class='spacer'></div>
<strong>Other Services</strong><br />Many of us are Jacks-of-all trades, so if you want to find work that is outside your main service, include that here. Be descriptive as possible. <br />
<textarea name="txtOtherServices" style="width:300px;height:50px;"><? echo nl2br($UDataArray->OtherServices);?></textarea><div class='spacer'></div>
<div class="messageinfo_warning"><strong>Work for WEvolt</strong></div><div class="spacer"></div>
If you would like to work for wevolt, please check the box below and we will review your information and let you know your approval status asap. If you do get picked to become a studio artist an agreement will need to be signed and all potential work will first have to go through the studio. If you have clients interested in using you, just have them contact us to schedule you.<br />
<br />

<input type="checkbox" name="txtIsStudio" value="1"  <? if ($UDataArray->IsStudio == 1) echo 'checked';?> />&nbsp;&nbsp;Yes I would like to submit my information to become a wevolt studio contractor.
<div class='spacer'></div>

</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        </td></tr></table></form>