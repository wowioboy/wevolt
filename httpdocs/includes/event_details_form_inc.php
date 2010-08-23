<?php 

include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php');
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
AND c.installed =1 and c.Hosted=1
ORDER BY c.title DESC";
$DB->query($query);
$counter = 0;
$numberComics = $DB->numRows();
$UserContent = "<div style='width:100%;'>";
while ($line = $DB->FetchNextObject()) {

	$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			
			if ($line->Hosted == 1) {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					$comicURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/';//$line->url.'/';
				} else if (($line->Hosted == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $line->url;
				} else {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					$comicURL = $line->url;
				}


$UserContent .="<a href='#' onClick=\"set_content('".addslashes($line->title)."','".$line->comiccrypt."','".$comicURL."','".$fileUrl."','project','".addslashes($line->synopsis)."','".addslashes($line->Tags)."');\"><img src='".$fileUrl."' border='2' alt='LINK' style='border:1px solid #000000;' width=\"50\" hspace='3' vspace='3'></a>"; 
			 $counter++;
			 
			
	
	 }
	  $UserContent .= "</div>";
	 if ($numberComics == 0) {
	 		$UserContent = "<div class='favs' style='text-align:center;padding-top:25px;height:200px;'>There are currently no projects comics for this user</div>";
	 }

$query =  "SELECT c.*, f.*
FROM favorites as f
JOIN projects as c on f.ProjectID=c.comiccrypt
WHERE f.userid = '$UserID' and c.Hosted=1 ORDER BY c.title DESC";
$DB->query($query);

$counter = 0;
$numberComics = $DB->numRows();
$FavContent = "<div style='width:100%;'>";
while ($line = $DB->FetchNextObject()) {

	$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			
			if ($line->Hosted == 1) {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					$comicURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/';
				} else if (($line->Hosted == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $line->url;
				} else {
					$fileUrl = $line->thumb;
					$comicURL = $line->url;
				}
$FavContent .="<a href='#' onClick=\"set_content('".addslashes($line->title)."','".$line->comiccrypt."','".$comicURL."','".$fileUrl."','project','".addslashes($line->synopsis)."','".addslashes($line->Tags)."');\"><img src='".$fileUrl."' border='2' alt='LINK' style='border:1px solid #000000;' width=\"50\" hspace='3' vspace='3'></a>"; 
			 $counter++;
 			
	}
	
	 
	 if ($numberComics == 0) {
	 		$FavContent = "<div class='favs' style='text-align:center;padding-top:25px;height:200px;'>There are currently no active volts for this user</div>";
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

<img src="http://www.wevolt.com/images/wizard_save_exit_btn.png"  onclick="submit_form('add_exit','<? echo $_GET['task'];?>','<? echo $_GET['type'];?>');" class="navbuttons">
</center>

<table><tr><td valign="top"><table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="184" align="left">
<? if ($_GET['type'] == 'event') {?>
<div style="height:10px;"></div>
Description<br />
<textarea  style="width:180px; height:40px" name="txtDescription" id="txtDescription"><? if ($Description == '') echo 'Enter A Description'; else echo $Description;?></textarea><br>
<div style="height:10px;"></div>

<div style="height:5px;"></div><div class="messageinfo_white">
Tags
Enter Tags (separate with a ',')</div>
<textarea rows="1"  style="width:180px; height:30px;" name="txtTags" id="txtTags" onfocus="doClear(this)" onblur="setDefault(this)"></textarea><div style="height:5px;"></div>
<? }?>
<div style="height:10px;"></div>
                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                        
                                        </td>
                                        <td width="10"></td>
                                        
                                        <td valign="top">
                                        <table width="375" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="366" align="center">
                                       



 <div class="messageinfo_white" align="left">LINK</div>
<? if ($_POST['Link'] == '') {?>
<? if ($_GET['type'] != 'event') {?>
<div style="font-size:10px; width:98%;" class="messageinfo_white" align="left">(you can enter an external link or use content you have tagged on WeVOLT)</div><div style="height:10px;"></div>
<? }?>

<div align="center">
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
<? }?></div>
<div id="urlupload" style="font-size:12px; <? if ($_GET['type'] != 'event') {?>display:none;<? }?>" align="left">
<div style="height:5px;"></div>
Enter full link including http://<br/>
<? if ($_GET['type'] == 'event') {?>Optional: Enter a url where people can get more info<? }?>
<input type="text" style="width:98%;" id="txtLink" name="txtLink" value="<? if ($_POST['Link'] == '') echo 'http://'; else echo $_POST['Link'];?>" ><div style="height:10px;"></div>
</div>
<? }?>

<div id="thumbselect" align="left" <? if ($_GET['type'] != 'event') { ?>style="display:none;"<? }?> class="messageinfo_white">

	<? if ($Thumb == '') {?>
   6. UPLOAD THUMBNAIL 
    <iframe id='loaderframe' name='loaderframe' height='30px' width="350px" frameborder="no" scrolling="no" src="/includes/media_upload_inc.php?compact=yes&transparent=1&uploadaction=user_thumb" allowtransparency="true"></iframe><div style="height:10px;"></div>
    <? }?>

</div>
<div id="thumbdisplay" <? if ($Thumb == '') {?>style="display:none;"<? }?> class="messageinfo"> 

<table width="100%"><tr><td width="75" align="center">Thumb:<br /><img src="<? echo $Thumb;?>" id="itemthumb" width="50"/></td><td><div align="center">

</div></td></tr></table>
</div> 

<div id="myupload" style="font-size:12px;height:150px;display:<? if (($_GET['type'] != 'todo') && ($_GET['type'] != 'promo')) {?>none;<? }?>width:98%; overflow:auto;">
<div style="height:5px;"></div>
<? echo $UserContent;?>
</div>

<div id="searchupload"  style="font-size:12px;display:<? if ($_GET['type'] != 'notify') {?>none<? } else {?>block<? }?>;" class="messageinfo">
<div style="height:5px;"></div>
<table cellpadding="0" cellspacing="0" border="0" width="98%">
<tr>
<td><input type="text" style="width:98%;" id="txtSearch" name="txtSearch" value="Keywords" onFocus="doClear(this);" onBlur="setDefault(this);" onkeyup="checkIt(this.value);">
<div style="font-size:12px;">
<input type="radio" name="txtContent" value="comic" checked> Comics / Projects<br>
<input type="radio" name="txtContent" value="user"> Creators<br>
<input type="radio" name="txtContent" value="forum"> Forum Boards<br>
<input type="radio" name="txtContent" value="blog"> Blogs<br>
<div style="height:3px;"></div>
</div>

</td>
</tr>
</table>
<div id="search_container" style="display:none;"><div class="messageinfo_yellow"><strong>SEARCH RESULTS</strong></div><div style="height:3px;"></div>
<div id="search_results" style="height:50px; overflow:auto;width:98%;"></div></div>
</div>



<div id="favupload" style="display:none;font-size:12px; height:150px; width:98%; overflow:auto;">
<? echo $FavContent;?>
</div>

  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                                        
                                        </td>
                                      </tr></table>


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

