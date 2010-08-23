<?php
	//Include the PS_Pagination class
	include('ps_pagination.php');
	
	//Connect to mysql db
	$conn = mysql_connect('localhost','outland_panel','pfout.08');
	mysql_select_db('outland_panel',$conn);
	$sql = 'SELECT * FROM usercomments';
	
	//Create a PS_Pagination object
	$pager = new PS_Pagination($conn,$sql,2,3);
	
	//The paginate() function returns a mysql result set 
	$rs = $pager->paginate();
	while($row = mysql_fetch_assoc($rs)) {
		echo $row['comment'],"<br />\n";
	}
	
	//Display the full navigation in one go
	echo $pager->renderFullNav();
	
	//Or you can display the inidividual links
	//echo "<br />";
	
	//Display the link to first page: First
	//echo $pager->renderFirst();
	
	//Display the link to previous page: <<
	//echo $pager->renderPrev();
	
	//Display page links: 1 2 3
	//echo $pager->renderNav();
	
	//Display the link to next page: >>
	//echo $pager->renderNext();
	
	//Display the link to last page: Last
	//echo $pager->renderLast();
?>