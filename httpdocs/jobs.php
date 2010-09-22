<? 
require_once('includes/init.php');
include 'classes/jobs.php';
$jobs = new jobs();
include_once($_SERVER['DOCUMENT_ROOT']."/classes/jobs_pages.php");  // include main class filw which creates pages
$UserID = $_SESSION['userid'];
$NumItemsPerPage = $_GET['c'];
if ($NumItemsPerPage == '')
	$NumItemsPerPage = 7;
$InitDB->close();
$PageTitle .= 'jobs';
if ($_GET['task'] == '')
	$TrackPage = 1;
if (($_GET['task'] == 'new') && ($_SESSION['userid'] == ''))
	header("location:/jobs.php");

if (($_GET['view'] != '') && ($_GET['task'] == '')) {	
	$JobArray = $jobs->getJob($_GET['view']);
	$PageTitle .= ' - '.$JobArray->title;
	$IsJob = true;			
} else if ($_GET['task'] == ''){
	$PageTitle .= ' - listing';
}
require_once('includes/pagetop_inc.php');
$Site->drawModuleCSS();

?>
<script type="text/javascript">
function do_search(sortvalue) {
	var Keywords = document.getElementById('keywords').value;
	var CatID = document.getElementById('txtCat').value;
	document.searchForm.submit();
}
</script>

<div align="center">
<table cellpadding="0" cellspacing="0" border="0" width="<? echo $TemplateWrapperWidth;?>">
  <tr>
    <td valign="top" align="center">
    <div class="content_bg">
		<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <?php $Site->drawControlPanel(); ?>
            </div>
        <? }?>
        <? if ($_SESSION['noads'] != 1) {?>
            <div id="ad_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;" align="center">
                <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
            </div>
        <?  }?>
       
       
        <div id="header_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;">
           <? $Site->drawHeaderWide();?>
        </div>
    </div>
    
     <div class="shadow_bg">
        	 <? $Site->drawSiteNavWide();?>
    </div>
    
     <div class="content_bg" id="content_wrapper">
         <!--Content Begin -->
         <div class="spacer"></div>
         <table cellspacing="0" cellpadding="0" width="<? echo $SiteTemplateWidth;?>">
             <tr>
                <td valign="top" style="padding-left:10px;" width="300">
                 <form name='searchForm' id='searchForm' onSubmit='return false' style="padding:0px;">
                     <table width="100%" cellspacing="10">
                         <tr>
                            <td colspan="2"> 
                            <img src="http://www.wevolt.com/images/job_board_title.jpg" />&nbsp;&nbsp;&nbsp;
                            </td>
                         </tr>
                        <? if ($_GET['task'] == '') {?> 
                        <tr>
                            <td><strong> Media:</strong></td>
                            <td width="100" align="left"><? $jobs->drawMediaSelect($_GET['media'],'get_media(this.options[this.selectedIndex].value)','mediaSelect',true);?></td>
                        </tr>
                        <tr>
                            <td><strong> Categories:</strong></td>
                            <td align="left"><? $jobs->drawCatSelect($_GET['media'],$_GET['cat'],'get_cat(this.options[this.selectedIndex].value)','catSelect',true);?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            <input type="text" name="keywords" id="keywords" value="enter keywords" onFocus="doClear(this);" onBlur="setDefault(this);"  style="width:98%;"/><div class="spacer"></div><input type="image" class="navbuttons" src="http://www.wevolt.com/images/job_search_btn.jpg" />
                            </td>
                        </tr>
                    <? } ?>
                    </table>
                 </form>
                  <div style="padding-left:10px;">
                    <? if ($_SESSION['IsPro'] == 1) {?>  Would you like to post a job? <br/>Click the ADD button<br/><a href="http://www.wevolt.com/jobs.php?task=new"><img src="http://www.wevolt.com/images/sm_add.png" border="0" tooltip="Post a new job"/></a><? }?>
                    </div>
                <!-- LEFT AD BOX -->
                 <? if ($_SESSION['noads'] != 1) {?>
                <div id="left_ad_div" style="background-color:#FFF;width:300px;" align="center">
                  <? $Site->drawVideoBoxAd();?>
                </div>
                 <?  }?>
                 
                </td>
                        
                <td valign="top" style="padding-left:10px;padding-top:20px;">
                <? if (($_GET['view'] == '') && ($_GET['task'] == '')) {
                        $jobs->getJobs($_GET['cat'],$_GET['search']);
                    } else if ($_GET['task'] == 'new') {
                        include $_SERVER['DOCUMENT_ROOT'].'/includes/create_job_inc.php';
                     } else {
                        $JobArray = $jobs->getJob($_GET['view']);
                        $PositionArray=$jobs->getJobPositions($JobArray->id,$_SESSION['userid']);
                        include $_SERVER['DOCUMENT_ROOT'].'/includes/view_job_inc.php';
                    }?>
                </td>
            
            </tr>
         </table>       
    <!--Content End -->
    </div>

	</td>
  </tr>
  <tr>
      <td style="background-image:url(http://www.wevolt.com/images/bottom_frame_no_blue.png); background-repeat:no-repeat;width:1058px;height:12px;">
      </td>
  </tr>
</table>
</div>
  
<?php require_once('includes/pagefooter_inc.php'); ?>


