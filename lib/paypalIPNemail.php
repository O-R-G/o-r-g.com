<?php

    // Paypal IPN emailer
    // O-R-G 01/07/2016

	// Always and only called by paypalIPNlisten
	// Builds download url from PayPal tx data
	// Sends email to buyer

	// ** to do **

	// email a link to o-r-g.com/thx?xxx-xxx
	// which then forces a download from out/xxx-xxx.dmg
	// the query could be encoded before sent or written into mail
	// with php hash() function and could be dehashed in views/download.php
	// in download.php, then could dehash, and then invoke a download
	// still with the actual filesource hidden based on this:
	// http://stackoverflow.com/questions/10997516/how-to-hide-the-actual-download-folder-location

	// simpler way to hide link might be just write the email as html
	// but even that is a little tedious in php and certainly not robust

        // Transaction values to match, as specified in paypal button & txn
        // These must be changed per transaction, staging, live etc.
        // $thisreceiver_email is set in paypalIPNlisten

        $thistxn_type = 'cart';
        $thispayment_status = 'Completed';

    	$debugString = '0.0 init emailer';


        // 0. Validate transaction details against request

        if (    ($txn_type == $thistxn_type) &&
                ($payment_status == $thispayment_status) &&
                ($receiver_email == $thisreceiver_email)) {

                // Pass
                if ($debug) $debugString .=     "\n 1.0 transaction details validated";

        } else {

                // Fail
                if ($debug) $debugString .=     "\n 1.0 transaction details failed";
        }


	// 1. Build download link

	$downloadBase = "http://www.o-r-g.com/out/";		// move this to the top?
	$downloadFileType = ".dmg";				//
	$downloadPage = "http://www.o-r-g.com/thx";

    	foreach ($item_name as $key => $value) {

                // generate hash

                $dbMainHost = "db153.pair.com";
                $dbMainUser = "reinfurt_42";
                $dbMainPass = "vNDEC89e";
                $dbMainDbse = "reinfurt_onrungo";
                $dbConnect = MYSQLI_CONNECT($dbMainHost, $dbMainUser, $dbMainPass, $dbMainDbse);
                $sql = "SELECT id, name1 FROM objects WHERE name1 LIKE '$value' LIMIT 1";
                $result = MYSQLI_QUERY($dbConnect, $sql);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                mysqli_close($dbConnect);
                $hash = md5($row['name1'] . $row['id']);
                $name = urlencode($row['name1']);

		$item_name_clean[$key] = cleanURL($value);

	        // if paypal item name includes "zip" then serve .zip
        	if (strpos($item_name_clean[$key], 'zip') !== false)
        		$downloadFileType = ".zip";

		// $downloadLink[$key] = $downloadBase . $item_name_clean[$key] . $downloadFileType;	// o-r-g.com/out/xxx
		// $downloadLink[$key] = $downloadPage . "?" . $item_name_clean[$key];			// o-r-g.com/thx?xxx
                $downloadLink[$key] = $downloadPage . "?name=" . $name .  "&key=" . $hash;		// o-r-g.com/thx?name=name&key=hash

		if ($debug) $debugString .= "\nkey = " . $key . " value = " . $value;
		if ($debug) $debugString .= "\ndownloadLink = " . $downloadLink[$key];
	}

	function cleanURL($string) {
		// $string = strtolower($string);				// l.c.
		// $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);	// a-z, 0-9
		$string = preg_replace("/[\s-]+/", " ", $string);		// rm * _
		$string = preg_replace("/[\s_]/", "-", $string);		// _ to -
		return $string;
	}


	// 2. Build email

	$to = ($debug ? $debug_email : $payer_email);
	$subject = "O-R-G small software purchase";
	$message = "*\n\nThank you very much. Here's where to download your software:\n";
	foreach ($downloadLink as $value) $message .= "\n" . $value;
	$message .= "\n\nEnjoy, tell your friends, and so forth.\n\n*\n\nhttp://www.o-r-g.com";
	$headers = "From: store@o-r-g.com" . "\r\n" . "Reply-To: store@o-r-g.com" . "\r\n" . "Cc: store@o-r-g.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();

	if ($debug) $debugString .=     "\n txn_type = " . $txn_type .
                                        "\n thistxn_type = " . $thistxn_type .
					"\n payment_status = " . $payment_status .
					"\n thispayment_status = " . $thispayment_status .
					"\n receiver_email = " . $receiver_email .
					"\n thisreceiver_email = " . $thisreceiver_email .
					"\n item_name1 = " . $item_name1 .
					"\n item_name1_clean = " . $item_name1_clean .
					"\n downloadLink = " . $downloadLink;

        if ($debug) mail($debug_email, 'debug email', $debugString);


	// 3. Send email

	mail($to, $subject, $message, $headers);
	exit("** Finished **");
?>
