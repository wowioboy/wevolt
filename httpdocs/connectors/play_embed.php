<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

$FeedItemID = $_GET['item'];
$ModuleID = $_GET['module'];
$Width = $_GET['w'];
$Height = $_GET['h'];
	
$query = "SELECT * from feed_items where EncryptID='$FeedItemID' and (MyModule='$ModuleID' or WeModule='$ModuleID')";
$ItemArray = $DB->queryUniqueObject($query);
$DB->close();

?>
<style type="text/css">
body,html {
margin:0px;
padding:0px;
background-color:#000000;

}

</style>

<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
 <table width="100%" cellpadding="0" cellspacing="0">
 
 <tr><td width="19" height="46" style="background-image:url(http://www.wevolt.com/images/viewer_border_T.jpg); background-repeat:repeat-x;" ><img src="http://www.wevolt.com/images/viewer_border_TL.jpg" /></td><td height="46" style="background-image:url(http://www.wevolt.com/images/viewer_border_T.jpg); background-repeat:repeat-x;" align="center"><img src="http://www.wevolt.com/images/viewer_header.jpg" /></td><td width="19" height="46" ><img src="http://www.wevolt.com/images/viewer_border_TR.jpg" /></td></tr>
  <tr>
  <td width="19" style="background-image:url(http://www.wevolt.com/images/viewer_border_L.jpg); background-repeat:repeat-y;"></td>
 <td>
  <div align="center" class="messageinfo_white"><div class="spacer"></div>
TITLE: <? echo $ItemArray->Title;?><div class="spacer"></div>
<? echo $ItemArray->Embed;?>
</div>
  </td>
  <td width="19" style="background-image:url(http://www.wevolt.com/images/viewer_border_R.jpg); background-repeat:repeat-y;"></td>
  </tr>
   <tr><td width="19" height="17" style="background-image:url(http://www.wevolt.com/images/viewer_border_B.jpg); background-repeat:repeat-x;"><img src="http://www.wevolt.com/images/viewer_border_BL.jpg" /></td>
   <td width="17" style="background-image:url(http://www.wevolt.com/images/viewer_border_B.jpg); background-repeat:repeat-x;"></td>
   <td width="19" height="17" ><img src="http://www.wevolt.com/images/viewer_border_BR.jpg" /></td></tr>
  </table>

