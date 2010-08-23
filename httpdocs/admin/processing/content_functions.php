<? 
//CONTENT CATEGORY FUNCTIONS
if (($_GET['a'] == 'content') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$query = "DELETE from categories where id='$CatID'";
	$db->query($query);
}

if (($_GET['a'] == 'content') && ($_POST['btnsubmit'] == 'SAVE')  && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$SectionID = $_POST['txtSection'];
	$query = "UPDATE categories set title = '$Title' where id='$CatID'";
	$db->query($query);
	$query = "UPDATE categories set section = '$SectionID' where id='$CatID'";
	$db->query($query);
}

if (($_GET['a'] == 'content') && ($_POST['btnsubmit'] == 'CREATE') && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Section = $_POST['txtSection'];
	$query = "INSERT into categories (Title, Section) values ('$Title','$SectionID')";
	$db->query($query);
}


//CONTENT SECTION FUNCTIONS
if (($_GET['a'] == 'content') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] == 'section')) {
	$db = new DB();
	$query = "DELETE from sections where id='$SectionID'";
	$db->query($query);
}

if (($_GET['a'] == 'content') && ($_POST['btnsubmit'] == 'SAVE')  && ($_POST['sub'] == 'section')) {
	$db = new DB();
	$Title = $_POST['txtTitle'];
	$query = "UPDATE sections set title = '$Title' where id='$SectionID'";
	$db->query($query);
}

if (($_GET['a'] == 'content') && ($_POST['btnsubmit'] == 'CREATE') && ($_POST['sub'] == 'section')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Description = mysql_escape_string($_POST['txtDescription']);
	$query = "INSERT into sections (Title, Description) values ('$Title','$Description')";
	$db->query($query);
}

//DELETE POST
if (($_GET['a'] == 'content') && ($_POST['btnsubmit'] == 'YES')) {
	$db = new DB();
	$query = "DELETE from content where id='$PostID'";
	$db->query($query);
}
?>