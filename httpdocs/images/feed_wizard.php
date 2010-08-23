<?php include 'includes/init.php';?>

<?php 

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
	<div style="padding-top:50px;font-size:16px;color:#000000;font-weight:bold;" align="center">';
		if ($Preview == 1) {
			$PrevCount = 0;
			while ($PrevCount < 10) {
					
					$ModuleTitleArray[$ModuleIndex]['Width'];
					
					if ($_POST['thumbsize'] == '')
						$ThumbSize =$_POST['txtThumbSize'];
					else 
						 $ThumbSize =$_POST['thumbsize'];
						 
					$ModuleString .= '<img src="/images/sample_thumb.jpg" width="'.$ThumbSize.'" hspace="3" vspace="3">';
					$PrevCount++;
			}
		}
	
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

if ($_GET['step'] > 1) { 
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
$ModuleList = '<select name="Module">';
$TabList = '<select name="Tab">';
	foreach ($CellIDArray as $Cell) { 
			
			
			$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and CellID='$Cell' order by Position";
			$ActiveModules = $DB->queryUniqueValue($query);
			//print 'Actuve = ' .	$ActiveModules.'<br/>';
			$ModuleIndex = substr($Cell,6,strlen($Cell)-1)-1;
			$TabSpaces = $ModuleTitleArray[$ModuleIndex]['Tabs'];
			if ($_POST['txtModule'] == $Cell) {
				$ModuleWidth = $ModuleTitleArray[$ModuleIndex]['Width'];
				$ModuleHeight = $ModuleTitleArray[$ModuleIndex]['Height'];
				
			}
			//print 'TabSpaces = ' .	$TabSpaces.'<br/>';
			$AvailTabs = ($TabSpaces - $ActiveModules);
			
		//	print 'MODULE INDEX '.$ModuleIndex .'<br/>';
			print 'CELL NAME '.$Cell .'<br/>';
		//	print 'MODULE WIDTH = ' . $ModuleTitleArray[$ModuleIndex]['Width'].'<br/>';
		//	print 'MODULE HEIGHT = ' . $ModuleTitleArray[$ModuleIndex]['Height'].'<br/>';
			$TabCount = 0;
			if ($_GET['step'] == 2) { 
	print 'TabSpaces' . $TabSpaces.'<br/>';		 	
				$ModuleList .= "<option value='".$Cell."'";
				if ($_POST['txtModule'] == $Cell)
					$ModuleList .= "selected";
			
				$ModuleList .= ">".$Cell." - Available Tabs: ".$AvailTabs."</option>";
			} else if ($_GET['step'] == '3') {
			print 'POST[txtModule]='.$_POST['txtModule'].'<br/>';
					if (($_POST['txtModule'] == $Cell)||($_POST['Module'] == $Cell)) {
					print 'INSIDE'.'<br/>';
						if ($ActiveModules == 0) {
									while($TabCount < $TabSpaces) {
										$TabList .= "<option value='".$Cell."'";
										if ($_POST['txtModule'] == $Cell)
											$TabList .= "selected";
						
										$TabList .= ">Tab ".($TabCount+1)."</option>";
										$TabCount++;
									}
					
								} else {
									$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID = '$CellID' order by Position"; 
									$DB->query($query);
									while ($line = $DB->fetchNextObject()) {
										$TabCount++;
									}
							
									while($TabCount < $TabSpaces) {
										$TabList .= "<option value='".$Cell."'";
										if ($_POST['txtModule'] == $Cell)
											$TabList .= "selected";
						
										$TabList .= ">Tab ".($TabCount+1)."</option>";
										$TabCount++;
									}
							}
						
					}
		  
		  
		  
		  if (($_GET['step'] == 7) &&  ($_POST['txtModule'] == $Cell)) {
		   			$CellString .= build_module_template($FeedID, $Cell,1);		
			 
					
			}
			$FeedTemplate=str_replace("{".$Cell."}","<div style='padding-left:5px;padding-right:5px;'>".$CellString."</div>",$FeedTemplate);
			//
					$FeedTemplate=str_replace("{".$Cell."Width}",$ModuleTitleArray[$ModuleIndex]['Width'],$FeedTemplate);
			
					$FeedTemplate=str_replace("{".$Cell."Height}",$ModuleTitleArray[$ModuleIndex]['Height'],$FeedTemplate);
			}
		
	}
	$ModuleList .= "</select>";
		$TabList .= '</select>';
		
		if ($_GET['step'] == '6') {
			if ($ModuleWidth < 100)
				$RecSize = 50;
			else if ($ModuleWidth < 300)
				$RecSize = 50;
			else if (($ModuleWidth > 300) && ($ModuleWidth < 700))
				$RecSize = 100;
			else 
				$RecSize = 100;
		}
}
?>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script src="/lib/prototype.js" type="text/javascript"></script>
<script src="/lib/editinplace.js" type="text/javascript"></script>
<? require_once('classes/AjaxEditInPlace.inc.php');?>

<script type="text/javascript">
function attach_file( p_script_url ) {
      	script = document.createElement( 'script' );
      	script.src = p_script_url; 
      	document.getElementsByTagName( 'head' )[0].appendChild( script );
}
		
function rolloveractive(tabid, divid) {
		var divstate = document.getElementById(divid).style.display;
		if (document.getElementById(divid).style.display != '') 
			document.getElementById(tabid).className ='profiletabhover';
}
 
function rolloverinactive(tabid, divid) {
		if (document.getElementById(divid).style.display != '') 
			document.getElementById(tabid).className ='profiletabinactive';
}

function submit_form(step, task,type) {
	modform.action = 'feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step='+step+'&task='+task;
	if (type != '') {
		document.getElementById("txtLayout").value = type;
	}
	
	modform.submit();

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
-->
</style>

</head>
<form name="modform" id="modform" method="post">
<table cellpadding="0" cellspacing="0" border="0" width="1050">

	<tr>
			
<td  valign="top">
        
			<div style="padding:5px;">
            <? if (!isset($_GET['step'])){ ?>
            <img src="images/feed_step0.jpg" border="0" usemap="#Step0" >
            <?
                
			 } else if ($_GET['step'] == 1) {?>
             
       		  <img src="images/feed_step1.jpg" border="0" usemap="#Step1" >
             <input type="text" size="10" name="Name" value="<? echo $_POST['txtName'];?>">
             <? 
			
			
			} else if ($_GET['step'] == 2) { ?>
			 <img src="images/feed_step2.jpg" border="0" usemap="#Step2" ><?
				echo $ModuleList;
				//echo $FeedTemplate;
			} else if ($_GET['step'] == 3) { ?>
			 <img src="images/feed_step3.jpg" border="0" usemap="#Step3" ><?
				echo $TabList;
				//echo $FeedTemplate;
			}	else if ($_GET['step'] == 4) { ?>
			 <img src="images/feed_step4.jpg" border="0" usemap="#Step4" >
			 <input type="radio" name="Privacy" value="1">Private (Only you can see this module)<br>
			<input type="radio" name="Privacy" value="2">Friends (Only you can see this module)<br>
			<input type="radio" name="Privacy" value="3">Fans (Only you can see this module)<br>
			<input type="radio" name="Privacy" value="4">Public (Only you can see this module)<br>
            <input type="button" onClick="submit_form('5','<? echo $_GET['task'];?>','');" value="NEXT!">
			 <?
				
				//echo $FeedTemplate;
			} else if ($_GET['step'] == 5) { ?>
			<div style="background-image:url(images/feed_blank.jpg); background-repeat:no-repeat; width:669px;height:575px; padding-left:50px;padding-right:150px;" align="center">
            
            <div style="height:200px;"></div>
			 WHAT TYPE OF LAYOUT DO YOU WANT THIS MODULE TO HAVE? <br>

            <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','text');" value="TEXT"><br>
			<input type="button" onClick="submit_form('6','<? echo $_GET['task'];?>','thumbs');" value="THUMBNAILS"><br>
            </div>
			 <?
				
				//echo $FeedTemplate;
			} else if ($_GET['step'] == 6) { ?>
			<div style="background-image:url(images/feed_blank.jpg); background-repeat:no-repeat; width:669px;height:575px; padding-left:50px;padding-right:150px;" align="center">
            
            <div style="height:200px;"></div>
			 WHAT SIZE THUMBNAILS WOULD YOU LIKE? <br>
			 For this Module the reccomended size is <? echo $RecSize;?><br>
           <select name="thumbsize">
           <option value="25" <? if (($_POST['txtThumbSize'] == '25') || ($RecSize == '25')) echo 'selected';?>>25</option>
           <option value="50"<? if (($_POST['txtThumbSize'] == '50') || ($RecSize == '50')) echo 'selected';?>>50</option>
           <option value="75"<? if (($_POST['txtThumbSize'] == '75') || ($RecSize == '75')) echo 'selected';?>>75</option>
           <option value="100"<? if (($_POST['txtThumbSize'] == '100') || ($RecSize == '100')) echo 'selected';?>>100</option>
           <option value="200"<? if (($_POST['txtThumbSize'] == '200') || ($RecSize == '200')) echo 'selected';?>>200</option>
           </select>
           <input type="button" onClick="submit_form('7','<? echo $_GET['task'];?>','thumbs');" value="PREVIEW">
            <input type="button" onClick="submit_form('8','<? echo $_GET['task'];?>','thumbs');" value="NEXT!">
            </div>
			 <?
				
				//echo $FeedTemplate;
			} else if ($_GET['step'] == 7) { ?>
			           
            
			 <?
				
				echo $FeedTemplate;
			}
				?>
		</div>
            
	  </td>
        
	</tr>
    
</table>

<map name="Step0"><area shape="rect" coords="250,296,419,364" href="feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step=1&task=new"><area shape="rect" coords="250,382,422,449" href="feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step=2&task=edit">
</map>

<map name="Step1">
  <area shape="rect" coords="77,497,211,522" href="feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>"><area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('2','<? echo $_GET['task'];?>','');">
</map>

<map name="Step2">
  <area shape="rect" coords="77,497,211,522" href="#" onClick="submit_form('1','<? echo $_GET['task'];?>','');">
  <? if ($_GET['task'] == 'new') {?>
  	 <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('4','<? echo $_GET['task'];?>','');">
  <? } else {?> 
   <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('3','<? echo $_GET['task'];?>','');">
  <? }?>
 
</map>
<map name="Step3">
  <area shape="rect" coords="77,497,211,522" href="#" onClick="submit_form('2','<? echo $_GET['task'];?>','');">
  <? if ($_GET['task'] == 'new') {?>
  	 <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('4','<? echo $_GET['task'];?>','');">
  <? } else {?> 
   <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('5','<? echo $_GET['task'];?>','');">
  <? }?>
 
</map>
<map name="Step4">
  <area shape="rect" coords="77,497,211,522" href="#" onClick="submit_form('3','<? echo $_GET['task'];?>');">
   <area shape="rect" coords="453,496,594,522" href="#" onClick="submit_form('5','<? echo $_GET['task'];?>');">
</map>
<input type="hidden" name="txtName" value="<? if ($_POST['txtName'] != '') echo $_POST['txtName']; else if ($_POST['Name'] != '')echo $_POST['Name'];?>">
<input type="hidden" name="txtModule" value="<? if ($_POST['txtModule'] != '') echo $_POST['txtModule']; else if ($_POST['Module'] != '')echo $_POST['Module'];?>">
<input type="hidden" name="txtThumbSize" value="<? if ($_POST['txtThumbSize'] != '') echo $_POST['txtThumbSize']; else if ($_POST['thumbsize'] != '')echo $_POST['thumbsize'];?>">
<input type="hidden" name="txtLayout" id="txtLayout" value="<? echo $_POST['txtLayout'];?>">

</form>