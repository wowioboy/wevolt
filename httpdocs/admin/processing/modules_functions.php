<? 

if (($_GET['a'] == 'modules') && ($_POST['btnsubmit'] == 'SAVE MODULE')) {
	$moduleDB = new DB();
	$Published = $_POST['txtPublish'];
	$Application = $_POST['txtApp'];
	$Title = $_POST['txtTitle'];
	$Sidebar = $_POST['txtSidebar'];
	$FrontPage = $_POST['txtFrontpage'];
	$ShowTitle = $_POST['txtShowTitle'];
	$AppModuleID = $_POST['txtAppModule'];
	$query = "update modules set published='$Published',frontpage='$FrontPage',title='$Title',sidebar='$Sidebar', ShowTitle='$ShowTitle' where id='$ModuleID' and application='$Application'";
	$moduleDB->query($query);

// APPLY TO PF_GALLERY_MODULES
if ($Application == 'gallery') {
	$NumberOfRows = $_POST['txtRows'];
	$NumberOfCols = $_POST['txtCols'];
	$Galleries = $_POST['txtGalleries'];
	$Categories = $_POST['txtCategory'];
	$Random = $_POST['txtRandom'];
	if (is_array($Galleries))
	{
  	$TempGalleries = '';
 	 foreach ($Galleries as $value) {
   	  if ($TempGalleries != '')
   	   $TempGalleries .= ',';
   	 $TempGalleries .= $value;
 	 }
 	 $GalleriesString = $TempGalleries;
	}
	if (is_array($Categories))
	{
  	$TempCategories = '';
 	 foreach ($Categories as $value) {
   	  if ($TempCategories != '')
   	   $TempCategories .= ',';
   	 $TempCategories .= $value;
 	 }
 	 $CategoriesString = $TempCategories;
	}
	$query = "update pf_gallery_modules set NumberOfRows='$NumberOfRows',NumberOfCols='$NumberOfCols',Galleries='$GalleriesString', Categories='$CategoriesString', Random='$Random',Title='$Title'  where id='$AppModuleID'";
	$moduleDB->query($query);
	}
	
	if ($Application == 'blog') {
	$query = "update pf_blog_modules set Title='$Title' where id='$AppModuleID'";
	$moduleDB->query($query);
	}
	
	if ($Application == 'store') {
	$NumberOfRows = $_POST['txtRows'];
	$NumberOfCols = $_POST['txtCols'];
	$Categories = $_POST['txtCategory'];
	$Random = $_POST['txtRandom'];
	if (is_array($Categories))
	{
  	$TempCategories = '';
 	 foreach ($Categories as $value) {
   	  if ($TempCategories != '')
   	   $TempCategories .= ',';
   	 $TempCategories .= $value;
 	 }
 	 $CategoriesString = $TempCategories;
	}
	$query = "update pf_store_modules set NumberOfRows='$NumberOfRows',NumberOfCols='$NumberOfCols', Categories='$CategoriesString', Random='$Random',Title='$Title'  where id='$AppModuleID'";
	$moduleDB->query($query);
	}
	
}

if (($_GET['a'] == 'modules') && ($_POST['btnsubmit'] == 'MOVE UP')) {
	$db = new DB();
	$CurrentOrder = array();
	$i=0;
	$query = "SELECT * from modules order by position";
	$db->query($query);
	while ($line = $db->fetchNextObject()) { 
		$CurrentOrder[] = $line->ID;
		if ($line->ID == $ModuleID) {
			$ArrayPosition = $i;
		}
		$i++;
	}
	$TotalLinks = $db->numRows();
	
	$query = "SELECT Position from modules where id='$ModuleID'";
	$CurrentPosition = $db->queryUniqueValue($query);
	if ($CurrentPosition != 1) {
		$NewPosition = $CurrentPosition--;
		$NewOrder = $CurrentOrder[$ArrayPosition];
		$CurrentOrder[$ArrayPosition] = $CurrentOrder[$ArrayPosition-1];
		$CurrentOrder[$ArrayPosition-1] = $NewOrder;
		   for ( $counter =0; $counter < $TotalLinks; $counter++) {
		    $ModuleID = $CurrentOrder[$counter];
			$UpdatePosition = $counter + 1;
		   	$query = "UPDATE modules set Position='$UpdatePosition' where id ='$ModuleID'"; 
			$db->query($query);
			}
	}
	
}



if (($_GET['a'] == 'modules') && ($_POST['btnsubmit'] == 'MOVE DOWN')) {
	$db = new DB();
	$CurrentOrder = array();
	$i=0;
	$query = "SELECT * from modules order by position";
	$db->query($query);
	//print $query;
	while ($line = $db->fetchNextObject()) { 
		$CurrentOrder[] = $line->ID;
		if ($line->ID == $ModuleID) {
			$ArrayPosition = $i;
			//print "MODULE ID = " . $ModuleID;
		}
		$i++;
	}
	$TotalLinks = $db->numRows();
	$query = "SELECT Position from modules where id='$ModuleID'";
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
		    	$ModuleID = $CurrentOrder[$counter];
				$UpdatePosition = $counter + 1;
		   		$query = "UPDATE modules set Position='$UpdatePosition' where id ='$ModuleID'"; 
				$db->query($query);
				//print $query;
			}
	}
	
}
	

?>