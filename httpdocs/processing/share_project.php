<?php 
include '../includes/init.php';
$DB = new DB();

$UserRefer = $_SESSION['email'];

$ItemID = $_GET['id'];
if ($ItemID == '')
	$ItemID = $_POST['txtItem'];

$ReturnLink = $_GET['link'];
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
			parent.close_wizard(); 
			parent.window.location ='<? echo $ReturnLink;?>'; 
        </script>
        
        <? 
	
	}

$DB->close();

?>
<script type="text/javascript">
function voltIt(ContentID,Link, Title, Type) {
	//parent.close_wizard(); 
	
	parent.open_feed_wizard(Title, ContentID, Link, Type, 'add');
//	var w = 550;
//	var h = 500;
	//var left = (screen.width/2)-(w/2);
	//var top = (screen.height/2)-(h/2);
	
	//var pageURL = 'http://users.w3volt.com/feed_wizard.php?name=<? //echo trim($_SESSION['username']);?>&a=add&ctype=project&content=<? //echo $ItemID;?>';
	//var title = 'Feed Wizard';
	//var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

	
	}



</script>
<? if ($Auth) {?>
<table cellpadding="0" cellspacing="0" border="0" width="475">
<tr>
<td align="center" style="color:#000000;background-color:#eef3f9;" height="100">
<form method="post" action="#" name="voltform" id="voltform">

					
					How would you like to share this content? <div style="height:5px;"></div>
                    <div>
                    <a href="http://www.facebook.com/sharer.php?u=<? echo  urlencode($ReturnLink);?>&t=<? echo  urlencode($Title);?>" target="_blank" ><img src="http://www.w3volt.com/images/fb_icon.jpg" border="0" /></a>
                    
                    <a href='http://twitter.com/home?status=Currently reading <? echo  urlencode($ReturnLink);?>' title='Click to share this post on Twitter' target="_blank" ><img src="http://www.w3volt.com/images/twitter_icon.jpg" border="0" /></a>
                    <a href='http://digg.com/submit/?url=<? echo urlencode($ReturnLink);?>&title=<? echo urlencode($Title);?>' title='Click to share this post on Digg' target="_blank" ><img src="http://www.w3volt.com/images/digg_icon.jpg" border="0" /></a>
                   
<a href="http://delicious.com/save" onclick="window.open('http://delicious.com/save?v=5&noui&jump=close&url='+encodeURIComponent('<? echo urlencode($ReturnLink);?>')+'&title='+encodeURIComponent('<? echo urlencode($Title);?>'), 'delicious','toolbar=no,width=550,height=550'); return false;"><img src="http://www.w3volt.com/images/del_icon.jpg" border="0" /></a>
<? if ($_SESSION['userid'] != '') {?>
<a href='#' title='Post to W3VOLT' onclick="voltIt('<? echo $ItemID;?>','<? echo urlencode($ReturnLink);?>','<? echo urlencode($Title);?>','project'); return false;"><img src="http://www.w3volt.com/images/w3_icon.jpg" border="0" /></a><? }?>

                   
                   
                    </div>
					                    

<input type="hidden" name="txtItem" value="<? echo $ItemID;?>">
<input type="hidden" name="txtRefer" value="<? echo $Refer;?>">
<input type="hidden" name="txtLink" value="<? echo  $ReturnLink;?>">

<input type="hidden" name="txtAction" id="txtAction" value="1">
</form>
</td>
</tr>
</table>
<? } ?>