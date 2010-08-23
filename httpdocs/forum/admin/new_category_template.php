<form method='post' action='#'>
<div class="spacer"></div>
<table width='100%' border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td width="100" valign="top"><div class="spacer"></div>
<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left; width:100%; background-color:#0099FF;"><div style="height:5px;"></div>
    <input type='button' value='CANCEL' onclick="window.location='index.php?<? echo $ForumType;?>=<? echo $TargetName;?>&a=admin&task=list_categories';" style="text-align:left; background-color:#FFCC00; width:100%;">
    </td>
    <td  valign="top"  style="padding:10px;">
  
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="">
  <tr>
    <td width="40%" valign="top" ><div class="sender_name">CATEGORY TITLE:</div> 
    <div class="messageinfo">
<input type="text"  style="width:100%;border:#cccccc 1px solid;" name="txtTitle" value="<? echo  stripslashes($ContentArray->Title);?>"/>	<div class="spacer"></div>

</td>

 <td valign="top" style="padding-left:10px;"><div class="sender_name">CATEGORY DESCRIPTION:</div>
<textarea name="txtDescription"  style="width:100%; border:#cccccc 1px solid; height:150px;"><? echo stripslashes($ContentArray->Description);?></textarea>
<div class="spacer"></div>
</td>
		   </tr>
   </table>
   
   </td>
  </tr>
</table>
<input type="hidden" name="txtAction" value="new" />
<input type="hidden" name="submitted" value="1" />
</form>