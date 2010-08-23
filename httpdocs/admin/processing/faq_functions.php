<? if (($_GET['a'] == 'faq') && ($_POST['btnsubmit'] == 'CREATE')) {
	$db = new DB();
	$Inserted = 0;
	$Question = mysql_escape_string($_POST['txtQuestion']);
	$Answer = mysql_escape_string($_POST['txtAnswer']);
	$query = 'SELECT Position from faq WHERE Position=(SELECT MAX(Position) FROM faq)';
	$NewPosition = $db->queryUniqueValue($query);
	$NewPosition++;
	$query = "INSERT into faq (Question, Answer, Position) values ('$Question','$Answer','$NewPosition')";
	$db->query($query);
	$db->close();
}

if (($_GET['a'] == 'faq') && ($_POST['btnsubmit'] == 'YES')) {
	$db = new DB();
	$query = "DELETE from faq where id='$ItemID'";
	$db->query($query);
}


if (($_GET['a'] == 'faq') && ($_POST['btnsubmit'] == 'MOVE UP')) {
	$db = new DB();
	$CurrentOrder = array();
	$i=0;
	$query = "SELECT * from faq order by position";
	$db->query($query);
	//print $query.'</br></br>';
	while ($line = $db->fetchNextObject()) { 
		$CurrentOrder[] = $line->ID;
		if ($line->ID == $ItemID) {
			$ArrayPosition = $i;
		}
		$i++;
	}
	$TotalLinks = $db->numRows();
	$query = "SELECT Position from faq where ID='$ItemID'";
	$CurrentPosition = $db->queryUniqueValue($query);
	//print $query.'</br></br>';
	if ($CurrentPosition != 1) {
		$NewPosition = $CurrentPosition--;
		$NewOrder = $CurrentOrder[$ArrayPosition];
		$CurrentOrder[$ArrayPosition] = $CurrentOrder[$ArrayPosition-1];
		$CurrentOrder[$ArrayPosition-1] = $NewOrder;
		   for ( $counter =0; $counter < $TotalLinks; $counter++) {
		    $ItemID = $CurrentOrder[$counter];
			$UpdatePosition = $counter + 1;
		   	$query = "UPDATE faq set Position='$UpdatePosition' where ID ='$ItemID'"; 
			$db->query($query);
			//print $query.'</br></br>';
			}
	}
	
}



if (($_GET['a'] == 'menu') && ($_POST['btnsubmit'] == 'MOVE DOWN')) {
	$db = new DB();
	$CurrentOrder = array();
	$i=0;
	$query = "SELECT * from faq order by position";
	$db->query($query);
	//print $query.'</br></br>';
	while ($line = $db->fetchNextObject()) { 
		$CurrentOrder[] = $line->ID;
		if ($line->ID == $ItemID) {
			$ArrayPosition = $i;
		}
		$i++;
	}
	$TotalLinks = $db->numRows();
	
	$query = "SELECT Position from faq where id='$ItemID'";
	$CurrentPosition = $db->queryUniqueValue($query);
	//print $query.'</br></br>';
	if ($CurrentPosition != $TotalLinks) {
		$NewPosition = $CurrentPosition--;
		$NewOrder = $CurrentOrder[$ArrayPosition];
		$CurrentOrder[$ArrayPosition] = $CurrentOrder[$ArrayPosition+1];
		$CurrentOrder[$ArrayPosition+1] = $NewOrder;
		   for ($counter =0; $counter < $TotalLinks; $counter++) {
		    	$ItemID = $CurrentOrder[$counter];
				$UpdatePosition = $counter + 1;
		   		$query = "UPDATE faq set Position='$UpdatePosition' where id ='$ItemID'"; 
				$db->query($query);
				//print $query.'</br></br>';
			//	print $query;
			}
	}
	
}
	

if (($_GET['a'] == 'faq') && ($_POST['btnsubmit'] == 'SAVE')) {
	$db = new DB();
	$Question = mysql_escape_string($_POST['txtQuestion']);
	$Answer = mysql_escape_string($_POST['txtAnswer']);
	$Published = $_POST['txtPublished'];
	$query = "UPDATE faq set Question = '$Question', Answer='$Answer', Published='$Published' where id='$ItemID'";
	$db->query($query);
}
?>