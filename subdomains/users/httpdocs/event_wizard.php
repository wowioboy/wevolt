<?php include 'includes/init.php';

	
$Action = $_GET['action'];
$UserID = $_SESSION['userid'];
$EventID = $_GET['id'];
$RePost = 0;
$DB = new DB();
$DB2 = new DB();
$query = "select * from users where encryptid='$UserID'"; 
$UserArray = $DB->queryUniqueObject($query);

if (($_SESSION['userid'] == '') || ($UserID != $_SESSION['userid']))
	$Auth = 0;
else 
	$Auth = 1;


if ((($_GET['step'] =='finish')||($_GET['step'] =='quit')) && ($_POST['save'] == 1)) { 
	
		$TargetModule = $_POST['txtModule'];
		if ($TargetModule == '')
			$TargetModule = $_POST['TargetWindow'];
		$CellID = $_POST['CellID'];	
		$Title = mysql_real_escape_string($_POST['txtName']);
		$Tags = mysql_real_escape_string($_POST['txtWindowTags']);
		$Description = mysql_real_escape_string($_POST['txtWindowDescription']);
		$Layout = $_POST['txtLayout'];
		$Privacy = $_POST['txtPrivacy'];
		$ThumbSize = $_POST['txtThumbSize'];
		$UserID = $_SESSION['userid'];
		$CreateDate = date('Y-m-d h:i:s');
		$TabID = $_POST['txtTab'];
		$ModuleID = $_POST['txtModuleID'];
		$IsMain = $_POST['txtMain'];
		$ModuleType = $_POST['txtModuleType'];
		
		if ($IsMain == '')
			$IsMain = 0;
		
		if ($_GET['task'] == 'new') {
			
			if ($IsMain == 1) {
				$query = "SELECT ID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$CurrentMain = $DB->queryUniqueValue($query);
				if ($CurrentMain != '') {
					$query = "UPDATE feed_modules set IsMain='0' where FeedID='$FeedID' and ID='CurrentMain'";
					$DB->execute($query);
				
				}
			}
			$query ="SELECT Position from feed_modules WHERE Position=(SELECT MAX(Position) FROM feed_modules where CellID='$TargetModule' and FeedID='$FeedID')";
			$NewPosition = $DB->queryUniqueValue($query);
			$NewPosition++;
			
			$query = "INSERT into feed_modules (Title, CellID, ModuleTemplate, ThumbSize, FeedID,Privacy,IsMain,CreateDate, Position,ModuleType, Description, Tags) values ('$Title','$CellID','$Layout','$ThumbSize','$FeedID','$Privacy', '$IsMain','$CreateDate','$NewPosition','$ModuleType','$Description','$Tags')";
			$DB->execute($query);
			
			$query = "SELECT ID from feed_modules where CreateDate='$CreateDate'";
			$ModuleID = $DB->queryUniqueValue($query);
			
			$Encryptid = substr(md5($ModuleID), 0, 12).dechex($ModuleID);
			
			$query = "UPDATE feed_modules set EncryptID='$Encryptid' where ID='$ModuleID'";
			
			$DB->execute($query);
			$ModuleID = $Encryptid;
			$RePost = 1;
			//header("Location:feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
		
		} else if ($_GET['task'] == 'edit') {
			if ($IsMain == 1) {
				$query = "SELECT EncryptID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$CurrentMain = $DB->queryUniqueValue($query);
				if ($CurrentMain != $ModuleID) {
					$query = "UPDATE feed_modules set IsMain='0' where FeedID='$FeedID' and ID='CurrentMain'";
					$DB->execute($query);
				
				}
			} 
			$query = "UPDATE feed_modules set Title='$Title', Description='$Description', Tags='$Tags', CellID='$CellID', ModuleTemplate='$Layout', ThumbSize='$ThumbSize', IsMain='$IsMain',Privacy='$Privacy',Position='$TabID' where EncryptID='$ModuleID'";
			$DB->execute($query);
			if ($_GET['step'] =='finish')
				header("Location:feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
		
			else 
				header("Location:view_feed.php?".$TypeTarget."=".$TargetID);
		
		}
	
}
$CloseWindow = 0;



?>
<LINK href="http://www.w3volt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
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

		var formaction = 'feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step='+step;
		var ModuleID ='<? echo $ModuleID;?>';
		
		if (step == 'add') {
			if (ModuleID == '') 
				ModuleID = task;
				
			formaction = formaction + '&module='+ModuleID;
		} else { 
			formaction = formaction +'&task='+task;
		}
	if (type != '') {
		document.getElementById("txtLayout").value = type;
	}
	document.modform.action = formaction;
	document.modform.submit();

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
	//	document.getElementById("localupload").style.display = '';
		document.getElementById("urlupload").style.display = 'none';
		//document.getElementById("localtab").className ='tabactive';
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
	} else if (value == 'url') {
		document.getElementById("urltab").className ='tabactive';
		document.getElementById("urlupload").style.display = '';
		//document.getElementById("localtab").className ='tabinactive';
		//document.getElementById("localupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabinactive';
		
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
		
	} else if (value == 'my') {
	
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
	
	//	document.getElementById("localtab").className ='tabinactive';
		//document.getElementById("localupload").style.display = 'none';
		// alert(value);
		document.getElementById("mytab").className ='tabactive';
		document.getElementById("myupload").style.display = '';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
	
		
		
	} else if (value == 'fav') {
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
		//document.getElementById("localtab").className ='tabinactive';
		//document.getElementById("localupload").style.display = 'none';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabactive';
		document.getElementById("favupload").style.display = '';
		
	}



}

function set_content(title, contentid, contentlink, contentthumb,contenttype,description,tags) {
		select_link('url');
		
		//ERROR FROM HERE SOMEWHERE
		document.getElementById("ContentType").value = contenttype;
		document.getElementById("ContentID").value = contentid;
		document.getElementById("txtItemTitle").value = title;
		document.getElementById("txtItemDescription").value = description;
		document.getElementById("txtItemTags").value = tags;
		document.getElementById("txtItemLink").value = contentlink;
		
		if (Template == 'content_thumb_title') || (Template == 'content_thumb')|| (Template == 'content_thumb_title_description')) {
			document.getElementById("thumbselect").style.display = 'none';
			document.getElementById("thumbdisplay").style.display = '';
			document.getElementById("itemthumb").src = contentthumb;
			document.getElementById("txtThumb").value = contentthumb;
		}
}
 
 


</script>
<style type="text/css">
	<!--
#modrightside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/right_side.png);
	background-repeat:repeat-y;
}

#modleftside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/left_side.png);
	background-repeat:repeat-y;
}

#modtop {
	height:38px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_bar.png);
	background-repeat:repeat-x;
}

.boxcontent {
	color:#000000;
	background-color:#FFFFFF;
}

#modbottom {
	height:9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_bar.png);
	background-repeat:repeat-x;
}

#modbottomleft{
	width:9px;
	height:9px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_left.png);
	background-repeat:no-repeat;
}

#modtopleft{
	width:9px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_left.png);
	background-repeat:no-repeat;
}

#modtopright{
	width:31px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_right.png);
	background-repeat:no-repeat;
}

#modbottomright{
	width:31px;
	height:9px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_right.png);
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


                       
                        <div style="background-image:url(http://www.w3volt.com/images/wizard_bg.jpg); background-repeat:no-repeat; background-position:top left;width:725px; height:628px;" align="left"><img src="http://www.w3volt.com/images/wizard_volt.jpg" /><img src="http://www.w3volt.com/images/wizard_edit.jpg" /><img src="http://www.w3volt.com/images/wizard_info.jpg" />
                                    
                               <div style="height:420px;width:600px;" align="left">
                           <form name="modform" id="modform" method="post">
                            <? if (!isset($_GET['step'])){ ?>
                            <div class="wizardheadlines" style="padding-left:50px; padding-top:50px;">
                                       Welcome to the window design wizard. <br />
<br />
Click on the "info" button in the top right corner at any time for help. 
</div>
<div align="center" style="padding-right:100px; padding-top:25px;">
<img src="http://www.w3volt.com/images/create_new_window.png"  border="0" vspace="5" onClick="submit_form('1','new','');" class="navbuttons"/><br />
<img src="http://www.w3volt.com/images/add_to_window.png"  border="0" vspace="5" onClick="submit_form('1','add','');" class="navbuttons"/><br />
<? if ($_GET['add'] != 1) {?>
<a href="/feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step=1&task=edit"><img src="http://www.w3volt.com/images/edit_exisiting_window.png"  border="0" vspace="5"/></a><br />
<? }?>
</div>
                                     
                            <? } else if ($_GET['step'] == 1) {?>
                            <div class="spacer"></div>
                            <div style="padding-left:20px;">
                            <? if ($_GET['task'] == 'new') {?>
							Click the '+' mark on the window cell you would like this new window to sit. <div class="spacer"></div>
							
							<? } else  if ($_GET['task'] == 'add') {?>
                            Click the window that you would like to add items too. <div style="font-size:10px; font-style:italic;"><br />
<br />
Only tabs that are custom lists and HTML windows can be added to, template windows and dynamic windows are not available to edit items. You would need to edit the settings for those windows to filter content. </div><div class="spacer"></div>
                            
                           <? } else  if ($_GET['task'] == 'edit') {?>
                            Click the window you would like to edit<div class="spacer"></div>
                            
                            <? }?>
                             <?  echo $FeedTemplate;?> 

                                       </div>                                  
                             <? } else if (($_GET['step'] == 2) && ($_GET['task'] == 'new')){ ?>
											Set the privacy level of this window: <br />
<br />

                                            <input type="radio" name="Privacy" value="Private" <? if ($_POST['txtPrivacy'] == 'Private') echo 'checked';?>>Private (Only you can see this module)<br>
                                            <input type="radio" name="Privacy" value="Friends" <? if ($_POST['txtPrivacy'] == 'Friends') echo 'checked';?>>Friends (Only Friends can see this module)<br>
                                            <input type="radio" name="Privacy" value="Fans" <? if ($_POST['txtPrivacy'] == 'Fans') echo 'checked';?>>Fans (Only Fans can see this module)<br>
                                            <input type="radio" name="Privacy" value="Public" <? if (($_POST['txtPrivacy'] == 'Public')||($_POST['txtPrivacy'] == '')) echo 'checked';?>>Public (Everyone can see this module)<br>
                                           
                                            <input type="button" onClick="submit_form('5','<? echo $_GET['task'];?>','');" value="NEXT!">                        
                                            
                                 <? } else if (($_GET['step'] == 2) && ($_GET['task'] == 'add')){ ?>
											Below is the current privacy setting of this window. Change below or skip to keep the same.<br />
<br />

                                            <input type="radio" name="Privacy" value="Private" <? if ($WindowArray->Privacy == 'Private') echo 'checked';?>>Private (Only you can see this module)<br>
                                            <input type="radio" name="Privacy" value="Friends" <? if ($WindowArray->Privacy == 'Friends') echo 'checked';?>>Friends (Only Friends can see this module)<br>
                                            <input type="radio" name="Privacy" value="Fans" <? if ($WindowArray->Privacy == 'Fans') echo 'checked';?>>Fans (Only Fans can see this module)<br>
                                            <input type="radio" name="Privacy" value="Public" <? if ($WindowArray->Privacy == 'Public')echo 'checked';?>>Public (Everyone can see this module)<br>
                                           
                                            <input type="button" onClick="submit_form('5','<? echo $_GET['task'];?>','');" value="NEXT!">                        
                                            
                                <? } else if ($_GET['step'] == 3) { ?>
                                          
            
                                         
                                     
                                <? } else if ($_GET['step'] == 4) { ?>
                                           
            
                                             
                                           
                                         
                                <? } else if ($_GET['step'] == 5) { ?>
                                            
           
                                            
                                             WHAT TYPE OF CONTENT WILL GO IN THIS WINDOW? <br><br>

                                            
                                            <input type="radio" name="txtModuleType" value="list" <? if (($_POST['txtModuleType'] == '') || ($_POST['txtModuleType'] == 'list')) echo 'checked';?>/>CUSTOM LIST<br />
                                            A custom list is a list of stuff that you put into this window. No content will be pulled from the Database or fed from another source.<br><br>


                                            
                                            <input type="radio" name="txtModuleType" value="content" <? if ($_POST['txtModuleType'] == 'content') echo 'checked';?>/> DYNAMIC LIST<br />
                                            A dynamic list is pulled from another source like an RSS feed or content on W3 Volt like a 'Top 10 W3Volt Comics' window is pulled straight from our database without any further interaction with you. <br>
<br>

                                            
                                            <? if ($_POST['ContentID'] != '') {?><input type="radio" name="txtModuleType" value="template" <? if ($_POST['txtModuleType'] == 'content') echo 'checked';?>/> W3 WINDOW<br />
											A W3 Window is a template window that we've built that you just plug and play. These include flash templates or imports from another site like Facebook or Twitter. <br>
<br>
<? }?>
                                            
                                            <input type="radio" name="txtModuleType" value="custom" <? if ($_POST['txtModuleType'] == 'custom') echo 'checked';?>/> CUSTOM HTML<br />This is open for you to do anything you want. Write some text / HTML or whatever. This will open an easy to use WSYWIG editor to create the window. <br>
<br>

                                            
                                             <input type="button" onClick="submit_form('6','<? echo $_GET['task'];?>','');" value="NEXT!">
                                          
                                          
                                <? } else if ($_GET['step'] == 6) { ?>
                                        
                                            <? if ($_POST['txtModuleType'] == 'custom') { ?>
                                                <script type="text/javascript">
                                                    submit_form('9','<? echo $_GET['task'];?>','');
                                                </script>
                                            <? } else  if (($_POST['txtModuleType'] == 'list') || ($_POST['txtModuleType'] == 'content')){?>
                                                    WHAT TYPE OF LAYOUT DO YOU WANT THIS MODULE TO HAVE? <br><br>
<strong>TEXT LAYOUTS:<br></strong>

                                                    Title will just show the title of the item, no link or html.<br>
                            						Title / Link layout will just show the title of the item, if a link is supplied then the link will open in a new window.<br>
                                                    Title / Link / Description layout will show the linkable title of the item and a short description below. <br><br>

                                                
                                                    <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','content_list_link');" value="TITLE">&nbsp;&nbsp;
                                                    <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','content_list_link');" value="TITLE / LINK">&nbsp;&nbsp;
                                                    <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','content_list_desc');" value="TITLE/LINK/DESCRIPTION"><br><br>

                                                 <strong>   Thumbnail Layouts:<br>
</strong>											    Thumbnails layout will show a thumbnail only, if link provided this will be clickable. <br>
                                                    Thumbnails / Title layout will show a thumbnail with a title below. <br>
                                                    Thumbnails / Title / Description layout list each item verically with the Thumb left aligned and the Title / Description next to it. <br>
<br>
 
                                                    <input type="button" onClick="submit_form('7','<? echo $_GET['task'];?>','content_thumb');" value="THUMBNAILS">&nbsp;&nbsp;
                                                    <input type="button" onClick="submit_form('7','<? echo $_GET['task'];?>','content_thumb_title');" value="THUMBNAILS W/ TITLE">&nbsp;&nbsp;
                                                   <input type="button" onClick="submit_form('7','<? echo $_GET['task'];?>','content_thumb_title_desc');" value="THUMBNAILS W/ TITLE and DESCRIPTION"><br>
                                                   
                                            <? }?>
                                            
                                <? } else if ($_GET['step'] == 7) { ?>
                                                               WHAT SIZE THUMBNAILS WOULD YOU LIKE? <br>
                                                 For this Module the reccomended size is <? echo $RecSize;?><br>
                                                <select name="thumbsize">
                                                   <option value="25" <? if (($_POST['txtThumbSize'] == '25') || ($RecSize == '25')) echo 'selected';?>>25</option>
                                                   <option value="50"<? if (($_POST['txtThumbSize'] == '50') || ($RecSize == '50')) echo 'selected';?>>50</option>
                                                   <option value="75"<? if (($_POST['txtThumbSize'] == '75') || ($RecSize == '75')) echo 'selected';?>>75</option>
                                                   <option value="100"<? if (($_POST['txtThumbSize'] == '100') || ($RecSize == '100')) echo 'selected';?>>100</option>
                                                   <option value="200"<? if (($_POST['txtThumbSize'] == '200') || ($RecSize == '200')) echo 'selected';?>>200</option>
                                                 </select>
                                                 <input type="button" onClick="submit_form('8','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="PREVIEW">
                                                <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="NEXT!">
                                            
                                <? } else if ($_GET['step'] == 8) { ?>
                                
                                             <?
                                             echo $FeedTemplate;?>
                                         <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="NEXT!"><br>
                                        <input type="button" onClick="submit_form('7','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="BACK TO SIZE"><br>
                                           
                                <? 	} else if ($_GET['step'] == 9) { ?>
                                          	Enter a title for the window. <br />
<blockquote>This title will appear in the tab and is limited to 20 characters. However you can also add a description to this tab that will appear when the user hovers over the tab.</blockquote>
Window Name<br />

                                               	 <input type="text" size="10" name="Name" value="<? echo $_POST['Name'];?>"> <br /><br />

 Window Description<br /><textarea name="Description"  style="width:300px;height:50px;"><? echo $_POST['Description'];?></textarea><br />
<br />

Window Tags<br /><textarea name="Tags"  style="width:300px;height:50px;"><? echo $_POST['Tags'];?></textarea><br />
<br />

                                 				 <input type="checkbox" name="main" value="1" class="styled" <? if (($_POST['txtMain'] == '1') || ($_POST['main'] == '1')) echo 'checked="checked"';?>/>Make this Window the main tab <br>
                                                 <br />

<input type="button" onClick="submit_form('10','<? echo $_GET['task'];?>','');" value="NEXT!">

                                 		 <? 	} else if ($_GET['step'] == 10) { ?>	
                                    
                                            <div style="height:10px;"></div>
                                             ARE THE FOLLOWING SETTINGS CORRECT?<br><br>
                                 
                                             Feed Tab Name: <? echo $_POST['Name'];?><br/>
                                             <? if ($_POST['Description'] != ''){?>
                                             Description: <? echo $_POST['Description'];?><br/>
                                             
                                             <? }?>
                                              <? if ($_POST['Tags'] != ''){?>
                                             Tags: <? echo $_POST['Tags'];?><br/>
                                             
                                             <? }?>
                                             Target Cell: <? if ($_POST['txtModuleID'] != '') echo $_POST['txtModuleID']; else if ($_POST['CellID'] != '') echo $_POST['CellID'];?><br/>
                                             Layout Style: <? echo ucwords(str_replace("_", " ",$_POST['txtLayout']));?><br/>
                                             Privacy Settings Style: <? echo $_POST['txtPrivacy'];?><br/>
                                             Main Window: <? if ($_POST['main'] == 1) echo 'Yes'; else echo 'No';?><br />
<br />

											 
                                              If so, finish creating your module and start adding items to it.<br>
                                            <? if ($_GET['task'] == 'new') {?>
                                            
                                                 <input type="button" onClick="submit_form('finish','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="CREATE MODULE AND ADD ITEMS"><br/><br>
                                      
                                            <? } else {?>
                                                   <input type="button" onClick="submit_form('finish','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="SAVE MODULE AND ADD ITEMS"><br/>
                                                   <input type="button" onClick="submit_form('quit','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="SAVE MODULE AND EXIT"><br/><br>
                                      
                                             <? }?>
                        
                                              <input type="button" onClick="submit_form('9','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="EDIT NAME"><br/>
                                              <input type="button" onClick="submit_form('1','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="EDIT MODULE PLACEMENT"><br/>
                                              <input type="button" onClick="submit_form('2','<? echo $_GET['task'];?>','<? echo $_POST['txtLayout'];?>');" value="EDIT PRIVACY SETTINGS"><br/>
                                              <input type="hidden" name="save" value="1" />
                                            
                                          
                                <? } else if ($_GET['step'] == 'add') { ?> 
                                            <div style="padding-left:20px;">
                                          
                                       <? include 'includes/feed_entry_form_inc.php';?>
                                       </div>
                                          
                                <? } ?>
                                </div>
                                 
                                 <!--NAV BUTTONS-->
                                 <div>
           						                         <img src="http://www.w3volt.com/images/back_button.jpg" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<? if ($_GET['step'] == 1) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_1.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_1_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 2) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_2.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_2_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 3) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_3.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_3_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 4) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_4.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_4_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 5) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_5.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_5_off.png" />
								<?  }?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? if ($_GET['step'] == 6) {?>
                                    <img src="http://www.w3volt.com/images/wizard_step_6.png" />
								<? } else { ?>
									<img src="http://www.w3volt.com/images/wizard_step_6_off.png" />
								<?  }?>

                                </div>
                                <input type="hidden" name="txtName" value="<? if ($_POST['txtName'] != '') echo $_POST['txtName']; else if ($_POST['Name'] != '')echo $_POST['Name'];?>">
                                <input type="hidden" name="txtWindowDescription" value="<? if ($_POST['txtWindowDescription'] != '') echo $_POST['txtWindowDescription']; else if ($_POST['Description'] != '')echo $_POST['Description'];?>">
                                <input type="hidden" name="txtWindowTags" value="<? if ($_POST['txtWindowTags'] != '') echo $_POST['txtWindowTags']; else if ($_POST['Tags'] != '')echo $_POST['Tags'];?>">
<input type="hidden" name="txtModuleID" value="<? if ($_POST['txtModuleID'] != '') echo $_POST['txtModuleID']; else if ($_GET['module'] != '')echo $_GET['module'];?>">
<input type="hidden" name="TargetWindow" id="TargetWindow" value="<? if ($_POST['TargetWindow'] != '') echo $_POST['TargetWindow']; else if ($_GET['window'] != '')echo $_GET['window'];?>">
<input type="hidden" name="CellID" id="CellID" value="<? if ($_POST['CellID'] != '') echo $_POST['CellID']; else if ($_GET['cell'] != '')echo $_GET['cell'];?>">

<input type="hidden" name="txtPrivacy" value="<? if ($_POST['txtPrivacy'] != '') echo $_POST['txtPrivacy']; else if ($_POST['Privacy'] != '')echo $_POST['Privacy'];?>">
<input type="hidden" name="txtModule" value="<? if ($_POST['txtModule'] != '') echo $_POST['txtModule']; else if ($_POST['Module'] != '')echo $_POST['Module'];?>">
<? if (($_GET['step'] != 'add_return') && ($_GET['step'] !='add_exit')) { ?>
<input type="hidden" id ="ContentType" name="ContentType" value="<? if ($_GET['ctype'] != '') echo $_GET['ctype']; else if ($_POST['ContentType'] != '')echo $_POST['ContentType'];?>">
<input type="hidden" name="RefTitle" value="<? if ($_GET['title'] != '') echo $_GET['title']; else if ($_POST['RefTitle'] != '')echo $_POST['RefTitle'];?>">
<input type="hidden" name="ContentID" id="ContentID" value="<? if ($_GET['content'] != '') echo $_GET['content']; else if ($_POST['ContentID'] != '')echo $_POST['ContentID'];?>">
<input type="hidden" name="Link" value="<? if ($_GET['link'] != '') echo $_GET['link']; else if ($_POST['Link'] != '')echo $_POST['Link'];?>">

<input type="hidden" name="txtTab" value="<? if ($_POST['txtTab'] != '') echo $_POST['txtTab']; else if ($_POST['Tab'] != '')echo $_POST['Tab'];?>">
<input type="hidden" name="txtThumbSize" value="<? if ($_POST['txtThumbSize'] != '') echo $_POST['txtThumbSize']; else if ($_POST['thumbsize'] != '')echo $_POST['thumbsize'];?>">
<input type="hidden" name="txtMain" value="<? if ($_POST['txtMain'] != '') echo $_POST['txtMain']; else if ($_POST['main'] != '') echo $_POST['main'];?>">
<input type="hidden" name="txtLayout" id="txtLayout" value="<? echo $_POST['txtLayout'];?>">
<? if ($_GET['step'] != 5) { ?>
<input type="hidden" name="txtModuleType" id="txtModuleType" value="<? echo $_POST['txtModuleType'];?>">
<? }?>
<? }?>
</form>
                        </div>
   <? if ($RePost == 1) {?>
   <script type="text/javascript">
  		 submit_form('add','<? echo $ModuleID;?>','');
   </script>
   
   
   <? }?>        
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
parent.close_wizard(); 
</script>

<? }?>                
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


			


<?php include 'includes/footer_template_new.php';?>
