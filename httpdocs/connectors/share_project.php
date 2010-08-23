<?php 

session_start();

$UserRefer = $_SESSION['email'];

$ItemID = $_GET['id'];
if ($ItemID == '')
	$ItemID = $_POST['txtItem'];

$ReturnLink = $_SESSION['returnlink'];
if ($ReturnLink == '')
	$ReturnLink = $_POST['txtLink'];
	
$Title = $_GET['title'];
if ($Title == '')
	$Title = $_POST['title'];
	
	$Auth = true;
	
	if ($_POST['txtAction'] == 1) {
	
		$_SESSION['voltrefer'] = '';
		$_SESSION['voltitem'] = '';
		$_SESSION['returnlink'] ='';
		$_SESSION['vVar1'] = '';
		$_SESSION['vVar2'] = '';
		?>
        <script type="text/javascript">
			parent.$.modal().close(); 
        </script>
        
        <? 
	
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
function voltIt(ContentID,Link, Title, Type) {

	parent.open_feed_wizard(Title, ContentID, Link, Type, 'add','<? echo $_SESSION['username'];?>');
//	var w = 550;
//	var h = 500;
	//var left = (screen.width/2)-(w/2);
	//var top = (screen.height/2)-(h/2);
	
	//var pageURL = 'http://users.wevolt.com/feed_wizard.php?name=<? //echo trim($_SESSION['username']);?>&a=add&ctype=project&content=<? //echo $ItemID;?>';
	//var title = 'Feed Wizard';
	//var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

	
	}



</script>
<? if ($Auth) {?>
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center">

<div style="height:15px;"></div>
<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                        <img src="http://www.wevolt.com/images/wizard_share_header.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        
               <div style="height:10px;"></div>
               <div class="messageinfo_white">
               	How would you like to share this content? <div style="height:10px;"></div>
               </div>
               <table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="384" align="center">
<form method="post" action="#" name="voltform" id="voltform">
                    <a href="http://www.facebook.com/sharer.php?u=<? echo  urlencode($_SESSION['sharelink']);?>&t=<? echo  urlencode($Title);?>" target="_blank" ><img src="http://www.wevolt.com/images/fb_icon.jpg" border="0" /></a>
                    
                    <a href='http://twitter.com/home?status=Currently reading <? echo  urlencode($_SESSION['sharelink']);?>' title='Click to share this post on Twitter' target="_blank" ><img src="http://www.wevolt.com/images/twitter_icon.jpg" border="0" /></a>
                    <a href='http://digg.com/submit/?url=<? echo urlencode($_SESSION['sharelink']);?>&title=<? echo urlencode($Title);?>' title='Click to share this post on Digg' target="_blank" ><img src="http://www.wevolt.com/images/digg_icon.jpg" border="0" /></a>                
<a href="http://delicious.com/save" onclick="window.open('http://delicious.com/save?v=5&noui&jump=close&url='+encodeURIComponent('<? echo urlencode($_SESSION['sharelink']);?>')+'&title='+encodeURIComponent('<? echo urlencode($Title);?>'), 'delicious','toolbar=no,width=550,height=550'); return false;"><img src="http://www.wevolt.com/images/del_icon.jpg" border="0" /></a>
<a href='http://reddit.com/submit?url=<? echo  urlencode($_SESSION['sharelink']);?>&title=<? echo $Title;?>' target='_blank'><img src="http://www.wevolt.com/images/reddit_icon.png" border="0" /></a>
<? if ($_SESSION['userid'] != '') {?>
<a href='#' title='Post to wevolt' onclick="voltIt('<? echo $ItemID;?>','<? echo urlencode($_SESSION['sharelink']);?>','<? echo urlencode($Title);?>','project'); return false;"><img src="http://www.wevolt.com/images/V_social_media.png" border="0" /></a><? }?>
<input type="hidden" name="txtItem" value="<? echo $ItemID;?>">
<input type="hidden" name="txtRefer" value="<? echo $Refer;?>">
<input type="hidden" name="txtLink" value="<? echo  $ReturnLink;?>">

<input type="hidden" name="txtAction" id="txtAction" value="1">
</form>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                     </div>
<? } ?>