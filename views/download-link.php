<?
/*
    PDT php example: 
    https://github.com/paypal/pdt-code-samples/blob/master/paypal_pdt.php
*/


$paypal_id = end($oo->urls_to_ids(array('shop', 'paypal')));
$paypal_items = $oo->get($paypal_id);
$bracket_pattern = '#\[(.*)\]#is';
preg_match_all($bracket_pattern, $paypal_items['deck'], $temp);
$auth_token = $temp[1][0];

// $pp_hostname = "www.paypal.com";
$pp_hostname = "www.sandbox.paypal.com";
$req = 'cmd=_notify-synch';
$tx_token = $_GET['tx'];
$req .= "&tx=$tx_token&at=$auth_token";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
//set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
//if your server does not bundled with default verisign certificates.
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
$res = curl_exec($ch);
curl_close($ch);

if(!$res){
    //HTTP ERROR
}else{
     // parse the data
    $lines = explode("\n", trim($res));
    $keyarray = array();
    if (strcmp ($lines[0], "SUCCESS") == 0) {
        for ($i = 1; $i < count($lines); $i++) {
            $temp = explode("=", $lines[$i],2);
            $keyarray[urldecode($temp[0])] = urldecode($temp[1]);
        }
    var_dump($keyarray);
    // check the payment_status is Completed
    // check that txn_id has not been previously processed
    // check that receiver_email is your Primary PayPal email
    // check that payment_amount/payment_currency are correct
    // process payment
    // $firstname = $keyarray['first_name'];
    // $lastname = $keyarray['last_name'];
    // $itemname = $keyarray['item_name'];
    // $amount = $keyarray['payment_gross'];
     
    // echo ("<p><h3>Thank you for your purchase!</h3></p>");
     
    // echo ("<b>Payment Details</b><br>\n");
    // echo ("<li>Name: $firstname $lastname</li>\n");
    // echo ("<li>Item: $itemname</li>\n");
    // echo ("<li>Amount: $amount</li>\n");
    // echo ("");
    }
    else if (strcmp ($lines[0], "FAIL") == 0) {
        // log for manual investigation
    }
}

/*
var_dump($_POST);
$num_cart_items = intval($_POST['num_cart_items']);
for ($i = 1; $i <= $num_cart_items; $i++ ) {
	$item_name[$i] = $_POST['item_name' . $i];
}

// 1. Build download link

$downloadBase = "http://www.o-r-g.com/out/";
$downloadFileType = ".dmg";             
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

    // $name = urlencode($row['name1']);
    // $item_name_clean[$key] = cleanURL($value);
    $item_name_encoded[$key] = urlencode($value);
    $item_name_clean[$key] = $item_name_encoded[$key];
    
    // if paypal item name includes "zip" then serve .zip
    if (strpos($item_name_clean[$key], 'zip') !== false)
        $downloadFileType = ".zip";

    // $downloadLink[$key] = $downloadBase . $item_name_clean[$key] . $downloadFileType;    // o-r-g.com/out/xxx
    // $downloadLink[$key] = $downloadPage . "?" . $item_name_clean[$key];          // o-r-g.com/thx?xxx
    $downloadLink[$key] = $downloadPage . "?name=" . $item_name_encoded[$key] .  "&key=" . $hash;   // o-r-g.com/thx?name=name&key=hash

    if ($debug) $debugString .= "\nkey = " . $key . " value = " . $value;
    if ($debug) $debugString .= "\ndownloadLink = " . $downloadLink[$key];
}

foreach($downloadLink as $key => $link){
    ?>
    <div><a href="<?= $link; ?>"><?= $item_name_clean[$key]; ?></a></div>
    <?
}
*/
?>

