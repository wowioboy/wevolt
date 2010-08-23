<?php

require_once "classes/diggclass.php";

$diggobj = new diggclass();

//get stories that kevin rose has dugg
$results= $diggobj->getUserDiggs("outlandmatt",$count=10,$offset=0,"","");
foreach($results as $story) {
	$StoryID = $story['story'];
	$StoryArray = $diggobj->getDiggs("",10,0,null,null,$StoryID);
	//print_r($StoryArray);
	//print'<br/>';
	$comments = $diggobj->getComments("",10,0,null,null,$StoryID);
	//print_r($comments);
	//print'<br/>';
	$diggs = $diggobj->getDiggs("",10,0,null,null,$StoryID);
	//print_r($diggs);
	//print'<br/>';print'<br/>';
	$stories = $diggobj->getStories("",$StoryID,"","","","");
	//print_r($stories);print'<br/>';print'<br/>';
	
	foreach($stories as $info) {
		print 'LINK = ' . $info['link'];
		print'<br/>';
		print 'Title = ' . $info['title'];
		print'<br/>';
		print 'Description = ' . $info['description'];
		$ThumbArray = $info['thumb'];
		$TCount = 0;
		foreach ($ThumbArray as $Thumb) {
	if ($TCount == 4)
		print 'Thumb = ' . $Thumb;
		print'<br/>';
		$TCount++;
		}
		
	
	}
}
?>
