<? 

function add_string_entry($Title,$Track) {
	global $InitDB, $IsReader;
		$PageLink = curPageURL();
		$UserID = $_SESSION['userid'];
		$query = "SELECT ID from string_links where Url='$PageLink'";
		$LinkID = $InitDB->queryUniqueValue($query);
		//print $query.'<br/>';
		//print 'LinkID = ' .$LinkID.'<br/>';
		if (($_SERVER['SCRIPT_NAME'] != '/feed_wizard.php') && ($UserID != '')){
			//print 'SCIRPT = '. $_SERVER['SCRIPT_NAME'].'<br/>';
			//$file = file($url);
			//$file = implode("",$file);
			$CurrentDate = date('Y-m-d h:i:s');
			//if(preg_match("/<title>(.+)<\/title>/i",$file,$m)) {
				//$Title = mysql_real_escape_string($m[1]);
			//} else { 
				//$UrlArray = explode('/',$PageLink);
			$Title = mysql_real_escape_string($Title);
			//}
				
			if ($LinkID == '') {
				$query = "INSERT into string_links (Title, Url, CreatedDate) values ('$Title','$PageLink','$CurrentDate')";
				$InitDB->execute($query);
				//print $query.'<br/>';
				$query = "SELECT ID from string_links where Url='$PageLink'";
				$LinkID = $InitDB->queryUniqueValue($query);
				///print $query.'<br/>';
			}
			
			$query = "SELECT * from string_entries where LinkID='$LinkID' and UserID='$UserID'";
			$EntryArray =  $InitDB->queryUniqueObject($query);
			$EntryID = $EntryArray->ID;
			$MarkStatus = $EntryArray->IsMarked;
			//print $query.'<br/>';
			if ($EntryID == '') {
				$query = "INSERT into string_entries (UserID, LinkID, FirstVisited,LastVisited) values ('$UserID','$LinkID','$CurrentDate','$CurrentDate')";
				$InitDB->execute($query);
				//print $query.'<br/>';
			} else {
				$query = "UPDATE string_entries set LastVisited='$CurrentDate' where UserID='$UserID' and LinkID='$LinkID'";
				$InitDB->execute($query);
				
			}
			$_SESSION['currentStringID'] = $EntryID;
			$_SESSION['CurrentMarkStatus'] = $MarkStatus;
		}

}

function build_drawers($DrawerID) {

		global $InitDB, $DB, $DB2;
		$DrawerCount = 0;
		$UserID = $_SESSION['userid'];
		
		/*<div id="drawerdiv_'.$DrawerID.'" style="display:none;">*/
		$String = '<div id="drawer_container'.$DrawerID.'" class="yuimenu">
                            <div class="bd">
                                <ul class="first-of-type">
                                <li class="yuimenuitem first-of-type">';
	
		$query ="SELECT * from drawers where UserID='$UserID' and ParentID='0' and DrawerID='$DrawerID' order by Position";
		
		$InitDB->query($query);
		//print $query.'<br/>';
		while ($line = $InitDB->FetchNextObject()) {
		
			   if ($line->DrawerType == 'label') {
			   		
					$ParentID = $line->ID;
					
					$String .= '<a class="yuimenuitemlabel" href="#drawer_'.$DrawerID.'-'.$DrawerCount.'">'.$line->Title.'</a>';
					$String .= '<div id="#drawer_'.$DrawerID.'-'.$DrawerCount.'" class="yuimenu">
                                            <div class="bd">
                                                <ul>';
					$DrawerCount++;
					
					$query ="SELECT * from drawers where UserID='$UserID' and ParentID='$ParentID' order by Position";
					$DB->query($query);
					//print $query.'<br/>';
					while ($line2 = $DB->FetchNextObject()) {
							if ($line2->DrawerType == 'label') {
								   $SubParentID = $line2->ID;
								  // print 'Subparent<br/>';
								   $query = "SELECT * from drawers where UserID='$UserID' and ParentID='$SubParentID' order by Position"; 				$DB2->query($query);
									//print $query.'<br/>';
								   $String .= '<li><a class="yuimenuitemlabel" href="#drawer_'.$DrawerID.'-'.$DrawerCount.'">'.$line2->Title.'</a>';
								   $String .= '<div id="#drawer_'.$DrawerID.'-'.$DrawerCount.'" class="yuimenu">
                                            			<div class="bd">
                                                			<ul class="first-of-type">';	
								   $DrawerCount++;		
								   while ($line3 = $DB2->FetchNextObject()) {
											$String .= '<li class="yuimenuitem"><a class="yuimenuitemlabel" href="'.$line3->Link.'">'.$line3->Title.'</a></li>';
								   }
								    $String .= '</ul>';
									$String .= '</div>';
									$String .= '</div>';	
									$String .= '</li>';	
								   
							 } else {
							 
							  		$String .= '<li class="yuimenuitem"><a class="yuimenuitemlabel" href="'.$line2->Link.'">'.$line2->Title.'</a></li>';
							  
							 }
					}
					 $String .= '</ul>
                                            </div>
                                        </div>      
                                    
                                    </li>';
			   
			   } else {
			   	
					$String .= '<li class="yuimenuitem"><a class="yuimenuitemlabel" href="'.$line->Link.'">'.$line->Title.'</a></li>';
			   
			   }
		}
		      $String .= '</ul>            
                            </div>
                        </div>';
				/*</div>*/
				return $String;
}
		
function build_string() {
	global $InitDB,$StringStart;
	$StringEntries = '';
		$UserID = $_SESSION['userid'];
		$query = "SELECT se.LinkID,se.IsMarked,se.ID as EntryID, se.UserID, se.LastVisited, sl.* from string_entries as se
				  join string_links as sl on se.LinkID=sl.ID
				  where se.UserID='$UserID' and sl.Title != '' order by se.LastVisited ASC limit 50";
		$InitDB->query($query);
		//$NumEntries = $InitDB->numRows();
		//$StringStart = ($NumEntries-1);
		
		while ($line = $InitDB->FetchNextObject()) {
			$TitleArray = explode('|',$line->Title);
			$StringTitle =  substr(trim($TitleArray[0]),0,11);
			$SubTitleArray = explode('-',trim($TitleArray[1]));
			
			$SubTitle = trim($SubTitleArray[0]);
			$SubSubTitle =  trim($SubTitleArray[1]);
			if ($SubTitle != 'Home') {
				$StringTitle = substr($SubTitle,0,11);
				$SubTitle =  trim($SubTitleArray[1]);
				$SubSubTitle =  trim($SubTitleArray[2]);
			
			}
			if ($line->IsMarked != 1){
				$Image = 'string_unmarked.png';
				$Class = '';
				$Status = 'unmarked';
			}else{
				$Image = 'string_marked.png';
				$Class = '';
				$Status = 'marked';
			
			}
			$StringEntries .='<li><div class="'.$Status.'" id=\'string_'.$line->EntryID.'\' onclick="mini_menu(\''.$line->Title.'\',\''.$line->Url.'\',\''.$line->EntryID.'\',\'string\',\''.$Status.'\',this, event);return false;" ><div style=\'height:2px;\'></div><span id=\'string_'.$Class.'title\'>'.$StringTitle.'&nbsp;&nbsp;&nbsp;</span><br/><span id=\'string_'.$Class.'subtitle\'>'.substr($SubTitle,0,15).'&nbsp;&nbsp;&nbsp;&nbsp;</span><br/><span id=\'string_'.$Class.'subtitle\'>'.$SubSubTitle.'&nbsp;&nbsp;&nbsp;&nbsp;</span></div></li>';
	/*
	<div style="float:right;"><a href="#" onclick="show_layer(\''.$line->Title.'\',\''.$line->Url.'\',\''.$line->ID.'\',\'string\', event);return false;">*</a></div>
	*/
		}
		
		return $StringEntries;
}
?>