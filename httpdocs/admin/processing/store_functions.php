<? if (($_GET['a'] == 'store') && ($_POST['btnsubmit'] == 'SAVE ITEM')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Description = mysql_escape_string($_POST['txtDescription']);
	$Category = $_POST['txtCategory'];
	$IsCategoryThumb = $_POST['txtCategoryThumb'];
	$Encrypted = $_POST['encryptedButton'];
	$Price = $_POST['txtPrice'];
	$IsActive = $_POST['txtActive'];
	$IsFeatured = $_POST['txtFeatured'];
	$ItemNumber = $_POST['txtNumber'];
	$ItemShipping = $_POST['txtShipping'];
	$ItemWeight = $_POST['txtWeight'];
		$InModule = $_POST['txtInModule'];
	$ModuleAddedDate = time();
	$ShippingOption = $_POST['txtShippingOption'];
	$query = "UPDATE pf_store_items set title = '$Title', Description = '$Description',Category = '$Category', price='$Price', Encrypted='$Encrypted', IsActive='$IsActive',IsFeatured='$IsFeatured', ItemNumber='$ItemNumber',ItemWeight='$ItemWeight',ItemShipping='$ItemShipping', ShippingOption='$ShippingOption',InModule = '$InModule' where id='$ItemID'";
	$db->query($query);
	if ($IsCategoryThumb == 1) {
		$query = "UPDATE pf_store_categories set CategoryThumb='$ItemID' where id='$Category'";
		$db->query($query);
	} else {
	$query = "SELECT CategoryThumb from pf_store_categories where id='$Category'";
		$ThumbID = $db->queryUniqueValue($query);
		if ($ThumbID == $ItemID) {
			$Blank = '';
			$query = "UPDATE pf_store_categories set CategoryThumb='$Blank' where id='$Category'";
		}
	}
}

if (($_GET['a'] == 'store') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$query = "DELETE from pf_store_categories where id='$CatID'";
	$db->query($query);
}


if (($_GET['a'] == 'store') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] == 'item')) {
	$db = new DB();
	$query = "DELETE from pf_store_items where id='$ItemID'";
	$db->query($query);
}


if (($_GET['a'] == 'store') && ($_POST['btnsubmit'] == 'SAVE') && (!isset($_POST['sub']))) {
	$db = new DB();
	$query = "UPDATE pf_store set Title='$Title', MaxWidth='$MaxWidth', MaxHeight='$MaxHeight', ResizeImage='$ResizeImage',ResizeSize='$ResizeSize'";
	$db->query($query);
}

if (($_GET['a'] == 'store') && ($_POST['btnsubmit'] == 'SAVE')  && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$query = "UPDATE pf_store_categories set title = '$Title' where id='$CatID'";
	$db->query($query);
}


if (($_GET['a'] == 'store') && ($_POST['btnsubmit'] == 'SAVE')  && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$query = "UPDATE pf_store_categories set title = '$Title' where id='$CatID'";
	$db->query($query);
}



if (($_GET['a'] == 'store') && ($_POST['btnsubmit'] == 'CREATE') && ($_POST['sub'] == 'cat')) {
	$db = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$query = "INSERT into pf_store_categories (Title) values ('$Title')";
	$db->query($query);
}?>