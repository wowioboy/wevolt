<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

function getDimensions($object) 
{
 $widthRe = '/width[ ]*[:|=][ ]*[\'|"]?[ ]*\d+/i';
 $heightRe = '/height[ ]*[:|=][ ]*[\'|"]?[ ]*\d+/i';
 $digitRe = '/\d+/';
 preg_match($widthRe, $object, $width);
 preg_match($digitRe, $width[0], $width);
 preg_match($heightRe, $object, $height);
 preg_match($digitRe, $height[0], $height);
 $width = array_shift($width);
 $height = array_shift($height);
 return array('height' => $height, 'width' => $width);
}
$RePost = 0;
if ($_GET['window'] != '')
	$WindowTarget = explode('-',$_GET['window']);
else 
	$WindowTarget = explode('-',$_POST['WindowID']);
$ItemID=$_POST['ItemID'];
$WindowID = $WindowTarget[1];
$CellID = $WindowTarget[0];
//print_r($WindowTarget);
$WindowType = $_GET['stype'];
if ($WindowType == '')
	$WindowType = $_POST['WindowType'];
$WindowSection = $_GET['section'];
if ($WindowSection == '')
	$WindowSection = $_POST['WindowSection'];
	
if ($WindowSection == 'myvolt') {
	$FeedItemTarget = 'MyModule';
	$FeedTarget = 'MyFeed';
	$FlagTarget = 'My';	
	$PositionTarget = 'MyPosition';
} else if ($WindowSection == 'wevolt') {
	$FeedItemTarget = 'WeModule';
	$FlagTarget = 'We';	
	$FeedTarget = 'WeFeed';
	$PositionTarget = 'WePosition';
} 
$Action = $_GET['action'];
$RePost = 0;
$UserID = $_SESSION['userid'];
$CloseWindow = 0;
if ($_SESSION['userid'] == '')
	$CloseWindow = 1;

$DB = new DB();

if ($WindowSection == 'myvolt') {
	$query = "SELECT * from feed where UserID='$UserID' and FeedType='my'"; 
	$FeedArray = $DB->queryUniqueObject($query);
} else if ($WindowSection == 'wevolt') {
	$query = "SELECT * from feed where UserID='$UserID' and FeedType='w3'"; 
	$FeedArray = $DB->queryUniqueObject($query);
}
$FeedID = $FeedArray->EncryptID;

$query = "SELECT * from feed_modules where FeedID='$FeedID' and EncryptID = '$WindowID'"; 
$ContentWindowArray = $DB->queryUniqueObject($query);
$ModuleTemplate = $ContentWindowArray->ModuleTemplate;
$CloseWindow = 0;

function move_up($WindowID, $FeedItemTarget, $FeedID, $FeedTarget,$ItemID,$DB, $PositionTarget) {
	$CurrentOrder = array();
	$i=0;
	$query = "SELECT * from feed_items where $FeedItemTarget='$WindowID' and $FeedTarget='$FeedID' order by $PositionTarget"; 
	$DB->query($query);
	while ($line = $DB->fetchNextObject()) { 
		$CurrentOrder[] = $line->EncryptID;
		if ($line->EncryptID == $ItemID) {
			$ArrayPosition = $i;
		}
		$i++;
	}
	$TotalLinks = $DB->numRows();
	$query = "SELECT $PositionTarget from feed_items where EncryptID='$ItemID' and $FeedTarget='$FeedID'";
	$CurrentPosition = $DB->queryUniqueValue($query);
	if ($CurrentPosition != 1) {
		$NewPosition = $CurrentPosition--;
		$NewOrder = $CurrentOrder[$ArrayPosition];
		$CurrentOrder[$ArrayPosition] = $CurrentOrder[$ArrayPosition-1];
		$CurrentOrder[$ArrayPosition-1] = $NewOrder;
		   for ( $counter =0; $counter < $TotalLinks; $counter++) {
		    $ItemID = $CurrentOrder[$counter];
			$UpdatePosition = $counter + 1;
		   	$query = "UPDATE feed_items set $PositionTarget='$UpdatePosition' where EncryptID='$ItemID' and $FeedTarget='$FeedID'";
				$DB->query($query);
			}
	
	 }
}

function move_down($WindowID, $FeedItemTarget, $FeedID, $FeedTarget,$ItemID,$DB, $PositionTarget) {
	$CurrentOrder = array();
	$i=0;
	$query = "SELECT * from feed_items where $FeedItemTarget='$WindowID' and $FeedTarget='$FeedID' order by $PositionTarget"; 
	$DB->query($query);
	//print $query.'<br/>';
	while ($line = $DB->fetchNextObject()) { 
		$CurrentOrder[] = $line->EncryptID;
		if ($line->EncryptID == $ItemID) {
			$ArrayPosition = $i;
		}
		$i++;
	}
	$TotalLinks = $DB->numRows();
	$query = "SELECT $PositionTarget from feed_items where EncryptID='$ItemID' and $FeedTarget='$FeedID'";
	$CurrentPosition = $DB->queryUniqueValue($query);
	//print $query.'<br/>';
	if ($CurrentPosition != $TotalLinks) {
		$NewPosition = $CurrentPosition--;
		$NewOrder = $CurrentOrder[$ArrayPosition];
		$CurrentOrder[$ArrayPosition] = $CurrentOrder[$ArrayPosition+1];
		$CurrentOrder[$ArrayPosition+1] = $NewOrder;
		   for ($counter =0; $counter < $TotalLinks; $counter++) {
		    	$ItemID = $CurrentOrder[$counter];
				$UpdatePosition = $counter + 1;
		   		$query = "UPDATE feed_items set $PositionTarget='$UpdatePosition' where EncryptID='$ItemID' and $FeedTarget='$FeedID'";
				$DB->query($query);
				//print $query.'<br/>';
			}
	}
} 


if ($_POST['move'] != '') {
	if ($_POST['move'] == 'up') {
		move_up($WindowID, $FeedItemTarget, $FeedID, $FeedTarget,$ItemID,$DB, $PositionTarget);
	} else if ($_POST['move'] == 'down') {
		move_down($WindowID, $FeedItemTarget, $FeedID, $FeedTarget,$ItemID,$DB, $PositionTarget);
	}
$HeaderString = "/connectors/update_window_myvolt.php?window=".$_POST['OriginalTarget']."&stype=".$WindowType."&section=".$WindowSection."&action=edit";
//print 'STRING =' . $HeaderString;
header("location:".$HeaderString);
}

if (($Action == 'edit') && (($_POST['edit'] == '')||($_POST['edit'] == '0'))){
	$ItemList = '<div id="item_list"><table width="100%">';
if (($WindowType == 'rss') || ($WindowType == 'headlines')) {
		$query = "SELECT * from feed_modules where FeedID='$FeedID' and ModuleTemplate='rss'"; 
		$DB->query($query);
		while ($line = $DB->FetchNextObject()) {
			$ItemList .= '<tr><td width="75%">FEED: '. $line->Title.'</td><td class="pagelinks">[<a href="#" onclick="edit_module(\''.$line->EncryptID.'\');">edit</a>]&nbsp;&nbsp;[<a href="#" onclick="delete_window(\''.$line->EncryptID.'\');">delete</a>]</td></tr>';
		
		
		}


} else if ($WindowType == 'ref_items')  {
$query = "SELECT $PositionTarget from feed_items WHERE $PositionTarget=(SELECT MAX($PositionTarget) FROM feed_items where $FeedItemTarget='$WindowID' and $FeedTarget='$FeedID')";
$MaxPosition = $DB->queryUniqueValue($query);
$query = "SELECT * from feed_items where $FeedItemTarget='$WindowID' and $FeedTarget='$FeedID' order by $PositionTarget"; 
$DB->query($query);
while ($line = $DB->FetchNextObject()) {
	$ItemList .= '<tr><td width="60%">'. $line->Title.'</td><td class="pagelinks">';
	if ((($PositionTarget == 'WePosition') && ($line->WePosition != $MaxPosition)) || (($PositionTarget == 'MyPosition') && ($line->MyPosition != $MaxPosition)))
	$ItemList .= "<a href='#' onclick=\"move_down('".$line->EncryptID."');\"><img src=\"http://www.wevolt.com/images/arrow_down.png\" border=\"0\"></a>&nbsp;&nbsp;";

		
		if ((($PositionTarget == 'WePosition') && ($line->WePosition != 1)) || (($PositionTarget == 'MyPosition') && ($line->MyPosition != 1)))
			
			$ItemList .= "<a href='#' onclick=\"move_up('".$line->EncryptID."');\"><img src=\"http://www.wevolt.com/images/arrow_up.png\" border=\"0\"></a>&nbsp;&nbsp;";
	
	$ItemList .= '[<a href="#" onclick="parent.edit_item(\''.$line->EncryptID.'\',\''.$FlagTarget.'\');">edit</a>]&nbsp;&nbsp;[<a href="#" onclick="parent.send_item(\''.$line->EncryptID.'\',\''.$FlagTarget.'\');">send</a>]&nbsp;&nbsp;[<a href="#" onclick="delete_window(\''.$line->EncryptID.'\');">delete</a>]</td></tr>';


}


 }else if ($WindowType == 'items')  {
	 $query = "SELECT $PositionTarget from feed_items WHERE $PositionTarget=(SELECT MAX($PositionTarget) FROM feed_items where $FeedItemTarget='$WindowID' and $FeedTarget='$FeedID')";
$MaxPosition = $DB->queryUniqueValue($query);
$query = "SELECT * from feed_items where $FeedItemTarget='$WindowID' and $FeedTarget='$FeedID' order by $PositionTarget";  
$DB->query($query);
while ($line = $DB->FetchNextObject()) {
	$ItemList .= '<tr><td width="60%">'. $line->Title.'</td><td class="pagelinks">';

		if ((($PositionTarget == 'WePosition') && ($line->WePosition != $MaxPosition)) || (($PositionTarget == 'MyPosition') && ($line->MyPosition != $MaxPosition)))
	$ItemList .= "<a href='#' onclick=\"move_down('".$line->EncryptID."');\"><img src=\"http://www.wevolt.com/images/arrow_down.png\" border=\"0\"></a>&nbsp;&nbsp;";
 
		
		if ((($PositionTarget == 'WePosition') && ($line->WePosition != 1)) || (($PositionTarget == 'MyPosition') && ($line->MyPosition != 1)))
			
			$ItemList .= "<a href='#' onclick=\"move_up('".$line->EncryptID."');\"><img src=\"http://www.wevolt.com/images/arrow_up.png\" border=\"0\"></a>&nbsp;&nbsp;";
		
			$ItemList .= '[<a href="#" onclick="parent.edit_item(\''.$line->EncryptID.'\',\''.$FlagTarget.'\');">edit</a>]&nbsp;&nbsp;[<a href="#" onclick="parent.send_item(\''.$line->EncryptID.'\',\''.$FlagTarget.'\');">send</a>]&nbsp;&nbsp;[<a href="#" onclick="delete_item(\''.$line->EncryptID.'\');">delete</a>]</td></tr>';


}


 }else if ($WindowType == 'ref')  {
$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID='$CellID'"; 
$DB->query($query);
while ($line = $DB->FetchNextObject()) {
	$ItemList .= '<tr><td width="75%">'. $line->Title.'</td><td class="pagelinks">[<a href="#" onclick="edit_module(\''.$line->EncryptID.'\');">edit</a>]&nbsp;&nbsp;[<a href="#" onclick="delete_window(\''.$line->EncryptID.'\');">delete</a>]</td></tr>';


}


}

$ItemList .= '</table></div>';

}


if ($_POST['save'] == 1) { 
		$Title = mysql_real_escape_string($_POST['txtTitle']);
		$Tags = mysql_real_escape_string($_POST['txtTags']);
		$Description = mysql_real_escape_string($_POST['txtComment']);
		if ($Description == '')
			$Description = mysql_real_escape_string($_POST['txtDescription']);
		$Thumb = $_POST['txtThumb'];
		
		$Link = $_POST['txtLink'];
		$CreateDate = date('Y-m-d h:i:s');
		$TabID = $_POST['txtTab'];
		$IsMain = $_POST['txtMain'];
		$WindowType = $_POST['WindowType'];
		$WindowSection = $_POST['WindowSection'];
		$Action = $_POST['Action'];
		$EmbedCode = mysql_real_escape_string($_POST['txtEmbed']);
		$EmbedDimensions = getDimensions($_POST['txtEmbed']);
		$EmbedWidth = $EmbedDimensions['width'];
		$EmbedHeight = $EmbedDimensions['height'];
		if (($WindowType == 'headlines') ||($WindowType == 'rss')){
			$ModuleTemplate = 'rss';
			$ModuleType = 'mod_template';
			if ($RSSLink == '')
				$ContentVariable = 'custom';
			else 
				$ContentVariable = $RSSLink;
			
		}else if ($WindowType == 'ref') {
			$ModuleTemplate = 'box_list';
			$ModuleType = 'list';
		}
		if ($IsMain == '')
			$IsMain = 0;
		
		if ($Action == 'new') {

			if ($IsMain == 1) {
				$query = "SELECT ID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$CurrentMain = $DB->queryUniqueValue($query);
				if ($CurrentMain != '') {
					$query = "UPDATE feed_modules set IsMain='0' where FeedID='$FeedID' and ID='$CurrentMain'";
					$DB->execute($query);
				
				}
			}
			$query ="SELECT Position from feed_modules WHERE Position=(SELECT MAX(Position) FROM feed_modules where CellID='$CellID' and FeedID='$FeedID')";
			$NewPosition = $DB->queryUniqueValue($query);
			$NewPosition++;
			

			//print 'query = ' . $query.'</br/>';
			$query = "INSERT into feed_modules (Title, CellID, ModuleTemplate, FeedID,Privacy,IsMain,CreateDate, Position,ModuleType, Description, Tags, ContentVariable,SearchVariable) values ('$Title','$CellID','$ModuleTemplate','$FeedID','$Privacy', '$IsMain','$CreateDate','$NewPosition','$ModuleType','$Description','$Tags','$ContentVariable','$Link')";
			$DB->execute($query);
			//print 'query = ' . $query.'</br/>';
			$query = "SELECT ID from feed_modules where CreateDate='$CreateDate' and FeedID='$FeedID'";
			$ModuleID = $DB->queryUniqueValue($query);
			
			$Encryptid = substr(md5($ModuleID), 0, 12).dechex($ModuleID);
			//print 'query = ' . $query.'</br/>';
			$query = "UPDATE feed_modules set EncryptID='$Encryptid' where ID='$ModuleID'";
			//print 'query = ' . $query.'</br/>';
			$DB->execute($query);
			$ModuleID = $Encryptid;
			$RePost = 1;
		$CloseWindow = 1;
		} else if ($Action == 'edit') {
			if (($_POST['WindowType'] == 'headlines') || ($_POST['WindowType'] == 'rss') || ($_POST['WindowType'] == 'ref')){
				if ($IsMain == 1) {
					$query = "SELECT EncryptID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
					$CurrentMain = $DB->queryUniqueValue($query);
					if ($CurrentMain != $ModuleID) {
						$query = "UPDATE feed_modules set IsMain='0' where FeedID='$FeedID' and ID='$CurrentMain'";
						$DB->execute($query);
					
					}
				} 
				$query = "UPDATE feed_modules set Title='$Title', Description='$Description', Tags='$Tags', IsMain='$IsMain', SearchVariable='$Link' where EncryptID='$WindowID'";
				$DB->execute($query);
			}
		$CloseWindow = 1;
	   } else if ($Action == 'add') {
		   $ContentID= $_POST['ContentID'];
		if ($_POST['ContentType'] == 'project') {
			$ItemType = 'project_link';
			$ProjectID =  $ContentID;
		} else if ($_POST['ContentType'] == 'user') {
			$ItemType = 'user_link'; 
		} else {
			$ItemType = 'external_link';
		}
		
	
	   			$query ="SELECT $PositionTarget from feed_items WHERE $PositionTarget=(SELECT MAX($PositionTarget) FROM feed_items where $FeedItemTarget='$WindowID' and $FeedTarget='$FeedID')";
			$NewPosition = $DB->queryUniqueValue($query);
			$NewPosition++;
         
		$query = "INSERT into feed_items ($FeedItemTarget, $FeedTarget, Title, FeedID, CreatedDate, Tags,Link, Description,UserID, $PositionTarget, ProjectID,Thumb,Embed,EmbedWidth,EmbedHeight, $FlagTarget,ContentID,ItemType) values ('$WindowID','$FeedID','$Title','$FeedID','$CreateDate','$Tags','$Link','$Description','".$_SESSION['userid']."','$NewPosition','$ProjectID','$Thumb','$EmbedCode','$EmbedWidth','$EmbedHeight',1,'$ContentID','$ItemType')";
			$DB->execute($query);
			  // print $query;
		//	print 'query = ' . $query.'</br/>';
			$query = "SELECT ID from feed_items where CreatedDate='$CreateDate' and $FeedItemTarget='$WindowID'";
			$ItemID = $DB->queryUniqueValue($query);
		//print 'query = ' . $query.'</br/>';
			$Encryptid = substr(md5($ItemID), 0, 12).dechex($ItemID);
			
			$query = "UPDATE feed_items set EncryptID='$Encryptid' where ID='$ItemID'";
			//	print 'query = ' . $query.'</br/>';
			$DB->execute($query);
			if ($_POST['formaction'] != 'add_return')
				$CloseWindow = 1;
 
	   
	   } 
	
} else if ($_POST['delete'] == 1) {
		$WindowType = $_POST['WindowType'];
		$WindowSection = $_POST['WindowSection'];
		$Action = $_POST['Action'];
		if (($WindowType == 'rss') || ($WindowType == 'headlines')) {
				$query = "SELECT EncryptID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$CurrentMain = $DB->queryUniqueValue($query);
				//print $query.'<br/>';
				if ($CurrentMain == $WindowID) {
					$query = "SELECT EncryptID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 0";
					$NewMain = $DB->queryUniqueValue($query);
					$query = "UPDATE feed_modules set IsMain='1' where FeedID='$FeedID' and EncryptID='$NewMain'";
					$DB->execute($query);
						//print $query.'<br/>';
				
				}
			$query = "DELETE from feed_modules where FeedID='$FeedID' and EncryptID='$WindowID'";
			$DB->execute($query);
				//print $query.'<br/>';
		}
		if ($WindowType == 'ref') {
				$query = "SELECT EncryptID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 1";
				$CurrentMain = $DB->queryUniqueValue($query);
				//print $query.'<br/>';
				if ($CurrentMain == $WindowID) {
					$query = "SELECT EncryptID from feed_modules where FeedID='$FeedID' and CellID='$CellID' and IsMain = 0";
					$NewMain = $DB->queryUniqueValue($query);
					$query = "UPDATE feed_modules set IsMain='1' where FeedID='$FeedID' and EncryptID='$NewMain'";
					$DB->execute($query);
						//print $query.'<br/>';
				
				}
				$query = "DELETE from feed_modules where FeedID='$FeedID' and EncryptID='$WindowID'";
				$DB->execute($query);
				$query = "DELETE from feed_items where FeedID='$FeedID' and ModuleID='$WindowID'";
				$DB->execute($query);
				//print $query.'<br/>';
		}
		
		if ($WindowType == 'ref_items') {
				$ItemID = $_POST['ItemID'];
				$query = "UPDATE feed_items set IsPublished=0 where $FeedTarget='$FeedID' and $FeedItemTarget='$WindowID' and EncryptID='$ItemID'";
				$DB->execute($query);
				//print $query.'<br/>';
		}
		//print "/connectors/update_window_myvolt.php?window=".$_POST['CellID'].'-'.$_POST['WindowID']."&stype=".$WindowType."&section=".$WindowSection."&action=".$Action;
		header("Location:/connectors/update_window_myvolt.php?window=".$_POST['CellID'].'-'.$_POST['WindowID']."&stype=".$WindowType."&section=".$WindowSection."&action=".$Action);
} else if ($_POST['edit'] == 1) {
	$query = "SELECT * from feed_modules where EncryptID='".$_POST['ItemID']."' and CellID='".$_POST['CellID']."'";
	$ItemArray = $DB->queryUniqueObject($query);
}
$DB->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Update Myvolt Windows</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="http://<? echo $_SERVER['SERVER_NAME'];?>/ajax/ajax_init.js"></script>
<style type="text/css">
/* <![CDATA[ */
textarea { clear: both; font-family: sans-serif; font-size: 1em; width: 275px;}
/* ]]> */
</style>

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
    var url="/connectors/getSearchResults.php";
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
function submit_form(step,task,type) {
	document.getElementById('edit').value = 0;
	document.getElementById('save').value = 1;
	document.getElementById('delete').value = 0;
	document.getElementById('move').value = '';
	document.getElementById('formaction').value = step;
	
	if (document.getElementById("txtTitle").value == ''){
		alert('Please Enter a short Title');
	} else if (document.getElementById("txtLink")!= null){
		
		if (document.getElementById("txtLink").value == '')
			alert('Please enter a link');
		else 
			document.modform.submit();
	}else {
		document.modform.submit();
	}

}

function delete_window(windowid) {

	var answer = confirm ("Are you sure you want to delete this item?");
	if (answer) {
		document.getElementById('save').value = 0;
		document.getElementById('edit').value = 0;
		document.getElementById('delete').value = 1;
		document.getElementById('ItemID').value = windowid;
	//	alert('ITEM = ' +document.getElementById('ItemID').value );
		document.modform.submit();
	} 

}
function edit_module(windowid) {
		document.getElementById('edit').value = 1;
		document.getElementById('save').value = 0;
		document.getElementById('delete').value = 0;
		document.getElementById('ItemID').value = windowid;
		document.modform.submit();
}
function move_up(windowid) {

		document.getElementById('edit').value = 0;
		document.getElementById('save').value = 0;
		document.getElementById('delete').value = 0;
		document.getElementById('move').value = 'up';
		document.getElementById('ItemID').value = windowid;
	document.modform.submit();
}
function move_down(windowid) {
		document.getElementById('edit').value = 0;
		document.getElementById('save').value = 0;
		document.getElementById('delete').value = 0;
		document.getElementById('move').value = 'down';
		document.getElementById('ItemID').value = windowid;
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
		if (document.getElementById("ContentType") != null)
			document.getElementById("ContentType").value = contenttype;
	    if (document.getElementById("ContentID") != null)
			document.getElementById("ContentID").value = contentid;
		if (document.getElementById("txtBlurb") != null)
			document.getElementById("txtBlurb").value = title;
		if (document.getElementById("txtTitle") != null)
			document.getElementById("txtTitle").value = title;
		if (document.getElementById("txtComment") != null)
			document.getElementById("txtComment").value = description;
		if (document.getElementById("txtDescription") != null)
			document.getElementById("txtDescription").value = description;
			document.getElementById("txtTags").value = tags;
			document.getElementById("txtLink").value = contentlink;
alert(contentthumb);
		
			document.getElementById("thumbselect").style.display = 'none';
			
			if (document.getElementById("search_container") != null) {
				document.getElementById("search_container").style.display = 'none';
				document.getElementById("search_results").innerHTML = '';
			}
			document.getElementById("thumbdisplay").style.display = '';
			document.getElementById("itemthumb").src = contentthumb;
			document.getElementById("txtThumb").value = contentthumb;
			
		
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

  
</head>
<body>
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
var href = parent.window.location.href;
href = href.split('#');
href = href[0];
parent.window.location = href;
</script>
 
<? }?>         
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center">

   <form name="modform" id="modform" method="post" action="#">
   
   <div style="height:15px;"></div>
<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                        <img src="http://www.wevolt.com/images/wizard_myvolt_window_header.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
               <div style="height:10px;"></div>
   

<? if (($Action == 'edit') && (($_POST['edit'] == '')||($_POST['edit'] == '0'))){?>
<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                       <? echo $ItemList;?>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>



<? } else {?>



<? if (($WindowType == 'headlines') ||($WindowType == 'rss') ) {?>
<table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
<table><tr><td align="left" style="padding:3px;">
1. Title<br />
<input type="text" style="width:350px;" id="txtTitle" name="txtTitle" value="<? echo $ItemArray->Title;?>" ><br>
</td></tr>
<tr><td align="left" style="padding:3px;">
2. Enter full url for RSS feed including http://<br/>
<input type="text" style="width:350px;" id="txtLink" name="txtLink" value="<? if ($ItemArray->SearchVariable == '') echo 'http://'; else echo $ItemArray->SearchVariable;?>">
</td></tr>
<tr><td align="left" style="padding:3px;">
<div class="messageinfo">
<input type="checkbox" name="txtMain" value="1" <? if ($ItemArray->IsMain == 1) echo 'checked';?>/>Main Tab</div>

</td></tr>

</table>
</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
<div class="spacer"></div>
<div align="center">

<img src="http://www.wevolt.com/images/wizard_save_btn.png" onclick="submit_form();" class="navbuttons" />     <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="closeWindow();" class="navbuttons"/></div>  

<? } else { ?>

<? 	if ($Action == 'add') {
		 include $_SERVER['DOCUMENT_ROOT'].'/includes/feed_entry_form_inc.php';
	} else if (($Action == 'new') || ($Action == 'edit')) {?>
<table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
<table><tr><td align="left" style="padding:3px;">
1. Title<br />
<input type="text" style="width:350px;" id="txtTitle" name="txtTitle" value="<? echo $ItemArray->Title;?>" ><br>
</td></tr>
<tr><td align="left" style="padding:3px;">
<div class="messageinfo">
<input type="checkbox" name="txtMain" value="1" <? if ($ItemArray->IsMain == 1) echo 'checked';?>/>Main Tab</div>

</td></tr>

</table>
</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table><div class="spacer"></div>
                        <div align="center">
<img src="http://www.wevolt.com/images/wizard_save_btn.png" onclick="submit_form();" class="navbuttons" />     <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="closeWindow();" class="navbuttons"/></div>  
<? } ?>

<? }?>

<? }?>
<input type="hidden" name="save" id="save" value="1" />
<input type="hidden" name="move" id="move" value="" />
<input type="hidden" name="delete" id="delete" value="0" />
<input type="hidden" name="edit" id="edit" value="0" />
<input type="hidden" name="formaction" id="formaction" value="" />
<input type="hidden" name="WindowID" id="WindowID" value="<? echo $WindowID;?>"/>
<input type="hidden" name="OriginalTarget" id="OriginalTarget" value="<? echo $_GET['window'];?>"/>
<input type="hidden" name="ItemID" id="ItemID" value="<? echo $ItemID;?>"/>
<input type="hidden" name="CellID" id="CellID" value="<? echo $CellID;?>"/>
<input type="hidden" name="WindowType" id="WindowType" value="<? echo $WindowType;?>"/>
<input type="hidden" name="WindowSection" id="WindowSection" value="<? echo $WindowSection;?>"/>
<input type="hidden" name="Action" id="Action" value="<? echo $Action;?>"/>
<input type="hidden" id ="ContentType" name="ContentType">
<input type="hidden" id ="ContentID" name="ContentID">
</form>

</body>
</html>

