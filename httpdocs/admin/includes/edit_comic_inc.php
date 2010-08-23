<? 
if ($ItemID == "") {
	$ItemID = $_GET['id'];
}
$db = new DB();
$query = "SELECT * from comics where comiccrypt='$ItemID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->title;
	$Synopsis = $line->synopsis;
	$Short = $line->short;
	$Genres = $line->genre;
	$Tags = $line->tags;
	$Thumb = $line->thumb;
	$Cover = $line->cover;
	$Featured = $line->Featured;
	$GenresArray = explode(',',$line->genre);
	$GenreCount = sizeof($GenresArray);
}

$genreString = "";
$query = "select * from genres order by Title";
$GenreListArray = $db->queryUniqueObject($query);
$genreString = "<select style='width:175px;' name='txtGenres[]' size='3' multiple='yes'>";
$z=0;
	while ($z < $GenreCount) {
	//	print "MY FILES COUNT = " . $FilesCount."<br/>";
		$genreString .= "<OPTION VALUE='".$line->Title."'";
			$GenreTitle = $GenresArray[$z];
			//print "GENRE TITLE IN GENRE ARRAY = " . $GenreTitle."<br/>";
			//print "GENRE DB " .$line->Title."<br/>";
			if ($GenreTitle == $line->Title) {
				$genreString .= "selected";
				//print "YO MAN I SHOULD BE SELECTED HEY THERE OVER HERE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
			}
			$z++;
		}

$genreString .= ">".$line->Title."</OPTION>";

$genreString .= "</select>";


?>
<form method='post' action='admin.php?a=comics'>
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
      EDITCOMIC</div>
<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CHANGE THUMB' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
	<td width="137" height="73" valign="top" class="contentbox" style="padding:10px;"><div class="spacer"></div><br />
          <img src='<? echo $Thumb;?>' border=1 /></td>

	<td width="246" valign="top"  class="contentbox" style="padding:10px;"><div class="spacer"></div>
	COMIC TITLE:<br />
<input type='text' name='txtTitle' value="<? echo $Title; ?>" />

	<div class='spacer'></div>
	FEATURE THIS COMIC:<br />

    <input type="radio" name="txtFeatured" value='1' <? if ($Featured == 1) { echo 'checked';} ?>/>
YES 
<input type="radio" name="txtFeatured" value='0' <? if ($Featured == 0) { echo 'checked';} ?>/>NO<div class="spacer"></div>TAGS:<br />
<textarea name='txtTags' class='inputstyle' style="width:100%; height:100px;" /><? echo $Tags; ?></textarea></td>	<td width="322" valign="top" class="contentbox" style="padding:10px;">ITEM DESCRIPTION:<br />
<textarea name='txtSynopsis' class='inputstyle' style="width:100%; height:150px;" /><? echo $Synopsis; ?></textarea><div class="spacer"></div>SHORT DESCRIPTION:<br />
<textarea name='txtShort' class='inputstyle' style="width:100%; height:50px;" /><? echo $Short; ?></textarea>

	
</td>
   </tr>
    <tr>
    <td colspan="3"  valign="top" class="contentbox">COVER: <br />
<img src='<? echo $Cover; ?>' border='1'/> 
<div class="spacer"></div></td>
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
<input type='hidden' name='txtItem' value='<? echo $ItemID; ?>' />
</form>