<section id="subscribe" class="visible"><?
    $subscribe = $_POST['subscribe'];
    $unsubscribe = $_POST['unsubscribe'];
    $address = $_POST['address'];
    if (!$subscribe && !$unsubscribe) {	
	?><p>To subscribe or unsubscribe from our mailing list, please enter your email address 
	below.</p>
	<form enctype='multipart/form-data' action='subscribe' method='post'>
            <textarea name='address' cols='30' rows='2'></textarea><br />    
            <input name='subscribe' type='submit' value='Subscribe'>
            <input name='unsubscribe' type='submit' value='Unsubscribe'>
        </form><?
    } else if (filter_var($address, FILTER_VALIDATE_EMAIL)) {
        $to = "open-reading-group-request@o-r-g.com";
        $subject = ($subscribe) ? "subscribe" : "unsubscribe";
        $body = "";
        $headers = "From: " . $address;
        mail($to,$subject,$body,$headers);
        ?><p>Thanks.</p><?
    } else {
        ?><p>Please <a href="">enter a valid email address.</a></p><?
    }
?></section>
