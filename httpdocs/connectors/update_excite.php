<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
include $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';
$DB = new DB();
$RePost = 0;
$UserID = $_SESSION['userid'];
$CloseWindow = 0;
if ($_SESSION['userid'] == '')
	$CloseWindow = 1;

if ($_GET['id'] != '') {
	if (($_GET['type'] == 'undefined') && ($_GET['cat'] == 'undefined')) {
		$query = "SELECT * from projects where ProjectID='".$_GET['id']."'";
		$ProjectArray = $DB->queryUniqueObject($query);
		$Headline = $ProjectArray->title;
	
		$Thumb = 'http://www.wevolt.com.'.$ProjectArray->thumb;
		$Link = 'http://www.wevolt.com/'.$ProjectArray->SafeFolder.'/';
		$ExciteType= 'project';

	} else {
			$ExciteType= $_GET['type'];
			if ($_GET['type'] == 'forum topic') {
				$query = "SELECT t.*, u.avatar as Thumb
				          from pf_forum_topics as t
						  join users as u on t.PosterID=u.encryptid
						  where t.EncryptID='".$_GET['id']."'";	
				$ProjectArray = $DB->queryUniqueObject($query);
				$ForumOwner = $ProjectArray->UserID;
				$ForumProject =  $ProjectArray->ProjectID;
				$Headline = $ProjectArray->Subject;
				$Thumb = $ProjectArray->Thumb;
				if ($_GET['cat'] == 'user') {
					$query = "SELECT * from users where encryptid='$ForumOwner'";
					$TargetArray = $DB->queryUniqueObject($query);
					$ForumTarget = 'user='.$TargetArray->username;
				} else if ($_GET['cat'] == 'project') {
					$query = "SELECT * from projects where ProjectID='$ForumProject'";
					$TargetArray = $DB->queryUniqueObject($query);
					$ForumTarget = 'project='.$TargetArray->username;
				}
					
				$Link = 'http://www.wevolt.com/forum/index.php?'.$ForumTarget.'&a=read&topic='.$ProjectArray->ID;
			} else if ($_GET['type'] == 'cal_entry') {
				$query = "SELECT c.*, u.avatar as UThumb
				          from calendar as c
						  join users as u on c.user_id=u.encryptid
						  where c.encrypt_id='".$_GET['id']."'";	
				$ProjectArray = $DB->queryUniqueObject($query);
				$Headline = $ProjectArray->title;
				$Thumb = $ProjectArray->thumb;
				if ($Thumb == '')
					$Thumb = $ProjectArray->UThumb;
					
				
				$Link = 'http://www.wevolt.com/view_event.php?action=view&id='.$ProjectArray->id;
			}
	}
}
if ($_POST['save'] == 1) { 
		$ContentID = $_POST['ContentID'];
		$Title = mysql_real_escape_string($_POST['txtName']);
		$Tags = mysql_real_escape_string($_POST['txtTags']);
		$Comment = mysql_real_escape_string($_POST['txtComment']);
		$Blurb= mysql_real_escape_string($_POST['txtBlurb']); 
		$UserID = $_SESSION['userid'];
		$CreateDate = date('Y-m-d h:i:s');
		$IsFront = $_POST['txtFront'];
		$ContentType = $_POST['ContentType'];
		$LinkTarget = $_POST['txtLinkTarget'];
		$Link = $_POST['txtLink'];
		$Thumb = $_POST['txtThumb'];
		
		if ($IsFront == '')
			$IsFront = 0;
			
			$query = "INSERT into excites (UserID, ContentID, ContentType, CreatedDate, Link, Tags, Comment, Blurb, OnFront,Thumb,Target) values ('$UserID','$ContentID','$ContentType','$CreateDate','$Link','$Tags','$Comment','$Blurb', '$IsFront','$Thumb','$LinkTarget')";
			$DB->execute($query);
			//print $query.'<br/>';
			$query = "SELECT ID from excites where CreatedDate='$CreateDate' and UserID='$UserID'";
			$NewID = $DB->queryUniqueValue($query);
			//print $query.'<br/>';
			$Encryptid = substr(md5($NewID), 0, 15).dechex($NewID);
			$IdClear = 0;
			$Inc = 5;
			while ($IdClear == 0) {
							$query = "SELECT count(*) from excites where EncryptID='$Encryptid'";
							$Found = $DB->queryUniqueValue($query);
							$output .= $query.'<br/>';
							if ($Found == 1) {
								$Encryptid = substr(md5(($NewID+$Inc)), 0, 15).dechex($NewID+$Inc);
							} else {
								$query = "UPDATE excites SET EncryptID='$Encryptid' WHERE ID='$NewID'";
								$DB->execute($query);
								$output .= $query.'<br/>';
								$IdClear = 1;
							}
							$Inc++;
			}
			
			insertUpdate('excite', 'updated', $Encryptid, 'user', $UserID,$Link,'',$_POST['txtBlurb']);
			$CloseWindow = 1;


}
if ($CloseWindow == 0) {
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

$query =  "SELECT c.*, f.*
FROM favorites as f
JOIN projects as c on f.ProjectID=c.ProjectID
WHERE f.userid = '$UserID' and c.Hosted=1 and c.Published=1 ORDER BY c.title DESC";
$DB->query($query);

$counter = 0;
$numberComics = $DB->numRows();
$FavContent = '<div style="width:100%;">';
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
				$Description = preg_replace("/\r?\n/", "\\n", addslashes($line->synopsis)); 
$FavContent .='<a href="javascript:void(0)"onClick=\"set_content(\''.addslashes(str_replace('"',"'",$line->title)).'\',\''.$line->ProjectID.'\',\''.$comicURL.'\',\''.$fileUrl.'\',\'comic\',\''.addslashes(str_replace('"',"'",$line->synopsis)).'\',\''.addslashes(str_replace('"',"'",$line->Tags)).'\');\"><img src="'.$fileUrl.'" border="2" alt="LINK" style="border:1px solid #000000;" width="50" hspace="3" vspace="3"></a>'; 
			 $counter++;
 			
	}
	
	 
	 if ($numberComics == 0) {
	 		$FavContent = '<div class="favs" style="text-align:center;padding-top:25px;height:200px;">There are currently no active projects for this user</div>';
	 }
}
$DB->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Update Excite Status</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="http://www.wevolt.com/ajax/ajax_init.js"></script>
<style type="text/css">
/* <![CDATA[ */
textarea { clear: both; font-family: sans-serif; font-size: 1em; width: 275px;}
/* ]]> */
</style>



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
	
	
	 var content =  document.modform.txtContent.value;

	//for (var i=0; i < document.modform.txtContent.length; i++){
  		// if (document.modform.txtContent[i].checked){
     		// var content = document.modform.txtContent[i].value;
     	// }
  // }
    var url="/connectors/getSearchResults.php";
    url=url+"?content="+content+"&keywords="+escape(keywords);
	//alert(url);
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete") {
            document.getElementById('search_results').innerHTML=xmlhttp.responseText;
			//alert(xmlhttp.responseText);
			document.getElementById('search_container').style.display='';
        }
    }
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}	
var timer = null;
function checkIt(keywords) {
    if (timer) window.clearTimeout(timer); // If a timer has already been set, clear it
	if (keywords != '') 
    timer = window.setTimeout(display_data(keywords), 2000); // Set it for 2 seconds
    //Just leave the method and let the timer do the rest...
}
function submit_form() {
			
	if (document.getElementById("txtBlurb").value == '') 
		alert('Please Enter a short blurb');
	else if (document.getElementById("txtLink").value == '')
	  	alert('Please enter a link');
	else 
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

	if (value == 'search') {
		document.getElementById("searchupload").style.display = '';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("linktargetdiv").style.display = 'none';
		document.getElementById("searchtab").className ='tabactive';
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		document.getElementById("thumbselect").style.display = 'none';
		
	} else if (value == 'url') {
		document.getElementById("urltab").className ='tabactive';
		document.getElementById("thumbselect").style.display = '';
		document.getElementById("urlupload").style.display = '';
		document.getElementById("linktargetdiv").style.display = '';
		document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabinactive';
		
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		
		
	} else if (value == 'my') {
	
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
	document.getElementById("linktargetdiv").style.display = 'none';
	document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		
		document.getElementById("mytab").className ='tabactive';
		document.getElementById("myupload").style.display = '';
		document.getElementById("favtab").className ='tabinactive';
		document.getElementById("favupload").style.display = 'none';
		document.getElementById("thumbselect").style.display = 'none';
	
		
		
	} else if (value == 'fav') {
		document.getElementById("urltab").className ='tabinactive';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("linktargetdiv").style.display = 'none';
		document.getElementById("searchtab").className ='tabinactive';
		document.getElementById("searchupload").style.display = 'none';
		document.getElementById("mytab").className ='tabinactive';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favtab").className ='tabactive';
		document.getElementById("favupload").style.display = '';
		document.getElementById("thumbselect").style.display = 'none';
		
	}



}

function set_content(title, contentid, contentlink, contentthumb,contenttype,description,tags) {
		
		
		//ERROR FROM HERE SOMEWHERE
		document.getElementById("contentmenu").style.display = 'none';
		document.getElementById("ContentType").value = contenttype;
		document.getElementById("ContentID").value = contentid;
		document.getElementById("txtBlurb").value = title;
		document.getElementById("txtComment").value = description;
		document.getElementById("txtTags").value = tags;
		document.getElementById("txtLink").value = contentlink;
		document.getElementById("urltitle").style.display = 'none';
		document.getElementById("linktargetdiv").style.display = 'none';
			document.getElementById("thumbselect").style.display = 'none';
			document.getElementById("searchupload").style.display = 'none';
		    document.getElementById("myupload").style.display = 'none';
		    document.getElementById("favupload").style.display = 'none';
			document.getElementById("search_container").style.display = 'none';
			document.getElementById("search_results").innerHTML = '';
			
			document.getElementById("thumbdisplay").style.display = '';
			document.getElementById("itemthumb").src = contentthumb;
			document.getElementById("txtThumb").value = contentthumb;
			document.getElementById("resetformdiv").style.display = '';
			document.getElementById("changeimagediv").style.display = 'none';
			//select_link('url');
		
}

function reset_form() {
	select_link('url');
	document.getElementById("thumbdisplay").style.display = 'none';	
	document.getElementById("urltitle").style.display = '';
		document.getElementById("contentmenu").style.display = '';
		document.getElementById("ContentType").value = '';
		document.getElementById("ContentID").value = '';
		document.getElementById("txtBlurb").value = '';
		document.getElementById("txtComment").value = '';
		document.getElementById("txtTags").value = '';
		document.getElementById("txtLink").value = '';
		document.getElementById("urltitle").style.display = '';
		document.getElementById("itemthumb").src = '';
			document.getElementById("txtThumb").value = '';
	
}
 
function change_thumb() {
	document.getElementById("thumbdisplay").style.display = 'none';	
		document.getElementById("itemthumb").src = '';
			document.getElementById("txtThumb").value = '';
			document.getElementById("thumbselect").style.display = '';

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
</script>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
  <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
</head>
<body>
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center"> 
<div class="spacer"></div>
<table width="608" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="592" align="center">
                                        <img src="http://www.wevolt.com/images/excite_edit_header.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
var href = parent.window.location.href;
href = href.split('#');
href = href[0];
parent.window.location = href;
//parent.$.modal().close();
</script>
 
<? } else {?>

<form name="modform" id="modform" method="post" action="#">
              
   <div>
                                         
<div style="height:10px;"></div>

<table><tr><td valign="top"><table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="184" align="left">
                                        1. Headline<br>
<textarea style="width:180px; height:25px;" name="txtBlurb" id="txtBlurb"><? echo $Headline;?></textarea><div style="height:5px;"></div>
2. Comment<br>
<textarea rows="1"  style="width:180px; height:80px" name="txtComment" id="txtComment"  ></textarea>
<div style="height:5px;"></div><div class="messageinfo_white">
 3. Tags
Enter Tags (separate with a ',')</div>
<textarea rows="1"  style="width:180px; height:70px;" name="txtTags" id="txtTags" onfocus="doClear(this)" onblur="setDefault(this)"></textarea><div style="height:5px;"></div>

<? if (in_array($_SESSION['userid'],$SiteAdmins)) {?>
<div class="messageinfo_white">
<input type="checkbox" name="txtFront" value="1" />Post Excite to Front Page</div>
<? }?><div style="height:10px;"></div>
                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                        
                                        </td>
                                        <td width="10"></td>
                                        
                                        <td valign="top"><center><img src="http://www.wevolt.com/images/wizard_done_btn.png" onclick="submit_form();" class="navbuttons" />     <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="parent.$.modal().close();" class="navbuttons"/><div style="height:5px;"></div></center>
                                        <table width="375" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>

										<td class="wizardboxcontent" valign="top" width="366" align="center">
                                       



<div class="messageinfo_white" align="left">4. LINK</div>
 <div id='urltitle'><? if (($_POST['Link'] == '') && ($Link == '')) {?>
<div style="font-size:10px; width:98%;" class="messageinfo_white" align="left">(enter an external link or select content from WeVOLT)</div></div><div style="height:10px;"></div>


<div align="center" id="contentmenu">
<table cellpadding="0" cellspacing="0" border="0"><tr>
<td id='urltab' class='tabactive' height="30" onClick="select_link('url')" onMouseOver="rolloveractive('urltab','urlupload')" onMouseOut="rolloverinactive('urltab','urlupload')" >URL</td><td width="5"></td>
<td id='mytab' class='tabinactive' height="30" onClick="select_link('my')" onMouseOver="rolloveractive('mytab','myupload')" onMouseOut="rolloverinactive('mytab','myupload')" >REvolts</td>

<td width="5"></td>

<td id='favtab' class='tabinactive' height="30" onClick="select_link('fav')" onMouseOver="rolloveractive('favtab','favupload')" onMouseOut="rolloverinactive('favtab','favupload')" >VOLTS</td>

<td width="5"></td>

<td id='searchtab' class='tabinactive' height="30" onClick="select_link('search')" onMouseOver="rolloveractive('searchtab','searchupload')" onMouseOut="rolloverinactive('searchtab','searchupload')" >SEARCH</td>

</tr></table></div>
<div id="urlupload" style="font-size:12px;" align="left">
<div style="height:5px;"></div>
Enter full link including http://<br/>
<input type="text" style="width:98%;" id="txtLink" name="txtLink" value="<? if ($_POST['Link'] == '') echo 'http://'; else echo $_POST['Link'];?>" ><div style="height:10px;"></div>
</div>
<? } else {
	if ($Link == '')
		echo '<div align="left">'.$_POST['Link'].'</div>';
	else
		echo '<div align="left">'.$Link.'</div>';
}
	?>
    <div align="left" id="linktargetdiv" <? if (($_GET['type'] == 'forum topic') || ($_GET['type'] == 'cal_entry')){?>style="display:none;"<? }?>><div style="height:5px;"></div>
    <select name="txtLinkTarget">
    <option value="_parent" selected>Same Page</option>
    <option value="_blank">New Page</option>
    </select>
    </div>
    <div style="height:5px;"></div>
<div id="thumbselect" align="left" class="messageinfo_white"<? if (($ExciteType == 'project') ||($ExciteType == 'forum topic') || ($_GET['type'] == 'cal_entry')){?> style="display:none;"<? }?>>
<div style="height:10px;"></div>
   5. UPLOAD THUMBNAIL 
    <iframe id='loaderframe' name='loaderframe' height='50px' width="350px" frameborder="no" scrolling="no" src="/includes/media_upload_inc.php?compact=yes&transparent=1&uploadaction=user_thumb" allowtransparency="true"></iframe><div style="height:10px;"></div>
   

</div>
<div id="thumbdisplay" <? if ($Thumb == '') {?>style="display:none;"<? }?> class="messageinfo_white"> 

<table cellpadding="5"><tr><td align="center" class="messageinfo_warning">Current<br />
Thumb:</td><td width="100" align="center"><img src="<? echo $Thumb;?>" id="itemthumb" width="75" style="border:#000000 2px solid;"/></td><td class="messageinfo_white"><div id="resetformdiv" style="display:none;"><a href="#" onclick="reset_form();">[RESET]</a></div><div id="changeimagediv"><a href="#" onclick="change_thumb();">[CHANGE THUMB]</a></div></td></tr></table>
</div>  
<div id="myupload" style="font-size:12px;height:180px;display:none; width:98%; overflow:auto;">
<div style="height:5px;"></div>
<? echo $UserContent;?>
</div>

<div id="searchupload"  style="font-size:12px;display:none;" class="messageinfo">

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
<div id="search_results" style="height:118px; overflow:auto;width:98%;"></div></div>
</div>



<div id="favupload" style="display:none;font-size:12px; height:180px; width:98%; overflow:auto;">
<? echo $FavContent;?>
</div>

  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                                        
                                        </td>
                                      </tr></table>
<? if (($_POST['Link'] != '') || ($Link != '')) {?>
<input type="hidden" style="width:98%;" id="txtLink" name="txtLink" value="<? if ($Link != '') echo $Link; else if ($_POST['Link'] == '') echo 'http://'; else echo $_POST['Link'];?>" >
<? }?>
<input type="hidden" id ="ContentType" name="ContentType" value="<? if (($_GET['type'] != '') && ($_GET['type'] != 'undefined')) echo $_GET['type']; else if ($_GET['ctype'] != '') echo $_GET['ctype']; else if ($_POST['ContentType'] != '')echo $_POST['ContentType'];?>">
<input type="hidden" name="ContentID" id="ContentID" value="<? if ($_GET['id'] != '') echo $_GET['id']; else if ($_GET['content'] != '') echo $_GET['content']; else if ($_POST['ContentID'] != '')echo $_POST['ContentID'];?>">
<input type="hidden" name="txtThumb" id="txtThumb" value="<? echo $Thumb;?>"/>
<input type="hidden" name="save" value="1" />
</div>
</div>
</form>

<? }?>

</body>
</html>