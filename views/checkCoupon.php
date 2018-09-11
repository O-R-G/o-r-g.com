<?
$config = $_SERVER["DOCUMENT_ROOT"];
$config = $config."/open-records-generator/config/config.php";
require_once($config);

// specific to this 'app'
$config_dir = $root."config/";
require_once($config_dir."url.php");
require_once($config_dir."request.php");

$db = db_connect("guest");

$oo = new Objects();
$mm = new Media();
$ww = new Wires();
$uu = new URL();

$id = $_GET['id'];
$type = $_GET['type'];
$code = $_GET['code'];

$fields = array("*");
$tables = array("objects");
$where 	= array("objects.url = '".$id."'");
$order 	= array("objects.rank", "objects.begin", "objects.end", "objects.name1");
$res = $oo->get_all($fields, $tables, $where, $order);

$obj = $res[0];
$codesRaw = $obj['notes'];
$codesLines = explode("\n", $codesRaw);

$output = array(
   "valid" => false
 );

foreach($codesLines as $codesLine) {
  if ($type == 'screensaver') {
    // Example: 2390-2391,free
    $codeMeta = explode(",", $codesLine);
    $codeRange = explode("-", $codeMeta[0]);

    // any match (not necessarily integer)
    if (sizeof($codeRange) == 1 && trim($codeRange[0]) == $code) {
      $output['valid'] = trim($codeMeta[1]);
    } else {
      // match if range (must be integer)
      if (intval($codeRange[0]) <= intval($code) && intval($code) <= intval($codeRange[1])) {
        $output['valid'] = trim($codeMeta[1]);
      }
    }

    if ($output['valid'] != false && sizeof($codeMeta) == 3) {
      $output['meta'] = trim($codeMeta[2]);
    }

  } else if ($type == 'ios-app') {
    $codes = explode(",", $codesLine);
    if (trim($codes[0]) == $code) {
      $output['valid'] = trim($codes[1]);
    }
  }
}

echo json_encode($output);
?>
