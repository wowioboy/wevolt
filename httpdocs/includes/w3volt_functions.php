<? 
function myTruncate($string, $limit, $break=".", $pad="...") { 
// return with no change if string is shorter than $limit  
if(strlen($string) <= $limit) return $string; 
// is $break present between $limit and the end of the string?  
if(false !== ($breakpoint = strpos($string, $break, $limit))) { if($breakpoint < strlen($string) - 1) { $string = substr($string, 0, $breakpoint) . $pad; } } return $string; 

}
function build_popup_menus($MenuModule,$CellID,$MenuModuleTemplate,$MenuModuleType, $ContentVariable) {
global $ModuleTitleArray,$ModuleIndex, $UserID;

	$PopMenuString.="<div id='".$MenuModule."_menu' style='display:none; position:absolute;' class='action_pop'><div  onmouseover=\"hide_layer('".$MenuModule."_menu', event);\" style='height:5px;'></div><table width='100%'><tr>
							<td onmouseover=\"hide_layer('".$MenuModule."_menu', event);\" width='5'></td><td>";
					
					if ($MenuModuleType == 'mod_template') {
						if ($MenuModuleTemplate == 'twitter') {
							//$MenuString.="<a href='http://twitter.com/".$ContentVariable."' target=\"_blank\" onclick=\"hide_layer('".$MenuModule."_menu', event);\">FOLLOW ON TWITTER</a>";
							
							$PopMenuString.="<a href='#' onclick=\"edit_window('".$CellID.'-'.$MenuModule."','twitter','edit','myvolt');hide_layer('".$MenuModule."_menu', event);\">edit window</a>";
							
						} else if ($MenuModuleTemplate == 'rss') {
					
							$PopMenuString.="<a href='#' onclick=\"edit_window('".$CellID.'-'.$MenuModule."','headlines','edit','myvolt');hide_layer('".$MenuModule."_menu', event);\">edit feeds</a><br/>";
							$PopMenuString.="<a href='#' onclick=\"edit_window('".$CellID.'-'.$MenuModule."','headlines','new','myvolt');hide_layer('".$MenuModule."_menu', event);\">add feed</a>";
							
						} else if ($MenuModuleTemplate == 'excite_single') {
					
							$PopMenuString.="<a href='#' onclick=\"re_excite('".$MenuModule."');hide_layer('".$MenuModule."_menu', event);\">RE-EXCITE</a>";
							
						}
					
					
					} else if ($MenuModuleType == 'excite_box') {
							//$PopMenuString.="<a href='#' onclick=\"re_excite('".$MenuModule."');hide_layer('".$MenuModule."_menu', event);\">RE-EXCITE</a>";
					
					} else if ($MenuModuleType == 'html') {
					
					
					} else if ($MenuModuleType == 'list') {
							if ($_SESSION['userid'] != '')
								$PopMenuString.="<a href='#' onclick=\"copy_items('".$CellID.'-'.$MenuModule."');hide_layer('".$MenuModule."_menu', event);\">COPY ITEMS</a><br/>------------<br/>";
			
					}
					
				
				if ($_SESSION['userid'] == $UserID){
						$PopMenuString.="<br/>--ADMIN--<br/><a href='#' onclick=\"window_wizard('edit');hide_layer('".$MenuModule."_menu', event);\">Dropdown Wizard</a>";
						$PopMenuString.="<br/><a href='#' onclick=\"edit_wevolt_window('".$CellID.'-'.$MenuModule."');hide_layer('".$MenuModule."_menu', event);\">Edit Dropdown</a>";
						$PopMenuString.="<br/><a href='#' onclick=\"edit_window('".$CellID.'-'.$MenuModule."','items','add','wevolt');hide_layer('".$MenuModule."_menu', event);\">add item</a><br/>";
						$PopMenuString.="<a href='#' onclick=\"edit_window('".$CellID.'-'.$MenuModule."','items','edit','wevolt');hide_layer('".$MenuModule."_menu', event);\">edit items</a>";
						$PopMenuString.="<br/><a href='#' onclick=\"edit_wevolt_window_label('".$CellID."');hide_layer('".$MenuModule."_menu', event);\">Edit Window Label</a>";
				}
	
					
					
					
					
	
				
			$PopMenuString.="</td><td onmouseover=\"hide_layer('".$MenuModule."_menu', event);\" width='5'></td></tr></table><div  onmouseover=\"hide_layer('".$MenuModule."_menu', event);\" style='height:5px;'></div></div>";
				$PopMenuString.='<div id="'.$MenuModule.'_menu_wrapper" style="display:none;"><a href="#" onclick="mini_menu(\''.$MenuModule.'_menu\',\'\',\''.$CellID.'_menu\',\'myvolt\',\'\',this, event);return false;"><img src="http://www.wevolt.com/templates/modules/standard/action_star.png" hspace="3" vspace="3" border="0" width="15" class="navbuttons"></a></div>';
return $PopMenuString;
}
function get_feed_items($ModuleID, $FeedID, $UserID) {

	global $DB,$DB2,$ModuleTitleArray,$ModuleIndex, $IsFriend, $IsOwner, $IsFan; 
	
	$String = '';
	$query = "SELECT * from feed_modules where EncryptID='$ModuleID'";
	$ModuleArray = $DB->queryUniqueObject($query);
	
	$SortVariable = $ModuleArray->SortVariable;
	$NumberVariable = $ModuleArray->NumberVariable;
	$Custom = $ModuleArray->Custom;
	$ContentVariable = $ModuleArray->ContentVariable;
	$ThumbSize = $ModuleArray->ThumbSize;
	$Template = $ModuleArray->ModuleTemplate;
	$ModuleType = $ModuleArray->ModuleType;
	$ModHTML = $ModuleArray->HTMLCode;
	$Cell = $ModuleArray->CellID;
	
	/*$MenuString.="<div id='".$ModuleID."_menu' style='display:none; position:absolute;' class='action_pop'><div onmouseover=\"hide_layer('".$ModuleID."_menu', event);\" style='height:5px;'></div><table width='100%'><tr>
							<td onmouseover=\"hide_layer('".$ModuleID."_menu', event);\" width='5'></td><td>";*/
							
	if ($ModuleType == 'content'){
		
		if ($ContentVariable == 'comic') {
			
			$query = "SELECT * from projects where Published=1 and Pages>1 and thumb!='' and ProjectType='comic' and Hosted=1 order by $SortVariable DESC LIMIT $NumberVariable ";
			$DB->query($query);
			
				while ($line = $DB->fetchNextObject()) {
					$String .= '<a href="http://www.wevolt.com/'.$line->SafeFolder.'/">';
					$String .= '<img src="http://www.wevolt.com'.$line->thumb.'" hspace="4" vspace="4" border="2" style="border-color:#000000;" width="'.$ThumbSize.'"  height="'.$ThumbSize.'" ></a>';
				}
		
		}
		
	
	//if ($_SESSION['userid'] != '')
		//$MenuString.="<a href='#' onclick=\"copy_items('".$Cell.'-'.$ModuleID."');hide_layer('".$ModuleID."_menu', event);\">Copy Items</a>";
		
	} else if ($ModuleType == 'list'){
		
		$query = "SELECT * from feed_items 
				  where WeModule='$ModuleID' and WeFeed='$FeedID' and UserID='$UserID' and IsPublished=1";
				  
				 
		$where = " and ((PrivacySetting='public') or (PrivacySetting='')";
		 if ($IsFriend)
			$where .= " or (PrivacySetting ='friends') or (PrivacySetting ='fans') ";
		 else if ($IsFan)
			$where .= " or (PrivacySetting ='fans') ";
		 else if ($IsOwner) 
			$where .= " or (PrivacySetting ='friends') or (PrivacySetting ='fans') or (PrivacySetting ='private') ";
		 $where .=")";
			
		 $query .= $where ." order by WeModule, WePosition";
				  
		$DB->query($query);
	//	print $query.'<br/>';
	//	print '<br/>';
		$ItemCount = 0;
		$CloseTable = 0;
		$TotalItems =$DB->numRows();

		while ($line = $DB->fetchNextObject()) {
				$ItemCount++;
			   $ProjectID = $line->ProjectID;
			   $ContentID = $line->ContentID;
			   
			   //AND IN IF STATEMENT TO CHECK FOR LIST MODULE TYPE
			   
			
				//print_r($line);
				//print '<br/>';
			//	print 'Template '.$Template.'<br/>';
			//	print 'ModuleID = '.$ModuleID .'</br>';
		//	print_r($line);
				$ModuleWidth = $ModuleTitleArray[$ModuleIndex]['Width'];
			
			   	if ($Template == 'content_thumb') {
					
						if ($line->Embed != '') {
		
							$String .= '<a href="#" onclick="play_embed(\''.$line->EncryptID.'\',\''.$ModuleID.'\',\''.(intval($line->EmbedWidth) +40).'\',\''.(intval($line->EmbedHeight) +100).'\');">';
							$Thumb = $line->Thumb;
							
							
						} else if ($line->ItemType == 'project_link') {
							
							$query = "SELECT * from projects where ProjectID='$ProjectID'";
							$ProjectArray = $DB2->queryUniqueObject($query);
							$ProjectType = $ProjectArray->ProjectType;
							$ProjectTarget = $ProjectArray->SafeFolder;
							$String .= '<a href="http://www.wevolt.com/'.$ProjectTarget.'/">';
							$Thumb = 'http://www.wevolt.com/'.$ProjectArray->thumb;
						} else if ($line->ItemType == 'feed_link') {
							$query = "SELECT * from feed where ProjectID='$ProjectID'";
							//$ProjectArray = $DB2->queryUniqueObject($query);
							//$ProjectType = $ProjectArray->ProjectType;
							//$ProjectTarget = $ProjectArray->SafeTitle;
							$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">';
						} else if ($line->ItemType == 'user_link') {
							$query = "SELECT * from users where encryptid='$ContentID'";
							$ProjectArray = $DB2->queryUniqueObject($query);
							$ProjectTarget = trim($ProjectArray->username);
								$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">';
								$Thumb = $ProjectArray->avatar;
						} else if ($line->ItemType == 'external_link'){
							$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">';
							$Thumb = $line->Thumb;
						}else {
							$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">';
							$Thumb = $line->Thumb;
						}
						
						$String .= '<img src="'.$Thumb.'"  hspace="3" vspace="3" border="2" style="border-color:#000000;" width="'.$ThumbSize.'"  height="'.$ThumbSize.'">';
						
						$String .= '</a>';
						
				} else if ($Template == 'content_thumb_title') {
						$TotalItemsAvailable = $ModuleWidth/$ThumbSize;
						//print 'Total Items = '.$TotalItemsAvailable.'<br/>';
						if ($String == '') 
							$String .= '<table><tr>';
						if ($ItemCount > $TotalItemsAvailable) {
							$String .= '</tr><tr>';
							$ItemCount = 0;
						}
						$String .= '<td align="center">'.$line->Title.'<br/>';
						$CloseTable = 1;
						if ($line->Embed != '') {
		
							$String .= '<a href="#" onclick="play_embed(\''.$line->EncryptID.'\',\''.$ModuleID.'\',\''.(intval($line->EmbedWidth) +40).'\',\''.(intval($line->EmbedHeight) +100).'\');">';
							$Thumb = $line->Thumb;
							
							
						} else if ($line->ItemType == 'project_link') {
							
							$query = "SELECT * from projects where ProjectID='$ProjectID'";
							$ProjectArray = $DB2->queryUniqueObject($query);
							$ProjectType = $ProjectArray->ProjectType;
							$ProjectTarget = $ProjectArray->SafeFolder;
							$String .= '<a href="http://www.wevolt.com/'.$ProjectTarget.'/">';
							$Thumb = 'http://www.wevolt.com/'.$ProjectArray->thumb;
						} else if ($line->ItemType == 'feed_link') {
							$query = "SELECT * from feed where ProjectID='$ProjectID'";
							$ProjectArray = $DB2->queryUniqueObject($query);
							$ProjectType = $ProjectArray->ProjectType;
							$ProjectTarget = $ProjectArray->SafeTitle;
							$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">';
						} else if ($line->ItemType == 'user_link') {
							$query = "SELECT * from users where encryptid='$ContentID'";
							$ProjectArray = $DB2->queryUniqueObject($query);
						//	print $query;
							$ProjectTarget = trim($ProjectArray->username);
								$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">';
								$Thumb = $ProjectArray->avatar;
						} else if ($line->ItemType == 'external_link'){
							$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">';
							$Thumb = $line->Thumb;
						}else {
							$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">';
							$Thumb = $line->Thumb;
						}
						
						$String .= '<img src="'.$Thumb.'"  hspace="3" vspace="3" border="2" style="border-color:#000000;" width="'.$ThumbSize.'"  height="'.$ThumbSize.'">';
						
						$String .= '</a>';
						$String .= '</td>';
						
				}else if ($Template == 'content_thumb_title_desc') {
						
						if ($ModuleWidth < 250) {
							$TotalItemsAvailable = 1;
							$ItemWidth = '100%';
						} else if (($ModuleWidth > 250) && ($ModuleWidth < 500)) {
							$TotalItemsAvailable = 2;
							$ItemWidth = '50%';
						} else if (($ModuleWidth > 500) && ($ModuleWidth < 800)) {
							$TotalItemsAvailable = 3;
							$ItemWidth = '33%';
						} else if ($ModuleWidth >= 800) {
							$TotalItemsAvailable = 4;
							$ItemWidth = '25%';
						}
					
						
				
						if ($String == '') 
							$String .= '<table><tr>';
						if ($ItemCount > $TotalItemsAvailable) {
							$String .= '</tr><tr>';
							$ItemCount = 0;
							}
						$String .= '<td align="left" valign="top" width="'.$ItemWidth.'">';
						$TempString = '<span class="sender_name">'.$line->Title.'</span><br/><span class="messageinfo">'.$line->Description.'</span>';
						$CloseTable = 1;
						if ($line->Embed != '') {
		
							$String .= '<a href="#" onclick="play_embed(\''.$line->EncryptID.'\',\''.$ModuleID.'\',\''.(intval($line->EmbedWidth) +40).'\',\''.(intval($line->EmbedHeight) +100).'\');">';
							$Thumb = $line->Thumb;
							
							
						} else if ($line->ItemType == 'project_link') {
							
							$query = "SELECT * from projects where ProjectID='$ProjectID'";
							$ProjectArray = $DB2->queryUniqueObject($query);
							$ProjectType = $ProjectArray->ProjectType;
							$ProjectTarget = $ProjectArray->SafeFolder;
							$String .= '<a href="http://www.wevolt.com/'.$ProjectTarget.'/">';
							$Thumb = 'http://www.wevolt.com/'.$ProjectArray->thumb;
						} else if ($line->ItemType == 'feed_link') {
							$query = "SELECT * from feed where ProjectID='$ProjectID'";
							$ProjectArray = $DB2->queryUniqueObject($query);
							$ProjectType = $ProjectArray->ProjectType;
							$ProjectTarget = $ProjectArray->SafeTitle;
							$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">';
						} else if ($line->ItemType == 'user_link') {
							$query = "SELECT * from users where encryptid='$ContentID'";
							$ProjectArray = $DB2->queryUniqueObject($query);
						//	print $query;
							$ProjectTarget = trim($ProjectArray->username);
								$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">';
								$Thumb = $ProjectArray->avatar;
						} else if ($line->ItemType == 'external_link'){
							$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">';
							$Thumb = $line->Thumb;
						} else {
							$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">';
							$Thumb = $line->Thumb;
						}
						
						$String .= '<img src="'.$Thumb.'"  hspace="3" vspace="3" border="2" style="border-color:#000000;" width="'.$ThumbSize.'"  height="'.$ThumbSize.'" align="left">';
						
						$String .= '</a>';
						$String .= $TempString.'</td>';
						
				} else if ($Template == 'content_list') {
						
							if ($line->Embed != '') {
		
							$String .= '<a href="#" onclick="play_embed(\''.$line->EncryptID.'\',\''.$ModuleID.'\',\''.(intval($line->EmbedWidth) +40).'\',\''.(intval($line->EmbedHeight) +100).'\');">';
							$Thumb = $line->Thumb;
							
							
						} else if ($line->ItemType == 'project_link') {
								$query = "SELECT * from projects where ProjectID='$ProjectID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectType = $ProjectArray->ProjectType;
								$ProjectTarget = $ProjectArray->SafeFolder;
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<div class="messageinfo">'.$line->Description.'<br/>';
								$String .= '<a href="http://www.wevolt.com/'.$ProjectTarget.'/">LINK</a></div><div class="medspacer"></div>';
						
							
						
							} else if ($line->ItemType == 'feed_link') {
								$query = "SELECT * from feed where ProjectID='$ProjectID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectType = $ProjectArray->ProjectType;
								$ProjectTarget = $ProjectArray->SafeFolder;
								$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">';
									 
							$String .= $line->Title;
							
							$String .= '</a>';
							
							}  else if ($line->ItemType == 'user_link') {
								$query = "SELECT * from users where encryptid='$ContentID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectTarget = trim($ProjectArray->username);
								$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">';
									 
							$String .= $line->Title;
							
							$String .= '</a>';
						
							} else if ($line->ItemType == 'external_link') {
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<div class="messageinfo">'.$line->Description.'<br/>';
								$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">LINK</a></div><div class="medspacer"></div>';
											
							} else {
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<div class="messageinfo">'.$line->Description.'<br/>';
								$String .= '<a href="'.$line->Link.'">LINK</a></div><div class="medspacer"></div>';
								
							}
						
							
				} else if ($Template == 'content_list_link') {
							
							if ($line->Embed != '') {
		
							$String .= '<a href="#" onclick="play_embed(\''.$line->EncryptID.'\',\''.$ModuleID.'\',\''.(intval($line->EmbedWidth) +40).'\',\''.(intval($line->EmbedHeight) +100).'\');">';
							$Thumb = $line->Thumb;
							
							
						} else if ($line->ItemType == 'project_link') {
								$query = "SELECT * from projects where ProjectID='$ProjectID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectType = $ProjectArray->ProjectType;
								$ProjectTarget = $ProjectArray->SafeFolder;
								$String .= '<div class="sender_name">'.$line->Title.'</div>';

								$String .= '<a href="http://www.wevolt.com/'.$ProjectTarget.'/">LINK</a></div><div class="medspacer"></div>';
						
							
						
							} else if ($line->ItemType == 'feed_link') {
								$query = "SELECT * from feed where ProjectID='$ProjectID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectType = $ProjectArray->ProjectType;
								$ProjectTarget = $ProjectArray->SafeFolder;
								$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">';
									 
							$String .= $line->Title;
							
							$String .= '</a>';
							
							}  else if ($line->ItemType == 'user_link') {
								$query = "SELECT * from users where encryptid='$ContentID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectTarget = trim($ProjectArray->username);
								$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/?t=profile">';
									 
							$String .= $line->Title;
							
							$String .= '</a>';
						
							} else if ($line->ItemType == 'external_link') {
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">LINK</a></div><div class="medspacer"></div>';
											
							} else {
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<a href="'.$line->Link.'">LINK</a></div><div class="medspacer"></div>';
								
							}
						
							
				}else if ($Template == 'content_list_desc') {
							
							if ($line->Embed != '') {
		
							$String .= '<a href="#" onclick="play_embed(\''.$line->EncryptID.'\',\''.$ModuleID.'\',\''.(intval($line->EmbedWidth) +40).'\',\''.(intval($line->EmbedHeight) +100).'\');">';
							$Thumb = $line->Thumb;
							
							
						} else if ($line->ItemType == 'project_link') {
								$query = "SELECT * from projects where ProjectID='$ProjectID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectType = $ProjectArray->ProjectType;
								$ProjectTarget = $ProjectArray->SafeFolder;
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<div class="messageinfo">'.$line->Description.'<br/>';
								$String .= '<a href="http://www.wevolt.com/'.$ProjectTarget.'/">LINK</a></div><div class="medspacer"></div>';
						
							} else if ($line->ItemType == 'feed_link') {
								$query = "SELECT * from feed where ProjectID='$ProjectID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectType = $ProjectArray->ProjectType;
								$ProjectTarget = $ProjectArray->SafeFolder;
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<div class="messageinfo">'.$line->Description.'<br/>';
								$String .= '<a href="http://www.wevolt.com/'.$ProjectTarget.'/">LINK</a></div><div class="medspacer"></div>';
							
							}  else if ($line->ItemType == 'user_link') {
								$query = "SELECT * from users where encryptid='$ContentID'";
								$ProjectArray = $DB2->queryUniqueObject($query);
								$ProjectTarget = trim($ProjectArray->username);
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<div class="messageinfo">'.$line->Description.'<br/>';
								$String .= '<a href="http://users.wevolt.com/'.$ProjectTarget.'/">LINK</a></div><div class="medspacer"></div>';
						
							} else if ($line->ItemType == 'external_link') {
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<div class="messageinfo">'.$line->Description.'<br/>';
								$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">LINK</a></div><div class="medspacer"></div>';
											
							}else {
								$String .= '<div class="sender_name">'.$line->Title.'</div>';
								$String .= '<div class="messageinfo">'.$line->Description.'<br/>';
								$String .= '<a href="'.$line->Link.'" target="'.$line->Target.'">LINK</a></div><div class="medspacer"></div>';
											
							}
						
							
				} else if ($Template == 'info_list') {
							$String .= '<div class="sender_name">'.$line->Title.'</div>';
							$String .= '<div class="messageinfo">'.$line->Description.'</div>';
				} 
				
				
		}
		//if ($_SESSION['userid'] != '')
			//$MenuString.="<a href='#' onclick=\"copy_items('".$Cell.'-'.$ModuleID."');hide_layer('".$ModuleID."_menu', event);\">COPY ITEMS</a>";
				

	} else if ($ModuleType == 'custom'){
				$String .='<div class="messageinfo">';
				$String .= nl2br(stripslashes($ModHTML));
				$String .='</div>';
	 		
						
	} else if ($ModuleType =='mod_template') {
				if ($Template == 'twitter') {
					
					$String .='<div id="tweet_'.$ModuleID.'" align="left" style="width:95%; padding-right:10px;" class="messageinfo">';
 					$String .='<div align=\'center\'>Please wait while my tweets load <img src="http://www.wevolt.com/images/load.gif" />';
 					$String .='<p><a href="http://twitter.com/'.$TwitterName.'">If you can\'t wait - check out what I\'ve been twittering</a></p></div>';
					$String .='<div class="menubar"><a href="http://twitter.com/'.$ContentVariable.'" id="twitter-link" style="display:block;text-align:right;">follow me on Twitter</a></div><script type="text/javascript" charset="utf-8">
getTwitters(\'tweet_'.$ModuleID.'\', { 
  id: \''.$ContentVariable.'\', 
  count: '.$NumberVariable.', 
  enableLinks: true, 
  ignoreReplies: true, 
  clearContents: true,
  template: \'%text% <br/><a href="http://twitter.com/%user_screen_name%/statuses/%id%/">%time%</a><div style="height:5px;"></div>\'
});
</script>';
					
					/*<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/'.$ContentVariable.'.json?callback=twitterCallback2&amp;count='.$NumberVariable.'"></script>';*/
					
					$String .='</div>';
				
					
				//	$MenuString.="<a href='http://twitter.com/".$ContentVariable."' target=\"_blank\" onclick=\"hide_layer('".$ModuleID."_menu', event);\">FOLLOW ON TWITTER</a>";
				
					
				} else if ($Template =='excite_status') {
				$query = "select distinct e.Blurb, e.ContentID, e.ContentType, e.CreatedDate, e.Comment, e.Link, u.avatar, u.username, p.thumb
		 				  from excites as e
						  
		 				  left join users as u on (e.ContentID=u.encryptid and e.ContentType='user')
						  left join projects as p on (e.ContentID=p.ProjectID)
							where e.UserID='$UserID' order by e.CreatedDate DESC limit 5";
					$DB2->query($query);
					
						while ($comic = $DB2->FetchNextObject()) {
							if ($comic->ContentType == 'user') 
								$Thumb = $comic->avatar;
							else 
								$Thumb = "http://www.wevolt.com".$comic->thumb;
							$Comment = preg_replace('/[^(\x20-\x7F)]*/','', $comic->Comment);

							$String.= "<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55' valign='top'><img src='/includes/round_images_inc.php?source=".$Thumb."&radius=20&colour=e9eef4' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top'><div class='sender_name'><a href='".$comic->Link."'>".$comic->Blurb."</a></div><div class='messageinfo'>".$Comment."</div></div></td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div>";

						}
						//if ($_SESSION['userid'] != '')
							//$MenuString.="<a href='#' onclick=\"re_excite('".$ModuleID."');hide_layer('".$ModuleID."_menu', event);\">RE-EXCITE</a>";
					
	
	}else if ($Template =='excite_single') {
				$query = "select distinct e.Blurb, e.ContentID, e.ContentType, e.CreatedDate, e.Comment, e.Link, u.avatar, u.username, p.thumb
		 				  from excites as e
						  
		 				  left join users as u on (e.ContentID=u.encryptid and e.ContentType='user')
						  left join projects as p on (e.ContentID=p.ProjectID)
							where e.UserID='$UserID' order by e.CreatedDate DESC limit 1";
					$DB2->query($query);
					
						while ($comic = $DB2->FetchNextObject()) {
							if ($comic->ContentType == 'user') 
								$Thumb = $comic->avatar;
							else 
								$Thumb = "http://www.wevolt.com".$comic->thumb;
							$Comment = preg_replace('/[^(\x20-\x7F)]*/','', $comic->Comment);

							$String.= "<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55' valign='top'><img src='/includes/round_images_inc.php?source=".$Thumb."&radius=20&colour=e9eef4' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a></td><td valign='top'><div class='sender_name'><a href='".$comic->Link."'>".$comic->Blurb."</a></div><div class='messageinfo'>".$Comment."</div></div></td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table><div class='smspacer'></div>";

						}
					//	if ($_SESSION['userid'] != '')
						//	$MenuString.="<a href='#' onclick=\"re_excite('".$ModuleID."');hide_layer('".$ModuleID."_menu', event);\">RE-EXCITE</a>";
					
	
	}
	}

	if ($CloseTable == 1)
		$String .='</tr></table>';
	
	//$MenuString.="</td><td onmouseover=\"hide_layer('".$ModuleID."_menu', event);\" width='5'></td></tr></table><div  onmouseover=\"hide_layer('".$ModuleID."_menu', event);\" style='height:5px;'></div></div>";
	
	
	//$String;//.=$MenuString;
	

	return $String;
	 
}

function build_cell($Title, $Template, $ModuleID, $FeedID, $UserID, $CellID,$SortVariable,$ContentVariable, $SearchVariable, $SearchTags, $Variable1, $Variable2, $Variable3, $Custom, $NumberVariable,$ThumbSize) {
		
	global $DB,$DB2,$ModuleTitleArray,$ModuleIndex,$TypeTarget, $TargetID,$MainWindowIDs,$ModHeight,$ModWidth, $IsFriend, $IsOwner, $IsFan; 
	$TabString = '';

	
	//print $query .'<br/>';
	//print 'TotalTabs ' .$TotalTabs.'<br/>';
	//print '<br/>';
	
	$FeedModuleArray = array(array());	
	$query = "SELECT EncryptID, Title from feed_modules where FeedID='$FeedID' and CellID = '$CellID' and IsMain = 1";
	$MainWindowArray = $DB->queryUniqueObject($query);	
	
	$MainWindowTitle = $MainWindowArray->Title;
	$MainWindowID = $MainWindowArray->EncryptID;
	//print 'Main Title = ' . $MainWindowTitle;
	if ($MainWindowID == '') {
		$NOW = date('Y-m-d h:i:s');
		$NewTitle = $ModuleTitleArray[$ModuleIndex]['Title'];
		if ($NewTitle == '')
			$NewTitle = 'New List';
					
			 $ModuleTemplate = 'list';
			 $ModuleType = 'content_list';
			 if ($UserID == $_SESSION['userid']) 
			 	 $IntroContent = '<img src="http://www.wevolt.com/images/tuts/create_wevolt_user.jpg">';
			 else 
			 	 $IntroContent = '<img src="http://www.wevolt.com/images/tuts/create_wevolt_no_user.jpg">';
			
		if ($ModuleTemplate == 'excite_single') {
			$query = "INSERT into feed_modules (Title,FeedID, CellID, IsMain, ModuleType, ModuleTemplate,CreateDate) values ('$NewTitle', '$FeedID', '$CellID', 1, '$ModuleType', '$ModuleTemplate','$NOW')";
			$DB->execute($query);
			$query ="SELECT ID from feed_modules WHERE FeedID='$FeedID' and CellID='$CellID' and CreateDate='$NOW'";
			$NewID = $DB->queryUniqueValue($query);
			$Encryptid = substr(md5($NewID), 0, 12).dechex($NewID);
			$query = "UPDATE feed_modules SET EncryptID='$Encryptid' WHERE ID='$NewID'";
			$DB->execute($query);
			$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID = '$CellID' and IsMain = 1";
			$MainWindowArray = $DB->queryUniqueObject($query);
			$MainWindowTitle = $MainWindowArray->Title;
			$MainWindowID = $MainWindowArray->EncryptID;
		} else {
			$MainWindowID = 'noneset-'.$ModuleIndex;
			$MainWindowTitle = 'INACTIVE<--';
		}
			
		
	
	} 
	$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and ParentModule = '$ModuleID' order by Position"; 
	$TotalTabs = $DB->queryUniqueValue($query);
	$ModuleTabIDArray[] = $MainWindowID;
	$MainWindowIDs[] =  $MainWindowID;

	$DivString = '<div id="'.$CellID.'">'; 
	//$DivString = '<div id="'.$ModuleID.'">'; 
	
	if ($_SESSION['IsPro'] == 1){ 
		$ModHeight = $ModuleTitleArray[$ModuleIndex]['Height'];
		    if ($ModuleTitleArray[$ModuleIndex]['Template'] == 'SinglexSingle')
				$ModWidth = $ModuleTitleArray[$ModuleIndex]['Width']+50;
			else if ($ModuleTitleArray[$ModuleIndex]['Template'] == 'DoublexSingle')
				$ModWidth = $ModuleTitleArray[$ModuleIndex]['Width'] + 100;
			else if ($ModuleTitleArray[$ModuleIndex]['Template'] == 'DoublexDouble')
				$ModWidth = $ModuleTitleArray[$ModuleIndex]['Width'] +50;
		
		
	}else {
			$ModTemplateArray = explode('x',$ModuleTitleArray[$ModuleIndex]['Template']);
			if ($ModTemplateArray[0] == 'Single')
				$ModHeight = $ModuleTitleArray[$ModuleIndex]['Height'] - 90;
			else if ($ModTemplateArray[0] == 'Double')
				$ModHeight = $ModuleTitleArray[$ModuleIndex]['Height'] - 45;
			else if ($ModTemplateArray[0] == 'Triple')
				$ModHeight = $ModuleTitleArray[$ModuleIndex]['Height'] - 30;
			
			$ModWidth = $ModuleTitleArray[$ModuleIndex]['Width'];
		
	}
	$ModuleString = '
	
	<!-- COMMENT FORM MODULE  -->
<table width="'.$ModWidth.'" height="'
.$ModHeight.'" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="fatmodtopleft"></td>

	<td id="fatmodtop" width="'.($ModWidth-40).'" valign="bottom">';
	
	//$ModuleTabIDArray = array($ModuleID);
	
	$TabString .= '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr>';
	$TabString .= '<td align="left"><select name="txtModuleSelect" onChange="mod_tab(this.options[this.selectedIndex].value);" style="width:125px; height:20px; font-size:12px;">'; 
	$TabString .= '<option value=\'\'>--';
	if ($ModuleTitleArray[$ModuleIndex]['Title'] == '')
		$TabString .= '-----------';
	else 
		$TabString .= $ModuleTitleArray[$ModuleIndex]['Title'];
	$TabString.='--</option>';
	$TabString .= '<option value=\''.$CellID.'-'.$MainWindowID.'\'>-->'.$MainWindowTitle.'</option>';


		
	$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID = '$CellID' and IsMain=0 ";
	
	$where = " and ((Privacy='public') or (Privacy='')";
	
	if ($IsFriend)
		$where .= " or (Privacy ='friends') or (Privacy ='fans') ";
	else if ($IsFan)
		$where .= " or (Privacy ='fans') ";
	else if ($IsOwner) 
			$where .= " or (Privacy ='friends') or (Privacy ='fans') or (Privacy ='private') ";
	$where .=")";
			
	$query .= $where ." order by Position";
	$DB->query($query);
	
	 $PopMenuString .= build_popup_menus($MainWindowID,$CellID,$ModuleTemplate,$ModuleType, $MainWindowArray->ContentVariable);
	 
		$NumSubModules = $DB->numRows();
		
	//	print $query .'<br/>';
		//print '<br/>';
		while ($line = $DB->fetchNextObject()) {
				$ModuleTabIDArray[] = $line->EncryptID;
				//print 'SUB TITLE = ' .$line->Title .'<br/>';
				//print 'SUB MOD = ' .$line->EncryptID .'<br/>';
				$PopMenuString .= build_popup_menus($line->EncryptID,$CellID,$line->ModuleTemplate,$line->ModuleType,$MainWindowArray->ContentVariable);
				$TabString .= '<option value=\''.$CellID.'-'.$line->EncryptID.'\'>-->'.$line->Title.'</option>';
		}
		
		//$PopMenuString = '';
		//	$ModuleTabIDArray[] = $line->EncryptID;
			//$TabString .= '<td class="availtabinactive" id="'.$line->EncryptID.'_tab" onmouseover="rolloveractive(\''.$line->EncryptID.'_tab\',\''.$line->EncryptID.'_div\')" onmouseout="rolloverinactive(\''.$line->EncryptID.'_tab\',\''.$line->EncryptID.'_div\')" onclick="mod_tab(\''.$CellID.'-'.$line->EncryptID.'\');" align="left">'.$line->Title.'<div class="tab_title_space" style="height:4px;"></div></td>
//<td width="5"></td>';
	$TabString .= '</select></td></tr></table>';

	$ModuleString .= $TabString.'<div style="height:4px;"></div></td><td id="fatmodtopright" valign="top" align="left"><div style="height:2px; "></div><div id="'.$CellID.'_menu"></div></td>

</tr>
<tr>
	
	<td valign="top" colspan="3"  width="'.($ModWidth-2).'">
	
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" height="'.$ModHeight.'"  width="'.($ModWidth-2).'">
	<div style="height:'.$ModHeight.'px;overflow:auto;" align="center">';
	
	//$DivString .= $TabString;
	$ModCount = 0;
	foreach($ModuleTabIDArray as $module) {
	
	if ($ModCount > 0) {
		$Display = 'none';
		
		$ModuleTabList .= ','.$module;
	} else {
		$Display = 'block';
		$ModuleTabList = $module;
	}		
		$ModuleString .= '<div id="'.$module.'_div" style="display:'.$Display.';">';
		
		if ($TotalTabs == 0) 
			$ModuleString .= $IntroContent;
		else
			$ModuleString .= get_feed_items($module, $FeedID, $UserID);
			
	//	$ModuleString .= get_feed_items($module, $FeedID, $UserID);
		//$ModuleString .='<div id="'.$module.'_menu_wrapper" style="display:none;"><a href="#" onclick="mini_menu(\''.$module.'_menu\',\'\',\''.$CellID.'_menu\',\'wevolt\',\'\',this, event);return false;"><img src="http://www.wevolt.com/templates/modules/standard/action_star.png" hspace="3" vspace="3" border="0" width="15" class="navbuttons"></a></div>';
		$ModuleString .= '</div>';
		$ModCount++;
	}
	
	
	$ModuleString .= '<input id="'.$CellID.'_tabs" value="'.$ModuleTabList.'" type="hidden"></div>';
	
	$ModuleString .='
	<div class="spacer"></div>
	</td>
	<td id="modrightside"></td>

	</tr>
	<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
	</table>
	
	</td>
</tr>


</table>'.
$PopMenuString.'
<!-- END MODULE  -->';
	
	return $ModuleString;

}
/*
function build_cell($Title, $Template, $ModuleID, $FeedID, $UserID, $CellID,$SortVariable,$ContentVariable, $SearchVariable, $SearchTags, $Variable1, $Variable2, $Variable3, $Custom, $NumberVariable,$ThumbSize) {
		
	global $DB,$DB2,$ModuleTitleArray,$ModuleIndex,$TypeTarget, $TargetID;
	$TabString = '';
	
	//$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and ParentModule = '$ModuleID' order by Position"; 
	$query = "SELECT count(*) from feed_modules where FeedID='$FeedID' and CellID = '$CellID' order by Position"; 
	$TotalTabs = $DB->queryUniqueValue($query);
	
	//print $query .'<br/>';
	//print 'TotalTabs ' .$TotalTabs.'<br/>';
	//print '<br/>';
	
	$FeedModuleArray = array(array());	
	$query = "SELECT EncryptID, Title from feed_modules where FeedID='$FeedID' and CellID = '$CellID' and IsMain = 1";
	$MainWindowArray = $DB->queryUniqueObject($query);
	$MainWindowTitle = $MainWindowArray->Title;
	
	$MainWindowID = $MainWindowArray->EncryptID;
	$ModuleTabIDArray[] = $MainWindowID;
	$DivString = '<div id="'.$CellID.'">'; 
	
	
	$ModuleString = '
	
	<!-- COMMENT FORM MODULE  -->
<table width="'.$ModuleTitleArray[$ModuleIndex]['Width'].'" height="'
.$ModuleTitleArray[$ModuleIndex]['Height'].'" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="modtopleft"></td>

	<td id="modtop" width="'.($ModuleTitleArray[$ModuleIndex]['Width']-40).'" valign="bottom">';
	
	//$ModuleTabIDArray = array($ModuleID);
	
	if ($ModuleTitleArray[$ModuleIndex]['Tabs'] == 0) {
		$TabString .='<div class="mod_title">'.$ModuleTitleArray[$ModuleIndex]['Title'].'<div style="height:10px;"></div></div>';	
	
	} else {
		$TabString .= '<table border="0" cellpadding="0" cellspacing="0"><tbody><tr>';
	
		$TabString .= '<td><select name="txtModuleSelect" onChange="mod_tab(this.options[this.selectedIndex].value);" style="width:125px;">'; 
		
		$query = "SELECT * from feed_modules where FeedID='$FeedID' and CellID = '$CellID' and IsMain=0 order by Position"; 
		$DB->query($query);
	
		//print '<br/>';
	
		$NumSubModules = $DB->numRows();
	//	print 'Main Window title = ' . $MainWindowTitle.'<br/>';
	
			$TabString .= '<option value=\''.$CellID.'-'.$MainWindowID.'\'>'.$MainWindowTitle.'</option>';
		
		while ($line = $DB->fetchNextObject()) {
				$ModuleTabIDArray[] = $line->EncryptID;
				//print 'SUB TITLE = ' .$line->Title .'<br/>';
				//print 'SUB MOD = ' .$line->EncryptID .'<br/>';
				$TabString .= '<option value=\''.$CellID.'-'.$line->EncryptID.'\'>'.$line->Title.'</option>';
		}
	
		$TabString .= '</select></td><td class=\'nav_links_white\'>&nbsp;&nbsp;<a href="#" onclick="edit_module(\''.$CellID.'\');">edit</a></td></tr></table><div style="height:10px;"></div>';
	
	}
	

	$ModuleString .= $TabString.'<div style="height:4px;"></div></td><td id="modtopright" valign="top" align="right"><a href="#"><img src="http://www.wevolt.com/templates/modules/standard/action_star.png" hspace="3" vspace="3" border="0" width="15"></a></td>

</tr>
<tr>
	
	<td valign="top" colspan="3"  width="'.($ModuleTitleArray[$ModuleIndex]['Width']-2).'">
	
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" height="'.$ModuleTitleArray[$ModuleIndex]['Height'].'"  width="'.($ModuleTitleArray[$ModuleIndex]['Width']-2).'">
	<div style="height:'.$ModuleTitleArray[$ModuleIndex]['Height'].'px;overflow:auto;" align="center">';
	
	//$DivString .= $TabString;
	$ModCount = 0;
	//print_r($ModuleTabIDArray);
	foreach($ModuleTabIDArray as $module) {
	
		if ($ModCount > 0) {
			$Display = 'none';
			
			$ModuleTabList .= ','.$module;
		} else {
			$Display = 'block';
			$ModuleTabList = $module;
		}		
			$ModuleString .= '<div id="'.$module.'_div" style="display:'.$Display.';">';
		
		$ModuleString .= get_feed_items($module, $FeedID, $UserID);
		$ModuleString .= '</div>';
		$ModCount++;
	}
	
	
	$ModuleString .= '<input id="'.$CellID.'_tabs" value="'.$ModuleTabList.'" type="hidden"></div>';
	
	$ModuleString .='
	<div class="spacer"></div>
	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>

<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
</table>
<!-- END MODULE  -->';
	
	return $ModuleString;

}
*/
?>