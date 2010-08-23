<?php include 'includes/init.php';


include 'includes/comments_inc.php';?>
<?php include 'includes/favorites_inc.php';?>
<? include 'includes/message_functions.php';?>
<?php 


function get_feed_items($ModuleID, $FeedID, $UserID) {

	global $DB,$DB2; 
	
	$String = '';
	$query = "SELECT * from feed_modules where EncryptID='$ModuleID'";
	$ModuleArray = $DB->queryUniqueObject($query);
	
	$SortVariable = $ModuleArray->SortVariable;
	$NumberVariable = $ModuleArray->NumberVariable;
	$Custom = $ModuleArray->Custom;
	$ContentVariable = $ModuleArray->ContentVariable;
	$ThumbSize = $ModuleArray->ThumbSize;
	$Template = $ModuleArray->ModuleTemplate;
	$ModuleType = $ModuleArray->ModuleType;
	
	if ($ModuleType == 'content'){
		
		if ($ContentVariable == 'comics') {
			
			$query = "SELECT * from comics where Published=1 and Pages>1 and thumb!='' order by $SortVariable DESC LIMIT $NumberVariable ";
			$DB->query($query);
			//print $query.'<br/><br/>';
				while ($line = $DB->fetchNextObject()) {
					$String .= '<a href="/'.$line->SafeFolder.'/">';
					$String .= '<img src="'.$line->thumb.'" hspace="3" vspace="3" border="2" style="border-color:#000000;" width="'.$ThumbSize.'"></a>';
				}
		
		}
	
	} else if ($ModuleType == 'list'){
		
		$query = "SELECT * from feed_items 
				  where ModuleID='$ModuleID' and FeedID='$FeedID' and UserID='$UserID' 
				  order by ModuleID, Position";
				  
		$DB->query($query);
		//print $query.'<br/>';
		//print '<br/>';
		$TotalItems =$DB->numRows();
		//print 'Total Items = ' .  $TotalItems.'<br/>';
		while ($line = $DB->fetchNextObject()) {
				
			   $ProjectID = $line->ProjectID;
			   $ContentID = $line->ContentID;
				//print_r($line);
				//print '<br/>';
				//print 'Template '.$Template.'<br/>';
				
			   	if ($Template == 'content_thumb') {
					
						if ($line->ItemType == 'project_link') {
							
							$query = "SELECT * from projects where ProjectID='$ProjectID'";
							$ProjectArray = $DB2->queryUniqueObject($query);
							$ProjectType = $ProjectArray->ProjectType;
							$ProjectTarget = $ProjectArray->SafeTitle;
							$String .= '<a href="/'.$ProjectTarget.'/">';
						} else if ($line->ItemType == 'feed_link') {
							$query = "SELECT * from feed where ProjectID='$ProjectID'";
							//$ProjectArray = $DB2->queryUniqueObject($query);
							//$ProjectType = $ProjectArray->ProjectType;
							//$ProjectTarget = $ProjectArray->SafeTitle;
							$String .= '<a href="/'.$ProjectTarget.'/">';
						} else if ($line->ItemType == 'creator_link') {
							$query = "SELECT * from users where encryptid='$ContentID'";
							//$ProjectArray = $DB2->queryUniqueObject($query);
							//$ProjectTarget = trim($ProjectArray->username);
							$String .= '<a href="/profile/'.$ProjectTarget.'/">';
						} else if ($line->ItemType == 'external_link'){
							$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">';
						}
						
						$String .= '<img src="'.$line->Thumb.'"  hspace="3" vspace="3" border="2" style="border-color:#000000;" width="'.$ThumbSize.'">';
						
						$String .= '</a>';
						
				} else if ($Template == 'content_list') {
							
							if ($line->ItemType == 'project_link') {
								$query = "SELECT * from projects where ProjectID='$ProjectID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectType = $ProjectArray->ProjectType;
								$ProjectTarget = $ProjectArray->SafeTitle;
								$String .= '<a href="/'.$ProjectTarget.'/">';
							
							} else if ($line->ItemType == 'feed_link') {
								$query = "SELECT * from feed where ProjectID='$ProjectID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectType = $ProjectArray->ProjectType;
								$ProjectTarget = $ProjectArray->SafeTitle;
								$String .= '<a href="/'.$ProjectTarget.'/">';
							
							}  else if ($line->ItemType == 'creator_link') {
								$query = "SELECT * from users where encryptid='$ContentID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectTarget = trim($ProjectArray->username);
								$String .= '<a href="/profile/'.$ProjectTarget.'/">';
						
							} else if ($line->ItemType == 'external_link') {
								$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">';
								
							}
							 
							$String .= $line->Title;
							
							$String .= '</a>';
							
				} else if ($Template == 'info_list') {
							$String .= '<div class="feed_item_title">'.$line->Title.'</div>';
							$String .= '<div class="feed_item_description">'.$line->Description.'</div>';
				}
				
		}
	
	} else if ($ModuleType == 'html'){
	
	}
	
	return $String;
	
}

function build_module($Title, $Template, $ModuleID, $FeedID, $UserID, $CellID,$SortVariable,$ContentVariable, $SearchVariable, $SearchTags, $Variable1, $Variable2, $Variable3, $Custom, $NumberVariable,$ThumbSize) {
		
	global $DB,$DB2,$ModuleTitleArray,$ModuleIndex,$TypeTarget, $TargetID;
	$TabString = '';
	$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and ParentModule = '$ModuleID' order by Position"; 
	$TotalTabs = $DB->queryUniqueValue($query);
	
	//print $query .'<br/>';
	//print 'TotalTabs ' .$TotalTabs.'<br/>';
	//print '<br/>';
	
	$FeedModuleArray = array(array());	
	$DivString = '<div id="'.$ModuleID.'">'; 
	
	$ModuleString = '
	
	<!-- COMMENT FORM MODULE  -->
<table width="'.$ModuleTitleArray[$ModuleIndex]['Width'].'" height="'
.$ModuleTitleArray[$ModuleIndex]['Height'].'" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="modtopleft"></td>

	<td id="modtop">';
	
	$ModuleTabIDArray = array($ModuleID);
	

	$TabString .= '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr>';
	
	$TabString .= '<td width="100">'.$ModuleTitleArray[$ModuleIndex]['Title'].'</td><td width="5"></td>';
	
	$TabString .= '<td class="availtabactive" id="'.$ModuleID.'_tab" onmouseover="rolloveractive(\''.$ModuleID.'_tab\',\''.$ModuleID.'_div\')" onmouseout="rolloverinactive(\''.$ModuleID.'_tab\',\''.$ModuleID.'_div\')" onclick="mod_tab(\''.$ModuleID.'-'.$ModuleID.'\');" align="left">'.$Title.'</td>
<td width="5"></td>';
		
	$query = "SELECT * from feed_modules where FeedID='$FeedID' and ParentModule = '$ModuleID' order by Position"; 
	$DB->query($query);
		
	//	print $query .'<br/>';
		//print '<br/>';
		
	while ($line = $DB->fetchNextObject()) {
			$ModuleTabIDArray[] = $line->EncryptID;
			$TabString .= '<td class="availtabinactive" id="'.$line->EncryptID.'_tab" onmouseover="rolloveractive(\''.$line->EncryptID.'_tab\',\''.$line->EncryptID.'_div\')" onmouseout="rolloverinactive(\''.$line->EncryptID.'_tab\',\''.$line->EncryptID.'_div\')" onclick="mod_tab(\''.$ModuleID.'-'.$line->EncryptID.'\');" align="left">'.$line->Title.'</td>
<td width="5"></td>';
	}
	$TabString .= '</tr></table>';

	$ModuleString .= $TabString.'</td><td id="modtopright" valign="top" align="right"><a href="#"><img src="/templates/modules/standard/action_star.png" hspace="3" vspace="3" border="0" width="50%"></a></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" height="'.$ModuleTitleArray[$ModuleIndex]['Height'].'">
	<div style="height:'.$ModuleTitleArray[$ModuleIndex]['Height'].'px;overflow:auto;" align="center">';
	
	//$DivString .= $TabString;
	$ModCount = 0;
	foreach($ModuleTabIDArray as $module) {
	
	if ($ModCount > 0) {
		$Display = 'none';
		
		$ModuleTabList .= ','.$module;
	} else {
		$Display = 'block';
		$ModuleTabList = $module;
	}		
		$ModuleString .= '<div id="'.$module.'_div" style="display:'.$Display.';">';
		
		$ModuleString .= get_feed_items($module, $FeedID, $UserID);
		$ModuleString .= '</div>';
		$ModCount++;
	}
	
	
	$ModuleString .= '<input id="'.$ModuleID.'_tabs" value="'.$ModuleTabList.'" type="hidden"></div>';
	
	$ModuleString .='
	<div class="spacer"></div>
	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>

<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
</table>
<!-- END MODULE  -->';
	
	return $ModuleString;

}






$Name = $_GET['name'];
$ProjectType = $_GET['type'];

$DB = new DB();
$DB2 = new DB();
if ($ProjectType == '') {

	$query = "select * from users where username='$Name'"; 
	$ItemArray = $DB->queryUniqueObject($query);
	$UserID = $ItemArray->encryptid;
	$Email =   $ItemArray->email;
	$FeedOfTitle = $ItemArray->username;
	//print $query.'<br/>';
	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID'";
	$FeedArray = $DB->queryUniqueObject($query);
		//print $query.'<br/>';
} else {

	$query = "select * from projects where SafeTitle='$Name' and ContentType='$ProjectType'";
	$ItemArray = $DB->queryUniqueObject($query);
	$UserID = $UserArray->UserID;
	$ProjectID =  $UserArray->ProjectID;
	$FeedOfTitle = $ItemArray->SafeTitle;

	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.ProjectID='$ProjectID'";
	  
	$FeedArray = $DB->queryUniqueObject($query);
	
	
}

$PageTitle = 'W3VOLT | FEED - '.$FeedOfTitle;
$FeedID = $FeedArray->EncryptID;
$FeedTemplate = $FeedArray->HtmlLayout;
$TotalLength = strlen($FeedTemplate);
$CurrentPosition = 0;
$WorkingString = $FeedTemplate;
	
$StillGoing = true;
$CellIDArray = array();
	
while ($StillGoing) {
			$StartPosition = strpos($WorkingString, "id=\"");
			$TempString = substr($WorkingString,$StartPosition+4, $TotalLength-1);
			$WalkingPosition = 0; 
			$EndPosition = strpos($TempString, "\">");
			$CellID = substr($TempString,$WalkingPosition, $EndPosition);
			$CellIDArray[] = $CellID;
			$CurrentPosition = $EndPosition;
			$WorkingString = substr($TempString,$EndPosition,$TotalLength-1);
			$NewLength = strlen($WorkingString);
			if ($NewLength < 36)
				$StillGoing = false;
			
}
	
$query = "SELECT * from feed_settings where FeedID='$FeedID'";
$SettingsArray = $DB->queryUniqueObject($query);
$query = "SELECT * from feed_templates where ID='$TemplateID'";
$TemplateArray = $DB->queryUniqueObject($query);

$ModuleTitleArray = array(array(
								'Title'=>$SettingsArray->Module1Title,
								'Width'=>$TemplateArray->Mod1Width,
								'Height'=>$TemplateArray->Mod1Height,
								'Tabs'=>$TemplateArray->Mod1Tabs),
							array(
								'Title'=>$SettingsArray->Module2Title,
								'Width'=>$TemplateArray->Mod2Width,
								'Height'=>$TemplateArray->Mod2Height,
								'Tabs'=>$TemplateArray->Mod2Tabs),
							array(
								'Title'=>$SettingsArray->Module3Title,
								'Width'=>$TemplateArray->Mod3Width,
								'Height'=>$TemplateArray->Mod3Height,
								'Tabs'=>$TemplateArray->Mod3Tabs),
							array(
								'Title'=>$SettingsArray->Module4Title,
								'Width'=>$TemplateArray->Mod4Width,
								'Height'=>$TemplateArray->Mod4Height,
								'Tabs'=>$TemplateArray->Mod4Tabs),
							array(
								'Title'=>$SettingsArray->Module5Title,
								'Width'=>$TemplateArray->Mod5Width,
								'Height'=>$TemplateArray->Mod5Height,
								'Tabs'=>$TemplateArray->Mod5Tabs),
							array(
								'Title'=>$SettingsArray->Module6Title,
								'Width'=>$TemplateArray->Mod6Width,
								'Height'=>$TemplateArray->Mod6Height,
								'Tabs'=>$TemplateArray->Mod6Tabs),
							array(
								'Title'=>$SettingsArray->Module7Title,
								'Width'=>$TemplateArray->Mod7Width,
								'Height'=>$TemplateArray->Mod7Height,
								'Tabs'=>$TemplateArray->Mod7Tabs),
							array(
								'Title'=>$SettingsArray->Module8Title,
								'Width'=>$TemplateArray->Mod8Width,
								'Height'=>$TemplateArray->Mod8Height,
								'Tabs'=>$TemplateArray->Mod8Tabs)
					);


foreach ($CellIDArray as $Cell) {
		$CellString = '';
		$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID='$Cell' order by Position"; 
		$DB->query($query);
		//print $query.'<br/>';
		$FeedModuleArray = array(array());
		while ($line = $DB->fetchNextObject()) {
				//$FeedModuleArray[] = array('ID'=>$line->EncryptID,'Title'=>$line->Title,'Width'=>$line->Width,'Position'=>$line->Position,'Template'=>$line->ModuleTemplate,'CellID'=>$Cell,'SortVariable'=>$line->SortVariable,'ContentVariable'=>$line->ContentVariable,'SearchVariable'=>$line->SearchVariable,'SearchTags'=>$line->SearchTags,'Variable1'=>$line->Variable1,'Variable2'=>$line->Variable2,'Variable3'=>$line->Variable3,'Custom'=>$line->Custom,'NumberVariable'=>$line->NumberVariable,'ThumbSize'=>$line->ThumbSize);
				
				$CellString .= build_module($line->Title,$line->ModuleTemplate, $line->EncryptID, $FeedID, $UserID, $Cell, $line->SortVariable,$line->ContentVariable, $line->SearchVariable, $line->SearchTags, $line->Variable1, $line->Variable2, $line->Variable3, $line->Custom, $line->NumberVariable, $line->ThumbSize);
				
		}
			
		/*foreach ($FeedModuleArray as $module) {
				$ModuleID = $module['ID'];
				print 'MODULE ID = ' . $ModuleID;
				print '<br/>';
				print_r($module);
				print '<br/>';
				print '<br/>';
				$CellString .= build_module($module['Title'],$module['Template'], $ModuleID, $FeedID, $UserID, $Cell, $module['SortVariable'],$module['ContentVariable'], $module['SearchVariable'], $module['SearchTags'], $module['Variable1'], $module['Variable2'], $module['Variable3'],$module['Custom'], $module['NumberVariable'],$module['ThumbSize']);
		}*/
		$FeedTemplate=str_replace("{".$Cell."}","<div style='padding-left:10px;padding-right:10px;'>".$CellString."</div>",$FeedTemplate);
		$FeedTemplate=str_replace("{".$Cell."Width}",$ModuleTitleArray[$ModuleIndex]['Width'],$FeedTemplate);
				
		$FeedTemplate=str_replace("{".$Cell."Height}",$ModuleTitleArray[$ModuleIndex]['Height'],$FeedTemplate);



}



/*
//TWITTER MODULE 
<div align="left" style="padding-right:10px;">
    <? if ($Twittername != '') {?>
    <div id="twitter_div" style="width:100%; padding-right:10px;">
<div class="sidebar-title">Twitter Updates</div>
<div id="twitter_update_list"></div>
<div class="menubar"><a href="http://twitter.com/<? echo $Twittername;?>" id="twitter-link" style="display:block;text-align:right;">follow me on Twitter</a></div>
<div class="spacer"></div>
</div>
*/	 

?>

<?php include 'includes/header_template_new.php';?>

<script type="text/javascript">
function twitterCallback2(twitters) {
  		var statusHTML = [];
  		for (var i=0; i<twitters.length; i++){
    		var username = twitters[i].user.screen_name;
			var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, 		function(url) {
		  return '<a href="'+url+'">'+url+'</a>';
		}).replace(/\B@([_a-z0-9]+)/ig, 
		
		function(reply) {
		  return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
		});
		
		statusHTML.push('<div style="padding-right:10px;"><div style="padding-top:5px;padding-bottom:5px;border-bottom:1px solid #000000;"><span style="color:#000000;">'+status+'</span><span class="menubar"> <em><a style="font-size:85%" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id+'">'+relative_time(twitters[i].created_at)+'</a></em></span></div></div>');
	  }
	  document.getElementById('twitter_update_list').innerHTML = statusHTML.join('');
}

function relative_time(time_value) {

		  var values = time_value.split(" ");
		  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
		  var parsed_date = Date.parse(time_value);
		  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
		  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
		  delta = delta + (relative_to.getTimezoneOffset() * 60);
		
		  if (delta < 60) {
				return 'less than a minute ago';
		  } else if(delta < 120) {
				return 'about a minute ago';
		  } else if(delta < (60*60)) {
				return (parseInt(delta / 60)).toString() + ' minutes ago';
		  } else if(delta < (120*60)) {
				return 'about an hour ago';
		  } else if(delta < (24*60*60)) {
				return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
		  } else if(delta < (48*60*60)) {
				return '1 day ago';
		  } else {
				return (parseInt(delta / 86400)).toString() + ' days ago';
		  }	  
}

function attach_file( p_script_url ) {
      	script = document.createElement( 'script' );
      	script.src = p_script_url; 
      	document.getElementsByTagName( 'head' )[0].appendChild( script );
}

function revealModal(divID) {
		window.onscroll = function () { document.getElementById(divID).style.top = document.body.scrollTop; };
		document.getElementById(divID).style.display = "block";
		document.getElementById(divID).style.top = document.body.scrollTop;
}
	
function hideModal(divID){
		document.getElementById(divID).style.display = "none";
}
	
		
function rolloveractive(tabid, divid) {
		var divstate = document.getElementById(divid).style.display;
		if (document.getElementById(divid).style.display != '') 
			document.getElementById(tabid).className ='availtabactive';
}
 
function rolloverinactive(tabid, divid) {
		if (document.getElementById(divid).style.display != '') 
			document.getElementById(tabid).className ='availtabinactive';
}

function mod_tab(value) {
	 
   //GRAB CURRENT GROUP ID OF SELECTED DROPDOWN
	var moduletarget= value.split('-');
	var ModuleParent = moduletarget[0];
	
	var SelectedModule = moduletarget[1];
	var ModuleList = document.getElementById(ModuleParent+'_tabs').value;
	var TabArray = ModuleList.split(',');
	//alert('NUMTABS '+ TabArray.length);
		for(i=0; i<TabArray.length; i++){
			//alert('MODULE ID' + TabArray[i]);
			if (TabArray[i] != SelectedModule) {
				document.getElementById(TabArray[i]+'_div').style.display = 'none';
				document.getElementById(TabArray[i]+'_tab').className ='availtabinactive';
			} else{
				document.getElementById(SelectedModule+'_div').style.display = '';
				document.getElementById(SelectedModule+'_tab').className ='availtabactive';
			}
		}
		
}
<? /*	
function comicstab()
	{
			document.getElementById("comicslist").style.display = '';
			document.getElementById("comicstab").className ='profiletabactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			<? if ($ID == $_SESSION['userid']) { ?>
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			<? }?>
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
	}
function infotab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = '';
			document.getElementById("infotab").className ='profiletabactive';
			<? if ($ID == $_SESSION['userid']) { ?>
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			<? }?>
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
			
	}
<? if ($ID == $_SESSION['userid']) { ?>
function favstab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			document.getElementById("favslist").style.display = '';
			document.getElementById("favstab").className ='profiletabactive';
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			
	}
	
	function appstab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = '';
			document.getElementById("appstab").className ='profiletabactive';
			<? }?>
			
	}
	<? }?>
	<? if ($Products >0) { ?>
	function productstab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			<? if ($ID == $_SESSION['userid']) { ?>
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			<? }?>
			document.getElementById("productslist").style.display = '';
			document.getElementById("productstab").className ='profiletabactive';
		
			
	}
	<? }?>
	
	   
   <table cellpadding="0" cellspacing="0" border="0"<? if ($Products > 0) { ?>width="386"<? } else {?>width="368"<? }?>> <tr>

<td class="profiletabactive" align="left" <? if ($Products > 0) { ?>width="25%"<? }?> id='comicstab' onMouseOver="rolloveractive('comicstab','comicslist')" onMouseOut="rolloverinactive('comicstab','comicslist')" onclick="comicstab();">COMICS</td>
<td width="5"></td>
<td class="profiletabinactive" align="left" <? if ($Products > 0) { ?>width="25%"<? }?> id='infotab' onMouseOver="rolloveractive('infotab','userinfo')" onMouseOut="rolloverinactive('infotab','userinfo')" onclick="infotab();"> INFO</td>
<? if ($ID == $_SESSION['userid']) { ?>
<td width="5"></td>
<td class="profiletabinactive" align="left" <? if ($Products > 0) { ?>width="25%"<? }?> id='favstab' onMouseOver="rolloveractive('favstab','favslist')" onMouseOut="rolloverinactive('favstab','favslist')" onclick="favstab();">FAVORITES</td>
<? }?>
<? if ($Products > 0) { ?>
<td width="5"></td>
<td class="profiletabinactive" align="left" <? if ($Products > 0) { ?>width="25%"<? }?> id='productstab' onMouseOver="rolloveractive('productstab','productslist')" onMouseOut="rolloverinactive('productstab','productslist')" onclick="productstab();">PRODUCTS</td>
<? }?>
<? if ($Applications > 0) { ?>
<td width="5"></td>
<td class="profiletabinactive" align="left" <? if ($Applications > 0) { ?>width="25%"<? }?> id='appstab' onMouseOver="rolloveractive('appstab','appslist')" onMouseOut="rolloverinactive('appstab','appslist')" onclick="appstab();">APPS</td>
<? }?>
</tr>
</table>
	*/
?>
	</script>

<style type="text/css">
	<!--
#modrightside {
	width: 9px;
	background-image:url(/templates/modules/standard/right_side.png);
	background-repeat:repeat-y;
}

#modleftside {
	width: 9px;
	background-image:url(/templates/modules/standard/left_side.png);
	background-repeat:repeat-y;
}

#modtop {
	height:38px;
	background-image:url(/templates/modules/standard/top_bar.png);
	background-repeat:repeat-x;
}

.boxcontent {
	color:#000000;
	background-color:#FFFFFF;
}

#modbottom {
	height:9px;
	background-image:url(/templates/modules/standard/bottom_bar.png);
	background-repeat:repeat-x;
}

#modbottomleft{
	width:9px;
	height:9px; 
	background-image:url(/templates/modules/standard/bottom_left.png);
	background-repeat:no-repeat;
}

#modtopleft{
	width:9px;
	height:38px; 
	background-image:url(/templates/modules/standard/top_left.png);
	background-repeat:no-repeat;
}

#modtopright{
	width:31px;
	height:38px; 
	background-image:url(/templates/modules/standard/top_right.png);
	background-repeat:no-repeat;
}

#modbottomright{
	width:31px;
	height:9px; 
	background-image:url(/templates/modules/standard/bottom_right.png);
	background-repeat:no-repeat;
}

-->
</style>
<table cellpadding="0" cellspacing="0" border="0" width="100%">

	<tr>
		<td width="<? echo $SideMenuWidth;?>" valign="top">
			<? include 'includes/site_menu_inc.php';?>
		</td> 
		
        <td  valign="top">
        
			<div style="padding:10px;">
               
                <? echo $FeedTemplate;?>
			</div>
            
		</td>
        
	</tr>
    
</table>

<?php include 'includes/footer_template_new.php';?>

<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<? echo $Twittername;?>.json?callback=twitterCallback2&amp;count=<? echo $TwitterCount;?>"></script>
</body>
</html>

