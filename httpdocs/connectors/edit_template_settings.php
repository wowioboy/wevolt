<?php 
session_start();
$RePost = 0;
$UserID = $_SESSION['userid'];
$ProjectID = $_GET['project'];
$ThemeID = $_GET['theme'];
$Section = $_GET['section'];
$SkinCode = $_GET['skin'];
$TemplateCode = $_GET['template'];
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
include_once(INCLUDES.'/db.class.php');
$DB = new DB();
$CloseWindow = 0;
if ($_SESSION['userid'] == '')
	$CloseWindow = 1;
$PFDIRECTORY = $_SESSION['pfdirectory'];
?>

<? 
if ($_POST['save'] == 1) { 

	$Section = $_POST['section'];
	$Width = $_POST[$Section.'Width'];
	$WidthLock = $_POST[$Section.'WidthLock'];
	if ($WidthLock == '')
		$WidthLock = 0;
	$Height = $_POST[$Section.'Height'];
	$HeightLock = $_POST[$Section.'HeightLock'];
	if ($HeightLock == '')
		$HeightLock = 0;
	$BackgroundRepeat = $_POST[$Section.'BackgroundRepeat'];
	$BackgroundRepeatLock = $_POST[$Section.'BackgroundRepeatLock'];
	if ($BackgroundRepeatLock == '')
		$BackgroundRepeatLock = 0;
	$BackgroundLock = $_POST[$Section.'BackgroundLock'];
	if ($BackgroundLock == '')
		$BackgroundLock = 0;
	$Content = mysql_real_escape_string($_POST[$Section.'Content']);
	$BackgroundImagePosition = $_POST[$Section.'BackgroundImagePosition'];
	$BackgroundImagePositionLock = $_POST[$Section.'BackgroundImagePositionLock'];
	if ($BackgroundImagePositionLock == '')
		$BackgroundImagePositionLock = 0;
	$Padding = $_POST[$Section.'PaddingTop']. ' ' . $_POST[$Section.'PaddingRight']. ' ' . $_POST[$Section.'PaddingBottom']. ' ' . $_POST[$Section.'PaddingLeft'];
	$PaddingLock = $_POST[$Section.'PaddingLock'];
	if ($PaddingLock == '')
		$PaddingLock = 0;
	$Align = $_POST[$Section.'Align'];
	$AlignLock = $_POST[$Section.'AlignLock'];
	if ($AlignLock == '')
		$AlignLock = 0;
	$VAlign = $_POST[$Section.'VAlign'];
	$VAlignLock = $_POST[$Section.'VAlignLock'];
	if ($VAlignLock == '')
		$VAlignLock = 0;
	$HeaderLink = $_POST['HeaderLink'];
	$ContentScroll = $_POST['ContentScroll'];
	$ContentScrollLock = $_POST['ContentScrollLock'];
	if ($ContentScrollLock == '')
		$ContentScrollLock = 0;
	
	$Updatequery = "UPDATE template_settings set 
				".$Section."Width='$Width', 
				".$Section."Height='$Height',
				".$Section."BackgroundRepeat='$BackgroundRepeat',
				".$Section."BackgroundImagePosition='$BackgroundImagePosition',";
				
			if ($Section != 'Content')	
			$Updatequery .= $Section."Content='$Content',";
			
			$Updatequery .= $Section."Padding='$Padding',
				".$Section."Align='$Align',
				".$Section."VAlign='$VAlign'";
		if ($Section == 'Header')
		$Updatequery .= ",HeaderLink ='$HeaderLink'";
	
	if ($Section == 'Content')
		$Updatequery .= ",ContentScroll ='$ContentScroll'";
	
	
	
	$UserID = $_SESSION['userid'];
	
	$ProjectID = $_POST['project'];
	$ThemeID = $_POST['theme'];
	
	$SkinCode = $_POST['skin'];
	$TemplateCode = $_POST['template'];
	
	
	if ($ThemeID != '') {
		$where = "where TemplateCode='$TemplateCode' and ThemeID='$ThemeID' and ProjectID=''";
			$query = "UPDATE template_settings_locks set 
				".$Section."Width='$WidthLock', 
				".$Section."Height='$HeightLock',
				".$Section."BackgroundRepeat='$BackgroundRepeatLock',
				".$Section."Background='$BackgroundLock',
				".$Section."BackgroundImagePosition='$BackgroundImagePositionLock',
				".$Section."Padding='$PaddingLock',
				".$Section."Align='$AlignLock',
				".$Section."VAlign='$VAlignLock'";
	if ($Section == 'Header')
		$query .= ",HeaderLink='$HeaderLinkLock'";
	
	if ($Section == 'Content')
		$query .= ",ContentScroll ='$ContentScrollLock'";
		
		$query .= " where TemplateCode='$TemplateCode' and ThemeID='$ThemeID'";
		$DB->query($query);
		//print $query.'<br/>';
	} else if ($ProjectID != ''){
			$query ="SELECT * from template_settings where TemplateCode='$TemplateCode' and ProjectID='$ProjectID'";
			$DB->query($query);
				//	print $query.'<br/>';
			$Found = $DB->numRows();
			if ($Found == 0) {
				$query ="INSERT into template_settings (TemplateCode, ProjectID) values ('$TemplateCode','$ProjectID')";
				$DB->execute($query);
					//	print $query.'<br/>';
			}
			$where =" where TemplateCode='$TemplateCode' and ProjectID='$ProjectID'";
		
	}
	
	$Updatequery .= $where;
	$DB->execute($Updatequery);
//print $Updatequery;
	$CloseWindow = 1;
		
}


if ($CloseWindow == 0) {


if ($ThemeID != '') {
	$query = "SELECT * from template_settings where TemplateCode='$TemplateCode' and ThemeID='$ThemeID'";
} else {
    $query = "SELECT * from template_settings where TemplateCode='$TemplateCode' and ProjectID='$ProjectID'";
	$ThemeID = $CurrentTheme;
	
}
$TemplateArray = $DB->queryUniqueObject($query);

$query = "SELECT * from template_settings_locks where TemplateCode='$TemplateCode' and ThemeID='$ThemeID'";
$TemplateLocks = $DB->queryUniqueObject($query);
//print_r($TemplateLocks);

if ($TemplateArray->TemplateCode == '') {
	$query = "SELECT * from template_settings where TemplateCode='$TemplateCode' and ThemeID='$ThemeID'";
	$TemplateArray = $DB->queryUniqueObject($query);
}

	$TemplateHTML = $TemplateArray->HTMLCode;

	$HeaderWidth = $TemplateArray->HeaderWidth;
	$HeaderHeight = $TemplateArray->HeaderHeight;
	$HeaderImage = $TemplateArray->HeaderImage;
	$HeaderBackground = $TemplateArray->HeaderBackground;
	$HeaderBackgroundRepeat = $TemplateArray->HeaderBackgroundRepeat;
	$HeaderContent = $TemplateArray->HeaderContent;
	$HeaderLink = $TemplateArray->HeaderLink;
	//print 'HEADER LINK = ' . $HeaderLink;
	$HeaderRollover = $TemplateArray->HeaderRollover;
	$HeaderAlign = $TemplateArray->HeaderAlign;
	$HeaderVAlign = $TemplateArray->HeaderVAlign;
	$HeaderBackgroundImagePosition = $TemplateArray->HeaderBackgroundImagePosition;
	$HeaderPaddingArray = explode(' ',$TemplateArray->HeaderPadding);
	$HeaderPaddingTop = $HeaderPaddingArray[0];
	$HeaderPaddingRight = $HeaderPaddingArray[1];
	$HeaderPaddingBottom = $HeaderPaddingArray[2];
	$HeaderPaddingLeft = $HeaderPaddingArray[3];
	
	$MenuBackground = $TemplateArray->MenuBackground;
	$MenuBackgroundRepeat = $TemplateArray->MenuBackgroundRepeat;
	$MenuImage = $TemplateArray->MenuImage;
	$MenuHeight = $TemplateArray->MenuHeight;
	$MenuWidth = $TemplateArray->MenuWidth;
	$MenuContent = $TemplateArray->MenuContent;
	$MenuAlign = $TemplateArray->MenuAlign;
	$MenuVAlign = $TemplateArray->MenuVAlign;
	$MenuBackgroundImagePosition = $TemplateArray->MenuBackgroundImagePosition;
	$MenuPaddingArray = explode(' ',$TemplateArray->MenuPadding);
	$MenuPaddingTop = $MenuPaddingArray[0];
	$MenuPaddingRight = $MenuPaddingArray[1];
	$MenuPaddingBottom = $MenuPaddingArray[2];
	$MenuPaddingLeft = $MenuPaddingArray[3];
	
	$ContentBackground = $TemplateArray->ContentBackground;
	$ContentBackgroundRepeat = $TemplateArray->ContentBackgroundRepeat;
	$ContentWidth = $TemplateArray->ContentWidth;
	$ContentHeight = $TemplateArray->ContentHeight;
	$ContentScroll = $TemplateArray->ContentScroll; 
	$ContentAlign = $TemplateArray->ContentAlign;
	$ContentVAlign = $TemplateArray->ContentVAlign;
	$ContentBackgroundImagePosition = $TemplateArray->ContentBackgroundImagePosition;
	$ContentPaddingArray = explode(' ',$TemplateArray->ContentPadding);
	$ContentPaddingTop = $ContentPaddingArray[0];
	$ContentPaddingRight = $ContentPaddingArray[1];
	$ContentPaddingBottom = $ContentPaddingArray[2];
	$ContentPaddingLeft = $ContentPaddingArray[3];
	
	$FooterImage = $TemplateArray->FooterImage;
	$FooterBackground = $TemplateArray->FooterBackground;
	$FooterBackgroundRepeat = $TemplateArray->FooterBackgroundRepeat;
	$FooterWidth = $TemplateArray->FooterWidth;
	$FooterHeight = $TemplateArray->FooterHeight; 
	$FooterContent = $TemplateArray->FooterContent;
	$FooterAlign = $TemplateArray->FooterAlign;
	$FooterVAlign = $TemplateArray->FooterVAlign;
	$FooterBackgroundImagePosition = $TemplateArray->FooterBackgroundImagePosition;
	$FooterPaddingArray = explode(' ',$TemplateArray->FooterPadding);
	$FooterPaddingTop = $FooterPaddingArray[0];
	$FooterPaddingRight = $FooterPaddingArray[1];
	$FooterPaddingBottom = $FooterPaddingArray[2];
	$FooterPaddingLeft = $FooterPaddingArray[3];
	

}

$DB->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Edit Template Settings</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://<? echo $_SERVER['SERVER_NAME'];?>/css/pf_css_new.css" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $_SERVER['SERVER_NAME'];?>/<? echo $_SESSION['pfdirectory'];?>/css/cms_css.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="http://<? echo $_SERVER['SERVER_NAME'];?>/ajax/ajax_init.js"></script>
<script language="JavaScript" type="text/javascript" src="http://<? echo $_SERVER['SERVER_NAME'];?>/scripts/global_functions.js"></script>
<style type="text/css">
/* <![CDATA[ */
textarea { clear: both; font-family: sans-serif; font-size: 1em; width: 275px;}

body,html {
padding:0px;
margin:0px;	
background-color:#eeeeee;
}
/* ]]> */
</style>



<script type="text/javascript">

function submit_form() {
			
	document.modform.submit();

}

  function removeTemplateImage(skintype) {
		
		attach_file( '/<? echo $_SESSION['pfdirectory'];?>/includes/remove_template_image.php?skincode=<? echo $SkinCode;?>&type='+skintype+'&project=<? echo $ProjectID;?>&theme=<? echo $ThemeID;?>');
		//alert('/pf_16_core/includes/remove_template_image.php?skincode=<? echo $SkinCode;?>&type='+skintype+'&project=<? echo $ProjectID;?>&theme=<? echo $ThemeID;?>');
		}


</script>
  
</head>
<body>

<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
parent.$.modal().close();
</script>

<? } else {?>

<form name="modform" id="modform" method="post" action="#">
<center>
 <? if ($Section == 'Header') {

    include $_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['pfdirectory'].'/includes/theme_settings_header_inc.php';
  } else if ($Section == 'Footer') {
  	 include $_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['pfdirectory'].'/includes/theme_settings_footer_inc.php';
  } else  if ($Section == 'Menu') {
  	include $_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['pfdirectory'].'/includes/theme_settings_menu_inc.php';
  } else if ($Section == 'Content') {
 	include $_SERVER['DOCUMENT_ROOT'].'/'.$_SESSION['pfdirectory'].'/includes/theme_settings_content_inc.php';
  }?>
</center>
  <input type="hidden" name="HeaderImage" id="HeaderImage" />
  <input type="hidden" name="HeaderBackground" id="HeaderBackground" />
  <input type="hidden" name="FooterImage" id="FooterImage" />
  <input type="hidden" name="FooterBackground" id="FooterBackground" />
  <input type="hidden" name="MenuImage" id="MenuImage" />
  <input type="hidden" name="MenuBackground" id="MenuBackground" />
  <input type="hidden" name="ContentBackground" id="ContentBackground" />
  <input type="hidden" name="project" value="<? echo $_GET['project'];?>"/>
  <input type="hidden" name="theme" value="<? echo $_GET['theme'];?>"/>
  <input type="hidden" name="section" value="<? echo $_GET['section'];?>"/>
    <input type="hidden" name="template" value="<? echo $_GET['template'];?>"/>
 
  
  <input type="hidden" value="1" name="save" />
 
</form>


<? }?>
</body>
</html>