<?php
 if(!isset($_SESSION)) {
    session_start();
  }
//******************************************************************************************************
//	Name: ubr_finished.php
//	Revision: 2.1
//	Date: 11:26 AM Saturday, September 20, 2008
//	Link: http://uber-uploader.sourceforge.net
//	Developer: Peter Schmandra
//	Description: Show successful file uploads.
//
//	BEGIN LICENSE BLOCK
//	The contents of this file are subject to the Mozilla Public License
//	Version 1.1 (the "License"); you may not use this file except in
//	compliance with the License. You may obtain a copy of the License
//	at http://www.mozilla.org/MPL/
//
//	Software distributed under the License is distributed on an "AS IS"
//	basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See
//	the License for the specific language governing rights and
//	limitations under the License.
//
//	Alternatively, the contents of this file may be used under the
//	terms of either the GNU General Public License Version 2 or later
//	(the "GPL"), or the GNU Lesser General Public License Version 2.1
//	or later (the "LGPL"), in which case the provisions of the GPL or
//	the LGPL are applicable instead of those above. If you wish to
//	allow use of your version of this file only under the terms of
//	either the GPL or the LGPL, and not to allow others to use your
//	version of this file under the terms of the MPL, indicate your
//	decision by deleting the provisions above and replace them with the
//	notice and other provisions required by the GPL or the LGPL. If you
//	do not delete the provisions above, a recipient may use your
//	version of this file under the terms of any one of the MPL, the GPL
//	or the LGPL.
//	END LICENSE BLOCK
//***************************************************************************************************************

//***************************************************************************************************************
// The following possible query string formats are assumed
//
// 1. ?upload_id=32_character_alpha_numeric_string
// 2. ?about
//****************************************************************************************************************

$THIS_VERSION = "2.1";                                // Version of this file
$UPLOAD_ID = '';                                      // Initialize upload id

require 'ubr_ini.php';
require 'ubr_lib.php';
require 'ubr_finished_lib.php';
include 'includes/db.class.php';
//require 'ubr_image_lib.php';

if($PHP_ERROR_REPORTING){ error_reporting(E_ALL); }

header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
?>

  <?      
if(isset($_GET['upload_id']) && preg_match("/^[a-zA-Z0-9]{32}$/", $_GET['upload_id'])){ $UPLOAD_ID = $_GET['upload_id']; }
elseif(isset($_GET['about'])){ kak("<u><b>UBER UPLOADER FINISHED PAGE</b></u><br>UBER UPLOADER VERSION =  <b>" . $UBER_VERSION . "</b><br>UBR_FINISHED = <b>" . $THIS_VERSION . "<b><br>\n", 1 , __LINE__, $PATH_TO_CSS_FILE); }
else{ kak("<span class='ubrError'>ERROR</span'>: Invalid parameters passed<br>", 1, __LINE__, $PATH_TO_CSS_FILE); }

//Declare local values
$_XML_DATA = array();                                          // Array of xml data read from the upload_id.redirect file
$_CONFIG_DATA = array();                                       // Array of config data read from the $_XML_DATA array
$_POST_DATA = array();                                         // Array of posted data read from the $_XML_DATA array
$_FILE_DATA = array();                                         // Array of 'FileInfo' objects read from the $_XML_DATA array
$_FILE_DATA_TABLE = '';                                        // String used to store file info results nested between <tr> tags
$_FILE_DATA_EMAIL = '';                                        // String used to store file info results

$xml_parser = new XML_Parser;                                  // XML parser
$xml_parser->setXMLFile($TEMP_DIR, $_REQUEST['upload_id']);    // Set upload_id.redirect file
$xml_parser->setXMLFileDelete($DELETE_REDIRECT_FILE);          // Delete upload_id.redirect file when finished parsing
$xml_parser->parseFeed();                                      // Parse upload_id.redirect file

// Display message if the XML parser encountered an error
if($xml_parser->getError()){ kak($xml_parser->getErrorMsg(), 1, __LINE__, $PATH_TO_CSS_FILE); }

$_XML_DATA = $xml_parser->getXMLData();                        // Get xml data from the xml parser
$_CONFIG_DATA = getConfigData($_XML_DATA);                     // Get config data from the xml data
$_POST_DATA  = getPostData($_XML_DATA);                        // Get post data from the xml data
$_FILE_DATA = getFileData($_XML_DATA);                         // Get file data from the xml data


// Output XML DATA, CONFIG DATA, POST DATA, FILE DATA to screen and exit if DEBUG_ENABLED.
if($DEBUG_FINISHED){
	if($_CONFIG_DATA['embedded_upload_results'] == 1){ scriptParent(); }

	debug("<br><u>XML DATA</u>", $_XML_DATA);
	debug("<u>CONFIG DATA</u>", $_CONFIG_DATA);
	debug("<u>POST DATA</u>", $_POST_DATA);
	debug("<u>FILE DATA</u><br>", $_FILE_DATA);
	exit;
}


/////////////////////////////////////////////////////////////////////////////////////////////////
//
//           *** ATTENTION: ENTER YOUR CODE HERE !!! ***
//
//	This is a good place to put your post upload code. Like saving the
//	uploaded file information to your DB or doing some image
//	manipulation. etc. Everything you need is in the
//	$XML DATA, $_CONFIG_DATA, $_POST_DATA and $_FILE_DATA arrays.
//
/////////////////////////////////////////////////////////////////////////////////////////////////
//	NOTE: You can now access all XML values below this comment. eg.
//	$_XML_DATA['upload_dir']; or $_XML_DATA['link_to_upload'] etc
/////////////////////////////////////////////////////////////////////////////////////////////////
//	NOTE: You can now access all config values below this comment. eg.
//	$_CONFIG_DATA['upload_dir']; or $_CONFIG_DATA['link_to_upload'] etc
/////////////////////////////////////////////////////////////////////////////////////////////////
//	NOTE: You can now access all post values below this comment. eg.
//	$_POST_DATA['client_id']; or $_POST_DATA['check_box_1_'] etc
/////////////////////////////////////////////////////////////////////////////////////////////////
//	NOTE: You can now access all file (slot, name, size, type) info below this comment. eg.
//	$_FILE_DATA['upfile_0']->name  or  $_FILE_DATA['upfile_0']->getFileInfo('name')
/////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	Create thumnail example.
//	createThumbFile(source_file_path, source_file_name, thumb_file_path, thumb_file_name, thumb_file_width, thumb_file_height)
//
//	EXAMPLE
//	$file_extension = getFileExtension($_FILE_DATA['upfile_0']->name);
//
//	if($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png'){ $success = createThumbFile($_CONFIG_DATA['upload_dir'], $_FILE_DATA['upfile_0']->name, $_CONFIG_DATA['upload_dir'], 'thumb_' . $_FILE_DATA['upfile_0']->name, 120, 100); }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Create file upload table
$_FILE_DATA_TABLE = getFileDataTable($_FILE_DATA, $_CONFIG_DATA, $_POST_DATA);

// Create and send email
if($_CONFIG_DATA['send_email_on_upload']){ emailUploadResults($_FILE_DATA, $_CONFIG_DATA, $_POST_DATA); }
$TaskID = $_POST_DATA['txtTask'];
$UserID = $_POST_DATA['txtUser'];
$FileCategory = $_POST_DATA['txtFileCategory'];
$Title = mysql_escape_string($_POST_DATA['txtTitle']);
$Description = mysql_escape_string($_POST_DATA['txtDescription']);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>Task File Upload</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="-1">
		<meta name="robots" content="none">
		<link rel="stylesheet" type="text/css" href="<?php print $PATH_TO_CSS_FILE; ?>">
        <script type="text/javascript">
		function addpage(pageid) {
			var CurrentPageString = parent.document.getElementById("txtPages").value;
				CurrentPageString = CurrentPageString + '||'+ pageid;
				parent.document.getElementById("txtPages").value = CurrentPageString;
				//alert('PAGE = ' + parent.document.getElementById("txtPages").value);
		}
		
		function addthumb(thumbid) { 
		var CurrentThumbString = parent.document.getElementById("txtThumbs").value;
			CurrentThumbString = CurrentThumbString + ','+thumbid;
			parent.document.getElementById("txtThumbs").value = CurrentThumbString;
			//alert('THUMB = ' + parent.document.getElementById("txtThumbs").value);
		}
		</script>
	</head>
	<body <? if ($_SESSION['uploadtype'] == 'selfpdf'){?>bgcolor="#000000"<? } ?>>
      <div style="color:#000000;">
    <div class="ubrAlert" align="center"><div class='spacer'></div>Please wait while your files are processed<div class='spacer'></div></div>

<? 
if ($_SESSION['uploadtype'] != 'selfpdf') {

include 'includes/image_resizer.php';
include 'includes/image_functions.php';
$NumFiles = sizeof($_FILE_DATA);
$count = 0;
$randDirectory =  $_SESSION['pdftempdirectory'];
$StartingPage = $_SESSION['pdf_nextpage'];
$PageCount = $StartingPage;
while ($count < $NumFiles) {
	if (strlen($PageCount) == 2) {
		$FileName = 'page_'.$PageCount;
		$TimesCount = 0;
	} else if (strlen($Count) == 3) {
		$FileName = 'page__'.$PageCount;
	}else { 
		$FileName = 'page'.$PageCount;
	}
	$PageCount++;
	$_SESSION['pdf_nextpage'] = $PageCount;
	$FileData ="upfile_".$count;
	$ext = getFileExtension($_FILE_DATA[$FileData]->name);
	$originalimage = "temp/".$_FILE_DATA[$FileData]->name;
	$OriginalFile = 'imported/temp/'.$randDirectory.'/'. $FileName .'.'. $ext;
	copy($originalimage,$OriginalFile);
	chmod($OriginalFile,0777);
	$CurrentFile = $OriginalFile;
	list($width,$height)=getimagesize($CurrentFile);
				
	if ($width > 800) {
		$convertString = "convert $CurrentFile -resize 800 $CurrentFile";
		exec($convertString);	
	}
	if ($height > 1214) {
		$convertString = "convert $CurrentFile -resize x1214 $CurrentFile";
		exec($convertString);	
	}
				
					
	$image = new imageResizer('imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext);
	$Thumbsm = 'imported/temp/'.$randDirectory.'/thumbs/'.$FileName.'_tb.jpg';
	$image->resize(100, 100,100, 100);
	$image->save($Thumbsm, JPG);
	chmod($Thumbsm,0777);
	$count++;
	?>	
 <script language="javascript" type="text/javascript">
 	addpage('<? echo 'imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext;?>');
 	addthumb('<? echo $Thumbsm;?>');
 </script>
<? } ?>

 <script language="javascript" type="text/javascript">
	ComicID = parent.document.getElementById("txtSafeFolder").value;
	parent.document.PageForm.action='/create/pdf/'+ComicID+'/';
	parent.document.PageForm.submit();
</script>
<? } else if ($_SESSION['uploadtype'] == 'selfpdf') {

	
	$randName = md5(rand() * time());
	$OriginalPDF = "temp/".$_FILE_DATA['upfile_0']->getFileInfo('name');

	chmod($OriginalPDF,0777);
	copy($OriginalPDF,'users/'.$_SESSION['username'].'/pdfs/'.$randName.'.pdf');

	chmod('users/'.$_SESSION['username'].'/pdfs/'.$randName.'.pdf',0777);
	unlink($OriginalPDF);
	$DownloadFile= 'users/'.$_SESSION['username'].'/pdfs/'.$randName.'.pdf';
	if ($_SESSION['action'] == 'new') {
	?>
     <script language="javascript" type="text/javascript">
		ComicID = parent.document.getElementById("txtSafeFolder").value;
		parent.document.getElementById("txtFilename").value = 'users/<? echo $_SESSION['username'];?>/pdfs/<? echo $randName;?>.pdf';
		parent.document.PageForm.action='/cms/edit/'+ComicID+'/?section=products&sub=ebook&a=finish';
		parent.document.PageForm.submit();
		</script>
<? 
	} else if ($_SESSION['action'] == 'edit') {
		$DB = new DB();
		$ItemID = $_SESSION['itemid'];
		$query = "UPDATE pf_store_items set DownloadFile ='$DownloadFile' where EncryptID='$ItemID'";
		$DB->execute($query);
		print $query;
		$DB->close(); ?>
    <script language="javascript" type="text/javascript">
		parent.document.getElementById("txtPDFLINK").innerHTML = '<a href=\"/users/<? echo $_SESSION['username'];?>/pdfs/<? echo $randName;?>.pdf\" target=\"_blank\"><img src=\"/pf_16_core/images/pdf_big.png\" border=\"0\"></a>';
		document.location='/pdf_file_upload.php';
		</script>     
   <?
	}

}?>


</div>
	</body>
    
</html>