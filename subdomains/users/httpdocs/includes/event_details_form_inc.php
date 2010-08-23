<?php 
$DB = new DB();
$UserID = $_SESSION['userid'];
$ContentType=$_POST['ContentType'];
$RefTitle= $_POST['RefTitle'];
$ContentType=$_POST['ContentType'];
$Link=$_POST['Link'];
$ContentID=$_POST['ContentID'];
$Thumb = $ContentArray->avatar;
                                           

$query = "SELECT * from pf_media where UploadBy='$UserID' and FileType='image'";
$DB->query($query);
$TotalImages = $DB->numRows();
$ImageCount = 0;
$ImageMediaString = '<table cellpadding="0" cellspacing="0" border="0"><tr>';
while ($line = $DB->FetchNextObject()) {
$ImageCount++;
	$ImageMediaString .= '<td align="center" width="60"><img src="http://www.wevolt.com/'.$line->Thumb.'" id="thumb_'.$line->ID.'" border="1" style="border:#fffff solid 1px;" vspace="2" hspace="2"><br/>[<a href="javascript:void(0)" onclick="select_image(\''.$line->Height.'\',\''.$line->Width.'\',\''.$line->Filename.'\');return false;">SELECT</a>]<br/>[<a href="/'.$line->Filename.'" rel="lightbox">VIEW</a>]<div style="height:5px;"></div></td>';
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
FROM projects AS c
JOIN comic_settings AS cs ON cs.ComicID = c.ProjectID
WHERE (
c.CreatorID = '$UserID'
OR c.userid = '$UserID')
AND c.installed =1
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
			
			///if ($line->Hosted == 1) {
					//$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//$comicURL = $line->url.'/';
				//} else if (($line->Hosted == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/';
				//} else {
					//$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//$comicURL = $line->url;
				//}


$UserContent .="<a href='#' onClick=\"set_content('".addslashes(str_replace('"',"'",$line->title))."','".$line->ProjectID."','".$comicURL."','".$fileUrl."','comic','".addslashes(str_replace('"',"'",$line->synopsis))."','".addslashes(str_replace('"',"'",$line->Tags))."');\"><img src='".$fileUrl."' border='2' alt='LINK' style='border:1px solid #000000;' width=\"50\" hspace='3' vspace='3'></a>"; 
			 $counter++;
			 
			
	
	 }
	  $UserContent .= "</div>";
	 if ($numberComics == 0) {
	 		$UserContent = "<div class='favs' style='text-align:center;padding-top:25px;height:200px;'>There are currently no active comics for this user</div>";
	 }

$query =  "SELECT c.*, f.*
FROM favorites as f
JOIN projects as c on f.ProjectID=c.ProjectID
WHERE f.userid = '$UserID' and c.Hosted=1 and c.Published=1 ORDER BY c.title DESC";
$DB->query($query);

$counter = 0;
$numberComics = $DB->numRows();
$FavContent = "<div style='width:100%;'>";
while ($line = $DB->FetchNextObject()) {

	$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			///if ($line->Hosted == 1) {
					//$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//$comicURL = $line->url.'/';
				//} else if (($line->Hosted == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = 'http://www.wevolt.com/'.$line->SafeFolder.'/';
				//} else {
					//$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//$comicURL = $line->url;
				//}

			/*if ($line->Hosted == 1) {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					$comicURL = $line->url.'/';
				} else if (($line->Hosted == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.wevolt.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $line->url;
				} else {
					$fileUrl = $line->thumb;
					$comicURL = $line->url;
				}
				*/
$FavContent .='<a href="javascript:void(0)" onClick="set_content(\''.addslashes(str_replace('"',"'",$line->title)).'\',\''.$line->ProjectID.'\',\''.$comicURL.'\',\''.$fileUrl.'\',\'comic\',\''.addslashes(str_replace('"',"'",$line->synopsis)).'\',\''.addslashes(str_replace('"',"'",$line->Tags)).'\');"><img src="'.$fileUrl.'" border="2" alt="LINK" style="border:1px solid #000000;" width="50" hspace="3" vspace="3"></a>'; 
			 $counter++;
 			
	}
	
	 
	 if ($numberComics == 0) {
	 		$FavContent = '<div class="favs" style="text-align:center;padding-top:25px;height:200px;">There are currently no active Volts</div>';
	 }


$DB->close();
?>



 <? $_SESSION['uploadtype'] = 'media';
   $_SESSION['comic'] = $ComicID;
   $_SESSION['story'] = '';
   $_SESSION['world'] = $WorldID;
   $_SESSION['safefolder'] = $SafeFolder;
   $_SESSION['dir'] = $ComicDir;

?>
<div style="height:10px;"></div>
<div class="messageinfo_white" align="center"><? if ($_GET['type'] == 'update') {?>Select which REvolt or Creator you want to get updates from<? } else {?>Enter more details about this entry below<? }?></div><div style="height:10px;"></div>
<table><tr>
<? if (($_REQUEST['type'] != 'reminder') &&($_REQUEST['type'] != 'update')&&($_REQUEST['type'] != 'todo')&&($_REQUEST['type'] != 'promotion')) {?>
<td valign="top"><table width="230" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="214" align="left">
<? if ($_GET['type'] == 'event')  {?>
<strong>More Info</strong><br />
<textarea  style="width:200px; height:30px;" name="txtInfo" id="txtInfo"><? if ($_REQUEST['txtInfo'] != '') echo $_REQUEST['txtInfo'];?></textarea><br>
<div style="height:10px;"></div>

<div style="height:5px;"></div><div class="messageinfo_white">
<strong>Tags</strong>
<span style="font-size:10px; font-style:italic;">(separate each with a ',')</span></div>
<textarea rows="1"  style="width:200px; height:20px;" name="txtTags" id="txtTags"><? if ($_REQUEST['txtTags'] != '') echo $_REQUEST['txtTags']; ?></textarea><div style="height:5px;"></div>

<div style="height:5px;"></div>
<div class="message_warning"><span style="font-size:10px; font-style:italic;">(optional)</span></div>
<div class="messageinfo_white">
Contact Name
<input type="text" style="width:180px;" name="txtContactName" id="txtContactName" value="<? if ($_REQUEST['txtContactName'] != '') echo $_REQUEST['txtContactName']; ?>" /><div style="height:5px;"></div>
Contact Phone
<input type="text" style="width:180px;" name="txtContactPhone" id="txtContactPhone" value="<? if ($_REQUEST['txtContactPhone'] != '') echo $_REQUEST['txtContactPhone']; ?>" /><div style="height:5px;"></div>
Contact Email
<input type="text" style="width:180px;" name="txtContactEmail" id="txtContactEmail" value="<? if ($_REQUEST['txtContactEmail'] != '') echo $_REQUEST['txtContactEmail']; ?>" /><div style="height:5px;"></div>
Use WEmail for contact? <br/>
<input type="radio" name="txtUseWemail" id="txtUseWemail" value="1" <? if ($_REQUEST['txtContactEmail'] = '1') echo 'checked'; ?>/>Yes&nbsp;&nbsp;<input type="radio" name="txtUseWemail" id="txtUseWemail" value="0" <? if ($_REQUEST['txtContactEmail'] = '0') echo 'checked'; ?>/>No

<? }?>

                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                        
                                        </td>
                                        <td width="10"></td>
                                        <? }?>
                                        <td valign="top">
                                        <table width="<? if (($_REQUEST['type'] == 'reminder') || ($_REQUEST['type'] == 'update') || ($_REQUEST['type'] == 'todo')) {?>500<? } else {?>375<? }?>" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="<? if (($_REQUEST['type'] == 'reminder') || ($_REQUEST['type'] == 'update')|| ($_REQUEST['type'] == 'todo'))  {?>484<? } else {?>366<? }?>" align="center">
                                       
<? if (($_REQUEST['type'] != 'update')&& ($_GET['type'] != 'promotion'))  {?> 

 <div class="messageinfo_white" align="left"><strong>LINK
 <? if (($_REQUEST['type'] != 'event') && ($_REQUEST['type'] != 'todo'))   {?></strong>
<div style="height:5px;"></div>
 <div id='urltitle'>
<div style="font-size:10px; width:98%;" class="messageinfo_white" align="left">(enter an external link or select content from WeVOLT)</div></div><div style="height:10px;"></div>
<div style="height:5px;"></div>
<? }?>

</div>
<? }?>

<? if (($_REQUEST['txtLink'] == '') || ($_REQUEST['task'] == 'edit')) {?>

	<? if (($_REQUEST['type'] != 'event') && ($_REQUEST['type'] != 'todo') &&($_REQUEST['type'] != 'promotion')) {?>
    <div align="center" id="contentmenu">
    <table cellpadding="0" cellspacing="0" border="0"><tr>
    <? if (($_REQUEST['type'] != 'update') &&($_REQUEST['type'] != 'promotion')) {?>
    <td id='urltab' class='tabactive' height="30" onClick="select_link('url')" onMouseOver="rolloveractive('urltab','urlupload')" onMouseOut="rolloverinactive('urltab','urlupload')" >URL</td><td width="5"></td>
    
    <td id='mytab' class='tabinactive' height="30" onClick="select_link('my')" onMouseOver="rolloveractive('mytab','myupload')" onMouseOut="rolloverinactive('mytab','myupload')" >REvolts</td>
    
    <td width="5"></td>
    <? }?>
    <? if (($_REQUEST['type'] != 'todo') &&($_REQUEST['type'] != 'promotion')) {?>
    <td id='favtab' class='tabinactive' height="30" onClick="select_link('fav')" onMouseOver="rolloveractive('favtab','favupload')" onMouseOut="rolloverinactive('favtab','favupload')" >Volts</td>
    
    <td width="5"></td>
    
    <td id='searchtab' class='<? if (($_GET['_REQUEST'] == 'update')&&($_REQUEST['type'] != 'promotion')) {?>tabactive<? } else {?>tabinactive<? }?>' height="30" onClick="select_link('search')" onMouseOver="rolloveractive('searchtab','searchupload')" onMouseOut="rolloverinactive('searchtab','searchupload')" >WEsearch</td>
    <? }?>
    </tr>
    
    </table></div>
    <? }?>
    
    <? if ($_REQUEST['type'] == 'todo') {?>
    Which project is this TODO event for?<br />
    
    <? } ?>
    <? if ($_REQUEST['type'] == 'promotion') {?>
    Which project is this Promotion event for?<br />
    <? } ?>

<div id="urlupload" style="font-size:12px;<? if (($_REQUEST['type'] == 'update') || ($_REQUEST['type'] == 'todo') ||($_REQUEST['type'] == 'promotion') && ($_REQUEST['a'] != 'edit')) {?>display:none;<? }?>" align="left" >
<div style="height:5px;"></div>
Enter full link including http://<br/>
<input type="text" style="width:98%;" id="txtLink" name="txtLink" value="<? if ($_POST['txtLink'] == '') echo 'http://'; else echo $_POST['txtLink'];?>" ><div style="height:10px;"></div>
</div>

<? } else {
	
		echo '<div align="left">'.$_POST['txtLink'].'</div>';
	}
	?>
    <? if (($_GET['type'] != 'update') &&($_REQUEST['type'] != 'promotion')) {?>
     <div align="left" id="linktargetdiv"><div style="height:5px;"></div>
    <? /*
    <select name="txtLinkTarget">
    <option value="_parent" <? if ($_REQUEST['txtLinkTarget'] == '_parent') echo ' selected';?>>Same Page</option>
    <option value="_blank" <? if ($_REQUEST['txtLinkTarget'] == '_parent') echo ' selected';?>>New Page</option>
    </select>
    */?>
	</div>
	
    <? }?>
    <div style="height:5px;"></div>
 
<div id="thumbselect" align="left" <? if ((($_REQUEST['type'] != 'event') && ($_REQUEST['type'] != 'reminder')) || ($_REQUEST['txtThumb'] != '')) { ?>style="display:none;"<? }?> class="messageinfo_white">
 <strong> UPLOAD THUMBNAIL </strong>
    <iframe id='loaderframe' name='loaderframe' height='50px' width="350px" frameborder="no" scrolling="no" src="/includes/media_upload_inc.php?compact=yes&transparent=1&uploadaction=user_thumb" allowtransparency="true"></iframe><div style="height:10px;"></div>
      <input type="hidden" name="txtThumb" id="txtThumb" value="<? if ($_REQUEST['txtThumb'] != '') echo $_REQUEST['txtThumb']; ?>">    
</div>
<div id="thumbdisplay" <? if ($_REQUEST['txtThumb'] == '')  {?>style="display:none;"<? }?> class="messageinfo"> 

<table cellpadding="5"><tr><td align="center" class="messageinfo_warning">Current<br />
Thumb:</td><td width="100" align="center"><img src="<? echo $_REQUEST['txtThumb'];?>" id="itemthumb" width="75" style="border:#000000 2px solid;"/></td><td class="messageinfo_white"><div id="resetformdiv" style="display:none;"><a href="javascript:void(0)" onclick="reset_form();">[RESET]</a></div><div id="changeimagediv"><a href="javascript:void(0)" onclick="change_thumb();">[CHANGE THUMB]</a></div></td></tr></table>
</div> 
<div id="myupload" style="font-size:12px;height:<? if (($_REQUEST['type'] == 'todo') ||($_REQUEST['type'] == 'promotion')) {?>200<? } else {?>120<? }?>px;display:<? if (($_REQUEST['type'] != 'todo') && ($_REQUEST['type'] != 'promotion')) {?>none;<? }?>; width:98%; overflow:auto;">
<div style="height:5px;"></div>
<? echo $UserContent;?>
</div>

<div id="searchupload"  style="font-size:12px;display:<? if ($_REQUEST['type'] != 'update') {?>none<? } else {?>block<? }?>;" class="messageinfo">

<table cellpadding="0" cellspacing="0" border="0" width="98%">
<tr>
<td><input type="text" style="width:98%;" id="txtSearch" name="txtSearch" value="Keywords" onFocus="doClear(this);" onBlur="setDefault(this);" onkeyup="checkIt(this.value);">
<div style="height:3px;"></div>
<select name="txtContent" id="txtContent" style="font-size:10px;">
<option  value="comic"> Comics / Projects</option>
<option  value="user"> Creators</option>
<option  value="forum"> Forum Boards</option>
<option  value="blog"> Blogs</option>
</select>
<div style="height:3px;"></div>


</td>
</tr>
</table>
<div id="search_container" style="display:none;"><div class="messageinfo_yellow"><strong>SEARCH RESULTS</strong></div><div style="height:3px;"></div>
<div id="search_results" style="height:50px; overflow:auto;width:98%;"></div></div>
</div>



<div id="favupload" style="display:none;font-size:12px; height:120px; width:98%; overflow:auto;">
<? echo $FavContent;?>
</div>
<? /*
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
<? if ($_REQUEST['type'] == 'todo') {?>
Which project is this TODO event for?<br />

<? } 
if ($_REQUEST['type'] == 'promo') {?>
Which project is this Promotion event for?<br />
<? }?></div>
<div id="urlupload" style="font-size:12px; <? if ($_REQUEST['type'] != 'event') {?>display:none;<? }?>" align="left">
<div style="height:5px;"></div>
Enter full link including http://<br/>
<? if ($_REQUEST['type'] == 'event') {?>Optional: Enter a url where people can get more info<? }?>
<input type="text" style="width:98%;" id="txtLink" name="txtLink" value="<? if ($_REQUEST['txtLink'] != '') echo $_REQUEST['txtLink']; else echo 'http://';?>" ><div style="height:10px;"></div>
</div>
<? }?>

<div id="thumbselect" align="left" <? if ($_REQUEST['type'] != 'event') { ?>style="display:none;"<? }?> class="messageinfo_white">


   6. UPLOAD THUMBNAIL 
    <iframe id='loaderframe' name='loaderframe' height='30px' width="350px" frameborder="no" scrolling="no" src="/includes/media_upload_inc.php?compact=yes&transparent=1&uploadaction=user_thumb" allowtransparency="true"></iframe><div style="height:10px;"></div>
 
</div>
<div id="thumbdisplay" <? if ($Thumb == '') {?>style="display:none;"<? }?> class="messageinfo"> 

<table width="100%"><tr><td width="75" align="center" class="messageinfo_white">Current Thumb:<br /><img src="<? echo $Thumb;?>" id="itemthumb" width="50"/></td><td><div align="center">

</div></td></tr></table>
</div> 

<div id="myupload" style="font-size:12px;height:150px;display:<? if (($_REQUEST['type'] != 'todo') && ($_REQUEST['type'] != 'promo')) {?>none;<? }?>width:98%; overflow:auto;">
<div style="height:5px;"></div>
<? echo $UserContent;?>
</div>

<div id="searchupload"  style="font-size:12px;display:<? if ($_REQUEST['type'] != 'notify') {?>none<? } else {?>block<? }?>;" class="messageinfo">
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
<? */?>
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

