<?php
include_once("init.php"); 
include("editor/fckeditor.php") ;
$CurrentDay = date('d');
$CurrentMonth = date('m');
$CurrentYear = date('Y');
$SectionID= $_GET['section'];
if ($SectionID != "") {
	$catString = "";
	$db = new DB();
	$query = "select * from categories where section='$SectionID' order by ID ASC";
	$db->query($query);
	$catString = "<select name='txtCategory' style='background-color:#FFFFFF; border:solid; 			border-width:1px; border-color:#FF6600; width:222px;'>";
	while ($line = $db->fetchNextObject()) { 
		$SectionCategories = '"'.$line->Title.'"';
		$catString .= "<OPTION VALUE='".$line->Title."'";
		if ($line->IsDefault == 1) {
			$catString .= "selected";
		}
		$catString .= ">".$line->Title."</OPTION>";
	}
	$catString .= "</select>";
} else {
$catString = "<select name='txtCategory' style='background-color:#FFFFFF; border:solid; 			border-width:1px; border-color:#FF6600; width:222px;'><option value='0'>SELECT SECTION</option>";
}


$secString = "";
$db = new DB();
$query = "select * from sections order by ID ASC";
$db->query($query);

$secString ="<select name='txtSection' onchange='fillSelect(this.value,this.form['txtCategories'])'>";
//$secString = "<select style='width:175px;' onchange='window.location = this.options[this.selectedIndex].value; '>";
while ($line = $db->fetchNextObject()) { 

$secString .= "<OPTION VALUE='".$line->ID."'";
if ($line->ID == $SectionID) {
$secString .= "selected";
}
$secString .= ">".$line->Title."</OPTION>";
	}
$secString .= "</select>";
?>
<script type="text/javascript">
	var categories = []; 
	categories["<? echo $SectionID ?>"] = [<? echo $SectionCategories ?>];
	
	function fillSelect(nValue,nList){

		nList.options.length = 1;
		var curr = categories[nValue];
		for (each in curr)
			{
			 var nOption = document.createElement('option'); 
			 nOption.appendChild(document.createTextNode(curr[each])); 
			 nOption.setAttribute("value",curr[each]); 			 
			 nList.appendChild(nOption); 
			}
	}

</script>
<form action="write_blog_post.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="621" valign="top"><div class="smspacer"></div>
    <? if ($SectionID == "") { ?>
CONTENT TITLE:
<input type="text" name="txtTitle" style="width:300px;">

<div class="spacer"></div>
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.

$oFCKeditor = new FCKeditor('pf_post') ;
$oFCKeditor->BasePath	= '/editor/';
$oFCKeditor->Height = '400';
$oFCKeditor->Width = '550';
$oFCKeditor->Value		= $HtmlContent ;
$oFCKeditor->Create() ;
?>

<div class="spacer"></div>
<input type="submit" value="SAVE PAGE" style="background-color:#FFFFFF; border:solid; border-width:1px; border-color:#FF6600;"><? }  else { echo "You need to select a section before you start creating your post";}?></td>
    <td width="384" valign="top" bgcolor="#a2b7b3" style="padding-left:5px;padding-top:5px; color:#000000;"><b>POST SETTINGS:</b>
      <div class="spacer"></div>
	   SECTION:<br />
       <? echo $sectionString; ?><br />
CATEGORY:<br />
<? echo $catString; ?><br />
<br />
	   SHOW TITLE:<br />
          <input type="radio" name="txtShowtitle" value="1" checked>
          Yes&nbsp;&nbsp;
          <input type="radio" name="txtShowtitle" value="0" >
          No<br />
          <br />
      PUBLISH:<br />
      <input type="radio" name="txtPublished" value="1" checked>
      Yes&nbsp;&nbsp;
      <input type="radio" name="txtPublished" value="0" >
      No<br />
      <br />
      </td>
  </tr>
</table>
<div class="spacer"></div>
<input type="hidden" name="txtPost" value="<? echo $PostID; ?>" />

</form>