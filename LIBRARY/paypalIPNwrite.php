<?php

	// Paypal IPN writer
	// O-R-G 6/18/2013

	// This is always and only invoked by paypalIPNlisten.php

	if ($debug) $debugString = "0.0 init";

	// Transaction values to match, as specified in paypal button & txn
	// These must be changed per transaction, staging, live etc.
	
	$thistxn_type = "web_accept";
	$thispayment_status = "Completed";
	$thisitem_name_1 = "BULLETINS 2-Year Subscription (USA)";
	$thisitem_name_2 = "BULLETINS 2-Year Subscription (ELSEWHERE)";
	$thisitem_name_3 = "BULLETINS 12-Year Subscription (USA)";
	$thisitem_name_4 = "BULLETINS 12-Year Subscription (ELSEWHERE)";
	$thispayment_amount_1 = "80.00";
	$thispayment_amount_2 = "120.00";
	$thispayment_amount_3 = "480.00";
	$thispayment_amount_4 = "720.00";
	$thispayment_currency = "USD";

	// Validate transaction details against subscription request

	if (	($txn_type == $thistxn_type) && 
		($payment_status == $thispayment_status) && 
		((($payment_amount == $thispayment_amount_1) &&
		($item_name == $thisitem_name_1)) || 
		(($payment_amount == $thispayment_amount_2) &&
		($item_name == $thisitem_name_2)) || 
		(($payment_amount == $thispayment_amount_3) &&
		($item_name == $thisitem_name_3)) || 
		(($payment_amount == $thispayment_amount_4) &&
		($item_name == $thisitem_name_4))) && 	 
		($payment_currency == $thispayment_currency) && 
		($receiver_email == $thisreceiver_email)) {

		// Pass

		if ($debug) $debugString .= "\n 1.0 transaction details validated";

		// Connect to Subscriptions database

		$dbMainHost = "db147b.pair.com";
		$dbMainUser = "reinfurt_36";
		$dbMainPass = "ThqHWXRy";
		$dbMainDbse = "reinfurt_servinglibrarysubscriptions";
		$dbConnect = MYSQL_CONNECT($dbMainHost, $dbMainUser, $dbMainPass);
		MYSQL_SELECT_DB($dbMainDbse, $dbConnect);

		// Check that txn_id has not been previously processed      
		// if duplicate, then exit()

		$sql = "SELECT id, notes FROM objects WHERE notes=$txn_id";
		$result = MYSQL_QUERY($sql);

		if ($result) {

			if ($debug) $debugString .= "\n 1.1 txn_id $txn_id already exists -- exiting";
			if ($debug) mail($IPNemail, 'debug write', $debugString, $IPNemail);
			exit("This txn_id already exists");
		}
	
		// Pre-process variables 
			
		$payment_date = ($payment_date) ? date("Y-m-d H:i:s", strtotime($payment_date)) : NULL;

		if (($item_name == $thisitem_name_1) || ($item_name == $thisitem_name_2)) {

			$dateIncrement = "+2 years";	// 2-year subscription

		} else if (($item_name == $thisitem_name_3) || ($item_name == $thisitem_name_4)) {
		
			$dateIncrement = "+12 years";	// 12-year subscription
		}

		$dateStub = strtotime($payment_date);		
		$end = date("Y-m-d H:i:s", strtotime($dateIncrement, $dateStub));

		if ($debug) $debugString .= "\n 3.6 dateStub = " . $dateStub;
		if ($debug) $debugString .= "\n 3.6 end = " . $end;
	
		if (!get_magic_quotes_gpc()) {

			$first_name = addslashes($first_name);
			$last_name = addslashes($last_name);
			$address_street = addslashes($address_street);
			$address_city = addslashes($address_city);
			$address_state = addslashes($address_state);
			$address_zip = addslashes($address_zip);
			$address_country = addslashes($address_country);
			$contact_phone = addslashes($contact_phone);
			$payer_email = addslashes($payer_email);
			$payment_date = addslashes($payment_date);
			$txn_id = addslashes($txn_id);
			$memo = addslashes($memo);
		}

		$created = date("Y-m-d H:i:s");
		$modified = NULL;
		$begin = $payment_date;

		//  Add to database

		// $first_name 		-> name1
		// $last_name		-> name2
		// $address_street 	-> address1
		// $address_city 	-> city
		// $address_state 	-> state
		// $address_zip 	-> zip
		// $address_country -> country
		// $contact_phone 	-> phone
		// $payer_email 	-> email
		// $payment_date 	-> date
		// $txn_id 			-> notes
		// $memo			-> body
		// $created			--> created
		// $modified		--> modified
		// $begin			--> begin
		// $end				--> end
	
		// objects 
	
		$sql = "INSERT INTO objects (created, modified, name1, name2, address1, city, state, zip, country, phone, email, date, begin, end, body, notes) VALUES ('$created', '$modified', '$first_name', '$last_name', '$address_street', '$address_city', '$address_state', '$address_zip', '$address_country', '$contact_phone', '$payer_email', '$payment_date', '$begin', '$end', '$memo', '$txn_id')";
		$result = MYSQL_QUERY($sql);
		$insertId = MYSQL_INSERT_ID();

		if ($debug) $debugString .= "\n 3.4 query = $sql";
		if ($debug) $debugString .= "\n 3.5 result = $result";
		if ($debug) $debugString .= "\n 3.6 insertId = $insertId";

		// wires
		// from _Subscribers record, fromid=1
	
		$sql = "INSERT INTO wires (created, modified, fromid, toid) VALUES ('$created', '$modified', (SELECT id FROM objects WHERE name1 LIKE 'Subscribers'), '$insertId')";

		$result = MYSQL_QUERY($sql);

		if ($debug) $debugString .= "\n 3.7 query2 = " . $sql;

	} else {
	
		// Fail

		if ($debug) $debugString .= "\n 1.0 transaction details failed";
	}

	if ($debug) mail($IPNemail, 'debug write', $debugString, $IPNemail);
?>
