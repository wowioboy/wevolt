<? if (($_GET['a'] == 'menu') && ($_POST['btnsubmit'] == 'CREATE')) {
	$db = new DB();
	$Inserted = 0;
	$Title = $_POST['txtTitle'];
	$Image = $_POST['txtImage'];
	$Application = $_POST['txtApp'];
	$LinkType = $_POST['txtType'];
	$Published = $_POST['txtPublished'];
	$SubMenu = $_POST['txtSubmenu'];
	$query = 'SELECT Position from menu WHERE Position=(SELECT MAX(Position) FROM menu)';
	$NewPosition = $db->queryUniqueValue($query);
	$NewPosition++;
	if ($_POST['txtType'] == 'application') {
		$Url = $_POST['txtApp'];
		$Window = 'parent';
	}
	if ($_POST['txtType'] == 'static') {
		$Url = 'index.php?p='.urlencode($_POST['txtStatic']);
		$Window = 'parent';
		$Content = $_POST['txtStatic'];
	}
	
	if ($_POST['txtType'] == 'external') {
		$Url = $_POST['txtUrl'];
		$Window = $_POST['txtWindow'];
	}
	
	if ($_POST['txtType'] == 'content') {
	$Content = $_POST['txtContent'];
	$Section = $_POST['txtSection'];
	$Category = $_POST['txtCategory'];
	
	if (($Content != '') && ($Content != 0)) {
		$Url = 'index.php?a=content&p='.$Content;
	} else if (($Section != '') && ($Section != 0)&& ($Category != '')&& ($Category != 0)){
		$Url = $Url = 'index.php?a=content&s='.$Section.'&c='.$Category;
		$query = "INSERT into menu (Title, Url, Window, Content, Application, LinkType, Image, Position, Published, Section, Category, SubMenu) values ('$Title','$Url','$Window','$Content','$Application','$LinkType','$Image',$NewPosition,$Published, $Section, $Category, $Submenu)";
	$db->query($query);
	$Inserted = 1;
	}else if ((($Section == '') || ($Section == 0)) && (($Category != '')&& ($Category != 0))){
		$Url = $Url = 'index.php?a=content&c='.$Category;
		$query = "INSERT into menu (Title, Url, Window, Content, Application, LinkType, Image, Position, Published, Category, SubMenu) values ('$Title','$Url','$Window','$Content','$Application','$LinkType','$Image',$NewPosition,$Published,  $Category,$Submenu)";
	$db->query($query);
	$Inserted = 1;
	}else if ((($Category == '') || ($Category == 0)) && (($Section != '')&& ($Section != 0))){
		$Url = $Url = 'index.php?a=content&s='.$Section;
		$query = "INSERT into menu (Title, Url, Window, Content, Application, LinkType, Image, Position, Published, Section, SubMenu) values ('$Title','$Url','$Window','$Content','$Application','$LinkType','$Image',$NewPosition,$Published, $Section,$Submenu)";
	$db->query($query);
	$Inserted = 1;
	}
	}
	
   if ($Inserted == 0) {	
	$query = "INSERT into menu (Title, Url, Window, Content, Application, LinkType, Image, Position, Published) values ('$Title','$Url','$Window','$Content','$Application','$LinkType','$Image','$NewPosition','$Published')";
	$db->query($query);
	}
	//header("location:admin.php?a=menu");
}

if (($_GET['a'] == 'menu') && ($_POST['btnsubmit'] == 'YES')) {
	$db = new DB();
	$query = "DELETE from menu where id='$MenuID'";
	$db->query($query);
}


if (($_GET['a'] == 'menu') && ($_POST['btnsubmit'] == 'MOVE UP')) {
	$db = new DB();
	$CurrentOrder = array();
	$i=0;
	$query = "SELECT * from menu order by position";
	$db->query($query);
	while ($line = $db->fetchNextObject()) { 
		$CurrentOrder[] = $line->ID;
		if ($line->ID == $MenuID) {
			$ArrayPosition = $i;
		}
		$i++;
	}
	$TotalLinks = $db->numRows();
	
	$query = "SELECT Position from menu where id='$MenuID'";
	$CurrentPosition = $db->queryUniqueValue($query);
	if ($CurrentPosition != 1) {
		$NewPosition = $CurrentPosition--;
		$NewOrder = $CurrentOrder[$ArrayPosition];
		$CurrentOrder[$ArrayPosition] = $CurrentOrder[$ArrayPosition-1];
		$CurrentOrder[$ArrayPosition-1] = $NewOrder;
		   for ( $counter =0; $counter < $TotalLinks; $counter++) {
		    $MenuID = $CurrentOrder[$counter];
			$UpdatePosition = $counter + 1;
		   	$query = "UPDATE menu set Position='$UpdatePosition' where id ='$MenuID'"; 
			$db->query($query);
			}
	}
	
}



if (($_GET['a'] == 'menu') && ($_POST['btnsubmit'] == 'MOVE DOWN')) {
	$db = new DB();
	$CurrentOrder = array();
	$i=0;
	$query = "SELECT * from menu order by position";
	$db->query($query);
	//print $query;
	while ($line = $db->fetchNextObject()) { 
		$CurrentOrder[] = $line->ID;
		if ($line->ID == $MenuID) {
			$ArrayPosition = $i;
			//print "MENU ID = " . $MenuID;
		}
		$i++;
	}
	$TotalLinks = $db->numRows();
	
	$query = "SELECT Position from menu where id='$MenuID'";
	//print $query;
	$CurrentPosition = $db->queryUniqueValue($query);
	//print "CURRENT POSITION = " . $CurrentPosition ;
	//print "MY Total Links = " . $TotalLinks;
	if ($CurrentPosition != $TotalLinks) {
		$NewPosition = $CurrentPosition--;
		$NewOrder = $CurrentOrder[$ArrayPosition];
		$CurrentOrder[$ArrayPosition] = $CurrentOrder[$ArrayPosition+1];
		$CurrentOrder[$ArrayPosition+1] = $NewOrder;
		   for ($counter =0; $counter < $TotalLinks; $counter++) {
		    	$MenuID = $CurrentOrder[$counter];
				$UpdatePosition = $counter + 1;
		   		$query = "UPDATE menu set Position='$UpdatePosition' where id ='$MenuID'"; 
				$db->query($query);
			//	print $query;
			}
	}
	
}
	

if (($_GET['a'] == 'menu') && ($_POST['btnsubmit'] == 'SAVE')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$ImageRemove = $_POST['txtImageRemove'];
	$SubMenu = $_POST['txtSubmenu'];
	if ($_POST['txtType'] == 'application') {
		$Url = $_POST['txtApp'];
		$Window = 'parent';
	}
	if ($_POST['txtType'] == 'static') {
		$Url = 'index.php?p='.urlencode($_POST['txtStatic']);
		$Window = 'parent';
			$Content = $_POST['txtStatic'];
	}
	
	if ($_POST['txtType'] == 'external') {
		$Url = $_POST['txtUrl'];
		$Window = $_POST['txtWindow'];
	}
	$Image = $_POST['txtImage'];
	if ($_POST['txtType'] == 'content') {
	$Content = $_POST['txtContent'];
	$Section = $_POST['txtSection'];
	$Category = $_POST['txtCategory'];
	if (($Content != '') && ($Content != 0)) {
		$Url = 'index.php?a=content&p='.$Content;
	} else if (($Section != '') && ($Section != 0)&& ($Category != '')&& ($Category != 0)){
		$Url = $Url = 'index.php?a=content&s='.$Section.'&c='.$Category;
		$query = "UPDATE menu set Section = '$Section', Category = '$Category' where id='$MenuID'";
		$db->query($query);
	}else if ((($Section == '') || ($Section == 0)) && (($Category != '')&& ($Category != 0))){
		$Url = $Url = 'index.php?a=content&c='.$Category;
		$query = "UPDATE menu set Category = '$Category' where id='$MenuID'";
		$db->query($query);
	}else if ((($Category == '') || ($Category == 0)) && (($Section != '')&& ($Section != 0))){
		$Url = $Url = 'index.php?a=content&s='.$Section;
		$query = "UPDATE menu set Section = '$Section' where id='$MenuID'";
		$db->query($query);
	}
	}
	$Application = $_POST['txtApp'];
	$LinkType = $_POST['txtType'];
	$Published = $_POST['txtPublished'];
	$query = "UPDATE menu set title = '$Title', SubMenu='$SubMenu' where id='$MenuID'";
	$db->query($query);
	$query = "UPDATE menu set url = '$Url' where id='$MenuID'";
	$db->query($query);
	$query = "UPDATE menu set window = '$Window' where id='$MenuID'";
	$db->query($query);
	$query = "UPDATE menu set published = '$Published' where id='$MenuID'";
	$db->query($query);
	$query = "UPDATE menu set LinkType = '$LinkType' where id='$MenuID'";
	$db->query($query);
	$query = "UPDATE menu set application = '$Application' where id='$MenuID'";
	$db->query($query);
	$query = "UPDATE menu set image = '$Image' where id='$MenuID'";
	$db->query($query);
	$query = "UPDATE menu set content = '$Content' where id='$MenuID'";
	$db->query($query);
	
	if ($ImageRemove == 1) {
		$query = "UPDATE menu set Image = '' where id='$MenuID'";
		$db->query($query);
	}
}

if (($_GET['a'] == 'menu') && (isset($_GET['id']))) {
if ($_GET['id'] != '') {
	$db = new DB();
	$Filename = $_POST['txtFilename'];
	$MenuID = $_GET['id'];
	$NewFilePath = 'images/menu/' . $Filename;
	copy("temp/".$Filename, $NewFilePath);
	chmod($NewFilePath,0777);
		$query = "UPDATE menu set Image='$NewFilePath' where ID='$MenuID'";
	$db->query($query);
}
}

?>