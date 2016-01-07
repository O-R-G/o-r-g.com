<?php

	// Prepare link to email

	if ($debug) $debugString = "0.0 init";

	// Transaction values to match, as specified in paypal button & txn
	// These must be changed per transaction, staging, live etc.

// removed many of the transaction details and using just $item_name to generate link
// either automatically with - for spaces or else manually in an array TBD
// link in email may have diff url than real url
	
	$thistxn_type = "cart";
	$thispayment_status = "Completed";
	
	// Validate transaction details against subscription request

// need to loop for multiple items in the cart

	if (	($txn_type == $thistxn_type) && 
		($payment_status == $thispayment_status) && 
		($receiver_email == $thisreceiver_email)) {

		// Pass

		if ($debug) $debugString .= "\n 1.0 transaction details validated";
		if ($debug) $debugString .= "\n item_name1 = " . $item_name1;

	} else {
	
		// Fail

		if ($debug) $debugString .= 	"\n 1.0 transaction details failed
						\n $txn_type = " . $txn_type;
						\n $thistxn_type = " . $thistxn_type;
						\n $payment_status = " . $payment_status;
						\n $thispayment_status = " . $thispayment_status;
						\n $receiver_email = " . $receiver_email;
						\n $thisreceiver_email = " . $thisreceiver_email;
						";
	}

	// if ($debug) mail($IPNemail, 'debug email', $debugString, $IPNemail);
?>
