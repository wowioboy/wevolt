<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class module  {
	
		var $ProjectID;
	
		public function getModules($Section,$Placement,$ProjectID) {
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				$ModuleOrder = array();
				$this->ProjectID = $ProjectID;
				if ($Section == 'Home') 
					$query = "SELECT * from pf_modules where ComicID='".$this->ProjectID."' and Homepage=1 and IsPublished=1 and Placement='$Placement' order by Position";
				else
					$query = "SELECT * from pf_modules where ComicID='".$this->ProjectID."' and IsPublished=1 and Homepage=0 and Placement='$Placement' order by Position";
				$db->query($query);
				$TotalMods = $db->numRows();
				
				if (( $TotalMods == 0) && ($Placement == 'left')) {
					$ModuleOrder[] = 'LatestPageMod';
					$ModuleOrder[] = 'authcomm';
				} else if (( $TotalMods == 0) && ($Placement == 'right')) {
					$ModuleOrder[] = 'comicsynopsis';
					$ModuleOrder[] = 'comiccredits';
				
				}
				while ($line = $db->fetchNextObject()) {
						if (($line->ModuleCode != 'menuone')&&($line->ModuleCode != 'menutwo')) 
							$ModuleOrder[] = $line->ModuleCode;
					
						if ($line->ModuleCode == 'twitter') {
							$Twittername = $line->CustomVar1;
							$TweetCount = $line->CustomVar2;
							$FollowLink = $line->CustomVar3;
							if ($Twittername == '')	
								$GetTwitter = 1;
						
						}
						if ($line->ModuleCode == 'custommod')
							$CustomModuleCode = stripslashes($line->HTMLCode);
						
				}
				$db->close();
				return $ModuleOrder;

		}
		
		public function getHomeModules() {
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				$HomeModuleArray = array();	
				$query = "SELECT * from pf_modules where ComicID='".$this->ProjectID."' and IsPublished=1 and Homepage=1";
				$db->query($query);
				while ($line = $db->fetchNextObject()) {
					$HomeModuleArray[] = $line->ModuleCode;
				}
				$db->close();	
				return $HomeModuleArray;
		}
	
	}




?>