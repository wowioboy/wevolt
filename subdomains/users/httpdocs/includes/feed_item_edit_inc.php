<?
if (($ModuleType != 'custom') || ($ModuleType != 'content'))  {
                                           

$query = "SELECT * from pf_media where UploadBy='$UserID' and FileType='image'";
$DB->query($query);
$TotalImages = $DB->numRows();
$ImageCount = 0;
$ImageMediaString = '<table cellpadding="0" cellspacing="0" border="0"><tr>';
while ($line = $DB->FetchNextObject()) {
$ImageCount++;
	$ImageMediaString .= '<td align="center" width="60"><img src="http://www.wevolt.com/'.$line->Thumb.'" id="thumb_'.$line->ID.'" border="1" style="border:#fffff solid 1px;" vspace="2" hspace="2"><br/>[<a href="#" onClick="select_image(\''.$line->Height.'\',\''.$line->Width.'\',\''.$line->Filename.'\');return false;">SELECT</a>]<br/>[<a href="/'.$line->Filename.'" rel="lightbox">VIEW</a>]<div style="height:5px;"></div></td>';
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
$FavContent .="<a href='#' onClick=\"set_content('".addslashes(str_replace('"',"'",$line->title))."','".$line->ProjectID."','".$comicURL."','".$fileUrl."','comic','".addslashes(str_replace('"',"'",$line->synopsis))."','".addslashes(str_replace('"',"'",$line->Tags))."');\"><img src='".$fileUrl."' border='2' alt='LINK' style='border:1px solid #000000;' width=\"50\" hspace='3' vspace='3'></a>"; 
			 $counter++;
 			
	}
	
	 
	 if ($numberComics == 0) {
	 		$FavContent = "<div class='favs' style='text-align:center;padding-top:25px;height:200px;'>There are currently no active Volts</div>";
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
<input type="hidden" name="txtThumb" value="<? echo $Thumb;?>" id="txtThumb" />

</center>

<table><tr><td valign="top"><table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="184" align="left">
                                        1. Headline<br>
<input type="text" style="width:180px;" id="txtTitle" name="txtTitle" value="<? echo $FeedItemArray->Title;?>"><div style="height:5px;"></div>
2. Comment<br>
<textarea rows="1"  style="width:180px; height:40px" name="txtDescription" id="txtDescription"  ><? echo $FeedItemArray->Description;?></textarea>
<div style="height:5px;"></div><div class="messageinfo_white">
 3. Tags
Enter Tags (separate with a ',')</div>
<textarea rows="1"  style="width:180px; height:25px;" name="txtTags" id="txtTags" onFocus="doClear(this)" onBlur="setDefault(this)"><? echo $FeedItemArray->Tags;?></textarea><div style="height:5px;"></div>
<div style="height:5px;"></div><div class="messageinfo_white">
 4. Embed Code (optional)</div>
<textarea rows="1"  style="width:180px; height:30px;" name="txtEmbed" id="txtEmbed" onFocus="doClear(this)" onBlur="setDefault(this)"><? echo $FeedItemArray->Embed;?></textarea><div style="height:5px;"></div>
<div class="messageinfo_white">
5. Privacy</div>
<select name="txtPrivacy">
<option value="public" <? if ($FeedItemArray->PrivacySetting =='public') echo 'selected';?>>Public</option>
<option value='fans' <? if ($FeedItemArray->PrivacySetting =='fans') echo 'selected';?>>Fans</option>
<option value='friends'<? if ($FeedItemArray->PrivacySetting =='friends') echo 'selected';?>>Friends</option>
<option value='private'<? if ($FeedItemArray->PrivacySetting =='private') echo 'selected';?>>Private</option>
</select>

                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                        
                                        </td>
                                        <td width="10"></td>
                                        
                                        <td valign="top">
                                    <div align="center">
<img src="http://www.wevolt.com/images/wizard_save_exit_btn.png"  onclick="submit_form('add_exit','save','');" class="navbuttons">&nbsp;&nbsp;<img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="parent.$.modal().close();" class="navbuttons"></div>
                                        <table width="375" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="366" align="center">
                                       



 <div class="messageinfo_white" align="left">6. LINK</div>

<div style="font-size:10px; width:98%;" class="messageinfo_white" align="left">(enter an external link or use content on WeVOLT)</div><div style="height:10px;"></div>


<div align="center">
<table cellpadding="0" cellspacing="0" border="0"><tr>
<td id='urltab' class='tabactive' height="30" onClick="select_link('url')" onMouseOver="rolloveractive('urltab','urlupload')" onMouseOut="rolloverinactive('urltab','urlupload')" >Web Url</td><td width="5"></td>
<td id='mytab' class='tabinactive' height="30" onClick="select_link('my')" onMouseOver="rolloveractive('mytab','myupload')" onMouseOut="rolloverinactive('mytab','myupload')" >Your REvolts</td>

<td width="5"></td>

<td id='favtab' class='tabinactive' height="30" onClick="select_link('fav')" onMouseOver="rolloveractive('favtab','favupload')" onMouseOut="rolloverinactive('favtab','favupload')" >Your Volts</td>


</tr></table></div>

<div id="myupload" style="font-size:12px;height:110px;display:none; width:98%; overflow:auto;">
<div style="height:5px;"></div>
<? echo $UserContent;?>
</div>

<div id="urlupload" style="font-size:12px;" align="left">
<div style="height:5px;"></div>
Enter full link including http://<br/>
<input type="text" style="width:98%;" id="txtLink" name="txtLink" value="<? echo $FeedItemArray->Link;?>" ><div style="height:5px;"></div>
    <select name="txtLinkTarget">
    <option value="_parent" <? if ($FeedItemArray->Target =='_parent') echo ' selected ';?>>Same Page</option>
    <option value="_blank" <? if ($FeedItemArray->Target =='_blank') echo ' selected ';?>>New Page</option>
    </select>
<div style="height:10px;"></div>
</div>
<div id="favupload" style="display:none;font-size:12px; height:110px; width:98%; overflow:auto;">
<? echo $FavContent;?>
</div></div>
<? if (($ModuleTemplate == 'content_thumb_title') || ($ModuleTemplate == 'content_thumb')|| ($ModuleTemplate == 'content_thumb_title_description') ||($ModuleTemplate == 'content_thumb_title_desc') || ($ModuleTemplate == 'list')|| ($ModuleTemplate == 'box_list')) {?>
<div id="thumbselect" align="left" class="messageinfo_white">
<div style="height:5px;"></div>
   7. UPLOAD THUMBNAIL 
    <iframe id='loaderframe' name='loaderframe' height='30px' width="350px" frameborder="no" scrolling="no" src="/includes/media_upload_inc.php?compact=yes&transparent=1&uploadaction=user_thumb" allowtransparency="true"></iframe><div style="height:10px;"></div>

</div>





<div id="searchupload"  style="font-size:12px;display:none;" class="messageinfo">
<div style="height:5px;"></div>
<table cellpadding="0" cellspacing="0" border="0" width="98%">
<tr>
<td><input type="text" style="width:98%;" id="txtSearch" name="txtSearch" value="Keywords" onFocus="doClear(this);" onBlur="setDefault(this);" onKeyUp="checkIt(this.value);">
<div style="font-size:12px;">
<select name="txtContent" id="txtContent" style="font-size:10px;">
<option  value="comic"> Comics / Projects</option>
<option  value="user"> Creators</option>
<option  value="forum"> Forum Boards</option>
<option  value="blog"> Blogs</option>
</select>
<div style="height:3px;"></div>
</div>

</td>
</tr>
</table>
<div id="search_container" style="display:none;"><div class="messageinfo_yellow"><strong>SEARCH RESULTS</strong></div><div style="height:3px;"></div>
<div id="search_results" style="height:110px; overflow:auto;width:98%;"></div></div>
</div>





  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                                        
                                        </td>
                                      </tr></table>


<? } else if ($ModuleType == 'custom') {?>

 <div class="messageinfo_warning">Enter your window content below</div> <div class="spacer"></div>
                                            <script type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
                                                <script type="text/javascript">
                                                  tinyMCE.init({
													mode: "exact",
													elements : "content",
													theme : "advanced",
													skin : "o2k7",
													spellchecker_rpc_url : '/tinymce/jscripts/tiny_mce/plugins/spellchecker/rpc.php',
												
													theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
													theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,blockquote,|,link,unlink,anchor,cleanup,help,code,|,fullscreen",
													theme_advanced_buttons3 : "formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,image,media,|,preview",
													theme_advanced_toolbar_location : "top",
													theme_advanced_toolbar_align : "left",
													theme_advanced_statusbar_location : "bottom",
													theme_advanced_source_editor_width : "500",
													theme_advanced_source_editor_height : "300",

													plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
												
												});
                                                </script>
                                              <textarea name="content" id="content" style="width:525px; height:225px;"><? echo $ContentWindowArray->HTMLCode;?></textarea>
                                              <div class="spacer"></div>
                                               


<? } else if ($ModuleType == 'content') {?>
 <div class="messageinfo_white"> <strong>Automatic Content Selector</strong></div>
                                <div  style="height:10px;"></div>  
                                 <table width="500" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="484" align="center">
                                		<table width="99%">
                                        <tr>
                                        <td valign="top" width="33%">
                                        Select Type of Content
                                        <select name="contentSelect">
                                        <option value="comic" <? if ($ContentWindowArray->ContentVariable == 'comic') echo 'selected';?>>Comics</option>
                                        <option value="forum" <? if ($ContentWindowArray->ContentVariable == 'forum') echo 'selected';?>>Forums</option>
                                        <option value="blog" <? if ($ContentWindowArray->ContentVariable == 'blog') echo 'selected';?>>Blogs</option>
                                        </select>
                                        </td>
                                        <td valign="top" width="33%">
                                         Select desired filter
                                        <select name="contentSubSelect">
                                        <option value="rank" <? if ($ContentWindowArray->SortVariable == 'rank') echo 'selected';?>>By Ranking</option>
                                        <option value="PagesUpdated" <? if ($ContentWindowArray->SortVariable == 'PagesUpdated') echo 'selected';?>>Last Updated</option>
                                        <option value="createdate" <? if ($ContentWindowArray->SortVariable == 'createdate') echo 'selected';?>>Newest Revolts</option>
                                         <option value="featured" <? if ($ContentWindowArray->SortVariable == 'featured') echo 'selected';?>>Featured</option>
                                         <option value="excites" <? if ($ContentWindowArray->SortVariable == 'excites') echo 'selected';?>>Most Excites</option>
                                         <option value="pages" <? if ($ContentWindowArray->SortVariable == 'pages') echo 'selected';?>>Most Pages</option>
                                        </select>
                                        </td>
                                        <td valign="top" width="33%">
                                        Select number of results
                                         <select name="contentNumSelect">
                                         <option value="5" <? if ($ContentWindowArray->NumberVariable == '5') echo 'selected';?>>5</option>
                                         <option value="10" <? if ($ContentWindowArray->NumberVariable == '10') echo 'selected';?>>10</option>
                                         <option value="20" <? if ($ContentWindowArray->NumberVariable == '20') echo 'selected';?>>20</option>
                                         <option value="50" <? if ($ContentWindowArray->NumberVariable == '50') echo 'selected';?>>50</option>
                                         <option value="75" <? if ($ContentWindowArray->NumberVariable == '75') echo 'selected';?>>75</option>
                                          <option value="100" <? if ($ContentWindowArray->NumberVariable == '100') echo 'selected';?>>100</option>
                                         </select></td>
                                        </tr>
                                        </table>
                                        
                                                          
                                  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>  <div  style="height:10px;"></div>   
    


<? }?>
<? }?>  