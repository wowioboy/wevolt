<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
include_once(CLASSES.'/message.php');
include_once(INCLUDES.'/db.class.php');

$CloseWindow = 0;
if ($_SESSION['userid'] == '')
	$CloseWindow = 1;
$PositionID = $_GET['pid'];

$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$query = "select p.*,c.title as PosTitle, j.title as JobTitle, j.user_id as JobOwner 
						from pf_jobs_positions as p
						join pf_jobs_cats as c on p.job_type=c.id
						join pf_jobs as j on p.job_id=j.id
						where p.encrypt_id='$PositionID'";
$PositionArray = $DB->queryUniqueObject($query);

if ($_POST['save'] == 1) { 
	$query = "SELECT count(*) from pf_jobs_applications where user_id='".$_SESSION['userid']."' and position_id='$PositionID'";
	$Found = $DB->queryUniqueValue($query);
		if ($Found == 0) {
			$query ="INSERT into pf_jobs_applications (user_id, job_id, position_id, application_date,message) values ('".$_SESSION['userid']."', '".$PositionArray->job_id."', '$PositionID', '".date('Y-m-d h:i:s')."','".mysql_real_escape_string($_POST['message'])."')";
			$DB->execute($query);
			//print $query;
			$message = new message();
			$message->sendMessage($_SESSION['userid'],$PositionArray->JobOwner,'application',$PositionID);
		}
		$CloseWindow = 1;
}
$DB->close();
?>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
  <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="/pf_16_core/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

</head>
<body>
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center"> 
<div class="spacer"></div>
<table width="508" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="492" align="center" style="font-size:18px;">
                                        <b>APPLY FOR JOB POSITION</b>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
parent.document.getElementById("<? echo $_GET['elem'];?>").innerHTML = 'You have <br/>applied';
parent.$.modal().close();
</script>
 
<? } else {?>
<form method="post" action="#" name="actionform" id="actionform">
<div style="width:80%;" class="messageinfo_white" align="left"><div class="spacer"></div>
<div style="font-size:14px;"><b>Project: </b><? echo $PositionArray->JobTitle;?></div><div class="spacer"></div>
<div style="font-size:14px;"><b>Position: </b><? echo $PositionArray->PosTitle;?></div>


<div class="spacer"></div>
<b>Custom Message:</b> &nbsp;&nbsp;<em>(OPTIONAL)</em><br />
</div>
<textarea name="message" id="message" style="width:80%; height:225px;"></textarea><div class="spacer"></div>
<input type="submit" value="APPLY" />
<input type="hidden" value="1" name="save">
</form>
<script type="text/javascript">
 
tinyMCE.init({
    mode: "exact",
    elements : "message",
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
</div>