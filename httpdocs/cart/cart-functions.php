<?php

require_once 'database.php';

/*********************************************************
*                 SHOPPING CART FUNCTIONS 
*********************************************************/
 
function addToCart()
{
	$coupon = $_GET['coupon'];
	$productId = $_GET['item'];
	$result = '';
	if ($coupon != '')
	{
		$sql = "SELECT c.coupon_id FROM coupon as c 
				JOIN coupon_store_item as csi ON c.coupon_id =csi.coupon_id
				WHERE csi.storeitem_id = $productId and c.coupon='$coupon'";
		$result = dbQuery($sql);
		
	}
	
	if (($coupon=='') || (dbNumRows($result) != 0)) {
	
		$qty = $_GET['qty'];
		if ($qty == '')
			$qty = 1;
		$numids = $_GET['additionalids'];
		if ($numids == '')
			$numids = 0;
		// current session id
		$sid = session_id();
		
		// check if the product is already
		// in cart table for this session
		$sql = "SELECT pd_id
				FROM tbl_cart
				WHERE pd_id = $productId AND ct_session_id = '$sid'";
		//$sql = "SELECT count(*) as cnt,
				//(SELECT AdditionalIDs FROM pf_store_items where id=$productId)AS AdditionalIDs 
				//FROM tbl_cart
				//WHERE pd_id = $productId AND ct_session_id = '$sid'";
		$result = dbQuery($sql);
		$Found = dbNumRows($result);
	//	while ($row = dbFetchAssoc($result)) {
			//$rowcount = $row['cnt'];
			//$additionalids = $row['AdditionalIDs'];
		//}
		if ($rowcount == 0) {// || ($additionalids == 1)) {
			// put the product in cart table
			$sql = "INSERT INTO tbl_cart (pd_id, ct_qty, ct_session_id, ct_date, ct_coupon)
					VALUES ($productId, $qty, '$sid', NOW(), '$coupon')";
			$result = dbQuery($sql);
			$_SESSION['cartitems'] = $_SESSION['cartitems'] + 1;
		} else {
			// update product quantity in cart table
			$sql = "UPDATE tbl_cart 
					SET ct_qty = ct_qty + $qty ";
			if ($coupon != '')
					$sql .= ",ct_coupon='" . mysql_real_escape_string($coupon) . "' ";
			$sql .= "WHERE ct_session_id = '$sid' AND pd_id = $productId";		
			$result = dbQuery($sql);
			
		}
		
		
		// an extra job for us here is to remove abandoned carts.
		// right now the best option is to call this function here
//		deleteAbandonedCart();
		return true;
	}
	else
		return false;
}

/*
	Get all item in current session
	from shopping cart table
*/
function getCartContent($cartId = '')
{
	$cartContent = array();

	$sid = session_id();
	if ($cartId == '')
	{
		$sql = "SELECT ct_id, ct.pd_id, ct_qty, ct_coupon, pd.ShortTitle, pd.Price, pd.ShippingRate, pd.IntShippingRate, pd.Quanity1, pd.QuanityPrice1, si.ThumbSm, pd.ProductCode
				FROM tbl_cart ct, pf_store_items pd, pf_store_images si
				WHERE ct_session_id = '$sid' AND ct.pd_id = pd.id and pd.id=si.ItemId and si.IsMain=1";
		$result = dbQuery($sql);
	}
	else
	{
		$sql = "SELECT 0 AS ct_id, 0 AS pd_id, 1 AS ct_qty, ct_coupon, 0 AS ct_numids, pd.ShortTitle, pd.Price, pd.ShippingRate, pd.IntShippingRate, pd.Quanity1, pd.QuanityPrice1, si.ThumbSm, pd.ProductCode
				FROM tbl_order_item ct, pf_store_items pd, pf_store_images si
				WHERE ct.od_id = $cartId AND ct.pd_id = pd.id and pd.id=si.ItemId and si.IsMain=1";
		$result = dbQuery($sql);
	}	
	while ($row = dbFetchAssoc($result)) {
		if ($row['ThumbSm']) {
			$row['ThumbSm'] = $row['ThumbSm'];
		} else {
			$row['ThumbSm'] = 'images/no-image-small.png';
		}
		$cartContent[] = $row;
	}
	
	return $cartContent;
}

function getNumInCart($cartId = '')
{
	$num = 0;

	$sid = session_id();
	if ($cartId == '')
	{
		$sql = "SELECT count(*) As Cnt
				FROM tbl_cart ct, pf_store_items pd, pf_store_images si
				WHERE ct_session_id = '$sid' AND ct.pd_id = pd.id and pd.id=si.ItemId and si.IsMain=1";
		$result = dbQuery($sql);
		print $sql;
	}
	else
	{
		$sql = "SELECT count(*) As Cnt
				FROM tbl_order_item ct, pf_store_items pd, pf_store_images si
				WHERE ct.od_id = $cartId AND ct.pd_id = pd.id and pd.id=si.ItemId and si.IsMain=1";
		$result = dbQuery($sql);
		//print $sql;
	}	
	while ($row = dbFetchAssoc($result)) {
		$num = $row['Cnt'];
	}
	
	return $num;
}


/*
	Remove an item from the cart
*/
function deleteFromCart($cartId = 0, $view_cart = true)
{
	if (!$cartId && isset($_GET['cid']) && (int)$_GET['cid'] > 0) {
		$cartId = (int)$_GET['cid'];
	}

	if ($cartId) {	
		$sql  = "DELETE FROM tbl_cart
				 WHERE ct_id = $cartId";

		$result = dbQuery($sql);
		$_SESSION['cartitems'] = 0;
	}
	
	if($view_cart)
		header('Location: view_cart.php');	
}

/*
	Update item quantity in shopping cart
*/
function updateCart()
{
	$cartId     = $_POST['hidCartId'];
	$productId  = $_POST['hidProductId'];
	$itemQty    = $_POST['txtQty'];
	//$numIDs    = $_POST['txtNumIDs'];
	$numItem    = count($itemQty);
	$numDeleted = 0;
	$notice     = '';
	
	for ($i = 0; $i < $numItem; $i++) {
		$newQty = (int)$itemQty[$i];
		if ($newQty == '')
			$newQty = 0;
		//$newNumIds = (int)$numIDs[$i];
		//if ($newNumIds == '')
			//$newNumIds = 0;
		if ($newQty < 1) {
			// remove this item from shopping cart
			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		} else {
			// update product quantity
			$sql = "UPDATE tbl_cart
					SET ct_qty = $newQty

					WHERE ct_id = {$cartId[$i]}";
			dbQuery($sql);
			//print $sql;
		}
	}
	
}

function isCartEmpty()
{
	$isEmpty = false;
	
	$sid = session_id();
	$sql = "SELECT ct_id
			FROM tbl_cart ct
			WHERE ct_session_id = '$sid'";
	
	$result = dbQuery($sql);
	
	if (dbNumRows($result) == 0) {
		$isEmpty = true;
	}	
	
	return $isEmpty;
}

function numInCart()
{
	$isEmpty = false;
	
	$sid = session_id();
	$sql = "SELECT *
			FROM tbl_cart ct
			WHERE ct_session_id = '$sid'";
	
	$result = dbQuery($sql);
	
	return dbNumRows($result);
}

function isItemInCart($id)
{
	$inCart = false;
	
	$sid = session_id();
	$sql = "SELECT *
			FROM tbl_cart ct
			WHERE ct_session_id = '$sid' 
			AND pd_id=$id";
	
	$result = dbQuery($sql);
	
	if (dbNumRows($result) > 0)
		$inCart = true;
	
	return $inCart;
}

/*
	Delete all cart entries older than one day
*/
function deleteAbandonedCart()
{
	$yesterday = date('Y-m-d H:i:s', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	$sql = "DELETE FROM tbl_cart
	        WHERE ct_date < '$yesterday'";
	dbQuery($sql);		
}

function deleteCart()
{
	$sid = session_id();
	$sql = "DELETE FROM tbl_cart
	        WHERE ct_session_id = '$sid'";
	dbQuery($sql);		
}

?>