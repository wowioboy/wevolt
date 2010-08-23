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
	
		$query = "SELECT * from projects where SafeFolder='".$_GET['id']."'";
		$ProjectArray = $DB->queryUniqueObject($query);
		$ProjectTitle = $ProjectArray->title;
		$ProjectID = $ProjectArray->ProjectID;
		$Thumb = 'http://www.wevolt.com.'.$ProjectArray->thumb;
		$Link = 'http://www.wevolt.com/'.$ProjectArray->SafeFolder.'/';
	
}
if ($_POST['save'] == 1) { 
		$Review = mysql_real_escape_string($_POST['txtReview']);
		$Headline= mysql_real_escape_string($_POST['txtHeadline']); 
		$Tags= mysql_real_escape_string($_POST['txtTags']); 
		$CreateDate = date('Y-m-d h:i:s');
		
		$RatingsOrder = explode('&listItem[]=',$_POST['ratingsorder']);
	
		$cnt = 1;
		foreach($RatingsOrder as $rating) {
			if ($rating != '') {
				if ($rating == 'writing') 
					$Writing = $cnt;
				else if ($rating == 'fun') 
					$Fun = $cnt;
				else if ($rating == 'storytelling') 
					$Storytelling = $cnt;
				else if ($rating == 'cool') 
					$Cool = $cnt;
				else if ($rating == 'art') 
					$Art = $cnt;
				
				$cnt++;
			}
		}
			
			$query = "INSERT into weviews (user_id, project_id, title, content, writing, art, fun, storytelling, cool,tags,created_date) values ('".$_SESSION['userid']."','".$_POST['cid']."','$Headline','$Review','$Writing','$Art','$Fun','$Storytelling', '$Cool','$Tags','$CreateDate')";
			$DB->execute($query);
			//print $query.'<br/>';
			$query = "SELECT ID from weviews where created_date='$CreateDate' and user_id='".$_SESSION['userid']."'";
			$NewID = $DB->queryUniqueValue($query);
			//print $query.'<br/>';
			$Encryptid = substr(md5($NewID), 0, 15).dechex($NewID);
			$IdClear = 0;
			$Inc = 5;
			while ($IdClear == 0) {
							$query = "SELECT count(*) from weviews where encrypt_id='$Encryptid'";
							$Found = $DB->queryUniqueValue($query);
							$output .= $query.'<br/>';
							if ($Found == 1) {
								$Encryptid = substr(md5(($NewID+$Inc)), 0, 15).dechex($NewID+$Inc);
							} else {
								$query = "UPDATE weviews SET encrypt_id='$Encryptid' WHERE id='$NewID'";
								$DB->execute($query);
								$output .= $query.'<br/>';
								$IdClear = 1;
							}
							$Inc++;
			}
			
			insertUpdate('review', 'added', $Encryptid, 'user', $UserID,$Link,'',$_POST['txtHeadline']);
			$CloseWindow = 1;


}

$DB->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Write Review</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
 <script src="http://www.wevolt.com/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://www.wevolt.com/js/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="/pf_16_core/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<style type="text/css">
/* <![CDATA[ */
textarea { clear: both; font-family: sans-serif; font-size: 1em; width: 275px;}
/* ]]> */
</style>

<style type="text/css">

div.section span {
		cursor: move;
		

	
	}
	div.section  {
	
		background-color:#CCCCCC;
		padding:5px;
		border:#0066FF 2px dashed;
	
	}
	div.avail  {
	
		background-color: #FFCC00;
		padding:5px;
		border:#000000 1px solid;
	
	}
	
li.homemod {
		margin: 3px 0px;
		width:100%;
		font-size:10px;
		color:#FFFFFF;
		font-weight:600;
		
	height:20px;
		text-align:center;
		cursor: move;
		padding-top:5px;
		border:#000000 1px solid;
		background-color:#144e92;

		
	}
div.homemod a {
font-size:10px;
color:#FFFFFF;
text-decoration:underline;
	font-weight:normal;

		
	}	
div.homemod a:link {
font-size:10px;
color:#FFFFFF;
text-decoration:underline;
font-weight:normal;
		
	}		
	.handle {
	color: #ffffff;
	
	}
	ul{
  list-style-type: none}
	h1 {
		margin-bottom: 0;
		font-size: 14px;
	}

</style>

<script type="text/javascript">
  // When the document is ready set up our sortable with it's inherant function(s)
  $(document).ready(function() {
    $("#ratings-list").sortable({
      handle : '.handle',
      update : function () {
		  var order = $('#ratings-list').sortable('serialize');
		  document.getElementById("ratingsorder").value = '&'+order;
		 // alert(document.getElementById("ratingsorder").value);
  		//$("#info").load("process-sortable.php?"+order);
      }
    });
});

<? /*
sections = ['ratings'];
	function createLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.create(sections[i],{tag:'div',dropOnEmpty: true, containment: sections,only:'homemod'});
		}
	}
	function destroyLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.destroy(sections[i]);
		}
	}
	function createGroupSortable() {
		Sortable.create('page',{tag:'div',only:'section',handle:'handle'});
	}

	

	function getGroupOrder() {
		var sections = document.getElementsByClassName('section');
		//var alerttext = '';

		sections.each(function(section) {
		
			var sectionID = section.id;
			var order = Sortable.serialize(sectionID);
			
				document.getElementById("ratingsorder").value = Sortable.sequence(section);
				
		});
		//document.modform.submit();
		return false;
	}
	*/?>
	</script>

<script type="text/javascript">

function submit_form() {
			
	if (document.getElementById("txtHeadline").value == '') {
		alert('Please Enter a short headline');
	}else {
		document.modform.submit();
		//getGroupOrder();
	}

}

</script>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
</head>
<body>
<div style="background-image:url(http://www.wevolt.com/images/700_bgd.jpg); background-repeat:no-repeat; height:467px; width:700px;" align="center">
<div class="spacer"></div>
<table width="608" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="592" align="center">
                                        <table width="100%"><tr><td width="75" align="left"><img src="<? echo $Thumb;?>" width="50" border="2"/></td><td align="center">
                                        <img src="http://www.wevolt.com/images/excite_edit_header.png" vspace="8"/>
                                        </td></tr></table>
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
                                         
<div style="height:10px;"></div> 

<table><tr><td valign="top"><table width="450" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="434" align="left">
                                        Headline:<br>
<input type="text" style="width:100%" name="txtHeadline" id="txtHeadline" /><div style="height:5px;"></div>
Review:<br />
<textarea name="txtReview" id="txtReview" style="width:100%;height:250px;"></textarea>
                                        </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                        
                                        </td>
                                        <td width="10"></td>
                                        
                                        <td valign="top"><center><img src="http://www.wevolt.com/images/wizard_done_btn.png" onclick="submit_form();" class="navbuttons" />     <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onclick="parent.$.modal().close();" class="navbuttons"/><div style="height:5px;"></div></center>
                                        <table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>

										<td class="wizardboxcontent" valign="top" width="184" align="center">
                                        Tags<br/>
                             <textarea name="txtTags" id="txtTags" style="width:100%;height:50px;"></textarea>  <div style="height:10px;"></div>  Ratings: <span style="font-size:10px;">(move the items below to order of quality)</span> 

<ul id="ratings-list">
<li id="listItem_writing" class="homemod"><span class="handle"/>Writing</span></li>
<li id="listItem_art" class="homemod"><span class="handle" />Art</span></li>
<li id="listItem_fun" class="homemod"><span class="handle" />Fun</span></li>
<li id="listItem_storytelling" class="homemod"><span class="handle" />Storytelling</span></li>
<li id="listItem_cool" class="homemod"><span class="handle" />Cool</span></li>

</ul>
  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
                                        
                                        </td>
                                      </tr></table>
<input type="hidden" name="save" value="1" />
<input type="hidden" id="ratingsorder" name="ratingsorder" value="" />
<input type="hidden" name="cid" id="cid" value="<? echo $ProjectID;?>" />
</div>
</form>
<script type="text/javascript">
 
tinyMCE.init({
    mode: "exact",
    elements : "txtReview",
    theme : "advanced",
	skin : "o2k7",
	spellchecker_rpc_url : '/pf_16_core/tinymce/jscripts/tiny_mce/plugins/spellchecker/rpc.php',
theme_advanced_source_editor_width : 500,
theme_advanced_source_editor_height : 400,
    theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,|,forecolor,backcolor",
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,blockquote,|link,unlink",
    theme_advanced_buttons3 : "formatselect,fontselect,fontsizeselect",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
    setup : function(ed) {
        // Add a custom button
       
    }
});
 
 </script>
<? }?>

</body>
</html>