<?php 
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/classes/comment.php';
$ItemID = $_GET['cid'];
if ($ItemID == '')
	$ItemID = $_POST['txtItem'];
$PageID = $_GET['pid'];
if ($PageID == '')
	$PageID = $_POST['txtPage'];
$PostBack = $_GET['postback'];
if ($PostBack == '')
	$PostBack = $_POST['postback'];
$Section = $_GET['section'];
if ($Section == '')
	$Section = $_POST['txtSection'];
$Username = $_GET['user'];

if ($_SESSION['userid'] == '') {?>
   <script type="text/javascript">
			parent.$.modal().close(); 
        </script>

<? }

if ($_POST['insert'] == '1'){
			$Comment = new comment();
			if(($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] )) || ($_SESSION['userid'] == '')) {
					unset($_SESSION['security_code']);
					setcookie("seccode", "", time()+60*60*24*100, "/");
					
					if ($_POST['txtFeedback'] == '')
						$_SESSION['commenterror'] = 'You need to enter a comment';
					  
						$CommentUserID = trim($_SESSION['userid']);
						
						$CommentUsername = addslashes($_POST['txtName']);

						if ($Section == 'Blog') {
							$Comment->pageComment($Section,$_SESSION['viewingproject'], $PageID, $CommentUserID, $_POST['txtFeedback'],$CommentUsername,$PostBack,$ItemID);?>
							 <script type="text/javascript">
								window.parent.location = '<? echo $PostBack;?>';
								</script>
							<?
							
					
						} else { 
						
							$Comment->pageComment($Section,$_SESSION['viewingproject'], $PageID, $CommentUserID, $_POST['txtFeedback'],$CommentUsername,$PostBack,$ItemID);?>
				   
							 <script type="text/javascript">
								window.parent.location = '<? echo $PostBack;?>';
								</script>
					<? }
					
			
		   } else {
				$_SESSION['commenterror'] = 'invalid security code. Try Again.';
		   }
}

?>

<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">

</style>

 <style type="text/css">
 body,html {
	margin:0px;
	padding:0px; 
	 
 }
 
 </style>
<script type="text/javascript">
	function submit_comment() {
		document.commentform.submit();
	}
</script>

<div class="wizard_wrapper" align="center" style="height:416px; width:624px;">
<div align="center">
<div style="height:20px;"></div>
<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                       <div id="commentbox">
<div class="modheader">Reply to <? echo $Username;?>'s Comment</div>
<form method="POST" action="#" name="commentform" id="commentform">
<textarea rows="10" style="width:98%" name="txtFeedback" onFocus="doClear(this);" id="txtComment"><? if ($_POST['txtFeedback']=='')
								echo 'enter a comment'; 
							else
		 						echo $_POST['txtFeedback'];?></textarea><div class="spacer"></div>
<div align="left">
<table cellpadding="0" cellspacing="0" border="0"><tr><td>
<img src="/panelflow/captcha/CaptchaSecurityImages.php?width=100&height=40&characters=5" border='2'/>
<label for="security_code"></label>
<br /></td><td style="padding-left:10px;">
<input id="security_code" name="security_code" type="text" class="inputstyle" style="width:100px; background-color:#99FFFF; border:none;" onFocus="doClear(this)" value="enter code"/></td>
									</tr></table></div>
<input type="hidden" name="insert" id="insert" value="1">
<input type="hidden" name="txtPage" id="txtPage" value="<? echo $PageID;?>" />
<input type="hidden" name="txtItem" id="txtItem" value="<? echo $ItemID;?>" />
<input type="hidden" name="postback" id="postback" value="<? echo $PostBack;?>" />
<input type="hidden" name="txtSection" id="txtSection" value="<? echo $Section;?>" />
<div class="spacer"></div>
<? if ($_SESSION['commenterror'] != '') {?>
<font style='color:red'><? echo $_SESSION['commenterror'];?>"</font>
<div class='spacer'></div>
<script type='text/javascript'>
alert('There was an error submitting comment, please check your fields and try again');
</script>
<? $_SESSION['commenterror'] = '';
							} ?>
<div class="spacer"></div><span class="buttonlinks">
<input type="button" onclick="submit_comment();" value="Submit Reply" class="navbuttons">
</form><div class="spacer"></div></div>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
  </div>                      
              
                     </div>
