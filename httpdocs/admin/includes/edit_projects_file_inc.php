<? $catString = "";

$db = new DB();
$query = "select * from pf_projects_files where ID ='$FileID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
$Title = $line->Title;
$Description = $line->Description;
$Filename=$line->Filename;
}
?>


<form method='post' action='admin.php?a=projects'>

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

      EDIT FILE</div>

<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div><input type='submit' name='btnsubmit' value='CANCEL' id='submitstyle' style="text-align:left;">
    </td>

    <td class='adminContent' valign="top">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="51%" rowspan="2" valign="top" class="listcell" style="padding:5px;">FILE TITLE<br />

<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/>	<div class='spacer'></div>
<br />FILE DESCRIPTION<br />

<textarea name='txtDescription' style="width:100%" class="inputstyle"><? echo $Description;?></textarea><div class='spacer'></div>
<br /></td>

	<td width="49%" valign="top" class="listcell" style="padding:5px;"> <a href='projects/media/<? echo $Filename;?>' target='_blank' >DOWNLOAD FILE </a><div class='spacer'></div>
<div id='logoupload'>You need Flash and Javascript installed</div>
<script type="text/javascript"> 
    var so = new SWFObject('flash/change_project_file.swf','upload','300','100','9');
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
        so.addVariable('itemid','<? echo $FileID; ?>');
		so.addVariable('titlename','<? echo $Title; ?>');
		so.addVariable('changeitem','1');
        so.write('logoupload'); 
</script></td>
	   </tr>
  <tr>
    <td valign="top" class="listcell" style="padding:5px;"><br /></td>
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
<input type='hidden' name="txtFile" value="<? echo $FileID; ?>" />
<input type='hidden' name='sub' value="file" />
</form>