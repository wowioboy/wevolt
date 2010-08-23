<?
$email .= '<html><body>';
$email .= 'Dear ' . $_POST['hidShippingFirstName'] . ' ' . $_POST['hidShippingLastName'] . '<br /><br />'; 
$email .= 'Thank you for purchase, order has now been created.<br /><br />';  
$email .= 'You should retain this email for your records.<br /><br />';  
$email .= '<hr /><br />';
$email .= 'Your Order ID: ' . $orderId . "<br /><br />\r\n";  
$email .= '<table width="550" border="0" align="center" cellpadding="0" cellspacing="0">';  


$numItem  = count($cartContent);
$subTotal = 0;
$shippingState = $_POST['hidShippingState'];
$useIntShipping = false;
if (!in_array($shippingState, $stateList))
{
	$useIntShipping = true;
}
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
				$subTotal += $QuanityPrice1 * $ct_numids;
				$ItemTotal += $QuanityPrice1 * $ct_numids;
			}
			else
			{
				$subTotal += $Price * $ct_numids;	
				$ItemTotal += $Price * $ct_numids;	
			}
			if ( $row[free_shipping] != 'yes')
				$subtotalShipping += $ShippingRate * $ct_qty;
		}
	}
	else 
	{
		$subTotal += $Price * $ct_qty;	
		$ItemTotal += $Price * $ct_qty;		
		if (($Quanity1 > 0) && ($ct_numids >= $Quanity1))
		{
			$subTotal += $QuanityPrice1 * $ct_numids;
			$ItemTotal += $QuanityPrice1 * $ct_numids;
			$subtotalShipping += $ShippingRate * $ct_qty;
		}
		else
		{
			$subTotal += $Price * $ct_numids;	
			$ItemTotal += $Price * $ct_numids;	
			$subtotalShipping += $ShippingRate * $ct_qty;
			
			$QuanityPrice1 = $Price;
		}
	}

	$email .= '<tr class="content">'; 
	$email .= '<td class="content">' . $ct_qty . ' x ' . $ShortTitle . '</td>';
	$email .= '<td align="right">' . $ct_coupon . '</td>';
	$email .= '<td align="right">' . displayAmount($Price) . '</td>';
	$email .= '<td align="right">' . displayAmount($ShippingRate) . '</td>';
	$email .= '<td align="right">' . displayAmount($ItemTotal + ($ct_qty * $ShippingRate)) . '</td>';
	$email .= "</tr>\r\n";
	if (($AdditionalIDs == 1) && ($ct_numids > 0)) { 
		$email .= '<tr class="content">'; 
		$email .= '<td class="content">' . $ct_numids . ' x Additional IDs</td>';
		$email .= '<td align="right"></td>';
		$email .= '<td align="right">' . displayAmount($QuanityPrice1) . '</td>';
		$email .= '<td align="right"></td>';
		$email .= '<td align="right"></td>';
		$email .= "</tr>\r\n";
	}
}

$email .= '<tr class="content">'; 
$email .= '<td colspan="4" align="right">Sub-total</td>';
$email .= '<td align="right">' . displayAmount($subTotal) . '</td>';
$email .= '</tr>';
$email .= '<tr class="content">'; 
$email .= '<td colspan="4" align="right">Shipping</td>';
$email .= '<td align="right">' . displayAmount($subtotalShipping) . '</td>';
$email .= '</tr>';
$email .= '<tr class="content"> ';
$email .= '<td colspan="4" align="right">Total</td>';
$email .= '<td align="right">' . displayAmount($subtotalShipping + $subTotal) . '</td>';
$email .= '</tr>';
$email .= '</table>';

$email .= '<hr /><br />';
$email .= 'DELIVERY DETAILS<br />';
$email .= $_POST['hidShippingFirstName'] . ' ' . $_POST['hidShippingLastName'] . "<br />\r\n";
$email .= $_POST['hidShippingAddress1'] . "<br />\r\n";
$email .= $_POST['hidShippingAddress2'] . "<br />\r\n";
$email .= $_POST['hidShippingCity'] . "<br />\r\n";
$email .= $_POST['hidShippingState'] . "<br />\r\n";
$email .= $_POST['hidShippingPostalCode'] . "<br />\r\n";
$email .= '<hr /><br /><br />';  
$email .= '</body></html>';

?>