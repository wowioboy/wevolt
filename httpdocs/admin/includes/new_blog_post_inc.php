<?php
include_once("init.php"); 
include("editor/fckeditor.php") ;
$CurrentDay = date('d');
$CurrentMonth = date('m');
$CurrentYear = date('Y');
$catString = "";
$db = new DB();
$query = "select * from pf_blog_categories order by ID ASC";
$db->query($query);
$catString = "<select name='txtCategory' class='inputstyle'>";
while ($line = $db->fetchNextObject()) { 
$catString .= "<OPTION VALUE='".$line->Title."'";
if ($line->IsDefault == 1) {
$catString .= "selected";
}
$catString .= ">".$line->Title."</OPTION>";
	}
$catString .= "</select>";
?>
<form action="write_blog_post.php" method="post">
<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>
      NEW BLOG POST</div>
      <div class="spacer"></div>
	  <b>POST SETTINGS:</b>
      <div class="spacer"></div>
PUBLISH DATE:<br />
<SELECT NAME='txtMonth' class='inputstyle'>
          <?
          for ( $i=1; $i<13; $i++ ) {
            echo "<OPTION VALUE='".$i."'";
			if ($CurrentMonth ==$i) {
				echo "selected";
			}
			echo ">".date("F", mktime(1,1,1,$i,1,1) )."</OPTION>";
          }
          ?>
        </SELECT><br />
<select name='txtDay'  class='inputstyle'>
      <?
            for ($i=1; $i<32; $i++) {
              echo "<OPTION VALUE='".$i."'";
			  if ($CurrentDay == $i) {
				echo "selected";
				}
			 echo ">".$i."</OPTION>";
            }
          ?>
    </select><br />
<select name='txtYear'  class='inputstyle'>
      <?
            for ($i=date("Y")+1; $i>=(date("Y")-20); $i--) {
			echo "<OPTION VALUE='".$i."'";
              if ($CurrentYear == $i) {
				echo "selected";
				}
			 	echo ">".$i."</OPTION>";
            }
          ?>
    </select><br /><br />

CATEGORY:<br />
<? echo $catString; ?><div class='spacer'></div>
      <input type="submit" value="SAVE PAGE" id='submitstyle'> 
    </td>
    <td class='adminContent' valign="top">
    
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
PAGE TITLE:
<input type="text" name="txtTitle" class='inputstyle'>

<div class="spacer"></div>
<script type="text/javascript">
<!--
$(document).ready(function()	{
	// Add markItUp! to your textarea in one line
	// $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
	$('#markItUp').markItUp(mySettings);
	
	// You can add content from anywhere in your page
	// $.markItUp( { Settings } );	
	$('.add').click(function() {
 		$.markItUp( { 	openWith:'<opening tag>',
						closeWith:'<\/closing tag>',
						placeHolder:"New content"
					}
				);
 		return false;
	});
	
	// And you can add/remove markItUp! whenever you want
	// $(textarea).markItUpRemove();
	$('.toggle').click(function() {
		if ($("#markItUp.markItUpEditor").length === 1) {
 			$("#markItUp").markItUpRemove();
			$("span", this).text("get markItUp! back");
		} else {
			$('#markItUp').markItUp(mySettings);
			$("span", this).text("remove markItUp!");
		}
 		return false;
	});
});
-->
</script>
<textarea id="markItUp" cols="80" name='content' rows="20"></textarea>
<div class="spacer"></div>
    </td>
    </tr>
</table>
    
    
  </td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
</form>