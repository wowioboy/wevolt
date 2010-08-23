<? 

$query = "SELECT * from pf_forum_categories where EncryptID='".$_GET['id']."'";
$ContentArray = $DB->queryUniqueObject($query);

?>
<form method='post' action='#'>
<div class="spacer"></div>
<table width='100%' border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td width="100" valign="top"><div class="spacer"></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left; width:100%; background-color:#0099FF;"><div style="height:5px;"></div>
    <input type='button' value='CANCEL' onclick="window.location='index.php?<? echo $ForumType;?>=<? echo $TargetName;?>&a=admin&task=list_categories';" style="text-align:left; background-color:#FFCC00; width:100%;">
    </td>
    <td  valign="top"  style="padding:10px;">
      <div class="messageinfo">
  <b>  Are you sure you want to delete this category? </b>
    </div><div class="spacer"></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="">
  <tr>
    <td width="40%" valign="top" ><div class="sender_name">CATEGORY TITLE: <? echo $ContentArray->Title;?></div> 

</td>

 <td valign="top" style="padding-left:10px;"><div class="sender_name">CATEGORY DESCRIPTION:</div>
<? echo stripslashes($ContentArray->Description);?>
<div class="spacer"></div>

</td>
		   </tr>
   </table>
   
   </td>
  </tr>
</table>
<input type="hidden" name="txtAction" value="delete" />
<input type="hidden" name="submitted" value="1" />
<input type="hidden" name="txtCurrentPosition" value="<? echo $ContentArray->Position;?>" />
<input type="hidden" name="txtID" value="<? echo $_GET['id']; ?>" />
</form>