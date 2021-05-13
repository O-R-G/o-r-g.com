<?php
    $to = 'test-imep75s9e@srv1.mail-tester.com';
    $subject = "tt";
    $message = "*\n\nThank you very much. Here's where to download your software:\n";
    // foreach ($downloadLink as $value) $message .= "\n" . $value;
    $message .= "\n\nEnjoy, tell your friends, and so forth.\n\n*\n\nhttp://www.o-r-g.com";
    $headers = "From: hello@wei-haowang.com" . "\r\n" . "Reply-To: hello@wei-haowang.com" . "\r\n" . "Cc: hello@wei-haowang.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();


    // 3. Send email
    try{
        mail($to, $subject, $message, $headers);
    }
    catch(Exception $e)
    {
         echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>
