<?php 
/* 
 * PayPal and database configuration 
 */ 
  
// PayPal configuration 
define('PAYPAL_ID', 'sb-9bvpe8701204@business.example.com'); 
define('PAYPAL_SANDBOX', TRUE); //TRUE or FALSE 
 
define('PAYPAL_RETURN_URL', 'http://34.126.181.163/orderSuccess.php'); 
define('PAYPAL_CANCEL_URL', 'http://34.126.181.163/payment_cancel.php'); 
define('PAYPAL_NOTIFY_URL', 'http://34.126.181.163/ipn.php'); 
define('PAYPAL_CURRENCY', 'SGD'); 
 
// Change not required 
define('PAYPAL_URL', (PAYPAL_SANDBOX == true)?"https://www.sandbox.paypal.com/cgi-bin/webscr":"https://www.paypal.com/cgi-bin/webscr");

