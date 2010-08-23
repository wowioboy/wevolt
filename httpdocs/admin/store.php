<?  
//if (!file_exists('includes/config.php')) {
//if (!file_exists('install/index.php')) {
   //  header('Location: /noconfig.php');
	// } else {
	 
	// header('Location: install/index.php');
	// }
   // echo "The file $filename exists";
//}	
include_once("includes/init.php"); 
$Pagetracking = 'Store'; 
$Application ='store';

$db = new DB();
    $query = "select * from pf_store";
	$StoreSettings = $db->queryUniqueObject($query);
	$NumFeaturedItems = $StoreSettings->NumFeaturedItems;
	$BuyButton = $StoreSettings->BuyButton;
	$AddCart = $StoreSettings->AddCart;
	$ViewCart = $StoreSettings->ViewCart;
	$ShowCategoryMenu = $StoreSettings->ShowCategoryMenu;
	$ShowFeaturedMenu = $StoreSettings->ShowFeaturedMenu;
	$ThankYou = $StoreSettings->ThankYou;
	$MerchantEmail = $StoreSettings->PayPalEmail;
	$ShowViewCart = $StoreSettings->ShowViewCart;
	$ShowAddCart = $StoreSettings->ShowAddCart;
//FRONTPAGE
if ((!isset($_GET['item'])) && (!isset($_GET['cat']))) {
    $query = "select * from pf_store_items where IsFeatured=1 order by Title limit $NumFeaturedItems";
	$db->query($query);
	$counter = 0;
	$FeaturedString = '<div class="storeheader">FEATURED ITEMS</div><div class="spacer"></div><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>';
	  while ($line = $db->fetchNextObject()) { 
	   
	 	 if ($counter == 6) {    
	  		$FeaturedString .= "<td><div class='item'><a href='store.php?item=".$line->ID."'><img src='".$line->ThumbLg."' border='0'></a></div></td>";
		 } else {
			 
			 	$FeaturedString .= "<td><div class='item'><a href='store.php?item=".$line->ID."'><img src='".$line->ThumbLg."' border='0'></a></div></td><td class='itemseperator'></td>";
		 }
			 $counter++;
			
 		if ($counter == 7){
 				$FeaturedString .= "</tr><tr>";
 				$counter = 0;
 			}
		} 
		if (($counter < 7) && ($counter != 0)) {
		 while ($counter < 7) {
			$FeaturedString .= "<td><div class='itemheader'>&nbsp;</div><div class='item'>&nbsp;</div></td>";
		 	$counter++;
		 }
		 $FeaturedString .= "</tr>";
		}
 	$FeaturedString .= "</table>";	
} else if ((!isset($_GET['item'])) && (isset($_GET['cat']))) {
$CatID = $_GET['cat'];
    $query = "select * from pf_store_items where Category='$CatID' order by Title";
	$db->query($query);
	$query = "select Title from pf_store_categories where ID='$CatID'";
	$StoreCatTitle = $db->queryUniqueValue($query);
	$counter = 0;
	$FeaturedString = '<div class="storeheader">'.$StoreCatTitle.'</div><div class="spacer"></div><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>';
	  while ($line = $db->fetchNextObject()) { 
	  
	 	 if ($counter == 6) {    
	  		$FeaturedString .= "<td><div class='item'><a href='store.php?item=".$line->ID."'><img src='".$line->ThumbLg."' border='0'></a></div></td>";
		 } else {
			 
			 	$FeaturedString .= "<td><div class='item'><a href='store.php?item=".$line->ID."'><img src='".$line->ThumbLg."' border='0'></a></div></td><td class='itemseperator'></td>";
		 }
			 $counter++;
			
 		if ($counter == 7){
 				$FeaturedString .= "</tr><tr>";
 				$counter = 0;
 			}
		} 
		if (($counter < 7) && ($counter != 0)) {
		 while ($counter < 7) {
			$FeaturedString .= "<td><div class='itemheader'>&nbsp;</div><div class='item'>&nbsp;</div></td>";
		 	$counter++;
		 }
		 $FeaturedString .= "</tr>";
		}
 	$FeaturedString .= "</table>";	
} else if ((isset($_GET['item'])) && (!isset($_GET['cat']))) {
$ItemID = $_GET['item'];
    $query = "select * from pf_store_items where id='$ItemID'";
	$ItemArray = $db->queryUniqueObject($query);
	$Title = $ItemArray->Title;
	$Description = $ItemArray->Description;
	$Price = $ItemArray->Price;
	$Encrypted = $ItemArray->Encrypted;
	$ItemImage = $ItemArray->GalleryImage;
	$ItemNumber = $ItemArray->ItemNumber;
	$ItemWeight = $ItemArray->ItemWeight;
	$ShippingOption = $ItemArray->ShippingOption;
	
} 


?>

<?php include 'includes/header.php'; ?><style type="text/css">
<!--
body {
	background-color: #303d4b;
}
-->
</style>
<div class="spacer"></div>	
<div class="contentwrapper" align="center">
<table width="<? echo $SiteWidth;?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="header" bgcolor="#000000" valign="middle" align="center"><img src="images/tyler_header.jpg" /></td>
  </tr>
  <tr>
    <td id="content" bgcolor="#FFFFFF" style="padding:10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="middle" id="topmenu"><? include 'includes/topmenu.php';?></td>
  </tr>
</table>
<div class="contentwrapper" <? if (!isset($_GET['item'])) {?>style="background-color:#a2b7b3;"<? } else { ?>style="background-color:#000000;"<? } ?>>
<? include 'includes/store_body_inc.php';?>

</div></td>
  </tr>
  <tr>
    <td id="footer">&nbsp;</td>
  </tr>
</table>

</div>			
<?php include 'includes/footer.php'; ?>	