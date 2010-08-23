<?php
 if(!isset($_SESSION)) {
    session_start();
  } 
$Version = '2';

if ((!isset($_GET['a'])) && (!isset($_GET['p']))) {
$PageTitle = 'Home';
}
$config = array();
include 'config.php';
include 'functions.php'; 
include 'comments_functions.php';
$dbuser = $config['dbuser'];
$dbpass = $config['dbpass'];
$database = $config['database'];
$dbhost = $config['dbhost'];
$settings = new DB();
$query = "select * from settings";
$settings->query($query);
while ($setting = $settings->fetchNextObject()) { 
	$SiteTitle = $setting->SiteTitle;
	$FrontPage = $setting->FrontPage;
	$MenuLayout = $setting->MenuLayout;
	$Copyright = $setting->Copyright;
	$ImageResize = $setting->ResizeImage;
	$SiteWidth = $setting->SiteWidth;
	$AdminUser = $setting->AdminUser;
	$AdminEmail = $setting->Email;
	$SiteDescription = $setting->Description;
	$Keywords = $setting->Keywords;
}

$query = "select AllowComments from pf_blog";
$AllowBlogComments = $settings->queryUniqueValue($query);
$query = "select ShowBlogRSS from pf_blog";
$ShowBlogRSS = $settings->queryUniqueValue($query);

$query = "select * from frontpage";
$settings->query($query);
while ($setting = $settings->fetchNextObject()) { 
	$ContentModule = $setting->ContentModule;
	$FrontContentCategories =  explode(",", $setting->ContentCategory);
	$FrontCatCount = sizeof($FrontContentCategories);
	if (($FrontCatCount == 1) && ($FrontContentCategories[0] == '')) {
		$FrontContentCategories[0] = $setting->ContentCategory;
		}
	$NumArticles = $setting->NumArticles;
	$StaticPageFront = $setting->StaticPageFront;
	$StaticPage = $setting->StaticPage;
	$BlogFront = $setting->BlogFront;
	$NumFrontBlogPosts = $setting->NumBlogPosts;
	$FrontBlogCategories = explode(",", $setting->BlogCategories);
	$FrontBlogCatCount = sizeof($FrontBlogCategories);
	$FrontGalleryVisible = $setting->FrontGalleryVisible;
	$FrontGallery = $setting->FrontGallery;
}


$query = "select * from sidebar";
$settings->query($query);
while ($setting = $settings->fetchNextObject()) { 
	$Sidebar = $setting->Published;
	$SidebarBackgroundColor = $setting->BackgroundColor;
	$SidebarLayout = $setting->SidebarLayout;
	$SidebarWidth = $setting->Width;
}


srand();

if (is_authed()) { 
	$loggedin = 1;
} else {
	$loggedin = 0;
} 

$BlogContent = '';
$HtmlContent = '';
$Content = '';
$MenuID = $_POST['txtMenu'];
$PageID = $_POST['txtPage'];
$CatID = $_POST['txtCat'];
$PostID = $_POST['txtPost'];
$SectionID = $_POST['txtSection'];
$GalleryID = $_POST['txtGallery'];
$ItemID = $_POST['txtItem'];
$ModuleID = $_POST['txtModule'];
$UserID = $_POST['txtUser'];
$ProjectID = $_POST['txtProject'];
$TaskID = $_POST['txtTask'];
$FileID = $_POST['txtFile'];
$Search = $_POST['searchtext'];
$RSSID = $_POST['txtRss'];
$LinkID = $_POST['txtLink'];
if ($Search == 'enter keywords') {
$Search = '';
}
$ApplicationType = $_GET['a'];
$GroupID = $_POST['txtGroup'];
?>