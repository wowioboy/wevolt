<?php
$xml_comment_key = "*COMIC*PAGE*COMMENT";
$xml_pageid_key = "*COMIC*PAGE*ID";
$xml_active_key = "*COMIC*PAGE*ACTIVE";
$xml_datelive_key = "*COMIC*PAGE*DATELIVE";
$xml_image_key = "*COMIC*PAGE*IMAGE";
$xml_title_key = "*COMIC*PAGE*TITLE";
$xml_height_key = "*COMIC*PAGE*IMGHEIGHT";

//$xml_description_key = "*NEWS*STORY*DESCRIPTION";

$story_array = array();
$counter = 0;
class xml_story{
    var $AuthorComment;
	var $PageID;
	var $Image;
	var $Title;
	var $Date;
	var $ImageHeight;
}


function startTag($parser, $data){
    global $current_tag;
    $current_tag .= "*$data";
}

function endTag($parser, $data){
    global $current_tag;
    $tag_key = strrpos($current_tag, '*');
    $current_tag = substr($current_tag, 0, $tag_key);
}

function contents($parser, $data){
    global $current_tag,$xml_pagetitle_key, $xml_height_key, $xml_comment_key, $xml_headerimage_key, $xml_tags_key, $xml_genre_key, $xml_datelive_key, $xml_title_key, $xml_pageid_key, $xml_image_key,$xml_active_key, $counter, $story_array; 
	
	//print "MY CURRENT TAG " . $current_tag."<br>";
    switch($current_tag){
	
	 case $xml_pageid_key:
	        $story_array[$counter] = new xml_story();
            $story_array[$counter]->id = $data;
            break;	
       
	    case $xml_comment_key:
            $story_array[$counter]->comment = $data;
		    break;
			
		case $xml_height_key:
            $story_array[$counter]->imgheight = $data;
			//print "MY HEIGHT DATA " . $data."<br>";
		    break;
			
		case $xml_image_key:
            $story_array[$counter]->image = $data;
			//print "MY IMAGE DATA " . $data."<br>";
		    break;
			
		case $xml_title_key:
            $story_array[$counter]->title = $data;
		    break;
					
		case $xml_active_key:
            $story_array[$counter]->active = $data;
			 //print "MY COUNTER = " .$counter++; 
            break;	
			case $xml_datelive_key:
            $story_array[$counter]->datelive = $data;
			//print "MY DATELIVE DATA " . $data."<br>";
			$counter++;
            break;
    }
}

$xml_parser = xml_parser_create();

xml_set_element_handler($xml_parser, "startTag", "endTag");

xml_set_character_data_handler($xml_parser, "contents");

$fp = fopen($xml_file, "r") or die("Could not open file");

$data = fread($fp, filesize($xml_file)) or die("Could not read file");

if(!(xml_parse($xml_parser, $data, feof($fp)))){
    die("Error on line " . xml_get_current_line_number($xml_parser));
}

xml_parser_free($xml_parser);

fclose($fp);

///PARSE COMIC INFO
?>