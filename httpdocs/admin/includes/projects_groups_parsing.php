<? 
print $query . "<br/>";
	$GroupProjects = explode(",", $ProjectString);
	$NumProjects = sizeof($GroupProjects);
	print "MY PROJECT STRING = " . $ProjectString ."<br/>";
	$projects = new DB();
	if ($ProjectString == '0') {
		$NewGroupString = '';
			$query = "SELECT * from pf_projects";
			$projects->query($query);	
			print $query . "<br/>";
			while ($line = $projects->fetchNextObject()) { 
				$ProjectID = $line->ID;
				print "MY GROUP ID = " . $GroupID . "<br/>";
				print "MY Project ID = " . $ProjectID . "<br/>";
				$ProjectGroups = explode(",", $line->Groups);
				$NumGroups = sizeof($ProjectGroups);
				$group2counter = 0;
				while ($group2counter < $NumGroups) {
				print "MY ProjectGroups[group2counter] ID = " . $ProjectGroups[$group2counter] . "<br/>";
					if ($GroupID ==  $ProjectGroups[$group2counter]) {
						// Group Detected skip adding to string
						print "DON't ADD";
					} else {
						if (strlen($NewGroupString ) >= 1) {
							$NewGroupString .= ','.$ProjectGroups[$group2counter];
						} else {
							$NewGroupString = $ProjectGroups[$group2counter];
						}
					}
					$group2counter++;
				}
				$query = "UPDATE pf_projects set groups = '$NewGroupString' where id='$ProjectID'";
				$projects->query($query);
				print $query ;
			}
			
	} else if ($RemoveProjectString != '') {
			$RemoveProjectIDArray = explode(",", $RemoveProjectString);
			$NumOfRemove = sizeof($RemoveProjectIDArray);
			$ProjectCounter = 0;
			while ($ProjectCounter < $NumOfRemove) {
				$NewGroupString = '';
				$ProjectID = $RemoveProjectIDArray[$ProjectCounter];
				$query = "SELECT Groups from pf_projects where id='$ProjectID'";
				$CurrentProjectGroupsString = $projects->queryUniqueValue($query);	
				$CurrentProjectGroups = explode(",", $CurrentProjectGroupsString);
				$NumberOfCurrentGroups = sizeof($CurrentProjectGroups);
				$group2counter = 0;
				while ($group2counter < $NumberOfCurrentGroups) {
					if ($GroupID ==  $CurrentProjectGroups[$group2counter]) {
							// Group Detected skip adding to string
							print "DON't ADD";
					} else {
						if (strlen($NewGroupString ) >= 1) {
							$NewGroupString .= ','.$CurrentProjectGroups[$group2counter];
						} else {
							$NewGroupString = $CurrentProjectGroups[$group2counter];
						}
					}
					$group2counter++;
				}
				$query = "UPDATE pf_projects set groups = '$NewGroupString' where id='$ProjectID'";
				$projects->query($query);
				print $query ;
				$ProjectCounter++;
			}
	} else if ($NumProjects > 0) {
		print "MY NUMBER OF PROJECTS = " . $NumProjects. "<br/>";
		$counter = 0;
		while ($counter < $NumProjects) {
			$ProjectID = $GroupProjects[$counter];
			$query = "SELECT groups from pf_projects where id='$ProjectID'";
			print $query . "<br/>";
			$GroupString = $groups->queryUniqueValue($query);
			print "MY GROUP STRING = ". $GroupString  . "<br/>";	
			$CurrentGroups = explode(",", $GroupString);
			$NumCurrentGroups = sizeof($CurrentGroups);
			print "MY NumCurrentGroups = ". $NumCurrentGroups  . "<br/>";	
			if ($NumCurrentGroups > 0) {
				$groupcounter = 0;
				while ($groupcounter < $NumCurrentGroups) {
					$CurrentGroupID = $CurrentGroups[$groupcounter];
					print "CurrentGroupID " . $CurrentGroupID  . "<br/>";	
					print "GroupID " . $GroupID . "<br/>";	
					if ($GroupID == $CurrentGroupID) {
						$GroupAlreadyActive = 1;
						$groupcounter = $NumCurrentGroups;
					} else {
						$GroupAlreadyActive = 0;
					}
					print "GroupAlreadyActive " . $GroupAlreadyActive  . "<br/>";
					$groupcounter++;
				}
				if ($GroupAlreadyActive == 0) {
							$NewGroupString .= $GroupString.','.$GroupID;
				} else {
				$NewGroupString = $GroupString;
				}
			} else {
			$NewGroupString = $GroupID;
			}
			$counter++;
			$query = "UPDATE pf_projects set groups = '$NewGroupString' where id='$ProjectID'";
			$groups->query($query);
			print $query . "<br/>";
		} 
	}
	?>