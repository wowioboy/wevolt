<?php 

include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';
$CloseWindow = 0;
if ($_SESSION['userid'] == '')
	$CloseWindow = 1;

if ($_POST['save'] == 1) { 

		if (($_POST['action'] == 'volt') || ($_POST['action'] == 'both')) {
				$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				if ($_POST['type'] == 'forum topic') {
					$query = "SELECT * from pf_forum_topics where EncryptID='".$_GET['id']."'";
					$ItemArray = $DB->queryUniqueObject($query);
					$Creator = $ItemArray->PosterID;
					$query = "SELECT count(*) from favorites where UserID='".$_SESSION['userid']."' and ContentID='".$_POST['p']."' and ContentType='forum_topic'";
					$Found = $DB->queryUniqueValue($query);
					if ($Found == 0) {
						$query = "INSERT into favorites (creatorid, UserID, ContentType, ContentID) values ('$Creator','".$_SESSION['userid']."','forum_topic','".$_POST['p']."')";
						$DB->execute($query);
					}
				} else if ($_POST['type'] == 'job_post') {
					$query = "SELECT * from pf_jobs where encrypt_id='".$_GET['id']."'";
					$ItemArray = $DB->queryUniqueObject($query);
					$Creator = $ItemArray->user_id;
					$query = "SELECT count(*) from favorites where UserID='".$_SESSION['userid']."' and ContentID='".$_POST['p']."' and ContentType='job'";
					$Found = $DB->queryUniqueValue($query);
					if ($Found == 0) {
						$query = "INSERT into favorites (creatorid, UserID, ContentType, ContentID) values ('$Creator','".$_SESSION['userid']."','job','".$_POST['p']."')";
						$DB->execute($query);
					}
				} else {
					$query = "SELECT * from projects where ProjectID='".$_GET['id']."'";
					$ProjectArray = $DB->queryUniqueObject($query);
					$Type = $ProjectArray->ProjectType;
					$Creator = $ProjectArray->CreatorID;
					$UserID = $_SESSION['userid'];
					$query = "SELECT count(*) from favorites where UserID='$UserID' and ProjectID='".$_POST['p']."'";
					$Found = $DB->queryUniqueValue($query);
					if ($Found == 0) {
						$query = "INSERT into favorites (creatorid, UserID, ContentType, ProjectID) values ('$Creator','$UserID','$Type','".$_POST['p']."')";
						$DB->execute($query);
					}
				}
				$DB->close();
		}
	
		if ($_POST['action'] == 'both')
			$LaunchExcite = true;
		else 
			$LaunchExcite = false;
		
}
?>
<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

function submit_form(action) {
	if (action == 'volt'){
		document.getElementById("action").value = 'volt';
		document.getElementById("save").value = '1';
	} else if (action == 'both') {
		document.getElementById("action").value = 'both';
		document.getElementById("save").value = '1';		
	}
	document.modform.submit();

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

<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
parent.$.modal().close();
</script>
<? }?>

<? if ($_POST['save'] == 1) {?>
<script type="text/javascript">
<? if ($LaunchExcite) {?>
parent.update_excite('<? echo $_POST['p'];?>','<? echo $_POST['cat'];?>','<? echo $_POST['type'];?>');
<? } else {?>
parent.$.modal().close();
<? }?>
</script>
 <? }?>

<form name="modform" id="modform" method="post" action="#">
<div class="wizard_wrapper" align="center" style="height:416px; width:624px;">

                                        <img src="http://www.wevolt.com/images/headers/volt_content_header.png" vspace="8"/>
   
      <div class="grey_text">     
<strong>What do you want to do with this REvolt</strong>
</div>
<div style="height:10px;"></div> 
<div align="center" style="width:624px;">  
<table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
                                        <table><tr><td>
<div class="white_box" style="width:140px;" align="center">
<div class="blue_button" onClick="submit_form('volt');">VOLT IT</div>
<div class="spacer"></div>
<span style="font-size:12px;">
Throw this in your Volt to save it for later.</span>
</div>                              
</td><td>
<div class="white_box" style="width:140px;" align="center">
<div class="blue_button" onClick="parent.update_excite('<? echo $_GET['id'];?>','<? echo $_GET['cat'];?>','<? echo $_GET['type'];?>');">EXCITE IT!</div>
<div class="spacer"></div>
<span style="font-size:12px;">
Add a link to the REvolt in your EXCITE status.</span>
</div>
</td></tr>
<tr><td colspan="2" align="center">
<div class="white_box" style="width:140px;" align="center">
<div class="blue_button" onClick="submit_form('both');">BOTH!</div>
<div class="spacer"></div>
<span style="font-size:12px;">
We're gonna throw this in your VOLT for later and let you EXCITE it right now.</span>
</div>
</td>
</tr></table>

</div>
</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        </div>
<div class="spacer"></div>
<div align="center">
<img src="http://www.wevolt.com/images/cms/cms_grey_cancel_box.png" onClick="parent.$.modal().close();" class="navbuttons"/></div>  
                        
<input type="hidden" name="action" value="" id="action"/>
<input type="hidden" name="save" id="save" value="" />
<input type="hidden" name="p" id="p" value="<? echo $_GET['id'];?>" />
<input type="hidden" name="type" id="type" value="<? echo $_GET['type'];?>" />
<input type="hidden" name="cat" id="cat" value="<? echo $_GET['cat'];?>" />
</form>
</body>
</html>