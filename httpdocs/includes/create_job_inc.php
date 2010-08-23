<? 
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php');

function convert_datetime($str) 
{

list($date, $time) = explode(' ', $str);
list($year, $month, $day) = explode('-', $date);
list($hour, $minute, $second) = explode(':', $time);

$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

return $timestamp;
}
function hourmin($id ,$pval = "")
{
	$times = array('00:00:00' => '12:00 am',
					'00:15:00' => '12:15 am',
				   '00:30:00' => '12:30 am',
				   '00:45:00' => '12:45 am',
				   '01:00:00' => '1:00 am',
				   '01:15:00' => '1:15 am',
				   '01:30:00' => '1:30 am',
				   '01:45:00' => '1:45 am',
					'02:00:00' => '2:00 am',
					'02:15:00' => '2:15 am',
					'02:30:00' => '2:30 am',
					'02:45:00' => '2:45 am',
				    '03:00:00' => '3:00 am',
					'03:30:00' => '3:30 am',
					'04:00:00' => '4:00 am',
					'04:30:00' => '4:30 am',
					'05:00:00' => '5:00 am',
					'05:30:00' => '5:30 am',
					'06:00:00' => '6:00 am',
					'06:30:00' => '6:30 am',
					'07:00:00' => '7:00 am',
	'07:30:00' => '7:30 am',
	'08:00:00' => '8:00 am',
	'08:30:00' => '8:30 am',
	'09:00:00' => '9:00 am',
	'09:30:00' => '9:30 am',
	'10:00:00' => '10:00 am',
	'10:30:00' => '10:30 am',
	'11:00:00' => '11:00 am',
	'11:30:00' => '11:30 am',
	'12:00:00' => '12:00 pm',
	'12:30:00' => '12:30 pm',
	'13:00:00' => '1:00 pm',
	'13:30:00' => '1:30 pm',
	'14:00:00' => '2:00 pm',
	'14:30:00' => '2:30 pm',
	'15:00:00' => '3:00 pm',
	'15:30:00' => '3:30 pm',
	'16:00:00' => '4:00 pm',
	'16:30:00' => '4:30 pm',
	'17:00:00' => '5:00 pm',
	'17:30:00' => '5:30 pm',
	'18:00:00' => '6:00 pm',
	'18:30:00' => '6:30 pm',
	'19:00:00' => '7:00 pm',
	'19:30:00' => '7:30 pm',
	'20:00:00' => '8:00 pm',
	'20:30:00' => '8:30 pm',
	'21:00:00' => '9:00 pm',
	'21:30:00' => '9:30 pm',
	'22:00:00' => '10:00 pm',
	'22:30:00' => '10:30 pm',
	'23:00:00' => '11:00 pm',
	'23:30:00' => '11:30 pm');
	$out = '<select name="'.$id.'">';
	$out .="<option value=\"\"";
	if ($pval == '')
			$out.= " selected ";
		$out .= ">-set-</option>"; 
	foreach ($times as $actual => $display) {
		$out .= "<option value=\"$actual\"";
		if ($pval == $actual)
			$out.= " selected ";
		$out .= ">$display</option>";
	}
	$out .= '</select>';
	return $out;
}

    function DateSelector($inName, $useDate='') 
    { 
    	$string = '<input name="'.$inName.'" class="datepicker" type="text" value="'.$useDate.'" style="width:75px;"/>';
 return $string;
} 

 function DayDropdown($inName, $useDate='') 
    { 
 return $string;
} 
$CloseWindow = 0;
if ($_POST['save'] == 1) {
		$StartDate = $_REQUEST['start_date'];
   	    $Expires = $_REQUEST['expire_date']; 
		$CreatedDate = date('Y-m-d').' 00:00:00';	
		if ($_POST['no_end'] == 1)
			$StartDate = '0000-00-00 00:00:00';
			
		$query = "INSERT into pf_jobs (
					user_id,
					title,
					description,
					deadline_notes,
					deadline,
					tags,
					created_date,
					job_type,
					media_id,
					local,
					zip,
					project_id,
					zip_radius,
					expire_date
					) values (
					'".$_SESSION['userid']."',
					'".mysql_real_escape_string($_POST['txtTitle'])."',
					'".mysql_real_escape_string($_POST['txtDescription'])."',
					'".mysql_real_escape_string($_POST['txtDeadlineNotes'])."',
					'".$StartDate."',					
					'".mysql_real_escape_string($_POST['txtTags'])."',
					'".$CreatedDate."',
					'".mysql_real_escape_string($_POST['ProjectType'])."',
					'".mysql_real_escape_string($_POST['mediaSelect'])."',
					'".mysql_real_escape_string($_POST['txtLocal'])."',
					'".mysql_real_escape_string($_POST['txtZip'])."',
					'".mysql_real_escape_string($_POST['txtProject'])."',
					'".mysql_real_escape_string($_POST['txtZipRadius'])."',
					'".mysql_real_escape_string($_POST['expire_date'])."'
					)";
					
					$InitDB->execute($query);
					print $query.'<br/>';
					$query ="SELECT ID from pf_jobs where created_date='$CreatedDate' and user_id='".$_SESSION['userid']."'";
					$ID = $InitDB->queryUniqueValue($query);
					print $query.'<br/>';
					$Encryptid = substr(md5($ID), 0, 15).dechex($ID);
					$IdClear = 0;
					$Inc = 5;
					while ($IdClear == 0) {
									$query = "SELECT count(*) from pf_jobs where encrypt_id='$Encryptid'";
									$Found = $InitDB->queryUniqueValue($query);
									$output .= $query.'<br/>';
									if ($Found == 1) {
										$Encryptid = substr(md5(($ID+$Inc)), 0, 15).dechex($ID+$Inc);
									} else {
										$query = "UPDATE pf_jobs SET encrypt_id='$Encryptid' WHERE ID='$ID'";
										$InitDB->execute($query);
										$output .= $query.'<br/>';
										$IdClear = 1;
									}
									$Inc++;
							}
					$query = "INSERT into pf_jobs_positions (
								job_id,
								job_type,
								description,
								rate,
								rate_type,
								created_date	
								) values (
								'".$ID."',
								'".mysql_real_escape_string($_POST['posSelect_1'])."',
								'".mysql_real_escape_string($_POST['txtPosDesc_1'])."',
								'".mysql_real_escape_string($_POST['txtPosRate_1'])."',
								'".mysql_real_escape_string($_POST['txtPosRateType_1'])."',
								'".$CreatedDate."'
								
								)";	
					print $query.'<br/>';
					$InitDB->execute($query);
					$query ="SELECT ID from pf_jobs_positions where created_date='$CreatedDate' and job_id='$ID'";
					$PID = $InitDB->queryUniqueValue($query);
					print $query.'<br/>';
					$Encryptid = substr(md5($PID), 0, 15).dechex($PID);
					$IdClear = 0;
					$Inc = 5;
					while ($IdClear == 0) {
									$query = "SELECT count(*) from pf_jobs_positions where encrypt_id='$Encryptid'";
									$Found = $InitDB->queryUniqueValue($query);
									$output .= $query.'<br/>';
									if ($Found == 1) {
										$Encryptid = substr(md5(($PID+$Inc)), 0, 15).dechex($PID+$Inc);
									} else {
										$query = "UPDATE pf_jobs_positions SET encrypt_id='$Encryptid' WHERE ID='$PID'";
										$InitDB->execute($query);
										$output .= $query.'<br/>';
										$IdClear = 1;
									}
									$Inc++;
							}
					insertUpdate('job', 'posted', $Encryptid,'user',$_SESSION['userid'],'http://www.wevolt.com/jobs.php?view='.$Encryptid,'',$_POST['txtTitle']);
					
					if ($_POST['numPositions'] > 1) {
						
						
						
						
					}
					$CloseWindow = 1;
}
	$InitDB->close();

if ($CloseWindow == 1) {
?>
<script type="text/javascript">
window.document.location.href='/jobs.php';
</script>
<? 
}

if (!$Start = $_REQUEST['start_date']) {
	$Start = date('Y-m-d');
} else {
	$Start 	= $_REQUEST['start_date'];
	
}
if (!$End = $_REQUEST['end_date']) {
	$End = date('Y-m-d');
} else {
	$End = $_REQUEST['end_date'];
	
}

if ($_POST['expire_date'] == '')
	$Expires = date("Y-m-d",strtotime("+1 months"));
else
$Expires = $_POST['expire_date'];

?>
<script>
$(document).ready(function() {
	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd'
	});
});

function submit_form() {
	document.getElementById("save").value = 1;
	
	document.jobform.submit();
}

function toggle_deadline() {
	
	if (document.getElementById("deadline_div").style.display == ''){
			document.getElementById("deadline_div").style.display = 'none';
	}else{
		document.getElementById("deadline_div").style.display = '';
	}
}


function toggle_local() {
	if (document.getElementById("local_zip").style.display == '')
		document.getElementById("local_zip").style.display = 'none';
	else
		document.getElementById("local_zip").style.display = '';
}

function select_media(value) {

var CurrentMedia = 
document.contentform.templateselect.length = 0;
					document.contentform.templateselect.options[0] = new Option("--SELECT TEMPLATE--", "lightbox", false, false);
				if (value == 'gallery') {
					document.contentform.templateselect.options[1] = new Option("Each gallery item listed in thumbnails and enlarged image pops up in a lightbox", "lightbox", false, false);
					document.contentform.templateselect.options[2] = new Option("Each gallery item listed in thumbnails and enlarged image is loaded in a new page", "standard", false, false);
					document.contentform.templateselect.options[3] = new Option("Flash Gallery - Thumbnails appear on the side, image loads in center", "flash_gallery_one", false, false);
					document.contentform.templateselect.options[4] = new Option("---", "", false, false);
					document.contentform.templateselect.options[5] = new Option("Custom HTML", "custom", false, false);
				}
				if ((value == 'downloads') || (value == 'mobile')|| (value == 'products')) {
					document.contentform.templateselect.options[1] = new Option("Thumbnail list with tabs for each section", "tabbed", false, false);
					document.contentform.templateselect.options[2] = new Option("---", "", false, false);
					document.contentform.templateselect.options[3] = new Option("Custom HTML", "custom", false, false);
				}
				if (value == 'characters') {
					document.contentform.templateselect.options[1] = new Option("Thumbnail w/ Reveal", "html_one", false, false);
					document.contentform.templateselect.options[2] = new Option("Thumbnail w/ Pop Up", "html_two", false, false);
					document.contentform.templateselect.options[3] = new Option("Vertical List", "html_three", false, false);
					document.contentform.templateselect.options[4] = new Option("---", "", false, false);
					document.contentform.templateselect.options[5] = new Option("Custom HTML", "custom", false, false);
				}
				if (value == 'blog') {
					document.contentform.templateselect.options[1] = new Option("2 Column w/ Module Sidebar", "column_split", false, false);
					document.getElementById("savebutton").style.display = '';
				}
				if (value == 'archives') {
					document.contentform.templateselect.options[1] = new Option("Thumbnail list", "thumb_list", false, false);
					document.contentform.templateselect.options[2] = new Option("Thumbnail list with Page Titles", "thumb_list_title", false, false);
					document.contentform.templateselect.options[3] = new Option("---", "", false, false);
					document.contentform.templateselect.options[4] = new Option("Custom HTML", "custom", false, false);
					
				}
				if (value == 'episodes') {
					document.contentform.templateselect.options[1] = new Option("Tabbed - Each episode has thumb and synopsis", "tabbed", false, false);
					document.contentform.templateselect.options[2] = new Option("Vertical list of each episode", "vertical_list", false, false);
					document.contentform.templateselect.options[3] = new Option("---", "", false, false);
					document.contentform.templateselect.options[4] = new Option("Custom HTML", "custom", false, false);
					
				}
				if (value == 'credits') {
					document.contentform.templateselect.options[1] = new Option("Each creator has own tab with Avatar and bio", "tabbed", false, false);
					document.contentform.templateselect.options[2] = new Option("Each creator is listed veritcally with name,thumb, bio and website", "vertical_list", false, false);	
					document.contentform.templateselect.options[3] = new Option("---", "", false, false);
					document.contentform.templateselect.options[4] = new Option("Custom HTML", "custom", false, false);																		}
				if (value == 'links') {
					document.contentform.templateselect.options[1] = new Option("Links listed veritcally with a description and image.", "vertical_list", false, false);
					document.contentform.templateselect.options[2] = new Option("---", "", false, false);
					document.contentform.templateselect.options[3] = new Option("Custom HTML", "custom", false, false);
				
				}
				
				if (value == 'home') {
					document.contentform.templateselect.options[1] = new Option("2 Column Layout.", "2_column", false, false);
					document.contentform.templateselect.options[2] = new Option("Page Reader", "reader", false, false);
					document.contentform.templateselect.options[3] = new Option("---", "", false, false);
					document.contentform.templateselect.options[4] = new Option("Custom HTML", "custom", false, false);
					
				
				} else {
				
					document.getElementById("home_settings").style.display = 'none';

				}
			
				if (value != '') 
								document.getElementById("section_settings").style.display = '';
					
				if (value != 'custom') 
					document.getElementById("tempateselect_div").style.display = '';
				if (value == 'custom') {
					 init_tiny();
						document.getElementById("customdiv").style.display = '';
						document.getElementById("tempateselect_div").style.display = 'none';
						document.getElementById("savebutton").style.display = '';
						
						

				} else {
						document.getElementById("tempateselect_div").style.display = '';
						document.getElementById("customdiv").style.display = 'none';
				}
}

function select_position(element,title) {
	document.getElementById(element).innerHTML=title;	
	}
	
	function select_type(type) {
		
	if	(type == 'collaboration'){
		document.getElementById("posRateDiv_1").style.display="none";
		document.getElementById("posRateTypeDiv_1").style.display="none";
		
		document.getElementById("posRateCollab").style.display="";
	}else{
		document.getElementById("posRateDiv_1").style.display="";
		document.getElementById("posRateTypeDiv_1").style.display="";
		document.getElementById("posRateCollab").style.display="none";
	}
	}
	
	function add_position() {
			var container = document.getElementById('positionDiv');
			var numPositions = document.getElementById('numPositions').value;
		
				numPositions++;
				var new_element = document.createElement('div');
				document.getElementById('numPositions').value = numPositions;
		var html = '<table width=\"592\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td id=\"wizardBox_TL\"></td><td id=\"wizardBox_T\"></td><td id=\"wizardBox_TR\"></td></tr><tr><td class=\"wizardboxcontent\"></td><td class=\"wizardboxcontent\" valign=\"top\" width=\"576\" align=\"left\">';
		
		html += '<div style=\"height:10px;\"></div><font style=\"font-size:16px;font-weight:bold;\">PAGE '+numfiles+'</font> <div style=\"padding:5px;\">PAGE TITLE:<input type=\"text\" name=\"title'+(numfiles-1)+'\" style=\"width:98%;\"><br>PAGE COMMENT:<br><textarea name=\"comment'+(numfiles-1)+'\" style=\"width:98%; height:50px;\"></textarea>CHOOSE FILE: <input type=\"file\" name=\"images[]\" style=\"width:100%;\"><div style=\"height:5px;\"></div>START DATE: <input name=\"date'+(numfiles-1)+'\" type=\"text\" id=\"date'+(numfiles-1)+'\" size=\"10\" value=\"<? echo $Today;?>\">&nbsp;<img src=\"/<? echo $_SESSION['pfdirectory'];?>/images/cal.gif\" onClick=\"displayDatePicker(\'date'+(numfiles-1)+'\',false,\'dmy\',\'-\');\" class=\"calpick\">&nbsp;&nbsp;<input type=\"checkbox\" name=\"chapter'+(numfiles-1)+'\" value=\"1\" style=\"border:none;background-color:#fdd8b3;\"/>Chapter Start</div>';
		
		html += '</td><td class=\"wizardboxcontent\"></td></tr><tr><td id=\"wizardBox_BL\"></td><td id=\"wizardBox_B\"></td><td id=\"wizardBox_BR\"></td></tr></tbody></table>';
		new_element.innerHTML =html;
		new_element.className ='uploadbox';
		container.appendChild(new_element); 
	
		
		
	}
</script>
<form method="post" action="#" name="jobform" id="jobform">
<table>
<tr>
<td>
<div align="left">post new job: </div><div class="spacer"></div>
<table width="<? echo ($_SESSION['contentwidth']-50);?>" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
				  <td id="blue_cmsBox_TL"></td>
				  <td id="blue_cmsBox_T"></td>
				  <td id="blue_cmsBox_TR"></td></tr>
				  <tr>
                  <td class="blue_cmsBox_L" background="http://www.wevolt.com/images/cms/blue_cms_box_L.png" width="8"></td>
				 
                  <td class="blue_cmsboxcontent" valign="top" width="<? echo ($_SESSION['contentwidth']-66);?>" align="left">
 <table cellspacing="10"><tr><td valign="top">
          <table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
												<td id="grey_cmsBox_TL"></td>
												<td id="grey_cmsBox_T"></td>
												<td id="grey_cmsBox_TR"></td></tr>
												<tr><td class="grey_cmsBox_L" background="http://www.wevolt.com/images/cms/grey_cms_box_L.png" width="8"></td>
												<td class="grey_cmsboxcontent" valign="top" width="384" align="left">
                                                
                                                <b>Headline:</b><br />
<input type="text" style="width:98%;" id="txtTitle" name="txtTitle" value="<? if (isset($_POST['txtTitle'])) echo $_POST['txtTitle']; else echo $JobArray->title;?>"/><div class="spacer"></div><b>Project Description:</b><em>&nbsp;(general info about your project, avalable positions are below)</em> <br />

<textarea name="txtDescription" id="txtDescription" style="width:98%; height:100px;"><? if (isset($_POST['txtDescription'])) echo $_POST['txtDescription']; else echo $JobArray->description;?></textarea> 
<div class="spacer"></div><b>Tags: </b><br />

<textarea name="txtTags" id="txtTags" style="width:98%;"><? if (isset($_POST['txtTags'])) echo $_POST['txtTags']; else echo $JobArray->tags;?></textarea> 
<div class="spacer"></div>
<table><tr><td>Project Type</td><td><select name="ProjectType" id="ProjectType" onchange="select_type(this.options[this.selectedIndex].value);">
<option value="contract">Contract / Work For Hire</option>
<option value="collaboration">Collaboration / Partner</option>
<option value="fee_royalties">Fee and Royalties</option>

</select></td></tr></table>


                                                </td><td class="grey_cmsBox_R" background="http://www.wevolt.com/images/cms/grey_cms_box_R.png" width="8"></td>
		
								</tr><tr><td id="grey_cmsBox_BL"></td><td id="grey_cmsBox_B"></td>
								<td id="grey_cmsBox_BR"></td>
								</tr></tbody></table>
                                
                                <div class="spacer"></div>
                                 <table width="400" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
												<td id="grey_cmsBox_TL"></td>
												<td id="grey_cmsBox_T"></td>
												<td id="grey_cmsBox_TR"></td></tr>
												<tr><td class="grey_cmsBox_L" background="http://www.wevolt.com/images/cms/grey_cms_box_L.png" width="8"></td>
                                               
												<td class="grey_cmsboxcontent" valign="top" width="384" align="left">
                                                <table width="100%" cellspacing="10"><tr><td>
                                                Media Type: &nbsp;&nbsp;
                               <?
							   if ($_POST['mediaselect'] != '')
							   		$MediaID =  $_POST['mediaselect'];
								else  if ($JobArray->media_id != '')
									$MediaID = $JobArray->media_id;
								else 
									$MediaID = 1;
									
							    $jobs->drawMediaSelect($MediaID,'select_media(this.options[this.selectedIndex].value)');?>
                                </td>
                                <td>
                                Position: &nbsp;&nbsp;
                               <?
							    $jobs->drawCatSelect($MediaID,'',"select_position('posTitle_1',this.options[this.selectedIndex].text)",'posSelect_1');?>
                                </td>
                               <!-- <td><img src="http://www.wevolt.com/images/add_position.png" class="navbuttons" onclick="add_position();"/></td>-->
                                </tr></table>
                                                </td><td class="grey_cmsBox_R" background="http://www.wevolt.com/images/cms/grey_cms_box_R.png" width="8"></td>
		
								</tr><tr><td id="grey_cmsBox_BL"></td><td id="grey_cmsBox_B"></td>
								<td id="grey_cmsBox_BR"></td>
								</tr></tbody></table>
                                
                </td>
                <td valign="top">
 <img src="http://www.wevolt.com/images/cms/cms_grey_save_box.png" class="navbuttons" onclick="submit_form();"/>&nbsp;&nbsp;<img src="http://www.wevolt.com/images/cms/cms_grey_cancel_box.png" class="navbuttons" onclick="window.document.location.href='/jobs.php';"/><div class="spacer"></div>
                                <table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
												<td id="grey_cmsBox_TL"></td>
												<td id="grey_cmsBox_T"></td>
												<td id="grey_cmsBox_TR"></td></tr>
												<tr><td class="grey_cmsBox_L" background="http://www.wevolt.com/images/cms/grey_cms_box_L.png" width="8"></td>
												<td class="grey_cmsboxcontent" valign="top" width="184" align="left">
                                                No Deadline&nbsp;&nbsp;<input type="checkbox" name="no_end" value="1" onchange="toggle_deadline();"/>
                                                <div id="deadline_div">
                            <table cellspacing="5"><tr><td class="grey_cmsboxcontent" ><b>Deadline:</b></td><td><? echo DateSelector('start_date',$Start) ?></td></tr></table>
                            </div>
                             <table cellspacing="5"><tr><td class="grey_cmsboxcontent" ><b>Post Expires:</b></td><td><? echo DateSelector('expire_date',$Expires) ?></td></tr></table>
<div class="spacer"></div>
<b>Deadline Notes: </b><br />
<textarea name="txtDeadlineNotes" id="txtDeadlineNotes" style="width:98%;"><? if (isset($_POST['txtDeadlineNotes'])) echo $_POST['txtDeadlineNotes']; else echo $JobArray->deadline_notes;?></textarea> 

                                                </td><td class="grey_cmsBox_R" background="http://www.wevolt.com/images/cms/grey_cms_box_R.png" width="8"></td>
		
								</tr><tr><td id="grey_cmsBox_BL"></td><td id="grey_cmsBox_B"></td>
								<td id="grey_cmsBox_BR"></td>
								</tr></tbody></table>
                                <div class="spacer"></div>
                                     <table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
												<td id="grey_cmsBox_TL"></td>
												<td id="grey_cmsBox_T"></td>
												<td id="grey_cmsBox_TR"></td></tr>
												<tr><td class="grey_cmsBox_L" background="http://www.wevolt.com/images/cms/grey_cms_box_L.png" width="8"></td>
												<td class="grey_cmsboxcontent" valign="top" width="184" align="left">
                                                
                           <b> Local Applicants Only:</b> <input type="checkbox" id="txtLocal" name="txtLocal" onchange="toggle_local();" value="1" <? if (($_POST['txtLocal'] == 1) || ($JobArray->local==1)) echo 'checked';?>/><br/>
                           <div id="local_zip" <? if (($_POST['txtLocal'] == 0) || (($_POST['txtLocal'] == '') && ($JobArray->local==0))) echo 'style="display:none;"'?>>
                           <div class="spacer"></div>
                             <b>Local Zip Code:</b><br />
<input type="text" style="width:98%;" id="txtZip" name="txtZip" value="<? if (isset($_POST['txtZip'])) echo $_POST['txtZip']; else echo $JobArray->zip;?>"/>
 <b>Zip Code Radius (miles):</b><br />
<input type="text" style="width:98%;" id="txtZipRadius" name="txtZipRadius" value="<? if (isset($_POST['txtZipRadius'])) echo $_POST['txtZipRadius']; else echo $JobArray->zip_radius;?>"/>
</div>
                                                </td><td class="grey_cmsBox_R" background="http://www.wevolt.com/images/cms/grey_cms_box_R.png" width="8"></td>
		
								</tr><tr><td id="grey_cmsBox_BL"></td><td id="grey_cmsBox_B"></td>
								<td id="grey_cmsBox_BR"></td>
								</tr></tbody></table>
                                <div class="spacer"></div>
                                
                                     <table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
												<td id="grey_cmsBox_TL"></td>
												<td id="grey_cmsBox_T"></td>
												<td id="grey_cmsBox_TR"></td></tr>
												<tr><td class="grey_cmsBox_L" background="http://www.wevolt.com/images/cms/grey_cms_box_L.png" width="8"></td>
												<td class="grey_cmsboxcontent" valign="top" width="184" align="left">
                                                
                           <b> Current WEvolt project:</b> 
                           <select name="txtProject" id="txtProject">
                           <? 
						   	  $InitDB->query("SELECT * from projects where userid='".$_SESSION['userid']."' order by title");
							    echo '<option value="">--select--</option>';  
							  while ($line = $InitDB->fetchNextObject()) {
								
									echo '<option value="'.$line->ProjectID.'"';
									
									if ($JobArray->project_id == $line->ProjectID) echo 'selected';
									
									echo '>'.$line->title.'</option>';  
								  
							  }
                            ?>
                            </select>               										
                         
                                                </td><td class="grey_cmsBox_R" background="http://www.wevolt.com/images/cms/grey_cms_box_R.png" width="8"></td>
		
								</tr><tr><td id="grey_cmsBox_BL"></td><td id="grey_cmsBox_B"></td>
								<td id="grey_cmsBox_BR"></td>
								</tr></tbody></table>
             
                            
                </td>
                
                
                </tr></table>      
                 <div class="spacer"></div>
                    <table width="650" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
												<td id="grey_cmsBox_TL"></td>
												<td id="grey_cmsBox_T"></td>
												<td id="grey_cmsBox_TR"></td></tr>
												<tr><td class="grey_cmsBox_L" background="http://www.wevolt.com/images/cms/grey_cms_box_L.png" width="8"></td>
												<td class="grey_cmsboxcontent" valign="top" width="594" align="left">
                                                
                                                Position: <span id="posTitle_1"></span><br/>
                                                <table><tr><td width="300" valign="top">
                                                <table cellspacing="10"><tr><td id="posRateDiv_1">
                                               
                                             <b>rate:</b><input type="text" style="width:98%;" id="txtPosRate_1" name="txtPosRate_1" value="<? if (isset($_POST['txtPosRate_1'])) echo $_POST['txtPosRate_1'];?>"/>
                                            </td><td id="posRateTypeDiv_1"> <b>rate type:</b><select name="txtPosRateType_1" id="txtPosRateType_1">
                                                <? if ($MediaID == 1){?><option value="perpage" <? if ($_POST['txtPosRateType_1'] == 'perpage') echo 'selected';?>>Per Page</option><? }?>
                                                <option value="flat" <? if ($_POST['txtPosRateType_1'] == 'flat') echo 'selected';?>>Flat Fee</option>
                                                <option value="hourly" <? if ($_POST['txtPosRateType_1'] == 'hourly') echo 'selected';?>>Hourly</option>
                                                <option value="backend_percent" <? if ($_POST['txtPosRateType_1'] == 'backend_percent') echo 'selected';?>>Backend Percentage</option>
                                                </select>
                                                </div>
                                                </td>
                                                <td id="posRateCollab" style="display:none;">This is a collaboration project
                                                </td>
                                                </tr></table>
                                               </td><td width="350" valign="top"><b>Position Description:</b><br/><textarea name="txtPosDesc_1" id="txtPosDesc_1" style="width:98%; height:30px;"><? if (isset($_POST['txtPosDesc_1'])) echo $_POST['txtPosDesc_1'];?></textarea> </td>
</tr></table>                                            
                                                
                                             </td><td class="grey_cmsBox_R" background="http://www.wevolt.com/images/cms/grey_cms_box_R.png" width="8"></td>
		
								</tr><tr><td id="grey_cmsBox_BL"></td><td id="grey_cmsBox_B"></td>
								<td id="grey_cmsBox_BR"></td>
								</tr></tbody></table>
                 <div class="spacer"></div>
                  <div id="positionDiv"></div>
                  </td>
                  <td class="blue_cmsBox_R" background="http://www.wevolt.com/images/cms/blue_cms_box_R.png" width="8"></td>
				   </tr><tr><td id="blue_cmsBox_BL"></td><td id="blue_cmsBox_B"></td>
				   <td id="blue_cmsBox_BR"></td>
				   </tr></tbody></table> 
</td> 
<td>

</td>
</tr>
</table>
<input type="hidden" id="save" name="save" value="1" />
<input type="hidden" id="numPositions" name="numPositions" value="" />
</form>
<script type="text/javascript">

select_position('posTitle_1','Artist');
</script>
