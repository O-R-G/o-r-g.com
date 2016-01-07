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

	// ** todo ** 
	
	//  match item to existing item hard coded or just strip out spaces to match
	//  send link to download page (hashed?)

	// download
	//  readfile() or location header, TBD
	//  http://stackoverflow.com/questions/10997516/how-to-hide-the-actual-download-folder-location

	// 0001 Three Minutes of Doing Nothing
	// 0002 After His Beautiful Machine of 1855
	// 0003 Breaking Like Surf on a Shore Until
	// 0004 The Result of Collapsing Two Simultaneous Views
	// 0005 Al Gore Woke Up One Morning Wondering
	// 0006 Perhaps There is Something Left to Save
	// 0007 Six Prototypes for a Screensaver


	// settings
	
	$debug = TRUE;					// debug via email
	$IPNstatus = FALSE;				// IPN status via email
	$sandbox = TRUE;				// dev flag
	if ($sandbox) {

		// staging

		$IPNserver = "www.sandbox.paypal.com";	
		$debug_email = "store@o-r-g.com";		// local debug
	        $thisreceiver_email = "store-facilitator@o-r-g.com"; // paypal

	} else {

		// live

		$IPNserver = "www.paypal.com";
		$debug_email = "store@o-r-g.com";		// local debug
	        $thisreceiver_email = "store@o-r-g.com";// paypal
	}

	// Assign payment notification values to local variables
	// these are only a subset of possible values
	
	// to validate

  	$txn_type = $_POST['txn_type'];			// match in IPNwrite
	$item_name1 = $_POST['item_name1'];		// match in IPNwrite
  	$payment_status = $_POST['payment_status'];	// match in IPNwrite
	$payment_amount = $_POST['mc_gross'];		// match in IPNwrite
  	$payment_currency = $_POST['mc_currency'];	// match in IPNwrite
  	$receiver_email = $_POST['receiver_email'];	// match in IPNwrite

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

	if ($debug) $debugString = "0.0 init";

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

		if (!feof($fp)) {			// Prevent extra looping if slow $fp

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
	}
			
	if ($IPNstatus) {

		// Send an email announcing the IPN message is VERIFIED
      	
		$mail_From = "$debug_email";
		$mail_To = "$debug_email";
		$mail_Subject = "IPN";
		$mail_Body = $req;
		mail($mail_To, $mail_Subject, $mail_Body, $mail_From);
	}


	// $IPN mail 

	if ($debug) mail($debug_email, 'debug listen', $debugString, $debug_email);

	fclose ($fp);  // close file pointer


	// IPN protocol verification complete -- process action or die()
	
	if ( $IPNverified == TRUE ) {
		
		// require_once("paypalIPNwrite.php");  	// not working, so included below
		// require_once("paypalIPNemail.php");  	// not working, so included below
	} else {

		die("IPN failed. Exiting ... ");
	}


        // Paypal IPN emailer
        // O-R-G 01/07/2016

        // Transaction values to match, as specified in paypal button & txn
        // These must be changed per transaction, staging, live etc.

        $thistxn_type = 'cart';
        $thispayment_status = 'Completed';
	$debugString = '0.0 init emailer';

	
        // Validate transaction details against request
	// Cart automatically sends one IPN per item
 
        if (    ($txn_type == $thistxn_type) &&
                ($payment_status == $thispayment_status) &&
                ($receiver_email == $thisreceiver_email)) {

                // Pass

                if ($debug) $debugString .=     "\n 1.0 transaction details validated";
 
        } else {

                // Fail

                if ($debug) $debugString .=     "\n 1.0 transaction details failed";

        }


	// build download url

	$item_name1_clean = cleanURL($item_name1);

	function cleanURL($string) {
		// $string = strtolower($string);				// l.c.
		// $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);	// a-z, 0-9
		$string = preg_replace("/[\s-]+/", " ", $string);		// rm * _
		$string = preg_replace("/[\s_]/", "-", $string);		// _ to -
		return $string;
	}

	$downloadBase = "http://www.o-r-g.com/out/";
	$downloadFileType = ".dmg";
	$downloadLink = $downloadBase . $item_name1_clean . $downloadFileType;

	// loop thru cart to get multiple items !!
	// $item_name1, $item_name2, etc.

	// build buyer email 


	if ($debug) $debugString .=     "\n txn_type = " . $txn_type .
                                        "\n thistxn_type = " . $thistxn_type .
					"\n payment_status = " . $payment_status .
					"\n thispayment_status = " . $thispayment_status .
					"\n receiver_email = " . $receiver_email .
					"\n thisreceiver_email = " . $thisreceiver_email .
					"\n item_name1 = " . $item_name1 .
					"\n item_name1_clean = " . $item_name1_clean . 
					"\n downloadLink = " . $downloadLink;

        if ($debug) mail($debug_email, 'debug email', $debugString, $debug_email);
        

	// Email with download link to buyer
	
	// if ($debug) $payer_email = $debug_email;

	$to = ($debug ? $debug_email : $payer_email);
	$subject = "O-R-G / " . $item_name1;
	$message = 	"\n*
			\nThank you very much for your purchase of
			\n$item_name1
			\nPlease find a download link for your screensaver software here:
			\n$downloadLink
			\nEnjoy, tell your friends, and so forth.
			\n*
			\nhttp://www.o-r-g.com";
	$headers = 	"From: store@o-r-g.com" . "\r\n" .
    			"Reply-To: store@o-r-g.com" . "\r\n" .
			"X-Mailer: PHP/" . phpversion();

	mail($to, $subject, $message, $headers);


	// Done.

	exit("** Transaction complete. **");


	// ** to do **

	// loop thru cart to get multiple items !!

	// email a link to o-r-g.com/thx?xxx-xxx
	// which then forces a download from out/xxx-xxx.dmg
	// though with the actual filesource hidden 	
	// http://stackoverflow.com/questions/10997516/how-to-hide-the-actual-download-folder-location

?>
