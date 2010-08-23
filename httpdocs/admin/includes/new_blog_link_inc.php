
<form method='post' action='admin.php?a=blog'>

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
      NEW LINK</div>
<input type='submit' name='btnsubmit' value='CREATE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<div class='inputspacer'></div>
    </td>
    <td class='adminContent' valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%" valign="top" class="listcell">LINK TITLE: <br />
<input type="text" class='inputstyle'  name="txtTitle" value="<? echo $Title;?>"/>	<div class='spacer'></div>LINK DESCRIPTION:<textarea name='txtDescription' style="width:100%"><? echo $LinkDescription?></textarea></td>
	<td width="47%" valign="top" class="listcell">URL (including http://): <br />
<input type="text" class='inputstyle'  name="txtUrl" value="<? echo $Url;?>"/>	<div class='spacer'></div>PUBLISHED:<br />
<input type="radio" name="txtPublished" value="1"  <? if ($Published == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtPublished" value="0" <? if ($Published == 0) { echo 'checked';}?> />NO</td>
	   </tr>
   </table></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="sub" value="link" />
<input type="hidden" name="txtLink" value="<? echo $LinkID; ?>" />
</form>