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
	
if ($_SESSION['userid'] == '') {
	$Auth = false;
	  ?>
        <script type="text/javascript">
			parent.close_wizard(); 
        </script>
        
        <? 

} else {

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
}
$DB->close();

?>
<script type="text/javascript">
function voltIt(value) {
	if (value == 'w3') {
		parent.window.location ='/feed_wizard.php?name=<? echo trim($_SESSION['username']);?>';
		
	} else {
		document.voltform.submit(); 
	
	}


}



</script>
<? if ($Auth) {?>
<table cellpadding="0" cellspacing="0" border="0" width="475">
<tr>
<td align="center" style="color:#000000;background-color:#eef3f9;" height="100">
<form method="post" action="#" name="voltform" id="voltform">

					
					How would you like to share this content? <div style="height:5px;"></div>
                    <div>
                    <a href="http://www.facebook.com/sharer.php?u=<? echo $ReturnLink;?>&t=<? echo $PageTitle;?>" target="_blank"><img src="http://www.w3volt.com/images/fb_icon" border="0" /></a>
                    
                    <a href='http://twitter.com/home?status=Currently reading <? echo $ReturnLink;?>' title='Click to share this post on Twitter' target="_blank"><img src="http://www.w3volt.com/images/twitter_icon" border="0" /></a>
                    
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