<? 
$DB = new DB();
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


$UserContent .='<a href="javascript:void(0)" onClick=\"set_content(\''.addslashes(str_replace('"',"'",$line->title)).'\',\''.$line->ProjectID.'\',\''.$comicURL.'\',\''.$fileUrl.'\',\'comic\',\''.addslashes(str_replace('"',"'",$line->synopsis)).'\',\''.addslashes(str_replace('"',"'",$line->Tags)).'\');\"><img src="'.$fileUrl.'" border="2" alt="LINK" style="border:1px solid #000000;" width="50" hspace="3" vspace="3"></a>'; 
			 $counter++;
			 
			
	
	 }
	  $UserContent .= "</div>";
	 if ($numberComics == 0) {
	 		$UserContent = '<div class="favs" style="text-align:center;padding-top:25px;height:200px;">There are currently no active projects for this user</div>';
	 }
	 
	 $DB->close();?>
<table>
<tr>
<td>
<div align="left"><? if ($_GET['a'] == 'edit') echo 'editing job: <b>'.$JobArray->title.'</b>'; else echo 'create job';?></div>
<div class="spacer"></div>
<table width="<? echo ($_SESSION['contentwidth']-50);?>" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
				  <td id="blue_cmsBox_TL"></td>
				  <td id="blue_cmsBox_T"></td>
				  <td id="blue_cmsBox_TR"></td></tr>
				  <tr><td class="blue_cmsBox_L" background="http://www.wevolt.com/images/cms/blue_cms_box_L.png" width="8"></td>
				  <td class="blue_cmsboxcontent" valign="top" width="<? echo ($_SESSION['contentwidth']-66);?>" align="left">
                 <table width="100%" cellspacing="10"><tr><td valign="top" class="blue_cmsboxcontent" width="80%"><b>Description</b>: <? echo nl2br($JobArray->description);?><div class="spacer"></div><b>Rate: </b>:<? echo nl2br($JobArray->rate);?><div class="spacer"></div><b>Deadline</b>: <? if ($JobArray->deadline == '0000-00-00 00:00:00') echo 'open deadline'; else echo $JobArray->deadline;?><div class="spacer"></div><b>Type</b>: <? echo nl2br($JobArray->type);?></td><td valign="top"><img src="http://www.wevolt.com/images/apply_job.png" /><div class="spacer"></div>VOLT<div class="spacer"></div>SUGGEST<div class="spacer"></div>SHARE<div class="spacer"></div><? if ($JobArray->ProjectThumb != '') {?>For Project:<br/><a href="http://www.wevolt.com/<? echo $JobArray->SafeFolder;?>/"><img src="http://www.wevolt.com<? echo $JobArray->ProjectThumb;?>" border="2" style="border:2px #000000 solid;"></a><? }?></td></tr></table>
                 
                  
                  </td><td class="blue_cmsBox_R" background="http://www.wevolt.com/images/cms/blue_cms_box_R.png" width="8"></td>
				   </tr><tr><td id="blue_cmsBox_BL"></td><td id="blue_cmsBox_B"></td>
				   <td id="blue_cmsBox_BR"></td>
				   </tr></tbody></table> 
</td> 
<td>

</td>
</tr>
</table>