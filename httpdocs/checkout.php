<? 
include_once("includes/init.php"); 
include_once('cart/cart-functions.php');
include_once('cart/common.php');
include_once 'cart/checkout-functions.php';
include_once('cart/usstates.php');
if ((!isset($_SESSION['orderId'])) && (isCartEmpty())) {
	// the shopping cart is still empty
	// so checkout is not allowed
	header('Location: store.php');
} else if (isset($_GET['step']) && (int)$_GET['step'] > 0 && (int)$_GET['step'] <= 3) {
	$step = (int)$_GET['step'];
	if ($step != 3) {
		$cartContent = getCartContent();
		$NumItems = sizeof($cartContent);
		$Count = 1;
		$Index = 0;
	
		$DB = new DB();
	//print_r($cartContent);
	if ($step != 2) {
		while($Count <= $NumItems) {
		$ProductID =  $cartContent[$Index]["pd_id"];
		$query = "SELECT ShippingOption from pf_store_items where ID='$ProductID'";
		$DigitalDelivery = $DB->queryUniqueValue($query);
		if ($DigitalDelivery == 0) {
			$step = 1;
			break;
		} else {
			$step = 2;
		}
		$Count++;
		$Index++;
		}
		}
		}
	$includeFile = '';
	//print 'STEP = ' . $step;
	if (($step == 1) && ($DigitalDelivery == 0)) {
		//$includeFile = 'cart/shippingAndPaymentInfo.php';
		$includeFile = 'cart/shippingInfo.php';
		$pageTitle   = 'Checkout - Step 1 of 2';
	} else if ($step == 2) {
		//$includeFile = 'cart/checkoutConfirmation.php';
		$includeFile = 'cart/checkoutConfirmation_sp.php';
		$pageTitle   = 'Checkout - Step 2 of 2';
	} else if ($step == 3) {
		if (!isset($_SESSION['orderId']))
		{
		   $cartContent = getCartContent();
		   $orderId  = saveOrder();
		   $orderAmount = getOrderAmount($orderId);
		   $_SESSION['orderId'] = $orderId;
		}	
		else
		{	//echo 'MY ORDER ID = ' . $orderId;
			$cartContent = getCartContent();
			$orderId = $_SESSION['orderId'];
			$orderAmount = getOrderAmount($orderId);
		}		
		
		include_once 'cart/receiptemail.php';
		header("location:paypal_start.php");
		// our next action depends on the payment method
		// if the payment method is COD then show the 
		// success page but when paypal is selected
		// send the order details to paypal
		//if ($_POST['hidPaymentMethod'] == 'cod') {
			//$includeFile = 'cart/authenticate/payment.php';	
		//} else {
			//$includeFile = 'cart/paypal/payment.php';	
		//}
	}
} else {
	// missing or invalid step number, just redirect
	header('Location: index.php');
}
?>
<?php include 'includes/header.php'; ?>
<script language="javascript" src="cart/common.js"></script>
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
      <script language="JavaScript" type="text/javascript" src="cart/checkout.js"></script>
		<? require_once "$includeFile"; ?>
  </div>
<div class="body_footer"></div>
</td>
 <td valign="top" class="rightside">
    
</td>
 	</tr>
  
</table>

</div>			
<?php include 'includes/footer.php'; ?>	