<? 
$Postarray = new DB();
$CurrentDay = date('d');
$CurrentMonth = date('m');
$CurrentYear = date('Y');
$todays_date = date("Y-m-d"); 
$IdArray = '';
$DateArray = '';
$TotalItems = 0;
$TodayDateTime = strtotime($todays_date); 
if ($ModuleApplication == 'blog') {
	$query = "select * from pf_blog_modules where id=1";
	$Postarray->query($query);
	while ($line = $Postarray->fetchNextObject()) { 
		$Title = $line->Title;
	}
	$query = "select * from pf_blog_posts order by PublishDate";
	$Postarray->query($query);
	while ($line = $Postarray->fetchNextObject()) { 
		$PostID = $line->ID;
		$PublishDate = $line->PublishDate;
		$PublishDateNew = substr($PublishDate, 6, 4) .'-'.substr($PublishDate, 0, 2)  .'-'. substr($PublishDate, 3, 2); 
		$PublishDateTime = strtotime($PublishDateNew);
		if ($PublishDateTime <= $TodayDateTime) { 
			if (strlen($IdArray) > 0) {
				$IdArray .=',';
			}
			if (strlen($DateArray) > 0) {
				$DateArray .=',';
			}
			$IdArray .= $PostID;
			$DateArray .= $PublishDate;
			$TotalItems++;
		} 
	}
} else if ($ModuleApplication == 'content') {
	$query = "select * from pf_modules where id=1";
	$Postarray->query($query);
	while ($line = $Postarray->fetchNextObject()) { 
		$Title = $line->Title;
	}
	$query = "select * from content where published=1 order by CreationDate DESC";
	$Postarray->query($query);
	while ($line = $Postarray->fetchNextObject()) { 
		$PostID = $line->ID;
		$PublishDate = $line->CreationDate;
		if (strlen($IdArray) > 0) {
				$IdArray .=',';
			}
			if (strlen($DateArray) > 0) {
				$DateArray .=',';
			}
			$IdArray .= $PostID;
			$DateArray .= substr($PublishDate, 5, 2)  .'-'. substr($PublishDate, 8, 2).'-'. substr($PublishDate, 0, 4);
			$TotalItems++;
	}
}

?>
<div align="center">
			<div id="calendar">You need to have your javascript turned on and make sure you have the latest version of Flash<a href="http://www.adobe.com/go/getflashplayer/" target="_blank">Player 9</a> or better installed.</div>
<script type="text/javascript"> 
    var so = new SWFObject('flash/content_calendar.swf','cal','210','150','#ffffff','9');                  
				  so.addParam('allowfullscreen','true'); 
                  so.addParam('allowscriptaccess','true'); 
				  so.addVariable('currentday','<?php echo $CurrentDay;?>');
				  so.addVariable('currentmonth','<?php echo $CurrentMonth;?>');
				  so.addVariable('currentyear','<?php echo $CurrentYear;?>');
				  so.addVariable('publishdate','<?php echo $PublishDate;?>');
				  so.addVariable('application','<?php echo $ModuleApplication;?>');
				  so.addVariable('totalitems','<?php echo $TotalItems;?>');
				  so.addVariable('idarray','<?php echo $IdArray;?>');
				  so.addVariable('datearray','<?php echo $DateArray;?>');
				  so.addParam("wmode", "transparent");
                  so.write('calendar'); 
</script>
</div>