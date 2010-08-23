
<form method='post' action='admin.php?a=users'>
<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>
      NEW USER</div>
  
     <input type='submit' name='btnsubmit' value='CREATE' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
    
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="283" valign="top" class="contentbox" style="padding:5px;">REAL NAME<br />
<input type="text" class='inputstyle'  name="txtRealName" value="<? echo $RealName;?>"/></td>
	<td width="280" valign="top"class="contentbox"  style="padding:5px;">USERNAME<br />
<input type="text" class='inputstyle'  name="txtUserName" value="<? echo $UserName;?>"/>
	</td>
	<td width="274" valign="top" class="contentbox" style="padding:5px;">PASSWORD<br />
<input type="text" class='inputstyle'  name="txtPassword" /></td>
   </tr>
    <tr>
    <td width="283" valign="top" class="contentbox"></td>
	<td width="280" valign="top"  class="contentbox" >&nbsp;</td>
	<td width="274" valign="top"  class="contentbox">&nbsp;</td>

   </tr>
    <tr>
    <td width="283" valign="top"  class="contentbox" style="padding:5px;">
SELET THE USERTYPE<br />
<select name='txtUserType' class='inputstyle'>
<OPTION VALUE="1" <? if ($UserType == '1'){echo 'selected';}?>>CLIENT</OPTION>
<OPTION VALUE="2" <? if ($UserType == '2'){echo 'selected';}?>>USER</OPTION>
<OPTION VALUE="3" <? if ($UserType == '4'){echo 'selected';}?>>EDITOR</OPTION>
<OPTION VALUE="4" <? if ($UserType == '5'){echo 'selected';}?>>PUBLISHER</OPTION>
<OPTION VALUE="5" <? if ($UserType == '6'){echo 'selected';}?>>ADMINISTRATOR</OPTION>
</select></td>
    <td width="280" valign="top" class="contentbox"  style="padding:5px;">EMAIL <br />
<input type="text" class='inputstyle'  name="txtEmail" value="<? echo $UserEmail;?>"/></td>
	<td width="274" valign="top" class="contentbox" style="padding:5px;">CONFIRM PASSWORD<br />
<input type="text" class='inputstyle'  name="txtConfirmPassword" /></td>
   </tr>
</table>
    
    
  </td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="add" value="1" /> 

</form>