<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class user {		
			
			function __construct($UserID = null) {
					if ($UserID == ''){
						if ($_SESSION['newflashpages'] != '') { 
							$_SESSION['flashpages'] = $_SESSION['newflashpages'];
							$_SESSION['newflashpages'] = '';
						} else {	
							$_SESSION['flashpages'] = 1;
						}
	
						$_SESSION['IsPro'] = 0;
						$_SESSION['noads'] = 0;
						$_SESSION['contentwidth'] = 728;
						$_SESSION['IsSuperFan'] = 0;
						$_SESSION['ProInvite'] = 0;
						$_SESSION['sidebar'] = 'open';
						if ($_SESSION['currentreader'] != '')
							$_SESSION['readerstyle'] = $_SESSION['currentreader'];
						else
							$_SESSION['readerstyle'] = $DefaultReader;
						$_SESSION['overage'] = 'N';
					} else {
						$this->getUserInfo($UserID);
						
					}
			}

		
			public function getUserInfo($UserID) {
					$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
					$query = "select us.*, u.overage, u.email, u.avatar, u.username,
							  (select count(*) from pf_subscriptions as s where s.UserID=us.UserID and s.Status='active' and s.SubscriptionType='hosted' and ((s.Temp=0) or ((s.Temp=1) and (s.Expires>=NOW())))) as IsPro,
							  (select count(*) from pf_subscriptions as s where s.UserID=us.UserID and s.Status='active' and s.SubscriptionType='fan' and ((s.Temp=0) or ((s.Temp=1) and (s.Expires>=NOW())))) as IsSuperFan  
         					  from users_settings as us
							  join users as u on u.encryptid = us.UserID
							  where us.UserID ='$UserID'"; 
					
					$UserSettingsArray = $db->queryUniqueObject($query);
					if ($UserSettingsArray->email == '') {
						unset($UserSettingsArray);
						$query ="INSERT into users_settings (UserID) values ('".$_SESSION['userid']."')";
						$db->execute($query);
							$query = "select us.*, u.overage, u.email, u.avatar, u.username,
							  (select count(*) from pf_subscriptions as s where s.UserID=us.UserID and s.Status='active' and s.SubscriptionType='hosted' and ((s.Temp=0) or ((s.Temp=1) and (s.Expires>=NOW())))) as IsPro,
							  (select count(*) from pf_subscriptions as s where s.UserID=us.UserID and s.Status='active' and s.SubscriptionType='fan' and ((s.Temp=0) or ((s.Temp=1) and (s.Expires>=NOW())))) as IsSuperFan  
         					  from users_settings as us
							  join users as u on u.encryptid = us.UserID
							  where us.UserID ='$UserID'"; 
				
					$UserSettingsArray = $db->queryUniqueObject($query);
					}
				
					$db->close();
					$NOW = date('Y-m-d h:i:s');
				 	$_SESSION['email'] = $UserSettingsArray->email;
			 		$_SESSION['lastlogin'] = $NOW;
			 		$_SESSION['encrypted_email'] =  md5($UserSettingsArray->email);
					$_SESSION['username'] = $UserSettingsArray->username;
					$_SESSION['avatar'] = $UserSettingsArray->avatar; 
					$_SESSION['readerstyle'] = $UserSettingsArray->ReaderStyle;
					$_SESSION['tooltips'] = $UserSettingsArray->ToolTips;
					
					
					if ($_SESSION['newflashpages'] != '') { 
						$_SESSION['flashpages'] = $_SESSION['newflashpages'];
						$_SESSION['newflashpages'] = '';
					} else {	
						$_SESSION['flashpages'] = $UserSettingsArray->FlashPages;
					}

					if (($UserSettingsArray->IsPro > 0) || ($UserSettingsArray->IsSuperFan > 0)) {
						$_SESSION['IsPro'] = 1;
						$_SESSION['noads'] = 1;
					}else{
						$_SESSION['IsPro'] = 0;
						$_SESSION['noads'] = 0;
					}
					if ($UserSettingsArray->IsSuperFan > 0)
						$_SESSION['IsSuperFan'] = 1;
					else
						$_SESSION['IsSuperFan'] = 0;
					
					if ($_SESSION['IsPro'] == 1)
						$_SESSION['contentwidth'] = 1024;
					else
						$_SESSION['contentwidth'] = 728;

					if ($_SESSION['readerstyle'] == '') {
						$_SESSION['readerstyle'] = $DefaultReader;
						$_SESSION['flashpages'] = '1';
					}	
				
					$_SESSION['overage'] = $UserSettingsArray->overage;	
					if ($_SESSION['currentreader'] != '')
						$_SESSION['readerstyle'] = $_SESSION['currentreader'];
						
					if (($_SESSION['IsPro'] == 1) || ($_SESSION['IsSuperFan'] == 1))	
						$_SESSION['sidebar'] = $UserSettingsArray->sidebar;
					else 
						$_SESSION['sidebar'] == 'open';
					
					if ($_SESSION['sidebartoggle'] != '')
						$_SESSION['sidebar'] = $_SESSION['sidebartoggle'];
					
						
						 				
					return $UserSettingsArray;

			}
			public function getInviteStatus($UserID,$ProjectID) {
					$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
					$CurrentDate = date('Y-m-d').' 00:00:00';
					$query = "select count(*) from fan_invitations as f where f.UserID='$UserID' and f.ProjectID = '$ProjectID' and ((f.ExpirationDate>'$CurrentDate' and f.Status='active') or (f.IsLifetime=1 and f.Status='active'))";
    				$ProInvite = $db->queryUniqueValue($query);
					if (($ProInvite > 0) && ($ProInvite != '')) {
						$_SESSION['ProInvite'] = 1;
						$_SESSION['noads'] = 1;
					}else{
						$_SESSION['ProInvite'] = 0;
					}
				
					$db->close();
			}
			
			public function getString($SiteVersion=1) {
				
				if ($SiteVersion == 1) {
					echo '<div id="string" style="visibility:hidden;min-width:120px;position:absolute;z-index:99;">';
					echo '<div style="height:10px;" onmouseover="hide_layer(\'popupmenu\',event);"></div>';
					echo '<table cellpadding="0" cellspacing="0" border="0">';
					echo '<tr>';
					echo '<td  onmouseover="hide_layer(\'popupmenu\',event);"></td>';
					echo '<td>';
					echo '<div style="background-image:url(http://www.wevolt.com/images/string_header.jpg); background-repeat:no-repeat; height:61px;width:109px;" align="center">';
					echo '<div style="height:25px;"></div>';
					echo '<a href="#" id="mycarousel-prev"><img src="http://www.wevolt.com/images/string_back.png" border="0"/></a></div>';
					echo '<div id="mycarousel" class="jcarousel-skin-tango">';
					echo '<ul>';
					
						$this->build_string($SiteVersion);
					echo '</ul>';
					echo '</div>';
					echo '<div style="background-image:url(http://www.wevolt.com/images/string_footer.jpg); background-repeat:no-repeat; height:48px;width:109px;" align="center">';
					echo '<div style="height:10px;"></div>';
					echo '<a href="#" id="mycarousel-next"><img src="http://www.wevolt.com/images/string_next.png" border="0"/></a>';
					echo '</div>';
					echo '</td>';
					echo '<td  onmouseover="hide_layer(\'popupmenu\',event);"></td><td width="500" onmouseover="toggle_string_button(\'off\');" id="hidestringpanel">&nbsp;</td>';
					echo '</tr>';
					echo '</table>';
					echo '<div style="height:10px;width:100px;" onmouseover="hide_layer(\'popupmenu\',event);"></div>';
					echo '</div>';
				} else {
					
					echo '<table id="string" style="visibility:hidden;min-width:120px;position:abosolute;z-index:99;" cellspacing="0" cellpadding="0">';
						echo '<tr>';
							echo '<td>';
							echo '<a href="#" id="mycarousel-prev"><img src="http://www.wevolt.com/images/string_arrow_left.png" border="0"></a>';
							echo '</td>';
							echo '<td background="http://www.wevolt.com/images/string_bg_2.png" style="background-repeat:repeat-x; height:40px;" valign="top">';
							echo '<div id="mycarousel" class="jcarousel-skin-tango">';
								echo '<ul>';			
										$this->build_string($SiteVersion);
								echo '</ul>';
							echo '</div>';
							echo '</td>';
							echo '<td>';
							echo '<a href="#" id="mycarousel-next"><img src="http://www.wevolt.com/images/string_arrow_right.png" border="0"></a>';
							echo '</td>';
						echo '</tr>';
					echo '</table>';
				}
		
		}
		
		
		public function build_string($SiteVersion=1) {
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				//$query = "SELECT ID from string_entries as se where se.UserID='".$_SESSION['userid']."' limit 50";
				//$db->query($query);
				$_SESSION['stringstart'] = 1;
				$StringEntries = '';
				$UserID = $_SESSION['userid'];
				$query = "SELECT distinct se.LinkID,se.IsMarked,se.ID as EntryID, se.UserID, se.LastVisited, sl.* 
				              from string_entries as se
							  join string_links as sl on se.LinkID=sl.ID
							  where se.UserID='$UserID' and sl.Title != '' and sl.hidden != '1' order by se.LastVisited DESC limit 50";
				$db->query($query);
			
				while ($line = $db->FetchNextObject()) {
						$TitleArray = explode('|',$line->Title);
						$StringTitle =  substr(trim($TitleArray[0]),0,11);
						$SubTitleArray = explode('-',trim($TitleArray[1]));
						
						$SubTitle = trim($SubTitleArray[0]);
						$SubSubTitle =  trim($SubTitleArray[1]);
						if ($SubTitle != 'Home') {
							$StringTitle = trim(substr($SubTitle,0,11));
							$SubTitle =  trim($SubTitleArray[1]);
							$SubSubTitle =  trim($SubTitleArray[2]);
						
						}
						
						if ($SiteVersion == 1) {
							if ($line->IsMarked != 1){
							$Image = 'string_unmarked.png';
							$Class = '';
							$Status = 'unmarked';
							}else{
								$Image = 'string_marked.png';
								$Class = '';
								$Status = 'marked';
							
							}
						
						
							echo '<li>';
							echo '<div class="'.$Status.'" id=\'string_'.$line->EntryID.'\' onclick="mini_menu(\''.$line->Title.'\',\''.$line->Url.'\',\''.$line->EntryID.'\',\'string\',\''.$Status.'\',this, event);return false;" tooltip="'.$line->Title.'" tooltip_position="bottom">';
							echo '<div style=\'height:2px;\'></div>';
							echo '<div id=\'string_'.$Class.'title\'>'.$StringTitle.'&nbsp;&nbsp;&nbsp;</div>';
						//	echo '<br/>';
							//echo '<span id=\'string_'.$Class.'subtitle\'>'.substr($SubTitle,0,15).'&nbsp;&nbsp;&nbsp;&nbsp;</span>';
							echo "<div id=\"string_".$Class."subtitle\">".$SubSubTitle."&nbsp;&nbsp;&nbsp;&nbsp;</div>". 
							
								 "<div style=\"font-size: 8px; position: relative; left: -7px;\" class=\"messageinfo_warning\">xp: {$line->xp}</div>";
							echo '</div>';
							echo '</li>';
						} else {
							if ($line->IsMarked != 1){							
								$Class = 'unmarked_2';
								$Status = 'unmarked';
							}else{
							 
								$Class = 'marked_2';
								$Status = 'marked';
						
							}
							echo '<li>';
							
							echo '<div class="'.$Class.'" id=\'string_'.$line->EntryID.'\' onclick="mini_menu(\''.$line->Title.'\',\''.$line->Url.'\',\''.$line->EntryID.'\',\'string\',\''.$Status.'\',this, event);return false;" tooltip="'.$line->Title.'" tooltip_position="bottom" style="cursor:pointer;">';
							
							echo '<div id=\'string_2title\'>'.$StringTitle.'</div>';
							echo "<div id=\"string_2subtitle\">".$SubTitle."</div>". 
							
								 "<div style=\"font-size:8px;color:#fdd700;\">xp: {$line->xp}</div>";
							echo '</div>';
							echo '</li>';	
						}
				}
				$db->close();
		}
		
		
		public function add_string_entry($Title,$Track, $Page,$IsProject=false,$IsJob=false) 
		{
			$users = new Users;
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				if ($IsJob == false)
					$PageLink = array_shift(explode("?", $Page));
				else
					$PageLink = $Page;
				$UserID = $_SESSION['userid'];
				$query = "SELECT ID from string_links where Url='$PageLink' and Title='".mysql_real_escape_string($Title)."'";
				$LinkID = $db->queryUniqueValue($query);
			//if ($_SESSION['username'] == 'matteblack')
					//print $query.'<br/>';
				if ($UserID != ''){
					$CurrentDate = date('Y-m-d H:i:s');
					$Title = mysql_real_escape_string($Title);
					if ($LinkID == '') {
						$query = "INSERT into string_links (Title, Url, CreatedDate) values ('$Title','$PageLink','$CurrentDate')";
						$db->execute($query);
						$query = "SELECT ID from string_links where Url='$PageLink'";
						$LinkID = $db->queryUniqueValue($query);
					}	
					$query = "SELECT * from string_entries where LinkID='$LinkID' and UserID='$UserID'";
					$EntryArray =  $db->queryUniqueObject($query);
					//if ($_SESSION['username'] == 'matteblack')
					//print $query.'<br/>';
					$EntryID = $EntryArray->ID;
					$MarkStatus = $EntryArray->IsMarked;
					if ($EntryID == '') {
						if ($LinkID) {
							$query = "select xp from string_links where ID = '$LinkID'";
							$xp = $db->queryUniqueValue($query);
						} else {
							$query = "select xp from string_links where Url='$PageLink'";
							$xp = $db->queryUniqueValue($query);
						}
						if (!$xp) {
							$xp = 10;
						}
						$users->addxp($db, $UserID, $xp);
						$query = "INSERT into string_entries (UserID, LinkID, FirstVisited,LastVisited) values ('$UserID','$LinkID','$CurrentDate','$CurrentDate')";
						$db->execute($query);
					} else {
						$query = "UPDATE string_entries set LastVisited='$CurrentDate' where UserID='$UserID' and LinkID='$LinkID'";
						$db->execute($query);
					}
					//if ($_SESSION['username'] == 'matteblack')
					//	print $query.'<br/>';
					$_SESSION['currentStringID'] = $EntryID;
					$_SESSION['CurrentMarkStatus'] = $MarkStatus;
				}
				$db->close();
		}
			
			public function getDrawers () {
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				
				
				$DCount = 0;
				
				$AvailDrawers = 0;
				echo '<div id="drawers_full" style="display:none; position:absolute; z-index:99;">';
				echo '<div style="height:10px;" ></div>';
				echo '<div class="yui-skin-w3volt_drawers">';
           		echo '<div id="doc" class="yui-t1">';
                echo '<div class="yui-b">';
				  
				while ($DCount <5) {
				$DCount++;
					$query ="SELECT count(*) from drawers where UserID='".$_SESSION['userid']."' and DrawerID='$DCount' and ParentID='0'";
					$numItems = $db->queryUniqueValue($query);
					
					//if ($numItems > 0)
						$AvailDrawers = $DCount;
					$query ="SELECT * from drawers where UserID='".$_SESSION['userid']."' and DrawerID='$DCount'";
					$DrawerArray = $db->queryUniqueObject($query);
					//if ($DrawerArray->DrawerID == '') 
						//echo '<div id="drawerdiv_'.$DCount.'" style="display:none;"><div class="yuimenuitem" align="center"><a href="#" onclick="edit_drawer(\''.$DCount.'\'); return false;"><img src="http://www.wevolt.com/images/edit_drawer.png" border="0"></a></div></div>';
					//else
				
						echo '<div id="drawer_'.$DCount.'" style="display:none;"><div class="yuimenuitem" align="center"><a href="#" onclick="edit_drawer(\''.$DCount.'\'); return false;"><img src="http://www.wevolt.com/images/edit_drawer.png" border="0"></a></div>'.$this->build_drawers($DCount,$numItems).'</div><input type="hidden" name="drawer_item_cnt_'.$DCount.'" value="'.$numItems.'" id="drawer_item_cnt_'.$DCount.'">';
				
					
				}	
				
				$db->close();
				echo '</div>';
           		echo '</div>';
				echo '</div>';
				echo '<div style="height:10px;" onmouseover="hide_drawer();">';
				echo '</div>';
				echo '</div>';
				return $AvailDrawers;
	
		}
	
		public function format_drawer_title($string) {
				$string = urldecode($string);
				$string = str_replace("%20"," ",$string);
				$string = str_replace("%27","'",$string);
				$string = ucwords(substr(strtolower($string),0,28));
				return $string;
		}
		
		public function build_drawers($DrawerID,$numItems) {
				$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				
				
				$DrawerCount = 0;
				$UserID = $_SESSION['userid'];
				$String = '<div id="drawer_container'.$DrawerID.'" class="yuimenu">';
				if ($numItems > 0)
                           $String .= '<div class="bd">
                                          <ul class="first-of-type">';
	
				$query ="SELECT * from drawers where UserID='$UserID' and ParentID='0' and DrawerID='$DrawerID' order by  Position";
				$DB->query($query);

				while ($line = $DB->FetchNextObject()) {

			  		$Count++;
					if ($line->DrawerType == 'label') {
							$ParentID = $line->ID;
					
							$String .= '<li class="yuimenuitem first-of-type"><a class="yuimenuitemlabel" href="#drawer_'.$DrawerID.'-'.$DrawerCount.'">'.$this->format_drawer_title($line->Title).'</a>';
							$String .= '<div id="#drawer_'.$DrawerID.'-'.$DrawerCount.'" class="yuimenu">
                                        <div class="bd">
                                        <ul>';
										$DrawerCount++;
							$DB2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
							$query ="SELECT * from drawers where UserID='$UserID' and ParentID='$ParentID' order by Position";
							$DB2->query($query);
					
							while ($line2 = $DB2->FetchNextObject()) {
									if ($line2->DrawerType == 'label') {
								  		 $SubParentID = $line2->ID;
										 $DB3 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								    	 $query = "SELECT * from drawers where UserID='$UserID' and ParentID='$SubParentID' order by Position"; 				
										 $DB3->query($query);
									
								   		 $String .= '<li><a class="yuimenuitemlabel" href="#drawer_'.$DrawerID.'-'.$DrawerCount.'">'.$this->format_drawer_title($line2->Title).'</a>';
								  	     $String .= '<div id="#drawer_'.$DrawerID.'-'.$DrawerCount.'" class="yuimenu">
                                            		 <div class="bd">
                                                	 <ul class="first-of-type">';	
								  		$DrawerCount++;		
								  		 while ($line3 = $DB3->FetchNextObject()) {
												$String .= '<li class="yuimenuitem"><a class="yuimenuitemlabel" href="'.$line3->Link.'">'.$this->format_drawer_title($line3->Title).'</a></li>';
								  		 }
										 $DB3->close();
								    	 $String .= '</ul>';
										 $String .= '</div>';
										 $String .= '</div>';	
										 $String .= '</li>';	
								   
							 		} else {
										
							  			$String .= '<li class="yuimenuitem"><a class="yuimenuitemlabel" href="'.$line2->Link.'">'.$this->format_drawer_title($line2->Title).'</a></li>';
							  
									}
							}
							$DB2->close();
						    $String .= '</ul>
                                         </div>
                                        </div>      
                                       </li>';
			   
			  		} else {
			   	
						$String .= '<li class="yuimenuitem"><a class="yuimenuitemlabel" href="'.$line->Link.'">'.$this->format_drawer_title($line->Title).'</a></li>';
			   
			   		}
				}
		      	if ($numItems > 0)
					$String .= '</ul></div>';
				            
                $String .= '</div>';
						
				$DB->close();
				return $String;
		}
		
		
	}

?>