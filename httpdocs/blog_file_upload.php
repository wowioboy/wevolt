<?php
 if(!isset($_SESSION)) {
    session_start();
  }
//******************************************************************************************************
//	Name: ubr_file_upload.php
//	Revision: 2.2
//	Date: 8:14 PM Thursday, August 28, 2008
//	Link: http://uber-uploader.sourceforge.net
//	Developer: Peter Schmandra
//	Description: Select and submit upload files.
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

$THIS_VERSION = '2.2';

require 'ubr_ini.php';
require 'ubr_lib.php';

if($PHP_ERROR_REPORTING){ error_reporting(E_ALL); }

header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

//Set config file
if($MULTI_CONFIGS_ENABLED){
	/////////////////////////////////////////////////////////////////////////
	//   ATTENTION
	//   Put your multi config file code here. eg
		if($_SESSION['uploadtype'] == 'media'){ 
		 		$config_file = 'blog_upload_config.php'; 
		}else {
			 $config_file = 'ubr_default_config.php';
		}
	 
	//   if($_COOKIE['user_name'] == 'TOM'){ $config_file = 'tom_config.php'; }
	/////////////////////////////////////////////////////////////////////////
}
else{ $config_file = $DEFAULT_CONFIG; }

// Load config file
require $config_file;

//***************************************************************************************************************
// The following possible query string formats are assumed
//
// 1. No query string
// 2. ?about
//***************************************************************************************************************
if($DEBUG_PHP){ phpinfo(); exit(); }
elseif($DEBUG_CONFIG){ debug($_CONFIG['config_file_name'], $_CONFIG); exit(); }
elseif(isset($_GET['about'])){
	kak("<u><b>UBER UPLOADER FILE UPLOAD</b></u><br>UBER UPLOADER VERSION =  <b>" . $UBER_VERSION . "</b><br>UBR_FILE_UPLOAD = <b>" . $THIS_VERSION . "</b><br>\n", 1, __LINE__, $PATH_TO_CSS_FILE);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>PANEL FLOW - PDF PAGE UPLOAD</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="-1">
		<meta name="robots" content="index,nofollow">
		<!-- Please do not remove this tag: Uber-Uploader Ver 6.5 http://uber-uploader.sourceforge.net -->
		<link rel="stylesheet" type="text/css" href="<?php print $PATH_TO_CSS_FILE; ?>">
		<script language="javascript" type="text/javascript">
			var path_to_link_script = "<?php print $PATH_TO_LINK_SCRIPT; ?>";
			var path_to_set_progress_script = "<?php print $PATH_TO_SET_PROGRESS_SCRIPT; ?>";
			var path_to_get_progress_script = "<?php print $PATH_TO_GET_PROGRESS_SCRIPT; ?>";
			var path_to_upload_script = "<?php print $PATH_TO_UPLOAD_SCRIPT; ?>";
			var multi_configs_enabled = <?php print $MULTI_CONFIGS_ENABLED; ?>;
			var check_allow_extensions_on_client = <?php print $_CONFIG['check_allow_extensions_on_client']; ?>;
			var check_disallow_extensions_on_client = <?php print $_CONFIG['check_disallow_extensions_on_client']; ?>;
			<?php if($_CONFIG['check_allow_extensions_on_client']){ print "var allow_extensions = /" . $_CONFIG['allow_extensions'] . "$/i;\n"; } ?>
			<?php if($_CONFIG['check_disallow_extensions_on_client']){ print "var disallow_extensions = /" . $_CONFIG['disallow_extensions'] . "$/i;\n"; } ?>
			var check_file_name_format = <?php print $_CONFIG['check_file_name_format']; ?>;
			var check_null_file_count = <?php print $_CONFIG['check_null_file_count']; ?>;
			var check_duplicate_file_count = <?php print $_CONFIG['check_duplicate_file_count']; ?>;
			var max_upload_slots = <?php print $_CONFIG['max_upload_slots']; ?>;
			var cedric_progress_bar = <?php print $_CONFIG['cedric_progress_bar']; ?>;
			var cedric_hold_to_sync = <?php print $_CONFIG['cedric_hold_to_sync']; ?>;
			var bucket_progress_bar = <?php print $_CONFIG['bucket_progress_bar']; ?>;
			var progress_bar_width = <?php print $_CONFIG['progress_bar_width']; ?>;
			var show_percent_complete = <?php print $_CONFIG['show_percent_complete']; ?>;
			var show_files_uploaded = <?php print $_CONFIG['show_files_uploaded']; ?>;
			var show_current_position = <?php print $_CONFIG['show_current_position']; ?>;
			var show_current_file = <?php if($CGI_UPLOAD_HOOK && $_CONFIG['show_current_file']){ print "1"; }else{ print "0"; } ?>;
			var show_elapsed_time = <?php print $_CONFIG['show_elapsed_time']; ?>;
			var show_est_time_left = <?php print $_CONFIG['show_est_time_left']; ?>;
			var show_est_speed = <?php print $_CONFIG['show_est_speed']; ?>;
			//var iframeheight = parent.document.getElementById("loaderframe").style.height;
			//iframeheight = iframeheight + 25;
			//parent.document.getElementById("loaderframe").style.height = '400px';
		
		</script>
		<script language="javascript" type="text/javascript" src="<?php print $PATH_TO_JS_SCRIPT; ?>"></script>
	</head>
	<body onLoad="iniFilePage()"   <? if ($_SESSION['uploadtype'] == 'selfpdf'){?>bgcolor="#000000"<? } ?>>
    <div>
		<div class="ubrWrapper">
			<?php if($DEBUG_AJAX){ print "<br><div id=\"ubr_debug\" class=\"ubrDebug\"></div><br>\n"; } ?>
			<div id="ubr_alert" class="ubrAlert"></div>

			<!-- Start Progress Bar -->

			<div align="center" id="progress_bar" style="display:none;">
				<div id="upload_status_wrap" class="ubrBar1" style="<?php print "width:" . $_CONFIG [ 'progress_bar_width' ]; ?>">
					<div id="upload_status" class="ubrBar2"></div>
				</div>
                <div style="height:10px;"></div>
				<?php if($_CONFIG['show_percent_complete'] || $_CONFIG['show_files_uploaded'] || $_CONFIG['show_current_position'] || $_CONFIG['show_elapsed_time'] || $_CONFIG['show_est_time_left'] || $_CONFIG['show_est_speed']){ ?>
				<table class="ubrUploadData">
					<?php if($_CONFIG['show_percent_complete']){ ?>
					<tr>
						<td class='ubrUploadDataLabel'>Percent Complete:</td>
						<td class='ubrUploadDataInfo'><span id="percent_complete">0%</span></td>
					</tr>
					<?php } ?>
					<?php if($_CONFIG['show_files_uploaded']){ ?>
					<tr>
						<td class='ubrUploadDataLabel'>Files Uploaded:</td>
						<td class='ubrUploadDataInfo'><span id="files_uploaded">0</span> of <span id="total_uploads"></span></td>
					</tr>
					<?php } ?>
					<?php if($_CONFIG['show_current_position']){ ?>
					<tr>
						<td class='ubrUploadDataLabel'>Current Position:</td>
						<td class='ubrUploadDataInfo'><span id="current_position">0</span> / <span id="total_kbytes"></span> KBytes</td>
					</tr>
					<?php } ?>
					<?php if($CGI_UPLOAD_HOOK && $_CONFIG['show_current_file']){ ?>
					<tr>
						<td class='ubrUploadDataLabel'>Current File Uploading:</td>
						<td class='ubrUploadDataInfo'><span id="current_file"></span></td>
					</tr>
					<?php } ?>
					<?php if($_CONFIG['show_elapsed_time']){ ?>
					<tr>
						<td class='ubrUploadDataLabel'>Elapsed Time:</td>
						<td class='ubrUploadDataInfo'><span id="elapsed_time">0</span></td>
					</tr>
					<?php } ?>
					<?php if($_CONFIG['show_est_time_left']){ ?>
					<tr>
						<td class='ubrUploadDataLabel'>Est Time Left:</td>
						<td class='ubrUploadDataInfo'><span id="est_time_left">0</span></td>
					</tr>
					<?php } ?>
					<?php if($_CONFIG['show_est_speed']){ ?>
					<tr>
						<td class='ubrUploadDataLabel'>Est Speed:</td>
						<td class='ubrUploadDataInfo'><span id="est_speed">0</span> KB/s.</td>
					</tr>
					<?php } ?>
				</table>
				<?php } ?>
			</div>
			<!-- End Progress Bar -->

			<?php if($_CONFIG['embedded_upload_results'] || $_CONFIG['opera_browser'] || $_CONFIG['safari_browser']){ ?>
			<div id="upload_div" style="display:none;"><iframe name="upload_iframe" frameborder="0" width="800" height="200" scrolling="auto"></iframe></div>
			<?php } ?>

			<!-- Start Upload Form -->
			<form name="uu_upload" id="uu_upload" <?php if($_CONFIG['embedded_upload_results'] || $_CONFIG['opera_browser'] || $_CONFIG['safari_browser']){ print "target=\"upload_iframe\""; } ?> method="post" enctype="multipart/form-data"  action="#" style="margin: 0px; padding: 0px;">
				<noscript><span class="ubrError">ERROR</span>: Javascript must be enabled to use this Uber-Uploader.<br><br></noscript>
                
                <div id='filesettings'>
                <div align="center" style="font-size:16px; color:#000000; font-family:Arial, Helvetica, sans-serif;">
                <? if ($_SESSION['uploadtype'] == 'selfprint'){?>
                <div style="color:#FFFFFF;">
                Please upload a preview image of your print
                </div>
                <? } else if ($_SESSION['uploadtype'] == 'podprint'){?>
                   <div style="color:#FFFFFF;">
                Please Select the file you want to have printed, minium resolution 300DPI. <br/>Supported Image Formats : (recommended) PSD, TIFF,PNG<br/>(not recommended) JPG, GIF
                </div>
                <? }?>
                </div>
            
				<?php
					// Include extra values you want passed to the upload script here.
				// eg. <input type="text" name="employee_num" value="5">
				// Access the value in the CGI with $query->param('employee_num');
				// Access the value in the PHP finished page with $_POST_DATA['employee_num'];
				// DO NOT USE "upfile_" for any of your values.
				?> 
				<div id="upload_slots"><input class="ubrUploadSlot" type="file" name="upfile_0" size="30" <?php if($_CONFIG['multi_upload_slots']){ ?>onChange="addUploadSlot(1)"<?php } ?>  onkeypress="return handleKey(event)" value=""> &nbsp;&nbsp;<input type="button" id="upload_button" name="upload_button" value="Upload" onClick="linkUpload();"> </div>
				   </div>
                 <input type='hidden' name='txtUser' value="<? echo $_SESSION['id'];?>">
                 <input type='hidden' name='txtComic' value="<? echo $_SESSION['comic'];?>">
                 <input type='hidden' name='txtWorld' value="<? echo $_SESSION['world'];?>">
			</form>
			<!-- End Upload Form -->
		</div>
        </div>
		<div id='ajax_div'><!-- Used to store AJAX --></div>
	</body>
</html>