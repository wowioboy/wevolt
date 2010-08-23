<script type="text/javascript">
function select_upload_type(value) {
	if (value == 'local') {
		document.getElementById("localupload").style.display = '';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("fileurl").value = '';
		document.getElementById("localtab").className ='tabactive';
		document.getElementById("urltab").className ='tabinactive';
		
	} else if (value == 'url') {
		document.getElementById("localupload").style.display = 'none';
		document.getElementById("urlupload").style.display = '';
		document.getElementById("uploadedfile").value = '';
		document.getElementById("localtab").className ='tabinactive';
		document.getElementById("urltab").className ='tabactive';
		
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

function submit_form() {
		
		document.getElementById('uploaddiv').style.display ='none';
		document.getElementById('progressdiv').style.display ='';
		document.UploadForm.submit();
}
</script>
<style type="text/css">
body, html {

<? if ($_GET['transparent'] != 1) {?>
	background-color:#ffffff;
	<? }?>

padding:0px;
margin:0px;
color:#ffffff;

}

 .messageinfo_warning {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:12px;
 color:#fdd700;
 }
.tabactive {
height:12px;
background-color:#fed800;
text-align:center;
padding:5px;
cursor:pointer;
font-weight:bold;
font-size:10px;
color:#000000;
}
.tabinactive {
height:12px;
background-color:#113356;
text-align:center;
padding:5px;
cursor:pointer;
color:#FFFFFF;
font-size:10px;
}
.tabhover{
height:12px;
background-color:#fed800;
color:#000000;
text-align:center;
padding:5px;
cursor:pointer;
font-size:10px;
text-decoration:underline;
}

.uploadwrapper {
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;

}
input.file {
margin:0px;
padding:0px;
}

</style>

<div class="uploadwrapper">
<div style="color:#ffffff;">
<div id='uploaddiv'>
<? if ($_GET['uploadaction'] == 'user_thumb') {?>
<form enctype="multipart/form-data" action="/user_thumb_uploader.php?uploadaction=<? echo $_GET['uploadaction'];?>" method="POST" id='UploadForm' name='UploadForm'>
<? } else {?>
<form enctype="multipart/form-data" action="/media_uploader.php" method="POST" id='UploadForm' name='UploadForm'>
<? }?>
<input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
<? /*
<div align="center">
<table cellpadding="0" cellspacing="0" border="0" width="75%"><tr><td width="50%" id='localtab' class='tabactive' height="30" onClick="select_upload_type('local')" onMouseOver="rolloveractive('localtab','localupload')" onMouseOut="rolloverinactive('localtab','localupload')" >BROWSE COMPUTER</td><td width="50%" id='urltab' class='tabinactive' height="30" onClick="select_upload_type('url')" onMouseOver="rolloveractive('urltab','urlupload')" onMouseOut="rolloverinactive('urltab','urlupload')" >URL UPLOAD</td></tr></table>
</div>*/?>
<div id='localupload'>

<table><tr><td>
<input name="uploadedfile" type="file" style="width:215px;" id="uploadedfile"/><? if ($_GET['compact'] == 'v2') {?><br/><input type="button" value="UPLOAD" onClick='submit_form();'/><? }?>
</td><? if ($_GET['compact'] != 'v2') {?><td valign="top">&nbsp;<input type="button" value="UPLOAD" onClick='submit_form();'/> </td><? }?></tr></table>
</div>




<div id='urlupload' style="display:none;">
<table><tr><td>
<b>Enter the full url to the file</b> <br>
(http://domain/folder/filename)<br>
<input type="text" name='fileurl' style="width:250px;" id='fileurl' > 
</td><td valign="top"><input type="button" value="Get Image" onClick='submit_form();'/> </td></tr></table>
</div>
<? if ($_GET['compact'] != 'yes') {?>
(optional) Resize width to: <input type="text" name="txtResizeWidth" style="width:50px;"/><br/>
<? }?>

</form>
</div>

<div id='progressdiv' align="center" style="display:none;" class="messageinfo_warning"><div style="height:10px;"></div>Please wait your item is being uploaded<div style="height:10px;"></div>
<img src='http://www.wevolt.com/images/progressBarLong.gif'></div>
</div>
</div>