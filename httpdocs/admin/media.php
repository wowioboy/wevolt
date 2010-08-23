<? include 'includes/init.php';

 ?>

<?php

/*********************************************************************/
/*                             fileNice                              */
/*                                                                   */
/*  Heirachical PHP file browser - http://filenice.com               */
/*  Written by Andy Beaumont - http://andybeaumont.com               */
/*                                                                   */
/*  Send bugs and suggestions to stuff[a]fileNice.com                */
/*                                                                   */
/*                                                                   */
/*********************************************************************/

/*********************************************************************/
/*                                                                   */
/* User editable preferences are now stored in fileNice/prefs.php    */
/* for easier maintenance and to assist with some fancy new features */
/* in this and future versions.                                      */
/*                                                                   */
/*********************************************************************/

include("fileNice/prefs.php");

/*********************************************************************/
/*                                                                   */
/*  Best not to touch stuff below here unless you know what you're   */
/*  doing.                                                           */
/*                                                                   */
/*********************************************************************/

$version = "1.0.2";

$server = $_SERVER['HTTP_HOST'];
$thisDir = dirname($_SERVER['PHP_SELF']);  
$pathToHere = "http://$server$thisDir/";
		
include "fileNice/fileNice.php";

// HANDLE THE PREFERENCES
$names = array("showImg","showEmbed","showHtml","showScript","showMisc");
if($_POST['action'] == "prefs"){
	// lets set the cookie values
	$varsArray = array();
	for($i=0; $i<count($names);$i++){
		if($_POST[$names[$i]] == "show"){
			$varsArray[$names[$i]] = "show";
		}else{
			$varsArray[$names[$i]] = "hide";
		}
		setcookie($names[$i],$varsArray[$names[$i]],time()+60*60*24*365);
		$$names[$i] = $varsArray[$names[$i]];
	}
	// set the skin
	setcookie("skin",$_POST['skin'],time()+60*60*24*365);
	$skin = $_POST['skin'];
	// set the slideshow speed
	setcookie("ssSpeed",$_POST['ssSpeed'],time()+60*60*24*365);
	$ssSpeed = $_POST['ssSpeed'] * 1000;
	// set the sortBy
	setcookie("sortBy",$_POST['sortBy'],time()+60*60*24*365);
	$sortBy = $_POST['sortBy'];
	// set the sortDir
	setcookie("sortDir",$_POST['sortDir'],time()+60*60*24*365);
	$sortDir = $_POST['sortDir'];
}else{
	// retreive prefs
	for($i=0; $i<count($names);$i++){
		if(isset($_COOKIE[$names[$i]])){
			//echo("COOKIE[".$names[$i]."] = " . $_COOKIE[$names[$i]] . "<br />");
			if($_COOKIE[$names[$i]] != "show"){
				$$names[$i] = "hide";
			}else{
				$$names[$i] = "show";
			}
		}else{
			$$names[$i] = "show";
		}
	}
	// GET THE PREFERRED SKIN
	if(isset($_COOKIE['skin'])){
		$skin = $_COOKIE['skin'];
	}else{
		$skin = $defaultSkin;
	}
	// GET THE SLIDE SHOW SPEED
	if(isset($_COOKIE['ssSpeed'])){
		$ssSpeed = $_COOKIE['ssSpeed'] * 1000;
	}else{
		$ssSpeed = $defaultSSSpeed * 1000;
	}
	// GET THE SORT BY AND DIRECTION
	if(isset($_COOKIE['sortBy'])){
		$sortBy = $_COOKIE['sortBy'];
	}else{
		$sortBy = $defaultSort;
	}
	if(isset($_COOKIE['sortDir'])){
		$sortDir = $_COOKIE['sortDir'];
	}else{
		$sortDir = $defSortDirection;
	}
}





if($_GET['action'] == "getFolderContents"){
	if(substr($_GET['dir'],0,2) != ".." && substr($_GET['dir'],0,1) != "/" && $_GET['dir'] != "./" && !stristr($_GET['dir'], '../')){
		$dir = $_GET['dir'];
		$list = new FNFileList;
		$list->getDirList($dir);
		exit;
	}else{
		// someone is poking around where they shouldn't be
		echo("Don't hack my shit yo.");
		exit;	
	}
}else if($_GET['action'] == "nextImage"){
	$out = new FNOutput;
	$tmp = $out->nextAndPrev($_GET['pic']);
	if($tmp[1] == ""){
		$nextpic = $tmp[2];
	}else{
		$nextpic = $tmp[1];
	}
	// get the image to preload
	$tmp2 = $out->nextAndPrev($nextpic);
	// get the image dimensions
	$imageDim = @getimagesize($nextpic);
	echo $nextpic."|".$imageDim[0]."|".$imageDim[1]."|".$tmp2[1];
	exit;
}




$showScript = 'hide';
$showHtml = 'hide';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>

	<title>PANEL FLOW CMS - MEDIA BROWSER</title>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="none" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="fileNice/skins/<?php echo $skin; ?>/fileNice.css" />
	<link rel="stylesheet" type="text/css" href="fileNice/skins/<?php echo $skin; $r = rand(99999,99999999); echo "/icons.php?r=$r\"" ?> />
	
<script language="javascript" type="text/javascript">
var ssSpeed = <?php echo $ssSpeed; ?>;
</script>
	
	<script src="fileNice/fileNice.js" type="text/javascript"></script>
		
</head>

<body>
<div>PANEL FLOW CMS - MEDIA BROWSER</div>
<!-- busy indicators -->
<div id="overDiv">&nbsp;</div>
<div id="busy">&nbsp;</div>
<!-- main -->
<div id="container">
	<div id="header">
	<form name="search" id="search" action="media.php" method="post"><input type="text" name="sstring" id="sstring" value="<?php echo $_POST['sstring']; ?>" /><input type="button" name="search" value="search" id="searchButton" onclick="validateSearch();" /></form>
		<h3><a href="#" title="edit prefs" class="expander preferences">[edit preferences]</a></h3>
	</div>
<form name="prefs" action="media.php" method="post" id="preferences">
Preferences:<br /><br />
<fieldset>
<legend>Sort by</legend>
<input type="radio" name="sortBy" id="name" value="name" <?php if($sortBy == "name") echo"checked=\"checked\""; ?> />
<label for="name">file name</label><br />
<input type="radio" name="sortBy" id="date" value="date" <?php if($sortBy == "date") echo"checked=\"checked\""; ?> />
<label for="date">date modified</label>
</fieldset>

<fieldset>
<legend>Sort direction</legend>
<input type="radio" name="sortDir" id="ascending" value="ascending" <?php if($sortDir == "ascending") echo"checked=\"checked\""; ?> />
<label for="ascending">ascending</label><br />
<input type="radio" name="sortDir"  id="descending" value="descending" <?php if($sortDir == "descending") echo"checked=\"checked\""; ?> />
<label for="descending">descending</label>
</fieldset>

<fieldset>
<legend>Filetypes to display</legend>
<input type="hidden" name="action" value="prefs" />
<?php if($showImg != "show") $checked = "";  else  $checked = "checked=\"checked\"";?>
<input type="checkbox" name="showImg" id="showImg" value="show" <?php echo $checked; ?> />
<label for="showImg">Show image type files</label><br />

<?php if($showEmbed  != "show") $checked = "";  else  $checked = "checked=\"checked\"";?> 
<input type="checkbox" name="showEmbed" id="showEmbed" value="show" <?php echo $checked; ?> />
<label for="showEmbed"> Show embed type files</label><br />

<?php if($showHtml != "show") $checked = "";  else  $checked = "checked=\"checked\"";?> 
<input type="checkbox" name="showHtml" id="showHtml" value="show" <?php echo $checked; ?> />
<label for="showHtml">Show html/text files</label><br />

<?php if($showScript != "show") $checked = "";  else  $checked = "checked=\"checked\"";?> 
<input type="checkbox" name="showScript" id="showScript" value="show" <?php echo $checked; ?> />
<label for="showScript">Show script files</label><br />

<?php if($showMisc != "show") $checked = "";  else  $checked = "checked=\"checked\"";?> 
<input type="checkbox" name="showMisc" id="showMisc" value="show" <?php echo $checked; ?> />
<label for="showMisc" >Show misc files</label><br />

<br />
</fieldset>
<input type="submit" name="Save" id="prefSave" value="Save" />
</form>


<?php
if(isset($_GET['view'])){
	if(substr($_GET['view'],0,2) != ".." && substr($_GET['view'],0,1) != "/" && $_GET['view'] != "./" && !stristr($_GET['view'], '../')){
		$out = new FNOutput;
		$out->viewFile($_GET['view']);
	}else{
		// someone is poking around where they shouldn't be
		echo("Don't hack my shit yo.");
		exit;	
	}
}else if(isset($_GET['src'])){
	if(substr($_GET['src'],0,2) != ".." && substr($_GET['src'],0,1) != "/" && $_GET['src'] != "./" && !stristr($_GET['src'], '../')){
		$out = new FNOutput;
		$out->showSource($_GET['src']);
	}else{
		// someone is poking around where they shouldn't be
		echo("Don't hack my shit yo.");
		exit;	
	}
}

?> <ul id="root"> <?php

// show file list
$list = new FNFileList;

if(isset($_POST['sstring'])){
	$list->search($_POST['sstring']);
}

$list->getDirList("images");




?>
</ul>
</div>


<!-- send to Flickr form -->
<form name="flickr" action="http://www.flickr.com/tools/sendto.gne" method="get">
<input type="hidden" name="url" />
</form>
<div>brower by fileNice</div>
</body>
<!-- script for applying the javascript events -->
<script type="text/javascript">
var o = new com.filenice.actions;
o.setFunctions();
</script>
</html>