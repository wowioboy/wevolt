<? 

if (($_GET['a'] == 'settings') && ($_POST['btnsubmit'] == 'SAVE')) {
	$db = new DB();
	// GLOBAL SETTINGS
	$SiteTitle = mysql_real_escape_string($_POST['txtSiteTitle']);
	$MenuLayout = $_POST['txtMenuLayout'];
	$Copyright = mysql_real_escape_string($_POST['txtCopyright']);
	$Description = mysql_real_escape_string($_POST['txtDescription']);
	$Keywords = mysql_real_escape_string($_POST['txtKeywords']);
	
	//GALLERY SETTNIGS
	$ResizeImage = $_POST['txtResizeImage'];
	$ImageSize = $_POST['txtImageSize'];
	
	//BLOG SETTINGS
	$BlogPosts = $_POST['txtBlogPosts'];
	$BlogTitle = mysql_real_escape_string($_POST['txtBlogTitle']);
	$AllowComments = $_POST['txtAllowComments'];
	$ShowCalendar = $_POST['txtShowCalendar'];
	$ShowBlogRoll = $_POST['txtShowBlogRoll'];
	$ShowBlogRSS = $_POST['txtShowBlogRSS'];
	//FRONTPAGE SETTINGS
	
	$ContentModule = $_POST['txtContentModule'];
	$ContentCategory = $_POST['txtContentCategory'];
	if ($ContentCategory == 0) {
		$ContentCategory = '';
	}
	$NumArticles = $_POST['txtNumArticles'];
	
	$StaticPageFront =$_POST['txtStaticPageFront'];
	$StaticPage = $_POST['txtPage'];
	
	$BlogFront = $_POST['txtBlogFront'];
	$NumBlogPosts = $_POST['txtNumBlogPosts'];
	$BlogCategories = $_POST['txtBlogCategory'];
	
	$FrontGalleryVisible = $_POST['txtGalleryFront'];
	$FrontGallery = $_POST['txtFrontGallery'];
	
	//SIDEBAR SETTINGS
	$SidebarVisible = $_POST['txtSidebarVisible'];
	$SidebarBackgroundColor = $_POST['txtSidebarBackgroundColor'];
	$SidebarLayout = $_POST['txtSidebarLayout'];
	$SidebarWidth = $_POST['txtSidebarWidth'];
	
	//GLOBAL
	$query = "UPDATE settings set sitetitle = '$SiteTitle'";
	$db->query($query);
	$query = "UPDATE settings set frontpage = '$FrontPage'";
	$db->query($query);
	$query = "UPDATE settings set menulayout = '$MenuLayout'";
	$db->query($query);
	$query = "UPDATE settings set copyright = '$Copyright'";
	$db->query($query);
	$query = "UPDATE settings set Description = '$Description'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE settings set Keywords = '$Keywords'";
	$db->query($query);
	//print $query."<br/>";
	
	//FRONTPAGE
	$query = "UPDATE frontpage set ContentModule = '$ContentModule'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE frontpage set ContentCategory = '$ContentCategory'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE frontpage set NumArticles = '$NumArticles'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE frontpage set StaticPageFront = '$StaticPageFront'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE frontpage set StaticPage = '$StaticPage'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE frontpage set BlogFront = '$BlogFront'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE frontpage set NumBlogPosts = '$NumBlogPosts'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE frontpage set BlogCategories = '$BlogCategories'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE frontpage set FrontGalleryVisible = '$FrontGalleryVisible'";
	$db->query($query);

	$query = "UPDATE frontpage set FrontGallery = '$FrontGallery'";
	$db->query($query);
	//print $query."<br/>";


	//GALLERY
	//$query = "UPDATE pf_gallery set resizeimage = '$ResizeImage'";
	//$db->query($query);
	//print $query."<br/>";
	//$query = "UPDATE pf_gallery set imagesize = '$ImageSize'";
	//$db->query($query);
	//print $query."<br/>";
	
	//BLOG 
	$query = "UPDATE pf_blog set blogtitle = '$BlogTitle', numberofposts = '$BlogPosts',AllowComments = '$AllowComments',ShowCalendar = '$ShowCalendar',ShowBlogRoll = '$ShowBlogRoll', ShowBlogRSS='$ShowBlogRSS'";
	$db->query($query);
	
	//SIDEBAR
	$query = "UPDATE sidebar set published = '$SidebarVisible'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE sidebar set backgroundcolor = '$SidebarBackgroundColor'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE sidebar set SidebarLayout = '$SidebarLayout'";
	$db->query($query);
	//print $query."<br/>";
	$query = "UPDATE sidebar set Width = '$SidebarWidth'";
	$db->query($query);
	//print $query."<br/>";
	
	// STORE SETTINGS
	$ResizeImage = $_POST['txtStoreResizeImage'];
	$ImageSize = $_POST['txtStoreResizeSize'];
	$StoreTitle = mysql_real_escape_string($_POST['txtStoreTitle']);
	$MaxWidth = $_POST['txtStoreWidth'];
	$MaxHeight = $_POST['txtStoreHeight'];
	$MaxHeight = $_POST['txtStoreHeight'];
	$NumFeaturedItems = $_POST['txtNumFeaturedItems'];
	$ShowCategoryMenu = $_POST['txtCategoryMenu'];
	$ShowFeaturedMenu = $_POST['txtFeaturedMenu'];
	$ThankYou = mysql_real_escape_string($_POST['txtThankYou']);
	$MerchantEmail = $_POST['txtMerchantEmail'];
	$ShowViewCart = $_POST['txtShowViewCart'];
		$ShowAddCart = $_POST['txtShowAddCart'];
	//$query = "UPDATE pf_store set ResizeImage = '$ResizeImage',ResizeSize = '$ImageSize',MaxWidth = '$MaxWidth',MaxHeight = '$MaxHeight',Title = '$StoreTitle',NumFeaturedItems = '$NumFeaturedItems',ShowCategoryMenu = '$ShowCategoryMenu', ThankYou='$ThankYou', PayPalEmail ='$MerchantEmail', ShowAddCart='$ShowAddCart', ShowViewCart='$ShowViewCart'";
//	$db->query($query);	

}

if (($_GET['a'] == 'settings') && (isset($_POST['txtButton']))) {
	$db = new DB();
	$Filename = $_POST['txtFilename'];
	$NewFilePath = 'store/images/' . $Filename;
	$ButtonType = $_POST['txtButton'];
	copy("temp/".$Filename, $NewFilePath);
	chmod($NewFilePath,0777);
	
	if ($ButtonType == 'buy') {
	$query = "UPDATE pf_store set BuyButton='$NewFilePath'";
	} else if ($ButtonType == 'addcart') {
	$query = "UPDATE pf_store set AddCart='$NewFilePath'";
	}else if ($ButtonType == 'viewcart') {
	$query = "UPDATE pf_store set ViewCart='$NewFilePath'";
	}
	$db->query($query);
}
?>