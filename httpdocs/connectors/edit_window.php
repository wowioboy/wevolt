<?php 

include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';?>

<?

$Name = $_GET['name'];
$ProjectType = $_GET['type'];

if (($Name == '') && ($ProjectType == '')){
	$Name = $_SESSION['username'];
}
$RePost = 0;

$DB = new DB();
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
			  where f.UserID='$UserID' and f.FeedType='w3'";
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
			  where f.ProjectID='$ProjectID' and f.FeedType='w3'";
	  
	$FeedArray = $DB->queryUniqueObject($query);
	
}
	
if (($_SESSION['userid'] == '') || ($UserID != $_SESSION['userid']))
	$CloseWindow = 1;

$FeedID = $FeedArray->EncryptID;
$FeedTemplate = $FeedArray->HtmlLayout;
$TemplateID = $FeedArray->TemplateID;	
$TotalLength = strlen($FeedTemplate);
$query = 'SELECT 

$CloseWindow = 0;

if (($_GET['step'] == 'add_return') || ($_GET['step'] =='add_exit')) { 
		$CellID = $_POST['CellID'];	
		$Title = mysql_real_escape_string($_POST['txtTitle']);
		$Content = mysql_real_escape_string($_POST['content']);
		$Tags = mysql_real_escape_string($_POST['txtTags']);
		$Description = mysql_real_escape_string($_POST['txtDescription']);
		$UserID = $_SESSION['userid'];
		$CreateDate = date('Y-m-d h:i:s');
		$ModuleID = $_POST['txtModuleID'];
		$ContentType = $_POST['ContentType'];
		$ContentID = $_POST['ContentID'];
		$Thumb = $_POST['txtThumb'];
		$Link = $_POST['txtLink'];
		$contentSubSelect = $_POST['contentSubSelect'];
		$contentSelect = $_POST['contentSelect'];
		$contentNumSelect = $_POST['contentNumSelect'];
		$EmbedCode = mysql_real_escape_string($_POST['txtEmbed']);
		$EmbedDimensions = getDimensions($_POST['txtEmbed']);
		$EmbedWidth = $EmbedDimensions['width'];
		$EmbedHeight = $EmbedDimensions['height'];
		
		if ($ContentType == 'project') {
			$ContentType = 'project_link';
			$ProjectID = $ContentID;
		} else if ($ContentType == 'user') {
			$ContentType = 'user_link'; 
		
		} else {
			$ContentType = 'external_link';
		}
		if ($Content != ''){
				$query = "UPDATE feed_modules set HTMLCode='$Content' where EncryptID='$ModuleID' and FeedID='$FeedID'";
				$DB->execute($query);
				$CloseWindow = 1;
					
			//print $query.'<br/>';
		} else if ($contentSelect != '') {
		
		$query = "UPDATE feed_modules set ContentVariable='$contentSelect', SortVariable='$contentSubSelect', NumberVariable='$contentNumSelect' where EncryptID='$ModuleID' and FeedID='$FeedID'";
				$DB->execute($query);
				$CloseWindow = 1;
		
		//print $query.'<br/>';
		
		} else {
					 $query ="SELECT Position from feed_items WHERE Position=(SELECT MAX(Position) FROM feed_items where ModuleID='$ModuleID' and FeedID='$FeedID')";
					$NewPosition = $DB->queryUniqueValue($query);
					$NewPosition++;
				//	print $query.'<br/>';
				$query = "INSERT into feed_items (WeModule, Title, FeedID, CreatedDate, Tags,ItemType, Link, Description,UserID, Position, ProjectID,Thumb,Embed,EmbedWidth,EmbedHeight,We) values ('$ModuleID','$Title','$FeedID','$CreateDate','$Tags','$ContentType','$Link','$Description','".$_SESSION['userid']."','$Position','$ProjectID','$Thumb','$EmbedCode','$EmbedWidth','$EmbedHeight',1)";
					$DB->execute($query);
					//print $query.'<br/>';	
					$query = "SELECT ID from feed_items where CreatedDate='$CreateDate' and FeedID='$FeedID'";
					$ItemID = $DB->queryUniqueValue($query);
					//	print $query;
					$Encryptid = substr(md5($ItemID), 0, 12).dechex($ItemID);
					//print $query.'<br/>';
					$query = "UPDATE feed_items set EncryptID='$Encryptid' where ID='$ItemID'";
						//print $query;
					$DB->execute($query);
					insertUpdate('window', 'added', $Encryptid, 'user', $UserID,'http://users.wevolt.com/'.trim($_SESSION['username']).'/?window='.$ModuleID);
					//print $query.'<br/>';
					/*
					if ($_GET['step'] =='add_return')
						header("Location:/connectors/feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
					//$CloseWindow = 1;
				
					else 
						$CloseWindow = 1;
						*/
			}

}

if ($_GET['step'] == 'add') {
	if ($_POST['TargetWindow'] != 1) {
		$TargetWindow = $_POST['TargetWindow'];
		if ($TargetWindow  == '')
			$TargetWindow = $_GET['module'];
		$query = "SELECT * from feed_modules where EncryptID='".$TargetWindow."'";
		$WindowArray = $DB->queryUniqueObject($query);
		$Thumb =  '';
	}
}
$Step = $_GET['step'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Update Excite Status</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="http://<? echo $_SERVER['SERVER_NAME'];?>/ajax/ajax_init.js"></script>
 <style type="text/css">
 body,html {
	margin:0px;
	padding:0px; 
	 
 }
 
 </style>
  <script>
function closeWindow() 
{
	var href = parent.window.location.href;
	href = href.split('#');
	href = href[0];
	parent.window.location = href;
}
</script>
<script type="text/javascript">
function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 
 document.getElementById("search_results").innerHTML=xmlHttp.responseText;
 document.getElementById('search_container').style.display='';

 } 
}
function display_data(keywords) {

    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null) {
        alert ("Your browser does not support AJAX!");
        return;
    }
	
	for (var i=0; i < document.modform.txtContent.length; i++){
  		 if (document.modform.txtContent[i].checked){
     		 var content = document.modform.txtContent[i].value;
     	 }
   }
    var url="http://www.wevolt.com/connectors/getSearchResults.php";
    url=url+"?content="+content+"&keywords="+escape(keywords);
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete") {
            document.getElementById('search_results').innerHTML=xmlhttp.responseText;
			document.getElementById('search_container').style.display='';
        }
    }
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}	
var timer = null;
function checkIt(keywords) {
    if (timer) window.clearTimeout(timer); // If a timer has already been set, clear it
    timer = window.setTimeout(display_data(keywords), 2000); // Set it for 2 seconds
    //Just leave the method and let the timer do the rest...
}
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

		var formaction = '/connectors/feed_wizard.php?<? echo $TypeTarget;?>=<? echo $TargetID;?>&step='+step;
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

var Template = '<? echo $WindowArray->ModuleTemplate;?>';
function select_link(value) {

	if (value == 'search') {
		document.getElementById("searchupload").style.display = '';
		document.getElementById("urlupload").style.display = 'none';
		//document.getElementById("searchtab").className ='tabactive';
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
	} else if (value == 'url') {
		document.getElementById("urltab").className ='tabactive';
		document.getElementById("urlupload").style.display = '';
		//document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabinactive';
		
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
		
	} else if (value == 'my') {
	
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
	
	//document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabactive';
		document.getElementById("myupload").style.display = '';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
	
		
		
	} else if (value == 'fav') {
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
		//document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
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
		document.getElementById("txtTitle").value = title;
		document.getElementById("txtDescription").value = description;
		document.getElementById("txtTags").value = tags;
		document.getElementById("txtLink").value = contentlink;
		document.getElementById("search_container").style.display = 'none';
		document.getElementById("search_results").innerHTML = '';

		if ((Template == 'content_thumb_title') || (Template == 'content_thumb')|| (Template == 'content_thumb_title_description') ||(Template == 'content_thumb_title_desc') ) {
	
			document.getElementById("thumbselect").style.display = 'none';
			document.getElementById("thumbdisplay").style.display = '';
			document.getElementById("itemthumb").src = contentthumb;
			document.getElementById("txtThumb").value = contentthumb;
		}
}
 
 
function show_thumb(value) {
	document.getElementById("previewthumb").width = value;	
}

</script>

</head><body>

        
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center">

<div style="height:15px;"></div>
<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                        <img src="http://www.wevolt.com/images/window_wizard_banner.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
               <div style="height:10px;"></div>

                                    
                               
                               <div align="center">
                         
                                             
                                              <input type="hidden" name="save" value="1" />
                                            
                                          
                             
                                    
                                          
                                       <? include $_SERVER['DOCUMENT_ROOT'].'/includes/feed_entry_form_inc.php';?>
                                   
                       
<input type="hidden" name="txtModuleID" value="<? if ($_POST['txtModuleID'] != '') echo $_POST['txtModuleID']; else if ($_GET['module'] != '')echo $_GET['module'];?>">
<input type="hidden" name="CellID" id="CellID" value="<? if ($_POST['CellID'] != '') echo $_POST['CellID']; else if ($_GET['cell'] != '')echo $_GET['cell'];?>">
<input type="hidden" name="txtPrivacy" value="<? if ($_POST['Privacy'] != '') echo $_POST['Privacy']; else if ($_POST['txtPrivacy'] != '')echo $_POST['txtPrivacy'];?>">
</form>
                        
                        </div>
    
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
closeWindow();
</script>

<? }?>                
</body>
</html>