<section id="subscribe"><?
    $subscribe = $_POST['subscribe'];
    $message = $_POST['message'];
    if (!$subscribe) {
        ?><br /><br /><br />Mailing list
        To subscribe or unsubscribe from our mailing list,<br />
        please enter your email address below.<br />
        <form enctype='multipart/form-data' action='contact' method='post'>
            <textarea name='message' cols='30' rows='2'></textarea><br />    
            <input name='subscribe' type='submit' value='Subscribe'>
        </form><?
    } else {
        $to = "open-reading-group-request@o-r-g.com";
        $subject = "subscribe";
        $body = "";
        $headers = "From: reinfurt@o-r-g.com";
        mail($to,$subject,$body,$headers);

        // function orgEmail($sender, $recipient, $subject, $message) 

        ?><br /><br /><br />Thanks.<?
    }
?></section><?
}
?>
