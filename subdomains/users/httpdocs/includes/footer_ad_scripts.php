<script type="text/javascript">
	
<? if  ($_SESSION['noads'] != 1) {?>
	<? if ($HomePage == 1) {?>
		if (window.frames["top_ads"] != null)
			window.frames["top_ads"].location='/includes/top_banner_inc.php?home=1';
		if (window.frames["left_ads"] != null)
			window.frames["left_ads"].location='/includes/left_ads_inc.php?home=1'; 
		if (window.frames["home_300"] != null)
			window.frames["home_300"].location='/includes/home_300_ad_inc.php'; 	
			
	<? } else if ($IsProject){?>
		if (window.frames["top_ads"] != null)
		    window.frames["top_ads"].location='/includes/publisher_top_banner_inc.php?project=<? echo $SafeFolder;?>';
		 if (parent.window.frames["left_ads"] != null)
			parent.window.frames["left_ads"].location='/includes/publisher_left_ads_inc.php?project=<? echo $SafeFolder;?>';
	<? } else {?>
		if (window.frames["top_ads"] != null)
			window.frames["top_ads"].location ='/includes/top_banner_inc.php';
		if (window.frames["left_ads"] != null)
			window.frames["left_ads"].location='/includes/left_ads_inc.php?'; 
	
	<? }?>
<? } else {
	 if ($HomePage == 1) {?>
		if (window.frames["home_300"] != null)
			window.frames["home_300"].location='/includes/home_300_ad_inc.php'; 	
			
	<? }
 }?>

</script>