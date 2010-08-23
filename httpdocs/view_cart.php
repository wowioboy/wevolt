<? 
include_once("includes/init.php"); 
include_once('cart/cart-functions.php');
include_once('cart/common.php');

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';

switch ($action) {
	case 'add' :
		addToCart();
		break;
	case 'update' :
		updateCart();
		break;	
	case 'delete' :
		deleteFromCart();
		break;
	case 'view' :
		break;
}

$cartContent = getCartContent();
$numItem = count($cartContent);


?>
<?php include 'includes/header.php'; ?>
<script language="javascript" type="text/javascript" src="/js/validation.js"></script>
<div class="spacer"></div>	

<div class="bigwrapper" align="center">
<table width="<? echo $SiteWidth;?>" border="0" cellspacing="0" cellpadding="0">
   <tr>
  <td id="content" bgcolor="#FFFFFF" style="background-repeat:repeat-y;" width="283" background="images/left_background.jpg" valign="top" align="right">
	<div class='headerbackground'> <div style="float:right; padding-top:200px; padding-right:10px;" > 
		<? 
		include 'apps/menu_display.php';
		?></div>
</div><? //MENU TABLE?>
	</td>
    <td valign="top" style="background-color:#f4efe6;">
    <div class="body_header"></div>

    <div id="bodywrapper">
    <? if ($numItem > 0 ) { ?>
		<form action="<?php echo $_SERVER['PHP_SELF'] . "?action=update"; ?>" method="post" name="frmCart" id="frmCart">
		 <table width="553" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
		  <tr class="entryTableHeader"> 
		   <td align="center" class="cartheader">&nbsp;</td>
		   <td width="155" align="center" class="cartheader">Item</td>
		   <td width="56" align="center" class="cartheader">Price</td>
		   <td width="45" align="center" class="cartheader">Quantity</td>
		   <td width="60" align="center" class="cartheader">Total</td>
		  <td width="90" align="center" class="cartheader">Controls</td>
		 </tr>
		 <?php
		 $BgColor = '#e5e5e5;';
		 $RowCount = 0;
		$subTotal = 0;
		$ProductsArray = array();
		$_SESSION['addedproducts'] = '';
		for ($i = 0; $i < $numItem; $i++) {
			extract($cartContent[$i]);
			$ItemTotal = 0;
			$productUrl = "store.php?item=$pd_id";
			if (!in_array($pd_id,$ProductsArray)){
				$ProductsArray[] = $pd_id;
				if (sizeof($ProductsArray) == 1) {
					$_SESSION['addedproducts'] = $pd_id;
				} else {
					$_SESSION['addedproducts'] .= ','.$pd_id;
				}
				//echo 'SESSION ADDEDPRODUCTS = ' . $_SESSION['addedproducts'];
			}
			
			if ($ct_coupon != '')
			{
				$result = dbQuery("select * from coupon where coupon='$ct_coupon'");
				while ($row = dbFetchAssoc($result)) {
					$Price = $row[flat_value];
					$subTotal += $row[flat_value] * $ct_qty;
					$ItemTotal += $row[flat_value] * $ct_qty;
						
					if ($Quanity1 > 0)
					{
						$subTotal += $QuanityPrice1;
						$ItemTotal += $QuanityPrice1;
					}
					else
					{
						$subTotal += $Price;	
						$ItemTotal += $Price;	
					}
				}
			}
			else 
			{
				$subTotal += $Price * $ct_qty;	
				$ItemTotal += $Price * $ct_qty;		
				if ($ct_qty > 0)
				{
					$subTotal += $QuanityPrice1;
					$ItemTotal += $QuanityPrice1;
				}
				else
				{
					$subTotal += $Price;	
					$ItemTotal += $Price;	
					
					$QuanityPrice1 = $Price;
				}
			}
			
			
$db = new DB();
$db3 = new DB();
foreach ($ProductsArray as $Product) {
	$query = "SELECT * from pf_store_items where ID='$Product'";
	$ProductArray = $db->queryUniqueObject($query);
	$OtherProducts = explode(',',$ProductArray->OtherProducts);
	if ($ProductArray->OtherProducts == '') {
		$ShowOther = 0;
	} else {
		$ShowOther = 1;
	}
	$OtherCount = 1;
	$OtherString = "<table width='90%' border='0' cellspacing='0' cellpadding='0'><tr>";
	if ($ProductArray->OtherProducts != '') {
		foreach ($OtherProducts as $RelatedItem) {
			
			$query = "select * from pf_store_items where id='$RelatedItem'";
			$RelatedItemArray = $db3->queryUniqueObject($query);

			$RelatedTitle = $RelatedItemArray->ShortTitle;
			$query = "select ThumbMd from pf_store_images where ItemID='$RelatedItem' and IsMain=1";
			$RelatedThumb = $db3->queryUniqueValue($query);

			$OtherString .= "<td style='padding:3px;' valign='top'>$RelatedTitle<br/><a href='store.php?item=".$RelatedItemArray->ID."' ><img src='".$RelatedThumb."' style='border-color:#000000;'></a><br/>Price: ".$RelatedItemArray->Price."</td>";
			if ($Count == 4) {
				$OtherString .= "</tr><tr>";
				$OtherCount = 1;
			} else {
				$Count++;
			} 
	
		}
		$OtherString .=  "</tr></table>";
		$db3->close();
	} else {
		$OtherString =  "";
	}
}
		?>
		 <tr class="content"> 
		  <td width="80" align="center" style="background-color:<? echo $BgColor;?>" valign="top"><a href="<?php echo $productUrl; ?>"><img src="<?php echo $ThumbSm; ?>" border="0"></a></td>
		  <td style="background-color:<? echo $BgColor;?>" valign="top" class='carttext' ><a href="<?php echo $productUrl; ?>"><b><?php echo $ShortTitle; ?></b></a></td>
		   <td align="right" valign="top" class='carttext' style="background-color:<? echo $BgColor;?>"><?php echo displayAmount($Price); ?></td>
		   <td width="45" style="background-color:<? echo $BgColor;?>" valign="top" >
	<input name="txtQty[]" type="text" id="txtQty[]" style='width:25px;' value="<?php echo $ct_qty; ?>" class="box"  onkeypress="return numbersonly(event)" >
          
		  <input name="hidCartId[]" type="hidden" value="<?php echo $ct_id; ?>">
		  <input name="hidProductId[]" type="hidden" value="<?php echo $ProductCode; ?>">     	  </td>
		  <td align="right" style="background-color:<? echo $BgColor;?>" valign="top" class='carttext' ><?php echo displayAmount($ItemTotal); ?></td>
		  <td width="90" align="center" valign="top"> <input name="btnDelete" type="button" style='width: 50px;cursor:pointer;' id="btnDelete" value="delete" onClick="window.location.href='<?php echo "view_cart.php?action=delete&cid=$ct_id"; ?>';">		  
		
		 <?php
		 if ($RowCount == 0) {
		 	$BgColor='#d5e6fe';
			$RowCount = 1;
		 } else {
		 	$BgColor='#e5e5e5';
			$RowCount = 0;
		 }
		}
		?>
		 <tr class="content"> 
		  <td colspan="4" align="right" class='carttext' >Sub-total</td>
		  <td align="right"  bgcolor="#bfc6dc" class='carttext' ><?php echo displayAmount($subTotal); ?></td>
		  <td width="90" align="center">&nbsp;</td>
		 </tr>
		 <tr class="content"> 
		  <td colspan="5" align="right">&nbsp;</td>
		  <td width="90" align="center">
		<input name="btnUpdate" type="submit" id="btnUpdate" value="Update Cart" style='cursor:pointer;' ></td>
		 </tr>
		</table>
		</form>
		<?php
		} else {?>
        <p>&nbsp;</p>
        <table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
		 <tr>
		  <td><p align="center">You shopping cart is empty</p>
		   <p>If you find you are unable to add anything to your cart, please ensure that 
			your internet browser has cookies enabled and that any other security software 
			is not blocking your shopping session.</p></td>
		 </tr>
		</table>
		<? $shoppingReturnUrl = isset($_SESSION['shop_return_url']) ? $_SESSION['shop_return_url'] : 'index.php';
		}?>
        <table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
		 <tr align="center"> 
		  <td><input name="btnContinue" type="button"  id="btnContinue" value="&lt;&lt; Continue Shopping" onClick="window.location.href='/store.php';" class='cartbtn'></td>
		<?php 
		if ($numItem > 0) {
		?>  
		  <td><input name="btnCheckout" type="button"  id="btnCheckout" value="Proceed To Checkout &gt;&gt;" onClick="window.location.href='checkout.php?step=1';" class='cartbtn'></td>
		<?php
		}
		?>  
		 </tr>
		</table>
         <? if ($ShowOther == 1) {?><div class='relateditems' align="center" style="padding-left:10px;"><b>People who bought these items also bought:</b> <br/><? echo $OtherString;?></div><? }?>
  </div>
<div class="body_footer"></div>
</td>
 <td valign="top" class="rightside">
    
</td>
 	</tr>
  
</table>

</div>			
<?php include 'includes/footer.php'; ?>	