<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php'); ?>

<script type="text/javascript" src="/<? echo $_SESSION['pfdirectory'];?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<?
$PageID = $_GET['pageid'];
if ($PageID =='')
	$PageID = $_POST['txtPage'];

$query = "select cp.HTMLFile,c.HostedUrl from comic_pages as cp 
		  join comics as c on cp.ComicID=c.comiccrypt
 		  where ParentPage='$PageID' and PageType='script'";
$PageArray = $InitDB->queryUniqueObject($query);

$HTMLFile = $PageArray->HTMLFile;
$HostedUrl = $PageArray->HostedUrl;
if ($HTMLFile != '') 
	$HtmlContent = @file_get_contents('http://www.wevolt.com/'.$_SESSION['basefolder'].'/'.$_SESSION['projectfolder'].'/images/pages/'.$HTMLFile);

if ($_POST['txtEdit']==1) { 
$HtmlContent = $_POST['pf_post'];
$OldFile = $_POST['ScriptHTML'];

//print 'OLD CONTENT = ' . $OldFile."<br/>";
$HTMLFile = $_SESSION['sessionproject'].'_'.strtotime("now").".html"; 
//print 'temp/'.$HTMLFile.'<br/>'; 
$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/temp/'.$HTMLFile,'w');
$write = fwrite($fp,$HtmlContent);
chmod($_SERVER['DOCUMENT_ROOT'].'/temp/'.$HTMLFile,0777);
//unlink('../comics/'.$HostedUrl.'/images/pages/'.$OldFile);

?>
<script language="javascript" type="text/javascript">

from_mysql_obj          = window.parent.document.getElementById( 'txtPeelFourFilename' );
from_mysql_obj.value = '<?php echo $HTMLFile; ?>';
window.parent.document.getElementById( 'scriptdiv' ).innerHTML = 'PAGE UPLOADED, IMAGE WILL BE PROCESSED ON SAVE';

//alert('FILE = ' + from_mysql_obj.value); 
//parent.document.getElementById( 'uploadModal' ).style.display = 'none';
/*
//document.location.href = "/<? //echo $PFDIRECTORY;?>/script_write.php?pageid=<? //echo $_GET['pageid'];?>";
*/
window.parent.document.getElementById("savealert").innerHTML = '<div style=\"padding:5px;\">You will need to still save your changes to take effect</div>';
parent.$.modal().close();
</script>

<? }

?>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
  <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
</head>
<body>
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center"> 
<form action="#" method="post">
<center><div class="spacer"></div>
<input type="image" src="http://www.wevolt.com/images/wizard_save_btn.png" style="background:none;border:none;"/>&nbsp;<img src="http://www.wevolt.com/images/wizard_cancel_btn.png"  onClick="parent.$.modal().close();" class="navbuttons" /></center>
<div class="messageinfo_white" style="font-size:10px;">
You can enter just text, 
or paste HTML code by clicking the [html] button
</div>
<textarea name="content" id="content" style="width:550px; height:325px;"><? echo $HtmlContent;?></textarea>

<input type="hidden" name="txtPage" value="<? echo $PageID; ?>">
<input type="hidden" name="ScriptHTML" value="<? echo $HTMLFile; ?>">
<input type="hidden" name="txtEdit" value="1">
</form>
</div>
<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
	skin : "o2k7",
	spellchecker_rpc_url : '/<? echo $_SESSION['pfdirectory'];?>/tinymce/jscripts/tiny_mce/plugins/spellchecker/rpc.php',

    theme_advanced_buttons1 : "mybutton,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,|,cut,copy,paste,pastetext,pasteword,|,link,unlink,anchor,cleanup,help,code",
    theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,image,media,|,preview,fullscreen",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
	theme_advanced_source_editor_width: "550px",
	theme_advanced_source_editor_height: "375px",
    plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
    setup : function(ed) {
        // Add a custom button
        ed.addButton('mybutton', {
            title : 'My button',
            image : 'img/example.gif',
            onclick : function() {
				// Add you own code to execute something on click
				ed.focus();
                ed.selection.setContent('<strong>Hello world!</strong>');
            }
        });
    }
});
</script>
