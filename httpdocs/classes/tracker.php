<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class tracker {
				
		public function getBrowser($userAgent) {
  			// Create list of browsers with browser name as array key and user agent as value. 
			$browsers = array(
								'Opera' => 'Opera',
								'Mozilla Firefox'=> '(Firebird)|(Firefox)', // Use regular expressions as value to identify browser
								'Galeon' => 'Galeon',
								'Mozilla'=>'Gecko',
								'MyIE'=>'MyIE',
								'Lynx' => 'Lynx',
								'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
								'Konqueror'=>'Konqueror',
								'SearchBot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)',
								'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
								'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
								'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
								'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
							);

			foreach($browsers as $browser=>$pattern) { // Loop through $browsers array
   					 // Use regular expressions to check browser type
					if(eregi($pattern, $userAgent)) { // Check if a value in $browsers array matches current user agent.
							return $browser; // Browser was matched so return $browsers key
					}
			}
			return 'Unknown'; // Cannot find browser so return Unknown
		}
		 
		
		public function insertPageView($ProjectID,$Pagetracking,$Remote,$UserID,$Referal,$CurrentLink,$IsPro,$IsCMS=false,$IsUser=false) {
			 //Analytics
 				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 				$browserType = $this->getBrowser($_SERVER['HTTP_USER_AGENT']);
			
					
					$BaseRef = explode('/',$Referal);
					$Referal = $BaseRef[0];
					
 				if ($IsCMS == false) {
				
				if ($browserType != 'SearchBot') {
					include(CLASSES."/geoipcity.inc");
					include(CLASSES."/geoipregionvars.php");
					$today = date("Ymd"); 
					$AnalyticDate = date("Y-m-d 00:00:00"); 
					$CurrentTime = date("h:i:s");
					$gi = geoip_open(CLASSES."/GeoLiteCity.dat",GEOIP_STANDARD);
					$record = geoip_record_by_addr($gi,$Remote);
					$CountryName = mysql_real_escape_string($record->country_name);
					$RegionName = mysql_real_escape_string($GEOIP_REGION_NAME[$record->country_code][$record->region]);
					$CityName =  mysql_real_escape_string($record->city);
					$Latitude = $record->latitude;
					$Longitude = $record->longitude;
					geoip_close($gi);
						 if ($IsPro == '')
						$IsPro = 0;
				
					if ($IsUser) {
						$query = "SELECT Hits FROM wevolt_user_analytics WHERE UserID='$ProjectID'";
						$Hits = $db->queryUniqueValue($query);
						if ($Hits == '') {
							$query = "INSERT into  wevolt_user_analytics (UserID, Hits) values ('$ProjectID', 1)";
							$db->execute($query);
							$Hits = 0;
							$Output .= $query.'<br/>';
						
						}
						
						$Output .= $query.'<br/>';	
						$Hits++;
						$query = "SELECT id, hits from wevolt_analytics where UserID='$ProjectID' and date ='$today'";
						$analytic = $db->queryUniqueObject($query);
						$Output .= $query.'<br/>';	
					
						if ($analytic->id != '') {
							$Todayhits = $analytic->hits;
							$Todayhits++;
							$query = "UPDATE wevolt_analytics set hits='$Todayhits' where UserID='$ProjectID' and date='$today'";
							$db->execute($query);
							$Output .= $query.'<br/>';	
						//print $query;
						} else {
							$query = "INSERT into wevolt_analytics (date, hits, UserID, page, remote, AnalyticDate) values ('$today', 1, '$ProjectID','$Page','$Remote','$AnalyticDate')";
							$db->execute($query);
							$Output .= $query.'<br/>';		
						}
					
						$query = "UPDATE wevolt_user_analytics set Hits='$Hits' where UserID='$ProjectID'";
						$db->execute($query);
											
					
						$query = "SELECT ID FROM wevolt_analytics WHERE UserID='$ProjectID' AND date='$today'";
						$AnalyticID = $db->queryUniqueValue($query);
						$Output .= $query.'<br/>';	
							$query = "INSERT into wevolt_user_analytics_breakdown (analyticid, OwnerID, date, page, remote, userid, CountryName, RegionName, CityName, Latitude, Longitude,Referal, AnalyticDate, Link, Browser, Time,ProView) values ('$AnalyticID','$ProjectID','$today','$Page','$Remote','$UserID','$CountryName', '$RegionName', '$CityName', '$Latitude', '$Longitude','$Referal', '$AnalyticDate','$CurrentLink','$browserType','$CurrentTime',$IsPro)";
						$db->execute($query);	
					
					} else {
						$query = "SELECT hits FROM projects WHERE ProjectID='$ProjectID'";
						$TotalHits = $db->queryUniqueValue($query);
						$Output .= $query.'<br/>';	
						$TotalHits++;
						$query = "UPDATE projects set hits='$TotalHits' where ProjectID='$ProjectID'";
						$db->execute($query);
						
						$query = "SELECT count(*) FROM `analytics_breakdown` where ProjectID='$ProjectID' and AnalyticDate='$today'";
						$Todayhits = $db->queryUniqueValue($query);
						$Output .= $query.'<br/>';
							
						$query = "SELECT id, hits from analytics where ProjectID='$ProjectID' and date ='$today'";
						$analytic = $db->queryUniqueObject($query);
						$Output .= $query.'<br/>';	
					
						if ($analytic->id != '') {
							//$Todayhits = $analytic->hits;
							$Todayhits++;
							$query = "UPDATE analytics set hits='$Todayhits' where ProjectID='$ProjectID' and date='$today'";
							$db->execute($query);
							$Output .= $query.'<br/>';	
						//print $query;
						} else {
							$query = "INSERT into analytics (date, hits, ProjectID, page, remote, AnalyticDate) values ('$today', 1, '$ProjectID','$Page','$Remote','$AnalyticDate')";
							$db->execute($query);
							$Output .= $query.'<br/>';		
						}
					
						//$query = "UPDATE comics set hits='$Hits' where comiccrypt='$ProjectID'";
						//$db->execute($query);
						//$Output .= $query.'<br/>';	
						
						$Output .= $query.'<br/>';	
					
						$query = "SELECT ID FROM analytics WHERE ProjectID='$ProjectID' AND date='$today'";
						$AnalyticID = $db->queryUniqueValue($query);
						$Output .= $query.'<br/>';	
							$query = "INSERT into analytics_breakdown (analyticid, ProjectID, date, page, remote, userid, CountryName, RegionName, CityName, Latitude, Longitude,Referal, AnalyticDate, Link, Browser, Time,ProView) values ('$AnalyticID','$ProjectID','$today','$Page','$Remote','$UserID','$CountryName', '$RegionName', '$CityName', '$Latitude', '$Longitude','$Referal', '$AnalyticDate','$CurrentLink','$browserType','$CurrentTime',$IsPro)";
					$db->execute($query);	
					$Output .= $query.'<br/>';	
					}
				
				
				
					
					}
					$db->close();
					
					return $Output;
				}
			} 
			
			function insertUserReadLog($ProjectID,$UserID) {
					$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
					 $browserType = $this->getBrowser($_SERVER['HTTP_USER_AGENT']);
					 if ($browserType != 'SearchBot') {
							$NOW = date('Y-m-d h:i:s');
							$query = "SELECT * from projects_read_log where ProjectID='$ProjectID' and UserID='$UserID'";
							$LogArray = $db->queryUniqueObject($query);
							$Output .= $query.'<br/>';	
							if ($LogArray->ID == '') {
								 $query = "INSERT into projects_read_log (ProjectID, UserID, FirstVisit, LastVisit, LastPage) values ('$ProjectID','$UserID','$NOW','$NOW','".$_SESSION['sharelink']."')";
								 $db->execute($query);
								 $Output .= $query.'<br/>';	
							} else {
								$TotalHits = $LogArray->TotalViews;
								$TotalHits++;
								$query = "UPDATE projects_read_log set LastVisit ='$NOW', TotalViews='$TotalHits', LastPage='".$_SESSION['sharelink']."' where ProjectID='$ProjectID' and UserID='$UserID'";
								$db->execute($query);
								$Output .= $query.'<br/>';	
							}
							
					}
					$db->close();
					return $Output;
			}
			
			function addPageviewXP($ProjectID,$UserID, $XP='') {
					$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
					 $browserType = $this->getBrowser($_SERVER['HTTP_USER_AGENT']);
					 if ($browserType != 'SearchBot') {
							$NOW = date('Y-m-d h:i:s');
							$Today = date('Y-m-d').' 00:00:00';
							$query = "SELECT * from projects_page_xp_tracker where ProjectID='$ProjectID' and UserID='$UserID' and PageLink='".$_SESSION['sharelink']."'";
							$LogArray = $db->queryUniqueObject($query);
							$Output .= $query.'<br/>';	
							if ($LogArray->ID == '') {
								 $query = "INSERT into projects_page_xp_tracker (ProjectID, UserID,  LastVisit, PageLink) values ('$ProjectID','$UserID','$NOW','".$_SESSION['sharelink']."')";
								 $db->execute($query);
								 $Output .= $query.'<br/>';	
							} else {
								if  ($LogArray->LastVisit<$Today) {
										$TotalHits = $LogArray->TotalHits;
										$TotalHits++;
										$query = "UPDATE projects_page_xp_tracker set LastVisit ='$NOW', TotalHits='$TotalHits' where ID='".$LogArray->ID."'"; 
										$db->execute($query);
										include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
										$XPMaker = new Users();
										$Output .= $XPMaker->addxp($db, $_SESSION['userid'], $XP);
										$Output .= $query.'<br/>';	
								}
								
							}
							
					}
					$db->close();
					return $Output;
			}


	}




?>