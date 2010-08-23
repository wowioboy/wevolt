<?php 
include 'includes/init.php';
include 'classes/jobs.php';
$jobs = new jobs();
include_once($_SERVER['DOCUMENT_ROOT']."/classes/jobs_pages.php");  // include main class filw which creates pages
$UserID = $_SESSION['userid'];
$NumItemsPerPage = $_GET['c'];
if ($NumItemsPerPage == '')
	$NumItemsPerPage = 7;
$InitDB->close();
$PageTitle .= 'jobs';
$TrackPage = 1;
if (($_GET['task'] == 'new') && ($_SESSION['userid'] == ''))
	header("location:/jobs.php");


include 'includes/header_template_new.php';
?>
<script type="text/javascript">
function do_search(sortvalue) {
	var Keywords = document.getElementById('keywords').value;
	var CatID = document.getElementById('txtCat').value;
	document.searchForm.submit();
}
</script>
<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <td valign="top" <? if ($_SESSION['IsPro'] == 1) {?>width="60"<? } else {?>width="<? echo $SideMenuWidth;?>"<? }?>><? include 'includes/site_menu_inc.php';?></td>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px; width:<? echo $_SESSION['contentwidth'];?>px">
         <table cellspacing="0" cellpadding="0" width="<? echo $_SESSION['contentwidth'];?>">
            <tr>
            <td style="width:7px; height:7px; background-image:url(http://www.wevolt.com/images/cms/TL_grey_corner.png); background-repeat:no-repeat;"></td>
            <td style="background-color:#535353; height:7px;width:<? echo ($_SESSION['contentwidth']-14);?>px;"></td>
            <td style="width:7px; height:7px; background-image:url(http://www.wevolt.com/images/cms/TR_grey_corner.png); background-repeat:no-repeat;"></td>
            </tr>
            <tr><td colspan="3" style="background-color:#535353;padding-left:3px; padding-right:3px;" class="messageinfo_white" valign="bottom">
            <? if ($_GET['task'] == '') {?> <form name='searchForm' id='searchForm' onSubmit='return false' style="padding:0px;"> 
       <table width="100%" cellspacing="10"><tr><td width="200">WEvolt jobs</td><td width="50"><strong> Media:</strong>
     </td><td width="100" align="left"> <? 
		$jobs->drawMediaSelect($_GET['media']);
		?> </td><td><strong> Categories:</strong></td><td align="left"><? 
		$jobs->drawCatSelect($_GET['media'],$_GET['cat']);
		?></td><td> <input type="text" name="keywords" id="keywords" value="enter keywords" onFocus="doClear(this);" onBlur="setDefault(this);"  style="width:130px;"/> &nbsp;<input type="submit" value="search" class="navbuttons" /></td><td><? if ($_SESSION['IsPro'] == 1) {?><a href="http://www.wevolt.com/jobs.php?task=new"><img src="http://www.wevolt.com/images/sm_add.png" border="0"/><? }?></a></td></tr></table></form>
            <? } ?>
            </td></tr>
            </table>
            
            <div style="background-color:#535353;padding-left:3px; padding-right:3px;width:<? echo ($_SESSION['contentwidth']-6);?>px;" align="center">
               
                <table style="width:100%" cellpadding="0" cellspacing="0">
                <tr>
                <td style="background-color:#fcfcfc; padding-top:10px; padding-bottom:10px;" valign="top" align="center">
                  
                   <div style="width:<? echo ($_SESSION['contentwidth']-26);?>px;padding-top:10px; padding-bottom:10px;" class="cms_wrappercontent" align="center">
                   
          <table width="100%" cellspacing="5"><tr>
         
        <td valign="top">
        <?
			if (($_GET['view'] == '') && ($_GET['task'] == '')) {
				$jobs->getJobs($_GET['cat'],$_GET['search']);
			} else if ($_GET['task'] == 'new') {
						include $_SERVER['DOCUMENT_ROOT'].'/includes/create_job_inc.php';
			 } else {
				$JobArray = $jobs->getJob($_GET['view']);
				$PositionArray=$jobs->getJobPositions($JobArray->id,$_SESSION['userid']);
				include $_SERVER['DOCUMENT_ROOT'].'/includes/view_job_inc.php';

			 }?>
        </td></tr></table>    
            
            </div>
            </td>
            </tr>
            </table>
            
        
      </div></td>
  </tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>

