<?
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
?>

