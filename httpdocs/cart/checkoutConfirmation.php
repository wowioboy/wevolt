<?php
include_once('cart/cart-functions.php');
include_once('cart/usstates.php');

/*
Line 1 : Make sure this file is included instead of requested directly
Line 2 : Check if step is defined and the value is two
Line 3 : The POST request must come from this page but the value of step is one
*/
/*s
if (!defined('WEB_ROOT')
    || !isset($_GET['step']) || (int)$_GET['step'] != 2
	|| $_SERVER['HTTP_REFERER'] != 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?step=1') {
	exit;
}
*/
$errorMessage = '&nbsp;';

/*
 Make sure all the required field exist is $_POST and the value is not empty
 Note: txtShippingAddress2 and txtPaymentAddress2 are optional
*/
$requiredField = array('txtShippingFirstName', 'txtShippingLastName', 'txtShippingAddress1', 'txtShippingPhone', 'txtShippingState',  'txtShippingCity', 'txtShippingPostalCode', 'txtShippingEmail');
					   
if (!checkRequiredPost($requiredField)) {
	$errorMessage = 'Input not complete';
}
					   
if (!isset($_SESSION['orderId']))
{
	$cartContent = getCartContent();
}
else
{
	$cartContent = getCartContent($_SESSION['orderId']);
}
?>
<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
    <tr> 
        <td class='inputheader'><b>Step 2 Of 3 </b>: Confirm Order </td>
    </tr>
</table>

<? if ($errorMessage != '') {?><p id="errorMessage"><?php echo $errorMessage; ?></p><? }?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=3" method="post" name="frmCheckout" id="frmCheckout">
<?php 
if ($_POST['optPayment'] == 'paypal') {
?>
    <!-- <table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
        <tr> 
            <td align="center"><strong>:: IMPORTANT NOTE :: </strong></td>
        </tr>
       <tr> 
            <td><p>Before clicking the &quot;Confirm Order&quot; button open a 
                    new browser window and go to <a href="https://developer.paypal.com" target="_blank">https://developer.paypal.com</a> 
                    then login using this username and password :<br>
                    Email : armanpi@phpwebcommerce.com<br>
                    Password : phpwebco<br>
                    <br>
                    After you click on the &quot;Confirm Order&quot; button below 
                    you will be redirected to paypal website. On the paypal checkout 
                    page use these info to login and complete the checkout process 
                    :<br>
                    Email : testme@phpwebcommerce.com <br>
                    Password : phpwebco </p>
                <p>By the way, please don't change the password or delete the 
                    test email okay :-)</p></td>
        </tr>
    </table>-->
    <p>&nbsp;</p>
<?php
}
?>
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" class="infoTable">
        <tr class="infoTableHeader"> 
            <td colspan="3" style="font-size:14px;">Ordered Item</td>
        </tr>
        <tr class="label"> 
            <td class="cartheader">Item</td>
            <td align="right" class="cartheader">Coupon</td>
			<td align="right" class="cartheader">Unit Price</td>
            <td align="right" class="cartheader">Shipping Price</td>			
            <td align="right" class="cartheader">Total</td>
        </tr>
        <?php
$shippingState = $_POST['txtShippingState'];
$useIntShipping = false;
if (!in_array($shippingState, $stateList))
{
	$useIntShipping = true;
}
$BgColor = '#e5e5e5;';
$RowCount = 0;
$numItem  = count($cartContent);
$subTotal = 0;
$subtotalShipping = 0;

for ($i = 0; $i < $numItem; $i++) {
	extract($cartContent[$i]);
	$ItemTotal = 0;
	if ($useIntShipping)
		$ShippingRate = $IntShippingRate;
	if ($ct_coupon != '')
	{
		$result = dbQuery("select * from coupon where coupon='$ct_coupon'");
		while ($row = dbFetchAssoc($result)) {
			$Price = $row[flat_value];
			$subTotal += $row[flat_value] * $ct_qty;
			$ItemTotal += $row[flat_value] * $ct_qty;
				
			if (($Quanity1 > 0) && ($ct_numids >= $Quanity1))
			{
				$subTotal += $QuanityPrice1;
				$ItemTotal += $QuanityPrice1;
			}
			else
			{
				$subTotal += $Price;	
				$ItemTotal += $Price;	
			}
			if ( $row[free_shipping] != 'yes')
				$subtotalShipping += $ShippingRate * $ct_qty;

		}
	}
	else 
	{
		$subTotal += $Price * $ct_qty;	
		$ItemTotal += $Price * $ct_qty;		
		if ($ct_qty > 0)
		{
			$subTotal += $QuanityPrice1;
			$ItemTotal += $QuanityPrice1 ;
			$subtotalShipping += $ShippingRate * $ct_qty;
		}
		else
		{
			$subTotal += $Price;	
			$ItemTotal += $Price;	
			$subtotalShipping += $ShippingRate * $ct_qty;
			
			$QuanityPrice1 = $Price;
		}
	}		
	 if ($RowCount == 0) {
		 	$BgColor='#ffffff';
			$RowCount = 1;
		 } else {
		 	$BgColor='#e5e5e5';
			$RowCount = 0;
		 }
	//$subtotalShipping += $ShippingRate * $ct_qty;
?>
        <tr class="content"> 
            <td class="content" bgcolor="<? echo $BgColor;?>"><?php echo "$ct_qty x $ShortTitle"; ?></td>
            <td align="right" bgcolor="<? echo $BgColor;?>"><?php echo $ct_coupon; ?></td>
            <td align="right" bgcolor="<? echo $BgColor;?>"><?php echo displayAmount($Price); ?></td>
            <td align="right" bgcolor="<? echo $BgColor;?>"><?php echo displayAmount($ShippingRate); ?></td>
            <td align="right" bgcolor="<? echo $BgColor;?>"><?php echo displayAmount($ItemTotal + ($ct_qty * $ShippingRate)); ?></td>
        </tr>
        <?php
		if ($ct_numids > 0) { ?>
		<tr class="content"> 
            <td class="content" bgcolor="<? echo $BgColor;?>"><?php echo "$ct_numids x AdditionalIDs"; ?></td>
            <td align="right" bgcolor="<? echo $BgColor;?>"></td>
            <td align="right" bgcolor="<? echo $BgColor;?>"><?php echo displayAmount($QuanityPrice1); ?></td>
            <td align="right" bgcolor="<? echo $BgColor;?>"></td>
            <td align="right" bgcolor="<? echo $BgColor;?>"></td>
        </tr>
<?		}		
}
?>
        <tr class="content"> 
            <td colspan="3" align="right">Sub-total</td>
            <td align="right" bgcolor="#bfc6dc"><?php echo displayAmount($subTotal); ?></td>
        </tr>
        <tr class="content"> 
            <td colspan="3" align="right">Shipping</td>
            <td align="right" bgcolor="#bfc6dc"><?php echo displayAmount($subtotalShipping); ?></td>
        </tr>
        <tr class="content"> 
            <td colspan="3" align="right">Total</td>
            <td align="right" bgcolor="#bfc6dc"><?php echo displayAmount($subtotalShipping + $subTotal); ?></td>
        </tr>
		<input type="hidden" name="hidTotalPrice" value="<?php echo $subtotalShipping + $subTotal; ?>" />
		<input name="hidShippingCost" type="hidden" id="hidShippingCost" value="<?php echo $subtotalShipping; ?>">
    </table>
    <p>&nbsp;</p>
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" class="infoTable">
        <tr class="infoTableHeader"> 
            <td colspan="2" class="cartheader" style="font-size:14px;">Shipping Information</td>
        </tr>
        <tr> 
            <td width="150" class="label">First Name</td>
            <td class="content"><?php echo $_POST['txtShippingFirstName']; ?>
                <input name="hidShippingFirstName" type="hidden" id="hidShippingFirstName" value="<?php echo $_POST['txtShippingFirstName']; ?>"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Last Name</td>
            <td class="content"><?php echo $_POST['txtShippingLastName']; ?>
                <input name="hidShippingLastName" type="hidden" id="hidShippingLastName" value="<?php echo $_POST['txtShippingLastName']; ?>"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address1</td>
            <td class="content"><?php echo $_POST['txtShippingAddress1']; ?>
                <input name="hidShippingAddress1" type="hidden" id="hidShippingAddress1" value="<?php echo $_POST['txtShippingAddress1']; ?>"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address2</td>
            <td class="content"><?php echo $_POST['txtShippingAddress2']; ?>
                <input name="hidShippingAddress2" type="hidden" id="hidShippingAddress2" value="<?php echo $_POST['txtShippingAddress2']; ?>"></td>
        </tr>
        <tr> 
            <td width="150" class="label">City</td>
            <td class="content"><?php echo $_POST['txtShippingCity']; ?>
                <input name="hidShippingCity" type="hidden" id="hidShippingCity" value="<?php echo $_POST['txtShippingCity']; ?>" ></td>
        </tr>
		<tr> 
            <td width="150" class="label">Province / State</td>
            <td class="content"><?php echo $_POST['txtShippingState']; ?> <input name="hidShippingState" type="hidden" id="hidShippingState" value="<?php echo $_POST['txtShippingState']; ?>" ></td>
        </tr>
        <tr> 
            <td width="150" class="label">Postal Code</td>
            <td class="content"><?php echo $_POST['txtShippingPostalCode']; ?>
                <input name="hidShippingPostalCode" type="hidden" id="hidShippingPostalCode" value="<?php echo $_POST['txtShippingPostalCode']; ?>"></td>
        </tr>
		<tr> 
            <td width="150" class="label">Phone Number</td>
            <td class="content"><?php echo $_POST['txtShippingPhone'];  ?>
                <input name="hidShippingPhone" type="hidden" id="hidShippingPhone" value="<?php echo $_POST['txtShippingPhone']; ?>"></td>
        </tr>
		<tr> 
            <td width="150" class="label">Email Address</td>
            <td class="content"><?php echo $_POST['txtShippingEmail'];  ?>
                <input name="hidShippingEmail" type="hidden" id="hidShippingEmail" value="<?php echo $_POST['txtShippingEmail']; ?>"></td>
        </tr>
         <tr><td colspan='2'>
    <p align="center"> 
        <input name="btnBack" type="button" id="btnBack" value="&lt;&lt; Modify Shipping/Payment Info" onClick="javascript: document.frmCheckout.action = 'checkout.php?step=1'; document.frmCheckout.submit();" class="box">
        &nbsp;&nbsp; 
        <input name="btnConfirm" type="submit" id="btnConfirm" value="Confirm Order &gt;&gt;" class="box">
</td></tr>
    </table>
    </form>