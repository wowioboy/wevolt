
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
      NEW CAT</div>
<input type='submit' name='btnsubmit' value='CREATE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<div class='inputspacer'></div>
    </td>
    <td class='adminContent' valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%" valign="top" class="listcell">CATEGORY TITLE: <br />
<input type="text" class='inputstyle'  name="txtTitle"/>	</td>
	<td valign="top" class="listcell">DEFAULT CATEGORY:<br />
<input type="radio" name="txtDefault" value="1"  <? if ($Default == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtDefault" value="0" <? if ($Default == 0) { echo 'checked';}?> />NO</td>
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
<input type="hidden" name="sub" value="cat" />
</form>