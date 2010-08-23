<?php 

include_once('init.php');
$FeedDB = new DB();
$UserID = $_SESSION['userid'];
$ContentType=$_POST['ContentType'];
$RefTitle= $_POST['RefTitle'];
$ContentType=$_POST['ContentType'];
$Link=$_POST['Link'];
$ContentID=$_POST['ContentID'];

$Thumb = $ContentArray->avatar;
	
$query = "SELECT * from pf_media where UploadBy='$UserID' and FileType='image'";
$FeedDB->query($query);
$TotalImages = $FeedDB->numRows();
$ImageCount = 0;
$ImageMediaString = '<table cellpadding="0" cellspacing="0" border="0"><tr>';
while ($line = $FeedDB->FetchNextObject()) {
$ImageCount++;
	$ImageMediaString .= '<td align="center" width="60"><img src="http://www.wevolt.com/'.$line->Thumb.'" id="thumb_'.$line->ID.'" border="1" style="border:#fffff solid 1px;" vspace="2" hspace="2"><br/>[<a href="#" onclick="select_image(\''.$line->Height.'\',\''.$line->Width.'\',\''.$line->Filename.'\');return false;">SELECT</a>]<br/>[<a href="/'.$line->Filename.'" rel="lightbox">VIEW</a>]<div style="height:5px;"></div></td>';
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
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					$comicURL = $line->url.'/';
				} else if (($line->Hosted == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $line->url;
				} else {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					$comicURL = $line->url;
				}

$UserContent .="<a href='#' onClick=\"set_content('".addslashes($line->title)."','".$line->comiccrypt."','comic','".$fileUrl."');\"><img src='".$fileUrl."' border='2' alt='LINK' style='border:1px solid #000000;' width=\"50\" hspace='3' vspace='3'></a>"; 
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
<center>
<input type="hidden" name="txtThumb" id="txtThumb" value="<? echo $Thumb;?>" id="txtThumb" />
<img src="http://www.wevolt.com/images/wizard_save_exit_btn.png"  onclick="submit_form('add_exit','<? echo $_GET['task'];?>','<? echo $_GET['type'];?>');" class="navbuttons">
</center>
<table cellpadding="0" cellspacing="0" border="0" width="700">
<tr>
<td valign="top" width="275">
<table><tr><td valign="top"><table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="184" align="left">
<? if ($_GET['type'] == 'event') {?>
<div style="height:10px;"></div>
Description<br />

<textarea style="width:275px;" name="txtDescription" id="txtDescription"><? if ($Description == '') echo 'Enter A Description'; else echo $Description;?></textarea><br>

<div style="height:10px;"></div>
LINK<br>

<div style="font-size:10px; width:90%;" ><? if ($_GET['type'] == 'event') {?>Optional: Enter a url where people can get more info<? }?></div><div style="height:10px;"></div>
<? }?>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
 <? if (($_GET['type'] != 'event') && ($_GET['type'] != 'todo') &&($_GET['type'] != 'promo')) {?>
<table cellpadding="0" cellspacing="0" border="0"><tr>
<? if ($_GET['type'] != 'notify') {?>
<td id='mytab' class='tabinactive' height="30" onClick="select_link('my')" onMouseOver="rolloveractive('mytab','myupload')" onMouseOut="rolloverinactive('mytab','myupload')" >R3VOLTS</td>
<td width="5"></td>
<? }?>
<? if (($_GET['type'] != 'todo') &&($_GET['type'] != 'promo')) {?>
<td id='favtab' class='tabinactive' height="30" onClick="select_link('fav')" onMouseOver="rolloveractive('favtab','favupload')" onMouseOut="rolloverinactive('favtab','favupload')" >VOLTS</td>
<td width="5"></td>
<td id='searchtab' class='tabinactive' height="30" onClick="select_link('search')" onMouseOver="rolloveractive('searchtab','searchupload')" onMouseOut="rolloverinactive('searchtab','searchupload')" >SEARCH</td>
<? }?>
</tr></table>
<? }?>
<? if ($_GET['type'] == 'todo') {?>
Which project is this TODO event for?<br />

<? } 
if ($_GET['type'] == 'promo') {?>
Which project is this Promotion event for?<br />
<? }?>
<div id="SelectedTitle"></div>
<div id="myupload" style="font-size:12px;height:300px;display:<? if (($_GET['type'] != 'todo') && ($_GET['type'] != 'promo')) {?>none;<? }?> width:275px; overflow:auto;">
<div style="height:10px;"></div>
<? echo $UserContent;?>
</div>
<div id="urlupload" style="font-size:12px; <? if ($_GET['type'] != 'event') {?>display:none;<? }?>">
<div style="height:10px;"></div>
Enter full link including http://<br/>
<input type="text" style="width:275px;" id="txtLink" name="txtLink" value="<? if ($_POST['Link'] == '') echo 'http://'; else echo $_POST['Link'];?>" ><div style="height:10px;"></div>
</div>

<div id="searchupload"  style="font-size:12px;display: <? if ($_GET['type'] != 'notify') {?>none<? } else {?>block<? }?>;">


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
<? if ($_GET['type'] == 'event') {?>
Tags<br />

<textarea style="width:200px;" name="txtTags" id="txtTags" onfocus="doClear(this)" onblur="setDefault(this)"><? if ($Tags != '') echo $Tags; else {?>Enter Tags (separate with a ',')<? }?></textarea><div style="height:10px;"></div>
<? }?>

<div id="thumbselect" <? if ($_GET['type'] != 'event') { ?>style="display:none;"<? }?>>

	<? if ($Thumb == '') {
	$_SESSION['uploadaction'] = 'user_thumb';
	?>
    UPLOAD THUMBNAIL<div class="messageinfo">optional: If no thumbnail provided, <br />
W3VOLT will use your user avatar.</div>
    <iframe id='loaderframe' name='loaderframe' height='30px' width="350px" frameborder="no" scrolling="no" src="/includes/media_upload_inc.php?compact=yes&transparent=1&uploadaction=user_thumb" allowtransparency="true"></iframe><div style="height:10px;"></div>
    <? }?>

</div>
<div id="thumbdisplay" <? if ($Thumb == '') {?>style="display:none;"<? }?>>
Thumb:<br />

<img src="<? echo $Thumb;?>" id="itemthumb" /><br />
<div id="changelink">
[<a href="#" onclick="document.getElementById('thumbselect').style.display='';">change</a>]
</div>
</div>
<div id="search_container" style="display:none;"><div class="sender_name">SEARCH RESULTS</div>
<div id="search_results" style="height:200px; overflow:auto;width:300px;"></div>
</div>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td>
</tr>
</table>
<input type="hidden" name="save" value="1" />

