<?php 

session_start();

$UserRefer = $_SESSION['email'];

$ItemID = $_GET['id'];
if ($ItemID == '')
	$ItemID = $_POST['txtItem'];

$ReturnLink = $_SESSION['returnlink'];
if ($ReturnLink == '')
	$ReturnLink = $_POST['txtLink'];
	
if ($_GET['type'] == '')
	$Type='project';
else 
	$Type=$_GET['type'];	
	
$Title = $_GET['title'];
if ($_SESSION['sharelink'] == '')
	$_SESSION['sharelink'] =  $_SESSION['refurl'];
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
  <div class="wizard_wrapper" align="center" style="width:624px; height:416px;">

                                        <img src="http://www.wevolt.com/images/headers/share_content_header.png" vspace="8"/>

               <div class="grey_text">
               	How would you like to share this content? <div style="height:10px;"></div>
               </div>
             
<form method="post" action="#" name="voltform" id="voltform">
                    <a href="http://www.facebook.com/sharer.php?u=<? echo  urlencode($_SESSION['sharelink']);?>&t=<? echo  urlencode($Title);?>" target="_blank" ><img src="http://www.wevolt.com/images/fb_icon.jpg" border="0" /></a>
                    
                    <a href='http://twitter.com/home?status=Currently reading <? echo  urlencode($_SESSION['sharelink']);?>' title='Click to share this post on Twitter' target="_blank" ><img src="http://www.wevolt.com/images/twitter_icon.jpg" border="0" /></a>
                    <a href='http://digg.com/submit/?url=<? echo urlencode($_SESSION['sharelink']);?>&title=<? echo urlencode($Title);?>' title='Click to share this post on Digg' target="_blank" ><img src="http://www.wevolt.com/images/digg_icon.jpg" border="0" /></a>                
<a href="http://delicious.com/save" onclick="window.open('http://delicious.com/save?v=5&noui&jump=close&url='+encodeURIComponent('<? echo urlencode($_SESSION['sharelink']);?>')+'&title='+encodeURIComponent('<? echo urlencode($Title);?>'), 'delicious','toolbar=no,width=550,height=550'); return false;"><img src="http://www.wevolt.com/images/del_icon.jpg" border="0" /></a>
<a href='http://reddit.com/submit?url=<? echo  urlencode($_SESSION['sharelink']);?>&title=<? echo $Title;?>' target='_blank'><img src="http://www.wevolt.com/images/reddit_icon.png" border="0" /></a>
<? if ($_SESSION['userid'] != '') {?>
<a href='#' title='Post to wevolt' onclick="voltIt('<? echo $ItemID;?>','<? echo urlencode($_SESSION['sharelink']);?>','<? echo urlencode($Title);?>','<? echo $Type;?>'); return false;"><img src="http://www.wevolt.com/images/V_social_media.png" border="0" /></a><? }?>
<input type="hidden" name="txtItem" value="<? echo $ItemID;?>">
<input type="hidden" name="txtRefer" value="<? echo $Refer;?>">
<input type="hidden" name="txtLink" value="<? echo  $ReturnLink;?>">

<input type="hidden" name="txtAction" id="txtAction" value="1">
</form>
                     </div>
<? } ?>