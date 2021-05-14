<?
/*
    PDT php example: 
    https://github.com/paypal/pdt-code-samples/blob/master/paypal_pdt.php
*/
$is_download_link = true;
$download_link_id = end($oo->urls_to_ids(array('shop', 'download-link')));
$download_link_item = $oo->get($download_link_id);

$bracket_pattern = '#\[(.*)\]#is';
preg_match_all($bracket_pattern, $download_link_item['deck'], $temp);
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

        $num_cart_items = intval($keyarray['num_cart_items']);
        for ($i = 1; $i <= $num_cart_items; $i++ ) {
            $item_name[$i] = $keyarray['item_name' . ($i)];
        }
        
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

            $item_name_encoded[$key] = urlencode($value);
            $item_name_clean[$key] = $item_name_encoded[$key];
            
            // if paypal item name includes "zip" then serve .zip
            if (strpos($item_name_clean[$key], 'zip') !== false)
                $downloadFileType = ".zip";
            $downloadLink[$key] = $downloadPage . "?name=" . $item_name_encoded[$key] .  "&key=" . $hash;   // o-r-g.com/thx?name=name&key=hash
        }

        ?>
        <div id="breadcrumbs">
            <ul class="nav-level">
                <li><a href="<? echo $host.$a_url; ?>">O-R-G</a></li>
            </ul>
        </div>
        <div class="column-container-container">
            <div class="column-container">
                Thank you very much. Here's where to download your software:<br>
                <?
                foreach($downloadLink as $key => $link){
                    ?>
                    <br><div><a href="<?= $link; ?>" target="_blank" ><?= $item_name_clean[$key]; ?></a></div>
                    <?
                }
                ?>
                <br><br>Enjoy, tell your friends, and so forth.
            </div>
        </div>
        <?
    }
    else if (strcmp ($lines[0], "FAIL") == 0) {
        // log for manual investigation
    }
}
?>