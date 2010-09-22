<?
$SiteTemplateWidth = '981';
$TemplateWrapperWidth = '1058';
$SiteVersion = 2;
include_once(CLASSES.'/site.php');
$Site = new site();
$_SESSION['refurl'] = curPageURL();
$_SESSION['returnlink'] = $_SESSION['refurl'];
$_SESSION['loginref'] = $_SESSION['refurl'];
$_SESSION['sharelink'] = '';
if (($_GET['sa'] =='') &&($_GET['a'] == '') &&($_POST['a'] == '')) {
	if (($_SESSION['userid'] != '') && ($TrackPage == 1))
		$User->add_string_entry($PageTitle, $TrackPage,$_SESSION['refurl'],$IsProject,$IsJob);
		
}

	 
$Site->drawHeader();


if (($MetaContentTitle == '') && ($IsProject)) {
	$MetaContentTitle = $ProjectTitle;
	$MetaDescription = $Synopsis;
	$MetaContentType = $ProjectType;
	$MetaThumb = $ProjectThumb;
} else if (($MetaContentTitle == '') && ($IsJob)) { 
	$MetaContentTitle = $JobArray->title;	
	$MetaDescription = $JobArray->description;
	$MetaContentType = 'article';
	$MetaThumb = 'http://www.wevolt.com/images/we_fb_logo.jpg';	
	
} else {
	$MetaThumb = 'http://www.wevolt.com/images/we_fb_logo.jpg';	
}
?>	
<meta property="og:title" content="job post: <? echo $MetaContentTitle;?>"/>
    <meta property="og:type" content="<? echo $MetaContentType;?>"/>
    <meta property="og:url" content="<? echo $_SESSION['refurl'];?>"/>
    <meta property="og:image" content="<? echo $MetaThumb;?>"/>
    <meta property="og:site_name" content="WEvolt"/>
    <meta property="og:description"
          content="<? echo $MetaDescription;?>"/>
<meta name="description" content="<?php if ($IsProject) echo $Synopsis; ?><?php if ($IsJob) echo $JobArray->description; ?><? echo $Site->getGlobalDescription();?> "></meta>
<meta name="keywords" content="<?php if ($IsProject) { echo $Creator; echo ','; echo $Writer;  echo ','; echo $Artist;  echo ','; echo $Letterist;  echo ','; echo $Colorist;  echo ','; echo $Genre;  echo ','; echo $Tags;} ?>,<? echo $Site->getGlobalKeywords();?> "></meta>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><? echo $PageTitle;?></title>

 <!--CSS LIBRARIES-->
 <? $Site->drawCSS();?>

<!--[if lte IE 6]><link href="http://www.wevolt.com/css/modal-window-ie6.css" type="text/css" rel="stylesheet" /><![endif]-->

<script type="text/javascript">
 var returnlink = escape('<? echo $_SESSION['returnlink'];?>');
 var username = '<? if (trim($_SESSION['username']) == '') echo 'na'; else echo trim($_SESSION['username']);?>';
 var usermail = '<? if ($_SESSION['email'] == '') echo 'na'; else echo $_SESSION['email'];?>'; 
 var stringstart = <? if ($_SESSION['stringstart']  == '') echo '1'; else echo $_SESSION['stringstart'];?>;
 var stringx = <? if ($_SESSION['IsPro'] == 0) {?>300<? } else {?>70<? }?>;
 var stringy = <? if ($_SESSION['IsPro'] == 0) {?>127<? } else {?>79<? }?>;
 var showtips = <?  if ($_SESSION['tooltips'] == '') echo '1'; else echo $_SESSION['tooltips']; ?>;
 var homepage = <? if ($HomePage == 1) echo '1'; else echo '0';?>;
 var siteversion = <? echo $SiteVersion;?>;
</script>
<!--GLOBAL SCRIPTS -->
 <? $Site->drawGlobalScripts();?>

<!--Jquery Scripts -->
 <? $Site->drawJQueryScripts();?>
 
<? if ($Home) {?>
<script type="text/javascript" language="javascript" src="http://www.wevolt.com/scripts/easySlider1.7.js"></script>
<? }?>

<? if ($IsProject) $Site->drawProjectScripts();?>

<? if (($BodyStyle == '') || (($IsProject) && ((($_SESSION['overage'] == '') || (strtolower($_SESSION['overage']) == 'n')) && (($_SESSION['authage'] != 1) && ($Rating == 'a')))))
	$BodyStyle = 'background-image:url(http://www.wevolt.com/images/WEvolt_bgd_dark.jpg);background-repeat:no-repeat;background-position:top;center;background-attachment:fixed;background-color:#0077d5;';
	
			
if  (((($_SESSION['readerstyle'] == 'flash') && ($_SESSION['currentreader'] == '')) || ($_SESSION['currentreader'] == 'flash')) && ($Section == 'Reader')) { 
		$BodyStyle ='background-color:#000000;'; 
}?>


 <!--[if IE]><style type="text/css">iframe {background: transparent;}</style><![endif]-->

<script  language="javascript">
function follow_content(contentid,type,elem) {
 
	attach_file('http://www.wevolt.com/connectors/follow_content.php?fid='+contentid+'&type='+type); 
	document.getElementById(elem).style.display = 'none';
	
}
if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)))
{
<? if ($IsProject) {?>
	location.href='http://www.wevolt.com/<? echo $SafeFolder;?>/iphone/';
<? } else {?>
	location.href='http://www.wevolt.com/iphone/index.php';
<? }?>
}

</script> 
</head>
<?php flush();  ?>

<body style="<? echo $BodyStyle;?>" class="yui-skin-wevolt">

   