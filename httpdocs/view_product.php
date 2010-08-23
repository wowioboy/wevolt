<?php include 'includes/init.php';



//$ID = 'bac9162b16c';
$ItemID = $_GET['productid'];
if ($ItemID == '')
	$ItemID = $_POST['productid'];

$ItemDB = new DB();

$query = "SELECT  pi.ShortTitle, pi.ComicID, pi.Price, pi.ProductType, pi.Description as ProductDescription, pi.Tags as ProductTags, pi.EncryptID,pi.DownloadFile,pi.UserID,pi.ShippingRate ,simg.ThumbLg, pamd.*, pab.*, pap.*,papr.*,c.title as Comic,c.SafeFolder,u.realname,u.username from pf_store_items as pi
		  join pf_store_images as simg on pi.EncryptID=simg.ItemID
		  join users as u on u.encryptid=pi.UserID
		  join comics as c on c.comiccrypt=pi.ComicID
		  left join products_attributes_books as pab on pi.EncryptID=pab.ItemID
		  left join products_attributes_pdf as pap on pi.EncryptID=pap.ProductID
		  left join products_attributes_prints as papr on pi.EncryptID=papr.ItemID
		  left join products_attributes_podmerch as pamd on pi.EncryptID=pamd.ItemID
		 
where pi.EncryptID='$ItemID'";
$ItemArray = $ItemDB->queryUniqueObject($query);
$ItemTitle = $ItemArray->ShortTitle;
$PodID = $ItemArray->PodID;
$ComicID = $ItemArray->ComicID;
$UserID = $ItemArray->UserID;
$SafeFolder = $ItemArray->SafeFolder;
 $templateURL = 'http://www.zazzle.com/api/create/at-238957118906091327?rf=238957118906091327&ax=Linkover&pd='.$PodID.'&fwd=ProductPage&ed=true&image=';
$Image = $ItemArray->DownloadFile;
$imageURL = urlencode('http://www.panelflow.com/'.$Image);
if ($ItemArray->ProductType == 'podmerch')
	$BuyLink = 	$templateURL .$imageURL;
		  
$ItemImage = $ItemArray->ThumbLg;
$PageTitle = ' | Products | '.$ItemTitle;

$TotalPrice = $ItemArray->Price + $ItemArray->ShippingRate;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
 
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?><?php echo $PageTitle; ?></title>
</head>


<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 


     <div class='contentwrapper'>
    <table width="100%" cellspacing="0" cellpadding="0">
           <tr>
            <td width="309" valign="top" style="padding-left:10px;"><div align="left"><span style="font-size:14px;"><? echo $ItemTitle;?></span></div>
<img src="/<? echo $ItemImage;?>" style="border:2px solid #FF9900;" vspace='2'/>



<?
$query = "SELECT * from pf_store_items as si
					  join pf_store_images as sim on sim.ItemID=si.EncryptID
					  where (si.ComicID='$ComicID' or si.UserID='$UserID') and sim.ItemID!='$ItemID' and sim.IsMain=1 order by si.ShortTitle";
					
				$ItemDB->query($query);
				$NumOther = $ItemDB->numRows();
				
				
				
				$Count = 0;
				if ($NumOther > 0) {
					$OtherString = '<div class="spacer"></div><div class="warning">Other Products by Creator: </div><table cellpadding="0" cellspacing="0" border="0"><tr>';
				while($line= $ItemDB->FetchNextObject()) {
				
					if (($line->ProductType == 'selfpdf') || ($line->ProductType == 'pdf') || ($line->ProductType == 'ebook'))
					$ProductCategory = 'E-Book';
					
					if (($line->ProductType == 'selfprint') || ($line->ProductType == 'podprint'))
					$ProductCategory = 'Print';
					
					
					if (($line->ProductType == 'selfbook') || ($line->ProductType == 'podbook'))
					$ProductCategory = 'Book';
					
					if (($line->ProductType == 'selfmerch') || ($line->ProductType == 'podmerch'))
					
					$ProductCategory = 'Merch';
					
						$OtherString .= '<td width="200" align="center"><b>'.$line->ShortTitle.'</b><br><em>'.$ProductCategory.'</em><br>';
						$OtherString .= '<a href="/'.$SafeFolder.'/products/'.$line->EncryptID.'/"><img src="/'.$line->ThumbSm.'" hspace="3" border="0"></a></td>';
						$Count++;
						if ($Count ==3) {
							$OtherString .= '</tr><tr>';
							$Count = 0;
						}
					}
					 
					 if ($Count < 3) {
						while($Count <3) {
						$OtherString .= '<td></td>';
							$Count++;
						}
						$OtherString .= '</tr>';
					 }
					$OtherString .= '</table>';
				}
				echo $OtherString;
				
				$ItemDB->close();
?>


</td>
            <td width="402" valign="top" style="font-size:12px;padding-left:10px; padding-right:20px;line-height:16px;" align="left">
            <?  
			$ProductType = $ItemArray->ProductType;
			
			if (($ItemArray->ProductType == 'pdf')||($ItemArray->ProductType == 'selfpdf')||($ItemArray->ProductType == 'ebook')){?>
            <b>Product Type</b>: E-Book<br />
            <b>Property</b>: <? echo $ItemArray->Comic;?><br />
			<b>Creator</b>: <a href="/profile/<? echo $ItemArray->username;?>/"><? echo $ItemArray->realname;?></a><br />
            <b>Description</b>: <? echo $ItemArray->Subject;?><br />
            <b>Tags</b>: <? echo $ItemArray->Tags;?><br />
            <b>Number of Pages</b>: <? echo $ItemArray->Pages;?><br />
            <br />
            <? if ($ItemArray->Price != '') {?>
			<b>Price</b>: $<? echo $ItemArray->Price;?>
             <? if (($ItemArray->ShippingRate != '') && ($ItemArray->ShippingRate != 0)) {?>
            <b>Shipping and Handling: </b>:<? echo $ItemArray->ShippingRate;?>
            <? }?>
            <? } else {?>
            <b>FREE!</b>
            <? }?>
            <? } else  if (($ItemArray->ProductType == 'podprint') ||($ItemArray->ProductType == 'selfprint')){?>
            <b>Product Type</b>: Print<br />
            <b>Property</b>: <? echo $ItemArray->Comic;?><br />
			<b>Creator</b>: <a href="/profile/<? echo $ItemArray->username;?>/"><? echo $ItemArray->realname;?></a><br />
            <b>Description</b>: <? echo $ItemArray->ProductDescription;?><br />
            <b>Tags</b>: <? echo $ItemArray->ProductTags;?><br />
            <br />
              <? if ($ItemArray->Price != '') {?>
            <b>Price</b>: $<? echo $ItemArray->Price;?>
            <? }?>
             <? if (($ItemArray->ShippingRate != '') && ($ItemArray->ShippingRate != 0)) {?>
            <b>Shipping and Handling: </b>:<? echo $ItemArray->ShippingRate;?>
            <? }?>
             <? } else  if (($ItemArray->ProductType == 'selfbook') ||($ItemArray->ProductType == 'podbook')){?>
            <b>Product Type</b>: Printed Book<br />
            <b>Property</b>: <? echo $ItemArray->Comic;?><br />
			<b>Creator</b>: <a href="/profile/<? echo $ItemArray->username;?>/"><? echo $ItemArray->realname;?></a><br />
            <b>Description</b>: <? echo $ItemArray->ProductDescription;?><br />
            <b>Tags</b>: <? echo $ItemArray->ProductTags;?><br />
            <br />
             <? if ($ItemArray->Price != '') {?>
            <b>Price</b>: $<? echo $ItemArray->Price;?>
            <? }?>
             <? if (($ItemArray->ShippingRate != '') && ($ItemArray->ShippingRate != 0)) {?>
            <b>Shipping and Handling: </b>:<? echo $ItemArray->ShippingRate;?>
            <? }?>
             <? } else  if (($ItemArray->ProductType == 'selfmerch') ||($ItemArray->ProductType == 'podmerch')){?>
            <?

			 if ($ProductType == 'podmerch') {?>
            <b>Product Type</b>: <? echo $ItemArray->TemplateName;?><br />
            <? } else {?>
             <b>Product Type</b>: Merchandise<br />
            <? }?>
            <b>Property</b>: <? echo $ItemArray->Comic;?><br />
			<b>Creator</b>: <a href="/profile/<? echo $ItemArray->username;?>/"><? echo $ItemArray->realname;?></a><br />
            <b>Description</b>: <? echo $ItemArray->ProductDescription;?><br />
            <b>Tags</b>: <? echo $ItemArray->ProductTags;?><br />
            <br />
             <? if ($ItemArray->Price != '') {?>
            <b>Price</b>: $<? echo $ItemArray->Price;?>
            <? }?>
            
             <? if (($ItemArray->ShippingRate != '') && ($ItemArray->ShippingRate != 0)) {?>
            <b>Shipping and Handling: </b>:<? echo $ItemArray->ShippingRate;?>
            <? }?>
            <? }?>
            <div align="center">
            
            <? if (($_GET['a'] == 'notauth') || (!is_authed())) {?>
            <div class="spacer"></div>
                    <div class="spacer"></div>
                    <div class="warning">YOU NEED TO BE LOGGED IN TO DOWNLOAD or PURCHASE</div><div class="spacer"></div>
           <? } else {?>
                    <div class="spacer"></div>
                    <div class="spacer"></div>
                    <? if ($TotalPrice != '') {
                                if ($ItemArray->ProductType == 'podmerch') {?> 
                                   <a href="<? echo $BuyLink;?>"><img src="/images/buynow.png" border="0"/></a>
                              
                                  <? } else {?>
                                        <a href="/store/start/?id=<? echo $ItemID;?>&type=<? echo $ProductType;?>"><img src="/images/buynow.png" border="0"/></a>
                                  <? }?>
                      <? } else { ?>
                       <a href="/store_download.php?id=<? echo $ItemID;?>"><img src="/images/download.png" border="0"/></a>
                      
                      <? }?>
            <? }?>
            </div>
		    </td>
	        </tr>
		</table>  
      <div style="height:10px;"></div>
     
      
  </div>
  </div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>

</body>
</html>

