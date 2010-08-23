<? if (($_GET['a'] == 'blog') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$query = "SELECT ID from pf_blog_categories";
	$db->query($query);
	$CatCount = $db->numRows();
	if ($CatCount > 1) {
		$query = "SELECT ID from pf_blog_categories where id='$CatID' and isdefault=1";
		$db->query($query);
		$LineCount = $db->numRows();
		if ($LineCount > 0) {
			$query = "UPDATE pf_blog_categories set isDefault =1 where id=1";
			$db->query($query);
		}
	$query = "DELETE from pf_blog_categories where id='$CatID'";
	$db->query($query);
	}
}

if (($_GET['a'] == 'blog') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] == 'link')) {
	$db = new DB();
	$query = "DELETE from pf_blog_links where id='$LinkID'";
	$db->query($query);
	}


if (($_GET['a'] == 'blog') && ($_POST['btnsubmit'] == 'SAVE')  && ($_POST['sub'] == 'link')) {
	$db = new DB();
	$Title =  mysql_escape_string($_POST['txtTitle']);
	$Description =  mysql_escape_string($_POST['txtDescription']);
	$Url = $_POST['txtUrl'];
	$Published = $_POST['txtPublished'];
		$query = "UPDATE pf_blog_links set title = '$Title', Description='$Description', Url='$Url',Published='$Published' where id='$LinkID'";
	$db->query($query);
}

if (($_GET['a'] == 'blog') && ($_POST['btnsubmit'] == 'CREATE')  && ($_POST['sub'] == 'link')) {
	$db = new DB();
	$Title =  mysql_escape_string($_POST['txtTitle']);
	$Description =  mysql_escape_string($_POST['txtDescription']);
	$Url = $_POST['txtUrl'];
	$Published = $_POST['txtPublished'];
	$query = "INSERT into pf_blog_links (Title, Description, Url, Published) values ('$Title','$Description','$Url','$Published')";
	$db->query($query);
}

if (($_GET['a'] == 'blog') && ($_POST['btnsubmit'] == 'SAVE')  && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$Title = $_POST['txtTitle'];
	$Default = $_POST['txtDefault'];
	if ($Default == 1) {
		$query = "SELECT ID from pf_blog_categories where isdefault = 1";
		$db->query($query);
		while ($line = $db->fetchNextObject()) { 
			$DefaultID = $line->ID;
		}
		$query = "UPDATE pf_blog_categories set isdefault=0 where ID='$DefaultID'";
		$db->query($query);
	} else { 
		$query = "SELECT ID from pf_blog_categories where id='$CatID' and isdefault=1";
		$db->query($query);
		$LineCount = $db->numRows();
		if ($LineCount > 0) {
			$query = "UPDATE pf_blog_categories set isDefault =1 where id=1";
			$db->query($query);
		} 
	}
	$query = "UPDATE pf_blog_categories set title = '$Title' where id='$CatID'";
	$db->query($query);
	$query = "UPDATE pf_blog_categories set isDefault = '$Default' where id='$CatID'";
	$db->query($query);
}

if (($_GET['a'] == 'blog') && ($_POST['btnsubmit'] == 'CREATE') && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Default = $_POST['txtDefault'];
	if ($Default == 1) {
		$query = "SELECT ID from pf_blog_categories where isdefault = 1";
		$db->query($query);
		while ($line = $db->fetchNextObject()) { 
			$DefaultID = $line->ID;
		}
		$query = "UPDATE pf_blog_categories set isdefault=0 where ID='$DefaultID'";
		$db->query($query);
	}
	$query = "INSERT into pf_blog_categories (Title, IsDefault) values ('$Title',$Default)";
	$db->query($query);
}

//DELETE BLOG POST
if (($_GET['a'] == 'blog') && ($_POST['btnsubmit'] == 'YES')) {
	$db = new DB();
	$query = "DELETE from pf_blog_posts where id='$PostID'";
	$db->query($query);
}

?>