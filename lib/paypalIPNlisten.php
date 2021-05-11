<?php

	// Paypal IPN listener
	// O-R-G 01/07/2016

	// dev / debug process

	// 0. set up sandbox.paypal.com user at developer.paypal.com
	// 1. set up buttons on sandbox.paypal.com 
	// 2. set up local stub dev page w/ paypal button link to sandbox
	// 3. turn on IPN notifications on sandbox.paypal.com, point 
	// 4. click btn to "purchase" an item, use dev@o-r-g.com as ibuyer
	// 5. dev, debug, repeat


	// settings
	
	$debug = TRUE;					// debug via email
	$IPNstatus = TRUE;				// IPN status via email
	$sandbox = TRUE;				// dev flag
	// $debug_email = "store@o-r-g.com";		// local debug
	// $IPNstatus_email = "store@o-r-g.com";		// local confirm
	$debug_email = "weiwanghasbeenused@gmail.com";		// local debug
	$IPNstatus_email = "weiwanghasbeenused@gmail.com";		// local confirm

	if ($sandbox) {

		// staging

		// $IPNserver = "www.sandbox.paypal.com";
		$IPNserver = "ipnpb.sandbox.paypal.com";
	        // $thisreceiver_email = "store-facilitator@o-r-g.com"; // paypal
	        $thisreceiver_email = "weiwanghasbeenused@gmail.com"; // paypal

	} else {

		// live

		$debug = FALSE;					
		$IPNserver = "www.paypal.com";
	        $thisreceiver_email = "store@o-r-g.com";	// paypal
	}

	// Assign payment notification values to local variables
	// these are only a subset of possible values
	
	// to validate

  	$txn_type = $_POST['txn_type'];			// match in IPNwrite
  	$payment_status = $_POST['payment_status'];	// match in IPNwrite
	$payment_amount = $_POST['mc_gross'];		// match in IPNwrite
  	$payment_currency = $_POST['mc_currency'];	// match in IPNwrite
  	$receiver_email = $_POST['receiver_email'];	// match in IPNwrite
	$item_name1 = $_POST['item_name1'];		// match in IPNwrite

	// to harvest
 
	$first_name = $_POST['first_name'];		// -> name1
	$last_name = $_POST['last_name'];		// -> name2
	$address_street = $_POST['address_street'];	// -> address1
	$address_city = $_POST['address_city'];		// -> city
	$address_state = $_POST['address_state'];	// -> state
	$address_zip = $_POST['address_zip'];		// -> zip
	$address_country = $_POST['address_country'];	// -> country
	$contact_phone = $_POST['contact_phone'];	// -> phone
	$payer_email = $_POST['payer_email'];		// -> email
	$payment_date = $_POST['payment_date'];		// -> date
  	$txn_id = $_POST['txn_id'];			// -> notes
	$memo = $_POST['memo'];				// -> body

	// for multiple items

	$num_cart_items = intval($_POST['num_cart_items']);
	for ($i = 1; $i <= $num_cart_items; $i++ ) {

		$item_name[$i] = $_POST['item_name' . $i];
		if ($debug) $debugString .= "item_name" . $i . " = " . $item_name[$i] . "\n";
	}

	if ($debug) $debugString .= "0.0 init";

	// Read the notification from PayPal and create the acknowledgement response  

	$req = 'cmd=_notify-validate'; // add 'cmd' to beginning of the acknowledgement you send back to PayPal

	// Loop through the notification NV pairs

	foreach ($_POST as $key => $value) { 

		$value = urlencode(stripslashes($value));  // Encode the values
		$req .= "&$key=$value";                    // Add the NV pairs to the acknowledgement  
	}

	if ($debug) $debugString .= "\n1.0 $txn_type, $item_name1, $payment_status, $payment_amount, $payment_currency, $receiver_email : $first_name, $last_name, $address_street, $address_city, $address_state, $address_zip, $address_country, $payer_email, $payment_date, $txn_id, $memo";
	
	// Set up the acknowledgement request headers
	// Requires HTTP 1.1 header format
	// see http://stackoverflow.com/questions/11810344/paypal-ipn-bad-request-400-error

	$header  = "POST /cgi-bin/webscr HTTP/1.1\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Host: $IPNserver\r\n";  // www.paypal.com for a live site
	$header .= "Content-Length: " . strlen($req) . "\r\n";
	$header .= "Connection: close\r\n\r\n";

	// Open a socket for the acknowledgement request

  	$fp = fsockopen("ssl://$IPNserver", 443, $errno, $errstr, 30);
  	
	// Post request back to PayPal for validation

  	fputs ($fp, $header . $req);

	if ($debug) $debugString .= "\n2.0 $fp $errstr($errno)";
	if ($debug) $debugString .= "\n\n" . $header . $req;

 	while (!feof($fp)) {                     	// While not EOF

		$res = fgets ($fp, 1024);              	// Get the acknowledgement response

		if ($debug) if ($res) $debugString .= "\n 3.0 $res";
    
		if (stripos($res, "VERIFIED") !== false) { 	// Response is VERIFIED

			if ($debug) $debugString .= "\n 3.1 IPN VERIFIED";
				
			// Notification protocol is complete, OK to process notification contents

			$IPNverified = TRUE;
		}	
		else if (stripos($res, "INVALID") !== false) {		// Response is INVALID

			if ($debug) $debugString .= '3.1 IPN INVALID';

			// Notification protocol is NOT complete, begin error handling

			$IPNverified = FALSE;
		}
	}
			
	if ($IPNstatus) {

		// Send an email announcing the IPN message is VERIFIED or NOT
      	
	        $to = "$IPNstatus_email";
        	$subject = "IPN $IPNverified";
	        $message = $req;
        	$headers = "From: store@o-r-g.com" . "\r\n" . "Reply-To: store@o-r-g.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();

		mail($to, $subject, $message, $headers);
	}

	if ($debug) mail($debug_email, 'debug listen', $debugString);
	echo $debugString;

	fclose ($fp);  // close file pointer


	// IPN protocol verification complete -- process action or die()
	
	if ( $IPNverified == TRUE ) {

		// require_once("paypalIPNwrite.php");  	
		require_once("paypalIPNemail.php");  	
	} else {

		die("IPN failed. Exiting ... ");
	}
?>
