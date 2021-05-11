<?
    $to = 'test-bkz4hsuwv@srv1.mail-tester.com';
    $subject = "O-R-G small software purchase";
    $message = "*\n\nThank you very much. Here's where to download your software:\n";
    // foreach ($downloadLink as $value) $message .= "\n" . $value;
    $message .= "\n\nEnjoy, tell your friends, and so forth.\n\n*\n\nhttp://www.o-r-g.com";
    $headers = "From: store@o-r-g.com" . "\r\n" . "Reply-To: store@o-r-g.com" . "\r\n" . "Cc: store@o-r-g.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();


    // 3. Send email
    try{
        mail($to, $subject, $message, $headers);
    }
    catch($err)
    {
        var_dump($err);
    }
?>