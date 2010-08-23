<?php
$DB = new DB();
	$query = "SELECT u.username, u.avatar,u.encryptid
	         from pf_events_invitations as f 
			 join users as u on f.UserID=u.encryptid 
			 where CalID='".$_POST['txtCal']."'";
	$DB->query($query);
	$ShowInviteSelf = 1;
	$CurrenUninvites = @explode(',',$_REQUEST['currentuninvites']);
	while ($line = $DB->fetchNextObject()) {
		//	print 'SUPER FAN '.$line->IsLifetime.'<br/>';
		if (!in_array($line->username,$CurrenUninvites)) {
			if ($CurrentInvites == '')
				$CurrentInvites = $line->encryptid;
			else
				$CurrentInvites .= ','.$line->encryptid;
			
			if ($line->encryptid == $_POST['u'])
				$ShowInviteSelf = 0;
			
			$InviteList .= '<img src="'.$line->avatar.'" tooltip="'.$line->username.'" vspace="5" hspace="5" style="border:1px #000000 solid;" width="50" height="50" id="invite_'.$line->username.'" onclick="uninvite_user(\''.$line->username.'\',\'invite_'.$line->username.'\');" class="navbuttons">';
		}
	}
	
if ($CurrentInvites == '')
	$InviteList = 'You haven\'t handed out any invitations yet. <br/>';	

if ($_POST['currentinvites'] != '') {
	$Invited = explode(',',$_POST['currentinvites']); 	
	if ($Invited == null)
		$Invited= array();
		$ItemNum = 1;
	foreach ($Invited as $user) {
		$query = "SELECT u.username, u.avatar,u.encryptid from users as u where u.encryptid='$user'";
		$line = $DB->queryUniqueObject($query);	
		$InviteList .= '<a href="javascript:void(0);" onclick="remove_user(\''.$line->encryptid.'\',\'event\',\'userselected_'.$line->encryptid.'\');"><img src="'.$line->avatar.'" tooltip="'.$line->username.'" vspace="5" hspace="5" style="border:2px #ff0000 solid;" width="50" height="50" id="userselected_'.$line->encryptid.'"  class="navbuttons"></a>';
		$ItemNum++;
		
	}

}
$DB->close();
?>
<div class="spacer"></div>
             <div align="center">           
              
   <div>
   <div id="savealert" style="color:#ff0000;display:none; font-size:10px;">You must SAVE for your changes to take effect<div style="height:5px;"></div></div>
<table><tr><td valign="top"> 

                                        <table width="300" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="284" align="center">
                                       

  <div class="messageinfo_white">EVENT INVITATIONS</div> 
<div class="messageinfo_warning">Type an email or username below:</div>

<div class="messageinfo_warning"><input type="radio" name="show_list" value="1" <? if (($_REQUEST['show_list'] == 1) || ($_REQUEST['show_list'] == '')) echo 'checked';?> />Show Invite List&nbsp;&nbsp;<input type="radio" name="show_list" vlaue="0" <? if (($_REQUEST['show_list'] == '0') && ($_REQUEST['show_list'] != '')) echo 'checked';?> />Hide Invite List&nbsp;&nbsp;</div>
<? if ($ShowInviteSelf == 1) {?><div class="messageinfo_warning"><input type="checkbox" name="invite_self" value="1" <? if (($_REQUEST['invite_self'] == 1)|| ($_REQUEST['invite_self'] == '')) echo 'checked';?> />Invite Self&nbsp;&nbsp;</div><? }?>
<table cellpadding="0" cellspacing="0" border="0" width="98%">
<tr>
<td><input type="text" style="width:98%;" id="txtSearch" name="txtSearch" value="username or email" onFocus="doClear(this);" onBlur="setDefault(this);" onkeyup="checkIt(this.value);">
<div style="display:none;">
<div style="height:3px;"></div>
<select name="txtContent" id="txtContent" style="font-size:10px;">
<option  value="wevolt_users"> WEvolt users</option>
<option  value="email"> Search for email</option>
</select>
<div style="height:3px;"></div>
</div>

</td>
</tr>
</table>

<div id="search_container" style="display:none;"><div class="messageinfo_yellow"><strong>SEARCH RESULTS</strong></div><div style="height:3px;"></div>
<div id="search_results" style="height:220px; overflow:auto;width:98%;"></div></div>
</div>


  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>

                        
                                        
                                        </td>
                                        <td></td>
                                        <td valign="top">
                                     
                                          <table width="330" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="314" align="center">
                                        
                                        <div class="messageinfo_warning">Invite List</div>
                                        <div id="invites_div" style="height:280px; width:300px; overflow:auto;">
                                        
                                        <? echo $InviteList;?>
                                        </div>
                                       
                                        </td><td class="wizardboxcontent"></td>
                
                                        </tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
                                        <td id="wizardBox_BR"></td>
                                        </tr></tbody></table>
                                                        
                                        
                                        </td>
                                      </tr></table>

<input type="hidden" name="delete" value="0" />
<input type="hidden" name="save" value="1" />
<input type="hidden" name="invite" value="1" />


</div>



</div>
