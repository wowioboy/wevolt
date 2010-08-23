<?php 
$UpdateXml = 0;
$CurrentDate= date('D M j'); 

$CurrentDay = date('d');
$CurrentMonth = date('m');
$CurrentYear = date('Y');

if ($PageID == ''){
	for ($z=$counter-1; $z>= 0; $z--){
		$Date = $story_array[$z]->datelive;
		$Active = $story_array[$z]->active;
		$PageDay = substr($Date, 3, 2); 
		$PageMonth = substr($Date, 0, 2); 
		$PageYear = substr($Date, 6, 4);

 			if ($Active == 1){
 				$PageID = $story_array[$z]->id;
				//print "MY PAGE SET = ". $PageID;
 				$AuthorComment = $story_array[$z]->comment;
				$Image = $story_array[$z]->image;
				$Title = $story_array[$z]->title;
				$ImageHeight = $story_array[$z]->imgheight;	
				list($Width, $Height) = split('[x]', $ImageHeight);	
				//print "MY WIDTH AND HEIGHT = " .$Width."x".$Height."<br/>"; 
				//print "MY FULL = " .$ImageHeight."<br/>"; 
				//print "MY COMMENT SET = " . $AuthorComment;
	
 				$CurrentIndex = $z;
				$NextPage = $PageID;
				  if ($z > 0) {
				    $PrevPage = $story_array[$z-1]->id;
				    } else { 
					$PrevPage = $PageID;
					}
				break;
 			 }  else if ($PageYear<$CurrentYear) {
				  $PageID = $story_array[$z]->id;
 				  $AuthorComment = $story_array[$z]->comment;
				  $Image = $story_array[$z]->image;
				  $Title = $story_array[$z]->title;
				  $ImageHeight = $story_array[$z]->imgheight;
				  list($Width, $Height) = split('[x]', $ImageHeight);	
				  //print "MY WIDTH AND HEIGHT = " .$Width."x".$Height."<br/>";
				 // print "MY FULL = " .$ImageHeight."<br/>";  		
 				  $CurrentIndex = $z;
				  $NextPage = $PageID;
				    if ($z > 0) {
				    $PrevPage = $story_array[$z-1]->id;
				    } else { 
					$PrevPage = $PageID;
					}
				  $UpdateXml = 1;
				  break;
			 } else if ($PageYear == $CurrentYear) {
				if ($PageMonth<$CurrentMonth) {
					$PageID = $story_array[$z]->id;
 				 	$AuthorComment = $story_array[$z]->comment;
				 	$Image = $story_array[$z]->image;
				  	$Title = $story_array[$z]->title;
					$ImageHeight = $story_array[$z]->imgheight;	
					list($Width, $Height) = split('[x]', $ImageHeight);
					//print "MY WIDTH AND HEIGHT = " .$Width."x".$Height."<br/>"; 
					//print "MY FULL = " .$ImageHeight."<br/>"; 
 				  	$CurrentIndex = $z;
					$NextPage = $PageID;
			      	    if ($z > 0) {
				   		 $PrevPage = $story_array[$z-1]->id;
				    	} else { 
						$PrevPage = $PageID;
						}
				  	$UpdateXml = 1;
				  	break;
				} else if ($PageMonth == $CurrentMonth) {
					if ($PageDay<=$CurrentDay) {
						$PageID = $story_array[$z]->id;
 				 	    $AuthorComment = $story_array[$z]->comment;
				 	    $Image = $story_array[$z]->image;
				  	    $Title = $story_array[$z]->title;
						$ImageHeight = $story_array[$z]->imgheight;
						list($Width, $Height) = split('[x]', $ImageHeight);	
						//print "MY WIDTH AND HEIGHT = " .$Width."x".$Height."<br/>";
						//print "MY FULL = " .$ImageHeight."<br/>";  
 				  	    $CurrentIndex = $z;
						$NextPage = $PageID;
				        if ($z > 0) {
				   		 $PrevPage = $story_array[$z-1]->id;
				    	} else { 
						$PrevPage = $PageID;
						}
				  	    $UpdateXml = 1;
				  	    break;
			        } 
				}
			}
 	}  // end for
}else {
 for ($z=0; $z < $counter; $z++){
 		$Pagetest = $story_array[$z]->id;
 			if ($PageID == $Pagetest){
 			$AuthorComment = $story_array[$z]->comment;
			$Image = $story_array[$z]->image;
			$Title = $story_array[$z]->title;
			$ImageHeight = $story_array[$z]->imgheight;	
			list($Width, $Height) = split('[x]', $ImageHeight);
			$Date = $story_array[$z]->datelive;		
 			$CurrentIndex = $z;
			if ($z == ($counter - 1)){ 
			$NextPage = $PageID;
			} else if ($story_array[$z+1]->active == '1'){
			$NextPage = $story_array[$z+1]->id;
			} else {
			$NextPage = $PageID;
			}
			if ($z > 0) {
			$PrevPage = $story_array[$z-1]->id;
			} else { 
			$PrevPage = $PageID;
			}
 			break;
			}
 }
}
//print "DO YOU HAVE TO UPDATE THAT XML? 0 or 1: ".$UpdateXml."<br/>";
$TotalPages = 0;
//print "MY COUNTER = " . $counter. "<br/>";
for ($k=0; $k< $counter; $k++){
$idSafe = 0; 
 	$Date = $story_array[$k]->datelive;
	$Active = $story_array[$k]->active;
	$SafeID = $story_array[$k]->id;
	$PageDay = substr($Date, 3, 2); 
	$PageMonth = substr($Date, 0, 2); 
	$PageYear = substr($Date, 6, 4);
		if ($PageYear<$CurrentYear) {
			$idSafe = 1; 
			$TotalPages++;
		   } else if ($PageYear == $CurrentYear) {
						if ($PageMonth<$CurrentMonth) {
							//print "SAFE ID = " .$SafeID."<br/>"; 
							$idSafe = 1; 
							 $TotalPages++;
							 //print "MY TOTAL PAGES MONTH LESS = " .$TotalPages."<br/>";
						   } else if ($PageMonth == $CurrentMonth) {
								    if ($PageDay<=$CurrentDay) {
									//print "SAFE ID = " .$SafeID."<br/>"; 
									     $idSafe = 1; 
									     $TotalPages++;
										//print "MY TOTAL PAGES DAY LESS = " .$TotalPages."<br/>";
				  	
			        				  } // End If
						          } // End PageMonth
			  } // end TEST
		    	if (($Active == 0) && ($idSafe = 1)){
 			    //$PageID = $story_array[$k]->id;
				 $UpdateXml = 1;
   } 
} // end for

?>