<?php
require_once 'config.php';

/*********************************************************
*                 CHECKOUT FUNCTIONS 
*********************************************************/
function saveOrder()
{
global $DigitalDelivery;
	$orderId       = 0;
	$shippingCost  = 0;
	if ($DigitalDelivery == 0) {
	$requiredField = array('hidShippingFirstName', 'hidShippingLastName', 'hidShippingAddress1', 'hidShippingCity', 'hidShippingPostalCode', 'hidShippingCost', 'hidTotalPrice');
			   
	if (checkRequiredPost($requiredField)) {
	    extract($_POST);
		
		// make sure the first character in the 
		// customer and city name are properly upper cased
		$hidShippingFirstName = ucwords($hidShippingFirstName);
		$hidShippingLastName  = ucwords($hidShippingLastName);
		$hidPaymentFirstName  = ucwords($hidPaymentFirstName);
		$hidPaymentLastName   = ucwords($hidPaymentLastName);
		$hidShippingCity      = ucwords($hidShippingCity);
		$hidPaymentCity       = ucwords($hidPaymentCity);
		$hidTotalPrice       = ucwords($hidTotalPrice);
		$shippingCost       = ucwords($hidShippingCost);
	}	
		$cartContent = getCartContent();
		$numItem     = count($cartContent);
		
		// save order & get order id
		$sql = "INSERT INTO tbl_order(od_date, od_last_update, od_shipping_first_name, od_shipping_last_name, od_shipping_address1, od_shipping_address2, od_shipping_phone, od_shipping_state, od_shipping_city, od_shipping_postal_code, od_shipping_email, od_shipping_cost, od_total_cost)
                VALUES (NOW(), NOW(), '$hidShippingFirstName', '$hidShippingLastName', '$hidShippingAddress1', 
				        '$hidShippingAddress2', '$hidShippingPhone', '$hidShippingState', '$hidShippingCity', '$hidShippingPostalCode', '$hidShippingEmail', '$shippingCost', '$hidTotalPrice')";
						
		$result = dbQuery($sql);
		//echo $sql
		// get the order id
		$orderId = dbInsertId();
		
		if ($orderId) {
			// save order items
			for ($i = 0; $i < $numItem; $i++) {
				for ($j = 0; $j < $cartContent[$i]['ct_qty']; $j++)
				{
					$sql = "INSERT INTO tbl_order_item(od_id, pd_id, od_qty, ct_coupon)
							VALUES ($orderId, {$cartContent[$i]['pd_id']}, {$cartContent[$i]['ct_qty']}, '{$cartContent[$i]['ct_coupon']}')";
							
					$result = dbQuery($sql);					
				}
			}
		
			$sql = "UPDATE tbl_order_item AS oi
					JOIN pf_store_items AS s ON s.id = oi.pd_id	
					SET oi.Complete = 1,
					oi.completedate=Now() 
					WHERE oi.od_id = $orderId";
			$result = dbQuery($sql);
			
			// update product stock
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "UPDATE tbl_product 
				        SET pd_qty = pd_qty - {$cartContent[$i]['ct_qty']}
						WHERE pd_id = {$cartContent[$i]['pd_id']}";
				$result = dbQuery($sql);					
			}
			
			
			// then remove the ordered items from cart
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "DELETE FROM tbl_cart
				        WHERE ct_id = {$cartContent[$i]['ct_id']}";
				$result = dbQuery($sql);					
			}							
		}					
	}
	
	return $orderId;
}

/*
	Get order total amount ( total purchase + shipping cost )
*/
function getOrderAmount($orderId)
{
	$orderAmount = 0;
	
	$sql = "SELECT od_total_cost
				FROM tbl_order
				WHERE od_id=$orderId";
				
	$result = dbQuery($sql);
	$orderAmount = 0;
	
	while ($row = dbFetchAssoc($result)) {
		$orderAmount = $row['od_total_cost'];
	}
	return $orderAmount;	
}

?>