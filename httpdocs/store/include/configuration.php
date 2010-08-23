<?php
/* *****************************************************/
/* 	USER CONFIGURABLE VARIABLES FOR ZSTORE 1.0.2  */
/* ****************************************************/

/***************************************************/
/*    REQUIRED VARIABLES   */
/*  You must replace the values for these variables  */
/****************************************************/	
// Your Zazzle contributor name. Enter your contributor name to feature products from your gallery exclusively
// or leave blank (remove "zazzle") to pull a feed from the Zazzle Marketplace.
$contributorHandle = "panelflow"; 

// Your Zazzle Associate ID
$associateId = "238957118906091327"; 

/****************************************************/
/*   OPTIONAL VARIABLES  */
/* You may change these variables to suit your gallery design  */
/****************************************************/

// The numeric code for the Zazzle product line to display. If you want to show all products from a gallery, leave this blank.  
// To get a product line number, click on a product line in a gallery.  In the URL you will see something like this:
// http://www.zazzle.com/coatsofarms/products/cg-196595220567583981.  The string of numbers at the end is the product line ID.
// Leave this blank if you are pulling Zazzle Marketplace feeds.
$productLineId = "";

// Product type filter. You can use this variable to limit display to only one type of product (t-shirts, mugs, etc)
// Just enter one of the numeric Product Codes below. If you leave this variable blank, all product types are displayed:
// 128 Bumper Sticker
// 137 Card
// 144 Mouse pad
// 145 Button 
// 146 Keychain
// 147 Magnet 
// 148 Hat
// 149 Bag 
// 151 Tie
// 153 Photo Sculpture 
// 154 Apron
// 156 Photo Print 
// 158 Calendar
// 167 Keds Shoes
// 168 Mug 
// 172 Postage Stamps
// 186 Skateboards
// 217 Sticker 
// 228 Print (posters)
// 231 Embroidered shirts
// 232 Embroidered bags
// 233 Embroidered hats
// 235 T-Shirt 
// 239 Postcards
// 240 Profile Card
$productType = "";

// Search terms.  Comma separated keywords you can use to select products for your store.
// Entering keywords is especially useful when pulling Zazzle Marketplace feeds.
// If you use a Marketplace feed and do not enter one or more keywords, all products from Zazzle.com 
// are returned, though not all at once. 
$keywords = "";

// Grid width: Set the overall width of your product grid (in pixels).
//$gridWidth = "900";
$gridWidth = "678";

// The size you want each grid cell (product square) - choices:  tiny, small, medium, large or huge
//$gridCellSize = "large"; 
$gridCellSize = "small"; 

// Grid cell spacing: The space between products in the product grid (in pixels).
$gridCellSpacing = "9";

// Background color of grid images in HEX (without the #, for example, "FFFFFF" for white)
$gridCellBgColor = "FFFFFF"; 

// If you have a Google Analytics account and you want to use it in your Zazzle Store, say true. Otherwise say false.
$useAnalytics = 'false'; 

// Your Google Analytics code.  This variable is ignored if useAnalytics is set to false. 
$analyticsId = "YOUROWNANALYTICSCODENUMBERHERE"; 

// Change just the number in quotes. This is how many results you want returned per page.
$showHowMany = !isset($_GET['ps']) ? "20" : $_GET['ps']; 

// Change just the number in quotes. The page of your gallery products you want to be the first displayed in your Zazzle Store
// (example, start showing products from page 5 of the result set)
$startPage = !isset($_GET['pg']) ? "1" : $_GET['pg']; 

// Show pagination controls (true or false).  These are the page numbers, <---Prev, and Next ---> used to move around in a gallery or Zazzle Store.
$showPagination = true; 

// Show sorting controls (true or false).  If true, controls are displayed allowing buyers to sort products by Recent (date created) or Popular (number sold).  
// If false, no sort controls are displayed and products are displayed according to the value of defaultSort. 
$showSorting = true; 

// How should we be sorting by default? options are 'date_created' or 'popularity' for sort by popularity.
$defaultSort = 'date_created';
	
// Show short product description beneath the product image (true or false). 
// Note: the description appears beneath the title if the title is enabled.
$showProductDescription = true;

// Show creator "by" line.  True or false. 
$showByLine = true;

// Show product title. True or false. 
$showProductTitle = true;

// Show product price.  If false, no price is displayed for products in your Zazzle Store. 
$showProductPrice = true;
	
// Enable or disable image caching (true or false). 
$useCaching = false;
	
// How long to keep cached resources (if useCaching is enabled) in seconds.  3600 seconds = 1 hour
//$cacheLifetime = 7200; 	
$cacheLifetime = 10; 	

	
/* ******************************************* */

?>
