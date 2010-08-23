<?php include 'includes/init.php';

function build_module_template($FeedID, $CellID, $Preview = '0') {
		
	global $DB,$DB2,$ModuleTitleArray,$ModuleIndex,$TypeTarget, $TargetID;
	$Count = 0;
	
	$TabString = '';
	$ModuleString = '
	
	<!-- COMMENT FORM MODULE  -->
<table width="'.$ModuleTitleArray[$ModuleIndex]['Width'].'" height="'
.$ModuleTitleArray[$ModuleIndex]['Height'].'" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="modtopleft"></td>

	<td id="modtop">';

	$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and CellID='$CellID' order by Position";
	$ActiveModules = $DB->queryUniqueValue($query);
	
	//print $query.'<br/>';
//	print 'ACtive Mdules' . $ActiveModules.'<br/>';
	//print '<br/>';
	$query = "SELECT * from feed_settings where FeedID='$FeedID'";
	$SettingsArray = $DB->queryUniqueObject($query);
	//print $query.'<br/>';
	//print '<br/>';
	$DivString = '<div id="'.$CellID.'" style="width:'.$ModuleTitleArray[$ModuleIndex]['Width'].'px;height:'.				$ModuleTitleArray[$ModuleIndex]['Height'].'px;" class="modulebg">'; 
	
	
	$TabString .= '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr>';
	
	$TabString .= '<td width="100">'.$ModuleTitleArray[$ModuleIndex]['Title'].'</td><td width="5"></td>';
	
	$TabSpaces .= $ModuleTitleArray[$ModuleIndex]['Tabs'];
	$TabCount = 0;
	//print 'TabSpaces' . $TabSpaces.'<br/>';
	if ($ActiveModules == 0) {
		while($TabCount < $TabSpaces) {
			  $TabString .= '<td class="availtabactive" id="'.$CellID.'_'.$TabCount.'" onclick="window.location=\'feed_wizard.php?'.$TypeTarget.'='.$TargetID.'&module='.$CellID.'\';" align="left" width="86">Tab '.($TabCount+1).'</td><td width="5"></td>';
			$TabCount++;
		}
	
	} else {
		$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID = '$CellID' order by Position"; 
		$DB->query($query);
		while ($line = $DB->fetchNextObject()) {
			$ModuleTabIDArray[] = $line->EncryptID;
			$TabString .= '<td class="availtabinactive" align="left" width="86">'.$line->Title.'</td><td width="5"></td>';
			$TabCount++;
		}
		
		while($TabCount < $TabSpaces) {
			  $TabString .= '<td class="availtabactive" id="'.$CellID.'_'.$TabCount.'" onclick="window.location=\'feed_wizard.php?'.$TypeTarget.'='.$TargetID.'&module='.$CellID.'\';" align="left" width="86">Tab '.($TabCount+1).'</td><td width="5"></td>';
			$TabCount++;
		}
		
	
	
	}
	$TabString .= '</tr></table>';
	
	$ModuleString .= $TabString.'</td><td id="modtopright" valign="top"><a href="#"><img src="/templates/modules/standard/action_star.png" hspace="3" vspace="3" border="0"></a></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" height="'.$ModuleTitleArray[$ModuleIndex]['Height'].'">
	<div style="height:'.$ModuleTitleArray[$ModuleIndex]['Height'].'px;overflow:auto;" align="center"><div style="height:100px;"></div>MODULE '.($ModuleIndex+1);

	
	$ModuleString .='</div>
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
	$TypeTarget = 'name';
	$TargetID = $Name;
	$query = "select * from users where username='$Name'"; 
	$ItemArray = $DB->queryUniqueObject($query);
	$UserID = $ItemArray->encryptid;
	$Email =   $ItemArray->email;
	$FeedOfTitle = $ItemArray->username;
	//print $query.'<br/>';
	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID, fs.TemplateID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID'";
	$FeedArray = $DB->queryUniqueObject($query);
		//print $query.'<br/>';
} else {
	$TypeTarget = 'type';
	$TargetID = $ProjectType;
	$query = "select * from projects where SafeTitle='$Name' and ContentType='$ProjectType'";
	$ItemArray = $DB->queryUniqueObject($query);
	$UserID = $UserArray->UserID;
	$ProjectID =  $UserArray->ProjectID;
	$FeedOfTitle = $ItemArray->SafeTitle;

	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID, fs.TemplateID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.ProjectID='$ProjectID'";
	  
	$FeedArray = $DB->queryUniqueObject($query);
	
}


$FeedID = $FeedArray->EncryptID;
$FeedTemplate = $FeedArray->HtmlLayout;
$TemplateID = $FeedArray->TemplateID;	
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
			

			$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and CellID='$Cell' order by Position";
			$ActiveModules = $DB->queryUniqueValue($query);

			//print 'Actuve = ' .	$ActiveModules.'<br/>';
			$ModuleIndex = substr($Cell,6,strlen($Cell)-1)-1;
			$TabSpaces = $ModuleTitleArray[$ModuleIndex]['Tabs'];

			$ModuleWidth = $ModuleTitleArray[$ModuleIndex]['Width'];
			$ModuleHeight = $ModuleTitleArray[$ModuleIndex]['Height'];
			$AvailTabs = ($TabSpaces - $ActiveModules);
			$TabCount = 0;
			
		   	$CellString = build_module_template($FeedID, $Cell,1);		
			$FeedTemplate=str_replace("{".$Cell."}","<div style='padding-left:5px;padding-right:5px;'>".$CellString."</div>",$FeedTemplate);	
			
			$FeedTemplate=str_replace("{".$Cell."Width}",$ModuleTitleArray[$ModuleIndex]['Width'],$FeedTemplate);
				
			$FeedTemplate=str_replace("{".$Cell."Height}",$ModuleTitleArray[$ModuleIndex]['Height'],$FeedTemplate);
			
	}


?>



<?php include 'includes/header_template_new.php';?>
<script type="text/javascript">
function attach_file( p_script_url ) {
      	script = document.createElement( 'script' );
      	script.src = p_script_url; 
      	document.getElementsByTagName( 'head' )[0].appendChild( script );
}
		
function rolloveractive(tabid, divid) {
	var divstate = document.getElementById(divid).style.display;
		if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='tabhover';
		} 
}

function rolloverinactive(tabid, divid) {
		if (document.getElementById(divid).style.display != '') {
			document.getElementById(tabid).className ='tabinactive';
		} 
}
function submit_form(step, task, type) {
	modform.action = 'feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step='+step+'&task='+task;
	if (type != '') {
		document.getElementById("txtLayout").value = type;
	}
	
	modform.submit();

}

 function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
 
 function setDefault(theText) 
{
     if (theText.value == "")
 {
         theText.value = theText.defaultValue;
     }
 }
 
 function select_link(value) {
	if (value == 'local') {
		document.getElementById("localupload").style.display = '';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("localtab").className ='tabactive';
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
	} else if (value == 'url') {
		document.getElementById("urltab").className ='tabactive';
		document.getElementById("urlupload").style.display = '';
		document.getElementById("localtab").className ='tabinactive';
		document.getElementById("localupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabinactive';
		
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
		
	} else if (value == 'my') {
	
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("localtab").className ='tabinactive';
		document.getElementById("localupload").style.display = 'none';
		document.getElementById("mytab").className ='tabactive';
		document.getElementById("myupload").style.display = '';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
		
	} else if (value == 'fav') {
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("localtab").className ='tabinactive';
		document.getElementById("localupload").style.display = 'none';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabactive';
		document.getElementById("favupload").style.display = '';
		
	}



}



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


.tabactive {
height:12px;
background-color:#f58434;
text-align:center;
padding:5px;
cursor:pointer;
font-weight:bold;
font-size:12px;
}
.tabinactive {
height:12px;
background-color:#dc762f;
text-align:center;
padding:5px;
cursor:pointer;
color:#FFFFFF;
font-size:12px;
}
.tabhover{
height:12px;
background-color:#ffab6f;
color:#000000;
text-align:center;
padding:5px;
cursor:pointer;
font-size:12px;
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
