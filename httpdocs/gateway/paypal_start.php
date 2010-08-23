<? 
// Include the paypal library
include_once ('gateway/Paypal.php');
include_once ('includes/init.php');
include_once('cart/cart-functions.php');
include_once('cart/common.php');
include_once 'cart/checkout-functions.php';

$DB = new DB();
$query = 'SELECT * from pf_store';
$StoreArray = $DB->queryUniqueObject($query);
// Create an instance of the paypal library
$myPaypal = new Paypal();


$cartContent = getCartContent();
			$orderId     = saveOrder();
			$orderAmount = getOrderAmount($orderId);
			
			print_r($cartContent);
// Specify your paypal email
$myPaypal->addField('business', $StoreArray->PayPalEmail);

// Specify the currency
$myPaypal->addField('currency_code', 'USD');

// Specify the url where paypal will send the user on success/failure
$SERVER = $_SERVER['SERVER_NAME'];
$myPaypal->addField('return', 'http://'.$SERVER.'/gateway/paypal_success.php');
$myPaypal->addField('cancel_return', 'http://'.$SERVER.'/gateway/paypal_failure.php');

// Specify the url where paypal will send the IPN
$myPaypal->addField('notify_url', 'http://'.$SERVER.'/gateway/paypal_ipn.php');

// Specify the product information
$myPaypal->addField('item_name', 'COMIC PDF - STUPID USERS');
$myPaypal->addField('amount', '.05');
$myPaypal->addField('item_number', '001');

// Specify any custom value
$myPaypal->addField('custom', 'xydcxdfsdf45342363564345');

// Enable test mode if needed
//$myPaypal->enableTestMode();

// Let's start the train!
//$myPaypal->submitPayment();