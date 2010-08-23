<?php 

include_once('init.php');
$FeedDB = new DB();
$UserID = $_SESSION['userid'];
$ContentType=$_POST['ContentType'];
$RefTitle= $_POST['RefTitle'];
$ContentType=$_POST['ContentType'];
$Link=$_POST['Link'];
$ContentID=$_POST['ContentID'];

$query = "SELECT * from feed_modules where EncryptID='$ModuleID'";
$ContentWindowArray = $DB->queryUniqueObject($query);

if ($ContentID != '') {
if ($ContentType =='user') {
		$query ="SELECT * from users where username='$ContentID";
		$ContentArray = $FeedDB->queryUniqueObject($query);
		$Description = $ContentArray->about;
		$Thumb = $ContentArray->avatar;
		$Tags = $ContentArray->tags;
	
} else if ($ContentType =='project') {
		$query ="SELECT * from projects where ProjectID='$ContentID'"; 
		$ContentArray = $FeedDB->queryUniqueObject($query);
		$Description = $ContentArray->synopsis;
		$Thumb = 'http://www.panelflow.com'.$ContentArray->thumb;
		$Tags = $ContentArray->tags;
		
}else {
	
		switch($ContentType) {
		
				case 'blog_post':
				echo 'Blog Post';
				break;
				
				case 'forum_post':
				echo 'Blog Post';
				break;
				
				case 'forum_topic':
				echo 'Blog Post';
				break;
				
				case 'forum_board':
				echo 'Blog Post';
				break;
				
				case 'character':
				echo 'Blog Post';
				break;
				
				case 'download':
				echo 'Blog Post';
				break;
				
				case 'mobile':
				echo 'Blog Post';
				break;
				
				case 'page':
				echo 'Blog Post';
				break;

		}

}
}



$query = "SELECT * from pf_media where UploadBy='$UserID' and FileType='image'";
$FeedDB->query($query);
$TotalImages = $FeedDB->numRows();
$ImageCount = 0;
$ImageMediaString = '<table cellpadding="0" cellspacing="0" border="0"><tr>';
while ($line = $FeedDB->FetchNextObject()) {
$ImageCount++;
	$ImageMediaString .= '<td align="center" width="60"><img src="http://www.panelflow.com/'.$line->Thumb.'" id="thumb_'.$line->ID.'" border="1" style="border:#fffff solid 1px;" vspace="2" hspace="2"><br/>[<a href="#" onclick="select_image(\''.$line->Height.'\',\''.$line->Width.'\',\''.$line->Filename.'\');return false;">SELECT</a>]<br/>[<a href="/'.$line->Filename.'" rel="lightbox">VIEW</a>]<div style="height:5px;"></div></td>';
	if ($ImageCount == 5) {
		$ImageMediaString .= '</tr><tr>';
		$ImageCount = 0;
	}
	
}
if (($ImageCount < 5) && ($ImageCount != 0)) {
	while ($ImageCount < 5) {
		$ImageMediaString .= '<td></td>';
		$ImageCount++;
	}
}
$ImageMediaString .= '</tr></table>';

$query =  "SELECT DISTINCT cs. * , c. *
FROM comics AS c
JOIN comic_settings AS cs ON cs.ComicID = c.comiccrypt
WHERE (
c.CreatorID = '$UserID'
OR c.userid = '$UserID')
AND c.installed =1
ORDER BY c.title DESC";
$DB->query($query);
$counter = 0;
$numberComics = $DB->numRows();
$UserContent = "<div width='275'>";
while ($line = $DB->FetchNextObject()) {

	$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			
			if ($line->Hosted == 1) {
					$fileUrl = 'http://www.panelflow.com'.$line->thumb;
					$comicURL = $line->url.'/';
				} else if (($line->Hosted == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.panelflow.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $line->url;
				} else {
					$fileUrl = 'http://www.panelflow.com'.$line->thumb;
					$comicURL = $line->url;
				}


$UserContent .="<a href='#' onClick=\"set_content('".addslashes($line->title)."','".$line->comiccrypt."','".$comicURL."','".$fileUrl."','comic','".addslashes($line->synopsis)."','".addslashes($line->Tags)."');\"><img src='".$fileUrl."' border='2' alt='LINK' style='border:1px solid #000000;' width=\"50\" hspace='3' vspace='3'></a>"; 
			 $counter++;
			 
			
	
	 }
	  $UserContent .= "</div>";
	 if ($numberComics == 0) {
	 		$UserContent = "<div class='favs' style='text-align:center;padding-top:25px;height:200px;'>There are currently no active comics for this user</div>";
	 }

$query =  "SELECT c.*, f.*
FROM favorites as f
JOIN comics as c on (f.ContentID=c.comiccrypt or f.comicid=c.comiccrypt)
WHERE f.userid = '$UserID' ORDER BY c.title DESC";
$DB->query($query);

$counter = 0;
$numberComics = $DB->numRows();
$FavContent = "<div width='275'>";
while ($line = $DB->FetchNextObject()) {

	$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			
			if ($line->Hosted == 1) {
					$fileUrl = 'http://www.panelflow.com'.$line->thumb;
					$comicURL = $line->url.'/';
				} else if (($line->Hosted == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.panelflow.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $line->url;
				} else {
					$fileUrl = $line->thumb;
					$comicURL = $line->url;
				}
$FavContent .="<a href='#' onClick=\"set_content('".addslashes($line->title)."','".$line->comiccrypt."','".$comicURL."','".$fileUrl."','comic','".addslashes($line->synopsis)."','".addslashes($line->Tags)."');\"><img src='".$fileUrl."' border='2' alt='LINK' style='border:1px solid #000000;' width=\"50\" hspace='3' vspace='3'></a>"; 
			 $counter++;
 			
	}
	
	 
	 if ($numberComics == 0) {
	 		$FavContent = "<div class='favs' style='text-align:center;padding-top:25px;height:200px;'>There are currently no active comics for this user</div>";
	 }

?>



 <? $_SESSION['uploadtype'] = 'media';
   $_SESSION['comic'] = $ComicID;
   $_SESSION['story'] = '';
   $_SESSION['world'] = $WorldID;
   $_SESSION['safefolder'] = $SafeFolder;
   $_SESSION['dir'] = $ComicDir;
?>

<center>
<input type="hidden" name="txtThumb" id="txtThumb" value="<? echo $Thumb;?>" id="txtThumb" />

<input type="button" onclick="submit_form('add_return','save','');" value="ADD ITEM AND RETURN TO FORM" />&nbsp;&nbsp;
<input type="button" onclick="submit_form('add_exit','save','');" value="ADD ITEM AND EXIT WIZARD" />
</center>
<table cellpadding="0" cellspacing="0" border="0" width="700">
<tr>
<td valign="top" width="275">
<div style="height:10px;"></div>
Description<br />

<textarea style="width:275px;" name="txtItemDescription" id="txtItemDescription"><? if ($Description == '') echo 'Enter A Description'; else echo $Description;?></textarea><br>
<div style="height:10px;"></div>
LINK<br>
<? if ($_POST['Link'] == '') {?>
<div style="font-size:10px; width:90%;" >(you can enter an external link or use content you have tagged on W3VOLT)</div><div style="height:10px;"></div>
<table cellpadding="0" cellspacing="0" border="0"><tr>
<td id='urltab' class='tabactive' height="30" onClick="select_link('url')" onMouseOver="rolloveractive('urltab','urlupload')" onMouseOut="rolloverinactive('urltab','urlupload')" >URL</td><td width="5"></td>
<td id='mytab' class='tabinactive' height="30" onClick="select_link('my')" onMouseOver="rolloveractive('mytab','myupload')" onMouseOut="rolloverinactive('mytab','myupload')" >R3VOLTS</td>

<td width="5"></td>

<td id='favtab' class='tabinactive' height="30" onClick="select_link('fav')" onMouseOver="rolloveractive('favtab','favupload')" onMouseOut="rolloverinactive('favtab','favupload')" >VOLTS</td>

<td width="5"></td>

<td id='searchtab' class='tabinactive' height="30" onClick="select_link('search')" onMouseOver="rolloveractive('searchtab','searchupload')" onMouseOut="rolloverinactive('searchtab','searchupload')" >SEARCH</td>

</tr></table>

<? }?>
<div id="myupload" style="font-size:12px;height:300px;display:none; width:275px; overflow:auto;">
<div style="height:10px;"></div>
<? echo $UserContent;?>
</div>
<div id="urlupload" style="font-size:12px;">
<div style="height:10px;"></div>
Enter full link including http://<br/>
<input type="text" style="width:275px;" id="txtItemLink" name="txtItemLink" value="<? if ($_POST['Link'] == '') echo 'http://'; else echo $_POST['Link'];?>" ><div style="height:10px;"></div>
</div>

<div id="searchupload"  style="font-size:12px;display:none;">


<div style="height:10px;"></div>
SEARCH BOX
<table cellpadding="0" cellspacing="0" border="0" width="95%">
<tr>
<td><input type="text" style="width:230px;" id="txtSearch" name="txtSearch" value="Keywords" onFocus="doClear(this);" onBlur="setDefault(this);" onkeyup="checkIt(this.value);">&nbsp;&nbsp;
<div style="font-size:12px;">
<input type="radio" name="txtContent" value="comic" checked> Comics / Projects<br>
<input type="radio" name="txtContent" value="user"> Creators<br>
<input type="radio" name="txtContent" value="forum"> Forum Boards<br>
<input type="radio" name="txtContent" value="blog"> Blogs<br>
</div>

</td>
</tr>
</table>
</div>



<div id="favupload" style="display:none;font-size:12px; height:300px; width:275px; overflow:auto;">
<div style="height:10px;"></div>
<? echo $FavContent;?>
</div>

</td>
<td valign="top" style="padding-left:10px;"><div style="height:10px;"></div>
Tags<br />

<textarea style="width:200px;" name="txtItemTags" id="txtItemTags" onfocus="doClear(this)" onblur="setDefault(this)"><? if ($Tags != '') echo $Tags; else {?>Enter Tags (separate with a ',')<? }?></textarea><div style="height:10px;"></div>


<div id="thumbselect" style="display:<? if (($WindowArray->ModuleTemplate == 'content_thumb_title') || ($WindowArray->ModuleTemplate == 'content_thumb')|| ($WindowArray->ModuleTemplate == 'content_thumb_title_description')) {?>block<? } else {?>none<? }?>;">

	<? if ($Thumb == '') {?>
    UPLOAD THUMBNAIL <br />
    <iframe id='loaderframe' name='loaderframe' height='140px' width="275px" frameborder="no" scrolling="auto" src="http://www.w3volt.com/includes/media_upload_inc.php?compact=yes&transparent=1" allowtransparency="true"></iframe><div style="height:10px;"></div>
    <? }?>

</div>
<div id="thumbdisplay" <? if ($Thumb == '') {?>style="display:none;"<? }?>>
Thumb:<br />

<img src="<? echo $Thumb;?>" id="itemthumb" />
</div>
<div id="search_container" style="display:none;"><div class="sender_name">SEARCH RESULTS</div>
<div id="search_results" style="height:200px; overflow:auto;width:300px;"></div>
</div>
</td>
</tr>
</table>

<!--
<table cellpadding="0" cellspacing="0" border="0"> 
<tr>
<td class="profiletabactive" align="left" id='imagestab' onMouseOver="rolloveractive('imagestab','imagesdiv')" onMouseOut="rolloverinactive('imagestab','imagesdiv')" onclick="imagestab();"> IMAGES</td>

<td width="5"></td>

<td class="profiletabinactive" align="left" id='mediatab' onMouseOver="rolloveractive('mediatab','mediadiv')" onMouseOut="rolloverinactive('mediatab','mediadiv')" onclick="mediatab();"> MEDIA</td>
<td width="5"></td>


<td class="profiletabinactive" align="left" id='downloadstab' onMouseOver="rolloveractive('downloadstab','downloadsdiv')" onMouseOut="rolloverinactive('downloadstab','downloadsdiv')" onclick="downloadstab();"> DOWNLOADS</td>
</tr>
</table>-->

