<? $db = new DB();
$query = "select * from pf_blog_posts where id='$PostID' limit 1";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
	$CreationDate = $line->PublishDate;
}
?>

<div class="spacer"></div>
<form method='post' action='admin.php?a=blog'>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="283" valign="top" bgcolor="#000000" class="contentbox">POST TITLE: <br />
          <? echo "<div style='color:#a2b7b3;'>".$Title."</div>"; ?> </td>
      <td width="280" valign="top" bgcolor="#000000" class="contentbox" >PUBLISH DATE:
          <? echo "<div style='color:#a2b7b3;'>".$PublishDate."</div>"; ?> </td>
      <td width="10" valign="top" bgcolor="#000000" class="contentbox"></td>
      <td width="432" valign="top" bgcolor="#a2b7b3" style="color:#000000;"><div align="center">Are you sure you want to delete this post?<br />
<input type="hidden" name="txtPost" value="<? echo $PostID; ?>" />
          <input type='submit' name='btnsubmit' value='YES' /> &nbsp;<input type='submit' name='btnsubmit' value='NO' />
		  
      </div></td>
    </tr>
    <tr>
      <td width="283" valign="top" bgcolor="#000000" class="contentbox">&nbsp;</td>
      <td width="280" valign="top" bgcolor="#000000" class="contentbox" >&nbsp;</td>
      <td width="10" valign="top" bgcolor="#000000" class="contentbox">&nbsp;</td>
      <td width="432" valign="top" bgcolor="#a2b7b3">&nbsp;</td>
    </tr>
  
  </table>
</form>
<div class="spacer"></div>