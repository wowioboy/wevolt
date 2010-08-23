<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>, <?php echo $Creator;?>"></meta>
<LINK href="css/pf_css.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $SiteTitle; ?> - <?php echo $PageTitle; ?></title>
<script language="Javascript">
 <!--

 function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
 
 function showCommentBox(val)
	{ 
	if (val == 0)
		{
			document.getElementById("trcommentbox").style.display = 'none';
				
		}
		else
		{
			document.getElementById("trcommentbox").style.display = '';
						
		}
	}	
	
	function revealModal(divID)
	{
		window.onscroll = function () { document.getElementById(divID).style.top = document.body.scrollTop; };
		document.getElementById(divID).style.display = "block";
		document.getElementById(divID).style.top = document.body.scrollTop;
	}
	
	function hideModal(divID)
	{
		document.getElementById(divID).style.display = "none";
	}
	
 //-->
 </script>
</head>
<body>
<div class="wrapper" align="center">