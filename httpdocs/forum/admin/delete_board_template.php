<? 

$query = "SELECT * from pf_forum_boards where EncryptID='".$_GET['id']."'";
$ContentArray = $DB->queryUniqueObject($query);

?>
<form method='post' action='#'>
<div class="spacer"></div>
<table width='100%' border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td width="100" valign="top"><div class="spacer"></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left; width:100%; background-color:#0099FF;"><div style="height:5px;"></div>
    <input type='button' value='CANCEL' onclick="window.location='index.php?<? echo $ForumType;?>=<? echo $TargetName;?>&a=admin&task=list_boards';" style="text-align:left; background-color:#FFCC00; width:100%;">
    </td>
    <td  valign="top"  style="padding:10px;">
      <div class="messageinfo">
    Are you sure you want to delete this board? <br/><br/>If you do then all the posts under this board will also be deleted. 
    </div>
    <div class="spacer"></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="">
  <tr>
    <td width="40%" valign="top" ><div class="sender_name"><strong>BOARD TITLE:</strong> </div>
<? echo $ContentArray->Title;?> 

</td>

 <td valign="top" style="padding-left:10px;"><div class="sender_name"><strong>BOARD DESCRIPTION:</strong></div>
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
<input type="hidden" name="txtCat" value="<? echo $ContentArray->CatID;?>" />
<input type="hidden" name="txtID" value="<? echo $_GET['id']; ?>" />
</form>